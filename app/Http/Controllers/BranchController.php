<?php

namespace App\Http\Controllers;

use App\lib\Webspice;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Exports\BranchExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    function __construct()
    {
        $this->table = 'branches';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startTime = microtime(true);
        $query = Branch::orderBy('created_at', 'desc');
        if ($request->search_branch_type != null) {
            $query->where('branch_type', $request->search_branch_type);
        }
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('branch_code', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('branch_name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('branch_type', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('address', 'LIKE', '%' . $searchText . '%');
            });
            // $query->whereLike(['branch_code', 'branch_name', 'branch_type', 'address'], $searchText);
        }
        if ($request->submit_btn == 'export') {
            return Excel::download(new BranchExport($query->get()->makeHidden(['created_by','updated_by','created_at','updated_at'])), 'branch_list_' . time() . '.xlsx');
        }

        $branches = $query->paginate(8);


        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;


        return view('master_data.branch.index', [
            'branches' => $branches,
            'execution_time' => $executionTime
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.branch.create');
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
            $branch_created=Branch::create($data);
            Webspice::log($this->table, $branch_created->id, "Data Created successfully!");
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decryptString($id);
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
        $id = Crypt::decryptString($id);
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
            $updateOk = false;
            try {               
                branch::find($id)->update($data);
                $updateOk = true;
            } catch (\Illuminate\Database\QueryException $e) {
                // Do whatever you need if the query failed to execute
                $updateOk = false;
                return response()->json(['error' => 'SORRY! Something went wrong!']);
            }
            if ($updateOk) {
                Webspice::log($this->table, $id, "Data updated successfully!");

                return response()->json([
                    'status'=>200,
                    'message'=> 'Branch Edited Successfully!'
            ]);
            }
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
        $id = Crypt::decryptString($id);
        $softDelOk = false;
        try {
            Branch::where('id', $id)->update(['status' => -1]);
            $softDelOk = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $softDelOk = false;
            return response()->json(['error' => 'SORRY! Something went wrong!']);
        }
        if ($softDelOk) {
            // log
            Webspice::log($this->table, $id, "Data soft-deleted successfully!");
            return response()->json([
                'status'=>200,
                'message'=>'The Branch has been removed!',
            ]);
        }
        
    }
}