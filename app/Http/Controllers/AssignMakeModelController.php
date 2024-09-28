<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\VModel;
use Illuminate\Http\Request;
use App\Models\VehicleVeriant;
use Illuminate\Support\Facades\Validator;

class AssignMakeModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assigned = VehicleVeriant::with(['year','model.make'])->get();
        return view('admin.seeAssigned',['assign'=> $assigned]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $year = Year::all();
        $model = VModel::all();
        return view('admin.assignMakeModelYear',['year' => $year , 'model' => $model]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'year'=>'required',
            'model'=>'required'
        ]);
        if($validation->fails()){
            return response()->json(['status'=> 500 , 'errors' => $validation->errors()]);
        } else {
            foreach ($request['year'] as $yearId) {
                foreach ($request['model'] as $modelId) {
                    $insert = VehicleVeriant::updateOrCreate([
                        'year_id' => $yearId,
                        'model_id' => $modelId,
                    ]);
                }
            }
            if($insert) {
                return response()->json(['status' => 200 , 'message' => 'Assigned Successfully']);
            }
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = VehicleVeriant::where('id' , $id)->delete();
        if($delete) {
            return response()->json(['status' => 200 , 'message' => 'Deleted Successfully']);
        } else {
            return response()->json(['status' => 500 , 'message' => "something went wrong"]);
        }
    }
}
