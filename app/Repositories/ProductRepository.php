<?php

namespace App\Repositories;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ProductMedia;
use App\Models\ProductOptionValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductRepository 
{
    public function store(array $data) {
        $validation = Validator::make($data,[
            'pname' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|min:1|numeric',
            'warranty' => 'required',
            'is_active' => 'required|min:0|max:1',
            'is_customizable' => 'required|min:0|max:1',
            'product_sort_order' => 'required|numeric|min:0',
            'slug' => 'required|unique:product,slug',
            // 'option' => 'required|array',
            // 'optVal' => 'required|array',
            // 'base_price' => 'required|numeric|array',
            // 'price_increment' => 'min_digits:0|array',
            // 'option_sort_order' => 'required|numeric|min_digits:0|array',
            // 'setting_name' => 'required|alpha|array',
            // 'setting_value' => 'required|alpha_num|array',
        ]);
        if($data['desc'] == '<p><br></p>'){
            $validation->getMessageBag()->add('desc', 'The Description is required field');
        }
        if($validation->fails()) {
            return ['errors' => $validation->errors()];
            return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
        } else {
            DB::beginTransaction();

            $product = Product::create([
                    'name' => $data['pname'] ,
                    'category_id' => $data['category'] ,
                    'description' => $data['desc'] ,
                    'price' => $data['price'] ,
                    'quantity' => $data['qty'] ,
                    'warranty' => $data['warranty'] ,
                    'is_active' => $data['is_active'] ,
                    'is_customizable' => $data['is_customizable'] ,
                    'slug' => $data['slug'] ,
                    'sort_order' => $data['product_sort_order']
                    ]);
            
            if($product) {
                if(isset($data['image']))
                {
                    foreach(request()->file('image') as $index => $image)
                    {
                        $sortOrder = $index + 1;
                        $img=$image->getClientOriginalName();
                        $image->move('uploads/Product/',$img);
                        $addImg = ProductMedia::create(['product_id' => $product->id , 'media' => $img , 'sort_order' => $sortOrder]);
                    }
                }
                if(isset($data['optVal'])) {
                    $optVal = $data['optVal'];
                    $basePrice = $data['base_price'];
                    $priceIncrement = $data['price_increment'];
                    $optionSortOrder = $data['option_sort_order'];

                    for ($i = 0; $i < count($optVal); $i++) {
                        $productOptionValue = ProductOptionValue::creeate([
                            'option_value_id' => $optVal[$i],
                            'product_id' => $product->id,
                            'base_price' => $basePrice[$i],
                            'price_increment' => $priceIncrement[$i],
                            'sort_order' => $optionSortOrder[$i],
                        ]);
                    }
                }
                if((!isset($data['setting_name']))) {
                    $settingName = $data['setting_name'];
                    $settingValue = $data['setting_value'];

                    for($i = 0; $i < count($settingName); $i++) {
                        $productSetting = Setting::create([
                            'product_id' => $product->id,
                            'setting_name' => $settingName[$i],
                            'value' => $settingValue[$i],
                        ]);
                    }
                }
                DB::commit();
                return ['status' => 200];
            } else {
                DB::rollback();
                return ['status' => 500];
            }
        }
    }

    
    public function destroy($id)
    {
        $deleteProduct = Product::where('id',$id)->delete();
        if($deleteProduct) {
            $deleteMedia = ProductMedia::where('product_id',$id)->delete();
            return true;
        } else {
            return false;
        }
    }

    public function update(Request $request, string $id)
    {
        $validation = Validator::make($data,[
            'pname' => 'required',
            'desc' => 'required',
            'price' => 'required|min:10|numeric',
            'qty' => 'required|min:1|numeric',
            'warranty' => 'required|alpha_num',
            'is_active' => 'required|min:0|max:1',
            'is_customizable' => 'required|min:0|max:1',
            'product_sort_order' => 'required|numeric|min:0',
            'slug' => 'required|unique:product,slug,'.$id,
        ]);
        if($data['desc'] == '<p><br></p>'){
            $validation->getMessageBag()->add('desc', 'The Desc is required field');
        }
        if($validation->fails()) {
            return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
        } else {
            // dd($request->all());
            DB::beginTransaction();

            $product = Product::where('id',$id)->update([
                    'name' => $data['pname'] ,
                    'category_id' => $data['category'] ,
                    'description' => $data['desc'] ,
                    'price' => $data['price'] ,
                    'quantity' => $data['qty'] ,
                    'warranty' => $data['warranty'] ,
                    'is_active' => $data['is_active'] ,
                    'is_customizable' => $data['is_customizable'] ,
                    'slug' => $data['slug'] ,
                    'sort_order' => $data['product_sort_order']
                    ]);
            
            if($product) {
                if(isset($data['image']))
                {
                    foreach(request()->file('image') as $index => $image)
                    {
                        $sortOrder = $index + 1;
                        $img=$image->getClientOriginalName();
                        $image->move('uploads/Product/',$img);
                        $addImg = ProductMedia::create(['product_id' => $product->id , 'media' => $img , 'sort_order' => $sortOrder]);
                    }
                }
                DB::commit();
                return ['status' => 200];
            } else {
            DB::rollback();
            return ['status' => 500];
            }
        }
    }
}