<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Http\Requests\StoreAffiliateRequest;
use App\Http\Requests\UpdateAffiliateRequest;

class AffiliateController extends Controller
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
     * @param  \App\Http\Requests\StoreAffiliateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAffiliateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function show(Affiliate $affiliate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function edit(Affiliate $affiliate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAffiliateRequest  $request
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAffiliateRequest $request, Affiliate $affiliate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Affiliate $affiliate)
    {
        //
    }
}
