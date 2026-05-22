<form class="admin-checkout-form" id="adminGuestCheckoutForm" novalidate>
    <section class="admin-checkout-section">
        <h3 class="admin-checkout-section-title">Payment Preview</h3>

        <ul class="admin-checkout-charges" id="checkoutChargesList"></ul>

        <div class="admin-checkout-add-row">
            <div class="admin-checkout-add-fields">
                <input type="text" id="checkout_charge_desc" class="admin-checkout-input" placeholder="Description" aria-label="Description">
                <input type="text" id="checkout_charge_nominal" class="admin-checkout-input admin-checkout-input-nominal" placeholder="Nominal" aria-label="Nominal">
            </div>
            <div class="admin-checkout-add-actions">
                <button type="button" class="admin-checkout-btn-add" id="checkoutAddCharge">
                    <span aria-hidden="true">+</span> Add
                </button>
            </div>
        </div>

        <div class="admin-checkout-summary">
            <div class="admin-checkout-summary-row">
                <span class="admin-checkout-summary-label">Staying Fee</span>
                <strong id="checkoutStayingFee">IDR 500.000</strong>
            </div>
            <div class="admin-checkout-summary-row deposit">
                <span class="admin-checkout-summary-label">Deposit</span>
                <strong id="checkoutDeposit">IDR 200.000</strong>
            </div>
            <div class="admin-checkout-summary-row refunded">
                <span class="admin-checkout-summary-label">Refunded</span>
                <strong id="checkoutRefunded">IDR 200.000</strong>
            </div>
        </div>
    </section>

    <section class="admin-checkout-section">
        <h3 class="admin-checkout-section-title">Guest Status</h3>
        <div class="admin-checkout-status-row">
            <textarea id="checkout_notes" name="notes" class="admin-checkout-input admin-checkout-notes" rows="3" placeholder="Any additional notes for us?" aria-label="Notes"></textarea>
            <select id="checkout_status" name="status" class="admin-checkout-status-select" aria-label="Guest status">
                <option value="safe" selected>Safe</option>
                <option value="blacklist">Blacklist</option>
            </select>
        </div>
    </section>
</form>
