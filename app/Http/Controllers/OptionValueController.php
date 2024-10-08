<?php

namespace App\Http\Controllers;

use App\Models\OptionValue;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Services\OptionValueService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OptionValueController extends Controller
{
    public function __construct( protected OptionValueService $optionValue ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $data = $this->optionValue->store($request->all());
        if(isset($data['errors'])) {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        } else if(isset($data['status']) && $data['status'] == 500) {
            return response()->json(['status' => 50,'errors' => "Permission Denied!"]);
        } else {
            return response()->json(['status' => 200, 'message' => 'Option Value Added Successfully']);
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
        $data = $this->optionValue->update($request->all(),$id);
        if(isset($data['errors'])) {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        } else if(isset($data['status']) && $data['status'] == 500) {
            return response()->json(['status' => 500, 'errors' => "Permission Denied"]);
        } else {
            return response()->json(['status' => 200, 'message' => 'Option Value Updated Successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        if($role->hasPermissionTo('delete-option-value')) {
            $data = $this->optionValue->destroy($id);
            if($data['status'] === 200){
                return response()->json(['status' => 200 , 'message' => 'Option Deleted Successfully']);
            } else {
                return response()->json(['status' => 500 , 'message' => "something went wrong"]);
            }
        } else {
            return response()->json(['status' => 500 , 'message' => "Permission Denied"]);
        }
    } 
}