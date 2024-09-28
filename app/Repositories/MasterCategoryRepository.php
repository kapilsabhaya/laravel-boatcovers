<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\MasterCategory;
use Illuminate\Support\Facades\Validator;


class MasterCategoryRepository 
{
    public function store(array $data) {
        $validation = Validator::make($data,[
            'master_name' => 'required|unique:master_category,master_category_name',
            'slug' => 'required|unique:master_category,slug'
        ]);
        if($validation->passes()) {
            $addMaster = MasterCategory :: create(['master_category_name' => $data['master_name']]);
            if($addMaster) {
                return ['status' == 200];
            }
        } else {
            return ['errors' => $validation->errors()];
        }
    }

    public function update(array $data, $id){
        $validation = Validator::make($data,[
            'master_name' => 'required',
            'slug' => 'required|unique:master_category,slug'
        ]);
        if($validation->passes()) { 
            $update = MasterCategory ::where('id',$id)->update(['master_category_name' => $data['master_name'] , 'status' => $request['status']]);
            if($update) {
                return ['status' == 200];
            }
        } else {
            return ['errors' => $validation->errors()];
        }
    }

    public function destroy($id){
        $findCategory = Category::where('master_category_id',$id)->first();
        if($findCategory) {
            return ['status' => 500];
        }
        $delete = MasterCategory ::where('id',$id)->delete();
        if($delete) {
            return ['status' => 200];
        } 
    }
}