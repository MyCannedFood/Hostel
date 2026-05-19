<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirm & Payment - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="confirm-payment-page">
    
    {{-- Booking Stepper --}}
    <nav class="booking-stepper">
        <div class="step completed">
            <span class="step-icon">✓</span>
            <span>Calendar</span>
        </div>
        <div class="step-divider"></div>
        <div class="step completed">
            <span class="step-icon">✓</span>
            <span>Room Selection</span>
        </div>
        <div class="step-divider"></div>
        <div class="step completed">
            <span class="step-icon">✓</span>
            <span>Bed & Shared Room</span>
        </div>
        <div class="step-divider"></div>
        <div class="step completed">
            <span class="step-icon">✓</span>
            <span>Guest Details</span>
        </div>
        <div class="step-divider"></div>
        <div class="step active">
            <span class="step-number">5</span>
            <span>Confirm & Payment</span>
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
                        <img src="{{ asset('images/rooms/room_1.png') }}" alt="Serene Haven" onerror="this.src='https://placehold.co/400x300?text=Serene+Haven'">
                        <span class="room-review-tag">Male Only</span>
                    </div>
                    <div class="room-review-details">
                        <h3>Serene Haven</h3>
                        <div class="room-review-bed">B1 - Bottom Bed</div>
                        <p class="room-review-desc">A functional and minimalist space designed for maximum comfort and simplicity.</p>
                        
                        <div class="room-review-features">
                            <div class="review-feature">
                                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>8-Person Capacity</span>
                            </div>
                            <div class="review-feature">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <span>External Shared Bathroom</span>
                            </div>
                            <div class="review-feature">
                                <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                                <span>Wi-Fi</span>
                            </div>
                            <div class="review-feature">
                                <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <span>Personal Locker</span>
                            </div>
                            <div class="review-feature">
                                <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                <span>AC</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="confirm-card">
                <h2>Your Stay</h2>
                <div class="stay-duration-box">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span>15 - 20 May 2026 (5 day)</span>
                </div>
            </section>

            <section class="confirm-card">
                <div class="confirm-card-header">
                    <h2>Guest Details</h2>
                    <a href="/guest-details" class="confirm-link">Edit</a>
                </div>
                <div class="guest-info-display">
                    <strong>Julian Walters</strong>
                    <span>julian@email.com</span>
                    <span>+44 7700 900XXX</span>
                </div>
            </section>

            <section class="confirm-card">
                <h2>Promotion</h2>
                <div class="promo-badge-card">
                    <div class="promo-badge-left">
                        <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        <div class="promo-badge-info">
                            <h4>ALASARE2026</h4>
                            <p>10% Discount Applied</p>
                        </div>
                    </div>
                    <button class="promo-badge-remove" onclick="this.closest('.promo-badge-card').style.display='none';">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            </section>

            <section class="confirm-card" style="margin-bottom: 0;">
                <div class="confirm-card-header">
                    <h2>Payment Method</h2>
                    <a href="/guest-details" class="confirm-link">Change</a>
                </div>
                <div class="payment-method-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M12 11h4v4h-4zM6 7v10M18 7v10M6 12h12"/></svg>
                    <span>QRIS / E-Wallet</span>
                </div>
            </section>

        </div>

        {{-- Right Column: Payment Summary --}}
        <div class="confirm-column-right">
            
            <div class="payment-summary-card">
                <h3>Payment Summary</h3>
                
                <div class="summary-details-list">
                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>Serene Haven (5 day)</span>
                            <span class="summary-item-sublabel">1 - Bottom Bed</span>
                        </div>
                        <span class="summary-item-value">IDR 625.000</span>
                    </div>

                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>AlaSare Breakfast</span>
                        </div>
                        <span class="summary-item-value">IDR 35.000</span>
                    </div>

                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>Promo Monday Only</span>
                        </div>
                        <span class="summary-item-value discount">- IDR 35.000</span>
                    </div>

                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>Dinner Feast AlaSare (1 pack)</span>
                        </div>
                        <span class="summary-item-value">IDR 35.000</span>
                    </div>

                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>Promo Discount (10%)</span>
                        </div>
                        <span class="summary-item-value discount">- IDR 75.000</span>
                    </div>

                    <div class="summary-item-row">
                        <div class="summary-item-label">
                            <span>Tax & Service (10%)</span>
                        </div>
                        <span class="summary-item-value">IDR 58.500</span>
                    </div>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-total-row">
                    <span class="summary-total-label">Total Payment</span>
                    <span class="summary-total-value">IDR 643.500</span>
                </div>

                <button class="btn-pay-now">
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    PAY NOW
                </button>

                <div class="agreement-container">
                    <input type="checkbox" id="agree-check" class="agreement-checkbox" checked>
                    <label for="agree-check" class="agreement-text">
                        I confirm that the personal information provided is accurate and valid.
                    </label>
                </div>
                
                <div class="agreement-subtext">
                    By clicking Pay Now, you agree to AlaSare's <a href="#">Terms of Service</a> and <a href="#">Cancellation Policy</a>.
                </div>
            </div>

        </div>

    </div>

    {{-- Footer Actions --}}
    <div class="confirm-footer-actions">
        <a href="/guest-details" class="btn-back-details">Back To Guest Details</a>
    </div>

</main>

<a href="https://wa.me/..." class="whatsapp-float">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

</body>
</html>
