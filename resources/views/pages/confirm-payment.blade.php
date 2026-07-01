<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-en="Confirm & Payment - AlaSare" data-id="Konfirmasi & Pembayaran - AlaSare">Confirm & Payment - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>

@include('components.navbar')

@php
    use Carbon\Carbon;

    // 1. Tangkap semua data dari URL GET Request
    $checkInParam = request()->query('check_in');
    $checkOutParam = request()->query('check_out');
    $nightsParam = (int) request()->query('nights', 1);
    $roomIdParam = request()->query('room_id');
    $bedIdParam = request()->query('bed_id');
    $addonsParam = request()->query('addons', '');
    $promoParam = request()->query('promo', '');
    $paymentMethod = request()->query('payment_method', 'QRIS / E-Wallet');

    // Data Tamu
    $guestName = request()->query('first_name', '') . ' ' . request()->query('last_name', '');
    $guestEmail = request()->query('email', '');
    $guestPhone = request()->query('country_code', '') . ' ' . request()->query('phone', '');

    // 2. Ambil data Room dan Bed dari Database
    $room = \App\Models\Room::find($roomIdParam);
    $bed = \App\Models\Bed::find($bedIdParam);

    $roomName = $room ? $room->name : 'Unknown Room';
    $bedName = $bed ? $bed->name : 'Unknown Bed';

    // 3. Kalkulasi Harga Kamar
    $basePrice = $bed && $bed->base_price > 0 ? $bed->base_price : ($room->base_price ?? 125000);
    $totalBedCost = $basePrice * max(1, $nightsParam);

    // 4. Kalkulasi Addons & Diskon Promo
    $addonIds = array_filter(explode(',', $addonsParam));
    $selectedAddons = \App\Models\Addon::whereIn('id', $addonIds)->get();

    $checkInDayName = $checkInParam ? Carbon::parse($checkInParam)->format('l') : Carbon::now()->format('l');

    $addonTotal = 0;
    $addonDetails = [];
    foreach($selectedAddons as $addon) {
        $isFree = $addon->is_auto_include && is_array($addon->include_days) && in_array($checkInDayName, $addon->include_days);
        $cost = $isFree ? 0 : $addon->price;
        $addonTotal += $cost;

        $addonDetails[] = [
            'name' => $addon->name,
            'note' => $isFree ? ($addon->note ?? '(For free)') : '',
            'cost' => $cost
        ];
    }

    $subTotal = $totalBedCost + $addonTotal;

    // Asumsi Promo Diskon 10% jika diisi (Bisa diganti dari database promo kamu)
    $promoDiscount = $promoParam ? ($subTotal * 0.10) : 0;

    // Asumsi Pajak & Servis 10%
    $tax = ($subTotal - $promoDiscount) * 0.10;

    $grandTotal = ($subTotal - $promoDiscount) + $tax;

    // Format Tanggal Display
    $displayCheckInDate = $checkInParam ? Carbon::parse($checkInParam)->format('d M Y') : '-';
    $displayCheckOutDate = $checkOutParam ? Carbon::parse($checkOutParam)->format('d M Y') : '-';
    $displayCheckInModal = $checkInParam ? Carbon::parse($checkInParam)->translatedFormat('d F Y') : '-';
    $displayCheckOutModal = $checkOutParam ? Carbon::parse($checkOutParam)->translatedFormat('d F Y') : '-';

    // Link kembali dengan membawa parameter utuh
    $queryParams = http_build_query(request()->all());
    $backToGuestDetailsUrl = url('/guest-details') . '?' . $queryParams;
@endphp

