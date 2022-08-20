@extends('layouts.app',['title' => 'Manage Vendor'])

@section('content')
<div class="container">
<div class="row justify-content-center">

<!-- Modal -->
<div class="modal fade" id="vendor_edit" tabindex="-1" aria-labelledby="vendor_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="vendor_edit_title">Edit Vendor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3 needs-validation edit_vendor_form" enctype="multipart/form-data" novalidate>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control vendor_input" id="vendor_name" name="vendor_name" placeholder=" " required>
                    <label for="vendor_name" >Enter Vendor Name *</label>
                        <div class="invalid-feedback error_msg vendor_name_err">Vendor Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control vendor_input" id="owner_name" name="owner_name" placeholder=" " required>
                    <label for="owner_name" >Enter Owner Name *</label>
                        <div class="invalid-feedback error_msg owner_name_err">Owner Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="file" class="form-control vendor_input" id="owner_photo" name="owner_photo" placeholder=" " accept="image/png,image/jpg,image/jpeg" >
                    <label for="owner_photo" >Enter Owner Photo (jpg/jpeg/png) *</label>
                    <div class="invalid-feedback error_msg owner_photo_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="number" class="form-control vendor_input" id="mobile_no" name="mobile_no" placeholder=" " required>
                    <label for="mobile_no" >Enter Mobile No *</label>
                        <div class="invalid-feedback error_msg mobile_no_err">Mobile No. is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="email" class="form-control vendor_input" id="email" name="email" placeholder=" " required>
                    <label for="email" >Enter E-mail *</label>
                    <div class="invalid-feedback error_msg email_err">E-mail address is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control vendor_input" id="address" name="address" placeholder=" " required>
                    <label for="address" >Enter Address *</label>
                    <div class="invalid-feedback error_msg address_err">Vendor Address is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="number" step="0.01" class="form-control vendor_input" id="commission_rate" name="commission_rate" placeholder=" ">
                    <label for="commission_rate" >Enter Commission Rate(%)</label>
                    <div class="invalid-feedback error_msg commission_rate_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control vendor_input" id="reference_no" name="reference_no" placeholder=" " >
                    <label for="reference_no" >Enter Reference No.</label>
                    <div class="invalid-feedback error_msg reference_no_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="number" class="form-control vendor_input" id="tin" name="tin" placeholder=" " required>
                    <label for="tin" >Enter BIN/TIN No. *</label>
                    <div class="invalid-feedback error_msg tin_err">BIN/TIN No. is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control vendor_input" id="enlisted_date" name="enlisted_date" placeholder=" " required>
                    <label for="enlisted_date" >Enter Enlisted Date *</label>
                    <div class="invalid-feedback error_msg enlisted_date_err">Enlisted Date is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control vendor_input" id="contact_person" name="contact_person" placeholder=" ">
                    <label for="contact_person" >Enter Contact Person Name</label>
                    <div class="invalid-feedback error_msg contact_person_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="number" class="form-control vendor_input" id="contact_person_number" name="contact_person_number" placeholder=" ">
                    <label for="contact_person_number" >Enter Contact Person Phone No.</label>
                        <div class="invalid-feedback error_msg contact_person_number_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="file" class="form-control vendor_input" id="agreement_attachment" name="agreement_attachment" placeholder=" " accept="application/pdf,image/png,image/jpg,image/jpeg">
                    <label for="agreement_attachment" >Enter Agreement Attachment (jpg/jpeg/png/pdf) *</label>
                    <div class="invalid-feedback error_msg agreement_attachment_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="number" step="0.01" class="form-control vendor_input" id="material_commission_amount" name="material_commission_amount" placeholder=" " required>
                    <label for="material_commission_amount" >Enter Material Commission Amount</label>
                        <div class="invalid-feedback error_msg material_commission_amount_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control vendor_input" id="agreement_date" name="agreement_date" placeholder=" " required>
                    <label for="agreement_date" >Enter Agreement Date *</label>
                    <div class="invalid-feedback error_msg agreement_date_err">Agreement Date is required!</div>
                </div>
            
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success edit_vendor_submit">Update Vendor</button>
        </form>
        </div>
        </div>
    </div>
</div>
    <h3 class="text-center">Vendor Details</h3>
    <table id="vendor_table" class="table table-striped table-bordered" style="width:98%">
        <thead class="vendor_thead">
        </thead>
        <tbody class="vendor_tbody">
        </tbody>
    </table>
</div>
</div>
@endsection

