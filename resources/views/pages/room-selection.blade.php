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
    
    <x-booking-stepper :currentStep="2" />

    <x-booking-header 
        title="Select Your Bed" 
        subtitle="Setiap ruang peristirahatan dirancang unik untuk kenyamanan Anda." 
    />

    <x-booking-summary-bar 
        checkIn="15/05/2026"
        checkOut="20/05/2026"
        guests="1 Male Guest"
    />

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

                <a class="btn-select-room" href="/bed-shared-room" style="text-decoration: none; display: inline-block;">SELECT</a>
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

                <a class="btn-select-room" href="/bed-shared-room" style="text-decoration: none; display: inline-block;">SELECT</a>
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

                <a class="btn-select-room" href="/bed-shared-room" style="text-decoration: none; display: inline-block;">SELECT</a>

            </div>
        </div>

    </div>

    {{-- Reusable Bottom Bar Component --}}
    <x-booking-bottom-bar 
        title="Select Your Room"
        label="EST.Total"
        value="IDR 625.000"
        backUrl="/calendar"
        backText="Back To Calender"
        continueUrl="/bed-shared-room"
        continueText="Continue To Bed"
    />

</main>

</body>
</html>
