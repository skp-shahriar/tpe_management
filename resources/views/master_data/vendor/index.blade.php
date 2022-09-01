@extends('layouts.app',['title' => 'Manage Vendor'])

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

<!-- Edit Modal -->
<div class="modal fade" id="vendor_edit" tabindex="-1" aria-labelledby="vendor_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        @include('master_data.vendor.edit')
    </div>
</div>
<form action="" method="GET">
    @csrf
    <div class="row">

        {{-- <div class="col-md-3 col-sm-12 px-1">
            <div class="input-group">
                <select class="form-select" name="search_branch_type" id="search_branch_type"
                    aria-label="Example select with button addon">
                    <option value="">Select Branch Type</option>
                    <option value="Branch"
                        {{ request()->get('search_branch_type') == 'Branch' ? 'selected' : '' }}>
                        Branch</option>
                    <option value="Main-Branch"
                        {{ request()->get('search_branch_type') == 'Main-Branch' ? 'selected' : '' }}>
                        Main-Branch</option>
                    <option value="SME"
                        {{ request()->get('search_branch_type') == 'SME' ? 'selected' : '' }}>
                        SME</option>
                    <option value="Sub-Branch"
                        {{ request()->get('search_branch_type') == 'Sub-Branch' ? 'selected' : '' }}>
                        Sub-Branch</option>
                </select> 
                <button class="btn btn-outline-secondary" type="button"> <i class="fa fa-search"></i> Search</button>
            </div>

        </div> --}}
        <div class="col-md-2 col-sm-12">
            <select name="search_status" class="form-select" id="search_status">
                <option value="">Select Status</option>
                <option value="7" {{ request()->get('search_status') == '7' ? 'selected' : '' }}>Active
                </option>
                <option value="-7" {{ request()->get('search_status') == '-7' ? 'selected' : '' }}>Inactive
                </option>
            </select>
        </div>
        <div class="col-md-5 col-sm-12 px-1">
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

        <div class="col-md-2 offset-md-3 col-sm-12">                  
            <a href="{{ route('vendor.create') }}"  class="btn btn-xs btn-outline-success float-end" name="create_new" 
                type="button">
                <i class="fa-solid fa-plus"></i> Create New
            </a>
        </div>

    </div>
</form>
</div>

<div class="row justify-content-center px-1">
    <table id="vendor_table" class="table table-striped " style="width:100%">
        <thead class="vendor_thead">
            <tr>
                <th>Sl.</th>
                <th>Vendor Name</th>
                <th>Mobile No.</th>
                <th>E-mail</th>
                <th>Reference No.</th>
                <th>Profile</th>
                <th class="text-center">Agreement</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody class="vendor_tbody">
            @foreach ($vendors as $index => $val)
            <tr class="{{ $val->status == -1 ? 'table-danger' : '' }}">
                <td>{{ $index + $vendors->firstItem() }}</td>
                <td>{{ $val->vendor_name }}</td>
                <td>{{ $val->mobile_no }}</td>
                <td>{{ $val->email }}</td>
                <td>{{ $val->reference_no }}</td>
                <td class="text-center"><a href="{{url('vendor',Crypt::encryptString($val->id))}}" class="btn btn-outline-secondary btn-sm {{ $val->status == -1 ? 'disabled' : '' }}">Details</a></td>
                <td class="text-center"><a href="{{ asset('img/agreement').'/'.$val->agreement_attachment }}" class="btn btn-outline-secondary btn-sm {{ $val->status == -1 ? 'disabled' : '' }}" target="_blank">View</a></td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input active_inactive_btn " status="{{ $val->status }}"
                            {{ $val->status == -1 ? 'disabled' : '' }} table="vendors" type="checkbox"
                            id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}"
                            {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                    </div>
                </td>
                <td>
                    <button class="btn btn-sm btn-success me-1 mt-1 edit_modal_btn"
                        id="edit_btn_row_{{ $val->id }}" vn_id="{{ Crypt::encryptString($val->id) }}"
                        {{ $val->status == -7 || $val->status == -1 ? 'disabled' : '' }} title="Edit"><i
                            class="fa-solid fa-file-pen"></i></button>
                    <button class="btn btn-sm btn-danger mt-1 del_btn" vn_id="{{ Crypt::encryptString($val->id) }}"
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
$(document).ready( function () {
    
    $( function() {
    $( "#agreement_date" ).datepicker();
    $( "#enlisted_date" ).datepicker();
    } );


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
                    location.reload();

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
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            })
                            location.reload();
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