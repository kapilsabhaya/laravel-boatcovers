<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;


class CategoryRepository 
{
    public function store(array $data) {
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
            dd($validation->errors());
            return ['errors' => $validation->errors()];
        }
    }
    

    public function update(array $data, $id) {
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
                return true;
            } 
        } else {
            return ['errors' => $validation->errors()];
        }
    }

    public function destroy($id) {
        $delete = Category::where('id',$id)->delete();
        if($delete){
            return true;
        }
    }
    
}