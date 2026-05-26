{{-- resources/views/admin/modal-lpj.blade.php --}}

<div class="overlay" id="overlayLpj">
    <div class="modal modal-lpj">

        <div class="modal-headerr">
            <h3>Accountability Report</h3>
        </div>

        <div class="modal-body lpj-body">
        <form id="formLpj" method="POST" action="{{ route('admin.budgeting.lpj.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- ROW 1: Select Approved Request -->
            <div class="row-title-cat" style="margin-bottom: 0;">
                <div class="form-group fg-title">
                    <label class="field-label">Select Approved Request</label>
                    <select name="budget_request_id" required>
                        <option value="" disabled selected>Select an approved request...</option>
                        {{-- Diisi oleh JS --}}
                    </select>
                </div>
            </div>

            <!-- DIVIDER -->
            <div class="lpj-divider"></div>

            <!-- COLUMN HEADERS -->
            <div class="lpj-col-headers">
                <div class="lpj-ch lpj-ch-amount">Estimated Amount (IDR)</div>
                <div class="lpj-ch lpj-ch-notes">Notes</div>
                <div class="lpj-ch lpj-ch-invoice">Invoice</div>
                <div class="lpj-ch lpj-ch-actual">Actual Amount Spent</div>
                <div class="lpj-ch-del"></div>
            </div>

            <!-- ITEM ROWS -->
            <div id="lpjItemRows">
                {{-- Diisi oleh JS setelah pilih request --}}
            </div>

            <!-- ADD ITEM + TOTALS -->
            <div class="lpj-bottom-row">
                <button type="button" class="btn-add-lpj" id="btnAddLpj">
                    + ADD ITEM
                </button>
                <div class="lpj-totals">
                    <div class="lpj-total-row">
                        <span class="lpj-total-label">Total Estimated:</span>
                        <span class="lpj-total-val" id="lpjTotalEst">IDR 0</span>
                    </div>
                    <div class="lpj-total-row">
                        <span class="lpj-total-label">Total Actual Spent:</span>
                        <span class="lpj-total-val" id="lpjTotalActual">IDR 0</span>
                    </div>
                </div>
            </div>

        </form>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('overlayLpj')">Cancel</button>
            <button type="submit" class="btn-submit" form="formLpj">Submit Report</button>
        </div>

    </div>
</div>