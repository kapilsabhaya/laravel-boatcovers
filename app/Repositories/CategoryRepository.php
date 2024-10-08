<?php

namespace App\Repositories;

use App\Models\Category;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CategoryRepository 
{
    
    public function store(array $data) {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('create-category')) {
            $validation = Validator::make($data,[
                'category_name' => 'required',
                'slug' => 'required|unique:category,slug',
            ]);
        
            if($validation->passes()) {
                $data = [
                    'master_category_id' => $data['master_category'],
                    'category_name' => $data['category_name'],
                    'slug' => $data['slug'],
                ];
                if(isset($data['sub_category_name'])) {
                    $data['sub_category_name'] = $data['sub_category_name'];
                }
                if (isset($data['image'])) {
                    $image = request()->file('image');
                    $name = $image->getClientOriginalName();
                    $image->move('uploads/Category/', $name);
                    $data['image'] = $name;
                }
                $insertCategory = Category::create($data);
                if($insertCategory) {
                    return ['status' => 200];
                }
            } else {
                return ['errors' => $validation->errors()];
            }
        } else {
            return ['status' => 500];
        }
    }  

    public function update(array $data, $id) {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('update-category')) {
            $validation = Validator::make($data, [
                'category_name' => 'required',
                'slug' => 'required|unique:category,slug',
            ]);
    
            if ($validation->passes()) {
                $updateData = [
                    'master_category_id' => $data['master_category'],
                    'category_name' => $data['category_name'],
                    'slug' => $data['slug'],
                ];
        
                if(isset($data['sub_category_name'])) {
                    $data['sub_category_name'] = $data['sub_category_name'];
                }
                if (isset($data['image'])) {
                    $image = request()->file('image');
                    $name = $image->getClientOriginalName();
                    $image->move('uploads/Category/', $name);
                    $updateData['image'] = $name;
                }
        
                $updateCategory = Category::where('id', $id)->update($updateData);
        
                if ($updateCategory) {
                    return ['status' => 200];
                } 
            } else {
                return ['errors' => $validation->errors()];
            }
        } else {
            return ['status' => 500];
        }
    }

    public function destroy($id) {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('delete-category')) {
            $delete = Category::where('id',$id)->delete();
            if($delete){
                return ['status' => 200];
            }
        } else {
            return ['status' => 500];
        }
    }
    
}