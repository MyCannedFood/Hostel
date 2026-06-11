<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('experience.experience_payment_title') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{--
    ══════════════════════════════════════════════════════
    MIDTRANS SNAP — Uncomment saat akun Midtrans siap
    ══════════════════════════════════════════════════════
    @if(config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js"
                data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
    ══════════════════════════════════════════════════════
    --}}
</head>
<body class="payment-page">

@include('components.navbar')

<main>
    {{-- Breadcrumb Steps --}}
    <section class="payment-steps">
        <div class="steps-container">
            <div class="step step--done">
                <a href="{{ route('experience.booking-detail', $booking['experience_id']) }}" class="step-link">{{ __('experience.step_detail') }}</a>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <a href="{{ route('experience.payment-method') }}" class="step-link">{{ __('experience.step_payment_method') }}</a>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--active">
                <span class="step-number">3.</span>
                <span class="step-label">{{ __('experience.step_payment') }}</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--pending">
                <span class="step-label">{{ __('experience.step_success') }}</span>
            </div>
        </div>
    </section>

    {{-- Flash Error --}}
    @if(session('error'))
        <div style="max-width:720px;margin:16px auto;padding:12px 16px;background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;color:#dc2626;font-size:13px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="payment-header">
        <h1 class="payment-title">{{ __('experience.experience_payment_title') }}</h1>
        <p class="payment-subtitle">{{ __('experience.payment_subtitle') }}</p>
    </div>

    {{-- Main Content --}}
    <section class="payment-content">

        {{-- Left: Experience Detail --}}
        <div class="payment-detail">
            <div class="detail-image-wrapper">
                @if($experience->cover_image)
                    <img src="{{ asset($experience->cover_image) }}"
                         alt="{{ $experience->name }}" class="detail-image">
                @else
                    <img src="https://images.unsplash.com/photo-1596431976070-13f59049a4f4?auto=format&fit=crop&q=80&w=800"
                         alt="{{ $experience->name }}" class="detail-image">
                @endif
            </div>

            <div class="detail-body">
                <h2 class="detail-title">{{ $experience->name }}</h2>
                <p class="detail-desc">
                    {{ $experience->short_description ?? $experience->name . ' ' . __('experience.experience_label') . ' di AlaSare.' }}
                </p>

                @if($experience->inclusions && count($experience->inclusions))
                <div class="detail-inclusions">
                    @foreach($experience->inclusions as $inclusion)
                        <span class="inclusion-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            {{ $inclusion }}
                        </span>
                    @endforeach
                </div>
                @endif

                <hr class="detail-divider">

                <div class="detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">{{ __('experience.date') }}</span>
                        <span class="meta-value">
                            {{ \Carbon\Carbon::parse($booking['scheduled_date'])->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">{{ __('experience.time_slot') }}</span>
                        <span class="meta-value">{{ $booking['time_slot'] }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">{{ __('experience.guests') }}</span>
                        <span class="meta-value">{{ str_pad($booking['guest_count'], 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">{{ __('experience.name') }}</span>
                        <span class="meta-value">{{ $booking['guest_name'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Payment Summary --}}
        <div class="payment-summary">
            <h3 class="summary-title">{{ __('experience.summary') }}</h3>

            <div class="summary-rows">
                <div class="summary-row">
                    <span class="summary-key">{{ __('experience.subtotal_label') }}</span>
                    <span class="summary-val">IDR {{ number_format($booking['subtotal'], 0, ',', '.') }}</span>
                </div>
                @if(($booking['promo_discount'] ?? 0) > 0)
                <div class="summary-row">
                    <span class="summary-key">{{ __('experience.promo_discount_label') }}</span>
                    <span class="summary-val summary-val--discount">
                        - IDR {{ number_format($booking['promo_discount'], 0, ',', '.') }}
                    </span>
                </div>
                @endif
                <div class="summary-row">
                    <span class="summary-key">{{ __('experience.taxes_service') }}</span>
                    <span class="summary-val">{{ __('experience.included') }}</span>
                </div>
            </div>

            <div class="summary-total">
                <span class="total-label">{{ __('experience.total_amount') }}</span>
                <span class="total-amount">IDR {{ number_format($booking['total_amount'], 0, ',', '.') }}</span>
            </div>

            <div class="summary-payment-method">
                <p class="method-text">
                    {{ __('experience.selected_payment', ['method' => $booking['payment_method']]) }}
                </p>

                {{--
                ══════════════════════════════════════════════════════
                MIDTRANS SNAP — Uncomment saat akun siap
                Hapus seluruh blok "QR Placeholder" di bawah ini,
                dan uncomment blok ini sebagai gantinya.
                ══════════════════════════════════════════════════════

                @if($snapToken)
                    <button id="pay-button" class="confirm-btn" style="width:100%;margin-top:16px;">
                        Bayar Sekarang
                    </button>
                    <script>
                        document.getElementById('pay-button').addEventListener('click', function () {
                            window.snap.pay('{{ $snapToken }}', {
                                onSuccess: function (result) {
                                    // Pembayaran berhasil → simpan booking ke DB
                                    fetch('{{ route("experience.payment.confirm") }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ midtrans_result: result })
                                    }).then(() => {
                                        window.location.href = '{{ route("experience.success") }}';
                                    });
                                },
                                onPending: function (result) {
                                    console.log('Pending:', result);
                                },
                                onError: function (result) {
                                    alert('Pembayaran gagal. Silakan coba lagi.');
                                    console.error('Error:', result);
                                },
                                onClose: function () {
                                    // User menutup popup tanpa bayar — tidak perlu action
                                }
                            });
                        });
                    </script>
                @else
                    <p style="color:#dc2626;font-size:13px;margin-top:8px;">
                        Gagal memuat payment gateway. Silakan kembali dan coba lagi.
                    </p>
                @endif

                ══════════════════════════════════════════════════════
                --}}

                {{-- ── QR Placeholder (hapus blok ini saat Midtrans aktif) ── --}}
                <p class="scan-label">{{ __('experience.scan_to_pay') }}</p>
                <div class="qr-wrapper">
                    <img src="{{ $qrCodeUrl }}"
                         alt="{{ __('experience.scan_to_pay') }}"
                         class="ticket-qr-img">
                </div>
                <p style="font-size:11px;color:rgba(26,61,10,0.45);text-align:center;margin-top:4px;">
                    {{ __('experience.booking_id') }}: {{ $booking['pending_ticket_id'] }}
                </p>

                <div class="awaiting-timer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ __('experience.awaiting_payment') }} <span id="countdown">14:59</span>
                </div>

                <form action="{{ route('experience.payment.confirm') }}" method="POST">
                    @csrf
                    <button type="submit" class="confirm-btn">{{ __('experience.i_have_paid') }}</button>
                </form>
                {{-- ── End QR Placeholder ── --}}

                <p class="secured-note">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    {{ __('experience.secured_by') }}
                </p>
            </div>
        </div>

    </section>

    <div class="page-secured">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        {{ __('experience.secured_encryption') }}
    </div>

</main>

<div class="back-bar">
    <a href="{{ route('experience.payment-method') }}" class="back-btn">{{ __('experience.back_to_payment_method') }}</a>
</div>

<x-whatsapp_floating />

<script>
    // Countdown 15 menit
    (function () {
        let total = 14 * 60 + 59;
        const el  = document.getElementById('countdown');
        if (!el) return;
        const t = setInterval(function () {
            if (total <= 0) { clearInterval(t); el.textContent = '00:00'; return; }
            total--;
            el.textContent =
                Math.floor(total / 60).toString().padStart(2, '0') + ':' +
                (total % 60).toString().padStart(2, '0');
        }, 1000);
    })();
</script>

</body>
</html>