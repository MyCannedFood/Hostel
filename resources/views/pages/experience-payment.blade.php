<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Experience Payment - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="payment-page">

@php
    $experience = (object)[
        'name'              => 'Nature the Earth',
        'short_description' => 'A soulful journey to the heart of our teak forest. Plant a sapling to leave a legacy of growth and renewal.',
        'image'             => 'baju_kutu.png',
        'inclusions'        => ['Sapling Included', 'Tools & Gear', 'Local Guide', 'Refreshments'],
    ];

    $booking = (object)[
        'date'           => '2026-11-24',
        'time'           => '07:00',
        'guests'         => 1,
        'subtotal'       => 350000,
        'promo_discount' => 50000,
        'total_amount'   => 300000,
        'payment_method' => 'QRIS / E-Wallet',
        'id'             => 1,
    ];
@endphp

@include('components.navbar')

<main>
    {{-- Breadcrumb Steps --}}
    <section class="payment-steps">
        <div class="steps-container">
            <div class="step step--done">
                <a href="/experience/booking-detail" class="step-link">Detail</a>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <a href="/experience/payment-method" class="step-link">Payment Method</a>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--active">
                <span class="step-number">3.</span>
                <span class="step-label">Payment</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--pending">
                <span class="step-label">Success</span>
            </div>
        </div>
    </section>

    {{-- Page Header --}}
    <div class="payment-header">
        <h1 class="payment-title">Experience Payment</h1>
        <p class="payment-subtitle">Secure your moment of reconnection.</p>
    </div>

    {{-- Main Content --}}
    <section class="payment-content">

        {{-- Left: Experience Detail --}}
        <div class="payment-detail">
            <div class="detail-image-wrapper">
                <img
                    src="{{ asset('images/experience/' . $experience->image) }}"
                    alt="{{ $experience->name }}"
                    class="detail-image"
                    onerror="this.src='https://images.unsplash.com/photo-1611080911579-2cd1ab8b50e4?auto=format&fit=crop&q=80&w=800'"
                >
            </div>

            <div class="detail-body">
                <h2 class="detail-title">{{ $experience->name }}</h2>
                <p class="detail-desc">{{ $experience->short_description }}</p>

                {{-- Inclusions --}}
                <div class="detail-inclusions">
                    @foreach ($experience->inclusions as $inclusion)
                        <span class="inclusion-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ $inclusion }}
                        </span>
                    @endforeach
                </div>

                <hr class="detail-divider">

                {{-- Booking Info --}}
                <div class="detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Date</span>
                        <span class="meta-value">{{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Time</span>
                        <span class="meta-value">{{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Guests</span>
                        <span class="meta-value">{{ str_pad($booking->guests, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Payment Summary --}}
        <div class="payment-summary">
            <h3 class="summary-title">Summary</h3>

            <div class="summary-rows">
                <div class="summary-row">
                    <span class="summary-key">Subtotal</span>
                    <span class="summary-val">IDR {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                </div>
                @if ($booking->promo_discount > 0)
                <div class="summary-row">
                    <span class="summary-key">Promo Discount</span>
                    <span class="summary-val summary-val--discount">- IDR {{ number_format($booking->promo_discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="summary-row">
                    <span class="summary-key">Taxes & Service (21%)</span>
                    <span class="summary-val">Included</span>
                </div>
            </div>

            <div class="summary-total">
                <span class="total-label">Total Amount</span>
                <span class="total-amount">IDR {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
            </div>

            <div class="summary-payment-method">
                <p class="method-text">Selected Payment Method: {{ $booking->payment_method }}</p>

                @if ($booking->payment_method === 'QRIS / E-Wallet')
                    <p class="scan-label">Scan to Pay</p>
                    <div class="qr-wrapper">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=ALS-2026-NTE-01"
                        alt="QR Code"
                        class="ticket-qr-img">
                    </div>
                @endif

                <div class="awaiting-timer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Awaiting Payment... <span id="countdown">14:59</span>
                </div>

                <form action="/experience/success" method="GET">
                    <button type="submit" class="confirm-btn">I Have Completed Payment</button>
                </form>

                <p class="secured-note">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Secured by AlaSare Payment Gateway
                </p>
            </div>
        </div>

    </section>

    {{-- Footer Security Note --}}
    <div class="page-secured">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Secured by AlaSare Encryption
    </div>

</main>

{{-- Back to Payment Method --}}
<div class="back-bar">
    <a href="/experience/payment-method" class="back-btn">Back To Payment Method</a>
</div>

<x-whatsapp_floating />

<script>
    (function () {
        let total = 14 * 60 + 59;
        const el = document.getElementById('countdown');
        if (!el) return;
        const t = setInterval(function () {
            if (total <= 0) { clearInterval(t); el.textContent = '00:00'; return; }
            total--;
            const m = Math.floor(total / 60).toString().padStart(2, '0');
            const s = (total % 60).toString().padStart(2, '0');
            el.textContent = m + ':' + s;
        }, 1000);
    })();
</script>

</body>
</html>