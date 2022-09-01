@extends('layouts.app', ['title' => 'Manage Option'])

@section('content')
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
    <div class="container">
        <form action="" method="GET">
            @csrf
            <div class="row">

                <div class="col-md-3 col-sm-12 px-1">
                    <div class="input-group">
                        <select class="form-select" name="search_group_name" id="search_group_name"
                            aria-label="Example select with button addon">
                            <option value="">Select Group Name</option>
                            <option value="Department"
                                {{ request()->get('search_group_name') == 'Department' ? 'selected' : '' }}>
                                Department</option>
                            <option value="Designation"
                                {{ request()->get('search_group_name') == 'Designation' ? 'selected' : '' }}>
                                Designation</option>
                            <option value="Region" {{ request()->get('search_group_name') == 'Region' ? 'selected' : '' }}>
                                Region
                            </option>
                            <option value="Division"
                                {{ request()->get('search_group_name') == 'Division' ? 'selected' : '' }}>
                                Division
                            </option>
                            <option value="Shift" {{ request()->get('search_group_name') == 'Shift' ? 'selected' : '' }}>
                                Shift
                            </option>
                            <option value="Type" {{ request()->get('search_group_name') == 'Type' ? 'selected' : '' }}>
                                Employee
                                Type
                            </option>
                            <option value="Grade" {{ request()->get('search_group_name') == 'Grade' ? 'selected' : '' }}>
                                Grade
                            </option>
                            <option value="service_type"
                                {{ request()->get('search_group_name') == 'service_type' ? 'selected' : '' }}>
                                Service Type</option>
                            <option value="facility_type"
                                {{ request()->get('search_group_name') == 'facility_type' ? 'selected' : '' }}>
                                Facility Type</option>
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
                    <a href="{{ route('option.create') }}"  class="btn btn-xs btn-outline-success float-end" name="create_new" 
                        type="button">
                        <i class="fa-solid fa-plus"></i> Create New
                    </a>
                </div>

            </div>
        </form>
        <div class="row justify-content-center px-1">
            {{-- <h3 class="text-center">Option Details</h3> --}}

            <table id="option_table" class="table table-striped" style="width:100%">
                <thead class="option_thead">
                    <tr>
                        <th>Sl.</th>
                        <th>Group Name</th>
                        <th>Option Value</th>
                        <th>Option Value 2</th>
                        <th>Option Value 3</th>
                        <th>Parent Group</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="option_tbody">
                    @foreach ($options as $index => $val)
                        <tr class="{{ $val->status == -1 ? 'table-danger' : '' }}">
                            <td>{{ $index + $options->firstItem() }}</td>
                            <td>{{ $val->group_name }}</td>
                            <td>{{ $val->option_value }}</td>
                            <td>{{ $val->option_value2 }}</td>
                            <td>{{ $val->option_value3 }}</td>
                            <td>{{ $val->parents_name }}</td>
                            {{-- <td>{!! App\Lib\Webspice::status($val->status) !!}</td> --}}
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input active_inactive_btn " status="{{ $val->status }}"
                                        {{ $val->status == -1 ? 'disabled' : '' }} table="options" type="checkbox"
                                        id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}"
                                        {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                                </div>
                            </td>
                            <td>

                                <button class="btn btn-sm btn-success me-1 mt-1 edit_modal_btn"
                                    id="edit_btn_row_{{ $val->id }}" op_id="{{ Crypt::encryptString($val->id) }}"
                                    {{ $val->status == -7 || $val->status == -1 ? 'disabled' : '' }} title="Edit"><i
                                        class="fa-solid fa-file-pen"></i></button>
                                <button class="btn btn-sm btn-danger mt-1 del_btn" op_id="{{ Crypt::encryptString($val->id) }}"
                                    title="Delete" {{ $val->status == -1 ? 'disabled' : '' }}><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
            {{ $options->appends(['search_group_name' => request()->get('search_group_name'), 'search_text' => request()->get('search_text'), 'search_status' => request()->get('search_status')])->links() }}
            <span class="float-start">{{ $execution_time }} Secs</span>
            <!-- Modal -->
            @include('master_data.option.edit')

        </div>
    </div>
@endsection

@push('scripts')
    <script>

        $(document).ready(function() {
            $(document).on("click", ".edit_modal_btn", function() {
                parentDropDown();
                var op_id = $(this).attr("op_id");

                $(".edit_option_submit").attr("op_id", op_id);
                $.ajax({
                    type: "GET",
                    url: "{{ url('option') }}" + "/" + op_id + "/edit",
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.error,
                            });
                            return false;
                        } else {
                            $('#group_name').val(response.group_name.toLowerCase());
                            $('#parent_id').val(response.parent_id);
                            $('#option_value').val(response.option_value);
                            $('#option_value2').val(response.option_value2);
                            $('#option_value3').val(response.option_value3);

                            $('#option_edit').modal("show");
                        }

                    }
                });


            });

            $(document).on('click', '.edit_option_submit', function(e) {
                e.preventDefault();
                var op_id = $(this).attr("op_id");
                $('.edit_option_submit').attr('disabled', true).text('Sending Data...');
                var data = {
                    'group_name': $('#group_name').val(),
                    'parent_id': $('#parent_id').val(),
                    'option_value': $('#option_value').val(),
                    'option_value2': $('#option_value2').val(),
                    'option_value3': $('#option_value3').val()
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "{{ url('option') }}" + '/' + op_id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $(".error_msg").removeClass("d-block");
                            $(".error_msg").addClass("d-none");
                            $(".option_input").removeClass('is-invalid');

                            Toast.fire({
                                icon: 'error',
                                title: "Validation Error!"
                            })
                            for (let key in response.errors) {
                                $('.' + key + '_err').removeClass("d-none").addClass("d-block")
                                    .text(response.errors[key]);
                                $('#' + key).addClass("is-invalid");
                            }
                            $('.edit_option_submit').attr('disabled', false).text(
                                'Save Changes');
                        } else {

                            $(".error_msg").removeClass("d-block");
                            $(".error_msg").addClass("d-none");
                            $(".option_input").removeClass('is-invalid');
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            })

                            $('.edit_option_submit').attr('disabled', false).text(
                                'Save Changes');
                            $(".edit_option_form").trigger("reset");
                            $('#option_edit').modal("hide");
                            location.reload();
                        }
                    }
                });
            });

            $(document).on('click', ".del_btn", function() {
                var op_id = $(this).attr('op_id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This option will be deleted!",
                    icon: 'warning',
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
                            url: "{{ url('option') }}" + '/' + op_id,
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 200) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: response.message
                                    })
                                    location.reload();
                                } else {
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
        function parentDropDown() {
            $.ajax({
                type: "GET",
                url: "{{ url('option/parentDropDown') }}",
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $('#parent_id').html(
                            `<option value="0" selected>No parent Option</option>`
                        );
                        for (var key in response.data) {
                            $('#parent_id').append(
                                `<option value="` + response.data[key].id + `">` + response.data[key]
                                .option_value + `</option>`
                            );
                        }
                    }
                }
            });
        }
    </script>
@endpush
