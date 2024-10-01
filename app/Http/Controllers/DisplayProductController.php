<?php

namespace App\Http\Controllers;
use App\Services\DisplayProductService;


use Illuminate\Http\Request;

class DisplayProductController extends Controller
{
    public function __construct( protected DisplayProductService $displayProduct ) { }
    
    public function getProduct(Request $request, $make , $model , $year) {
        $data = $this->displayProduct->getProduct($request->all(),$make,$model,$year);
        if(isset($data['makeError']) == 500) {
            return view('commonProductView')->withErrors("Invalid Make !");
        }
        if(isset($data['modelError']) == 500) {
            return view('commonProductView')->withErrors("Invalid Model !");
        }
        if(isset($data['yearError']) == 500) {
            return view('commonProductView')->withErrors("Invalid Year !");
        }
        if(isset($data['vehicleError']) == 500) {
            return view('commonProductView')->withErrors("Vehicle Not Found !");
        }
        if(isset($data['products'])) {
            return view('commonProductView', ['products' => $data['products'] ,'make' => $data['make'],'model' => $data['model'], 'year' => $data['year']]);
        } 
    }

    public function singleProduct($slug) {
        $product = $this->displayProduct->singleProduct($slug);
        if($product == false) {
            return view('singleProductView')->withErrors("Product Not Found");
        }
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
        if($product == false) {
            return view('customizeProductView')->withErrors('Product Not Found');
        }
        return view('customizeProductView',['product' => $product]);
    }

    public function price_increment(Request $req) {
        $price_increment = $this->displayProduct->price_increment($req->all());
        if(isset($price_increment['optionValue']) == 500) {
            return response()->json(['errors' => 'Option Value Mismatch']);
        }
        if(isset($price_increment['productError']) == 500) {
            return response()->json(['errors' => 'Product Not Found']);
        }
        return response()->json(['price_increment' => $price_increment]);
    }
}