@section('script')
<script>
$(document).ready( function () {
    
    $( function() {
    $( "#agreement_date" ).datepicker();
    $( "#enlisted_date" ).datepicker();
    } );

    $('.vendor_tbody').html('');
    function fetchVendorTable() {
        $('.vendor_thead').html(
            `<tr>\
                <th>Sl.</th>\
                <th>Vendor Name</th>\
                <th>Mobile No.</th>\
                <th>E-mail</th>\
                <th>Reference No.</th>\
                <th>Profile</th>\
                <th class="text-center">Agreement</th>\
                <th>Status</th>\
                <th class="text-center">Action</th>\
            </tr>`
        );
        $.ajax({
            type: "GET",
            url: "{{url('vendor/fetchVendorTable')}}",
            dataType: "json",
            success: function (response) {
                $.each(response, function (key, val) { 
                    var status=''
                    var deleted=''
                    var disabled=''
                    var agreement_attachment_link='#'
                    var details_link='#'
                    var edit_btn=''
                    var del_btn=''
                    if (val.status==7) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input vn-status" type="checkbox" vn_id="`+ val.id +`" checked>
                                    </div>`
                    }else if (val.status==-7) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input vn-status" type="checkbox" vn_id="`+ val.id +`">
                                    </div>`
                    }else if (val.status==-1) {
                        status=`<div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" disabled>
                                    </div>`
                    }
                    
                    if (val.status==-1) {
                        deleted='table-danger'
                        disabled='disabled'
                    } else {
                        deleted=''
                        disabled=''
                        agreement_attachment_link=val.agreement_attachment
                        details_link=val.id
                        edit_btn=val.id
                        del_btn=val.id
                    }
                    $('.vendor_tbody').append(
                        `<tr class='`+ deleted +`'>\
                            <td>`+ ++key +`</td>\
                            <td>`+ val.vendor_name +`</td>\
                            <td>`+ val.mobile_no +`</td>\
                            <td>`+ val.email +`</td>\
                            <td>`+ val.reference_no +`</td>\
                            <td class="text-center"><a href="{{url('vendor')}}/`+details_link+`" class="btn btn-outline-secondary btn-sm `+ disabled +`">Details</a></td>\
                            <td class="text-center"><a href="{{ asset('img/agreement/`+ agreement_attachment_link +`') }}" class="btn btn-outline-secondary btn-sm `+ disabled +`" target="_blank">View</a></td>\
                            <td class="">`+ status +`</td>\
                            <td class="text-center">\
                                <button class="btn btn-sm btn-success `+ disabled +` me-1 mt-1 edit_modal_btn " vn_id="`+ edit_btn +`" title="Edit"><i class="fa-solid fa-file-pen"></i></button>\
                                <button class="btn btn-sm btn-danger `+ disabled +` mt-1 del_btn" vn_id="`+ del_btn +`" title="Delete"><i class="fa-solid fa-trash-can"></i></button>\
                            </td>\
                        </tr>`
                    );
                });
                
                // make datatable
                // $('#vendor_table').DataTable( {
                //     responsive: true,
                //     retrieve: true,
                    // "scrollX": true
                // });
            }
        });
    }

    // fatch table data function
    fetchVendorTable();
    
    $(document).on('change','.vn-status', function () {
        if($(this).is(':checked')){
            var data={
                id:$(this).attr("vn_id"),
                status:'active'
            }
        }else{
            var data={
                id:$(this).attr("vn_id"),
                status:'inactive',
            }
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: "POST",
            url: "{{url('vendor/statusSwitch')}}",
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
        var vn_id= $(this).attr("vn_id");
        $(".edit_vendor_form").attr("vn_id",vn_id);
        $.ajax({
            type: "GET",
            url: "{{url('vendor')}}"+'/'+vn_id+"/edit",
            dataType: "json",
            success: function (response) {
            $('#vendor_name').val(response.vendor_name)
            $('#owner_name').val(response.owner_name)
            $('#mobile_no').val(response.mobile_no)
            $('#email').val(response.email)
            $('#address').val(response.address)
            $('#commission_rate').val(response.commission_rate)
            $('#reference_no').val(response.reference_no)
            $('#tin').val(response.tin)
            $('#enlisted_date').val(response.enlisted_date)
            $('#contact_person').val(response.contact_person)
            $('#contact_person_number').val(response.contact_person_number)
            $('#material_commission_amount').val(response.material_commission_amount)
            $('#agreement_date').val(response.agreement_date)
            }
        });
        
        $('#vendor_edit').modal("show");
    });

    $(document).on('submit','.edit_vendor_form', function (e) {
        e.preventDefault();
        var vn_id= $(this).attr("vn_id");
        $('.edit_vendor_submit').attr('disabled',true).text('Sending Data...');
       // Create an FormData object 
        var form_data = new FormData($('.edit_vendor_form')[0]);

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        form_data.append('_method', 'PUT');
        
        $.ajax({
            type: "POST",
            url: "{{url('vendor')}}/"+ vn_id,
            data: form_data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status==400) {
                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".vendor_input").removeClass('is-invalid');
                
                    for (let key in response.errors) {
                        $('.'+key+'_err').removeClass("d-none").addClass("d-block").text(response.errors[key]);
                        $('#'+key).addClass("is-invalid");
                    }
                    $('.edit_vendor_submit').attr('disabled',false).text('Update Vendor');
                }else{
                    // $('#vendor_table').DataTable().clear().destroy();
                    $('.vendor_tbody').html('');
                    // fatch table data function
                    fetchVendorTable();

                    $(".error_msg").removeClass("d-block");
                    $(".error_msg").addClass("d-none");
                    $(".vendor_input").removeClass('is-invalid');
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    })
                    $('.edit_vendor_submit').attr('disabled',false).text('Update Vendor');
                    $(".edit_vendor_form").trigger("reset");
                    $(".edit_vendor_form").removeClass('was-validated');
                    $('#vendor_edit').modal("hide");
                    
                }
            }
        });
    });

    $(document).on('click',".del_btn", function () {
        var vn_id=$(this).attr('vn_id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This vendor will be deleted!",
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
                    url: "{{url('vendor')}}"+'/'+vn_id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status==200) {
                            $('#vendor_table').DataTable().clear().destroy();
                            $('.vendor_tbody').html('');
                            fetchVendorTable();
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