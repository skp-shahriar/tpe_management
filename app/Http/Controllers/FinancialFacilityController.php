<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Option;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\FacilityDetails;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\FinancialFacility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinancialFacilityController extends Controller
{
    public function financialFacility()
    {
        $facility_type=Option::where('group_name','facility_type')->get();
        return view('financial_facility.financial_facility', compact('facility_type'));
    }

    public function getSelectiveValue(Request $request)
    {
        if ($request->process_type=='vendor') {
            $selective_value=Vendor::get();
        }elseif ($request->process_type=='employee') {
            $selective_value=Employee::select('id','employee_id','employee_name')->get();
        }elseif ($request->process_type=='branch') {
            $selective_value=Branch::get();
        }elseif ($request->process_type=='department') {
            $selective_value=Option::where('group_name','Department')->get();
        }else {
            $selective_value='all';
        }

        return response()->json($selective_value);
    }

    public function addFinancialFacility(Request $request)
    {
        $rule_list=[
            'facility_type' => 'required',
            'process_type' => 'required',
            'applicable_month' => 'required',
            'amount_type' => 'required',
            'amount' => 'required',
        ];

        if ($request->continue=='continue') {
            $rule_list['end_month']='required';
        }
        if ($request->process_type!='all') {
            $rule_list['selective_value']='required';
        }

        $validator= Validator::make($request->all(),$rule_list);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {

            $data=[
                'facility_type'=>$request->facility_type,
                'process_type'=>$request->process_type,
                'applicable_month'=>$request->applicable_month,
                'end_month'=>$request->end_month,
                'amount_type'=>$request->amount_type,
                'amount'=>$request->amount,
                'created_by'=> Auth::user()->id,
            ];

            if ($request->process_type!='all') {
                $selective_val=implode(",",$request->selective_value);
                $data['selective_value']=$selective_val;
            }

            if ($request->process_type=='vendor') {
                $query=Employee::whereIn('vendor_id',$request->selective_value);
                $employee=$query->get('id','present_salary');
                $emp_id=$query->pluck('id')->toArray();
            }elseif ($request->process_type=='employee') {
                $query=Employee::whereIn('id',$request->selective_value);
                $employee=$query->get('id','present_salary');
                $emp_id=$query->pluck('id')->toArray();
                
            }elseif ($request->process_type=='branch') {
                $query=Employee::whereIn('branch_id',$request->selective_value);
                $employee=$query->get('id','present_salary');
                $emp_id=$query->pluck('id')->toArray();
            }elseif ($request->process_type=='department') {
                $query=Employee::whereIn('department_id',$request->selective_value);
                $employee=$query->get('id','present_salary');
                $emp_id=$query->pluck('id')->toArray();
            }else {
                $employee=Employee::get('id','present_salary');
                $emp_id=Employee::pluck('id')->toArray();
            }

            if ($request->continue=='continue') {

                $to = Carbon::createFromFormat('m/Y', $request->end_month);
                $from = Carbon::createFromFormat('m/Y', $request->applicable_month);
                $period = CarbonPeriod::create($from, '1 month', $to);
                $duplicate=false;
                foreach ($period as $dt) {
                    $year=$dt->format("Y");
                    $month=$dt->format("m");
                    $financial_faclility_id=FinancialFacility::where('facility_type',$request->facility_type)->where('applicable_month', $dt->format("m/Y"))->pluck('id')->toArray();
                    
                    $facility_details_exists=FacilityDetails::whereIn('employee_id',$emp_id)->whereIn('facility_id',$financial_faclility_id)->where('month',$month)->where('year',$year)->exists();
                    if ($facility_details_exists) {
                        $duplicate=true;
                    }
                }

                if (!$duplicate) {

                    foreach ($period as $dt) {
                        $year=$dt->format("Y");
                        $month=$dt->format("m");
                        $FinancialFacility=FinancialFacility::create($data);

                        foreach ($employee as $k=>$emp) {
                            $fd_data=[
                                'facility_id'=>$FinancialFacility->id,
                                'employee_id'=>$emp->id,
                                'month'=>$month,
                                'year'=>$year,
                            ];
                            if ($request->amount_type=='fixed') {
                                $fd_data['amount']=$request->amount;
                            }else{
                                $fd_data['amount']=($request->amount / 100) * $emp->present_salary;
                            }
                            FacilityDetails::create($fd_data);
                        }
                    }

                }else {

                    $duplicate_emp_id=FacilityDetails::whereIn('employee_id',$emp_id)->whereIn('facility_id',$financial_faclility_id)->where('month',$month)->where('year',$year)->pluck('employee_id')->toArray();
                    $duplicate_emp_name=Employee::whereIn('id',$duplicate_emp_id)->pluck('employee_name');
                    return response()->json([
                        'status'=>409,
                        'message'=> $duplicate_emp_name,
                    ]);

                }

            } else {
                $fd_date_arr=explode("/",$request->applicable_month);
                $financial_faclility_id=FinancialFacility::where('facility_type',$request->facility_type)->where('applicable_month', $request->applicable_month)->pluck('id')->toArray();

                $exist_query=FacilityDetails::whereIn('employee_id',$emp_id)->whereIn('facility_id',$financial_faclility_id)->where('month',$fd_date_arr[0])->where('year',$fd_date_arr[1]);

                $facility_details_exists=$exist_query->exists();

                    if (!$facility_details_exists) {

                        $FinancialFacility=FinancialFacility::create($data);
                        foreach ($employee as $emp) {
                            $fd_data=[
                                'facility_id'=>$FinancialFacility->id,
                                'employee_id'=>$emp->id,
                                'month'=>$fd_date_arr[0],
                                'year'=>$fd_date_arr[1],
                            ];
                            if ($request->amount_type=='fixed') {
                                $fd_data['amount']=$request->amount;
                            }else{
                                $fd_data['amount']=($request->amount / 100) * $emp->present_salary;
                            }
                            FacilityDetails::insert($fd_data);
                        }
                        

                    }else {

                        $duplicate_emp_id=$exist_query->pluck('employee_id')->toArray();
                        $duplicate_emp_name=Employee::whereIn('id',$duplicate_emp_id)->pluck('employee_name');
                        return response()->json([
                            'status'=>409,
                            'message'=> $duplicate_emp_name,
                        ]);

                    }

            }

            return response()->json([
                    'status'=>200,
                    'message'=> 'Facility Added Successfully!',
            ]);
        }
    }

    public function financialFacilityReportForm()
    {
        $facility_type=Option::where('group_name','facility_type')->get();
        $vendor=Vendor::get();
        return view('financial_facility.financial_facility_report_form', compact('facility_type','vendor'));
    }

    public function getBranch(Request $request)
    {
        if ($request->branch_type=='all') {
            $branch=Branch::get();
            return response()->json([
                'type'=>'all',
                'data'=>$branch
            ]);
        }else {
            $branch=Branch::where('branch_type',$request->branch_type)->get();
            return response()->json([
                'type'=>'selective',
                'data'=>$branch
            ]);
        }
    }

    public function generateReport(Request $request)
    {
        // $validator= Validator::make($request->all(),[
        //     'facility_type'=>'required',
        //     'vendor_id'=>'required',
        //     'branch_type'=>'required',
        //     'branch_id'=>'required',
        //     'month'=> 'required'
        // ]);
        $request->validate([
            'facility_type'=>'required',
            'vendor_id'=>'required',
            'branch_type'=>'required',
            'branch_id'=>'required',
            'month'=> 'required'
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status'=>400,
        //         'errors'=>$validator->getMessageBag()->toArray()
        //     ]);
        // }else {

            if (''!=array_search("all",$request->vendor_id)) {
                $vendor_id=Vendor::pluck('id');
            }else{
                $vendor_id=$request->vendor_id;
            }
            if (''!=array_search("all",$request->branch_id)) {
                $branch_id=Branch::pluck('id');
            }else{
                $branch_id=$request->branch_id;
            }
            $vendor_name=Vendor::whereIn('id',$vendor_id)->pluck('vendor_name')->toArray();
            $branch_name=Branch::whereIn('id',$branch_id)->pluck('branch_name')->toArray();
            $month_year=$request->month;
            $facility_type_name=Option::where('id',$request->facility_type)->pluck('option_value');
            $date_arr=explode("/",$request->month);
            $month=$date_arr[0];
            $year=$date_arr[1];
            $employee=Employee::whereIn('vendor_id',$vendor_id)->whereIn('branch_id',$branch_id)->pluck('id');
            $faclility_details=FacilityDetails::join('financial_facilities','facility_details.facility_id','=','financial_facilities.id')->select('facility_details.*','financial_facilities.facility_type')->whereIn('employee_id',$employee)->where('facility_type',$request->facility_type)->where('month',$month)->where('year',$year)->get();
            return view('financial_facility.financial_facility_report',compact('faclility_details','vendor_name','branch_name','month_year','facility_type_name'));
    }
    
}