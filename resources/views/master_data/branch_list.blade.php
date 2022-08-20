@extends('layouts.app',['title' => 'Manage Branch'])

@section('content')
<div class="container">
<div class="row justify-content-center">

<!-- Modal -->
<div class="modal fade" id="branch_edit" tabindex="-1" aria-labelledby="branch_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="branch_edit_title">Edit Branch</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3 needs-validation edit_branch_form" >
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
            
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success edit_branch_submit">Update Branch</button>
        </form>
        </div>
        </div>
    </div>
</div>
    <h3 class="text-center">Branch Details</h3>
    <table id="branch_table" class="table table-striped table-bordered" style="width:98%">
        <thead class="branch_thead">
        </thead>
        <tbody class="branch_tbody">
        </tbody>
    </table>
</div>
</div>
@endsection

@section('script')
<script>
$(document).ready( function () {
    $('.branch_tbody').html('');
    function fetchBranchTable() {
        $('.branch_thead').html(
            `<tr>\
                <th>Sl.</th>\
                <th>Branch Name</th>\
                <th>Branch Code</th>\
                <th>Branch Type</th>\
                <th>Address</th>\
                <th>Status</th>\
                <th>Action</th>\
            </tr>`
        );
        $.ajax({
            type: "GET",
            url: "{{url('branch/fetchBranchTable')}}",
            dataType: "json",
            success: function (response) {
                $.each(response, function (key, val) { 
                    var status=''
                    var deleted=''
                    var disabled=''
                    var edit_btn=''
                    var del_btn=''
                    if (val.status==7) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input br-status" type="checkbox"  br_id="`+ val.id +`" checked>
                                    </div>`
                    }else if (val.status==-7) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input br-status" type="checkbox" br_id="`+ val.id +`">
                                    </div>`
                    }else if (val.status==-1) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input br-status" type="checkbox" disabled>
                                    </div>`
                    }
                    
                    if (val.status == -1) {
                        deleted='table-danger'
                        disabled='disabled'
                    } else {
                        deleted=''
                        disabled=''
                        edit_btn=val.id
                        del_btn=val.id
                    }
                    $('.branch_tbody').append(
                        `<tr class="`+ deleted +`">\
                            <td>`+ ++key +`</td>\
                            <td>`+ val.branch_name +`</td>\
                            <td>`+ val.branch_code +`</td>\
                            <td>`+ val.branch_type +`</td>\
                            <td>`+ val.address +`</td>\
                            <td>`+ status +`</td>\
                            <td>\
                                <button class="btn btn-sm btn-success `+disabled+` me-1 mt-1 edit_modal_btn" br_id="`+ edit_btn +`" title="Edit"><i class="fa-solid fa-file-pen"></i></button>\
                                <button class="btn btn-sm btn-danger `+disabled+` mt-1 del_btn" br_id="`+ del_btn +`" title="Delete"><i class="fa-solid fa-trash-can"></i></button>\
                            </td>\
                        </tr>`
                    );
                });
                
                // $('#branch_table').DataTable( {
                //     responsive: true,
                //     retrieve: true,
                    // "scrollX": true
                // });
            }
        });
    }

    // fatch table data function
    fetchBranchTable();
    

    $(document).on('change','.br-status', function () {
        if($(this).is(':checked')){
            var data={
                id:$(this).attr("br_id"),
                status:'active'
            }
        }else{
            var data={
                id:$(this).attr("br_id"),
                status:'inactive',
            }
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "POST",
            url: "{{url('branch/statusSwitch')}}",
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


    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
        })
    })()

    $(document).on("click",".edit_modal_btn", function () {
        var br_id= $(this).attr("br_id");
        $(".edit_branch_submit").attr("br_id",br_id);
        $.ajax({
            type: "GET",
            url: "{{url('branch')}}"+'/'+br_id+"/edit",
            dataType: "json",
            success: function (response) {
            $('#branch_name').val(response.branch_name)
            $('#branch_code').val(response.branch_code)
            $('#branch_type').val(response.branch_type)
            $('#address').val(response.address)
            }
        });
        
        $('#branch_edit').modal("show");
    });

    $(document).on('submit','.edit_branch_form', function (e) {
        e.preventDefault();
        var br_id= $('.edit_branch_submit').attr("br_id");
        $('.edit_branch_submit').attr('disabled',true).text('Sending Data...');
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
            type: "PUT",
            url: "{{url('branch')}}"+'/'+br_id,
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
                    $('.edit_branch_submit').attr('disabled',false).text('Update branch');
                }else{
                    $('#branch_table').DataTable().clear().destroy();
                    $('.branch_tbody').html('');
                    // fatch table data function
                    fetchBranchTable();

                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".branch_input").removeClass('is-invalid');
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                    
                    $('.edit_branch_submit').attr('disabled',false).text('Update branch');
                    $(".edit_branch_form").trigger("reset");
                    $(".edit_branch_form").removeClass('was-validated');
                    $('#branch_edit').modal("hide");
                    
                }
            }
        });
    });

    $(document).on('click',".del_btn", function () {
        var br_id=$(this).attr('br_id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This branch will be deleted!",
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
                    url: "{{url('branch')}}"+'/'+br_id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status==200) {
                            $('#branch_table').DataTable().clear().destroy();
                            $('.branch_tbody').html('');
                            fetchBranchTable();
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