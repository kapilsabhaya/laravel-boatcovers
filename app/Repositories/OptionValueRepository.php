<?php

namespace App\Repositories;

use App\Models\OptionValue;
use Illuminate\Support\Facades\Validator;


class OptionValueRepository 
{
    public function store(array $data)
    {
        $validation = Validator::make($data,[
            'name' => 'required|unique:option_value,option_value',
            // 'base_price' => 'required|numeric',
            // 'price_increment' => 'numeric',
            'sort_order' => 'required|numeric'
        ]);
        if($validation->passes()) {
            $insert = OptionValue::create(['option_value'=>$data['name'] , 'option_id' => $data['option_id'] , 'is_default' => $data['is_default'] , 'sort_order' => $data['sort_order']]);
            if($insert) {
                return ['status' =>200];
            }
        } else{
            return ['errors'=> $validation->errors()];
        }
    }
    public function update(array $data, string $id)
    {
        $validation = Validator::make($data,[
            'name' => 'required|unique:option_value,option_value',
            'sort_order' => 'required|numeric'
        ]);
        if($validation->passes()) {
            $update = OptionValue::where('id',$id)->update(['option_value'=>$data['name'] , 'option_id' => $data['option_id'] , 'is_default' => $data['is_default'] , 'sort_order' => $data['sort_order']]);
            if($update) {
                return ['status' =>200];
            }
        } else{
            return ['errors'=> $validation->errors()];
        }
    }

    public function destroy($id) {
        $delete = OptionValue::where('id',$id)->delete();
        if($delete){
            return ['status' => 200];
        } else {
            return ['status' => 500];
        }
    }
}