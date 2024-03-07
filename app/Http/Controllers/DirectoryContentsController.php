<?php

namespace App\Http\Controllers;

use App\Models\DirectoryContents;
use App\Http\Requests\StoreDirectoryContentsRequest;
use App\Http\Requests\UpdateDirectoryContentsRequest;

class DirectoryContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDirectoryContentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectoryContentsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectoryContents  $directoryContents
     * @return \Illuminate\Http\Response
     */
    public function show(DirectoryContents $directoryContents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectoryContents  $directoryContents
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectoryContents $directoryContents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDirectoryContentsRequest  $request
     * @param  \App\Models\DirectoryContents  $directoryContents
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectoryContentsRequest $request, DirectoryContents $directoryContents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectoryContents  $directoryContents
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectoryContents $directoryContents)
    {
        //
    }
}
