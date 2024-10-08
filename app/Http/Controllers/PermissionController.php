<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $permission = $error = null;

        if($role->hasPermissionTo('view-permission')) {
            $permission = Permission::all();
        } else {
            $error = "You don't have access to view permissions";
        }
        return view('admin.permissions' , ['permission' => $permission , 'error' => $error]);
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
        if($role->hasPermissionTo('create-permission')) {
            try{
                $permission = Permission::create(['name' => $request['permission'] , 'guard_name' => 'admin']);
                if($permission) {
                    return response()->json(['status' => 200]);
                } else {
                    return response()->json(['status' => 500]);
                }
            } catch(Throwable $error) {
                return response()->json(['error' => $error->getMessage()]);
            }
        } else {
            return response()->json(['error' => "You don't have permission to create new one."]);
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
        //
    }
}
