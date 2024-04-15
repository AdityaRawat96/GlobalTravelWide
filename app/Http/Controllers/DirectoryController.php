<?php

namespace App\Http\Controllers;

use App\Models\Directory;
use App\Http\Requests\StoreDirectoryRequest;
use App\Http\Requests\UpdateDirectoryRequest;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if the request is ajax
        if ($request->ajax()) {
            $parent_id = $request->input('directory_id') ?? null;
            $directories = Directory::where('parent_id', $parent_id)->get();
            $files = Attachment::where('type', 'directory')->where('ref_id', $parent_id ?? 0)->get();
            // Format size
            foreach ($files as $file) {
                $file->size = $this->formatBytes($file->size);
                $file->url = Storage::disk('public')->url($file->url);
            }
            return response()->json([
                'parent_id' => $parent_id,
                'directories' => $directories,
                'files' => $files
            ]);
        }
        $directories_count = Directory::count();
        $attachments_count = Attachment::where('type', 'directory')->count();
        $attachments_size = Attachment::where('type', 'directory')->sum('size');
        // format the size
        $attachments_size = $this->formatBytes($attachments_size);
        return view('directory.index')->with([
            'items_count' => $attachments_count + $directories_count,
            'items_size' => $attachments_size
        ]);
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDirectoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectoryRequest $request)
    {
        $this->authorize('create', Directory::class);
        // Get the validated data from the request
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        try {
            DB::beginTransaction();
            // Create a new directory
            $directory = Directory::create($validated);
            DB::commit();
            // Return the directory
            return response()->json([
                'directory' => $directory,
                'message' => 'Directory - ' . $directory->name . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Http\Response
     */
    public function show(Directory $directory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Http\Response
     */
    public function edit(Directory $directory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDirectoryRequest  $request
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectoryRequest $request, Directory $directory)
    {
        $this->authorize('update', $directory);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the directory
            $directory->update($validated);
            DB::commit();
            // Return the directory
            return response()->json([
                'directory' => $directory,
                'message' => 'Directory - ' . $directory->name . ' updated successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directory $directory)
    {
        $this->authorize('delete', $directory);
        // Delete the directory if it has no children
        $children = Directory::where('parent_id', $directory->id)->count();
        $attachments = Attachment::where('type', 'directory')->where('ref_id', $directory->id)->get();
        if ($children > 0) {
            return response()->json(['error' => 'Directory has children!'], 500);
        } else {
            try {
                DB::beginTransaction();

                // Remove all the storage files and attachments
                foreach ($attachments as $attachment) {
                    Storage::disk('public')->delete($attachment->url);
                    $attachment->delete();
                }

                $directory->delete();
                DB::commit();
                return response()->json(['message' => 'Directory - ' . $directory->name . ' deleted successfully!']);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}
