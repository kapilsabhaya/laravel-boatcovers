<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\VModel;
use Illuminate\Http\Request;
use App\Models\VehicleVeriant;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssignMakeModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $assigned = $error = null;
        if($role->hasPermissionTo('view-assign-vehicle-variant')) {
        $assigned = VehicleVeriant::with(['year','model.make'])->get();
        } else {
            $error = "Permission Denied";
        }
        return view('admin.seeAssigned',['assign'=> $assigned , 'error' => $error]);
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
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('create-assign-vehicle-variant')) {
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
        } else {
            return response()->json(['status' => 500 , 'errors' => "Permission Denied"]);
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
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('delete-assign-vehicle-variant')) {
            $delete = VehicleVeriant::where('id' , $id)->delete();
            if($delete) {
                return response()->json(['status' => 200 , 'message' => 'Deleted Successfully']);
            } else {
                return response()->json(['status' => 500 , 'message' => "something went wrong"]);
            }
        } else{
            return response()->json(['status' => 500 , 'message' => "Permission Denied"]);
        }
    }
}
