@extends('layouts.app',['title' => 'Manage Employee'])

@section('style')
<style>
    .has-search .form-control {
        padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
</style>
@endsection

@section('content')
<div class="container">
<div class="row justify-content-center">
<!-- Modal -->
<div class="modal fade" id="employee_edit" tabindex="-1" aria-labelledby="employee_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        @include('master_data.employee.edit')
    </div>
</div>
<form action="" method="GET">
    @csrf
    <div class="row">

        <div class="col-md-2 col-sm-12 px-1">
            <div class="input-group">
                <select class="form-select" name="search_branch" id="search_branch"
                    aria-label="Example select with button addon">
                    <option value="">Select Branch</option>
                    @foreach ($branch as $val)
                        <option value="{{$val->id}}"
                        {{ request()->get('search_branch') == $val->id ? 'selected' : '' }}>
                        {{$val->branch_name}}</option>
                    @endforeach
                    
                </select>
                {{-- <button class="btn btn-outline-secondary" type="button"> <i class="fa fa-search"></i> Search</button> --}}
            </div>

        </div>
        <div class="col-md-2 col-sm-12 px-1">
            <div class="input-group">
                <select class="form-select" name="search_vendor" id="search_vendor"
                    aria-label="Example select with button addon">
                    <option value="">Select Vendor</option>
                    @foreach ($vendor as $val)
                        <option value="{{$val->id}}"
                        {{ request()->get('search_vendor') == $val->id ? 'selected' : '' }}>
                        {{$val->vendor_name}}</option>
                    @endforeach
                    
                </select>
                {{-- <button class="btn btn-outline-secondary" type="button"> <i class="fa fa-search"></i> Search</button> --}}
            </div>

        </div>
        <div class="col-md-2 col-sm-12">
            <select name="search_status" class="form-select" id="search_status">
                <option value="">Select Status</option>
                <option value="7" {{ request()->get('search_status') == '7' ? 'selected' : '' }}>Active
                </option>
                <option value="-7" {{ request()->get('search_status') == '-7' ? 'selected' : '' }}>Inactive
                </option>
            </select>
        </div>
        <div class="col-md-4 col-sm-12 px-1">
            <div class="input-group">
                <input type="text" name="search_text" value="{{ request()->get('search_text') }}"
                    class="form-control" placeholder="Search by text">
                <div class="input-group-append">
                    <button class="btn btn-secondary me-2" name="submit_btn" type="submit" value="search">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <button class="btn btn-xs btn-outline-secondary float-end" name="submit_btn" value="export"
                    type="submit">
                    <i class="fa-solid fa-download"></i> Export
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-12">                  
            <a href="{{ route('employee.create') }}"  class="btn btn-xs btn-outline-success float-end" name="create_new" 
                type="button">
                <i class="fa-solid fa-plus"></i> Create New
            </a>
        </div>

    </div>
</form>
</div>
<div class="row justify-content-center px-1">
    <table id="employee_table" class="table table-striped" style="width:100%">
        <thead class="employee_thead">
            <tr>
                <th>Sl.</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Employee Phone</th>
                <th>Branch</th>
                <th>Designation</th>
                <th>Supervisor Name</th>
                <th>Details</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="employee_tbody">
            @foreach ($employees as $index => $val)
            <tr class="{{ $val->status == -1 ? 'table-danger' : '' }}">
                <td>{{ $index + $employees->firstItem() }}</td>
                <td>{{ $val->employee_id }}</td>
                <td>{{ $val->employee_name }}</td>
                <td>{{ $val->employee_phone }}</td>
                <td>{{ $val->branch->branch_name }}</td>
                <td>{{ $val->designation->option_value }}</td>
                <td>{{ $val->supervisor_name }}</td>
                <td class="text-center"><a href="{{url('employee',Crypt::encryptString($val->id))}}" class="btn btn-outline-secondary btn-sm {{ $val->status == -1 ? 'disabled' : '' }}">Details</a></td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input active_inactive_btn " status="{{ $val->status }}"
                            {{ $val->status == -1 ? 'disabled' : '' }} table="employees" type="checkbox"
                            id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}"
                            {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                    </div>
                </td>
                <td>
                    <button class="btn btn-sm btn-success me-1 mt-1 edit_modal_btn"
                        id="edit_btn_row_{{ $val->id }}" em_id="{{ Crypt::encryptString($val->id) }}"
                        {{ $val->status == -7 || $val->status == -1 ? 'disabled' : '' }} title="Edit"><i
                            class="fa-solid fa-file-pen"></i></button>
                    <button class="btn btn-sm btn-danger mt-1 del_btn" em_id="{{ Crypt::encryptString($val->id) }}"
                        title="Delete" {{ $val->status == -1 ? 'disabled' : '' }}><i
                            class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
            @endforeach
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
                    location.reload();
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
                            location.reload();
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