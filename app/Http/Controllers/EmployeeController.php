<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Option;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\EmployeeHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use App\Lib\Webspice;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendor=Vendor::where([['status','=',7],['status','!=',-1]])->get();
        $branch=Branch::where([['status','=',7],['status','!=',-1]])->get();
        $employee=employee::where([['status','=',7],['status','!=',-1]])->get();
        $option=Option::where([['status','=',7],['status','!=',-1]])->get();
        return view('master_data.employee_list',compact('vendor','employee','option','branch'));
    }

    public function findEmployeeType(Request $request)
    {
        $type=Option::find($request->id);
        return response()->json($type);
    }

    public function fetchEmployeeTable()
    {
        $employee=Employee::get();

        foreach ($employee as $key => $val) {
            
            $vendor=Vendor::where('id',$val['vendor_id'])->pluck('vendor_name');
            $employee[$key]['vendor_id']=$vendor;

            $branch=Branch::where('id',$val['branch_id'])->pluck('branch_name');
            $employee[$key]['branch_id']=$branch;
            
            $region=Option::where('id',$val['region_id'])->pluck('option_value');
            $employee[$key]['region_id']=$region;

            $division=Option::where('id',$val['division_id'])->pluck('option_value');
            $employee[$key]['division_id']=$division;

            $department=Option::where('id',$val['department_id'])->pluck('option_value');
            $employee[$key]['department_id']=$department;

            $designation=Option::where('id',$val['designation_id'])->pluck('option_value');
            $employee[$key]['designation_id']=$designation;

            $shift=Option::where('id',$val['shift_id'])->pluck('option_value');
            $employee[$key]['shift_id']=$shift;

            $type=Option::where('id',$val['type_id'])->pluck('option_value');
            $employee[$key]['type_id']=$type;

            $type=Option::where('id',$val['grade_id'])->pluck('option_value');
            $employee[$key]['grade_id']=$type;
        }

        return response()->json($employee);
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
        return view('master_data.employee_create',compact('vendor','employee','option','branch'));
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

            EmployeeHistory::create($emp_history);
            
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
        //
    }

    public function statusSwitch(Request $request)
    {
        if ($request->status=='active') {
            Employee::where('id', $request->id)->update(['status' => 7]);

            return response()->json([
                'status'=>'active',
                'message'=>'Employee status changed to Active',
            ]);
        }else{
            Employee::where('id', $request->id)->update(['status' => -7]);

            return response()->json([
                'status'=>'inactive',
                'message'=>'Employee status changed to Inactive',
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

            Employee::find($id)->update($data);

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

            return response()->json([
                    'status'=>200,
                    'message'=> 'Employee Edited Successfully!'
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
        Employee::where('id', $id)->update(['status' => -1]);

        return response()->json([
            'status'=>200,
            'message'=>'The Employee has been removed!',
        ]);
    }


    public function employeeAction()
    {
        $employee=Employee::select('id','employee_id','employee_name')->get();
        return view('master_data.employee_action',compact('employee'));
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