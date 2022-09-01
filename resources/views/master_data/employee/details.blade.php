@extends('layouts.app',['title' => 'Employee Profile'])

@section('content')
<div class="container">
<div class="mt-4 row justify-content-center">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="{{route('employee.index')}}" class="btn btn-success float-end"><i class="fa-solid fa-circle-arrow-left"></i> View All Employee</a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 px-5">
        <table class="mt-2 table table-bordered">
            <tbody>
                <tr class="">
                    <th class="fw-bold " width="25%">Employee ID:</th>
                    <td class="">{{$employee->employee_id}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Employee Name:</th>
                    <td class="">{{$employee->employee_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Employee Phone:</th>
                    <td class="">{{$employee->employee_phone}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Employee E-mail:</th>
                    <td class="">{{$employee->employee_email}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Vendor Name:</th>
                    <td class="">{{$employee->vendor->vendor_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Branch Name:</th>
                    <td class="">{{$employee->branch->branch_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Region:</th>
                    <td class="">{{$employee->region->option_value}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Division:</th>
                    <td class="">{{$employee->division->option_value}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Department:</th>
                    <td class="">{{$employee->department->option_value}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Designation:</th>
                    <td class="">{{$employee->designation->option_value}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Shift:</th>
                    <td class="">{{$employee->shift->option_value}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Employee Type:</th>
                    <td class="">{{$employee->type->option_value}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Present Salary:</th>
                    <td class="">{{$employee->present_salary}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Servic Reference ID:</th>
                    <td class="">{{$employee->service_reference_id}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Start Date:</th>
                    <td class="">{{$employee->start_date}}</td>
                </tr>
                <tr class="">
                    <th
                    class="fw-bold " width="25%">End date:</th>
                    <td class="">{{$employee->end_date}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Grade:</th>
                    <td class="">{{$employee->grade->option_value}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Gender:</th>
                    <td class="">{{$employee->gender}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Date of birth:</th>
                    <td class="">{{$employee->date_of_birth}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Marital Status:</th>
                    <td class="">{{$employee->marital_status}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Religion:</th>
                    <td class="">{{$employee->religion}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">National ID:</th>
                    <td class="">{{$employee->national_id}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">TIN No:</th>
                    <td class="">{{$employee->tin}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Reference Info:</th>
                    <td class="">{{$employee->reference_info}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Under Service Type Package:</th>
                    <td class="">{{$employee->under_service_type_packages}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Nationality:</th>
                    <td class="">{{$employee->nationality}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Father Name:</th>
                    <td class="">{{$employee->father_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Mother Name:</th>
                    <td class="">{{$employee->mother_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Husband/Wife name:</th>
                    <td class="">{{$employee->husband_wife_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Blood Group:</th>
                    <td class="">{{$employee->blood_group}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Present Address:</th>
                    <td class="">{{$employee->present_address}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Permanent Address:</th>
                    <td class="">{{$employee->permanent_address}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Supervisor Name:</th>
                    <td class="">{{$employee->supervisor_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Manager Name:</th>
                    <td class="">{{$employee->manager_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold " width="25%">Joining Date:</th>
                    <td class="">{{$employee->joining_date}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection