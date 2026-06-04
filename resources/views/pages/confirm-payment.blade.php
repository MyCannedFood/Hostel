<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirm & Payment - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<main class="confirm-payment-page">
    
    {{-- Booking Stepper Aktif (Bisa Diklik) --}}
    <nav class="booking-stepper">
        <a href="{{ url('/calendar') }}?{{ $queryParams }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span>Calendar</span>
        </a>
        <div class="step-divider"></div>
        <a href="{{ url('/room-selection') }}?{{ $queryParams }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span>Room Selection</span>
        </a>
        <div class="step-divider"></div>
        <a href="{{ url('/bed-shared-room/' . ($roomIdParam ?? 1)) }}?{{ $queryParams }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span>Bed & Shared Room</span>
        </a>
        <div class="step-divider"></div>
        <a href="{{ $backToGuestDetailsUrl }}" class="step completed" style="text-decoration:none; color:inherit;">
            <span class="step-icon">✓</span> <span>Guest Details</span>
        </a>
        <div class="step-divider"></div>
        <div class="step active">
            <span class="step-number">5</span> <span>Confirm & Payment</span>
        </div>
    </nav>

    <header class="confirm-header">
        <h1>Finalize Your Stay</h1>
        <p>Almost there. Complete your payment below to confirm your reservation at AlaSare.</p>
    </header>

    <div class="confirm-payment-grid">
        
        {{-- Left Column: Review Booking Details --}}
        <div class="confirm-column-left">
            
            <section class="confirm-card">
                <h2>Review Booking Details</h2>
                <div class="room-review-card">
                    <div class="room-review-image-wrapper">
                        <img src="{{ $room && $room->photo ? asset('storage/' . $room->photo) : asset('images/default-room.png') }}" alt="{{ $roomName }}">
                        @if($room && strtolower($room->gender_type) != 'mixed')
                            <span class="room-review-tag">{{ strtoupper($room->gender_type) }} ONLY</span>
                        @endif
                    </div>
                    <div class="room-review-details">
                        <h3>{{ $roomName }}</h3>
                        <div class="room-review-bed">{{ $bedName }}</div>
                        <p class="room-review-desc">{{ $room ? $room->description : '' }}</p>
                        
                        <div class="room-review-features">
                            <div class="review-feature">
                                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>{{ $room ? $room->capacity : '-' }} Person Capacity</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="confirm-card">
                <h2>Your Stay</h2>
                <div class="stay-duration-box">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span>{{ $displayCheckInDate }} - {{ $displayCheckOutDate }} ({{ $nightsParam }} day)</span>
                </div>
            </section>

            <section class="confirm-card">
                <div class="confirm-card-header">
                    <h2>Guest Details</h2>
                    <a href="{{ $backToGuestDetailsUrl }}" class="confirm-link">Edit</a>
                </div>
                <div class="guest-info-display">
                    <strong style="text-transform: capitalize;">{{ $guestName }}</strong>
                    <span>{{ $guestEmail }}</span>
                    <span>{{ $guestPhone }}</span>
                </div>
            </section>

            @if($promoParam)
                <section class="confirm-card">
                    <h2>Promotion</h2>
                    <div class="promo-badge-card">
                        <div class="promo-badge-left">
                            <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            <div class="promo-badge-info">
                                <h4 style="text-transform: uppercase;">{{ $promoParam }}</h4>
                                <p>10% Discount Applied</p>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <section class="confirm-card" style="margin-bottom: 0;">
                <div class="confirm-card-header">
                    <h2>Payment Method</h2>
                    <a href="{{ $backToGuestDetailsUrl }}" class="confirm-link">Change</a>
                </div>
                <div class="payment-method-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M12 11h4v4h-4zM6 7v10M18 7v10M6 12h12"/></svg>
                    <span style="text-transform: capitalize;">{{ str_replace('_', ' ', $paymentMethod) }}</span>
                </div>
            </section>

        </div>

        {{-- Right Column: Payment Summary --}}
        <div class="confirm-column-right">
            
            <h2 id="columnHeaderLabel" style="margin-bottom: 16px; color: #082600; font-family: var(--font-serif);">Payment Summary</h2>
            
            <div class="payment-summary-card" id="paymentSummaryCard">
                <h3>Payment Summary</h3>
                
                <div class="summary-details-list">
                    {{-- Kamar --}}
                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>{{ $roomName }} ({{ $nightsParam }} day)</span>
                            <span class="summary-item-sublabel">{{ $bedName }}</span>
                        </div>
                        <span class="summary-item-value">IDR {{ number_format($totalBedCost, 0, ',', '.') }}</span>
                    </div>

                    {{-- Addons --}}
                    @foreach($addonDetails as $addon)
                        <div class="summary-item-row">
                            <div class="summary-item-label">
                                <span>{{ $addon['name'] }} <span style="color: #6CA16C; font-size: 11px;">{{ $addon['note'] }}</span></span>
                            </div>
                            <span class="summary-item-value">{{ $addon['cost'] > 0 ? 'IDR '.number_format($addon['cost'], 0, ',', '.') : 'IDR 0' }}</span>
                        </div>
                    @endforeach

                    {{-- Diskon Promo --}}
                    @if($promoDiscount > 0)
                        <div class="summary-item-row">
                            <div class="summary-item-label">
                                <span>Promo Discount (10%)</span>
                            </div>
                            <span class="summary-item-value discount">- IDR {{ number_format($promoDiscount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    {{-- Pajak & Service --}}
                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>Tax & Service (10%)</span>
                        </div>
                        <span class="summary-item-value">IDR {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-total-row">
                    <span class="summary-total-label">Total Payment</span>
                    <span class="summary-total-value">IDR {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>

                <div class="agreement-container">
                    <input type="checkbox" id="agree-check" class="agreement-checkbox">
                    <label for="agree-check" class="agreement-text">
                        I confirm that the personal information provided is accurate and valid.
                    </label>
                </div>
                
                <button class="btn-pay-now" id="btnPayNow" disabled style="opacity: 0.5; cursor: not-allowed;">
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    PAY NOW
                </button>

                <div class="agreement-subtext">
                    By clicking Pay Now, you agree to AlaSare's <a href="#">Terms of Service</a> and <a href="#">Cancellation Policy</a>.
                </div>
            </div>

            {{-- QRIS Scan Payment Card (Muncul setelah Pay Now di klik) --}}
            <div class="qris-payment-card" id="qrisPaymentCard" style="display: none; background-color: #ffffff; flex-direction: column; justify-content: center; align-items: center; padding: 24px; border-radius: 8px; box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05); border: 1px solid rgba(195, 201, 186, 0.30);">
                <div style="padding-bottom: 24px; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: flex; width: 100%;">
                    <div style="width: 100%; flex-direction: column; justify-content: flex-start; align-items: center; display: flex;">
                        <div style="text-align: center; justify-content: center; display: flex; flex-direction: column; color: #082600; font-size: 18.75px; font-family: var(--font-serif); font-weight: 600; line-height: 24px; word-wrap: break-word; margin-bottom: 16px;">
                            Complete your payment via {{ strtoupper(str_replace('_', ' ', $paymentMethod)) }}
                        </div>
                    </div>
                </div>

                <div style="width: 100%; padding-bottom: 24px; flex-direction: column; justify-content: flex-start; align-items: center; display: flex;">
                    <div style="width: 100%; flex-direction: column; justify-content: flex-start; align-items: center; display: flex;">
                        <div style="padding-bottom: 12px; flex-direction: column; justify-content: flex-start; align-items: center; display: flex; width: 100%;">
                            <div style="text-align: center; color: #C3C9BA; font-size: 14px; font-family: var(--font-body); font-weight: 500; line-height: 18px;">SCAN TO PAY</div>
                        </div>
                        <div style="width: 100%; max-width: 192px; padding-bottom: 16px; flex-direction: column; justify-content: flex-start; align-items: center; display: flex; margin: 0 auto;">
                            <div style="width: 192px; height: 192px; padding: 12px; background: white; box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05); border-radius: 8px; border: 1px solid rgba(195, 201, 186, 0.30); flex-direction: column; justify-content: center; align-items: center; display: flex;">
                                <img style="width: 100%; height: 100%;" src="{{ asset('images/qr.png') }}" alt="QRIS Payment Code" onerror="this.src='https://placehold.co/192?text=QRIS+CODE'" />
                            </div>
                        </div>
                        <div style="padding: 8px 16px; background: rgba(217, 134, 74, 0.10); border-radius: 4px; justify-content: center; align-items: center; gap: 8px; display: inline-flex;">
                            <div><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>
                            <div style="text-align: center; color: #D9864A; font-size: 13px; font-family: var(--font-body); font-weight: 600;">Awaiting Payment... <span id="paymentTimer">14:59</span></div>
                        </div>
                    </div>
                </div>

                <div style="width: 100%; padding-bottom: 24px; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: flex;">
                    <button class="btn-payment-completed" id="btnPaymentCompleted" style="width: 100%; padding: 16px 24px; background: #D9864A; border: none; border-radius: 8px; color: white; font-size: 14px; font-weight: 600; text-transform: uppercase; cursor: pointer; transition: background 0.2s;">
                        I HAVE COMPLETED PAYMENT
                    </button>
                </div>

                <div style="justify-content: center; align-items: center; gap: 8px; display: flex; width: 100%;">
                    <div><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="rgba(67, 73, 62, 0.80)" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></div>
                    <div style="text-align: center; color: rgba(67, 73, 62, 0.80); font-size: 12px; font-weight: 400;">SECURED BY ALASARE PAYMENT GATEWAY</div>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- Footer Navigation Back (Statis) --}}
<div class="confirm-footer-wrapper" style="position: fixed; bottom: 0; left: 0; width: 100%; background: #FFFFFF; border-top: 1px solid #E5E5E5; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); z-index: 990; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; display: flex; justify-content: center;">
        <a href="{{ $backToGuestDetailsUrl }}" class="btn-back-details" style="background-color: #6CA16C; color: white; padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 15px;">
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
            <h2>payment success</h2>
            <div class="booking-id-badge" id="modalBookingId">BOOKING ID: #LOADING...</div>
        </div>

        <div class="success-modal-body">
            <ul class="success-details-list">
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                        <span>Room</span>
                    </div>
                    <div class="detail-value">{{ $roomName }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 20v-8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8"></path></svg>
                        <span>Bed</span>
                    </div>
                    <div class="detail-value">{{ $bedName }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline></svg>
                        <span>Check-in</span>
                    </div>
                    <div class="detail-value">{{ $displayCheckInModal }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 7 5 12 10 17"></polyline></svg>
                        <span>Check-out</span>
                    </div>
                    <div class="detail-value">{{ $displayCheckOutModal }}</div>
                </li>
                <li>
                    <div class="detail-label">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Metode bayar</span>
                    </div>
                    <div class="detail-value" style="text-transform: capitalize;">{{ str_replace('_', ' ', $paymentMethod) }}</div>
                </li>
            </ul>

            <div class="total-price-box">
                <span class="price-label">TOTAL PRICE</span>
                <span class="price-value">IDR {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>

            <div class="modal-actions">
                <a href="/calendar" class="btn-modal-outline">
                    Booking Details
                </a>
                <button class="btn-modal-outline" id="downloadReceipt">
                    Download proof of payment
                </button>
            </div>

            <div class="confirmation-sent-text">
                confirmation has been sent to {{ $guestEmail }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const agreeCheck = document.getElementById('agree-check');
        const btnPayNow = document.getElementById('btnPayNow');
        
        const paymentSummaryCard = document.getElementById('paymentSummaryCard');
        const qrisPaymentCard = document.getElementById('qrisPaymentCard');
        const btnPaymentCompleted = document.getElementById('btnPaymentCompleted');
        const overlay = document.getElementById('paymentSuccessOverlay');
        const columnHeaderLabel = document.getElementById('columnHeaderLabel');
        const modalBookingId = document.getElementById('modalBookingId');
        
        let paymentTimerInterval;
        let createdBookingId = null;

        // 1. Validasi Checkbox
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

        // 2. Klik PAY NOW -> Simpan data PENDING ke Backend via AJAX
        btnPayNow.addEventListener('click', async function (e) {
            e.preventDefault();
            
            const originalText = btnPayNow.innerHTML;
            btnPayNow.innerHTML = 'PROCESSING...';
            btnPayNow.setAttribute('disabled', 'true');

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.append('grand_total', "{{ $grandTotal }}");
            
            const payload = {};
            for(let [key, value] of urlParams.entries()) {
                payload[key] = value;
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

                // TANGKAP TEKS MENTAH DARI LARAVEL (Biar ketahuan kalau ada error HTML)
                const rawText = await response.text(); 
                let data;

                try {
                    data = JSON.parse(rawText); // Coba ubah ke JSON
                } catch (parseError) {
                    console.error("SERVER ERROR HTML RESPONSE:", rawText);
                    alert("Terjadi error di sistem (Database/PHP). Silakan tekan F12, buka tab 'Console' untuk melihat detail error aslinya!");
                    btnPayNow.innerHTML = originalText;
                    btnPayNow.removeAttribute('disabled');
                    return; // Hentikan proses
                }
                
                if(data.success) {
                    createdBookingId = data.booking_id;
                    
                    paymentSummaryCard.style.display = 'none';
                    qrisPaymentCard.style.display = 'flex';
                    columnHeaderLabel.textContent = 'Awaiting Payment';
                    startPaymentTimer();
                    
                    document.querySelector('.confirm-footer-wrapper').style.display = 'none';
                } else {
                    alert('Gagal membuat booking. Silakan coba lagi.');
                    btnPayNow.innerHTML = originalText;
                    btnPayNow.removeAttribute('disabled');
                }

            } catch (err) {
                console.error("NETWORK ERROR:", err);
                alert('Terjadi kesalahan jaringan atau server tidak merespon.');
                btnPayNow.innerHTML = originalText;
                btnPayNow.removeAttribute('disabled');
            }
        });

        // 3. I HAVE COMPLETED PAYMENT -> Konfirmasi Status Booking via AJAX
        btnPaymentCompleted.addEventListener('click', async function (e) {
            e.preventDefault();
            
            if(!createdBookingId) {
                alert('Booking ID tidak ditemukan!');
                return;
            }

            const originalBtnText = btnPaymentCompleted.textContent;
            btnPaymentCompleted.textContent = 'VERIFYING...';
            
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
                    qrisPaymentCard.style.display = 'none';
                    columnHeaderLabel.textContent = 'Payment Completed';
                    
                    // Ambil kode booking asli dari server atau URL jika ada
                    modalBookingId.textContent = "BOOKING ID: #BK-" + new Date().getFullYear() + "-" + createdBookingId.toString().padStart(4, '0');
                    
                    overlay.classList.add('is-active');
                    document.body.style.overflow = 'hidden';
                    clearInterval(paymentTimerInterval);
                } else {
                    alert('Gagal konfirmasi pembayaran.');
                }
            } catch(err) {
                alert('Gagal menghubungi server.');
            } finally {
                btnPaymentCompleted.textContent = originalBtnText;
            }
        });

        // Close Modal & Redirect (Opsional)
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('is-active');
                document.body.style.overflow = '';
                // Arahkan ke halaman utama/dashboard setelah sukses
                window.location.href = "/calendar";
            }
        });

        document.getElementById('downloadReceipt').addEventListener('click', function() {
            alert('Receipt will be downloaded shortly...');
        });

        function startPaymentTimer() {
            let timeLeft = 15 * 60; // 15 menit
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
                    alert("Waktu pembayaran telah habis. Silakan ulangi booking.");
                    window.location.reload();
                }
            }, 1000);
        }
    });
</script>

</body>
</html>