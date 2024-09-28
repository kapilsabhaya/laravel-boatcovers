<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\MasterCategory;
use App\Services\MasterCategoryService;
use Illuminate\Support\Facades\Validator;

class MasterCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct( protected MasterCategoryService $masterCategory ) { }
    public function index()
    {
        $getMasterCategory = MasterCategory :: all();
        return view('admin.manageMasterCategory',['data' => $getMasterCategory]);
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
        $data = $this->masterCategory->store($request->all());
        if(isset($data['status']) === 200) {
            return response()->json(['status' => 200, 'message' => 'Master Category Added Successfully']);
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
    public function update(Request $request, string $id)
    {
        $data = $this->masterCategory->update($data,$id);
        if(isset($data['status']) === 200) {
            return response()->json(['status' => 200, 'message' => 'Master Category Updated Successfully']);
        } else {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->masterCategory->destroy($id);
        if(isset($data['status']) == 500 ) {
            return response()->json(['status' => 500 , 'message' => 'Master Category Associated']);
        } else {
            return response()->json(['status' => 200, 'message' => 'Master Category Deleted']);
        }
    }
}
