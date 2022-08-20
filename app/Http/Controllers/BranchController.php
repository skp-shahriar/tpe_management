<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master_data.branch_list');
    }

    public function fetchBranchTable()
    {
        $branch=Branch::get();
        return response()->json($branch);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.branch_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'branch_code' => 'required|unique:branches,branch_code',
            'branch_name' => 'required|unique:branches,branch_name',
            'branch_type' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {
            $data=[
                'branch_code'=>$request->branch_code,
                'branch_name'=>$request->branch_name,
                'branch_type'=>$request->branch_type,
                'address'=>$request->address,
                'status'=> 7,
                'created_by'=> Auth::user()->id,
            ];
            Branch::create($data);
            return response()->json([
                    'status'=>200,
                    'message'=> 'Branch Added Successfully!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function statusSwitch(Request $request)
    {
        
        if ($request->status=='active') {
            Branch::where('id', $request->id)->update(['status' => 7]);

            return response()->json([
                'status'=>'active',
                'message'=>'Branch status changed to Active',
            ]);
        }else{
            Branch::where('id', $request->id)->update(['status' => -7]);

            return response()->json([
                'status'=>'inactive',
                'message'=>'Branch status changed to Inactive',
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch=Branch::find($id);  
        return response()->json($branch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator= Validator::make($request->all(),[
            'branch_name' => 'required|unique:branches,branch_name,'.$id,
            'branch_code' => 'required|unique:branches,branch_code,'.$id,
            'branch_type' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {
            $data=[
                'branch_name'=>$request->branch_name,
                'branch_code'=>$request->branch_code,
                'branch_type'=>$request->branch_type,
                'address'=>$request->address,
                'updated_by'=> Auth::user()->id,
            ];
            branch::find($id)->update($data);
            return response()->json([
                    'status'=>200,
                    'message'=> 'Branch Edited Successfully!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Branch::where('id', $id)->update(['status' => -1]);

        return response()->json([
            'status'=>200,
            'message'=>'The Branch has been removed!',
        ]);
    }
}