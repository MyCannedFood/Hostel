<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Guest Details - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/guest-details.css', 'resources/js/app.js'])
    <style>
        /* CSS Untuk Footer Dinamis */
        .booking-summary-footer { position: fixed; bottom: 0; left: 0; width: 100%; background: #FFFFFF; border-top: 1px solid #E5E5E5; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); z-index: 999; padding: 20px; }
        .footer-container { max-width: 600px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px; }
        .summary-table { display: flex; flex-direction: column; gap: 8px; border-bottom: 2px solid #1A3D0A; padding-bottom: 16px; }
        .summary-row { display: flex; justify-content: space-between; font-size: 14px; color: #43493E; }
        .summary-row .summary-label { font-weight: 600; color: #43493E; text-transform: uppercase; }
        .summary-row.total { margin-top: 8px; }
        .summary-row.total .summary-label, 
        .summary-row.total .summary-price { font-weight: bold; color: #1A3D0A; font-size: 16px; text-transform: uppercase; }
        .summary-actions { display: flex; gap: 12px; justify-content: center; }
        .summary-actions .btn-back { background: #6CA16C; color: white; padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 15px; text-align: center; border: none; }
        .summary-actions .btn-pay { background: #D9864A; color: white; padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 15px; text-align: center; border: none; cursor: pointer; }
        body { padding-bottom: 220px; } 
    </style>
</head>
<body>

@include('components.navbar')

@php
    use Carbon\Carbon;
    
    // 1. Tangkap semua parameter URL dasar
    $checkInParam = request()->query('check_in');
    $checkOutParam = request()->query('check_out');
    $nightsParam = (int) request()->query('nights', 1);
    $guestsParam = request()->query('guests', '1a0c');
    $promoParam = request()->query('promo', '');
    $monthParam = request()->query('month', '');
    $roomIdParam = request()->query('room_id');
    $bedIdParam = request()->query('bed_id');
    $addonsParam = request()->query('addons', ''); 

    // 2. Tangkap parameter input form (jika kembali dari halaman payment)
    $guestData = [
        'first_name' => request()->query('first_name', ''),
        'last_name' => request()->query('last_name', ''),
        'email' => request()->query('email', ''),
        'phone' => request()->query('phone', ''),
        'age' => request()->query('age', ''),
        'occupation' => request()->query('occupation', ''),
        'country' => request()->query('country', ''),
        'city' => request()->query('city', ''),
        'self_description' => request()->query('self_description', ''),
        'personal_notes' => request()->query('personal_notes', ''),
        'special_requests' => request()->query('special_requests', ''),
        'arrival_time' => request()->query('arrival_time', ''),
        'arrival_location' => request()->query('arrival_location', ''),
        'departure_time' => request()->query('departure_time', ''),
        'departure_location' => request()->query('departure_location', ''),
        'payment_method' => request()->query('payment_method', 'qris'),
    ];

    // 3. Ambil data Room dan Bed dari Database
    $room = \App\Models\Room::find($roomIdParam);
    $bed = \App\Models\Bed::find($bedIdParam);
    
    $roomName = $room ? $room->name : 'Unknown Room';
    $bedName = $bed ? $bed->name : 'Unknown Bed';

    // 4. Kalkulasi Harga Kamar
    $basePrice = 0;
    if ($bed && $bed->base_price > 0) {
        $basePrice = $bed->base_price;
    } elseif ($room && $room->base_price > 0) {
        $basePrice = $room->base_price;
    } else {
        $basePrice = 125000; 
    }
    
    $totalBedCost = $basePrice * max(1, $nightsParam);
    $grandTotal = $totalBedCost;

    // 5. Kalkulasi Addons
    $addonIds = array_filter(explode(',', $addonsParam));
    $selectedAddons = \App\Models\Addon::whereIn('id', $addonIds)->get();
    
    $checkInDateObj = $checkInParam ? Carbon::parse($checkInParam) : Carbon::now();
    $checkInDayName = $checkInDateObj->format('l');

    $addonDetails = [];
    foreach($selectedAddons as $addon) {
        $isFree = false;
        if ($addon->is_auto_include && is_array($addon->include_days)) {
            if (in_array($checkInDayName, $addon->include_days)) {
                $isFree = true;
            }
        }
        
        $cost = $isFree ? 0 : $addon->price;
        $grandTotal += $cost;

        $addonDetails[] = [
            'name' => $addon->name,
            'note' => $isFree ? ($addon->note ?? '(For free)') : '',
            'cost' => $cost
        ];
    }

    // 6. RAKIT ULANG URL UNTUK NAVIGASI STEPPER
    $queryParamsArray = request()->except(['_token']);
    $queryParams = http_build_query($queryParamsArray);
    $calendarUrl = url('/calendar') . '?' . $queryParams;
    $roomSelectionUrl = url('/room-selection') . '?' . $queryParams;
    $bedSelectionUrl = url('/bed-shared-room/' . ($roomIdParam ?? 1)) . '?' . $queryParams;
    $backUrl = $bedSelectionUrl;
@endphp

<main class="guest-details-page">
    
    {{-- Booking Stepper Aktif --}}
    <nav class="booking-stepper">
        <a href="{!! $calendarUrl !!}" class="step completed" style="text-decoration: none; color: inherit;">
            <span class="step-icon">✓</span>
            <span>Calendar</span>
        </a>
        <div class="step-divider"></div>
        <a href="{!! $roomSelectionUrl !!}" class="step completed" style="text-decoration: none; color: inherit;">
            <span class="step-icon">✓</span>
            <span>Room Selection</span>
        </a>
        <div class="step-divider"></div>
        <a href="{!! $bedSelectionUrl !!}" class="step completed" style="text-decoration: none; color: inherit;">
            <span class="step-icon">✓</span>
            <span>Bed & Shared Room</span>
        </a>
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

    <form action="/confirm-payment" method="GET" id="guestDetailsForm">
        
        {{-- Input Hidden Penjaga State Dasar --}}
        <input type="hidden" name="check_in" value="{{ $checkInParam }}">
        <input type="hidden" name="check_out" value="{{ $checkOutParam }}">
        <input type="hidden" name="nights" value="{{ $nightsParam }}">
        <input type="hidden" name="guests" value="{{ $guestsParam }}">
        <input type="hidden" name="promo" value="{{ $promoParam }}">
        <input type="hidden" name="month" value="{{ $monthParam }}">
        <input type="hidden" name="room_id" value="{{ $roomIdParam }}">
        <input type="hidden" name="bed_id" value="{{ $bedIdParam }}">
        <input type="hidden" name="addons" value="{{ $addonsParam }}">
        
        {{-- Section 1: Who is checking in? --}}
        <section class="form-section">
            <h2>Who is checking in?</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ $guestData['first_name'] }}" placeholder="e.g. John" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ $guestData['last_name'] }}" placeholder="e.g. Doe" required>
                </div>
                <div class="form-group full-width">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ $guestData['email'] }}" placeholder="For booking confirmation" required>
                </div>
                <div class="form-group full-width">
                    <label for="phone">Phone Number</label>
                    <div class="phone-input-group">
                        <select name="country_code">
                            <option value="+62">+62</option>
                            <option value="+1">+1</option>
                            <option value="+44">+44</option>
                        </select>
                        <input type="text" id="phone" name="phone" value="{{ $guestData['phone'] }}" placeholder="WhatsApp number preferred" required inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/\D/g,'');">
                    </div>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="{{ $guestData['age'] }}" placeholder="e.g. 28">
                </div>
                <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <input type="text" id="occupation" name="occupation" value="{{ $guestData['occupation'] }}" placeholder="e.g. Freelancer">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" value="{{ $guestData['country'] }}" placeholder="e.g. Indonesia">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="{{ $guestData['city'] }}" placeholder="e.g. Jakarta">
                </div>
                <div class="form-group full-width">
                    <label for="self_description">Self Description (Optional)</label>
                    <textarea id="self_description" name="self_description" rows="3" placeholder="Tell us a bit about yourself...">{{ $guestData['self_description'] }}</textarea>
                </div>
                <div class="form-group full-width">
                    <label for="personal_notes">Personal Notes (Optional)</label>
                    <textarea id="personal_notes" name="personal_notes" rows="3" placeholder="Any additional notes for us?">{{ $guestData['personal_notes'] }}</textarea>
                </div>
            </div>
        </section>

        {{-- Section 2: Reservation Details --}}
        <section class="form-section">
            <h2>Reservation Details</h2>
            
            <div class="accordion-section">
                <div class="accordion-header" onclick="toggleAccordion('special-requests')">
                    <span>Special Requests</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </div>
                <div id="special-requests" class="accordion-content">
                    <textarea name="special_requests" class="special-requests-textarea" rows="4" placeholder="e.g. Dietary restrictions, room preference, late check-in...">{{ $guestData['special_requests'] }}</textarea>
                </div>
            </div>

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
                                        <option value="">Estimated Arrival Time</option>
                                        <option value="Morning" {{ $guestData['arrival_time'] == 'Morning' ? 'selected' : '' }}>Morning (06:00 - 12:00)</option>
                                        <option value="Afternoon" {{ $guestData['arrival_time'] == 'Afternoon' ? 'selected' : '' }}>Afternoon (12:00 - 18:00)</option>
                                        <option value="Night" {{ $guestData['arrival_time'] == 'Night' ? 'selected' : '' }}>Night (18:00 - 24:00)</option>
                                    </select>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <input type="text" name="arrival_location" value="{{ $guestData['arrival_location'] }}" placeholder="Arriving Location (e.g. Airport, Train Station)">
                            </div>
                            <div class="transport-footer">
                                <a href="#" class="clear-btn" onclick="clearTransport(this, event)">Clear</a>
                            </div>
                        </div>
                        <div class="transport-card">
                            <label class="transport-label">Departure</label>
                            <div class="transport-input-group">
                                <div class="custom-select">
                                    <select name="departure_time">
                                        <option value="">Estimated Departure Time</option>
                                        <option value="Morning" {{ $guestData['departure_time'] == 'Morning' ? 'selected' : '' }}>Morning (06:00 - 12:00)</option>
                                        <option value="Afternoon" {{ $guestData['departure_time'] == 'Afternoon' ? 'selected' : '' }}>Afternoon (12:00 - 18:00)</option>
                                        <option value="Night" {{ $guestData['departure_time'] == 'Night' ? 'selected' : '' }}>Night (18:00 - 24:00)</option>
                                    </select>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <input type="text" name="departure_location" value="{{ $guestData['departure_location'] }}" placeholder="Arriving Location (e.g. Airport, Train Station)">
                            </div>
                            <div class="transport-footer">
                                <a href="#" class="clear-btn" onclick="clearTransport(this, event)">Clear</a>
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
            <div id="policies" class="accordion-content" style="background: #1A3D0A; color: #FFF; border: none; padding: 32px;">
                <div class="policies-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div class="policy-time" style="display: flex; gap: 12px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div class="policy-time-content">
                            <div style="color: #A5B8A2; font-size: 12px; font-weight: bold;">CHECK-IN</div>
                            <div style="color: #FFF; font-size: 16px;">{{ $policies['checkin_time'] ?? '14:00' }}</div>
                        </div>
                    </div>
                    <div class="policy-time" style="display: flex; gap: 12px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div class="policy-time-content">
                            <div style="color: #A5B8A2; font-size: 12px; font-weight: bold;">CHECK-OUT</div>
                            <div style="color: #FFF; font-size: 16px;">Before {{ $policies['checkout_time'] ?? '12:00' }}</div>
                        </div>
                    </div>
                </div>
                <div class="house-rules">
                    <h4 style="color: #FFF; margin-bottom: 12px;">House Rules</h4>
                    <ul style="color: #D1DCD1; font-size: 13px; line-height: 1.8; margin: 0; padding-left: 20px;">
                        @php $rules = explode("\n", $policies['house_rules'] ?? "No smoking inside rooms\nQuiet hours after 22:00\nGuests must register at reception"); @endphp
                        @foreach ($rules as $rule)
                            @if (trim($rule))
                                <li>{{ trim($rule) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="accept-checkbox" style="margin-top: 24px; display: flex; align-items: center; gap: 12px;">
                    <input type="checkbox" name="accept_policies" id="accept_policies" required style="width: 18px; height: 18px; cursor: pointer;">
                    <label for="accept_policies" style="color: #FFF; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; cursor: pointer;">I Accepted</label>
                </div>
            </div>
        </section>

        {{-- Section 4: Payment Method --}}
        <section class="payment-section" style="background: white; padding: 32px; border-radius: 12px; border: 1px solid #E5E5E5; margin-top: 24px;">
            <h2 style="font-size: 20px; color: #1A3D0A; margin-bottom: 20px;">Payment Method</h2>
            <div class="payment-options" style="display: flex; flex-direction: column; gap: 12px;">
                <label class="payment-option" style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border: 1px solid #E5E5E5; border-radius: 8px; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="radio" name="payment_method" value="qris" {{ $guestData['payment_method'] == 'qris' ? 'checked' : '' }}>
                        <div class="payment-option-label" style="display: flex; align-items: center; gap: 8px; font-weight: bold; color: #1A3D0A;">
                            <img src="{{ asset('images/icons/qris.png') }}" alt="QRIS" onerror="this.src='https://placehold.co/40x20?text=QRIS'" style="height: 20px;">
                            <span>QRIS (Semua E-Wallet)</span>
                        </div>
                    </div>
                    <span class="payment-tag" style="background: #FFF3E0; color: #D9864A; padding: 4px 8px; font-size: 11px; border-radius: 4px; font-weight: bold;">Recommended</span>
                </label>
                <label class="payment-option" style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border: 1px solid #E5E5E5; border-radius: 8px; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="radio" name="payment_method" value="e-wallet" {{ $guestData['payment_method'] == 'e-wallet' ? 'checked' : '' }}>
                        <div class="payment-option-label" style="display: flex; align-items: center; gap: 8px; font-weight: bold; color: #1A3D0A;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                            <span>E-Wallet App</span>
                        </div>
                    </div>
                    <div class="payment-icons" style="font-size: 12px; color: #7D8A74;">GoPay, OVO, ShopeePay</div>
                </label>
                <label class="payment-option" style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border: 1px solid #E5E5E5; border-radius: 8px; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="radio" name="payment_method" value="bank_transfer" {{ $guestData['payment_method'] == 'bank_transfer' ? 'checked' : '' }}>
                        <div class="payment-option-label" style="display: flex; align-items: center; gap: 8px; font-weight: bold; color: #1A3D0A;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 10V21"/><path d="M19 10V21"/><path d="M9 10V21"/><path d="M15 10V21"/><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
                            <span>Bank Transfer</span>
                        </div>
                    </div>
                    <div class="payment-icons" style="font-size: 12px; color: #7D8A74;">BCA, Mandiri, BRI</div>
                </label>
                <label class="payment-option" style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border: 1px solid #E5E5E5; border-radius: 8px; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="radio" name="payment_method" value="card" {{ $guestData['payment_method'] == 'card' ? 'checked' : '' }}>
                        <div class="payment-option-label" style="display: flex; align-items: center; gap: 8px; font-weight: bold; color: #1A3D0A;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            <span>Credit / Debit Card</span>
                        </div>
                    </div>
                    <div class="payment-icons">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7D8A74" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/></svg>
                    </div>
                </label>
            </div>
        </section>

    </form>
</main>

{{-- Booking Summary Footer Dinamis --}}
<footer class="booking-summary-footer">
    <div class="footer-container">
        <div class="summary-table">
            
            <div class="summary-row">
                <div class="summary-label">{{ $roomName }} - {{ $bedName }}</div>
                <div class="summary-price">IDR {{ number_format($totalBedCost, 0, ',', '.') }}</div>
            </div>
            
            @foreach($addonDetails as $addon)
                <div class="summary-row">
                    <div class="summary-label">
                        {{ $addon['name'] }} 
                        @if($addon['note'])
                            <span style="color: #A5B8A2; font-size: 10px; margin-left: 4px;">{{ $addon['note'] }}</span>
                        @endif
                    </div>
                    <div class="summary-price">
                        {{ $addon['cost'] > 0 ? 'IDR ' . number_format($addon['cost'], 0, ',', '.') : '' }}
                    </div>
                </div>
            @endforeach
            
            <div class="summary-row total">
                <div class="summary-label">EST. Total</div>
                <div class="summary-price">IDR {{ number_format($grandTotal, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="summary-actions">
            {{-- Tombol Back akan mengembalikan user ke halaman pilih kasur dengan state form utuh --}}
            <a href="#" class="btn-back" id="btnBackToBed">Back To Bed Selection</a>
            <button type="submit" form="guestDetailsForm" class="btn-pay">Continue To Pay</button>
        </div>
    </div>
</footer>

<a href="https://wa.me/..." class="whatsapp-float" style="position: fixed; right: 20px; bottom: 200px; background: #25D366; border-radius: 50%; padding: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); z-index: 1000;">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

<script>
    function toggleAccordion(id) {
        const content = document.getElementById(id);
        const isVisible = content.style.display !== 'none';
        content.style.display = isVisible ? 'none' : 'block';
        
        const header = content.previousElementSibling;
        const arrow = header.querySelector('svg');
        if(arrow) {
            arrow.style.transform = isVisible ? 'rotate(0deg)' : 'rotate(180deg)';
            arrow.style.transition = 'transform 0.3s';
        }
    }

    function clearTransport(btn, e) {
        e.preventDefault();
        const card = btn.closest('.transport-card');
        const select = card.querySelector('select');
        const input = card.querySelector('input');
        if(select) select.selectedIndex = 0;
        if(input) input.value = '';
    }

    // === JAVASCRIPT STATE PRESERVER ===
    document.addEventListener('DOMContentLoaded', function() {
        const theForm = document.getElementById('guestDetailsForm');
        const stepperLinks = document.querySelectorAll('.booking-stepper a');
        const btnBackFooter = document.getElementById('btnBackToBed');

        // Fungsi untuk mengumpulkan semua data form menjadi URL Parameters
        function getFormStateAsQueryString() {
            const formData = new FormData(theForm);
            const params = new URLSearchParams();
            
            // Loop semua input dan tambahkan ke param jika isinya tidak kosong
            for (const [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value);
                }
            }
            return params.toString();
        }

        // Fungsi ajaib untuk mengupdate semua link navigasi secara live
        function updateAllLinks() {
            const currentFormState = getFormStateAsQueryString();
            
            // Update Stepper Top Links
            stepperLinks.forEach(link => {
                const baseUrl = link.getAttribute('href').split('?')[0];
                link.setAttribute('href', baseUrl + '?' + currentFormState);
            });

            // Update Tombol Back di Footer
            const baseBackUrl = "{!! $backUrl !!}".split('?')[0];
            btnBackFooter.setAttribute('href', baseBackUrl + '?' + currentFormState);
        }

        // Tempelkan sensor pendeteksi ketikan di SEMUA input form
        theForm.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', updateAllLinks);
            if(input.tagName === 'INPUT' && (input.type === 'text' || input.type === 'email' || input.type === 'number')) {
                input.addEventListener('keyup', updateAllLinks); // Deteksi per huruf!
            }
        });

        // Jalankan sekali saat halaman pertama kali dimuat
        updateAllLinks();
    });

    // Validasi form Policies sebelum submit ke halaman Payment
    document.getElementById('guestDetailsForm').addEventListener('submit', function(e) {
        const cb = document.getElementById('accept_policies');
        if(!cb.checked) {
            e.preventDefault();
            alert('Please accept the House Rules & Policies to proceed.');
            
            const policiesDiv = document.getElementById('policies');
            if (policiesDiv.style.display === 'none') {
                toggleAccordion('policies');
            }
        }
    });
</script>

</body>
</html>