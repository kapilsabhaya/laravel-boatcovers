<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\MasterCategory;
use App\Services\CategoryService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct( protected CategoryService $category ) { }
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $categories = $masterCat = $error =null;
        if($role->hasPermissionTo('view-category')) {
        $masterCat = MasterCategory::all()->where('status','1');
        $categories = Category::all();
        } else {
            $error = 'You do not have permission to view categories';
        }
        return view('admin.manageCategory',['masterCategory' => $masterCat , 'category' => $categories , 'error' => $error]);
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
        if(isset($data['status']) && isset($data['status']) == 200){
            return response()->json(['status' => 200, 'message' => 'Category Added Successfully']);
        }
        else if(isset($data['status']) && isset($data['status']) == 500){
            return response()->json(['status' => 500, 'errors' => 'Permission Denied!']);
        } else if(isset($data['errors'])) {
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
        if(isset($data['status']) && $data['status'] == 200){
            return response()->json(['status' => 200, 'message' => 'Category Updated Successfully']);
        }
        else if(isset($data['status']) && $data['status'] == 500) {
            return response()->json(['status' => 500, 'errors' => 'Permission Denied!']);
        } else if(isset($data['errors'])) {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->category->destroy($id);
        if(isset($data['status']) && $data['status'] == 200) {
            return response()->json(['status' => 200 , 'message' => 'Category Deleted Successfully']);
        } else if(isset($data['status']) && $data['status'] == 500) {
            return response()->json(['status' => 500 , 'message' => "Permission Denied"]);
        }
    }
}
