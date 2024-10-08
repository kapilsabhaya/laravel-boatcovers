<?php

namespace App\Http\Controllers;

use App\Models\Make;
use App\Models\VModel;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $error = $category = $make = $model = null;
        if($role->hasPermissionTo('view-model')) {
            $category = Category::all();
            $make = Make::all();
            $model = VModel::with(['category','make'])->get();
        } else {
            $error = "Permission Denied";
        }
        return view('admin.manageModel',['category' => $category , 'make' => $make ,'model' => $model,'error' => $error]);
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('create-model')) {
            $validation = Validator ::make($request->all(), [
                'model' => 'required',
                'slug' => 'required|unique:model,slug',
            ]);
            if($validation->passes()) {
                $insert = VModel::create(['model_name' => $request->model , 'category_id' => $request->category , 'make_id' => $request->make , 'slug' => $request->slug]);
                if($insert) {
                    return response()->json(['status' => 200 , 'message' => 'Model Added Successfully']);
                }
            } else {
                return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
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
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('update-model')) {
            $validation = Validator ::make($request->all(), [
                'model' => 'required',
                'slug' => 'required|unique:model,slug,'.$id,
            ]);
            if($validation->passes()) {
                $update = VModel::where('id',$id)->update(['model_name' => $request->model , 'category_id' => $request->category , 'make_id' => $request->make , 'slug' => $request->slug]);
                if($update) {
                    return response()->json(['status' => 200 , 'message' => 'Model Updated Successfully']);
                }
            } else {
                return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
            }
        } else {
            return response()->json(['status' => 500 , 'errors' => "Permission Denied"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('delete-model')) {
            $delete = VModel::where('id', $id)->delete();
            if($delete) {
                return response()->json(['status' => 200, 'message' => 'Model Deleted Successfully']);
            } else {
                return response()->json(['status' => 500 , 'message' => "Failed To delete"]);
            }
        } else {
            return response()->json(['status' => 500 , 'message' => "Permission Denied"]);
        }
    }
}
