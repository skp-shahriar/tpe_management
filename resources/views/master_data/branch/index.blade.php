@extends('layouts.app',['title' => 'Manage Branch'])

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
<div class="modal fade" id="branch_edit" tabindex="-1" aria-labelledby="branch_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        @include('master_data.branch.edit')
    </div>
</div>
<form action="" method="GET">
    @csrf
    <div class="row">

        <div class="col-md-3 col-sm-12 px-1">
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

        <div class="col-md-2 col-sm-12">                  
            <a href="{{ route('branch.create') }}"  class="btn btn-xs btn-outline-success float-end" name="create_new" 
                type="button">
                <i class="fa-solid fa-plus"></i> Create New
            </a>
        </div>

    </div>
</form>
</div>
<div class="row justify-content-center px-1">
    <table id="branch_table" class="table table-striped " style="width:100%">
        <thead class="branch_thead">
            <tr>
                <th>Sl.</th>
                <th>Branch Name</th>
                <th>Branch Code</th>
                <th>Branch Type</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="branch_tbody">
            @foreach ($branches as $index => $val)
            <tr class="{{ $val->status == -1 ? 'table-danger' : '' }}">
                <td>{{ $index + $branches->firstItem() }}</td>
                <td>{{ $val->branch_name }}</td>
                <td>{{ $val->branch_code }}</td>
                <td>{{ $val->branch_type }}</td>
                <td>{{ $val->address }}</td>
                {{-- <td>{!! App\Lib\Webspice::status($val->status) !!}</td> --}}
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input active_inactive_btn " status="{{ $val->status }}"
                            {{ $val->status == -1 ? 'disabled' : '' }} table="branches" type="checkbox"
                            id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}"
                            {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                    </div>
                </td>
                <td>
                    <button class="btn btn-sm btn-success me-1 mt-1 edit_modal_btn"
                        id="edit_btn_row_{{ $val->id }}" br_id="{{ Crypt::encryptString($val->id) }}"
                        {{ $val->status == -7 || $val->status == -1 ? 'disabled' : '' }} title="Edit"><i
                            class="fa-solid fa-file-pen"></i></button>
                    <button class="btn btn-sm btn-danger mt-1 del_btn" br_id="{{ Crypt::encryptString($val->id) }}"
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
                    location.reload();

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