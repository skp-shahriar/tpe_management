<?php

namespace App\Http\Controllers;

use App\lib\Webspice;
use App\Models\Branch;
use App\Models\Option;
use App\Models\Vendor;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Models\EmployeeHistory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
// use App\Lib\Webspice;

class EmployeeController extends Controller
{
    function __construct()
    {
        $this->table = 'employees';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startTime = microtime(true);
        $query = Employee::orderBy('created_at', 'desc');
        if ($request->search_branch != null) {
            $query->where('branch_id', $request->search_branch);
        }
        if ($request->search_vendor != null) {
            $query->where('vendor_id', $request->search_vendor);
        }
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('employee_id', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('employee_name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('employee_phone', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('supervisor_name', 'LIKE', '%' . $searchText . '%');
            });
            // $query->whereLike(['branch_code', 'branch_name', 'branch_type', 'address'], $searchText);
        }
        if ($request->submit_btn == 'export') {
            return Excel::download(new EmployeeExport($query->get()->makeHidden(['vendor_id','branch_id','region_id','division_id','department_id','designation_id','shift_id','type_id','end_date','grade_id','status','created_by','updated_by','created_at','updated_at'])), 'employee_list_' . time() . '.xlsx');
        }

        $employees = $query->paginate(8);


        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $vendor=Vendor::where([['status','=',7],['status','!=',-1]])->get();
        $branch=Branch::where([['status','=',7],['status','!=',-1]])->get();
        $option=Option::where([['status','=',7],['status','!=',-1]])->get();

