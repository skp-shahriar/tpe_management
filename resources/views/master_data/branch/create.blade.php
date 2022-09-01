@extends('layouts.app',['title' => 'Create Branch'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3 class="text-center">Add Branch details</h3>
        <form class="row g-3 needs-validation add_branch_form" method="POST" novalidate>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control branch_input" id="branch_name" name="branch_name" placeholder=" " required>
                <label for="branch_name" >Enter Branch Name *</label>
                    <div class="invalid-feedback error_msg branch_name_err">Branch name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="branch_type" name="branch_type" class="form-select branch_input" required>
                    <option value="" disabled selected>Choose Type</option>
                    <option value="Main-Branch">Main-branch</option>
                    <option value="Branch">Branch</option>
                    <option value="Sub-Branch">Sub-branch</option>
                    <option value="SME">SME</option>
                </select>
                <label for="branch_type" >Select Branch Type *</label>
                <div class="invalid-feedback error_msg branch_type_err">Branch type is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control branch_input" id="branch_code" name="branch_code" placeholder=" " required>
                <label for="branch_code" >Enter Branch Code *</label>
                    <div class="invalid-feedback error_msg branch_code_err">Branch code is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control branch_input" id="address" name="address" placeholder=" " required>
                <label for="address" >Enter Address *</label>
                <div class="invalid-feedback error_msg address_err">Branch address is required!</div>
            </div>

            <div class="d-grid col-12 mx-auto justify-content-md-center">
                <button type="submit" class="w-100 btn btn-success add_branch_submit">Add branch</button>
            </div>
        </form>

    </div>
</div>
@endsection

@section('script')
<script>

$(document).ready(function () {

    $(document).on('submit','.add_branch_form', function (e) {
        
        e.preventDefault();
        $('.add_branch_submit').attr('disabled',true).text('Sending Data...');
        var data={
            'branch_name': $('#branch_name').val(),
            'branch_code': $('#branch_code').val(),
            'branch_type': $('#branch_type').val(),
            'address': $('#address').val(),
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            type: "POST",
            url: "{{route('branch.store')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.status==400) {
                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".branch_input").removeClass('is-invalid');

                    Toast.fire({
                        icon: 'error',
                        title: "Validation Error!"
                    })
                    for (let key in response.errors) {
                        $('.'+key+'_err').removeClass("d-none").addClass("d-block").text(response.errors[key]);
                        $('#'+key).addClass("is-invalid");
                    }
                    $('.add_branch_submit').attr('disabled',false).text('Add Branch');
                }else{
                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".branch_input").removeClass('is-invalid');
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                    $('.add_branch_submit').attr('disabled',false).text('Add Branch');
                    $(".add_branch_form").trigger("reset");
                    $(".add_branch_form").removeClass('was-validated');
                }
            }
        });
    });
});
</script>
@endsection