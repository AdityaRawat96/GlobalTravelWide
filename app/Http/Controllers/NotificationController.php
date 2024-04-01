<?php

namespace App\Http\Controllers;

use App\Exports\NotificationsExport;
use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Attachment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Notification::class);
        // Check if the request is ajax
        if ($request->ajax()) {
            // Write your logic to get the data from database using the request object values

            // Get the values from the request object
            $start = $request->start;
            $length = $request->length;
            $search = $request->search;
            $order = $request->order;
            $columns = $request->columns;

            // Build an eloquent query using these values
            $query = Notification::select(
                'id',
                DB::raw("DATE_FORMAT(date, '%d-%m-%Y') as date"),
                'title',
            );

            // only if the filter is not empty and exists filter the records
            if (!empty($request->filter) && isset($request->filter)) {
                foreach ($request->filter as $filter) {
                    if ($filter['type'] == 'text') {
                        $query->where($filter['name'], $filter['comparator'], $filter['value']);
                    } else if ($filter['type'] == 'date') {
                        $query->whereDate($filter['name'], $filter['comparator'], $filter['value']);
                    }
                }
            }

            // Add the search query trim the search value and check if it is not empty
            if (!empty($search['value'])) {
                $query->where(function ($query) use ($columns, $search) {
                    $query->where('customers.name', 'like', '%' . $search['value'] . '%');
                    foreach ($columns as $column) {
                        if ($column['searchable'] == 'true' && $column['data'] != 'customer_name') {
                            $query->orWhere($column['data'], 'like', '%' . $search['value'] . '%');
                        }
                    }
                });
            }

            // Add the order by clause if the column is orderable
            if (!empty($order)) {
                $column = $columns[$order[0]['column']]['data'];
                $dir = $order[0]['dir'];
                if ($columns[$order[0]['column']]['orderable'] == 'true') {
                    $query->orderBy($column, $dir);
                }
            }

            // get count of the records from query
            $recordsFiltered = $query->count();

            // Get the data
            $query->offset($start)
                ->limit($length);

            $data_filtered = $query->get();

            $datatable = DataTables::of($data_filtered)
                ->setOffset($start)
                ->with('recordsTotal', Notification::count())
                ->with('sqlQuery', $query->get())
                ->with('recordsFiltered', $recordsFiltered)
                ->make(true);
            return $datatable;
        }
        return view('notification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Notification::class);
        // return the view for creating a new notification
        $customers = Customer::select('id', 'name')->get();
        return view('notification.create')->with(['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        $this->authorize('create', Notification::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $validated['user_id'] = auth()->user()->id;
            // Store the notification in the database
            $notification = Notification::create($validated);

            // Store notification attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                foreach ($files as $file) {
                    $attachment['type'] = 'notification';
                    $attachment['ref_id'] = $notification->id;
                    $attachment['name'] = $file->getClientOriginalName();
                    $attachment['extension'] = $file->getClientOriginalExtension();
                    $attachment['mime_type'] = $file->getClientMimeType();
                    $attachment['size'] = $file->getSize();
                    $attachment['url'] = $file->store('notifications', 'public');
                    Attachment::create($attachment);
                }
            }
            DB::commit();
            // Return the notification

            return response()->json([
                'notification' => $notification,
                'message' => 'Notification - ' . str_pad($notification->id, 5, '0', STR_PAD_LEFT) . ' created successfully!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Notification $notification)
    {
        $this->authorize('view', $notification, Notification::class);
        $notification_attachments = Attachment::where('type', 'notification')->where('ref_id', $notification->id)->get();
        // return the view for showing the notification
        return view('notification.show', compact('notification'))->with(['notification_attachments' => $notification_attachments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        $this->authorize('view', $notification, Notification::class);
        // return the view for editing the notification
        $notification_attachments = Attachment::where('type', 'notification')->where('ref_id', $notification->id)->get();
        return view('notification.create', compact('notification'))->with(['notification_attachments' => $notification_attachments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $this->authorize('update', $notification, Notification::class);
        // Get the validated data from the request
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            // Update the notification in the database
            $notification->update($validated);
            $existing_files = Attachment::where('type', 'notification')->where('ref_id', $notification->id)->get();

            // Store notification attacahments
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                // check file by name. if file exists, do not reupload and create an attachment, if the file is not in the request but in db delete the file and attachment
                foreach ($files as $file) {
                    $existing_file = $existing_files->where('name', $file->getClientOriginalName())->first();
                    if (!$existing_file) {
                        $attachment['type'] = 'notification';
                        $attachment['ref_id'] = $notification->id;
                        $attachment['name'] = $file->getClientOriginalName();
                        $attachment['extension'] = $file->getClientOriginalExtension();
                        $attachment['mime_type'] = $file->getClientMimeType();
                        $attachment['size'] = $file->getSize();
                        $attachment['url'] = $file->store('notifications', 'public');
                        Attachment::create($attachment);
                    }
                }

                // Delete the files that are not in the request
                foreach ($existing_files as $existing_file) {
                    $file_exists = false;
                    foreach ($files as $file) {
                        if ($existing_file->name == $file->getClientOriginalName()) {
                            $file_exists = true;
                            break;
                        }
                    }
                    if (!$file_exists) {
                        Storage::disk('public')->delete($existing_file->url);
                        $existing_file->delete();
                    }
                }
            } else {
                // Delete all the files if no file is in the request
                foreach ($existing_files as $existing_file) {
                    Storage::disk('public')->delete($existing_file->url);
                    $existing_file->delete();
                }
            }
            DB::commit();
            return response()->json(['message' => 'Notification - ' . str_pad($notification->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification, Notification::class);
        try {
            DB::beginTransaction();
            // Delete the notification attachments
            $attachments = Attachment::where('type', 'notification')->where('ref_id', $notification->id)->get();
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->url);
                $attachment->delete();
            }
            $notification->delete();
            DB::commit();
            return response()->json(['message' => 'Notification - ' . str_pad($notification->id, 5, '0', STR_PAD_LEFT) . ' deleted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Export the notifications to excel
    public function export($type = 'excel')
    {
        if ($type == 'excel') {
            // return the excel file 
            return Excel::download(new NotificationsExport, 'notifications_' . time() . '.xlsx');
        } else if ($type == 'csv') {
            // return the csv file
            return Excel::download(new NotificationsExport, 'notifications_' . time() . '.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } else if ($type == 'pdf') {
            // return the pdf file
            return Excel::download(new NotificationsExport, 'notifications_' . time() . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
        }
    }
}
