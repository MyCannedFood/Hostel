<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('experience.payment_method_title') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="payment-method-page">

    {{-- Stepper --}}
    <nav class="exp-stepper">
        <div class="exp-step exp-step--done">
            <a href="{{ route('experience.booking-detail', $booking['experience_id']) }}" class="step-link">{{ __('experience.step_detail') }}</a>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--active">
            <span class="exp-step-number">2.</span>
            <span class="exp-step-label">{{ __('experience.step_payment_method') }}</span>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--pending">
            <span class="exp-step-label">{{ __('experience.step_payment') }}</span>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--pending">
            <span class="exp-step-label">{{ __('experience.step_success') }}</span>
        </div>
    </nav>

    <h1 class="page-title">{{ __('experience.payment_method_title') }}</h1>

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

                <div style="margin-top: 32px;">
                    {{-- QRIS --}}
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
                                <span class="option-label">{{ __('experience.ewallet_mobile_banking') }}</span>
                                <span class="option-title">{{ __('experience.qris') }}</span>
                            </div>
                        </div>
                    </label>

                    {{-- Virtual Account --}}
                    <label>
                        <input type="radio" name="payment_method" value="Virtual Account" class="payment-radio" style="display:none;">
                        <div class="payment-option" onclick="selectPaymentOption(this)">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 21h18"/><path d="M3 10h18"/>
                                    <path d="M5 10v7"/><path d="M9 10v7"/><path d="M15 10v7"/><path d="M19 10v7"/>
                                    <path d="M12 2l-10 6h20l-10-6z"/>
                                </svg>
                            </div>
                            <div class="option-text">
                                <span class="option-label">{{ __('experience.bank_transfer') }}</span>
                                <span class="option-title">{{ __('experience.va') }}</span>
                            </div>
                        </div>
                    </label>

                    {{-- Credit Card --}}
                    <label>
                        <input type="radio" name="payment_method" value="Credit Card" class="payment-radio" style="display:none;">
                        <div class="payment-option" onclick="selectPaymentOption(this)">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                                    <path d="M2 10h20"/>
                                </svg>
                            </div>
                            <div class="option-text">
                                <span class="option-label">{{ __('experience.debit_credit_card') }}</span>
                                <span class="option-title">{{ __('experience.credit_card') }}</span>
                            </div>
                        </div>
                    </label>
                </div>

                {{-- Promo Code --}}
                <div class="promo-section">
                    <label class="promo-label">{{ __('experience.promo_or_referral') }}</label>
                    <div class="promo-input-group">
                        <input type="text" class="promo-input" name="promo_code" placeholder="{{ __('experience.promo_placeholder') }}">
                        <button type="button" class="btn-apply">{{ __('experience.apply') }}</button>
                    </div>
                </div>
            </div>

            {{-- Right Column: Summary --}}
            <div class="summary-col">
                <div class="summary-card">
                    <div class="summary-decor"></div>
                    <h2>{{ __('experience.summary') }}</h2>

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
                                {{ __('experience.date') }}: {{ \Carbon\Carbon::parse($booking['scheduled_date'])->format('d/m/Y') }}
                            </div>
                            <div class="item-meta">
                                {{ __('experience.guests') }}: {{ $booking['guest_count'] }} {{ $booking['guest_count'] > 1 ? __('experience.adults') : __('experience.adult') }}
                            </div>
                        </div>
                    </div>

                    <div class="summary-breakdown">
                        <div class="breakdown-row">
                            <span>{{ __('experience.subtotal') }}</span>
                            <span class="val">IDR {{ number_format($booking['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="breakdown-row discount">
                            <span>{{ __('experience.promo_discount') }}</span>
                            <span class="val">
                                {{ $booking['promo_discount'] > 0 ? '- IDR ' . number_format($booking['promo_discount'], 0, ',', '.') : '-' }}
                            </span>
                        </div>
                        <div class="breakdown-row">
                            <span>{{ __('experience.tax_service') }}</span>
                            <span class="val">{{ __('experience.included') }}</span>
                        </div>
                    </div>

                    <div class="summary-total">
                        <span class="lbl">{{ __('experience.total') }}</span>
                        <span class="val">IDR {{ number_format($booking['total_amount'], 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-pay-now">
                        {{ __('experience.pay_now') }}
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <div class="help-text">
                    {{ __('experience.need_help') }} <a href="{{ route('contact') }}">{{ __('experience.contact_concierge') }}</a>
                </div>
            </div>
        </div>

    </form>
</main>

<footer class="bottom-bar">
    <a href="{{ route('experience.booking-detail', $booking['experience_id']) }}" class="btn-back-details">
        {{ __('experience.back_to_details') }}
    </a>
</footer>

<script>
    function selectPaymentOption(clickedDiv) {
        // Visual: hapus active dari semua option
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        clickedDiv.classList.add('active');

        // Centang radio yang ada di dalam label parent
        const radio = clickedDiv.closest('label')?.querySelector('.payment-radio');
        if (radio) radio.checked = true;
    }
</script>

</body>
</html>