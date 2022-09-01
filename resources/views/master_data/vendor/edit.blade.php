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