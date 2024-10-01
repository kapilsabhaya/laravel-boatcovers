<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Services\HomeService;

class HomeController extends Controller
{
    public function __construct( protected HomeService $home ) { }

    public function index() {
        $data = $this->home->index();
        return view('dashboard',['boats' => $data['boat'] , 'jetSkies' => $data['jetSky'] , 'cars' => $data['car'] , 'extra' => $data['extra'] ]);
    }
    
    public function handleSlug(Request $request ,$slug) {
        $data = $this->home->handleSlug($request->all(),$slug);
        if($data == false) {
            return redirect()->route('dashboard')->withErrors('Not Found');
        }
        if(isset($data['category']) && isset($data['make'])) {
            return view('commonCategoryView', ['category' => $data['category'], 'make' => $data['make']]);
        } else if(isset($data['category']) && isset($data['product'])){
            return view('commonCategoryView2', ['category' => $data['category'], 'product' => $data['product']]);
        } else {
            return view('categoryPatio',['category' =>$data['category']  ]);
        }
    }
    
    
    public function getYear($makeId) {
        $year = $this->home->getYear($makeId);
        if($year == false) {
            return response()->json(['error' => "Invalid Make !"]);
        }
        return response()->json(['years' => $year]);     
    }

    public function getModel($makeId, $catId) {
        $model = $this->home->getModel($makeId , $catId);
        if(isset($model['makeError']) == 500) {
            return response()->json(['error' => "Invalid Make !"]);
        } 
        if(isset($model['catError']) == 500) {
            return response()->json(['error' => "Invalid Category !"]);
        }
        return response()->json(['models' => $model]);
    }
}
