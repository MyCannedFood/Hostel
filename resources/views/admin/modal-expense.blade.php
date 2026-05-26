<div class="overlay" id="overlayExpense">
    <div class="modal">

        <div class="modal-header">
            <h3>Budgeting</h3>
        </div>

        <div class="modal-body">
        <form id="formExpense" method="POST" action="{{ route('admin.budgeting.requests.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- ROW 1: Title + Category + Type -->
            <div class="row-title-cat">
                <div class="form-group fg-title">
                    <label class="field-label">Expense Title</label>
                    <input type="text" name="title" placeholder="e.g., Replacement of lobby curtains" required>
                </div>
                <div class="form-group fg-cat">
                    <label class="field-label">Category</label>
                    <select name="category" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Operational">Operational</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Marketing">Marketing</option>
                    </select>
                </div>
                <div class="form-group fg-cat">
                    <label class="field-label">Type</label>
                    <select name="type" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Operational">Operational</option>
                    </select>
                </div>
            </div>

            <!-- ROW 2: Item entry -->
            <div id="itemRows">
                <div class="item-entry">
                    <div class="form-group fg-title-item">
                        <label class="field-label">Item Description</label>
                        <input type="text" class="item-title" name="items[0][title]" placeholder="e.g., Lobby Curtains" required>
                    </div>
                    <div class="form-group fg-amount">
                        <label class="field-label">Estimated Amount (IDR)</label>
                        <input type="number" class="item-amount" name="items[0][estimated_amount]" value="0" min="0" required>
                    </div>
                    <div class="form-group fg-notes">
                        <label class="field-label">Notes</label>
                        <input type="text" name="items[0][notes]" placeholder="Notes/ Description request">
                    </div>
                    <div class="form-group fg-invoice">
                        <label class="field-label">Invoice (Optional)</label>
                        <label class="upload-invoice-label">
                            <input type="file" hidden accept=".pdf,.jpg,.jpeg,.png" name="items[0][invoice]">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            <span>Upload Invoice</span>
                        </label>
                    </div>
                    <div class="form-group fg-payment">
                        <label class="field-label">Payment Method</label>
                        <select name="items[0][payment_method]">
                            <option value="">Select Method</option>
                            <option value="Out of Pocket">Out of Pocket</option>
                            <option value="Company Card">Company Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="fg-del">
                        <button type="button" class="btn-del-row">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add Item -->
            <button type="button" class="btn-add-item" id="btnAddItem">
                <i class="fa-solid fa-circle-plus"></i>
                Add Item
            </button>

            <!-- Requested By -->
            <div class="form-group row-requested">
                <label class="field-label">Requested By</label>
                <input type="text" name="requested_by" placeholder="e.g., Aris K." required>
            </div>

            <!-- Grand Total -->
            <div class="grand-total-wrap">
                <span class="gt-label">Grand Total</span>
                <span class="gt-amount">Total Estimated Amount: IDR <span id="grandTotalVal">0</span></span>
            </div>

        </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('overlayExpense')">Cancel</button>
            <button type="submit" class="btn-submit" form="formExpense">Submit Request</button>
        </div>

    </div>
</div>