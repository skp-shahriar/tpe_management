<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="employee_edit_title">Edit Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form class="row g-3 needs-validation edit_employee_form" novalidate>
            <div class="col-md-6 form-floating">
                <input type="number" class="form-control employee_input" id="employee_id" name="employee_id" placeholder=" " required>
                <label for="employee_id" >Enter Employee ID *</label>
                    <div class="invalid-feedback error_msg employee_id_err">Employee ID is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="employee_name" name="employee_name" placeholder=" " required>
                <label for="employee_name" >Enter Employee Name *</label>
                    <div class="invalid-feedback error_msg employee_name_err">Employee Name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="employee_phone" name="employee_phone" placeholder=" " required>
                <label for="employee_phone" >Enter Employee Phone *</label>
                    <div class="invalid-feedback error_msg employee_phone_err">Employee Phone No. is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="employee_email" name="employee_email" placeholder=" ">
                <label for="employee_email" >Enter Employee E-mail</label>
                    <div class="invalid-feedback error_msg employee_email_err"></div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="vendor_id" name="vendor_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Vendor Name</option>
                    @foreach ($vendor as $val)
                        <option value="{{$val->id}}">{{$val->vendor_name}}</option>
                    @endforeach
                </select>
                <label for="vendor_id" >Select Vendor *</label>
                <div class="invalid-feedback error_msg vendor_id_err">Vendor Name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="branch_id" name="branch_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Branch Name</option>
                    @foreach ($branch as $val)
                        <option value="{{$val->id}}">{{$val->branch_name}}</option>
                    @endforeach
                </select>
                <label for="branch_id" >Select Branch *</label>
                <div class="invalid-feedback error_msg branch_id_err">Branch Name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="region_id" name="region_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Region Name</option>
                    @foreach ($option as $val)
                        @if ($val->group_name=='Region')
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="region_id" >Select Region *</label>
                <div class="invalid-feedback error_msg region_id_err">Region is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="division_id" name="division_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Division Name</option>
                    @foreach ($option as $val)
                        @if ($val->group_name=='Division')
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="division_id" >Select Division *</label>
                <div class="invalid-feedback error_msg division_id_err">Division is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="department_id" name="department_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Department Name</option>
                    @foreach ($option as $val)
                        @if ($val->group_name=='Department')
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="department_id" >Select Department *</label>
                <div class="invalid-feedback error_msg department_id_err">Department is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="designation_id" name="designation_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Designation Name</option>
                    @foreach ($option as $val)
                        @if ($val->group_name=='Designation')
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="designation_id" >Select Designation *</label>
                <div class="invalid-feedback error_msg designation_id_err">Designation is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="shift_id" name="shift_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Shift Name</option>
                    @foreach ($option as $val)
                        @if ($val->group_name=='Shift')
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="shift_id" >Select Shift *</label>
                <div class="invalid-feedback error_msg shift_id_err">Shift is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="type_id" name="type_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Type Name</option>
                    @foreach ($option as $val)
                        @if ($val->group_name=='Type')
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="type_id" >Select Type *</label>
                <div class="invalid-feedback error_msg type_id_err">Employee Type is required!</div>
            </div>
            <div class="col-md-6 form-floating" id="start_date_div">
                <input type="text" class="form-control employee_input " id="start_date" name="start_date" placeholder=" ">
                <label for="start_date" >Enter Start Date</label>
                    <div class="invalid-feedback error_msg start_date_err"></div>
            </div>
            <div class="col-md-6 form-floating" id="end_date_div">
                <input type="text" class="form-control employee_input " id="end_date" name="end_date" placeholder=" ">
                <label for="end_date" >Enter End Date</label>
                    <div class="invalid-feedback error_msg end_date_err"></div>
            </div>

            <div class="col-md-6 form-floating">
                <select id="grade_id" name="grade_id" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Grade Name</option>
                    @foreach ($option as $val)
                        @if ($val->group_name=='Grade')
                        <option value="{{$val->id}}">{{$val->option_value}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="grade_id" >Select Grade *</label>
                <div class="invalid-feedback error_msg grade_id_err">Employee Grade is required!</div>
            </div>

            <div class="col-md-6 form-floating">
                <input type="number" class="form-control employee_input" id="present_salary" name="present_salary" placeholder=" " required>
                <label for="present_salary" >Enter Present Salary *</label>
                    <div class="invalid-feedback error_msg present_salary_err">Present Salary is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="service_reference_id" name="service_reference_id" placeholder=" " required>
                <label for="service_reference_id" >Enter Service Reference ID *</label>
                    <div class="invalid-feedback error_msg service_reference_id_err">Service Reference ID is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="gender" name="gender" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                </select>
                <label for="gender" >Select Gender *</label>
                <div class="invalid-feedback error_msg gender_err">Gender is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="date_of_birth" name="date_of_birth" placeholder=" " required>
                <label for="date_of_birth" >Enter Date Of Birth *</label>
                    <div class="invalid-feedback error_msg date_of_birth_err">Date of Birth is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="marital_status" name="marital_status" placeholder=" " required>
                <label for="marital_status" >Enter Marital Status *</label>
                    <div class="invalid-feedback error_msg marital_status_err">Marital Status is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="religion" name="religion" placeholder=" " required>
                <label for="religion" >Enter Religion *</label>
                    <div class="invalid-feedback error_msg religion_err">Religion is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="number" class="form-control employee_input" id="national_id" name="national_id" placeholder=" " required>
                <label for="national_id" >Enter National ID No. *</label>
                    <div class="invalid-feedback error_msg national_id_err">National ID No. is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="number" class="form-control employee_input" id="tin" name="tin" placeholder=" ">
                <label for="tin" >Enter TIN no.</label>
                    <div class="invalid-feedback error_msg tin_err"></div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="nationality" name="nationality" placeholder=" " required>
                <label for="nationality" >Enter Nationality *</label>
                    <div class="invalid-feedback error_msg nationality_err">Nationality is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="father_name" name="father_name" placeholder=" " required>
                <label for="father_name" >Enter Father Name *</label>
                    <div class="invalid-feedback error_msg father_name_err">Father Name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="mother_name" name="mother_name" placeholder=" " required>
                <label for="mother_name" >Enter Mother Name *</label>
                    <div class="invalid-feedback error_msg mother_name_err">Mother Name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="husband_wife_name" name="husband_wife_name" placeholder=" ">
                <label for="husband_wife_name" >Enter Husband/Wife Name</label>
                    <div class="invalid-feedback error_msg husband_wife_name_err"></div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="blood_group" name="blood_group" placeholder=" " required>
                <label for="blood_group" >Enter Blood Group *</label>
                    <div class="invalid-feedback error_msg blood_group_err">Blood Group is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="present_address" name="present_address" placeholder=" " required>
                <label for="present_address" >Enter Present Address *</label>
                    <div class="invalid-feedback error_msg present_address_err">Present Address is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="permanent_address" name="permanent_address" placeholder=" " required>
                <label for="permanent_address" >Enter Permanent Address *</label>
                    <div class="invalid-feedback error_msg permanent_address_err">Permanent Address is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="supervisor_name" name="supervisor_name" placeholder=" " required>
                <label for="supervisor_name" >Enter Supervisor Name *</label>
                    <div class="invalid-feedback error_msg supervisor_name_err">Supervisor Name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="manager_name" name="manager_name" placeholder=" " required>
                <label for="manager_name" >Enter Manager Name *</label>
                    <div class="invalid-feedback error_msg manager_name_err">Manager Name is required!</div>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control employee_input" id="joining_date" name="joining_date" placeholder=" " required>
                <label for="joining_date" >Enter Joining Date *</label>
                    <div class="invalid-feedback error_msg joining_date_err">Joining Date is required!</div>
            </div>
            <div class="col-md-6">
                <textarea class="form-control employee_input" id="reference_info" name="reference_info" placeholder="Enter employee reference info"></textarea>
                <div class="invalid-feedback error_msg reference_info_err"></div>
            </div>
            <div class="col-md-6 form-floating">
                <select id="under_service_type_packages" name="under_service_type_packages" class="form-select employee_input" required>
                    <option value="" selected disabled>Choose Under servise type packages</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <label for="under_service_type_packages" >Select Under Service Type Packages *</label>
                <div class="invalid-feedback error_msg under_service_type_packages_err">Service Type Packages is equired!</div>
            </div>
        
    </div>
    <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success edit_employee_submit">Update Employee</button>
    </form>
    </div>
    </div>