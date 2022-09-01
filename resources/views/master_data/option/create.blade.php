@extends('layouts.app', ['title' => 'Create Option'])
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="row g-3 needs-validation add_option_form" method="POST" novalidate>
                <div class="col-md-6 form-floating">
                    <select id="group_name" name="group_name" class="form-select option_input" required>
                        <option value="" selected disabled>Select Group Name</option>
                        <option value="department">Department</option>
                        <option value="designation">Designation</option>
                        <option value="region">Region</option>
                        <option value="division">Division</option>
                        <option value="district">District</option>
                        <option value="shift">Shift</option>
                        <option value="type">Type</option>
                        <option value="grade">Grade</option>
                        <option value="facility_type">Facility Type</option>
                    </select>
                    <label for="group_name">Add Group Name *</label>
                    <div class="invalid-feedback error_msg group_name_err">Group Name is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control option_input" id="option_value" name="option_value"
                        placeholder=" " required>
                    <label for="option_value">Enter Option Value *</label>
                    <div class="invalid-feedback error_msg option_value_err">Option Value is required!</div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control option_input" id="option_value2" name="option_value2"
                        placeholder=" ">
                    <label for="option_value2">Enter Option Value 2</label>
                    <div class="invalid-feedback error_msg option_value2_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <input type="text" class="form-control option_input" id="option_value3" name="option_value3"
                        placeholder=" ">
                    <label for="option_value3">Enter Option Value 3</label>
                    <div class="invalid-feedback error_msg option_value3_err"></div>
                </div>
                <div class="col-md-6 form-floating">
                    <select id="parent_id" name="parent_id" class="form-select option_input">
                        <option value="0" selected>No parent Option</option>
                    </select>
                    <label for="parent_id">Add Parent Option (Optional)</label>
                    <div class="invalid-feedback error_msg parent_id_err"></div>
                </div>

                <div class="d-grid col-12 mx-auto justify-content-md-center">
                    <button type="submit" class="w-100 btn btn-success add_option_submit">Add Option</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
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

        $(document).ready(function() {

            parentDropDown();

            $(document).on('submit', '.add_option_form', function(e) {

                e.preventDefault();
                $('.add_option_submit').attr('disabled', true).text('Sending Data...');
                var data = {
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
                    type: "POST",
                    url: "{{ route('option.store') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $(".error_msg").removeClass("d-block");
                            $(".error_msg").addClass("d-none");
                            $(".option_input").removeClass('is-invalid');

                            for (let key in response.errors) {
                                $('.' + key + '_err').removeClass("d-none").addClass("d-block")
                                    .text(response.errors[key]);
                                $('#' + key).addClass("is-invalid");
                            }
                            $('.add_option_submit').attr('disabled', false).text('Add Option');
                        } else {
                            $(".error_msg").removeClass("d-block");
                            $(".error_msg").addClass("d-none");
                            $(".option_input").removeClass('is-invalid');
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            })
                            $('.add_option_submit').attr('disabled', false).text('Add Option');
                            $(".add_option_form").trigger("reset");
                            $(".add_option_form").removeClass('was-validated');

                            parentDropDown();
                        }
                    }
                });
            });
        });
    </script>
@endpush
