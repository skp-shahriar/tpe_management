<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master_data.option_list');
    }

    public function parentDropDown()
    {
        $option= Option::where('status',7)->get();
        return response()->json([
            'status'=>200,
            'data'=> $option
        ]);
    }

    public function fetchOptionTable()
    {
        $option=Option::get();
        foreach ($option as $key => $val) {
            if ($val['parent_id']==0) {
                $option[$key]['parent_id']='-';
            }else{
                $grp_name=Option::find($val['parent_id']);
                $option[$key]['parent_id']=$grp_name['group_name'];
            }

            if ($val['option_value2']==null) {
                $option[$key]['option_value2']='-';
            }
            if ($val['option_value3']==null) {
                $option[$key]['option_value3']='-';
            }
        }
        return response()->json($option);
    }


    public function statusSwitch(Request $request)
    {
        if ($request->status=='active') {
            Option::where('id', $request->id)->update(['status' => 7]);

            return response()->json([
                'status'=>'active',
                'message'=>'Option status changed to Active',
            ]);
        }else{
            Option::where('id', $request->id)->update(['status' => -7]);

            return response()->json([
                'status'=>'inactive',
                'message'=>'Option status changed to Inactive',
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.option_create');
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
            'group_name' => 'required',
            'parent_id' => 'required',
            'option_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {
            $data=[
                'group_name'=>$request->group_name,
                'parent_id'=>$request->parent_id,
                'option_value'=>$request->option_value,
                'option_value2'=>$request->option_value2,
                'option_value3'=>$request->option_value3,
                'status'=>7,
                'created_by'=> Auth::user()->id,
            ];
            Option::create($data);
            return response()->json([
                    'status'=>200,
                    'message'=> 'Option Added Successfully!',
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $option=Option::find($id);  
        return response()->json($option);
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
            'group_name' => 'required',
            'parent_id' => 'required',
            'option_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {
            $data=[
                'group_name'=>$request->group_name,
                'parent_id'=>$request->parent_id,
                'option_value'=>$request->option_value,
                'option_value2'=>$request->option_value2,
                'option_value3'=>$request->option_value3,
                'updated_by'=> Auth::user()->id,
            ];
            Option::find($id)->update($data);
            return response()->json([
                    'status'=>200,
                    'message'=> 'Option Edited Successfully!'
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
        Option::where('id', $id)->update(['status' => -1]);

        return response()->json([
            'status'=>200,
            'message'=>'The Option has been removed!',
        ]);
    }
}