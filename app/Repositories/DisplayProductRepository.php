<?php

namespace App\Repositories;
use App\Models\Make;
use App\Models\Year;
use App\Models\VModel;
use App\Models\Product;
use App\Models\Category;
use App\Models\OptionValue;
use Illuminate\Support\Str;
use App\Models\ProductMedia;
use App\Models\VehicleVeriant;
use App\Models\ProductOptionValue;

class DisplayProductRepository 
{
    public function getProduct(array $data,$make,$model,$year) {
        $checkMake = Make::where('slug',$make)->first();
        if(!$checkMake) {
            return ['makeError' => 500 ];
        }
        $checkModel = VModel::where('slug',$model)->first();
        if(!$checkModel) {
            return ['modelError' => 500];
        }
        $checkYear = Year::where('year',$year)->first();
        if(!$checkYear) {
            return ['yearError' => 500];
        }
        $make = Str::title(str_replace('-', ' ', $make));
        $model = Str::title(str_replace('-', ' ', $model));
        $year = Str::title(str_replace('-', ' ', $year));

        $make = Make::where('name',$make)->first();
        $model = VModel::where('model_name',$model)->first();
        $year = Year::where('year',$year)->first();
        
        if(!$make || !$model || !$year) {
            return ['vehicleError' => 500];
        }
        $category = VModel::where('make_id',$make->id)->where('id',$model->id)->first();
        if($category) {
            $products = Product::with(['getCategory','media' => function($query){ $query->orderBy('sort_order')->limit(1); },'productOption.optionValue' => function($que) { $que->orderBy('option_value.sort_order'); }])->where('category_id',$category->category_id)->where('product.quantity' ,'>', 1)->where('product.is_active',true)->orderBy('sort_order')->get();
            return ['products' => $products , 'make' => $make->name ,'model' => $model->model_name, 'year' => $year->year];
        } else {
            return ['vehicleError' => 500];
        }
    }

    public function singleProduct($slug){
        $product = Product::with(['getCategory','media' => function($query){ $query->orderBy('sort_order'); },'productOption.optionValue.option' ,'setting'])->where('product.is_active',true)->where('slug',$slug)->orderBy('sort_order')->first();
        if(!$product) {
            return false;
        }
        return $product;
    }

    public function subCatPatio($param) {
        $categoryName = Str::title(str_replace('-', ' ', $param));
        $category = Category::where('category_name', $categoryName)->first();
        if ($category) {
            $sub_category = Category::where('category_name',$category->category_name)->get();
            return ['sub_category' => $sub_category];
        }

        $category = Category::where('slug',$param)->first();
        $product = Product::with(['getCategory','media' => function($query){ $query->orderBy('sort_order')->limit(1); }])->where('category_id',$category->id)->where('product.is_active',true)->orderBy('sort_order')->get();
        return ['product' => $product];
    }

    public function customizeProduct($slug) {
        $product = Product::with(['getCategory','media' => function($query){ $query->orderBy('sort_order'); },'productOption.optionValue.option'])->where('product.is_active',true)->where('slug',$slug)->orderBy('sort_order')->first();
        if(!$product) {
            return false;
        }
        return $product;
    }