@if(strtolower($paymentMethod) === 'midtrans')
    @php
        $mtSettings = \App\Models\PaymentSetting::instance();
        $mtClientKey = $mtSettings->midtrans_client_key ?: config('midtrans.client_key');
    @endphp
    @if($mtSettings->midtrans_production || config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js"
                data-client-key="{{ $mtClientKey }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ $mtClientKey }}"></script>
    @endif
@endif

<main class="confirm-payment-page">

    {{-- Booking Stepper Aktif (Bisa Diklik) --}}
    <nav class="booking-stepper">
        <a href="{{ url('/calendar') }}?{{ $queryParams }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span data-en="Calendar" data-id="Kalender">Calendar</span>
        </a>
        <div class="step-divider"></div>
        <a href="{{ url('/room-selection') }}?{{ $queryParams }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span data-en="Room Selection" data-id="Pilih Kamar">Room Selection</span>
        </a>
        <div class="step-divider"></div>
        <a href="{{ url('/bed-shared-room/' . ($roomIdParam ?? 1)) }}?{{ $queryParams }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span data-en="Bed & Shared Room" data-id="Kasur & Kamar Bersama">Bed & Shared Room</span>
        </a>

        <div class="step-divider"></div>
        <a href="{{ $backToGuestDetailsUrl }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span data-en="Guest Details" data-id="Detail Tamu">Guest Details</span>
        </a>
        <div class="step-divider"></div>
        <div class="step active">
            <span class="step-number">5</span> <span data-en="Confirm & Payment" data-id="Konfirmasi & Pembayaran">Confirm & Payment</span>
        </div>
    </nav>

    <header class="confirm-header">
        <h1 data-en="Finalize Your Stay" data-id="Selesaikan Masa Tinggal Anda">Finalize Your Stay</h1>
        <p data-en="Almost there. Complete your payment below to confirm your reservation at AlaSare." data-id="Hampir selesai. Lakukan pembayaran Anda di bawah ini untuk mengonfirmasi reservasi di AlaSare.">Almost there. Complete your payment below to confirm your reservation at AlaSare.</p>
    </header>

    <div class="confirm-payment-grid">

        {{-- Left Column: Review Booking Details --}}
        <div class="confirm-column-left">

            <section class="confirm-card">
                <h2 data-en="Review Booking Details" data-id="Tinjauan Detail Pemesanan">Review Booking Details</h2>
                <div class="room-review-card">
                    <div class="room-review-image-wrapper">
                        <img src="{{ $room && $room->photo ? asset('storage/' . $room->photo) : asset('images/default-room.png') }}" alt="{{ $roomName }}">
                        @php
                            $genderLower = strtolower($room->gender_type);
                            $badgeEn = strtoupper($room->gender_type) . ' ONLY';
                            $badgeId = match($genderLower) {
                                'female' => 'KHUSUS WANITA',
                                'male'   => 'KHUSUS PRIA',
                                default  => strtoupper($room->gender_type),
                            };
                        @endphp
                        <span class="room-review-tag"
                            data-en="{{ $badgeEn }}"
                            data-id="{{ $badgeId }}">
                            {{ $badgeEn }}
                        </span>
                    </div>
                    <div class="room-review-details">
                        <h3>{{ $roomName }}</h3>
                        <div class="room-review-bed">{{ $bedName }}</div>
                        <p class="room-review-desc"
                            data-en="{{ $room ? $room->description : '' }}"
                            data-id="{{ $room ? ($room->description_id ?: $room->description) : '' }}">
                                {{ $room ? $room->description : '' }}
                         </p>

                        <div class="room-review-features">
                            <div class="review-feature">
                                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>{{ $room ? $room->capacity : '-' }} <span data-en="Person Capacity" data-id="Kapasitas Orang">Person Capacity</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="confirm-card">
                <h2 data-en="Your Stay" data-id="Masa Menginap Anda">Your Stay</h2>
                <div class="stay-duration-box">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span>{{ $displayCheckInDate }} - {{ $displayCheckOutDate }} ({{ $nightsParam }} <span data-en="day" data-id="hari">day</span>)</span>
                </div>
            </section>

            <section class="confirm-card" id="promoSection">
                <h2 data-en="Promotion" data-id="Promo">Promotion</h2>

                {{-- Promo input --}}
                <div id="promoInputArea">
                    <div style="display:flex;gap:8px;margin-bottom:8px;">
                        <input type="text" id="promoCodeInput"
                               value="{{ $promoParam }}"
                               placeholder="e.g. ALASAREZEN"
                               style="flex:1;padding:10px 12px;border:1px solid #ddd;border-radius:4px;font-size:13px;text-transform:uppercase;letter-spacing:0.05em;{{ $promoParam ? 'background:#f5f5f5;' : '' }}"
                               {{ $promoParam ? 'readonly' : '' }}>
                        <button type="button" id="promoBtn"
                                class="btn-apply"
                                style="padding:10px 20px;background:#D9864A;color:#fff;border:none;border-radius:4px;font-weight:600;font-size:13px;cursor:pointer;white-space:nowrap;">
                            {{ $promoParam ? 'Remove' : 'Apply' }}
                        </button>
                    </div>
                    <div id="promoSuccess" style="display:{{ $promoParam ? 'flex' : 'none' }};align-items:center;gap:6px;font-size:12px;color:#2a6e32;font-weight:600;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span id="promoSuccessText">
                            @if($promoParam)
                                Promo <strong>{{ $promoParam }}</strong> applied!
                            @endif
                        </span>
                    </div>
                    <div id="promoError" style="display:none;align-items:center;gap:6px;font-size:12px;color:#b03020;font-weight:600;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span id="promoErrorText"></span>
                    </div>
                </div>

                {{-- Promo badge (shown when promo is applied) --}}
                <div id="promoBadgeArea" style="display:{{ $promoParam ? 'block' : 'none' }};">
                    <div class="promo-badge-card">
                        <div class="promo-badge-left">
                            <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            <div class="promo-badge-info">
                                <h4 id="promoBadgeCode" style="text-transform:uppercase;">{{ $promoParam }}</h4>
                                <p id="promoBadgeDesc" data-en="Discount Applied" data-id="Diskon Diterapkan">
                                    @if($promoParam) 10% Discount Applied @else Discount Applied @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="confirm-card">
                <div class="confirm-card-header">
                    <h2 data-en="Guest Details" data-id="Detail Tamu">Guest Details</h2>
                    <a href="{{ $backToGuestDetailsUrl }}" class="confirm-link" data-en="Edit" data-id="Edit">Edit</a>
                </div>
                <div class="guest-info-display">
                    <strong style="text-transform: capitalize;">{{ $guestName }}</strong>
                    <span>{{ $guestEmail }}</span>
                    <span>{{ $guestPhone }}</span>
                </div>
            </section>

            <section class="confirm-card" style="margin-bottom: 0;">
                <div class="confirm-card-header">
                    <h2 data-en="Payment Method" data-id="Metode Pembayaran">Payment Method</h2>
                    <a href="{{ $backToGuestDetailsUrl }}" class="confirm-link" data-en="Change" data-id="Ubah">Change</a>
                </div>
                <div class="payment-method-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M12 11h4v4h-4zM6 7v10M18 7v10M6 12h12"/></svg>
                    <span style="text-transform: capitalize;">{{ str_replace('_', ' ', $paymentMethod) }}</span>
                </div>
            </section>

        </div>

        {{-- Right Column: Payment Summary --}}
        <div class="confirm-column-right">

            <h2 id="columnHeaderLabel" style="margin-bottom: 16px; color: #082600; font-family: var(--font-serif);" data-en="Payment Summary" data-id="Ringkasan Pembayaran">Payment Summary</h2>

            <div class="payment-summary-card" id="paymentSummaryCard">
                <h3 data-en="Payment Summary" data-id="Ringkasan Pembayaran">Payment Summary</h3>

                <div class="summary-details-list">
                    {{-- Kamar --}}
                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>{{ $roomName }} ({{ $nightsParam }} <span data-en="day" data-id="hari">day</span>)</span>
                            <span class="summary-item-sublabel">{{ $bedName }}</span>
                        </div>
                        <span class="summary-item-value">IDR {{ number_format($totalBedCost, 0, ',', '.') }}</span>
                    </div>

                    {{-- Addons --}}
                    @foreach($addonDetails as $addon)
                        <div class="summary-item-row">
                            <div class="summary-item-label">
                                <span>
                                    {{ $addon['name'] }}
                                    @if($addon['note'])
                                        <span style="color: #6CA16C; font-size: 11px;" data-en="{{ $addon['note'] }}" data-id="{{ $addon['note'] == '(For free)' ? '(Gratis)' : $addon['note'] }}">{{ $addon['note'] }}</span>
                                    @endif
                                </span>
                            </div>
                            <span class="summary-item-value">{{ $addon['cost'] > 0 ? 'IDR '.number_format($addon['cost'], 0, ',', '.') : 'IDR 0' }}</span>
                        </div>
                    @endforeach

                    {{-- Diskon Promo --}}
                    <div class="summary-item-row" id="promoDiscountRow" style="display:{{ $promoDiscount > 0 ? '' : 'none' }};">
                        <div class="summary-item-label">
                            <span data-en="Promo Discount" data-id="Diskon Promo">Promo Discount</span>
                        </div>
                        <span class="summary-item-value discount" id="promoDiscountDisplay">- IDR {{ number_format($promoDiscount, 0, ',', '.') }}</span>
                    </div>

                    {{-- Pajak & Servis --}}
                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span data-en="Tax & Service (10%)" data-id="Pajak & Layanan (10%)">Tax & Service (10%)</span>
                        </div>
                        <span class="summary-item-value" id="taxDisplay">IDR {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-total-row">
                    <span class="summary-total-label" data-en="Total Payment" data-id="Total Pembayaran">Total Payment</span>
                    <span class="summary-total-value" id="summaryTotalValue">IDR {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>

                <div class="agreement-container">
                    <input type="checkbox" id="agree-check" class="agreement-checkbox">
                    <label for="agree-check" class="agreement-text" data-en="I confirm that the personal information provided is accurate and valid." data-id="Saya mengonfirmasi bahwa informasi pribadi yang diberikan adalah akurat dan sah.">
                        I confirm that the personal information provided is accurate and valid.
                    </label>
                </div>

                <button class="btn-pay-now" id="btnPayNow" disabled style="opacity: 0.5; cursor: not-allowed;">
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    <span data-en="PAY NOW" data-id="BAYAR SEKARANG">PAY NOW</span>
                </button>

                <div class="agreement-subtext">
                    <span data-en="By clicking Pay Now, you agree to AlaSare's" data-id="Dengan mengklik Bayar Sekarang, Anda menyetujui">By clicking Pay Now, you agree to AlaSare's</span>
                    <a href="#" data-en="Terms of Service" data-id="Ketentuan Layanan">Terms of Service</a>
                    <span data-en="and" data-id="dan">and</span>
                    <a href="#" data-en="Cancellation Policy" data-id="Kebijakan Pembatalan">Cancellation Policy</a>.
                </div>
            </div>

            {{-- QRIS Scan Payment Card (Muncul setelah Pay Now di klik) --}}
            <div class="qris-payment-card" id="qrisPaymentCard" style="display: none; background-color: #ffffff; flex-direction: column; justify-content: center; align-items: center; padding: 24px; border-radius: 8px; box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05); border: 1px solid rgba(195, 201, 186, 0.30);">
                <div style="padding-bottom: 24px; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: flex; width: 100%;">
                    <div style="width: 100%; flex-direction: column; justify-content: flex-start; align-items: center; display: flex;">
                        <div style="text-align: center; justify-content: center; display: flex; flex-direction: column; color: #082600; font-size: 18.75px; font-family: var(--font-serif); font-weight: 600; line-height: 24px; word-wrap: break-word; margin-bottom: 16px;">
                            <span data-en="Complete your payment via" data-id="Selesaikan pembayaran Anda melalui">Complete your payment via</span>&nbsp;{{ strtoupper(str_replace('_', ' ', $paymentMethod)) }}
                        </div>
                    </div>
                </div>

                <div style="width: 100%; padding-bottom: 24px; flex-direction: column; justify-content: flex-start; align-items: center; display: flex;">
                    <div style="width: 100%; flex-direction: column; justify-content: flex-start; align-items: center; display: flex;">

                        {{-- QR CODE BLOCK: disembunyikan lewat JS jika payment_method = cash --}}
                        <div id="qrCodeBlock">
                            <div style="padding-bottom: 12px; flex-direction: column; justify-content: flex-start; align-items: center; display: flex; width: 100%;">
                                <div style="text-align: center; color: #C3C9BA; font-size: 14px; font-family: var(--font-body); font-weight: 500; line-height: 18px;" data-en="SCAN TO PAY" data-id="PINDAI UNTUK MEMBAYAR">SCAN TO PAY</div>
                            </div>
                            <div style="width: 100%; max-width: 192px; padding-bottom: 16px; flex-direction: column; justify-content: flex-start; align-items: center; display: flex; margin: 0 auto;">
                                <div style="width: 192px; height: 192px; padding: 12px; background: white; box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05); border-radius: 8px; border: 1px solid rgba(195, 201, 186, 0.30); flex-direction: column; justify-content: center; align-items: center; display: flex;">
                                    <img style="width: 100%; height: 100%;" src="{{ asset('images/qr.png') }}" alt="QRIS Payment Code" onerror="this.src='https://placehold.co/192?text=QRIS+CODE'" />
                                </div>
                            </div>
                        </div>

                        {{-- Untuk cash, teks ini otomatis di-override jadi "Awaiting Confirmation..." lewat JS --}}
                        <div style="padding: 8px 16px; background: rgba(217, 134, 74, 0.10); border-radius: 4px; justify-content: center; align-items: center; gap: 8px; display: inline-flex;">
                            <div><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>
                            <div style="text-align: center; color: #D9864A; font-size: 13px; font-family: var(--font-body); font-weight: 600;">
                                <span id="awaitingLabel" data-en="Awaiting Payment..." data-id="Menunggu Pembayaran...">Awaiting Payment...</span> <span id="paymentTimer">14:59</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="width: 100%; padding-bottom: 24px; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: flex;">
                    <button class="btn-payment-completed" id="btnPaymentCompleted" style="width: 100%; padding: 16px 24px; background: #D9864A; border: none; border-radius: 8px; color: white; font-size: 14px; font-weight: 600; text-transform: uppercase; cursor: pointer; transition: background 0.2s;" data-en="I HAVE COMPLETED PAYMENT" data-id="SAYA TELAH MENYELESAIKAN PEMBAYARAN">
                        I HAVE COMPLETED PAYMENT
                    </button>
                </div>

                <div style="justify-content: center; align-items: center; gap: 8px; display: flex; width: 100%;">
                    <div><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="rgba(67, 73, 62, 0.80)" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></div>
                    <div style="text-align: center; color: rgba(67, 73, 62, 0.80); font-size: 12px; font-weight: 400;" data-en="SECURED BY ALASARE PAYMENT GATEWAY" data-id="DIAMANKAN OLEH GERBANG PEMBAYARAN ALASARE">SECURED BY ALASARE PAYMENT GATEWAY</div>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- Footer Navigation Back (Statis) --}}
<div class="confirm-footer-wrapper" style="position: fixed; bottom: 0; left: 0; width: 100%; background: #FFFFFF; border-top: 1px solid #E5E5E5; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); z-index: 990; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; display: flex; justify-content: center;">
        <a href="{{ $backToGuestDetailsUrl }}" class="btn-back-details" style="background-color: #6CA16C; color: white; padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 15px;" data-en="Back To Guest Details" data-id="Kembali ke Detail Tamu">
            Back To Guest Details
        </a>
    </div>
</div>

{{-- Payment Success Popup Modal --}}
<div class="payment-success-overlay" id="paymentSuccessOverlay">
    <div class="payment-success-modal">
        <div class="success-modal-header">
            <div class="checkmark-circle">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h2 data-en="PAYMENT SUCCESS" data-id="PEMBAYARAN SUKSES">payment success</h2>
            <div class="booking-id-badge" id="modalBookingId" data-en="BOOKING ID: #LOADING..." data-id="ID PEMESANAN: #MEMUAT...">BOOKING ID: #LOADING...</div>
        </div>

        <div class="success-modal-body">
            <ul class="success-details-list">
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                        <span data-en="Room" data-id="Kamar">Room</span>
                    </div>
                    <div class="detail-value">{{ $roomName }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 20v-8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8"></path></svg>
                        <span data-en="Bed" data-id="Kasur">Bed</span>
                    </div>
                    <div class="detail-value">{{ $bedName }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline></svg>
                        <span data-en="Check-in" data-id="Check-in">Check-in</span>
                    </div>
                    <div class="detail-value">{{ $displayCheckInModal }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 7 5 12 10 17"></polyline></svg>
                        <span data-en="Check-out" data-id="Check-out">Check-out</span>
                    </div>
                    <div class="detail-value">{{ $displayCheckOutModal }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect><circle cx="12" cy="12" r="3"></circle></svg>
                        <span data-en="Payment Method" data-id="Metode bayar">Metode bayar</span>
                    </div>
                    <div class="detail-value" style="text-transform: capitalize;">{{ str_replace('_', ' ', $paymentMethod) }}</div>
                </li>
            </ul>

            <div class="total-price-box">
                <span class="price-label" data-en="TOTAL PRICE" data-id="TOTAL HARGA">TOTAL PRICE</span>
                <span class="price-value">IDR {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>

            <div class="modal-actions">
                <a href="/calendar" class="btn-modal-outline" data-en="Booking Details" data-id="Detail Pemesanan">
                    Booking Details
                </a>
                <button class="btn-modal-outline" id="downloadReceipt" data-en="Download proof of payment" data-id="Unduh Bukti Pembayaran">
                    Download proof of payment
                </button>
            </div>

            <div class="confirmation-sent-text">
                <span data-en="Confirmation has been sent to" data-id="Konfirmasi telah dikirim ke">confirmation has been sent to</span> {{ $guestEmail }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lang = window.AlasLang ? window.AlasLang.current() : 'id';
        document.querySelectorAll('[data-en][data-id]').forEach(el => {
            if (el.tagName === 'OPTION') return;
            const text = el.getAttribute('data-' + lang);
            if (text !== null) el.textContent = text;
    });

        const agreeCheck = document.getElementById('agree-check');
        const btnPayNow = document.getElementById('btnPayNow');
        const paymentSummaryCard = document.getElementById('paymentSummaryCard');
        const qrisPaymentCard = document.getElementById('qrisPaymentCard');
        const qrCodeBlock = document.getElementById('qrCodeBlock');
        const awaitingLabel = document.getElementById('awaitingLabel');
        const btnPaymentCompleted = document.getElementById('btnPaymentCompleted');
        const overlay = document.getElementById('paymentSuccessOverlay');
        const columnHeaderLabel = document.getElementById('columnHeaderLabel');
        const modalBookingId = document.getElementById('modalBookingId');

        // Payment method (lowercased) dipakai untuk cek apakah ini cash
        const paymentMethodValue = @json(strtolower($paymentMethod));
        const isCashPayment = paymentMethodValue === 'cash';

        // Promo elements
        const promoInput = document.getElementById('promoCodeInput');
        const promoBtn = document.getElementById('promoBtn');
        const promoSuccess = document.getElementById('promoSuccess');
        const promoSuccessText = document.getElementById('promoSuccessText');
        const promoError = document.getElementById('promoError');
        const promoErrorText = document.getElementById('promoErrorText');
        const promoInputArea = document.getElementById('promoInputArea');
        const promoBadgeArea = document.getElementById('promoBadgeArea');
        const promoBadgeCode = document.getElementById('promoBadgeCode');
        const promoBadgeDesc = document.getElementById('promoBadgeDesc');
        const promoDiscountRow = document.getElementById('promoDiscountRow');
        const promoDiscountDisplay = document.getElementById('promoDiscountDisplay');
        const summaryTotalValue = document.getElementById('summaryTotalValue');
        const taxDisplay = document.getElementById('taxDisplay');

        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Data untuk invoice PDF (dipakai oleh tombol "Download proof of payment")
        const invoiceData = {
            roomName: @json($roomName),
            bedName: @json($bedName),
            guestName: @json(trim($guestName)),
            guestEmail: @json($guestEmail),
            checkIn: @json($displayCheckInModal),
            checkOut: @json($displayCheckOutModal),
            nights: {{ $nightsParam }},
            paymentMethod: @json(str_replace('_', ' ', $paymentMethod)),
            bedCost: {{ $totalBedCost }},
            addons: @json($addonDetails),
            promoCode: @json($promoParam),
        };

        let paymentTimerInterval;
        let createdBookingId = null;
        let currentPromoCode = '{{ $promoParam }}';
        let currentPromoDiscount = {{ $promoDiscount }};

        const isId = () => (window.AlasLang && window.AlasLang.current() === 'id');

        // ── Promo Code ────────────────────────────────────────────
        function formatIDR(amount) {
            return 'IDR ' + parseInt(amount).toLocaleString('id-ID');
        }

        async function applyPromoCode() {
            const code = promoInput.value.trim().toUpperCase();
            if (!code) {
                showPromoError('Please enter a promo code.');
                return;
            }

            promoBtn.disabled = true;
            promoBtn.textContent = 'Checking...';

            const subtotal = {{ $totalBedCost }} + {{ $addonTotal }};

            try {
                const res = await fetch('{{ route("booking.promo.apply") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: JSON.stringify({ code, subtotal }),
                });
                const data = await res.json();

                if (!res.ok || !data.success) {
                    showPromoError(data.message || 'Invalid promo code.');
                    promoBtn.disabled = false;
                    promoBtn.textContent = 'Apply';
                    return;
                }

                // Success
                currentPromoCode = data.code;
                currentPromoDiscount = data.discount;
                promoInput.readOnly = true;
                promoBtn.textContent = 'Remove';
                promoBtn.onclick = removePromoCode;
                promoBtn.disabled = false;

                promoInputArea.style.display = 'none';
                promoBadgeArea.style.display = 'block';
                promoBadgeCode.textContent = data.code;
                promoBadgeDesc.textContent = data.discount_label + ' Discount Applied';

                showPromoSuccess('Promo <strong>' + data.code + '</strong> applied! You save ' + formatIDR(data.discount) + '.');

                updateSummary();

            } catch (e) {
                showPromoError('Something went wrong. Please try again.');
                promoBtn.disabled = false;
                promoBtn.textContent = 'Apply';
            }
        }

        async function removePromoCode() {
            promoBtn.disabled = true;
            promoBtn.textContent = 'Removing...';

            try {
                const res = await fetch('{{ route("booking.promo.remove") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                });
                const data = await res.json();

                currentPromoCode = '';
                currentPromoDiscount = 0;
                promoInput.value = '';
                promoInput.readOnly = false;
                promoBtn.textContent = 'Apply';
                promoBtn.onclick = applyPromoCode;
                promoBtn.disabled = false;

                promoInputArea.style.display = 'block';
                promoBadgeArea.style.display = 'none';
                hidePromoMessages();
                updateSummary();

            } catch (e) {
                promoBtn.disabled = false;
                promoBtn.textContent = 'Remove';
            }
        }

        function updateSummary() {
            const subtotal = {{ $totalBedCost }} + {{ $addonTotal }};
            const discount = currentPromoDiscount;
            const tax = (subtotal - discount) * 0.10;
            const grandTotal = (subtotal - discount) + tax;

            if (discount > 0) {
                promoDiscountRow.style.display = '';
                promoDiscountDisplay.textContent = '- ' + formatIDR(discount);
            } else {
                promoDiscountRow.style.display = 'none';
            }

            taxDisplay.textContent = formatIDR(tax);
            summaryTotalValue.textContent = formatIDR(grandTotal);
        }

        function showPromoSuccess(html) {
            promoError.style.display = 'none';
            promoSuccess.style.display = 'flex';
            promoSuccessText.innerHTML = html;
        }

        function showPromoError(msg) {
            promoSuccess.style.display = 'none';
            promoError.style.display = 'flex';
            promoErrorText.textContent = msg;
        }

        function hidePromoMessages() {
            promoSuccess.style.display = 'none';
            promoError.style.display = 'none';
        }

        // Attach promo button
        if (promoBtn) {
            promoBtn.addEventListener('click', function () {
                if (currentPromoCode) {
                    removePromoCode();
                } else {
                    applyPromoCode();
                }
            });
        }

        // Auto uppercase
        if (promoInput) {
            promoInput.addEventListener('input', function () {
                if (!this.readOnly) {
                    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                }
            });
        }

        agreeCheck.addEventListener('change', function() {
            if(this.checked) {
                btnPayNow.removeAttribute('disabled');
                btnPayNow.style.opacity = '1';
                btnPayNow.style.cursor = 'pointer';
            } else {
                btnPayNow.setAttribute('disabled', 'true');
                btnPayNow.style.opacity = '0.5';
                btnPayNow.style.cursor = 'not-allowed';
            }
        });

        btnPayNow.addEventListener('click', async function (e) {
            e.preventDefault();

            const originalText = btnPayNow.innerHTML;
            btnPayNow.innerHTML = isId() ? 'PROSES...' : 'PROCESSING...';
            btnPayNow.setAttribute('disabled', 'true');

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.append('grand_total', summaryTotalValue.textContent.replace(/[^0-9]/g, ''));

            const payload = {};
            for(let [key, value] of urlParams.entries()) {
                payload[key] = value;
            }

            // Include promo data
            if (currentPromoCode) {
                payload['promo_code'] = currentPromoCode;
                payload['promo_discount'] = currentPromoDiscount;
            }

            try {
                const response = await fetch('/api/create-booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                const rawText = await response.text();
                let data;

                try {
                    data = JSON.parse(rawText);
                } catch (parseError) {
                    console.error("SERVER ERROR HTML RESPONSE:", rawText);
                    alert(isId() ? "Terjadi error di sistem (Database/PHP). Silakan tekan F12, buka tab 'Console' untuk melihat detail error aslinya!" : "A system error occurred (Database/PHP). Please press F12 and open the 'Console' tab to view details!");
                    btnPayNow.innerHTML = originalText;
                    btnPayNow.removeAttribute('disabled');
                    return;
                }

                if(data.success) {
                    createdBookingId = data.booking_id;

                    if (data.snap_token) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function (result) {
                                fetch('/api/confirm-booking/' + data.booking_id, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({ midtrans_result: result })
                                }).then(function (res) { return res.json(); }).then(function (confirmData) {
                                    if (confirmData.success) {
                                        showPaymentSuccess(data.booking_id);
                                    }
                                });
                            },
                            onPending: function (result) {
                                console.log('Midtrans pending:', result);
                            },
                            onError: function (result) {
                                alert(isId() ? 'Pembayaran gagal. Silakan coba lagi.' : 'Payment failed. Please try again.');
                                btnPayNow.innerHTML = originalText;
                                btnPayNow.removeAttribute('disabled');
                            },
                            onClose: function () {
                                btnPayNow.innerHTML = originalText;
                                btnPayNow.removeAttribute('disabled');
                            }
                        });
                        paymentSummaryCard.style.display = 'none';
                        columnHeaderLabel.textContent = isId() ? 'Menunggu Pembayaran' : 'Awaiting Payment';
                        document.querySelector('.confirm-footer-wrapper').style.display = 'none';
                    } else {
                        paymentSummaryCard.style.display = 'none';
                        qrisPaymentCard.style.display = 'flex';

                        if (isCashPayment) {
                            // Cash: sembunyikan blok QR code, tidak perlu generate/scan barcode
                            if (qrCodeBlock) qrCodeBlock.style.display = 'none';
                            if (awaitingLabel) {
                                awaitingLabel.textContent = isId() ? 'Menunggu Konfirmasi...' : 'Awaiting Confirmation...';
                            }
                            columnHeaderLabel.textContent = isId() ? 'Menunggu Konfirmasi' : 'Awaiting Confirmation';
                        } else {
                            if (qrCodeBlock) qrCodeBlock.style.display = '';
                            columnHeaderLabel.textContent = isId() ? 'Menunggu Pembayaran' : 'Awaiting Payment';
                        }

                        startPaymentTimer();
                        document.querySelector('.confirm-footer-wrapper').style.display = 'none';
                    }
                } else {
                    alert(isId() ? 'Gagal membuat booking. Silakan coba lagi.' : 'Failed to create booking. Please try again.');
                    btnPayNow.innerHTML = originalText;
                    btnPayNow.removeAttribute('disabled');
                }

            } catch (err) {
                console.error("NETWORK ERROR:", err);
                alert(isId() ? 'Terjadi kesalahan jaringan atau server tidak merespon.' : 'Network error or server is not responding.');
                btnPayNow.innerHTML = originalText;
                btnPayNow.removeAttribute('disabled');
            }
        });

        function showPaymentSuccess(bookingId) {
            qrisPaymentCard.style.display = 'none';
            columnHeaderLabel.textContent = isId() ? 'Pembayaran Selesai' : 'Payment Completed';

            const bookingPrefix = isId() ? 'ID PEMESANAN' : 'BOOKING ID';
            modalBookingId.textContent = bookingPrefix + ": #BK-" + new Date().getFullYear() + "-" + bookingId.toString().padStart(4, '0');

            overlay.classList.add('is-active');
            document.body.style.overflow = 'hidden';
            clearInterval(paymentTimerInterval);
        }

        // 3. I HAVE COMPLETED PAYMENT -> Konfirmasi Status Booking via AJAX
        btnPaymentCompleted.addEventListener('click', async function (e) {
            e.preventDefault();

            if(!createdBookingId) {
                alert(isId() ? 'Booking ID tidak ditemukan!' : 'Booking ID not found!');
                return;
            }

            const originalBtnText = btnPaymentCompleted.textContent;
            btnPaymentCompleted.textContent = isId() ? 'MEMVERIFIKASI...' : 'VERIFYING...';

            try {
                const res = await fetch(`/api/confirm-booking/${createdBookingId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await res.json();

                if(data.success) {
                    showPaymentSuccess(createdBookingId);
                } else {
                    alert(isId() ? 'Gagal konfirmasi pembayaran.' : 'Failed to confirm payment.');
                }
            } catch(err) {
                console.error(err);
                alert(isId() ? 'Gagal menghubungi server.' : 'Failed to connect to the server.');
            } finally {
                btnPaymentCompleted.textContent = originalBtnText;
            }
        });

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('is-active');
                document.body.style.overflow = '';
                window.location.href = "/calendar";
            }
        });

        // ── Download Proof of Payment (Invoice PDF) ─────────────────
        document.getElementById('downloadReceipt').addEventListener('click', function() {
            if (!createdBookingId) {
                alert(isId() ? 'ID booking belum tersedia.' : 'Booking ID not available yet.');
                return;
            }
            generateInvoicePDF();
        });

        function generateInvoicePDF() {
            if (!window.jspdf) {
                alert(isId() ? 'Gagal memuat modul PDF, coba lagi.' : 'Failed to load PDF module, please try again.');
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ unit: 'pt', format: 'a4' });
            const pageWidth = doc.internal.pageSize.getWidth();

            const subtotal = invoiceData.bedCost + invoiceData.addons.reduce((s, a) => s + a.cost, 0);
            const discount = currentPromoDiscount || 0;
            const tax = (subtotal - discount) * 0.10;
            const grandTotal = (subtotal - discount) + tax;

            const bookingCode = `BK-${new Date().getFullYear()}-${createdBookingId.toString().padStart(4, '0')}`;
            const fmt = (n) => parseInt(n).toLocaleString('id-ID');

            let y = 50;

            // Header
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(20);
            doc.setTextColor(8, 38, 0);
            doc.text('AlaSare', 40, y);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text('Proof of Payment / Invoice', 40, y + 16);

            doc.setFontSize(10);
            doc.text(`No: ${bookingCode}`, pageWidth - 40, y, { align: 'right' });
            doc.text(`Date: ${new Date().toLocaleDateString('en-GB')}`, pageWidth - 40, y + 16, { align: 'right' });

            y += 40;
            doc.setDrawColor(220, 220, 220);
            doc.line(40, y, pageWidth - 40, y);
            y += 25;

            // Guest info (kiri)
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(11);
            doc.setTextColor(8, 38, 0);
            doc.text('Guest Information', 40, y);
            y += 16;
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(60, 60, 60);
            doc.text(`Name: ${invoiceData.guestName}`, 40, y); y += 14;
            doc.text(`Email: ${invoiceData.guestEmail}`, 40, y); y += 14;
            doc.text(`Payment Method: ${invoiceData.paymentMethod}`, 40, y);

            // Stay info (kanan)
            let y2 = y - 28;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(11);
            doc.setTextColor(8, 38, 0);
            doc.text('Stay Details', pageWidth / 2 + 10, y2);
            y2 += 16;
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(60, 60, 60);
            doc.text(`Room: ${invoiceData.roomName}`, pageWidth / 2 + 10, y2); y2 += 14;
            doc.text(`Bed: ${invoiceData.bedName}`, pageWidth / 2 + 10, y2); y2 += 14;
            doc.text(`Check-in: ${invoiceData.checkIn}`, pageWidth / 2 + 10, y2); y2 += 14;
            doc.text(`Check-out: ${invoiceData.checkOut}`, pageWidth / 2 + 10, y2);

            y = Math.max(y, y2) + 30;
            doc.setDrawColor(220, 220, 220);
            doc.line(40, y, pageWidth - 40, y);
            y += 20;

            // Table header
            doc.setFillColor(8, 38, 0);
            doc.rect(40, y - 12, pageWidth - 80, 20, 'F');
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(10);
            doc.setTextColor(255, 255, 255);
            doc.text('Description', 48, y + 2);
            doc.text('Amount (IDR)', pageWidth - 48, y + 2, { align: 'right' });
            y += 22;

            doc.setFont('helvetica', 'normal');
            doc.setTextColor(40, 40, 40);
            doc.text(`${invoiceData.roomName} (${invoiceData.nights} night${invoiceData.nights > 1 ? 's' : ''}) - ${invoiceData.bedName}`, 48, y);
            doc.text(fmt(invoiceData.bedCost), pageWidth - 48, y, { align: 'right' });
            y += 18;

            invoiceData.addons.forEach((a) => {
                doc.text(`${a.name}${a.note ? ' ' + a.note : ''}`, 48, y);
                doc.text(fmt(a.cost), pageWidth - 48, y, { align: 'right' });
                y += 18;
            });

            doc.setDrawColor(230, 230, 230);
            doc.line(40, y, pageWidth - 40, y);
            y += 16;

            doc.text('Subtotal', 48, y);
            doc.text(fmt(subtotal), pageWidth - 48, y, { align: 'right' });
            y += 16;

            if (discount > 0) {
                doc.setTextColor(176, 48, 32);
                doc.text(`Promo Discount (${invoiceData.promoCode || currentPromoCode})`, 48, y);
                doc.text('- ' + fmt(discount), pageWidth - 48, y, { align: 'right' });
                doc.setTextColor(40, 40, 40);
                y += 16;
            }

            doc.text('Tax & Service (10%)', 48, y);
            doc.text(fmt(tax), pageWidth - 48, y, { align: 'right' });
            y += 20;

            doc.setDrawColor(8, 38, 0);
            doc.setLineWidth(1);
            doc.line(40, y, pageWidth - 40, y);
            y += 20;

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(13);
            doc.setTextColor(8, 38, 0);
            doc.text('TOTAL PAYMENT', 48, y);
            doc.text('IDR ' + fmt(grandTotal), pageWidth - 48, y, { align: 'right' });

            y += 50;
            doc.setFont('helvetica', 'italic');
            doc.setFontSize(9);
            doc.setTextColor(120, 120, 120);
            doc.text(
                'This is a computer-generated invoice and serves as valid proof of payment for your booking at AlaSare.',
                40, y, { maxWidth: pageWidth - 80 }
            );

            doc.save(`Invoice-${bookingCode}.pdf`);
        }

        function startPaymentTimer() {
            let timeLeft = 15 * 60;
            const timerEl = document.getElementById('paymentTimer');
            clearInterval(paymentTimerInterval);

            paymentTimerInterval = setInterval(function() {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

                if (timeLeft <= 0) {
                    clearInterval(paymentTimerInterval);
                    timerEl.textContent = '00:00';
                    alert(isId() ? "Waktu pembayaran telah habis. Silakan ulangi booking." : "Payment time has expired. Please restart your booking.");
                    window.location.reload();
                }
            }, 1000);
        }


    });
</script>

</body>
</html>