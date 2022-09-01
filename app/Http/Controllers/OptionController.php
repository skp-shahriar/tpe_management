<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\lib\Webspice;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Exports\OptionExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    function __construct()
    {
        $this->table = 'options';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $startTime = microtime(true);
        $query = Option::select('options.id', 'options.group_name', 'options.option_value', 'options.option_value2', 'options.option_value3', 'options.status', 'parents.option_value as parents_name');
        $query->leftJoin('options as parents', 'parents.id', '=', 'options.parent_id');
        if ($request->search_group_name != null) {
            $query->where('options.group_name', $request->search_group_name);
        }
        if ($request->search_status != null) {
            $query->where('options.status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('options.option_value', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('options.option_value2', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('options.option_value3', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('parents.option_value', 'LIKE', '%' . $searchText . '%');
            });
        }
        $query->orderBy('options.id', 'desc');
        if ($request->submit_btn == 'export') {
            return Excel::download(new OptionExport($query->get()), 'option_list_' . time() . '.xlsx');
        }

        $options = $query->paginate(8);


        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;


        return view('master_data.option.index', [
            'options' => $options,
            'execution_time' => $executionTime
        ]);
    }

    


    public function parentDropDown()
    {
        #get record from cache if exist or set
        // $active_cache_options = collect(json_decode(Redis::get('options')));
        // $active_cache_options = $active_cache_options->where('status', 7)->sortByDesc('option_value');
        // if (isset($active_cache_options)) {
        //     $active_options = json_decode($active_cache_options);
        // } else {
        //     $active_options = Option::where('status', 7)->get();
        //     Redis::set('options', json_encode($active_options));
        // }

         $active_options = Option::where([['parent_id', '=', 0], ['status', '=', 7]])->get();
        return response()->json([
            'status' => 200,
            'data' => $active_options
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.option.create');
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
            'group_name' => ['required',
            Rule::unique('options')->where(function ($query) use($request) {
                return $query->where('group_name', $request->group_name)
                ->where('option_value', $request->option_value);
            })],
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
                'group_name'=>strtolower($request->group_name),
                'parent_id'=>$request->parent_id,
                'option_value'=>$request->option_value,
                'option_value2'=>$request->option_value2,
                'option_value3'=>$request->option_value3,
                'status'=>7,
                'created_by'=> Auth::user()->id,
            ];
            $option_created=Option::create($data);
            Webspice::log('options', $option_created->id, "Data Created successfully!");
            // if(Redis::exists('options')) {
            //     Redis::del('options');
            //     Redis::set('options',json_encode(Option::all()));
            // }else{
            //     Redis::set('options',json_encode(Option::all()));
            // }            
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
        $id = Crypt::decryptString($id);
        $option = Option::where('id', $id)->where('status', 7)->first();
        if (!$option) {
            return response()->json(['error' => 'SORRY! Something went wrong!']);
        }
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
        $id = Crypt::decryptString($id);
             
        $validator = Validator::make($request->all(), [
            'group_name' => 'required',
            'parent_id' => 'required',
            'option_value' => [
                'required',
                Rule::unique('options')->ignore($id, 'id')->where(function ($query) use ($request) {
                    return $query->where('group_name', $request->group_name)
                        ->where('option_value', $request->option_value);
                })
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        } else {
            $data = [
                'group_name' => strtolower($request->group_name),
                'parent_id' => $request->parent_id,
                'option_value' => $request->option_value,
                'option_value2' => $request->option_value2,
                'option_value3' => $request->option_value3,
                'updated_by' => Auth::user()->id,
            ];
            $updateOk = false;
            try {               
                Option::find($id)->update($data);
                $updateOk = true;
            } catch (\Illuminate\Database\QueryException $e) {
                // Do whatever you need if the query failed to execute
                $updateOk = false;
                return response()->json(['error' => 'SORRY! Something went wrong!']);
            }
            if ($updateOk) {
                // log
                Webspice::log($this->table, $id, "Data updated successfully!");

                // Update chace 
                // $cache = Redis::get($this->table);
                // if (!isset($cache)) {
                //     $cache = DB::table($this->table)->get();
                //     Redis::set($this->table, json_encode($cache));
                //     $cache = Redis::get($this->table);
                // }

                // $cacheData = collect(json_decode($cache));
                // $data = $cacheData->where('id', $id)->first();
                // $data->group_name = strtolower($request->group_name);
                // $data->parent_id = $request->parent_id;
                // $data->option_value = $request->option_value;
                // $data->option_value2 = $request->option_value2;
                // $data->option_value3 = $request->option_value3;
                // $data->updated_by = Auth::user()->id;
                // $data->updated_at = Carbon::now("Asia/Dhaka");
                // $index = $cacheData->search($data);
                // $cacheData[$index] = $data;
                // Redis::set($this->table, json_encode($cacheData));

                return response()->json([
                    'status' => 200,
                    'message' => 'Option Edited Successfully!'
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
            Option::where('id', $id)->update(['status' => -1]);
            $softDelOk = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $softDelOk = false;
            return response()->json(['error' => 'SORRY! Something went wrong!']);
        }
        if ($softDelOk) {
            // log
            Webspice::log('options', $id, "Data soft-deleted successfully!");
            // Update chace 
            // $cache = Redis::get($this->table);
            // if (!isset($cache)) {
            //     $cache = DB::table($this->table)->get();
            //     Redis::set($this->table, json_encode($cache));
            //     $cache = Redis::get($this->table);
            // }

            // $cacheData = collect(json_decode($cache));
            // $data = $cacheData->where('id', $id)->first();
            // $data->status = -1;
            // $data->updated_by = Auth::user()->id;
            // $data->updated_at = Carbon::now("Asia/Dhaka");
            // $index = $cacheData->search($data);
            // $cacheData[$index] = $data;
            // Redis::set($this->table, json_encode($cacheData));
            return response()->json([
                'status' => 200,
                'message' => 'The Option has been removed!',
            ]);
        }
    }
}