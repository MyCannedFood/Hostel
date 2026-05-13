<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rooms - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: var(--color-bg-light); color: #111;">

@include('components.navbar')

<main>
    {{-- Sanctuaries Section --}}
    <section id="home-sanctuaries" class="sanctuaries-section">
        
        <!-- Intro Banner -->
        <div class="sanctuaries-intro">
            <div class="sanctuaries-intro-content">
                <div class="sanctuaries-logo">
                    <img src="{{ asset('images/logo_only.png') }}" alt="AlaSare Logo" style="object-fit: contain;">
                </div>
                <div class="sanctuaries-intro-text">
                    <h2>Our Rooms</h2>
                    <p>Embrace the warmth of Nusantara in our nature-inspired shared rooms. Limited to just 24 guests, we offer an intimate tropical escape to rest, recharge, and connect with fellow travelers.</p>
                </div>
            </div>
            <div class="sanctuaries-stats">
                <div class="stat-item">
                    <h3>24</h3>
                    <p>Capacity</p>
                </div>
                <div class="stat-item">
                    <h3>Shared</h3>
                    <p>Social Spaces</p>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="sanctuaries-header">
            <div class="sanctuaries-header-title">
                <h3>Available Rooms</h3>
                <p>Find your peaceful corner among the ferns and teakwood.</p>
            </div>
            <button class="filter-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                Filter
            </button>
        </div>

        <!-- Grid -->
        <div class="rooms-grid">
            
            <!-- Room 1 -->
            <div class="room-card">
                <div class="room-image">
                    <img src="{{ asset('images/rooms/room_1.png') }}" alt="Herbal Garden Dorm">
                    <div class="room-tags">
                        <span class="room-tag tag-male">Male Only</span>
                        <span class="room-tag tag-info">Simple & Functional</span>
                    </div>
                </div>
                <div class="room-content">
                    <div class="room-title-price">
                        <h4>Herbal Garden Dorm</h4>
                        <div class="room-price">
                            <span class="room-price-val">Rp 125k</span>
                            <span class="room-price-unit">/ bed / night</span>
                        </div>
                    </div>
                    <div class="room-features">
                        <div class="room-feature">
                            <svg viewBox="0 0 24 24"><path d="M19 19V4h-4V3H5v16H3v2h18v-2h-2zm-6-6h-2v-2h2v2z"/></svg>
                            <span>Swing door (Ayun)</span>
                        </div>
                        <div class="room-feature">
                            <svg viewBox="0 0 24 24"><path d="M7 7h10v2H7zm0 4h10v2H7zm0 4h7v2H7zM4 3h16v18H4V3zm2 2v14h12V5H6z"/></svg>
                            <span>Shared Bathroom (Luar)</span>
                        </div>
                    </div>
                    <p class="room-desc">A simple and functional sanctuary designed for essential comfort, featuring 4 sturdy bunk beds (8 capacity).</p>
                    
                    <div class="room-availability">
                        <div class="room-availability-header">
                            <span>Availability</span>
                            <span>6/8 Beds Available</span>
                        </div>
                        <div class="availability-bar">
                            <div class="availability-fill" style="width: 75%;"></div>
                        </div>
                    </div>

                <div class="room-actions">
                    <div class="room-icons">
                        <button class="icon-btn" title="Swing Door"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg></button>
                        <button class="icon-btn" title="Shared Bathroom"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 4h10M9 4v1m6-1v1M8 8v10a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V8M7 8h10"/></svg></button>
                        <button class="icon-btn" title="Simple & Functional"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 12h6M9 15h6"/></svg></button>
                    </div>
                    <button class="btn-select">Select Bed</button>
                </div>
                </div>
            </div>

            <!-- Room 2 -->
            <div class="room-card">
                <div class="room-image">
                    <img src="{{ asset('images/rooms/room_2.png') }}" alt="Nusantara Suite">
                    <div class="room-tags">
                        <span class="room-tag tag-male">Male Only</span>
                    </div>
                </div>
                <div class="room-content">
                    <div class="room-title-price">
                        <h4>Nusantara Suite</h4>
                        <div class="room-price">
                            <span class="room-price-val">Rp 150k</span>
                            <span class="room-price-unit">/ bed / night</span>
                        </div>
                    </div>
                    <div class="room-features">
                        <div class="room-feature">
                            <svg viewBox="0 0 24 24"><path d="M19 19V4h-4V3H5v16H3v2h18v-2h-2zm-6-6h-2v-2h2v2z"/></svg>
                            <span>Sliding door (Pintu geser)</span>
                        </div>
                        <div class="room-feature">
                            <svg viewBox="0 0 24 24"><path d="M7 7h10v2H7zm0 4h10v2H7zm0 4h7v2H7zM4 3h16v18H4V3zm2 2v14h12V5H6z"/></svg>
                            <span>Ensuite (Terpisah sekat kaca)</span>
                        </div>
                    </div>
                    <p class="room-desc">Tropical-themed suite with Brazilian Ferns and bamboo. Features 4 bunk beds, ensuite with separate toilet and shower area, divided by glass.</p>
                    
                    <div class="room-availability">
                        <div class="room-availability-header low">
                            <span>Availability</span>
                            <span>0/8 Beds Available</span>
                        </div>
                        <div class="availability-bar">
                            <div class="availability-fill low" style="width: 100%;"></div>
                        </div>
                    </div>

                    <div class="room-actions">
                        <div class="room-icons">
                            <button class="icon-btn" title="Sliding Door"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M12 3v18M9 9h0M15 9h0"/></svg></button>
                            <button class="icon-btn" title="Ensuite Separate"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 4h10M9 4v1m6-1v1M8 8v10a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V8M7 8h10"/></svg></button>
                            <button class="icon-btn" title="Tropical Pakis Brazil"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 3.5 1.8 9.3Z"/><path d="M11 20A10 10 0 0 1 2.2 7.1c.5 2.1 2.8 3.7 3.7 3.5s.6-3.2 2.1-4.5c.3-1.2 1-3.4-1.8-5.7C10.5 2.5 11 3.5 11 20Z"/><path d="M11 20V10"/></svg></button>
                        </div>
                        <button class="btn-select" style="background:#B0B0B0;cursor:not-allowed;">Sold Out</button>
                    </div>
                </div>
            </div>

            <!-- Room 3 -->
            <div class="room-card">
                <div class="room-image">
                    <img src="{{ asset('images/rooms/room_3.png') }}" alt="Bamboo Sanctuary">
                    <div class="room-tags">
                        <span class="room-tag tag-female">Female Only</span>
                    </div>
                </div>
                <div class="room-content">
                    <div class="room-title-price">
                        <h4>Bamboo Sanctuary</h4>
                        <div class="room-price">
                            <span class="room-price-val">Rp 150k</span>
                            <span class="room-price-unit">/ bed / night</span>
                        </div>
                    </div>
                    <div class="room-features">
                        <div class="room-feature">
                            <svg viewBox="0 0 24 24"><path d="M19 19V4h-4V3H5v16H3v2h18v-2h-2zm-6-6h-2v-2h2v2z"/></svg>
                            <span>Swing door (Pintu biasa)</span>
                        </div>
                        <div class="room-feature">
                            <svg viewBox="0 0 24 24"><path d="M7 7h10v2H7zm0 4h10v2H7zm0 4h7v2H7zM4 3h16v18H4V3zm2 2v14h12V5H6z"/></svg>
                            <span>Ensuite (1 Ruang sekat kaca)</span>
                        </div>
                    </div>
                    <p class="room-desc">Light-filled bamboo sanctuary featuring Brazilian Ferns. Includes 4 bunk beds, an ensuite with toilet and shower in one space, separated by a glass partition.</p>
                    
                    <div class="room-availability">
                        <div class="room-availability-header">
                            <span>Availability</span>
                            <span>6/8 Beds Available</span>
                        </div>
                        <div class="availability-bar">
                            <div class="availability-fill" style="width: 75%;"></div>
                        </div>
                    </div>

                    <div class="room-actions">
                        <div class="room-icons">
                            <button class="icon-btn" title="Swing Door"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg></button>
                            <button class="icon-btn" title="Ensuite Bathroom"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 4h10M9 4v1m6-1v1M8 8v10a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V8M7 8h10"/></svg></button>
                            <button class="icon-btn" title="Tropical Bamboo Theme"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 3.5 1.8 9.3Z"/><path d="M11 20A10 10 0 0 1 2.2 7.1c.5 2.1 2.8 3.7 3.7 3.5s.6-3.2 2.1-4.5c.3-1.2 1-3.4-1.8-5.7C10.5 2.5 11 3.5 11 20Z"/><path d="M11 20V10"/></svg></button>
                        </div>
                        <button class="btn-select">Select Bed</button>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

@include('components.footer')

</body>
</html>
