<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $adminRole = Role::find($admin->id);
        $role = $error = null;

        if($adminRole->hasPermissionTo('view-role')) {
            $role = Role::all();
        } else {
            $error = "You don't have permission to view roles";
        }
        return view('admin.roles',['role' => $role , 'error' => $error]);
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
        if($role->hasPermissionTo('create-role')) {
            try {
                $role = Role::create(['name' => $request['role'] , 'guard_name' => 'admin']);
                if($role) {
                    return response()->json(['status' => 200]);
                }
            } catch(Throwable $error){
                return response()->json(['error' => $error->getMessage()]);
            }
        } else {
            return response()->json(['error' => "You don't have permission to create role"]);
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
