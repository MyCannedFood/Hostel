<div class="overlay" id="overlayExpense">
    <div class="modal">

        <div class="modal-header">
            <h3>Budgetin and Request</h3>
        </div>

        <div class="modal-body">
        <form id="formExpense" onsubmit="return false;">

            <!-- ROW 1: Title + Category -->
            <div class="row-title-cat">
                <div class="form-group fg-title">
                    <label class="field-label">Expense Title / Item Description</label>
                    <input type="text" placeholder="e.g., Replacement of lobby curtains">
                </div>
                <div class="form-group fg-cat">
                    <label class="field-label">Category</label>
                    <select>
                        <option>Maintenance</option>
                        <option>Operational</option>
                        <option>Utilities</option>
                        <option>Marketing</option>
                    </select>
                </div>
            </div>

            <!-- ROW 2: Item entry -->
            <div id="itemRows">
                <div class="item-entry">
                    <div class="form-group fg-amount">
                        <label class="field-label">Estimated Amount (IDR)</label>
                        <input type="number" class="item-amount" value="0" min="0">
                    </div>
                    <div class="form-group fg-notes">
                        <label class="field-label">Notes</label>
                        <input type="text" placeholder="Notes/ Description request">
                    </div>
                    <div class="form-group fg-invoice">
                        <label class="field-label">Invoice (Optional)</label>
                        <label class="upload-invoice-label">
                            <input type="file" hidden accept=".pdf,.jpg,.jpeg,.png">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            <span>Upload Invoice</span>
                        </label>
                    </div>
                    <div class="form-group fg-payment">
                        <label class="field-label">Payment Method</label>
                        <select>
                            <option>Out of Pocket</option>
                            <option>Company Card</option>
                            <option>Bank Transfer</option>
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
                <input type="text" value="AlaSare Admin" readonly>
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