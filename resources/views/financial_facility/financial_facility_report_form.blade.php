@extends('layouts.app',['title' => 'Financial Facility Report'])

@section('style')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
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
        <form class="row g-3 needs-validation financial_facility_form" action="{{url('financialFacilityGenerateReport')}}" method="POST">
            @csrf
            <h3 class="text-center">Generate Report</h3>
            <div class="col-md-6 form-floating">
                <select id="facility_type" name="facility_type" class="form-select financial_facility">
                    <option selected disabled>Choose Facility Type</option>
                    @foreach ($facility_type as $val)
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                    @endforeach
                </select>
                <label for="facility_type" >Select Facility Type</label>
                @error('facility_type')
                <script>
                    $("#facility_type").addClass('is-invalid');
                </script>
                <div class="invalid-feedback d-block error_msg facility_type_err">{{$message}}</div>
                @enderror
                
            </div>
            <div class="col-md-6 form-floating">
                <select id="vendor_id" name="vendor_id[]" class="form-select financial_facility" multiple="multiple">
                        <option value="all">All</option>
                    @foreach ($vendor as $val)
                        <option value="{{$val->id}}">{{$val->vendor_name}}</option>
                    @endforeach
                </select>
                <label for="vendor_id" >Select Vendor</label>
                @error('vendor_id')
                <script>
                    $("#vendor_id").addClass('is-invalid');
                </script>
                <div class="invalid-feedback d-block error_msg vendor_id_err">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 form-floating">
                <select id="branch_type" name="branch_type" class="form-select financial_facility">
                    <option selected disabled>Choose Branch Type</option>
                        <option value="all">All</option>
                        <option value="Main-Branch">Main-Branch</option>
                        <option value="Branch">Branch</option>
                        <option value="Sub-Branch">Sub-Branch</option>
                        <option value="SME">SME</option>
                </select>
                <label for="branch_type" >Select Branch Type</label>
                @error('branch_type')
                <script>
                    $("#branch_type").addClass('is-invalid');
                </script>
                <div class="invalid-feedback d-block error_msg branch_type_err">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 form-floating">
                <select id="branch_id" name="branch_id[]" class="form-select financial_facility" multiple='multiple'>
                    <option value="all">All</option>
                </select>
                <label for="branch_id" >Select Branch</label>
                @error('branch_id')
                <script>
                    $("#branch_id").addClass('is-invalid');
                </script>
                <div class="invalid-feedback d-block error_msg branch_id_err">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control financial_facility" id="month" name="month" placeholder=" ">
                <label for="month" >Enter Month</label>
                @error('month')
                <script>
                    $("#month").addClass('is-invalid');
                </script>
                <div class="invalid-feedback d-block error_msg month_err">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-6"></div>
            <div class="d-grid col-12 mx-auto justify-content-md-center">
                <button type="submit" class="w-100 btn btn-success financial_facility_submit">Generate Report</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('#vendor_id').select2();
    $('#branch_id').select2();
    $( "#month" ).datepicker({dateFormat: 'mm/yy'});

    $(document).on('change','#branch_type', function () {
        var data={
            branch_type:$('#branch_type').val(),
        }
        $.ajax({
            type: "GET",
            url: "{{url('financialFacilityReportGetBranch')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                var options='<option value="all">All</option>';
                for (let key in response.data) {
                        options+=`<option value="`+ response.data[key].id +`">`+ response.data[key].branch_name +`</option>`
                    }
                $('#branch_id').html(options);
            }
        });
    });




    // $(document).on('click','.financial_facility_submit', function (e) {
        
    //     e.preventDefault();
    //     $('.financial_facility_submit').attr('disabled',true).text('Sending Data...');
    //     var data={
    //         'facility_type': $('#facility_type').val(),
    //         'vendor_id': $('#vendor_id').val(),
    //         'branch_type': $('#branch_type').val(),
    //         'branch_id': $('#branch_id').val(),
    //         'month': $('#month').val()
    //     }
    //     $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //     $.ajax({
    //         type: "POST",
    //         url: "{{url('financialFacilityGenerateReport')}}",
    //         data: data,
    //         dataType: "json",
    //         success: function (response) {
    //             if (response.status==400) {
    //                 $(".error_msg").removeClass("d-block");
    //                 $(".error_msg").addClass("d-none");
    //                 $(".financial_facility").removeClass('is-invalid');

    //                 Toast.fire({
    //                     icon: 'error',
    //                     title: "Validation Error!"
    //                 })
    //                 for (let key in response.errors) {
    //                     $('.'+key+'_err').removeClass("d-none").addClass("d-block").text(response.errors[key]);
    //                     $('#'+key).addClass("is-invalid");
    //                 }
    //                 $('.financial_facility_submit').attr('disabled',false).text('Generate Report');
    //             }else{
    //                 $(".error_msg").removeClass("d-block");
    //                 $(".error_msg").addClass("d-none");
    //                 $(".financial_facility").removeClass('is-invalid');
    //                 Toast.fire({
    //                     icon: 'success',
    //                     title: response.message
    //                 })
    //                 $('.financial_facility_submit').attr('disabled',false).text('Generate Report');
    //                 $(".financial_facility_form").trigger("reset");
    //             }
    //         }
    //     });
    // });
});
</script>
@endsection