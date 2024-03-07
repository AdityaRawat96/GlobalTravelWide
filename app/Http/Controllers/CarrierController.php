<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarrierController extends Controller
{
    public function index()
    {
        $carriers = Carrier::all();
        return view('admin.carrier.carrier')->with('carriers', $carriers);
        // return view('carrier.index')->with('record', $carriers);
    }

    public function create()
    {
        $record = new Carrier();
        return view('carrier.create', compact('record'));
    }

    public function edit($id)
    {
        $record = Carrier::find($id);
        return view('carrier.edit', compact('record'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // return $r->diagnoses_id;
            $carrier_data = $request->all();
            $data['name'] = $carrier_data["name"];
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachment_file = Storage::disk('s3')->put('carriers', $attachment);
                $data["logo"] = $attachment_file;
            }
            Carrier::create($data);
            DB::commit();
            return redirect()->back()->withSuccess('Record Added Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $carrier_data = $request->all();
            $data['name'] = $carrier_data["name"];
            $data["logo"] = null;
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                if (!Storage::disk('s3')->exists("carriers/" . $attachment->getClientOriginalName())) {
                    $attachment_file = Storage::disk('s3')->put('carriers', $attachment);
                } else {
                    $attachment_file = "carriers/" . $attachment->getClientOriginalName();
                }
                $data["logo"] = $attachment_file;
            }
            Carrier::find($id)->update($data);
            DB::commit();
            return redirect()->back()->withSuccess('Record Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Carrier::find($id)->delete();
        return $id;
    }
}
