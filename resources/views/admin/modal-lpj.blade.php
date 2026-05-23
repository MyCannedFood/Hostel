{{-- resources/views/admin/partials/modal-lpj.blade.php --}}

<div class="overlay" id="overlayLpj">

    <div class="modal">

        <div class="modal-header">

            <h3>Upload LPJ</h3>

            <button class="modal-close" onclick="closeModal('overlayLpj')">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form>

            <div class="form-group">
                <label>Select Approved Request</label>
                <select>
                    <option>#EXP-2024-001: Lobby Curtains Replacement</option>
                    <option>#EXP-2024-002: Laundry Equipment Repair</option>
                </select>
            </div>

            <div class="form-group">
                <label>Actual Amount Spent</label>
                <div class="input-prefix">
                    <span>IDR</span>
                    <input type="number" placeholder="0">
                </div>
            </div>

            <div class="form-group">
                <label>Date of Spending</label>
                <input type="date">
            </div>

            <div class="form-group">
                <label>Upload Proof of Purchase</label>
                <label class="upload-box">
                    <input type="file" hidden>
                    <div class="upload-content">
                        <i class="fa-solid fa-file-arrow-up"></i>
                        <span>Upload receipts/invoices</span>
                    </div>
                </label>
            </div>

            <div class="form-group">
                <label>Notes / Discrepancy Explanation</label>
                <textarea rows="5" placeholder="Explain any difference between estimated and actual spending..."></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('overlayLpj')">Cancel</button>
                <button type="submit" class="btn-submit">Submit Report</button>
            </div>

        </form>

    </div>

</div>