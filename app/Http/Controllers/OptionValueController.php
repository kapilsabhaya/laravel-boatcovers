<?php

namespace App\Http\Controllers;

use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Services\OptionValueService;
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
        if($data['errors']) {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
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
        if($data['errors']) {
            return response()->json(['status' => 500 , 'errors' => $data['errors']]);
        } else {
            return response()->json(['status' => 200, 'message' => 'Option Value Updated Successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->optionValue->destroy($id);
        if($data['status'] === 200){
            return response()->json(['status' => 200 , 'message' => 'Option Deleted Successfully']);
        } else {
            return response()->json(['status' => 500 , 'message' => "something went wrong"]);
        }
    } 
}