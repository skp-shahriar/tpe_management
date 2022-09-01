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