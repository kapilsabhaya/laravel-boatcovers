<?php

namespace App\Http\Controllers;

use App\Models\Make;
use App\Models\VModel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        $make = Make::all();
        $model = VModel::with(['category','make'])->get();
        // dd($category);
        return view('admin.manageModel',['category' => $category , 'make' => $make ,'model' => $model]);
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
        $validation = Validator ::make($request->all(), [
            'model' => 'required',
            'slug' => 'required|unique:model,slug',
        ]);
        if($validation->passes()) {
            $insert = VModel::create(['model_name' => $request->model , 'category_id' => $request->category , 'make_id' => $request->make , 'slug' => $request->slug]);
            if($insert) {
                return response()->json(['status' => 200 , 'message' => 'Model Added Successfully']);
            }
        } else {
            return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
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
    public function update(Request $request, string $id)
    {
        $validation = Validator ::make($request->all(), [
            'model' => 'required',
            'slug' => 'required|unique:model,slug,'.$id,
        ]);
        if($validation->passes()) {
            $update = VModel::where('id',$id)->update(['model_name' => $request->model , 'category_id' => $request->category , 'make_id' => $request->make , 'slug' => $request->slug]);
            if($update) {
                return response()->json(['status' => 200 , 'message' => 'Model Updated Successfully']);
            }
        } else {
            return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = VModel::where('id', $id)->delete();
        if($delete) {
            return response()->json(['status' => 200, 'message' => 'Model Deleted Successfully']);
        } else {
            return response()->json(['status' => 500 , 'message' => "Failed To delete"]);
        }
    }
}
