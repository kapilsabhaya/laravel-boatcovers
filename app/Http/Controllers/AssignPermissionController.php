<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class AssignPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.assignPermission' , ['roles' => $roles , 'permissions' => $permissions] );
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
        if($role->hasPermissionTo('assign-permission-to-role')) {
            $validation = Validator::make($request->all(),[
                'role'=>'required',
                'permission'=>'required'
            ]);

            if($validation->fails()){
                return response()->json(['status'=> 500 , 'errors' => $validation->errors()]);
            } else{
                foreach($request['role'] as $roleId) {
                    $role = Role::find($roleId);
                    foreach($request['permission'] as $permissionId) {
                        $permission = Permission::find($permissionId);
                        $role->givePermissionTo($permission);
                    }
                }
                return response()->json(['status' => 200 , 'message' => 'Assigned Successfully']);
            }
        } else {
            return response()->json(['errors' => "You don't have permission to assign permissions."]);
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

    // public function permissionToAdmin(Request $request){
    //     $admins = AdminModel::all();
    //     $permissions = Permission::all();
    //     return view('admin.permissionToAdmin' , ['admins' => $admins,'permissions' => $permissions]);
    // }
    // public function permissionToAdminStore(Request $request){
    //     $validation = Validator::make($request->all(),[
    //         'admin'=>'required',
    //         'permission'=>'required'
    //     ]);

    //     if($validation->fails()){
    //         return response()->json(['status'=> 500 , 'errors' => $validation->errors()]);
    //     } else {
    //         foreach($request['admin'] as $adminId) {
    //             $admin = AdminModel::find($adminId);
    //             foreach($request['permission'] as $permissionId) {
    //                 $permission = Permission::find($permissionId);
    //                 $admin->givePermissionTo($permission);
    //             }
    //         }
    //     }
    // }
}
