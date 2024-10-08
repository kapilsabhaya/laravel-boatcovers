<?php

namespace App\Repositories;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ProductMedia;
use App\Models\ProductOptionValue;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
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
                        $productOptionValue = ProductOptionValue::create([
                            'option_value_id' => $optVal[$i],
                            'product_id' => $product->id,
                            'base_price' => $basePrice[$i],
                            'price_increment' => $priceIncrement[$i],
                            'sort_order' => $optionSortOrder[$i],
                        ]);
                    }
                }
                if((isset($data['setting_name']))) {
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
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('delete-product')){
            $deleteProduct = Product::where('id',$id)->delete();
            if($deleteProduct) {
                $deleteMedia = ProductMedia::where('product_id',$id)->delete();
                return ['status' => 200];
            } else {
                return false;
            }
        } else {
            return ['status' => 500];
        }
    }

    public function update(array $data, string $id)
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('update-product')) {
            $validation = Validator::make($data,[
                'pname' => 'required',
                'desc' => 'required',
                'price' => 'required|numeric',
                'qty' => 'required|min:1|numeric',
                'warranty' => 'required',
                'is_active' => 'required|min:0|max:1',
                'is_customizable' => 'required|min:0|max:1',
                'product_sort_order' => 'required|numeric|min:0',
                'slug' => 'required|unique:product,slug,'.$id,
            ]);
            if($data['desc'] == '<p><br></p>'){
                $validation->getMessageBag()->add('desc', 'The Desc is required field');
            }
            if($validation->fails()) {
                return ['status' => 500 , 'errors' => $validation->errors()];
            } else {
                // dd($request->all());
                DB::beginTransaction();
                $product = true;
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
                            $addImg = ProductMedia::updateOrCreate(['product_id' => $id , 'media' => $img , 'sort_order' => $sortOrder]);
                        }
                    }

                    if(isset($data['optVal'])) {

                        $allOptions = ProductOptionValue::where('product_id',$data['product_id'])->get();
                        $optVal = $data['optVal'];
                        $basePrice = $data['base_price'];
                        $priceIncrement = $data['price_increment'];
                        $optionSortOrder = $data['option_sort_order'];
        
                        foreach($allOptions as $allOption) {
                            if(!in_array($allOption['option_value_id'], $optVal)) {
                                $deleteOption = ProductOptionValue::where('product_id',$id)->where('option_value_id',$allOption['option_value_id'])->delete();
                            }
                        }
    
                        for ($i = 0; $i < count($optVal); $i++) {
                            $existingOption = ProductOptionValue::where('product_id',$id)->where('option_value_id',$optVal[$i])->first();
                            if($existingOption) {
                                // Update existing option
                                $existingOption->update([
                                    'base_price' => $basePrice[$i],
                                    'price_increment' => $priceIncrement[$i],
                                    'sort_order' => $optionSortOrder[$i],
                                ]);
                            } else {
                                // Create new option
                                $productOptionValue = ProductOptionValue::create([
                                    'option_value_id' => $optVal[$i],
                                    'product_id' => $id,
                                    'base_price' => $basePrice[$i],
                                    'price_increment' => $priceIncrement[$i],
                                    'sort_order' => $optionSortOrder[$i],
                                ]);
                            }
                        }
                    }

                    // dd($data['setting_name'],$data['setting_value']);
                    if((isset($data['setting_name']))) {
                        $allSettings = Setting::where('product_id',$id)->get();
                        
                        $settingName = $data['setting_name'];
                        $settingId = $data['setting_id'];
                        $settingValue = $data['setting_value'];
    
                        foreach($allSettings as $allSetting) {
                            if(!in_array($allSetting['id'], $settingId)){
                                $deleteSetting = Setting::where('id',$allSetting['id'])->delete();
                            }
                        }
                        
                        foreach($settingName as $i => $setting) {
                        $existingSetting = Setting::where('product_id',$id)->where('id',$settingId[$i])->first();
                        if($existingSetting) {
                            $updateSetting = Setting::where('product_id',$id)->where('id',$settingId[$i])->update(['setting_name' => $settingName[$i] , 'value' => $settingValue[$i]]);
                        } else {
                            $createSetting = Setting::create([
                                'product_id' => $id,
                                'setting_name' => $settingName[$i],
                                'value' => $settingValue[$i]
                            ]);
                        }
                        }
                    }
                   
                    DB::commit();
                    return ['status' => 200];
                } else {
                DB::rollback();
                return ['status' => 500];
                }
            }
        } else {
            return response()->json(['status' => 500 , 'errors' => "You don't have permission to update product"]);
        }
    }
}