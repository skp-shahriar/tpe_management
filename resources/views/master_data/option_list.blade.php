@extends('layouts.app',['title' => 'Manage Option'])

@section('content')
<div class="container">
<div class="row justify-content-center">

<!-- Modal -->
<div class="modal fade" id="option_edit" tabindex="-1" aria-labelledby="option_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="option_edit_title">Edit Option</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3 needs-validation edit_option_form" novalidate>
                <div class="col-md-6 form-floating">
                    <select id="group_name" name="group_name" class="form-select option_input" required>
                        <option value="" selected disabled>Select Group Name</option>
                        <option value="Department">Department</option>
                        <option value="Designation">Designation</option>
                        <option value="Region">Region</option>
                        <option value="Division">Division</option>
                        <option value="Shift">Shift</option>
                        <option value="Type">Employee Type</option>
                        <option value="Grade">Grade</option>
                        <option value="service_type">Service Type</option>
                        <option value="facility_type">Facility Type</option>
                    </select>
                    <label for="group_name" >Add Group Name *</label>
                    <div class="invalid-feedback error_msg group_name_err">Group Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control option_input" id="option_value" name="option_value" placeholder=" " required>
                    <label for="option_value" >Enter Option Value *</label>
                        <div class="invalid-feedback error_msg option_value_err">Option Value is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control option_input" id="option_value2" name="option_value2" placeholder=" ">
                    <label for="option_value2" >Enter Option Value 2</label>
                        <div class="invalid-feedback error_msg option_value2_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control option_input" id="option_value3" name="option_value3" placeholder=" ">
                    <label for="option_value3" >Enter Option Value 3</label>
                        <div class="invalid-feedback error_msg option_value3_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="parent_id" name="parent_id" class="form-select option_input">
                        <option value="0" selected>No parent Option</option>
                    </select>
                    <label for="parent_id" >Add Parent Option (Optional)</label>
                    <div class="invalid-feedback error_msg parent_id_err"></div>
                </div>
            
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success edit_option_submit">Update Option</button>
        </form>
        </div>
        </div>
    </div>
</div>
    <h3 class="text-center">Option Details</h3>
    <table id="option_table" class="table table-striped table-bordered" style="width:98%">
        <thead class="option_thead">
        </thead>
        <tbody class="option_tbody">
        </tbody>
    </table>
</div>
</div>
@endsection

@section('script')
<script>
$(document).ready( function () {
    $('.option_tbody').html('');
    function fetchOptionTable() {
        $('.option_thead').html(
            `<tr>\
                <th>Sl.</th>\
                <th>Group Name</th>\
                <th>Option Value</th>\
                <th>Option Value 2</th>\
                <th>Option Value 3</th>\
                <th>Parent Group</th>\
                <th>Status</th>\
                <th>Action</th>\
            </tr>`
        );
        $.ajax({
            type: "GET",
            url: "{{url('option/fetchOptionTable')}}",
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
                                    <input class="form-check-input op-status" type="checkbox"  op_id="`+ val.id +`" checked>
                                    </div>`
                    }else if (val.status==-7) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input op-status" type="checkbox" op_id="`+ val.id +`">
                                    </div>`
                    }else if (val.status==-1) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input op-status" type="checkbox" disabled>
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
                    $('.option_tbody').append(
                        `<tr class='`+deleted+`'>\
                            <td>`+ ++key +`</td>\
                            <td>`+ val.group_name +`</td>\
                            <td>`+ val.option_value +`</td>\
                            <td>`+ val.option_value2 +`</td>\
                            <td>`+ val.option_value3 +`</td>\
                            <td>`+ val.parent_id +`</td>\
                            <td>`+ status +`</td>\
                            <td>\
                                <button class="btn btn-sm btn-success `+disabled+` me-1 mt-1 edit_modal_btn" op_id="`+ edit_btn +`" title="Edit"><i class="fa-solid fa-file-pen"></i></button>\
                                <button class="btn btn-sm btn-danger `+disabled+` mt-1 del_btn" op_id="`+ del_btn +`" title="Delete"><i class="fa-solid fa-trash-can"></i></button>\
                            </td>\
                        </tr>`
                    );
                });
                
                // $('#option_table').DataTable( {
                //     responsive: true,
                //     retrieve: true,
                //     scrollX: true
                // });
            }
        });
    }

    // fatch table data function
    fetchOptionTable();

    $(document).on('change','.op-status', function () {
        if($(this).is(':checked')){
            var data={
                id:$(this).attr("op_id"),
                status:'active'
            }
        }else{
            var data={
                id:$(this).attr("op_id"),
                status:'inactive',
            }
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "POST",
            url: "{{url('option/statusSwitch')}}",
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
        var op_id= $(this).attr("op_id");
        $(".edit_option_submit").attr("op_id",op_id);
        $.ajax({
            type: "GET",
            url: "{{url('option')}}"+"/"+op_id+"/edit",
            dataType: "json",
            success: function (response) {
            $('#group_name').val(response.group_name)
            $('#parent_id').val(response.parent_id)
            $('#option_value').val(response.option_value)
            $('#option_value2').val(response.option_value2)
            $('#option_value3').val(response.option_value3)
            }
        });
        
        $('#option_edit').modal("show");
    });

    $(document).on('submit','.edit_option_form', function (e) {
        e.preventDefault();
        var op_id= $('.edit_option_submit').attr("op_id");
        $('.edit_option_submit').attr('disabled',true).text('Sending Data...');
        var data={
            'group_name': $('#group_name').val(),
            'parent_id': $('#parent_id').val(),
            'option_value': $('#option_value').val(),
            'option_value2': $('#option_value2').val(),
            'option_value3': $('#option_value3').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            
        $.ajax({
            type: "PUT",
            url: "{{url('option')}}"+'/'+op_id,
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.status==400) {
                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".option_input").removeClass('is-invalid');
                    for (let key in response.errors) {
                        $('.'+key+'_err').removeClass("d-none").addClass("d-block").text(response.errors[key]);
                        $('#'+key).addClass("is-invalid");
                    }
                    $('.edit_option_submit').attr('disabled',false).text('Update Option');
                }else{
                    $('#option_table').DataTable().clear().destroy();
                    $('.option_tbody').html('');
                    // fatch table data function
                    fetchOptionTable();

                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".option_input").removeClass('is-invalid');
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                    
                    $('.edit_option_submit').attr('disabled',false).text('Update Option');
                    $(".edit_option_form").trigger("reset");
                    $(".edit_option_form").removeClass('was-validated');
                    $('#option_edit').modal("hide");
                    
                }
            }
        });
    });

    $(document).on('click',".del_btn", function () {
        var op_id=$(this).attr('op_id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This option will be deleted!",
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
                    url: "{{url('option')}}"+'/'+op_id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status==200) {
                            $('#option_table').DataTable().clear().destroy();
                            $('.option_tbody').html('');
                            fetchOptionTable();
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