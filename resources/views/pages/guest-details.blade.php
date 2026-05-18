<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Guest Details - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/guest-details.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="guest-details-page">
    
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
        <div class="step active">
            <span class="step-icon">4</span>
            <span>Guest Details</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">5</span>
            <span>Confirm & Payment</span>
        </div>
    </nav>

    <header class="guest-header">
        <h1>Guest Details</h1>
        <p>Please complete your profile for a seamless check-in experience.</p>
    </header>

    <form action="#" method="POST">
        @csrf
        
        {{-- Section 1: Who is checking in? --}}
        <section class="form-section">
            <h2>Who is checking in?</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="e.g. John" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="e.g. Doe" required>
                </div>
                <div class="form-group full-width">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="For booking confirmation" required>
                </div>
                <div class="form-group full-width">
                    <label for="phone">Phone Number</label>
                    <div class="phone-input-group">
                        <select name="country_code">
                            <option value="+62">+62</option>
                            <option value="+1">+1</option>
                            <option value="+44">+44</option>
                        </select>
                        <input type="text" id="phone" name="phone" placeholder="WhatsApp number preferred" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" placeholder="e.g. 28">
                </div>
                <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <input type="text" id="occupation" name="occupation" placeholder="e.g. Freelancer">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" placeholder="e.g. Indonesia">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="e.g. Jakarta">
                </div>
                <div class="form-group full-width">
                    <label for="self_description">Self Description (Optional)</label>
                    <textarea id="self_description" name="self_description" rows="3" placeholder="Tell us a bit about yourself..."></textarea>
                </div>
                <div class="form-group full-width">
                    <label for="personal_notes">Personal Notes (Optional)</label>
                    <textarea id="personal_notes" name="personal_notes" rows="3" placeholder="Any additional notes for us?"></textarea>
                </div>
            </div>
        </section>

        {{-- Section 2: Reservation Details --}}
        <section class="form-section">
            <h2>Reservation Details</h2>
            
            {{-- Special Requests Accordion --}}
            <div class="accordion-section">
                <div class="accordion-header" onclick="toggleAccordion('special-requests')">
                    <span>Special Requests</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
                <div id="special-requests" class="accordion-content">
                    <textarea name="special_requests" class="special-requests-textarea" rows="4" placeholder="e.g. Dietary restrictions, room preference, late check-in..."></textarea>
                </div>
            </div>

            {{-- Transportation Accordion --}}
            <div class="accordion-section">
                <div class="accordion-header" onclick="toggleAccordion('transportation')">
                    <span>Transportation (Optional)</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
                <div id="transportation" class="accordion-content" style="display: none;">
                    <div class="transport-grid">
                        <div class="transport-card">
                            <label class="transport-label">Arrival</label>
                            <div class="transport-input-group">
                                <div class="custom-select">
                                    <select name="arrival_time">
                                        <option>Estimated Arrival Time</option>
                                    </select>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <input type="text" name="arrival_location" placeholder="Arriving Location (e.g. Airport, Train Station)">
                            </div>
                            <div class="transport-footer">
                                <a href="#" class="clear-btn">Clear</a>
                            </div>
                        </div>
                        <div class="transport-card">
                            <label class="transport-label">Departure</label>
                            <div class="transport-input-group">
                                <div class="custom-select">
                                    <select name="departure_time">
                                        <option>Estimated Departure Time</option>
                                    </select>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <input type="text" name="departure_location" placeholder="Arriving Location (e.g. Airport, Train Station)">
                            </div>
                            <div class="transport-footer">
                                <a href="#" class="clear-btn">Clear</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 3: Policies --}}
        <section class="form-section policies-form-section" style="padding: 0; overflow: hidden;">
            <div class="accordion-header" onclick="toggleAccordion('policies')" style="background: #D18D60;">
                <span>Policies</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </div>
            <div id="policies" class="accordion-content" style="background: var(--color-primary); color: #FFF; border: none; padding: 32px;">
                <div class="policies-grid">
                    <div class="policy-time">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div class="policy-time-content">
                            <div style="color: #AAA;">CHECK-IN</div>
                            <div style="color: #FFF;">14:00 - 21:00</div>
                        </div>
                    </div>
                    <div class="policy-time">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div class="policy-time-content">
                            <div style="color: #AAA;">CHECK-OUT</div>
                            <div style="color: #FFF;">Before 12:00</div>
                        </div>
                    </div>
                </div>
                <div class="house-rules">
                    <h4 style="color: #FFF;">House Rules</h4>
                    <ul style="color: #DDD; font-size: 12px; line-height: 1.8;">
                        <li>Quiet hours are observed from 22:00 to 07:00 to maintain a peaceful and comfortable environment for all guests.</li>
                        <li>Smoking is strictly prohibited inside rooms and all indoor common areas.</li>
                        <li>Please keep shared spaces clean and tidy after use.</li>
                        <li>Any form of criminal activity, violence, harassment, illegal substances, or behavior that may endanger others is strictly prohibited.</li>
                        <li>Guests are expected to respect fellow guests, staff, and property at all times.</li>
                        <li>All guests are required to provide valid identification and accurate personal information during check-in for security and registration purposes.</li>
                    </ul>
                </div>
                <div class="accept-checkbox">
                    <span style="color: #FFF; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">I Accepted</span>
                    <input type="checkbox" name="accept_policies" required checked>
                </div>
            </div>
        </section>

        {{-- Section 4: Payment Method --}}
        <section class="payment-section">
            <h2>Payment Method</h2>
            <div class="payment-options">
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="qris" checked>
                    <div class="payment-option-label">
                        <img src="{{ asset('images/icons/qris.png') }}" alt="QRIS" onerror="this.src='https://placehold.co/40x20?text=QRIS'">
                        <span>QRIS (Semua E-Wallet)</span>
                    </div>
                    <span class="payment-tag">Recommended</span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="e-wallet">
                    <div class="payment-option-label">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        <span>E-Wallet App</span>
                    </div>
                    <div class="payment-icons" style="font-size: 10px;">GoPay, OVO, ShopeePay</div>
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="bank_transfer">
                    <div class="payment-option-label">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 10V21"/><path d="M19 10V21"/><path d="M9 10V21"/><path d="M15 10V21"/><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
                        <span>Bank Transfer</span>
                    </div>
                    <div class="payment-icons" style="font-size: 10px;">BCA, Mandiri, BRI</div>
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="card">
                    <div class="payment-option-label">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        <span>Credit / Debit Card</span>
                    </div>
                    <div class="payment-icons">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/></svg>
                    </div>
                </label>
            </div>
        </section>

