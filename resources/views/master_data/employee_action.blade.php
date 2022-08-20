@extends('layouts.app',['title' => 'Employee Action'])

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--single{
    height: 55px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 70px;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3 class="text-center">Change Employee Data</h3>
        <form class="row g-3 needs-validation employee_history_form" method="POST" novalidate>
            <div class="col-md-6 form-floating">
                <select id="employee_id" name="employee_id" class="form-select employee_history" required>
                    <option selected disabled>Choose Employee</option>
                    @foreach ($employee as $val)
                        <option value="{{$val->id}}">{{$val->employee_id}} - {{$val->employee_name}}</option>
                    @endforeach
                </select>
                <label for="employee_id" >Select Employee *</label>
                <div class="invalid-feedback error_msg employee_id_err">Employee is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="action" name="action" class="form-select employee_history" req>
                    <option value="" selected disabled>Select Action</option>
                        <option value="branch_id">Change Branch</option>
                        <option value="employee_type_id">Change Employee Type</option>
                        <option value="designation_id">Change Designation</option>
                        <option value="department_id">Change Department</option>
                        <option value="grade_id">Change Employee Grade</option>
                        {{-- <option value="present_salary">Change Salary</option> --}}
                </select>
                <label for="action" >Select Action *</label>
                <div class="invalid-feedback error_msg action">Action is required!</div>
            </div>
            {{-- <div class="col-md-6 form-floating salary">
                <input type="text" class="form-control employee_history" id="salary" name="salary" placeholder=" ">
                <label for="salary" >Enter Salary</label>
                    <div class="invalid-feedback error_msg salary_err"></div>
            </div> --}}
            <div class="col-md-6 form-floating action_value">
                <select id="action_value" name="action_value" class="form-select employee_history" required>
                    <option value="" selected disabled>Select Action Value</option>
                </select>
                <label for="action_value" >Select Action Value *</label>
                <div class="invalid-feedback error_msg action_value">Action Value is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="action_date" name="action_date" placeholder=" " required>
                <label for="action_date" >Enter Action Date *</label>
                    <div class="invalid-feedback error_msg action_date_err">Action Date is required!</div>
            </div>

            <div class="col-md-6">

            </div>
            <div class="d-grid col-12 mx-auto justify-content-md-center">
                <button type="submit" class="w-100 btn btn-success employee_history_submit">Save Changes</button>
            </div>
        </form>

    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // searchable Dropdown
    $('#employee_id').select2();

    $( "#action_date" ).datepicker({dateFormat: 'dd/mm/yy'});
    $('#action_date').datepicker('setDate', 'today');
    // $('.salary').hide();
    $('.action_value').hide();
    $('#action').attr('disabled', true);
    $('.employee_history_submit').attr('disabled', true);
    $('.employee_history_submit').val('Select Employee & Action');

    $(document).on('change','#employee_id', function () {
        $('#action').removeAttr('disabled').val('');
        $('.action_value').hide();
    });

    $(document).on('change','#action', function () {
        var employee_id=$('#employee_id').val();
        var action=$('#action').val();

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        var data={
            id:$('#employee_id').val(),
            action:$('#action').val()
        }
        $.ajax({
            type: "POST",
            url: "{{route('currentValue')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                $('.employee_history_submit').attr('disabled', false);
                $('.employee_history_submit').val('Save Changes');
                // if (action=='present_salary') {
                //     $('.salary').show();
                //     $('.action_value').hide();
                //     $('#salary').val(response.current_value.present_salary);
                    
                // }else{
                    var options='<option value="" selected disabled>Select Action Value</option>';
                    if (action=='branch_id') {
                        for (let key in response.action_value) {
                            options+=`<option value="`+ response.action_value[key].id +`">`+ response.action_value[key].branch_name +`</option>`
                        }
                    }else{
                        for (let key in response.action_value) {
                            options+=`<option value="`+ response.action_value[key].id +`">`+ response.action_value[key].option_value +`</option>`
                        }
                    }
                    $("#action_value").html(options);
                    var action_current_val=Object.values(response.current_value)[0];
                    $("#action_value").val(action_current_val);

                    $('.action_value').show();
                    // $('.salary').hide();
                // }
            }
        });
    });


    $(document).on('submit','.employee_history_form', function () {
        $('.employee_history_submit').attr('disabled', true);
        $('.employee_history_submit').val('Saving Changes...');

        var data={
            employee_id:$('#employee_id').val(),
            action:$('#action').val(),
            action_value:$('#action_value').val(),
            // salary:$('#salary').val(),
            action_date:$('#action_date').val(),
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "POST",
            url: "{{route('empHistory')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                $('.employee_history_submit').attr('disabled', true);
                $('.employee_history_submit').val('Select Employee & Action');
                $('.action_value').hide().val();
                $('#employee_id').val();
                $('#action').attr('disabled', true).val();
                Toast.fire({
                        icon: 'success',
                        title: "Changes Saved!"
                    })
            }
        });
    });
});

</script>
@endsection