<?php

namespace App\Http\Controllers;

use App\Models\VModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = VModel::all();
        return view('admin.manageSetting',['model' => $model]);
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
        $validation = Validator::make($request->all(),[
            'product' => 'required',
            'setting_name' => 'required|unique:setting,setting_name',
            'value' => 'required|alpha_num',
            'price_inc' => 'numeric|min_digits:0|nullable',
            'sort_order' => 'required|min_digits:0'
        ]);
        if($validation->fails()) {
            return response()->json(['status' => 500 , 'errors' => $validation->errors()]);
        } else {
            dd($request->all());
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
