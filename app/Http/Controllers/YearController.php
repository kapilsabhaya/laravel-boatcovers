<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $year = Year::all();
        return view('admin.manageYear',['year' => $year]);
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
            'year' => 'required|unique:year,year|integer',
        ]);
        if($validation->passes()) {
            $insert = Year::create(['year' => $request->year]);
            if($insert) {
                return response()->json(['status' => 200 , 'message' => 'Year added successfully']);
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
        $validation = Validator::make($request->all(),[
            'year' => 'required|unique:year,year,'.$id,
        ]);
        if($validation->passes()) {
            $update = Year::where('id',$id)->update(['year' => $request->year]);
            if($update) {
                return response()->json(['status' => 200 , 'message' => 'Year updated successfully']);
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
        $delete = Year::where('id', $id)->delete();
        if($delete) {
            return response()->json(['status' => 200, 'message' => 'Year Deleted Successfully']);
        } else {
            return response()->json(['status' => 500 , 'message' => "Failed To Delete"]);
        }
    }
}
