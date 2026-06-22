{{-- Form checkout tamu: staying fee, deposit, tambahan charges, guest status --}}
<form class="admin-checkout-form" id="adminGuestCheckoutForm" method="POST" action="{{ route('admin.manage_guests.checkout') }}" novalidate>
    @csrf
    <input type="hidden" name="booking_code" id="checkout_booking_code" value="">

    <section class="admin-checkout-section">
        <h3 class="admin-checkout-section-title">Payment Preview</h3>

        {{-- Booking Code & Guest Code info --}}
        <div class="admin-checkout-booking-info" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 18.75px; color: #1a3d0a;">
            <span class="admin-checkout-info-label" style="font-weight: bold;">Booking Code</span>
            <strong id="checkoutBookingRef" class="admin-checkout-info-value" style="color: #D9864A; font-weight: bold;">—</strong>
        </div>
        <div class="admin-checkout-booking-info" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-size: 18.75px; color: #1a3d0a;">
            <span class="admin-checkout-info-label" style="font-weight: bold;">Guest ID</span>
            <strong id="checkoutGuestCode" class="admin-checkout-info-value" style="color: #D9864A; font-weight: bold;">—</strong>
        </div>


        {{-- List charge tambahan yang ditambahkan admin --}}
        <ul class="admin-checkout-charges" id="checkoutChargesList"></ul>

        {{-- Form tambah charge baru --}}
        <div class="admin-checkout-add-row">
            <div class="admin-checkout-add-fields">
                <input type="text" id="checkout_charge_desc" class="admin-checkout-input" placeholder="Description" aria-label="Description">
                <input type="text" id="checkout_charge_nominal" class="admin-checkout-input admin-checkout-input-nominal" placeholder="Nominal (e.g. 50000)" aria-label="Nominal">
            </div>
            <div class="admin-checkout-add-actions">
                <button type="button" class="admin-checkout-btn-add" id="checkoutAddCharge">
                    <span aria-hidden="true">+</span> Add Charge
                </button>
            </div>
        </div>

        {{-- Summary kalkulasi --}}
        <div class="admin-checkout-summary">
            <div class="admin-checkout-summary-row">
                <span class="admin-checkout-summary-label">Staying Fee</span>
                <strong id="checkoutStayingFee">—</strong>
            </div>
            <div class="admin-checkout-summary-row extra-charges" id="checkoutExtraRow" style="display:none">
                <span class="admin-checkout-summary-label">Extra Charges</span>
                <strong id="checkoutExtraTotal" class="admin-checkout-extra">—</strong>
            </div>
            <div class="admin-checkout-summary-row deposit" id="checkoutDepositRow" style="display:none">
                <span class="admin-checkout-summary-label">Deposit</span>
                <strong id="checkoutDeposit">—</strong>
            </div>
            <div class="admin-checkout-summary-row refunded" id="checkoutRefundedRow" style="display:none">
                <span class="admin-checkout-summary-label">Refunded</span>
                <strong id="checkoutRefunded" class="admin-checkout-refunded">—</strong>
            </div>
            <div class="admin-checkout-summary-row additional-charge" id="checkoutAdditionalRow" style="display:none">
                <span class="admin-checkout-summary-label">Additional Charge</span>
                <strong id="checkoutAdditional" class="admin-checkout-additional">—</strong>
            </div>
        </div>
    </section>

    <section class="admin-checkout-section">
        <h3 class="admin-checkout-section-title">Guest Status</h3>
        <div class="admin-checkout-status-row">
            <textarea id="checkout_notes" name="notes" class="admin-checkout-input admin-checkout-notes" rows="3" placeholder="Any additional notes..." aria-label="Notes"></textarea>
            <select id="checkout_status" name="status" class="admin-checkout-status-select" aria-label="Guest status">
                <option value="safe" selected>Safe</option>
                <option value="blacklist">Blacklist</option>
            </select>
        </div>
    </section>
</form>
