<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Select Your Bed - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/bed-shared-room.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="selection-page">

    {{-- Booking Stepper --}}
    <nav class="booking-stepper">
        <div class="step completed">
            <span class="step-icon">&#10003;</span>
            <span>Calendar</span>
        </div>
        <div class="step-divider"></div>
        <div class="step completed">
            <span class="step-icon">&#10003;</span>
            <span>Room Selection</span>
        </div>
        <div class="step-divider"></div>
        <div class="step active">
            <span class="step-icon">3</span>
            <span>Bed &amp; Shared Room</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">4</span>
            <span>Guest Details</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">5</span>
            <span>Confirm &amp; Payment</span>
        </div>
    </nav>

    {{-- Page Header --}}
    <header class="selection-header">
        <h1>Choose Your Private Space</h1>
        <p>Kami menyewakan per bed. Anda memilih bed spesifik dalam kamar bersama.</p>
    </header>

    {{-- Summary Bar --}}
    <div class="calendar-summary-bar" style="margin-bottom: 32px;">
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

    {{-- Selection Container --}}
    <div class="selection-container">

        <div class="room-selection-card">

            {{-- Card Header --}}
            <div class="room-card-header">
                <h2>Room &nbsp; Serene Haven</h2>
                <span class="room-type-badge">Room Type: Male Dorm</span>
            </div>

            {{-- Card Body: image + info --}}
            <div class="room-card-body">
                <div class="room-sel-image">
                    <img src="{{ asset('images/sharedroom/room_1.png') }}" alt="Serene Haven">
                    <span class="room-sel-tag">Male Only</span>
                </div>
                <div class="room-sel-content">
                    <h2>Serene Haven</h2>
                    <p class="room-sel-desc">A functional and minimalist space designed for maximum comfort and simplicity.</p>

                    <div class="room-sel-features">
                        <div class="sel-feature">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            8-Person Capacity
                        </div>
                        <div class="sel-feature">
                            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            External Shared Bathroom
                        </div>
                        <div class="sel-feature">
                            <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                            Wi-Fi
                        </div>
                        <div class="sel-feature">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Personal Locker
                        </div>
                        <div class="sel-feature">
                            <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            AC
                        </div>
                    </div>
                </div>
            </div>

            {{-- Floor Plan --}}
            <div class="floor-plan-area">
                <img src="{{ asset('images/sharedroom/serene-haven-floorplan.png') }}" alt="Serene Haven Floor Plan">
            </div>

            {{-- Locker image --}}
            <div class="locker-image-wrapper" style="margin: 0 20px 0;">
                <img src="{{ asset('images/sharedroom/locker.png') }}" alt="Personal Locker">
                <span class="locker-badge">Secure Storage</span>
            </div>

            {{-- Room Rules --}}
            <div class="room-rules">
                <h4>Room Rules</h4>
                <ul>
                    <li><span class="rule-icon">🔇</span> Quiet hours (22:00 – 07:00)</li>
                    <li><span class="rule-icon">🚭</span> Strictly no smoking</li>
                    <li><span class="rule-icon">👤</span> One person per bed</li>
                    <li><span class="rule-icon">🍽️</span> No food inside the beds</li>
                </ul>
            </div>

        </div>

        {{-- Kenali Calon Teman Sekamar --}}
        <div class="roommates-section">
            <h3>Kenali Calon Teman Sekamar</h3>

            {{-- Roommate 1 --}}
            <div class="room-selection-card" style="border-radius: 12px; overflow: hidden;">
                <div class="roommate-card">
                    <img src="{{ asset('images/sharedroom/julian.png') }}" alt="Julian Harrison" class="roommate-photo">
                    <div class="roommate-info">
                        <h4>Julian Harrison</h4>
                        <p class="roommate-meta">29 years old &bull; <strong>Senior Architect</strong></p>
                        <p class="roommate-bio">Focusing on sustainable urban spaces during my stay. Love to start the day with a jog and find the best local espresso. Looking forward to sharing the space!</p>
                        <div class="roommate-tags">
                            <span class="roommate-tag">Sustainability</span>
                            <span class="roommate-tag">Urban Design</span>
                            <span class="roommate-tag">Coffee Connoisseur</span>
                        </div>
                    </div>
                    <span class="roommate-bed-badge">Bed: 1 Top Bed</span>
                </div>
            </div>

            {{-- Roommate 2 --}}
            <div class="room-selection-card" style="border-radius: 12px; overflow: hidden; margin-top: 12px;">
                <div class="roommate-card">
                    <img src="{{ asset('images/sharedroom/liam.png') }}" alt="Liam Smith" class="roommate-photo">
                    <div class="roommate-info">
                        <h4>Liam Smith</h4>
                        <p class="roommate-meta">25 years old &bull; <strong>Full-stack Developer</strong></p>
                        <p class="roommate-bio">Working remotely while exploring Southeast Asia. Usually quiet when working, but always up for a sunset drink or exploring the night markets.</p>
                        <div class="roommate-tags">
                            <span class="roommate-tag">Code & Coffee</span>
                            <span class="roommate-tag">Digital Nomad</span>
                            <span class="roommate-tag">Hiking</span>
                        </div>
                    </div>
                    <span class="roommate-bed-badge">Bed: 2 Bottom Bed</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom Sticky Bar --}}
    <div class="selection-bottom-bar">
        <div class="bottom-bar-content">
            <div class="selection-info">
                <span>Selected: <strong>Serene Haven – B1 – Bottom Bed – IDR 750,000</strong></span>
                <span>Total: <strong>IDR 750,000 (5 days 4 Nights + 1 Male Guest)</strong></span>
            </div>
            <div class="bottom-actions">
                <button class="btn-back">Back To Rooms</button>
                <button class="btn-continue">Continue To Details</button>
            </div>
        </div>
    </div>

</main>


</body>
</html>