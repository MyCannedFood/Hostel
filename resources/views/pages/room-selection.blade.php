<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Select Your Bed - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="selection-page">
    
    {{-- Booking Stepper --}}
    <nav class="booking-stepper">
        <div class="step completed">
            <span class="step-icon">✓</span>
            <span>Calendar</span>
        </div>
        <div class="step-divider"></div>
        <div class="step active">
            <span class="step-icon">2</span>
            <span>Room Selection</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">3</span>
            <span>Bed & Shared Room</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">4</span>
            <span>Guest Details</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">5</span>
            <span>Confirm & Payment</span>
        </div>
    </nav>

    <header class="selection-header">
        <h1>Select Your Bed</h1>
        <p>Setiap ruang peristirahatan dirancang unik untuk kenyamanan Anda.</p>
    </header>

    {{-- Summary Bar (Reused from calendar style but in this page context) --}}
    <div class="calendar-summary-bar" style="margin-bottom: 40px;">
        <div class="summary-inputs">
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>Check-in: <strong>15/05/2026</strong></span>
            </div>
            <div class="divider"></div>
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>Check-out: <strong>20/05/2026</strong></span>
            </div>
            <div class="divider"></div>
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><strong>1 Male Guest</strong></span>
            </div>
        </div>
        <div class="promo-section">
            <div class="promo-input-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D37D4F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <input type="text" placeholder="Apply Promo Code">
            </div>
            <a href="#" class="apply-btn">Apply</a>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="calendar-controls" style="margin-bottom: 24px;">
        <div class="filter-tabs">
            <button class="filter-tab active">All Rooms</button>
            <button class="filter-tab">Female Only Dorm</button>
            <button class="filter-tab">Male Only Dorm</button>
        </div>
        <div class="nights-indicator">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            4 Nights
        </div>
    </div>

    {{-- Room Selection Container --}}
    <div class="selection-container">
        
        {{-- Serene Heaven --}}
        <div class="room-selection-card">
            <div class="room-sel-image">
                <img src="{{ asset('images/rooms/room_1.png') }}" alt="Arunika"> 
                <span class="room-sel-tag">Male Only</span>
            </div>
            <div class="room-sel-content">
                <h2>Serene Heaven</h2>
                <p class="room-sel-desc">A functional and minimalist space designed for maximum comfort and simplicity.</p>
                
                <div class="room-sel-features">
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        8 Person Capacity
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Extends Shared Bathroom
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        AC
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                        Wi-Fi
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Personal Locker
                    </div>
                </div>

                <div class="bed-availability-section">
                    <h4>Bed Availability</h4>
                    <div class="bed-grid">
                        <span class="bed-badge available">T1</span>
                        <span class="bed-badge available">B1</span>
                        <span class="bed-badge available">T2</span>
                        <span class="bed-badge available">B2</span>
                        <span class="bed-badge available">T3</span>
                        <span class="bed-badge available">B3</span>
                        <span class="bed-badge available">T4</span>
                        <span class="bed-badge available">B4</span>
                    </div>
                </div>

                <button class="btn-select-room">SELECT</button>
            </div>
        </div>

        {{-- Botanice --}}
        <div class="room-selection-card">
            <div class="room-sel-image">
                <img src="{{ asset('images/rooms/room_2.png') }}" alt="The Teak Nest">
                <span class="room-sel-tag">Male only</span>
            </div>
            <div class="room-sel-content">
                <h2>Botanice</h2>
                <p class="room-sel-desc">A refreshing tropical theme adorned with beautiful Brazilian Fern and bamboo interior decorations.</p>
                
                <div class="room-sel-features">
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        6 Person Capacity
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Similar Extension (Located in Bedroom)
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        AC
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                        Wi-Fi
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Personal Locker
                    </div>
                </div>

                <div class="bed-availability-section">
                    <h4>Bed Availability</h4>
                    <div class="bed-grid">
                        <span class="bed-badge available">T1</span>
                        <span class="bed-badge available">B1</span>
                        <span class="bed-badge available">T2</span>
                        <span class="bed-badge available">B2</span>
                        <span class="bed-badge available">T3</span>
                        <span class="bed-badge available">B3</span>
                    </div>
                </div>

                <button class="btn-select-room">SELECT</button>
            </div>
        </div>

        {{-- The Heritage --}}
        <div class="room-selection-card">
            <div class="room-sel-image">
                <img src="{{ asset('images/rooms/room_3.png') }}" alt="The Heritage">
                <span class="room-sel-tag" style="background: rgba(192, 124, 77, 0.8);">Female Only</span>
            </div>
            <div class="room-sel-content">
                <h2>The Heritage</h2>
                <p class="room-sel-desc">A serene tropical theme identical to The Teak Nest, featuring lush Brazilian Fern and bamboo decorations.</p>
                
                <div class="room-sel-features">
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        8 Person Capacity
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Extends Shared Bathroom
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        AC
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                        Wi-Fi
                    </div>
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Personal Locker
                    </div>
                </div>

                <div class="bed-availability-section">
                    <h4>Bed Availability</h4>
                    <div class="bed-grid">
                        <span class="bed-badge available">T1</span>
                        <span class="bed-badge available">B1</span>
                        <span class="bed-badge available">T2</span>
                        <span class="bed-badge available">B2</span>
                        <span class="bed-badge available">T3</span>
                        <span class="bed-badge available">B3</span>
                        <span class="bed-badge available">T4</span>
                        <span class="bed-badge available">B4</span>
                    </div>
                </div>

                <button class="btn-select-room">SELECT</button>
            </div>
        </div>

    </div>

    {{-- Bottom Bar --}}
    <div class="selection-bottom-bar">
        <div class="bottom-bar-content">
            <div class="selection-info">
                <span>Selected: <strong>Arunika Bed</strong></span>
                <span>Total: <strong>IDR 0</strong></span>
            </div>
            <button class="btn-continue">CONTINUE TO DETAILS</button>
        </div>
    </div>

</main>

<a href="https://wa.me/..." class="whatsapp-float">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

</body>
</html>
