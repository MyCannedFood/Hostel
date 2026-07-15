<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-en="Payment Method - AlaSare" data-id="Metode Pembayaran - AlaSare">{{ __('experience.payment_method_title') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@php
    $generalSettings = \App\Models\GeneralSetting::getSection('operational_policies')->data;
    $taxIncluded = !($generalSettings['tax_included'] ?? true);
    $govTax = $generalSettings['government_tax'] ?? 11;
    $srvCharge = $generalSettings['service_charge'] ?? 5;
    $totalTaxPercent = $govTax + $srvCharge;

    $afterDiscount = max(0, $booking['subtotal'] - ($booking['promo_discount'] ?? 0));
    $taxServiceVal = ($afterDiscount * $totalTaxPercent) / 100;
@endphp

@include('components.navbar')

<main class="payment-method-page">

    {{-- Stepper --}}
    <nav class="exp-stepper">
        <div class="exp-step exp-step--done">
            <a href="{{ route('experience.booking-detail', $booking['experience_id']) }}" class="step-link" data-en="Detail" data-id="Detail">{{ __('experience.step_detail') }}</a>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--active">
            <span class="exp-step-number">2.</span>
            <span class="exp-step-label" data-en="Payment Method" data-id="Metode Pembayaran">{{ __('experience.step_payment_method') }}</span>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--pending">
            <span class="exp-step-label" data-en="Payment" data-id="Pembayaran">{{ __('experience.step_payment') }}</span>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--pending">
            <span class="exp-step-label" data-en="Success" data-id="Sukses">{{ __('experience.step_success') }}</span>
        </div>
    </nav>

    <h1 class="page-title" data-en="Payment Method" data-id="Metode Pembayaran">{{ __('experience.payment_method_title') }}</h1>

    <form action="{{ route('experience.payment-method.store') }}" method="POST">
        @csrf

        <div class="payment-grid">
            {{-- Left Column: Payment Options --}}
            <div class="payment-options-col">

                {{-- Validation errors --}}
                @if($errors->any())
                    <div style="margin-bottom:12px;padding:12px 16px;background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;color:#dc2626;font-size:13px;">
                        @foreach($errors->all() as $error)
                            <p style="margin:0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @php $expPaymentSettings = \App\Models\PaymentSetting::instance(); $customPayments = \App\Models\PaymentMethod::active()->ordered()->get(); @endphp
                <div style="margin-top: 32px;">
                    @if($expPaymentSettings->qris_enabled)
                    <label>
                        <input type="radio" name="payment_method" value="QRIS" class="payment-radio" checked style="display:none;">
                        <div class="payment-option active" onclick="selectPaymentOption(this)">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 3h6v6H3z"/><path d="M15 3h6v6h-6z"/>
                                    <path d="M3 15h6v6H3z"/>
                                    <path d="M15 15h2v2h-2z"/><path d="M19 19h2v2h-2z"/>
                                    <path d="M15 19h2v2h-2z"/><path d="M19 15h2v2h-2z"/>
                                </svg>
                            </div>
                            <div class="option-text">
                                <span class="option-label" data-en="E-WALLET & MOBILE BANKING" data-id="E-WALLET & MOBILE BANKING">{{ __('experience.ewallet_mobile_banking') }}</span>
                                <span class="option-title" data-en="QRIS" data-id="QRIS">{{ __('experience.qris') }}</span>
                            </div>
                        </div>
                    </label>
                    @endif

                    @if($expPaymentSettings->cash_enabled)
                    <label>
                        <input type="radio" name="payment_method" value="Cash" class="payment-radio" style="display:none;">
                        <div class="payment-option" onclick="selectPaymentOption(this)">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                </svg>
                            </div>
                            <div class="option-text">
                                <span class="option-label" data-en="CASH" data-id="TUNAI">Cash</span>
                                <span class="option-title">{{ __('experience.cash') ?? 'Cash' }}</span>
                            </div>
                        </div>
                    </label>
                    @endif

                    @if($expPaymentSettings->midtrans_enabled)
                    <label>
                        <input type="radio" name="payment_method" value="Midtrans" class="payment-radio" style="display:none;">
                        <div class="payment-option" onclick="selectPaymentOption(this)">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                                    <path d="M2 10h20"/>
                                    <path d="M2 15h20"/>
                                </svg>
                            </div>
                            <div class="option-text">
                                <span class="option-label" data-en="MIDTRANS" data-id="MIDTRANS">Midtrans</span>
                                <span class="option-title" data-en="Virtual Account / Credit Card / E-Wallet" data-id="Virtual Account / Kartu Kredit / E-Wallet">Virtual Account / Credit Card / E-Wallet</span>
                            </div>
                        </div>
                    </label>
                    @endif

                    @foreach($customPayments as $cpm)
                    <label>
                        <input type="radio" name="payment_method" value="{{ $cpm->type }}" class="payment-radio" style="display:none;">
                        <div class="payment-option" onclick="selectPaymentOption(this)">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                                    <path d="M2 10h20"/>
                                </svg>
                            </div>
                            <div class="option-text">
                                <span class="option-label">{{ $cpm->provider_name }}</span>
                                <span class="option-title">{{ $cpm->account_number ?? $cpm->email_username ?? '' }}</span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Promo Code --}}
                <div class="promo-section">
                    <label class="promo-label">PROMO OR REFERRAL CODE</label>
                    <div class="promo-input-group" id="promoInputGroup">
                        <input type="text" class="promo-input" id="promoCodeInput"
                               name="promo_code"
                               value="{{ $booking['promo_code'] ?? '' }}"
                               placeholder="e.g. ALASAREZEN"
                               style="text-transform:uppercase;letter-spacing:0.05em;"
                               {{ !empty($booking['promo_code']) ? 'readonly' : '' }}>
                        <button type="button" class="btn-apply" id="promoBtn"
                                onclick="{{ !empty($booking['promo_code']) ? 'removePromoCode()' : 'applyPromoCode()' }}">
                            {{ !empty($booking['promo_code']) ? 'Remove' : 'Apply' }}
                        </button>
                    </div>

                    {{-- Feedback messages --}}
                    <div id="promoSuccess" style="display:{{ !empty($booking['promo_code']) ? 'flex' : 'none' }};align-items:center;gap:6px;margin-top:8px;font-size:12px;color:#2a6e32;font-weight:600;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span id="promoSuccessText">
                            @if(!empty($booking['promo_code']))
                                Promo <strong>{{ $booking['promo_code'] }}</strong> applied!
                            @endif
                        </span>
                    </div>
                    <div id="promoError" style="display:none;align-items:center;gap:6px;margin-top:8px;font-size:12px;color:#b03020;font-weight:600;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <span id="promoErrorText"></span>
                    </div>
                </div>

            </div>

            {{-- Right Column: Summary --}}
            <div class="summary-col">
                <div class="summary-card">
                    <div class="summary-decor"></div>
                    <h2 data-en="Summary" data-id="Ringkasan">{{ __('experience.summary') }}</h2>

                    <div class="summary-item">
                        @if($experience->cover_image)
                            <img src="{{ asset($experience->cover_image) }}" alt="{{ $experience->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1596431976070-13f59049a4f4?auto=format&fit=crop&q=80&w=800"
                                 alt="{{ $experience->name }}">
                        @endif
                        <div class="item-info">
                            <h3 class="item-title">{{ $experience->name }}</h3>
                            <div class="item-meta">
                                <span data-en="Date" data-id="Tanggal">{{ __('experience.date') }}</span>: {{ \Carbon\Carbon::parse($booking['scheduled_date'])->format('d/m/Y') }}
                            </div>
                            <div class="item-meta">
                                <span data-en="Guests" data-id="Tamu">{{ __('experience.guests') }}</span>: {{ $booking['guest_count'] }} {{ $booking['guest_count'] > 1 ? __('experience.adults') : __('experience.adult') }}
                            </div>
                        </div>
                    </div>

                    <div class="summary-breakdown">
                        <div class="breakdown-row">
                            <span data-en="SUBTOTAL" data-id="SUB TOTAL">{{ __('experience.subtotal') }}</span>
                            <span class="val">IDR {{ number_format($booking['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="breakdown-row discount" id="promoDiscountRow"
                             style="{{ ($booking['promo_discount'] ?? 0) > 0 ? '' : 'display:none;' }}">
                            <span>PROMO DISCOUNT</span>
                            <span class="val" id="promoDiscountDisplay">
                                @if(($booking['promo_discount'] ?? 0) > 0)
                                    - IDR {{ number_format($booking['promo_discount'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>

                        <div class="breakdown-row">
                            <span data-en="TAX & SERVICE ({{ $totalTaxPercent }}%)" data-id="PAJAK & LAYANAN ({{ $totalTaxPercent }}%)">
                                {{ app()->getLocale() === 'en' ? "TAX & SERVICE ($totalTaxPercent%)" : "PAJAK & LAYANAN ($totalTaxPercent%)" }}
                            </span>
                            @if($taxIncluded)
                                <span class="val" data-en="Included" data-id="Termasuk">{{ __('experience.included') }}</span>
                            @else
                                <span class="val" id="taxServiceDisplay">IDR {{ number_format($taxServiceVal, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="summary-total">
                        <span class="lbl">Total</span>
                        <span class="val" id="summaryTotal">IDR {{ number_format($booking['total_amount'], 0, ',', '.') }}</span>
                    </div>


                    <button type="submit" class="btn-pay-now" data-en="PAY NOW" data-id="BAYAR SEKARANG">
                        {{ __('experience.pay_now') }}
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <div class="help-text">
                    <span data-en="Need help?" data-id="Butuh bantuan?">{{ __('experience.need_help') }}</span>
                    <a href="{{ route('contact') }}">
                        <span data-en="Contact our Wellness Concierge" data-id="Hubungi Wellness Concierge kami">{{ __('experience.contact_concierge') }}</span>
                    </a>
                </div>
            </div>
        </div>

    </form>
</main>

<footer class="bottom-bar">
    <a href="{{ route('experience.booking-detail', $booking['experience_id']) }}" class="btn-back-details" data-en="Back To Details" data-id="Kembali ke Detail">
        {{ __('experience.back_to_details') }}
    </a>
</footer>

<script>
    function selectPaymentOption(clickedDiv) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        clickedDiv.classList.add('active');
        const radio = clickedDiv.closest('label')?.querySelector('.payment-radio');
        if (radio) radio.checked = true;
    }

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content
        || '{{ csrf_token() }}';

    const subtotal = {{ $booking['subtotal'] }};
    const taxIncluded = {{ $taxIncluded ? 'true' : 'false' }};
    const totalTaxPercent = {{ $totalTaxPercent }};

    function formatIDR(amount) {
        return 'IDR ' + parseInt(amount).toLocaleString('id-ID');
    }

    async function applyPromoCode() {
        const code = document.getElementById('promoCodeInput').value.trim().toUpperCase();
        if (!code) {
            showPromoError('Please enter a promo code.');
            return;
        }

        const btn = document.getElementById('promoBtn');
        btn.disabled = true;
        btn.textContent = 'Checking...';

        try {
            const res  = await fetch('{{ route("experience.promo.apply") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ code }),
            });
            const data = await res.json();

            if (!res.ok || !data.success) {
                showPromoError(data.message || 'Invalid promo code.');
                btn.disabled = false;
                btn.textContent = 'Apply';
                return;
            }

            // Success
            document.getElementById('promoCodeInput').readOnly = true;
            btn.textContent = 'Remove';
            btn.onclick = removePromoCode;
            btn.disabled = false;

            // Update UI
            showPromoSuccess(`Promo <strong>${code}</strong> applied! You save ${formatIDR(data.discount)}.`);

            // Update summary
            document.getElementById('promoDiscountRow').style.display = '';
            document.getElementById('promoDiscountDisplay').textContent = '- ' + formatIDR(data.discount);
            document.getElementById('summaryTotal').textContent = formatIDR(data.total_amount);

            if (!taxIncluded) {
                const afterDiscount = subtotal - data.discount;
                const taxVal = data.total_amount - afterDiscount;
                const taxEl = document.getElementById('taxServiceDisplay');
                if (taxEl) taxEl.textContent = formatIDR(taxVal);
            }

        } catch (e) {
            showPromoError('Something went wrong. Please try again.');
            btn.disabled = false;
            btn.textContent = 'Apply';
        }
    }

    async function removePromoCode() {
        const btn = document.getElementById('promoBtn');
        btn.disabled = true;
        btn.textContent = 'Removing...';

        try {
            const res  = await fetch('{{ route("experience.promo.remove") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({}),
            });
            const data = await res.json();

            document.getElementById('promoCodeInput').value    = '';
            document.getElementById('promoCodeInput').readOnly = false;
            btn.textContent = 'Apply';
            btn.onclick     = applyPromoCode;
            btn.disabled    = false;

            hidePromoMessages();
            document.getElementById('promoDiscountRow').style.display = 'none';
            document.getElementById('summaryTotal').textContent = formatIDR(data.total_amount || subtotal);

            if (!taxIncluded) {
                const total = data.total_amount || (subtotal + (subtotal * totalTaxPercent / 100));
                const taxVal = total - subtotal;
                const taxEl = document.getElementById('taxServiceDisplay');
                if (taxEl) taxEl.textContent = formatIDR(taxVal);
            }

        } catch (e) {
            btn.disabled    = false;
            btn.textContent = 'Remove';
        }
    }

    function showPromoSuccess(html) {
        document.getElementById('promoError').style.display   = 'none';
        document.getElementById('promoSuccess').style.display = 'flex';
        document.getElementById('promoSuccessText').innerHTML = html;
    }
    function showPromoError(msg) {
        document.getElementById('promoSuccess').style.display = 'none';
        document.getElementById('promoError').style.display   = 'flex';
        document.getElementById('promoErrorText').textContent = msg;
    }
    function hidePromoMessages() {
        document.getElementById('promoSuccess').style.display = 'none';
        document.getElementById('promoError').style.display   = 'none';
    }

    // Auto uppercase saat user mengetik
    document.getElementById('promoCodeInput')?.addEventListener('input', function () {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });
</script>

</body>
</html>
