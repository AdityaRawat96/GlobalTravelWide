<?php

namespace App\Http\Controllers;

use App\Models\Pnr;
use App\Http\Requests\StorePnrRequest;
use App\Http\Requests\UpdatePnrRequest;

class PnrController extends Controller
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
     * @param  \App\Http\Requests\StorePnrRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePnrRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function show(Pnr $pnr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function edit(Pnr $pnr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePnrRequest  $request
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePnrRequest $request, Pnr $pnr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pnr $pnr)
    {
        //
    }
}
