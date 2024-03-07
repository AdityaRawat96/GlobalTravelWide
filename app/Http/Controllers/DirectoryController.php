<?php

namespace App\Http\Controllers;

use App\Models\Directory;
use App\Http\Requests\StoreDirectoryRequest;
use App\Http\Requests\UpdateDirectoryRequest;

class DirectoryController extends Controller
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
     * @param  \App\Http\Requests\StoreDirectoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectoryRequest $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directory $directory)
    {
        //
    }
}
