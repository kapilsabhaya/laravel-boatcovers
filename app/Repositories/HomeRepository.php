<?php

namespace App\Repositories;
use App\Models\Make;
use App\Models\VModel;
use App\Models\Product;
use App\Models\Category;
use App\Models\MasterCategory;
use App\Models\VehicleVeriant;

class HomeRepository 
{

    public function index() {
        $boatCover = Product::with(['media' => function($query){ $query->orderBy('sort_order')->limit(1); }])->where('category_id',6)->where('product.quantity' ,'>', 1)->where('product.is_active',true)->orderBy('sort_order')->limit(2)->get();
        $jetSkyCover = Product::with(['media' => function($query){ $query->orderBy('sort_order')->limit(1); } ])->where('category_id',7)->where('product.quantity' ,'>', 1)->where('product.is_active',true)->orderBy('sort_order')->limit(2)->get();
        $carCover = Product::with(['media' => function($query){ $query->orderBy('sort_order')->limit(1); }])->where('category_id',1)->where('product.quantity' ,'>', 1)->where('product.is_active',true)->orderBy('sort_order')->limit(3)->get();
        $extra = Product::with(['media' => function($query){ $query->orderBy('sort_order')->limit(1); }])->where('category_id',13)->where('product.quantity' ,'>', 1)->where('product.is_active',true)->orderBy('sort_order','desc')->first();
        return ['boat' => $boatCover , 'jetSky' => $jetSkyCover , 'car' => $carCover , 'extra' => $extra];
    }

    public function handleSlug(array $data , $slug) {
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            $masterCategory = MasterCategory::where('slug',$slug)->first();
            if($category || $masterCategory) {
                if ($category) {
                        $make = VModel::join('make', 'model.make_id', '=', 'make.id')
                            ->where('model.category_id', $category->id)
                            ->select('make.id', 'make.name')
                            ->orderBy('make.name')
                            ->distinct()
                            ->get();
                        if(!$make->isEmpty()) {
                            // all vehicle covers
                            return ['category' => $category , 'make' => $make];
                        }
                } else if ($masterCategory) {
                    $category = Category::where('master_category_id',$masterCategory->id)->get();
                    foreach ($category as $cat) {
                        if (is_null($cat->sub_category_name)) {
                            //tarps-extras
                            $product = Product::with(['media' => function($query){ $query->orderBy('sort_order')->limit(1); }])->where('category_id',$cat->id)->where('is_active',true)->orderBy('sort_order')->get();
                            return ['category' => $cat , 'product' => $product];
                        } else {
                            //patio
                            $category = Category::where('master_category_id', $masterCategory->id)
                                ->distinct()
                                ->select('master_category_id', 'category_name')
                                ->get();
                                return ['category' => $category];
                        }
                    }
                }
            } else {
                return false;
            }
        } 
    }

    public function getYear($makeId) {
        $checkMake = Make::where('id',$makeId)->first();
        if(!$checkMake) {
            return false;
        }
        $models = VModel::where('make_id',$makeId)->get();
        foreach ($models as $model) {
            $years = VehicleVeriant::join('year','year_id','year.id')->where('model_id',$model->id)->groupBy('year.year')->orderBy('year.year')->get();
            // $years = VehicleVeriant::with(['year' => function($query) { $query->orderBy('year.year','asc'); }])->where('model_id',$model->id)->get();
        }
        return $years;
    }

    public function getModel($makeId , $catId) {
        $checkMake = Make::where('id',$makeId)->first();
        if(!$checkMake) {
            return ['makeError' => 500];
        }
        $checkCategory = Category::where('id' ,$catId)->first();
        if(!$checkCategory) {
            return ['catError' => 500];
        }
        $model = VModel::where('category_id',$catId)->orderBy('model.model_name')->where('make_id',$makeId)->get();
        return $model;
    }
}