    public function price_increment(array $data) {
        //check this array
        $heightId = null;
        $widthId = null;
        $depthId = null;
        if($data['height'] && $data['width'] && $data['depth']){
        $heightInch = $data['height'][0]['height'];
        $heightId = $data['height'][0]['heightId'];
        $widthInch = $data['width'][0]['width'];
        $widthId = $data['width'][0]['widthId'];
        $depthInch = $data['depth'][0]['depth'];
        $depthId = $data['depth'][0]['depthId'];
        }

        if(isset($data['product_id'])){
            $checkProduct = Product::where('id',$data['product_id'])->first();
            if(!$checkProduct) {
                return ['productError' => 500];
            }
        }
        if(isset($data['color'])) {
            $checkColor = OptionValue::where('id', $data['color'])->first();
            $checkProductOptionValue = ProductOptionValue::where('product_id',$data['product_id'])->where('option_value_id',$data['color'])->first();
            if(!$checkColor || !$checkProductOptionValue) {
                return back()->withErrors('Option Value Mismatch'); 
            }
        } 
        if(isset($data['size'])) {
            $checkSize = OptionValue::where('id', $data['size'])->first();
            $checkProductOptionValue = ProductOptionValue::where('product_id',$data['product_id'])->where('option_value_id',$data['size'])->first();
            if(!$checkSize || !$checkProductOptionValue) {
                return ['optionValue' => 500];
            }
        }
        if(isset($data['fabric'])) {
            $checkFabric = OptionValue::where('id', $data['fabric'])->first();
            $checkProductOptionValue = ProductOptionValue::where('product_id',$data['product_id'])->where('option_value_id',$data['fabric'])->first();
            if(!$checkFabric || !$checkProductOptionValue) {
                return ['optionValue' => 500];
            }
        }
        if(isset($data['tiedown'])) {
            $checkTiedown = OptionValue::where('id', $data['tiedown'])->first();
            $checkProductOptionValue = ProductOptionValue::where('product_id',$data['product_id'])->where('option_value_id',$data['tiedown'])->first();
            if(!$checkTiedown || !$checkProductOptionValue) {
                return ['optionValue' => 500];
            }
        }
        if(isset($data['grommet'])) {
            $checkGrommet = OptionValue::where('id', $data['grommet'])->first();
            $checkProductOptionValue = ProductOptionValue::where('product_id',$data['product_id'])->where('option_value_id',$data['grommet'])->first();
            if(!$checkGrommet || !$checkProductOptionValue) {
                return ['optionValue' => 500];
            }
        }
        if(isset($data['height'])) {
            $checkHeight = OptionValue::where('id', $heightId)->first();
            if(!$checkHeight) {
                return ['optionValue' => 500];
            }
        }
        if(isset($data['width'])) {
            $checkWidth = OptionValue::where('id', $widthId)->first();
            if(!$checkWidth) {
                return ['optionValue' => 500];
            }
        }
        if(isset($data['depth'])) {
            $checkDepth = OptionValue::where('id', $depthId)->first();
            if(!$checkDepth) {
                return ['optionValue' => 500];
            }
        }
       
        
        $productOption = ProductOptionValue::with('product')
            ->where('product_id', $data['product_id'])
            ->where(function($query) use ($data , $heightId , $widthId , $depthId) {
                $query->where('option_value_id', $data['fabric'])
                    ->orWhere('option_value_id', $data['tiedown'])
                    ->orWhere('option_value_id', $data['grommet'])
                    ->orWhere('option_value_id', $heightId)
                    ->orWhere('option_value_id', $widthId)
                    ->orWhere('option_value_id', $depthId)
                    ->orWhere('option_value_id', isset($data['size']));
            })
            ->get();
    
        $total_price_increment = 0;
        $measurePrice = 0;
        foreach($productOption as $proOpt) {
            if($proOpt->option_value_id == $heightId && $heightInch) {
                $heightPrice = $proOpt->base_price * $heightInch;
                $price_inc = number_format(($heightPrice + ($heightPrice * $proOpt->price_increment)/ 100),2);
                $measurePrice += $price_inc;
            }
            else if($proOpt->option_value_id == $widthId && $widthInch) {
                $widthPrice = $proOpt->base_price * $widthInch;
                $price_inc = number_format(($widthPrice + ($widthPrice * $proOpt->price_increment)/ 100),2);
                $measurePrice += $price_inc;
            }
            else if($proOpt->option_value_id == $depthId && $depthInch) {
                $depthPrice = $proOpt->base_price * $depthInch;
                $price_inc = number_format(($depthPrice + ($depthPrice * $proOpt->price_increment)/ 100),2);
                $measurePrice += $price_inc;
            }
            else if($proOpt->option_value_id == isset($data['size']) || $proOpt->option_value_id == $data['fabric'] || $proOpt->option_value_id == $data['tiedown'] || $proOpt->option_value_id == $data['grommet'] ) {
            $price = $proOpt->product->price;
            $increment_rate = $proOpt->price_increment;
            $base_price = $proOpt->base_price;
            $price_increment = number_format($price + ($base_price + ($base_price * $increment_rate / 100)) ,2);
            $total_price_increment += $price_increment;
            }
        }
        return (number_format($total_price_increment + $measurePrice,2));
    }
}