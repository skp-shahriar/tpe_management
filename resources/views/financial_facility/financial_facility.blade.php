@extends('layouts.app',['title' => 'Financial Facility Management'])
@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container{
        width: 100% !important;
    }
    .select2-container .select2-selection--multiple{
        padding-top: 20px !important;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3 class="text-center">Add Financial Facility</h3>
        <form class="row g-3 needs-validation add_financial_facility_form" method="POST">
            <div class="col-md-6 form-floating">
                <select id="facility_type" name="facility_type" class="form-select financial_facility">
                    <option selected disabled>Choose Facility Type</option>
                    @foreach ($facility_type as $val)
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                    @endforeach
                </select>
                <label for="facility_type" >Select Facility Type</label>
                <div class="invalid-feedback error_msg facility_type_err"></div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="process_type" name="process_type" class="form-select financial_facility">
                    <option selected disabled>Choose Process Type</option>
                        <option value="all">All Employee</option>
                        <option value="vendor">Selective Vendor</option>
                        <option value="employee">Selective Employees</option>
                        <option value="branch">Selective Branches</option>
                        <option value="department">Selective Department</option>
                </select>
                <label for="process_type" >Select Process Type</label>
                <div class="invalid-feedback error_msg process_type_err"></div>
            </div>
            <div class="col-md-6 form-floating selective_value">
                <select id="selective_value" name="selective_value[]" class="form-select financial_facility" multiple="multiple">
                    
                </select>
                <label for="selective_value" >Select Multiple</label>
                <div class="invalid-feedback error_msg selective_value_err"></div>
            </div>

            <div class="col-md-6 form-floating">
                <input type="text" class="form-control financial_facility" id="applicable_month" name="applicable_month" placeholder=" ">
                <label for="applicable_month" >Enter Applicable Month</label>
                    <div class="invalid-feedback error_msg applicable_month_err"></div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="continue" name="continue" id="continue" >
                    <label class="form-check-label" for="continue">
                    Continue
                    </label>
                </div>
            </div>
            <div class="col-md-6 form-floating end_month">
                <input type="text" class="form-control financial_facility" id="end_month" name="end_month" placeholder=" ">
                <label for="end_month" >Enter End Month</label>
                    <div class="invalid-feedback error_msg end_month_err"></div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="amount_type" name="amount_type" class="form-select financial_facility">
                    <option selected disabled>Choose Amount Type</option>
                        <option value="fixed">Fixed Amount</option>
                        <option value="percentage">Percentage Amount</option>
                </select>
                <label for="amount_type" >Select Amount Type</label>
                <div class="invalid-feedback error_msg amount_type_err"></div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="number" class="form-control financial_facility" id="amount" name="amount" placeholder=" ">
                <label for="amount" >Enter Amount</label>
                    <div class="invalid-feedback error_msg amount_err"></div>
            </div>

            <div class="col-md-6"></div>
            <div class="d-grid col-12 mx-auto justify-content-md-center">
                <button type="submit" class="w-100 btn btn-success add_financial_facility_submit">Add Facility</button>
            </div>
        </form>

    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$( "#applicable_month" ).datepicker({dateFormat: 'mm/yy'});
$( "#end_month" ).datepicker({dateFormat: 'mm/yy'});
$('.selective_value').hide();
$('.end_month').hide();
$('#selective_value').select2();


$(document).ready(function () {

    $(document).on('change','#process_type', function () {
        var process_type=$('#process_type').val()
        var data={
            process_type: process_type
        }
        $.ajaxSetup({  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "GET",
            url: "{{url('getSelectiveValue')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                var options='';
                if (process_type=='vendor') {
                    for (let key in response) {
                        options+=`<option value="`+ response[key].id +`">`+ response[key].vendor_name +`</option>`
                    }
                }else if (process_type=='employee') {
                    for (let key in response) {
                        options+=`<option value="`+ response[key].id +`">`+ response[key].employee_id +` - `+ response[key].employee_name +`</option>`
                    }
                }else if (process_type=='branch') {
                    for (let key in response) {
                        options+=`<option value="`+ response[key].id +`">`+ response[key].branch_name +`</option>`
                    }
                }else if (process_type=='department') {
                    for (let key in response) {
                        options+=`<option value="`+ response[key].id +`">`+ response[key].option_value +`</option>`
                    }
                }
                $('#selective_value').html(options);
                if (process_type=='all') {
                    $('.selective_value').hide();
                }else{
                    $('.selective_value').show();
                }
                
            }
        });
    });

    $(document).on('change','#continue', function () {
        if ($('#continue').is(":checked")){
            $('.end_month').show();
        }else{
            $('#end_month').val('');
            $('.end_month').hide();
        }
    });

    $(document).on('click','.add_financial_facility_submit', function (e) {
        
        e.preventDefault();
        $('.add_financial_facility_submit').attr('disabled',true).text('Sending Data...');
        var data={
            'facility_type': $('#facility_type').val(),
            'process_type': $('#process_type').val(),
            'selective_value': $('#selective_value').val(),
            'applicable_month': $('#applicable_month').val(),
            'end_month': $('#end_month').val(),
            'amount_type': $('#amount_type').val(),
            'amount': $('#amount').val(),
        }
        if ($('#continue').is(":checked")){
            data.continue= $('#continue').val()
        }else{
            data.continue= ''
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            type: "POST",
            url: "{{url('addFinancialFacility')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.status==400) {
                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".financial_facility").removeClass('is-invalid');

                    Toast.fire({
                        icon: 'error',
                        title: "Validation Error!"
                    })
                    for (let key in response.errors) {
                        $('.'+key+'_err').removeClass("d-none").addClass("d-block").text(response.errors[key]);
                        $('#'+key).addClass("is-invalid");
                    }
                    $('.add_financial_facility_submit').attr('disabled',false).text('Add Facility');
                }else{
                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".financial_facility").removeClass('is-invalid');
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                    $('.add_financial_facility_submit').attr('disabled',false).text('Add Facility');
                    $(".add_financial_facility").trigger("reset");
                }
            }
        });
    });
});
</script>
@endsection