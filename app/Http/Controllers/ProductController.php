<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\ProductOptionValue;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct( protected ProductService $product ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $product = $error = null;
        if($role->hasPermissionTo('view-product')) {
            $product = Product::with(['getCategory' , 'media'])->get();
        } else {
            $error = 'You do not have permission to view this page';
        }
        return view('admin.manageProduct',['product' => $product,'error' => $error]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        $opt = Option::all();
        return view('admin.addProduct',['option'=> $opt , 'category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->product->store($request->all());
        if(isset($data['errors'])) {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        } else if(isset($data['errors']) == 500) {
            return response()->json(['status' => 500 , 'message' => 'Product Add Failed']);
        } else {
            return response()->json(['status' => 200 , 'message' => 'Product Added Successfully']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::all();
        $product = Product::with(['getCategory' , 'media','productOption.optionValue','setting'])->where('id',$id)->get();
        $option = Option::all();
        return view('admin.updateProduct',['category' => $category,'product' => $product,'option' => $option]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->product->update($request->all(),$id);
        if(isset($data['status']) && $data['status'] == 200) {
            return response()->json(['status' => 200 , 'message' => 'Product Updated Successfully']);
        }
        if(isset($data['status']) && $data['status'] == 500) {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        } else {
            return response()->json(['status' => 500 , 'message' => 'Product Update Failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->product->destroy($id);
        if(isset($data['status']) && $data['status'] == 200) {
            return response()->json(['status' => 200 , 'message' => 'Product Deleted Successfully']);
        } 
        if(isset($data['status']) && $data['status'] == 500) {
            return response()->json(['status' => 500 , 'message' => 'Permisssion Denied']);
        }
        else {
            return response()->json(['status' => 500 , 'message' => 'Product Deleted Failed']); 
        }
    }

    public function getOptionValue(string $id){
        $optVal = OptionValue::where('option_id',$id)->select('id as option_val_id','option_value')->get();
        return response()->json(['status' => 200 , 'optVal' => $optVal]);
    }
    
    public function deleteImg(Request $request){
        $checkImageExist = ProductMedia::where('id',$request['imgId'])->first();
        if(!$checkImageExist) {
            return response()->json(['status' => 500 , 'error' => "Image does not exist"]);
        }
        $checkImageAssociated = ProductMedia::where('id',$request['imgId'])->where('product_id',$request['productId'])->first();
        if(!$checkImageAssociated) {
            return response()->json(['status' => 500 , 'error' => "Image Not Valid!"]);
        }
        $deleteImg = ProductMedia::where('id',$request['imgId'])->delete();
        if($deleteImg) {
            return response()->json(['status' => 200]);
        }
    }
}
