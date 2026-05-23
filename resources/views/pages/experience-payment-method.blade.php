<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment Method - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>

@include('components.navbar')

<main class="payment-method-page">

    {{-- Stepper --}}
    <nav class="pm-stepper">
        <div class="pm-step completed">
            <span>DETAIL</span>
        </div>
        <div class="pm-step-divider">></div>
        <div class="pm-step active">
            <span>2. PAYMENT METHOD</span>
        </div>
        <div class="pm-step-divider">></div>
        <div class="pm-step">
            <span>PAYMENT</span>
        </div>
        <div class="pm-step-divider">></div>
        <div class="pm-step">
            <span>SUCCESS</span>
        </div>
    </nav>

    <h1 class="page-title">Payment Method</h1>

    <div class="payment-grid">
        {{-- Left Column --}}
        <div class="payment-options-col">
            <div class="payment-option active" onclick="selectPaymentOption(this)" style="margin-top: 32px;">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h6v6H3z"/><path d="M15 3h6v6h-6z"/><path d="M3 15h6v6H3z"/><path d="M15 15h2v2h-2z"/><path d="M19 19h2v2h-2z"/><path d="M15 19h2v2h-2z"/><path d="M19 15h2v2h-2z"/></svg>
                </div>
                <div class="option-text">
                    <span class="option-label">E-WALLET & MOBILE BANKING</span>
                    <span class="option-title">QRIS</span>
                </div>
            </div>

            <div class="payment-option" onclick="selectPaymentOption(this)">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 10v7"/><path d="M9 10v7"/><path d="M15 10v7"/><path d="M19 10v7"/><path d="M12 2l-10 6h20l-10-6z"/></svg>
                </div>
                <div class="option-text">
                    <span class="option-label">BANK TRANSFER</span>
                    <span class="option-title">VA (Virtual Account)</span>
                </div>
            </div>

            <div class="payment-option" onclick="selectPaymentOption(this)">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                </div>
                <div class="option-text">
                    <span class="option-label">DEBIT / CREDIT CARD</span>
                    <span class="option-title">Credit Card</span>
                </div>
            </div>

            <div class="promo-section">
                <label class="promo-label">PROMO OR REFERRAL CODE</label>
                <div class="promo-input-group">
                    <input type="text" class="promo-input" placeholder="Enter Promo/Referral Code">
                    <button type="button" class="btn-apply">Apply</button>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="summary-col">
            <div class="summary-card">
                <div class="summary-decor"></div>
                <h2>Summary</h2>
                <div class="summary-item">
                    <img src="{{ asset('images/experience/baju_kutu.png') }}" alt="Nature the earth">
                    <div class="item-info">
                        <h3 class="item-title">Nature the earth</h3>
                        <div class="item-meta">Date: 24/11/2024</div>
                        <div class="item-meta">Guests: 1 Adult</div>
                    </div>
                </div>

                <div class="summary-breakdown">
                    <div class="breakdown-row">
                        <span>SUBTOTAL</span>
                        <span class="val">IDR 350.000</span>
                    </div>
                    <div class="breakdown-row discount">
                        <span>PROMO DISCOUNT</span>
                        <span class="val">- IDR 50.000</span>
                    </div>
                    <div class="breakdown-row">
                        <span>TAX & SERVICE (21%)</span>
                        <span class="val">Included</span>
                    </div>
                </div>

                <div class="summary-total">
                    <span class="lbl">Total</span>
                    <span class="val">IDR 300.000</span>
                </div>

                <form action="/experience/payment" method="GET">
                    <button type="submit" class="btn-pay-now">
                        PAY NOW
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>
            </div>

            <div class="help-text">
                Need help? <a href="#">Contact our Wellness Concierge</a>
            </div>
        </div>
    </div>
</main>

<footer class="bottom-bar">
    <a href="/experience/booking-detail" class="btn-back-details">Back To Details</a>
</footer>

<script>
    function selectPaymentOption(element) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        element.classList.add('active');
    }
</script>

</body>
</html>
