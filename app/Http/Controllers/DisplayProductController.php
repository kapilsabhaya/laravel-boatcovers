<?php

namespace App\Http\Controllers;
use App\Services\DisplayProductService;


use Illuminate\Http\Request;

class DisplayProductController extends Controller
{
    public function __construct( protected DisplayProductService $displayProduct ) { }
    
    public function getProduct(Request $request, $make , $model , $year) {
        $data = $this->displayProduct->getProduct($request->all(),$make,$model,$year);
        // dd($data['year']);
        return view('commonProductView', ['products' => $data['products'] ,'make' => $data['make'],'model' => $data['model'], 'year' => $data['year']]);
    }

    public function singleProduct($slug) {
        $product = $this->displayProduct->singleProduct($slug);
        return view('singleProductView',['product' => $product]);
    }

    public function subCatPatio($param)
    {
        $data = $this->displayProduct->subCatPatio($param);
        if(isset($data['sub_category'])){
            return view('subCategoryPatio', ['sub_category' => $data['sub_category']]);
        } else {
            return view('modelPatio', ['product' => $data['product']]);
        }
    }  

    public function customizeProduct($slug) {
        $product = $this->displayProduct->customizeProduct($slug);
        return view('customizeProductView',['product' => $product]);
    }

    public function price_increment(Request $req) {
        $price_increment = $this->displayProduct->price_increment($req->all());
        return response()->json(['price_increment' => $price_increment]);
    }
}

