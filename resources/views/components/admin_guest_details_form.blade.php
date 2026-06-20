{{-- Reusable guest profile fields (based on pages/guest-details) for admin check-in --}}
<form class="admin-guest-form" id="adminGuestCheckinForm" novalidate>
    <div class="admin-guest-form-grid">
        <div class="admin-guest-form-group">
            <label for="admin_first_name">First Name</label>
            <input type="text" id="admin_first_name" name="first_name" placeholder="e.g. John">
        </div>
        <div class="admin-guest-form-group">
            <label for="admin_last_name">Last Name</label>
            <input type="text" id="admin_last_name" name="last_name" placeholder="e.g. Doe">
        </div>
        <div class="admin-guest-form-group admin-guest-form-full">
            <label for="admin_email">Email Address</label>
            <input type="email" id="admin_email" name="email" placeholder="For booking confirmation">
        </div>
        <div class="admin-guest-form-group admin-guest-form-full">
            <label for="admin_phone">Phone Number</label>
            <div class="admin-guest-phone-group">
                <select name="country_code" id="admin_country_code" aria-label="Country code">
                    <option value="+62">+62</option>
                    <option value="+1">+1</option>
                    <option value="+44">+44</option>
                </select>
                <input type="text" id="admin_phone" name="phone" placeholder="WhatsApp number preferred">
            </div>
        </div>
        <div class="admin-guest-form-group">
            <label for="admin_age">Age</label>
            <input type="number" id="admin_age" name="age" placeholder="e.g. 28" min="1">
        </div>
        <div class="admin-guest-form-group">
            <label for="admin_occupation">Occupation</label>
            <input type="text" id="admin_occupation" name="occupation" placeholder="e.g. Freelancer">
        </div>
        <div class="admin-guest-form-group">
            <label for="admin_country">Country</label>
            <input type="text" id="admin_country" name="country" placeholder="e.g. Indonesia">
        </div>
        <div class="admin-guest-form-group">
            <label for="admin_city">City</label>
            <input type="text" id="admin_city" name="city" placeholder="e.g. Jakarta">
        </div>
        <div class="admin-guest-form-group admin-guest-form-full">
            <label for="admin_self_description">Self Description (Optional)</label>
            <textarea id="admin_self_description" name="self_description" rows="3" placeholder="Tell us a bit about yourself..."></textarea>
        </div>
        <div class="admin-guest-form-group admin-guest-form-full">
            <label for="admin_personal_notes">Personal Notes (Optional)</label>
            <textarea id="admin_personal_notes" name="personal_notes" rows="3" placeholder="Any additional notes for us?"></textarea>
        </div>
    </div>

    <div class="admin-guest-id-deposit-section">
        <div class="admin-guest-tab-row" role="tablist" aria-label="ID Card or Deposit">
            <button type="button" class="admin-guest-tab active" role="tab" aria-selected="true" aria-controls="adminTabIdCard" id="adminTabBtnIdCard" data-tab="id-card">ID Card</button>
            <button type="button" class="admin-guest-tab" role="tab" aria-selected="false" aria-controls="adminTabDeposit" id="adminTabBtnDeposit" data-tab="deposit">Deposit</button>
        </div>

        <div class="admin-guest-tab-panel active" id="adminTabIdCard" role="tabpanel" aria-labelledby="adminTabBtnIdCard">
            <div class="admin-guest-tab-fields">
                <div class="admin-guest-form-group">
                    <label for="admin_id_number">ID Number</label>
                    <input type="text" id="admin_id_number" name="id_number" placeholder="e.g. 3174012345670001">
                </div>
                <div class="admin-guest-form-group">
                    <label for="admin_address">Address</label>
                    <input type="text" id="admin_address" name="address" placeholder="Full address on ID card">
                </div>
            </div>
        </div>

        <div class="admin-guest-tab-panel" id="adminTabDeposit" role="tabpanel" aria-labelledby="adminTabBtnDeposit" hidden>
            <div class="admin-guest-tab-fields">
                <div class="admin-guest-form-group">
                    <label for="admin_deposit_amount">Deposit Amount</label>
                    <input type="text" id="admin_deposit_amount" name="deposit_amount" placeholder="e.g. IDR 100.000">
                </div>
                <div class="admin-guest-form-group">
                    <label for="admin_deposit_notes">Deposit Notes</label>
                    <input type="text" id="admin_deposit_notes" name="deposit_notes" placeholder="Optional notes">
                </div>
            </div>
        </div>
    </div>

    <div class="admin-guest-upload-grid">
        <div class="admin-guest-upload-box">
            <label class="admin-guest-upload-label" for="admin_profile_picture">Profile Picture</label>
            <label class="admin-guest-upload-area" for="admin_profile_picture" style="position: relative; overflow: hidden;">
                <input type="file" id="admin_profile_picture" name="profile_picture" accept="image/*" hidden>
                <div class="upload-placeholder" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="1.5" aria-hidden="true">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <span class="admin-guest-upload-hint">Click to upload</span>
                </div>
                <img class="upload-preview" id="admin_profile_picture_preview" src="" alt="Preview" style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
            </label>
        </div>
        <div class="admin-guest-upload-box">
            <label class="admin-guest-upload-label" for="admin_card_photo">Card Photo</label>
            <label class="admin-guest-upload-area" for="admin_card_photo" style="position: relative; overflow: hidden;">
                <input type="file" id="admin_card_photo" name="card_photo" accept="image/*" hidden>
                <div class="upload-placeholder" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="1.5" aria-hidden="true">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <span class="admin-guest-upload-hint">Click to upload</span>
                </div>
                <img class="upload-preview" id="admin_card_photo_preview" src="" alt="Preview" style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
            </label>
        </div>
    </div>
</form>
