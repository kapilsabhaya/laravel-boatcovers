<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Services\OptionService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct( protected OptionService $option ) { }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->id);
        $option = $error = null;
        if($role->hasPermissionTo('view-option')) {
            $option = Option::all();
        } else {
            $error = "Permission Denied!";
        }
        return view('admin.manageOption',['option' => $option,'error' => $error]);
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
        $data = $this->option->store($request->all());
        if(isset($data['status']) && $data['status'] == 500) {
            return response()->json(['status' => 500 , 'errors' => 'Permission Denied']);
        } else if(isset($data['errors'])){
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        } else {
            return response()->json(['status' =>200 , 'message' => 'Option Added Successfully']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $optVal = OptionValue::where('option_id',$id)->get();
        $optName = Option::select('option_name')->where('id',$id)->get();
        return view('admin.manageOptionValue',['optVal' => $optVal,'optId' => $id , 'optName' => $optName]);
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
        $data = $this->option->update($request->all(),$id);
        if(isset($data['status']) && $data['status'] == 500){
            return response()->json(['status' => 500 , 'errors' => "Permission Denied"]);
        } else if(isset($data['errors'])){
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        } else {
            return response()->json(['status' =>200 , 'message' => 'Option Updated Successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->option->destroy($id);
        if($data['status'] === 200){
            return response()->json(['status' => 200 , 'message' => 'Option Deleted Successfully']);
        } else if(($data['status'] === 500)) {
            return response()->json(['status' => 500 , 'message' => "Permission Denied"]);
        } else {
            return response()->json(['status' => 500 , 'message' => "Something Went Wrong"]);
        }
    }
}
