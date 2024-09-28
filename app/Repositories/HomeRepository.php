<?php

namespace App\Repositories;
use App\Models\Category;
use App\Models\VModel;
use App\Models\Product;
use App\Models\MasterCategory;
use App\Models\VehicleVeriant;

class HomeRepository 
{
    public function handleSlug(array $data , $slug) {
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            $masterCategory = MasterCategory::where('slug',$slug)->first();
            if ($category) {
                    $make = VModel::join('make', 'model.make_id', '=', 'make.id')
                        ->where('model.category_id', $category->id)
                        ->select('make.id', 'make.name')
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
        } 
    }

    public function getYear($makeId) {
        $models = VModel::where('make_id',$makeId)->get();
        foreach ($models as $model) {
            $years = VehicleVeriant::with(['year'])->where('model_id',$model->id)->distinct()->get();
        }
        return $years;
    }

    public function getModel($makeId , $catId) {
        $model = VModel::where('category_id',$catId)->where('make_id',$makeId)->get();
        return $model;
    }
}