</main>

{{-- Booking Summary --}}
<footer class="booking-summary-footer">
    <div class="footer-container">
        <div class="summary-table">
            <div class="summary-row">
                <div class="summary-label"><strong>Serene Haven - 1 - Bottom Bed</strong></div>
                <div class="summary-price">IDR 625.000</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Breakfast AlaSare <span style="color: #A5B8A2; font-size: 10px;">For Free</span></div>
                <div class="summary-price"></div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Dinner Feast AlaSare</div>
                <div class="summary-price">IDR 35.000</div>
            </div>
            <div class="summary-row total">
                <div class="summary-label">EST. Total</div>
                <div class="summary-price">IDR 660.000</div>
            </div>
        </div>

        <div class="summary-actions">
            <a href="/calendar" class="btn-back">Back To Calendar</a>
            <button type="submit" class="btn-pay">Continue To Pay</button>
        </div>
    </div>
</footer>

<a href="https://wa.me/..." class="whatsapp-float">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

<script>
    function toggleAccordion(id) {
        const content = document.getElementById(id);
        const isVisible = content.style.display !== 'none';
        content.style.display = isVisible ? 'none' : 'block';
        
        // Optionally rotate the arrow icon
        const header = content.previousElementSibling;
        const arrow = header.querySelector('svg');
        arrow.style.transform = isVisible ? 'rotate(0deg)' : 'rotate(180deg)';
        arrow.style.transition = 'transform 0.3s';
    }
</script>

</body>
</html>
