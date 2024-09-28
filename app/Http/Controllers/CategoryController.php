<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\MasterCategory;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct( protected CategoryService $category ) { }
    public function index()
    {
        $masterCat = MasterCategory::all()->where('status','1');
        $categories = Category::all();
        return view('admin.manageCategory',['masterCategory' => $masterCat , 'category' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->category->store($request->all());
        if(isset($data['status']) === 200){
            return response()->json(['status' => 200, 'message' => 'Category Added Successfully']);
        } else {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $data = $this->category->update($request->all(),$id);
        if(true){
            return response()->json(['status' => 200, 'message' => 'Category Updated Successfully']);
        } else {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->category->destroy($id);
        if(true) {
            return response()->json(['status' => 200 , 'message' => 'Category Deleted Successfully']);
        } else {
            return response()->json(['status' => 500 , 'message' => "something went wrong"]);
        }
    }
}
