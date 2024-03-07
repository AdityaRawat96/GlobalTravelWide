<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    public function index(){
        $boxes = Box::all();
        return view('admin.box.box')->with('boxes', $boxes);
        // return view('box.index')->with('record', $boxes);
    }

    public function create(){
        $record=new Box();
        return view('box.create',compact('record'));
    }

    public function edit($id){
        $record=Box::find($id);
        return view('box.edit',compact('record'));
    }

    public function store(Request $request){
        try{
            DB::beginTransaction();
            // return $r->diagnoses_id;
            $box_data = $request->all();
            $data['name'] = $box_data["box-name"];
            $data['price'] = $box_data["box-price"];
            $data['length'] = $box_data["box-length"];
            $data['width'] = $box_data["box-width"];
            $data['height'] = $box_data["box-height"];
            $data['weight'] = $box_data["box-weight"];
            Box::create($data);
            DB::commit();
            return redirect()->back()->withSuccess('Record Added Successfully');
        }
        catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function update(Request $request,$id){
        try{
            DB::beginTransaction();
            $box_data = $request->all();
            $data['name'] = $box_data["box-name"];
            $data['price'] = $box_data["box-price"];
            $data['length'] = $box_data["box-length"];
            $data['width'] = $box_data["box-width"];
            $data['height'] = $box_data["box-height"];
            $data['weight'] = $box_data["box-weight"];
            Box::find($id)->update($data);
            DB::commit();
            return redirect()->back()->withSuccess('Record Updated Successfully');
        }
        catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function destroy($id){
        Box::find($id)->delete();
        return $id;
    }
}