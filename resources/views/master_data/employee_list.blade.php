@extends('layouts.app',['title' => 'Manage Employee'])

@section('content')
<div class="container">
<div class="row justify-content-center">
<!-- Modal -->
<div class="modal fade" id="employee_edit" tabindex="-1" aria-labelledby="employee_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="employee_edit_title">Edit Employee</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3 needs-validation edit_employee_form" novalidate>
                <div class="col-md-6 form-floating">
                    <input type="number" class="form-control employee_input" id="employee_id" name="employee_id" placeholder=" " required>
                    <label for="employee_id" >Enter Employee ID *</label>
                        <div class="invalid-feedback error_msg employee_id_err">Employee ID is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="employee_name" name="employee_name" placeholder=" " required>
                    <label for="employee_name" >Enter Employee Name *</label>
                        <div class="invalid-feedback error_msg employee_name_err">Employee Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="employee_phone" name="employee_phone" placeholder=" " required>
                    <label for="employee_phone" >Enter Employee Phone *</label>
                        <div class="invalid-feedback error_msg employee_phone_err">Employee Phone No. is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="employee_email" name="employee_email" placeholder=" ">
                    <label for="employee_email" >Enter Employee E-mail</label>
                        <div class="invalid-feedback error_msg employee_email_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="vendor_id" name="vendor_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Vendor Name</option>
                        @foreach ($vendor as $val)
                            <option value="{{$val->id}}">{{$val->vendor_name}}</option>
                        @endforeach
                    </select>
                    <label for="vendor_id" >Select Vendor *</label>
                    <div class="invalid-feedback error_msg vendor_id_err">Vendor Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="branch_id" name="branch_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Branch Name</option>
                        @foreach ($branch as $val)
                            <option value="{{$val->id}}">{{$val->branch_name}}</option>
                        @endforeach
                    </select>
                    <label for="branch_id" >Select Branch *</label>
                    <div class="invalid-feedback error_msg branch_id_err">Branch Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="region_id" name="region_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Region Name</option>
                        @foreach ($option as $val)
                            @if ($val->group_name=='Region')
                            <option value="{{$val->id}}">{{$val->option_value}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="region_id" >Select Region *</label>
                    <div class="invalid-feedback error_msg region_id_err">Region is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="division_id" name="division_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Division Name</option>
                        @foreach ($option as $val)
                            @if ($val->group_name=='Division')
                            <option value="{{$val->id}}">{{$val->option_value}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="division_id" >Select Division *</label>
                    <div class="invalid-feedback error_msg division_id_err">Division is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="department_id" name="department_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Department Name</option>
                        @foreach ($option as $val)
                            @if ($val->group_name=='Department')
                            <option value="{{$val->id}}">{{$val->option_value}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="department_id" >Select Department *</label>
                    <div class="invalid-feedback error_msg department_id_err">Department is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="designation_id" name="designation_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Designation Name</option>
                        @foreach ($option as $val)
                            @if ($val->group_name=='Designation')
                            <option value="{{$val->id}}">{{$val->option_value}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="designation_id" >Select Designation *</label>
                    <div class="invalid-feedback error_msg designation_id_err">Designation is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="shift_id" name="shift_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Shift Name</option>
                        @foreach ($option as $val)
                            @if ($val->group_name=='Shift')
                            <option value="{{$val->id}}">{{$val->option_value}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="shift_id" >Select Shift *</label>
                    <div class="invalid-feedback error_msg shift_id_err">Shift is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="type_id" name="type_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Type Name</option>
                        @foreach ($option as $val)
                            @if ($val->group_name=='Type')
                            <option value="{{$val->id}}">{{$val->option_value}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="type_id" >Select Type *</label>
                    <div class="invalid-feedback error_msg type_id_err">Employee Type is required!</div>
                </div>
                <div class="col-md-6 form-floating" id="start_date_div">
                    <input type="text" class="form-control employee_input " id="start_date" name="start_date" placeholder=" ">
                    <label for="start_date" >Enter Start Date</label>
                        <div class="invalid-feedback error_msg start_date_err"></div>
                </div>
                <div class="col-md-6 form-floating" id="end_date_div">
                    <input type="text" class="form-control employee_input " id="end_date" name="end_date" placeholder=" ">
                    <label for="end_date" >Enter End Date</label>
                        <div class="invalid-feedback error_msg end_date_err"></div>
                </div>
    
                <div class="col-md-6 form-floating">
                    <select id="grade_id" name="grade_id" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Grade Name</option>
                        @foreach ($option as $val)
                            @if ($val->group_name=='Grade')
                            <option value="{{$val->id}}">{{$val->option_value}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="grade_id" >Select Grade *</label>
                    <div class="invalid-feedback error_msg grade_id_err">Employee Grade is required!</div>
                </div>
    
                <div class="col-md-6 form-floating">
                    <input type="number" class="form-control employee_input" id="present_salary" name="present_salary" placeholder=" " required>
                    <label for="present_salary" >Enter Present Salary *</label>
                        <div class="invalid-feedback error_msg present_salary_err">Present Salary is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="service_reference_id" name="service_reference_id" placeholder=" " required>
                    <label for="service_reference_id" >Enter Service Reference ID *</label>
                        <div class="invalid-feedback error_msg service_reference_id_err">Service Reference ID is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="gender" name="gender" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select>
                    <label for="gender" >Select Gender *</label>
                    <div class="invalid-feedback error_msg gender_err">Gender is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="date_of_birth" name="date_of_birth" placeholder=" " required>
                    <label for="date_of_birth" >Enter Date Of Birth *</label>
                        <div class="invalid-feedback error_msg date_of_birth_err">Date of Birth is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="marital_status" name="marital_status" placeholder=" " required>
                    <label for="marital_status" >Enter Marital Status *</label>
                        <div class="invalid-feedback error_msg marital_status_err">Marital Status is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="religion" name="religion" placeholder=" " required>
                    <label for="religion" >Enter Religion *</label>
                        <div class="invalid-feedback error_msg religion_err">Religion is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="number" class="form-control employee_input" id="national_id" name="national_id" placeholder=" " required>
                    <label for="national_id" >Enter National ID No. *</label>
                        <div class="invalid-feedback error_msg national_id_err">National ID No. is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="number" class="form-control employee_input" id="tin" name="tin" placeholder=" ">
                    <label for="tin" >Enter TIN no.</label>
                        <div class="invalid-feedback error_msg tin_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="nationality" name="nationality" placeholder=" " required>
                    <label for="nationality" >Enter Nationality *</label>
                        <div class="invalid-feedback error_msg nationality_err">Nationality is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="father_name" name="father_name" placeholder=" " required>
                    <label for="father_name" >Enter Father Name *</label>
                        <div class="invalid-feedback error_msg father_name_err">Father Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="mother_name" name="mother_name" placeholder=" " required>
                    <label for="mother_name" >Enter Mother Name *</label>
                        <div class="invalid-feedback error_msg mother_name_err">Mother Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="husband_wife_name" name="husband_wife_name" placeholder=" ">
                    <label for="husband_wife_name" >Enter Husband/Wife Name</label>
                        <div class="invalid-feedback error_msg husband_wife_name_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="blood_group" name="blood_group" placeholder=" " required>
                    <label for="blood_group" >Enter Blood Group *</label>
                        <div class="invalid-feedback error_msg blood_group_err">Blood Group is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="present_address" name="present_address" placeholder=" " required>
                    <label for="present_address" >Enter Present Address *</label>
                        <div class="invalid-feedback error_msg present_address_err">Present Address is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="permanent_address" name="permanent_address" placeholder=" " required>
                    <label for="permanent_address" >Enter Permanent Address *</label>
                        <div class="invalid-feedback error_msg permanent_address_err">Permanent Address is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="supervisor_name" name="supervisor_name" placeholder=" " required>
                    <label for="supervisor_name" >Enter Supervisor Name *</label>
                        <div class="invalid-feedback error_msg supervisor_name_err">Supervisor Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="manager_name" name="manager_name" placeholder=" " required>
                    <label for="manager_name" >Enter Manager Name *</label>
                        <div class="invalid-feedback error_msg manager_name_err">Manager Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control employee_input" id="joining_date" name="joining_date" placeholder=" " required>
                    <label for="joining_date" >Enter Joining Date *</label>
                        <div class="invalid-feedback error_msg joining_date_err">Joining Date is required!</div>
                </div>
                <div class="col-md-6">
                    <textarea class="form-control employee_input" id="reference_info" name="reference_info" placeholder="Enter employee reference info"></textarea>
                    <div class="invalid-feedback error_msg reference_info_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="under_service_type_packages" name="under_service_type_packages" class="form-select employee_input" required>
                        <option value="" selected disabled>Choose Under servise type packages</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                    <label for="under_service_type_packages" >Select Under Service Type Packages *</label>
                    <div class="invalid-feedback error_msg under_service_type_packages_err">Service Type Packages is equired!</div>
                </div>
            
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success edit_employee_submit">Update Employee</button>
        </form>
        </div>
        </div>
    </div>
</div>
    <h3 class="text-center">Employee Details</h3>
    <table id="employee_table" class="table table-striped table-bordered" style="width:98%">
        <thead class="employee_thead">
        </thead>
        <tbody class="employee_tbody">
        </tbody>
    </table>
</div>
</div>
@endsection

@section('script')
<script>

    $('#start_date_div').hide();
    $('#end_date_div').hide(); 

$(document).ready( function () {
    
    $( function() {
    $( "#date_of_birth" ).datepicker({ dateFormat: 'dd/mm/yy',
    beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
	        inst.dpDiv.css({ top: rect.top + 60, left: rect.left + 0 });
        }, 0);
    }
});
    $( "#joining_date" ).datepicker({dateFormat: 'dd/mm/yy',
    beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
	        inst.dpDiv.css({ top: rect.top -290, left: rect.left + 0 });
        }, 0);
    }
});
    $( "#start_date" ).datepicker({dateFormat: 'dd/mm/yy',
    beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
	        inst.dpDiv.css({ top: rect.top +60, left: rect.left + 0 });
        }, 0);
    }
});
    $( "#end_date" ).datepicker({dateFormat: 'dd/mm/yy',
    beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
	        inst.dpDiv.css({ top: rect.top +60, left: rect.left + 0 });
        }, 0);
    }
});

    } );



    $(document).on('change', "#start_date", function () {
        $('#joining_date').val($('#start_date').val());
    });

    $(document).on('change','#type_id', function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var id={
            id:$('#type_id').val()
        }
        $.ajax({
            type: "POST",
            data: id,
            url: "{{url('employee/findEmployeeType')}}",
            dataType: "json",
            success: function (response) {
                if (response.option_value.toLowerCase()=='probation') {
                    $('#start_date_div').show();
                    $('#end_date_div').show();  
                    $(document).on('change', "#joining_date", function () {
                        $('#start_date').val($('#joining_date').val());
                    });
                }else{
                    $('#start_date_div').hide();
                    $('#end_date_div').hide();
                }
            }
        });
        
    });

    
    $('.employee_tbody').html('');
    
    function fetchEmployeeTable() {
        
        $('.employee_thead').html(
            `<tr>\
                <th>Sl.</th>\
                <th>Employee ID</th>\
                <th>Employee Name</th>\
                <th>Employee Phone</th>\
                <th>Branch</th>\
                <th>Designation</th>\
                <th>Supervisor Name</th>\
                <th>Details</th>\
                <th>Status</th>\
                <th>Action</th>\
            </tr>`
        );
        $.ajax({
            type: "GET",
            url: "{{url('employee/fetchEmployeeTable')}}",
            dataType: "json",
            success: function (response) {
                $.each(response, function (key, val) { 
                    var status=''
                    var deleted=''
                    var disabled=''
                    var details_link='#'
                    var edit_btn=''
                    var del_btn=''
                    if (val.status==7) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input em-status" type="checkbox"  em_id="`+ val.id +`" checked>
                                    </div>`
                        edit_btn=val.id
                        del_btn=val.id
                        details_link=val.id
                    }else if (val.status==-7) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input em-status" type="checkbox" em_id="`+ val.id +`">
                                    </div>`
                        disabled='disabled'
                    }else if (val.status==-1) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input em-status" type="checkbox" disabled>
                                    </div>`
                        deleted='table-danger'
                        disabled='disabled'
                    }
                    if (val.start_date==null) {
                        val.start_date='-'
                    }
                    if (val.end_date==null) {
                        val.end_date='-'
                    }
                    if (val.reference_info==null) {
                        val.reference_info='-'
                    }
                    $('.employee_tbody').append(
                        `<tr class="`+deleted+`">\
                            <td>`+ ++key +`</td>\
                            <td>`+ val.employee_id +`</td>\
                            <td>`+ val.employee_name +`</td>\
                            <td>`+ val.employee_phone +`</td>\
                            <td>`+ val.branch_id +`</td>\
                            <td>`+ val.designation_id +`</td>\
                            <td>`+ val.supervisor_name +`</td>\
                            <td> <a href="{{url('employee')}}/`+details_link+`" class="btn btn-outline-secondary btn-sm `+ disabled +`">Details</a> </td>\
                            <td>`+ status +`</td>\
                            <td>\
                                <button class="btn btn-sm btn-success `+ disabled +` me-1 mt-1 edit_modal_btn" em_id="`+ edit_btn +`" title="Edit"><i class="fa-solid fa-file-pen"></i></button>\
                                <button class="btn btn-sm btn-danger `+ disabled +` mt-1 del_btn" em_id="`+ del_btn +`" title="Delete"><i class="fa-solid fa-trash-can"></i></button>\
                            </td>\
                        </tr>`
                    );
                });
                
                // $('#employee_table').DataTable( {
                //     responsive: true,
                //     retrieve: true,
                    // "scrollX": true
                // });
            }
        });
    }

    // fatch table data function
    fetchEmployeeTable();

    $(document).on('change','.em-status', function () {
        if($(this).is(':checked')){
            var data={
                id:$(this).attr("em_id"),
                status:'active'
            }
        }else{
            var data={
                id:$(this).attr("em_id"),
                status:'inactive',
            }
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "POST",
            url: "{{url('employee/statusSwitch')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.status=='active') {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                }else{
                    Toast.fire({
                        icon: 'warning',
                        title: response.message
                    })
                }
            }
        });
    });


    $(document).on("click",".edit_modal_btn", function () {
        var em_id= $(this).attr("em_id");
        $(".edit_employee_submit").attr("em_id",em_id);
        $.ajax({
            type: "GET",
            url: "{{url('employee')}}"+'/'+em_id+"/edit",
            dataType: "json",
            success: function (response) {
            $('#employee_id').val(response.employee_id)
            $('#employee_name').val(response.employee_name)
            $('#employee_phone').val(response.employee_phone)
            $('#employee_email').val(response.employee_email)
            $('#vendor_id').val(response.vendor_id)
            $('#branch_id').val(response.branch_id)
            $('#region_id').val(response.region_id)
            $('#division_id').val(response.division_id)
            $('#department_id').val(response.department_id)
            $('#designation_id').val(response.designation_id)
            $('#shift_id').val(response.shift_id)
            $('#type_id').val(response.type_id)
            $('#start_date').val(response.start_date)
            $('#end_date').val(response.end_date)
            $('#grade_id').val(response.grade_id)
            $('#present_salary').val(response.present_salary)
            $('#service_reference_id').val(response.service_reference_id)
            $('#gender').val(response.gender)
            $('#date_of_birth').val(response.date_of_birth)
            $('#marital_status').val(response.marital_status)
            $('#religion').val(response.religion)
            $('#national_id').val(response.national_id)
            $('#tin').val(response.tin)
            $('#reference_info').val(response.reference_info)
            $('#under_service_type_packages').val(response.under_service_type_packages)
            $('#nationality').val(response.nationality)
            $('#father_name').val(response.father_name)
            $('#mother_name').val(response.mother_name)
            $('#husband_wife_name').val(response.husband_wife_name)
            $('#blood_group').val(response.blood_group)
            $('#present_address').val(response.present_address)
            $('#permanent_address').val(response.permanent_address)
            $('#supervisor_name').val(response.supervisor_name)
            $('#manager_name').val(response.manager_name)
            $('#joining_date').val(response.joining_date)

                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                var id={
                    id:response.type_id
                }
                $.ajax({
                type: "POST",
                data: id,
                url: "{{url('employee/findEmployeeType')}}",
                dataType: "json",
                success: function (response) {
                    if (response.option_value.toLowerCase()=='probation') {
                        $('#start_date_div').show();
                        $('#end_date_div').show();
                    }else{
                        $('#start_date_div').hide();
                        $('#end_date_div').hide(); 
                    }
                }
                });
            }
        });
        
        $('#employee_edit').modal("show");

        
    });

    $(document).on('submit','.edit_employee_form', function (e) {
        e.preventDefault();
        var em_id= $('.edit_employee_submit').attr("em_id");
        $('.edit_employee_submit').attr('disabled',true).text('Sending Data...');
        var data={
            'employee_id': $('#employee_id').val(),
            'employee_name': $('#employee_name').val(),
            'employee_phone': $('#employee_phone').val(),
            'employee_email': $('#employee_email').val(),
            'vendor_id': $('#vendor_id').val(),
            'branch_id': $('#branch_id').val(),
            'region_id': $('#region_id').val(),
            'division_id': $('#division_id').val(),
            'department_id': $('#department_id').val(),
            'designation_id': $('#designation_id').val(),
            'shift_id': $('#shift_id').val(),
            'type_id': $('#type_id').val(),
            'start_date': $('#start_date').val(),
            'end_date': $('#end_date').val(),
            'grade_id': $('#grade_id').val(),
            'present_salary': $('#present_salary').val(),
            'service_reference_id': $('#service_reference_id').val(),
            'gender': $('#gender').val(),
            'date_of_birth': $('#date_of_birth').val(),
            'marital_status': $('#marital_status').val(),
            'religion': $('#religion').val(),
            'national_id': $('#national_id').val(),
            'tin': $('#tin').val(),
            'reference_info': $('#reference_info').val(),
            'under_service_type_packages': $('#under_service_type_packages').val(),
            'nationality': $('#nationality').val(),
            'father_name': $('#father_name').val(),
            'mother_name': $('#mother_name').val(),
            'husband_wife_name': $('#husband_wife_name').val(),
            'blood_group': $('#blood_group').val(),
            'present_address': $('#present_address').val(),
            'permanent_address': $('#permanent_address').val(),
            'supervisor_name': $('#supervisor_name').val(),
            'manager_name': $('#manager_name').val(),
            'joining_date': $('#joining_date').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            
        $.ajax({
            type: "PUT",
            url: "{{url('employee')}}"+'/'+em_id,
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.status==400) {
                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".employee_input").removeClass('is-invalid');
                    for (let key in response.errors) {
                        $('.'+key+'_err').removeClass("d-none").addClass("d-block").text(response.errors[key]);
                        $('#'+key).addClass("is-invalid");
                    }
                    $('.edit_employee_submit').attr('disabled',false).text('Update Employee');
                }else{
                    $('#employee_table').DataTable().clear().destroy();
                    $('.employee_tbody').html('');
                    // fatch table data function
                    fetchEmployeeTable();

                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".employee_input").removeClass('is-invalid');
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                    
                    $('.edit_employee_submit').attr('disabled',false).text('Update Employee');
                    $(".edit_employee_form").trigger("reset");
                    $(".edit_employee_form").removeClass('was-validated');
                    $('#employee_edit').modal("hide");
                    
                }
            }
        });
    });

    $(document).on('click',".del_btn", function () {
        var em_id=$(this).attr('em_id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This employee will be deleted!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e6e6e',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
                $.ajax({
                    type: "DELETE",
                    url: "{{url('employee')}}"+'/'+em_id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status==200) {
                            $('#employee_table').DataTable().clear().destroy();
                            $('.employee_tbody').html('');
                            fetchEmployeeTable();
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            })
                        }else{
                            Toast.fire({
                                icon: 'warning',
                                title: response.message
                            })
                        }
                    }
                });
                
            }
            })
    });
});
</script>
@endsection