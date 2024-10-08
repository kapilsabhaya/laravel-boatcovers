<?php

namespace App\Http\Controllers;

use App\Models\Make;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $make = $error = null;
        if($role->hasPermissionTo('view-make')) {
        $make = Make::all();
        } else {
            $error = "You don't have access to this page";
        }
        return view('admin.manageMake',['make' => $make,'error' => $error]);
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
        if($role->hasPermissionTo('create-make')){
            $validation = Validator::make($request->all(),[
                'make' => 'required',
                'slug' => 'required|unique:make,slug,'
            ]);
            if($validation->passes()){
                $insert = Make::create(['name'=> $request->make , 'slug' => $request->slug ]);
                if($insert) {
                    return response()->json(['status' => 200, 'message' => 'Make Added Successfully']);
                }
            } else {
                return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
            }
        } else {
            return response()->json(['status' => 500, 'errors' => "Permission Denied"]);
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
        if($role->hasPermissionTo('update-make')){
            $validation = Validator::make($request->all(),[
                'make' => 'required',
                'slug' => 'required|unique:make,slug,'.$id
            ]);
            if($validation->passes()) {
                $update = Make::where('id', $id)->update(['name' => $request->make , 'slug' => $request->slug ]);
                if($update) {
                    return response()->json(['status' => 200, 'message' => 'Make Updated Successfully']);
                }
            } else {
                return response()->json(['status' => 500 , 'errors' => $validation->errors() ]);
            }
        } else {
            return response()->json(['status' => 500 , 'errors' => "Permission Denied!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('delete-make')) {
            $delete = Make::where('id', $id)->delete();
            if($delete) {
                return response()->json(['status' => 200, 'message' => 'Make Deleted Successfully']);
            } else {
                return response()->json(['status' => 500 , 'message' => "something went wrong"]);
            }
        } else {
            return response()->json(['status' => 500 , 'message' => "Permission Denied"]);
        }
    }
}
