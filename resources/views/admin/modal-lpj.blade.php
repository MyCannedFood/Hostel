{{-- resources/views/admin/partials/modal-lpj.blade.php --}}

<div class="overlay" id="overlayLpj">
    <div class="modal modal-lpj">

        <div class="modal-headerr">
            <h3>Accountability Report</h3>
        </div>

        <div class="modal-body lpj-body">
        <form id="formLpj" onsubmit="return false;">

            <!-- ROW 1: Select Request + Category -->
            <div class="row-title-cat" style="margin-bottom: 0;">
                <div class="form-group fg-title">
                    <label class="field-label">Select Approved Request</label>
                    <select>
                        <option value="" disabled selected>Select a pending approved request...</option>
                        <option>#EXP-2024-001: Lobby Curtains Replacement</option>
                        <option>#EXP-2024-002: Laundry Equipment Repair</option>
                        <option>#EXP-2024-003: Bamboo Fencing Materials</option>
                    </select>
                </div>
                <div class="form-group fg-cat">
                    <label class="field-label">Category</label>
                    <select>
                        <option value="" disabled selected>Select Category</option>
                        <option>Maintenance</option>
                        <option>Operational</option>
                        <option>Utilities</option>
                        <option>Marketing</option>
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

                <!-- Row 1: pre-filled, belum upload invoice -->
                <div class="lpj-item-entry">
                    <div class="form-group lpj-fg-amount">
                        <input type="number" class="lpj-est-amount" value="1500000" min="0" oninput="updateLpjTotals()">
                    </div>
                    <div class="form-group lpj-fg-notes">
                        <input type="text" value="Bamboo fencing materials" placeholder="Add description...">
                    </div>
                    <div class="form-group lpj-fg-invoice">
                        <label class="upload-invoice-label lpj-upload">
                            <input type="file" hidden accept=".pdf,.jpg,.jpeg,.png" onchange="handleLpjUpload(this)">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            <span>Upload Invoice</span>
                        </label>
                    </div>
                    <div class="form-group lpj-fg-actual">
                        <div class="input-idr-wrap">
                            <span class="idr-prefix">IDR</span>
                            <input type="number" class="lpj-actual-amount" value="0" min="0" oninput="updateLpjTotals()">
                        </div>
                    </div>
                    <div class="lpj-fg-del">
                        <button type="button" class="btn-del-row" onclick="removeLpjRow(this)">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Row 2: pre-filled, sudah upload invoice (badge hijau) -->
                <div class="lpj-item-entry">
                    <div class="form-group lpj-fg-amount">
                        <input type="number" class="lpj-est-amount" value="250000" min="0" oninput="updateLpjTotals()">
                    </div>
                    <div class="form-group lpj-fg-notes">
                        <input type="text" value="Natural hemp twine" placeholder="Add description...">
                    </div>
                    <div class="form-group lpj-fg-invoice">
                        <div class="upload-done-badge" title="receipt.jpg">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>receipt.jpg</span>
                        </div>
                    </div>
                    <div class="form-group lpj-fg-actual">
                        <div class="input-idr-wrap">
                            <span class="idr-prefix">IDR</span>
                            <input type="number" class="lpj-actual-amount" value="245000" min="0" oninput="updateLpjTotals()">
                        </div>
                    </div>
                    <div class="lpj-fg-del">
                        <button type="button" class="btn-del-row" onclick="removeLpjRow(this)">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Row 3: kosong -->
                <div class="lpj-item-entry">
                    <div class="form-group lpj-fg-amount">
                        <input type="number" class="lpj-est-amount" placeholder="0" min="0" oninput="updateLpjTotals()">
                    </div>
                    <div class="form-group lpj-fg-notes">
                        <input type="text" placeholder="Add description...">
                    </div>
                    <div class="form-group lpj-fg-invoice">
                        <label class="upload-invoice-label lpj-upload">
                            <input type="file" hidden accept=".pdf,.jpg,.jpeg,.png" onchange="handleLpjUpload(this)">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            <span>Upload</span>
                        </label>
                    </div>
                    <div class="form-group lpj-fg-actual">
                        <div class="input-idr-wrap">
                            <span class="idr-prefix">IDR</span>
                            <input type="number" class="lpj-actual-amount" placeholder="0" min="0" oninput="updateLpjTotals()">
                        </div>
                    </div>
                    <div class="lpj-fg-del">
                        <button type="button" class="btn-del-row" onclick="removeLpjRow(this)">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- ADD ITEM + TOTALS -->
            <div class="lpj-bottom-row">
                <button type="button" class="btn-add-lpj" id="btnAddLpj" onclick="addLpjRow()">
                    + ADD ITEM
                </button>
                <div class="lpj-totals">
                    <div class="lpj-total-row">
                        <span class="lpj-total-label">Total Estimated:</span>
                        <span class="lpj-total-val" id="lpjTotalEst">IDR 1,750,000</span>
                    </div>
                    <div class="lpj-total-row">
                        <span class="lpj-total-label">Total Actual Spent:</span>
                        <span class="lpj-total-val" id="lpjTotalActual">IDR 245,000</span>
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