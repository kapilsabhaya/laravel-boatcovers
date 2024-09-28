<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::get();
        return view('admin.manageUser',['user' => $user]);
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
        //
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
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if($validation->passes()) {
            $update = User::where('id',$id)->update(['name'=>$request['name'], 'email' => $request['email'], 'status' => $request['status']]);
            if($update) {
                return response()->json(['status' => 200]);
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
        $delete = User::where('id',$id)->delete();
        if($delete){
            return response()->json(['status' => 200 , 'message' => 'User Deleted Successfully']);
        } else {
            return response()->json(['status' => 500 , 'message' => 'Failed to Delete']);
        }
    }
}
