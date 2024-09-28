<?php

namespace App\Repositories;

use App\Models\Option;
use Illuminate\Support\Facades\Validator;


class OptionRepository 
{
    public function store(array $data)
    {
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
    }

    public function update(array $data, string $id)
    {
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
    }
    public function destroy($id) {
        $delete = Option::where('id',$id)->delete();
        if($delete){
            return ['status' => 200];
        } else {
            return ['status' => 500];
        }
    }
}
