<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\MasterCategory;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
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
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $getMasterCategory = $error =null;
        if($role->hasPermissionTo('view-master-category')) {
        $getMasterCategory = MasterCategory :: all();
        } else {
        $error = "You don't have permission to access this page!";
        }
        return view('admin.manageMasterCategory',['data' => $getMasterCategory,'error' => $error]);
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
        if(isset($data['status']) && $data['status'] == 200) {
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
        $data = $this->masterCategory->update($request->all(),$id);
        if(isset($data['status']) && $data['status'] == 200) {
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
        if(isset($data['status']) && $data['status'] == 500 ) {
            return response()->json(['status' => 500 , 'message' => 'Master Category Associated']);
        }
        if(isset($data['error']) && $data['error'] == 500) {
            return response()->json(['status' => 500 , 'message' => 'Permission Denied']);
        }
        else {
            return response()->json(['status' => 200, 'message' => 'Master Category Deleted']);
        }
    }
}
