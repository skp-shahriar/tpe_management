@extends('layouts.app',['title' => 'Financial Facility Report'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (isset($faclility_details[0]))
        <h3 class="text-center">{{$facility_type_name[0]}} Report - {{$month_year}}</h3>
        <p class="text-center mb-0"><b>Vendor Name:</b> {{implode(", ",$vendor_name)}}</p>
        <p class="text-center"><b>Branch Name:</b> {{implode(", ",$branch_name)}}</p>
        <table class="table table-bordered ">
            <thead>
              <tr>
                <tr>
                    <th>Sl.</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Vendor</th>
                    <th>Branch</th>
                    <th>Amount</th>
                  </tr>
              </tr>
            </thead>
            <tbody>
                @foreach ($faclility_details as $k=>$val)
                    <tr>
                        <th>{{++$k}}</th>
                        <td>{{$val->employee->employee_id}}</td>
                        <td>{{$val->employee->employee_name}}</td>
                        <td>{{$val->employee->department->option_value}}</td>
                        <td>{{$val->employee->vendor->vendor_name}}</td>
                        <td>{{$val->employee->branch->branch_name}}</td>
                        <td>{{$val->amount}}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        @else
        <h3 class="text-center text-danger">No data Found!</h3>
        <a class="text-center w-25 btn btn-info" href="{{route('financial_facility')}}">Add New Financial Facility</a>
        @endif
    </div>
</div>
@endsection