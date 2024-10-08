<?php

namespace App\Http\Controllers;

use App\Models\AdminRole;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssignRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = AdminModel::all();
        $roles = Role::all();
        return view('admin.assignRole', ['admins' => $admins,'roles' => $roles]);
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
        if($role->hasPermissionTo('assign-role-to-admin')) {
            $validation = Validator::make($request->all(),[
                'admin'=>'required',
                'role'=>'required'
            ]);

            if($validation->fails()){
                return response()->json(['status'=> 500 , 'errors' => $validation->errors()]);
            } else {
                foreach($request['admin'] as $adminId) {
                    $admin = AdminModel::find($adminId);
                    foreach($request['role'] as $roleId) {
                        $role = Role::find($roleId);
                        $admin->assignRole($role);
                    }
                }
                return response()->json(['status' => 200 , 'message' => 'Assigned Successfully']);
            }
        } else {
            return response()->json(['errors' => "You don't have permission to add new"]);
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
