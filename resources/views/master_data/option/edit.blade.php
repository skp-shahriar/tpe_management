<div class="modal fade" id="option_edit" tabindex="-1" aria-labelledby="option_edit_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="option_edit_title">Edit Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation edit_option_form">
                    <div class="col-md-6 form-floating">
                        <select id="group_name" name="group_name" class="form-select option_input">
                            <option selected disabled>Select Group Name</option>
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
                        <label for="group_name">Group Name *</label>
                        <div class="invalid-feedback error_msg group_name_err"></div>
                    </div>
                    <div class="col-md-6 form-floating">
                        <input type="text" class="form-control option_input" id="option_value" name="option_value"
                            placeholder=" ">
                        <label for="option_value">Enter Option Value *</label>
                        <div class="invalid-feedback error_msg option_value_err"></div>
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

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success edit_option_submit">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
