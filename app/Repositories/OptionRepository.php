<?php

namespace App\Repositories;

use App\Models\Option;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OptionRepository 
{
    public function store(array $data)
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('create-option')) {
            $validate = Validator::make($data,[
                'option'=>'required|unique:option,option_name',
            ]);
            if($validate->fails()){
                return ['errors' => $validate->errors()];
            } else {
                $insert = Option::create(['option_name' => $request->option]);
                if($insert) {
                    return ['status' == 200];
                }
            }
        } else {
            return ['status' => 500];
        }
    }

    public function update(array $data, string $id)
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('update-option')){
            $validate = Validator::make($data,[
                'option'=>'required|unique:option,option_name,'.$id,
            ]);
            if($validate->fails()){
                return ['errors' => $validate->errors()];
            } else {
                $update = Option::where('id',$id)->update(['option_name' => $data['option'] , 'status' => $data['status']]);
                if($update) {
                    return ['status' == 200];
                }
            }
        } else {
            return ['status' => 500];
        }
    }
    public function destroy($id) {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('delete-option')) {
            $delete = Option::where('id',$id)->delete();
            if($delete){
                return ['status' => 200];
            } else {
                return ['status' => 500];
            }
        } else {
            return ['status' => 500];
        }
    }
}