        return view('master_data.employee.index', [
            'employees' => $employees,
            'vendor' => $vendor,
            'option' => $option,
            'branch' => $branch,
            'execution_time' => $executionTime
        ]);
        
    }

    public function findEmployeeType(Request $request)
    {
        $type=Option::find($request->id);
        return response()->json($type);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor=Vendor::where([['status','=',7],['status','!=',-1]])->get();
        $branch=Branch::where([['status','=',7],['status','!=',-1]])->get();
        $employee=employee::where([['status','=',7],['status','!=',-1]])->get();
        $option=Option::where([['status','=',7],['status','!=',-1]])->get();
        return view('master_data.employee.create',compact('vendor','employee','option','branch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rule_list=[
            'employee_id' => 'required|numeric|unique:employees,employee_id',
            'employee_name' => 'required',
            'employee_phone' => 'required|unique:employees,employee_phone',
            'employee_email' => 'unique:employees,employee_email',
            'vendor_id' => 'required',
            'branch_id' => 'required',
            'region_id' => 'required',
            'division_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'shift_id' => 'required',
            'type_id' => 'required',
            'grade_id' => 'required',
            'present_salary' => 'required|numeric',
            'service_reference_id' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'marital_status' => 'required',
            'religion' => 'required',
            'national_id' => 'required|numeric|unique:employees,national_id',
            'tin' => 'numeric|unique:employees,tin',
            'nationality' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'blood_group' => 'required',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'supervisor_name' => 'required',
            'manager_name' => 'required',
            'joining_date' => 'required',
            'under_service_type_packages' => 'required',
        ];

        $type=Option::find($request->type_id);
        if (strtolower($type->option_value)=='probation') {

            $rule_list['start_date']="required";
            $rule_list['end_date']="required";
        }
        $validator= Validator::make($request->all(),$rule_list);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {
            $data=[
                'employee_id' => $request->employee_id,
                'employee_name' => $request->employee_name,
                'employee_phone' => $request->employee_phone,
                'employee_email' => $request->employee_email,
                'vendor_id' => $request->vendor_id,
                'branch_id' => $request->branch_id,
                'region_id' => $request->region_id,
                'division_id' => $request->division_id,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'shift_id' => $request->shift_id,
                'type_id' => $request->type_id,
                'grade_id' => $request->grade_id,
                'present_salary' => $request->present_salary,
                'service_reference_id' => $request->service_reference_id,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'marital_status' => $request->marital_status,
                'religion' => $request->religion,
                'national_id' => $request->national_id,
                'tin' => $request->tin,
                'reference_info' => $request->reference_info,
                'under_service_type_packages' => $request->under_service_type_packages,
                'nationality' => $request->nationality,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'husband_wife_name' => $request->husband_wife_name,
                'blood_group' => $request->blood_group,
                'present_address' => $request->present_address,
                'permanent_address' =>$request->permanent_address,
                'supervisor_name' => $request->supervisor_name,
                'manager_name' => $request->manager_name,
                'joining_date' => $request->joining_date,
                'status' => 7,
                'created_by'=> Auth::user()->id,
            ];

            if (strtolower($type->option_value)=='probation') {
                $data['start_date']=$request->start_date;
                $data['end_date']=$request->end_date;
            }else {
                $data['start_date']=$request->joining_date;
            }

            $employee=Employee::create($data);
            Webspice::log($this->table, $employee->id, "Data Created successfully!");
            $emp_history=[
                'employee_id'=> $employee->id,
                'branch_id'=> $request->branch_id,
                'employee_type_id'=> $request->type_id,
                'designation_id'=> $request->designation_id,
                'department_id'=> $request->department_id,
                'grade_id'=> $request->grade_id,
                'action_type'=> 'new_added',
                'updated_by'=> Auth::user()->id,
            ];

            if (strtolower($type->option_value)=='probation') {
                $emp_history['start_date']=$request->start_date;
                $emp_history['end_date']=$request->end_date;
            }else{
                $emp_history['start_date']=$request->joining_date;
            }

            $employee_history_created=EmployeeHistory::create($emp_history);
            Webspice::log('employee_histories', $employee_history_created->id, "Data Created successfully!");
            
            return response()->json([
                    'status'=>200,
                    'message'=> 'Employee Added Successfully!'
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
        $id = Crypt::decryptString($id);
        $employee=Employee::find($id);
        return view('master_data.employee.details', compact('employee'));
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
        $employee=Employee::find($id);  
        return response()->json($employee);
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
        $rule_list=[
            'employee_id' => 'required|numeric|unique:employees,employee_id,'.$id,
            'employee_name' => 'required',
            'employee_phone' => 'required|unique:employees,employee_phone,'.$id,
            'employee_email' => 'required|unique:employees,employee_email,'.$id,
            'vendor_id' => 'required',
            'branch_id' => 'required',
            'region_id' => 'required',
            'division_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'shift_id' => 'required',
            'type_id' => 'required',
            'grade_id' => 'required',
            'present_salary' => 'required|numeric',
            'service_reference_id' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'marital_status' => 'required',
            'religion' => 'required',
            'national_id' => 'required|numeric|unique:employees,national_id,'.$id,
            'tin' => 'required|numeric|unique:employees,tin,'.$id,
            'nationality' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'blood_group' => 'required',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'supervisor_name' => 'required',
            'manager_name' => 'required',
            'joining_date' => 'required',
            'under_service_type_packages' => 'required',
        ];

        $type=Option::find($request->type_id);
        if (strtolower($type->option_value)=='probation') {

            $rule_list['start_date']="required";
            $rule_list['end_date']="required";
        }

        $validator= Validator::make($request->all(),$rule_list);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {
            $data=[
                'employee_id' => $request->employee_id,
                'employee_name' => $request->employee_name,
                'employee_phone' => $request->employee_phone,
                'employee_email' => $request->employee_email,
                'vendor_id' => $request->vendor_id,
                'branch_id' => $request->branch_id,
                'region_id' => $request->region_id,
                'division_id' => $request->division_id,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'shift_id' => $request->shift_id,
                'type_id' => $request->type_id,
                'grade_id' => $request->grade_id,
                'present_salary' => $request->present_salary,
                'service_reference_id' => $request->service_reference_id,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'marital_status' => $request->marital_status,
                'religion' => $request->religion,
                'national_id' => $request->national_id,
                'tin' => $request->tin,
                'reference_info' => $request->reference_info,
                'under_service_type_packages' => $request->under_service_type_packages,
                'nationality' => $request->nationality,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'husband_wife_name' => $request->husband_wife_name,
                'blood_group' => $request->blood_group,
                'present_address' => $request->present_address,
                'permanent_address' =>$request->permanent_address,
                'supervisor_name' => $request->supervisor_name,
                'manager_name' => $request->manager_name,
                'joining_date' => $request->joining_date,
                'updated_by'=> Auth::user()->id,
            ];

            if (strtolower($type->option_value)=='probation') {
                $data['start_date']=$request->start_date;
                $data['end_date']=$request->end_date;
            }else {
                $data['start_date']=$request->joining_date;
            }

            

            $emp_history=[
                'employee_id'=> $id,
                'branch_id'=> $request->branch_id,
                'employee_type_id'=> $request->type_id,
                'designation_id'=> $request->designation_id,
                'department_id'=> $request->department_id,
                'grade_id'=> $request->grade_id,
                'updated_by'=> Auth::user()->id,
            ];

            if (strtolower($type->option_value)=='probation') {
                $emp_history['start_date']=$request->start_date;
                $emp_history['end_date']=$request->end_date;
            }else{
                $emp_history['start_date']=$request->joining_date;
            }

            $emp_hs_id=EmployeeHistory::where('employee_id',$id)->orderBy('id', 'DESC')->first();

            EmployeeHistory::find($emp_hs_id->id)->update($emp_history);

            $updateOk = false;
            try {               
                Employee::find($id)->update($data);
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
                    'message'=> 'Employee Edited Successfully!'
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
            Employee::where('id', $id)->update(['status' => -1]);
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
                'message'=>'The Employee has been removed!',
            ]);
        }
    }


    public function employeeAction()
    {
        $employee=Employee::select('id','employee_id','employee_name')->get();
        return view('master_data.employee.action',compact('employee'));
    }

    public function currentValue(Request $request)
    {
        if ($request->action=='employee_type_id') {
            $request->action='type_id';
        }
        $current_value=Employee::where('id',$request->id)->select($request->action)->first();
        if ($request->action=='branch_id') {
            $action_value=Branch::get();
        }else{
            $action=explode("_",$request->action);
            $action_value=Option::where('group_name',ucfirst($action[0]))->get();
        }
        return response()->json([
            'current_value'=>$current_value,
            'action_value'=>$action_value
        ]);
    }
    public function empHistory(Request $request)
    {
        
        $emp_data=[
        ];
        $action_type=explode("_",$request->action);
        $emp_history_data=[
            'employee_id'=>$request->employee_id,
            'start_date'=>$request->action_date,
            'action_type'=>$action_type[0].'_change',
            'updated_by'=> Auth::user()->id,
        ];

        $previous_date=date('d/m/Y',strtotime($request->action_date."-1 days"));
        Employee::find($request->employee_id)->update($emp_data);
        EmployeeHistory::where('employee_id',$request->employee_id)->orderBy('id', 'DESC')->first()->update(array('end_date' => $previous_date));
        $last_history=EmployeeHistory::where('employee_id',$request->employee_id)->orderBy('id', 'DESC')->first();
        $emp_history_data['branch_id']=$last_history->branch_id;
        $emp_history_data['employee_type_id']=$last_history->employee_type_id;
        $emp_history_data['designation_id']=$last_history->designation_id;
        $emp_history_data['department_id']=$last_history->department_id;
        $emp_history_data['grade_id']=$last_history->grade_id;
        // $emp_history_data['salary']=$last_history->salary;

        // if ($request->action=='present_salary') {
        //     $emp_history_data['salary']=$request->salary;
        // }else {
            $emp_history_data[$request->action]=$request->action_value;
        // }

        EmployeeHistory::create($emp_history_data);
        return response()->json([
            'status'=>400,
            'message'=>'saved!',
        ]);
    }
}