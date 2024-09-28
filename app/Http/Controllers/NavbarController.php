<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\MasterCategory;
use Illuminate\Support\Facades\Redis;

class NavbarController extends Controller
{
    public function getSubCategory($id) {
        $cacheKey = 'subCategories_' . $id;
        $subcategories = Redis::get($cacheKey);
        if(!$subcategories) {
            $subcategories = Category::where('master_category_id',$id)->get();
            Redis::setex($cacheKey , 3600,json_encode($subcategories));
        } else {
            $subcategories = json_decode($subcategories, true);
        }
        return response()->json(['status' =>200 ,'subcategories' => $subcategories]);
    }
}   
