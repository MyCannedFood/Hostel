

<div class="overlay" id="overlayExpense">

    <div class="modal">

        <div class="modal-header">

            <h3>Request Expense</h3>

            <button class="modal-close" onclick="closeModal('overlayExpense')">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form>

            <div class="form-group">
                <label>Expense Title / Item Description</label>
                <input type="text" placeholder="e.g., Replacement of lobby curtains">
            </div>

            <div class="form-group">
                <label>Category</label>
                <select>
                    <option>Maintenance</option>
                    <option>Operational</option>
                    <option>Utilities</option>
                    <option>Marketing</option>
                </select>
            </div>

            <div class="form-group">
                <label>Estimated Amount</label>
                <div class="input-prefix">
                    <span>IDR</span>
                    <input type="number" placeholder="0">
                </div>
            </div>

            <div class="form-group">
                <label>Date Needed</label>
                <input type="date">
            </div>

            <div class="form-group">
                <label>Requested By</label>
                <input type="text" value="AlaSare Admin" readonly>
            </div>

            <div class="form-group">
                <label>Supporting Attachment</label>
                <label class="upload-box">
                    <input type="file" hidden>
                    <div class="upload-content">
                        <i class="fa-solid fa-file-arrow-up"></i>
                        <span>Upload quote/invoice</span>
                    </div>
                </label>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('overlayExpense')">Cancel</button>
                <button type="submit" class="btn-submit">Submit Request</button>
            </div>

        </form>

    </div>

</div>