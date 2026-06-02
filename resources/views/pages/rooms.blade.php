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
                    <h3>{{ $totalCapacity ?? 24 }}</h3>
                    <p>Capacity</p>
                </div>
                <div class="stat-item">
                    <h3>{{ $roomTypeLabel ?? 'Shared' }}</h3>
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
            @forelse($rooms as $room)
                <div class="room-card">
                    <div class="room-image">
                        @if($room['photo'])
                            <img src="{{ $room['photo'] }}" alt="{{ $room['name'] }}">
                        @else
                            <img src="{{ asset('images/rooms/room_1.png') }}" alt="{{ $room['name'] }}">
                        @endif
                        <div class="room-tags">
                            <span class="room-tag {{ $room['gender_type'] === 'Male' ? 'tag-male' : ($room['gender_type'] === 'Female' ? 'tag-female' : 'tag-mixed') }}">
                                {{ $room['gender_label'] }}
                            </span>
                            @if(!empty($room['attributes']))
                                @foreach($room['attributes'] as $attr)
                                    <span class="room-tag tag-info">{{ $attr }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="room-content">
                        <div class="room-title-price">
                            <h4>{{ $room['name'] }}</h4>
                            <div class="room-price">
                                <span class="room-price-val">Rp 125k</span>
                                <span class="room-price-unit">/ bed / night</span>
                            </div>
                        </div>
                        <div class="room-features">
                            @if(!empty($room['attributes']))
                                @foreach($room['attributes'] as $attr)
                                    <div class="room-feature">
                                        <svg viewBox="0 0 24 24"><path d="M19 19V4h-4V3H5v16H3v2h18v-2h-2zm-6-6h-2v-2h2v2z"/></svg>
                                        <span>{{ $attr }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <p class="room-desc">{{ $room['description'] ?: 'No description available.' }}</p>

                        <div class="room-availability">
                            <div class="room-availability-header {{ $room['is_sold_out'] ? 'low' : '' }}">
                                <span>Availability</span>
                                <span>{{ $room['available_beds'] }}/{{ $room['total_beds'] }} Beds Available</span>
                            </div>
                            <div class="availability-bar">
                                <div class="availability-fill {{ $room['is_sold_out'] ? 'low' : '' }}" style="width: {{ $room['availability_percentage'] }}%;"></div>
                            </div>
                        </div>

                        <div class="room-actions">
                            <div class="room-icons">
                                @if(!empty($room['main_facilities']))
                                    @foreach($room['main_facilities'] as $facility)
                                        @php
                                            $facilityName = strtolower(trim($facility));
                                            $iconPath = '';
                                            if(str_contains($facilityName, 'wi-fi') || str_contains($facilityName, 'wifi')) {
                                                $iconPath = 'M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2';
                                            } elseif(str_contains($facilityName, 'ac') || str_contains($facilityName, 'air')) {
                                                $iconPath = 'M2 12h20M2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6M12 2v2M12 12v4M8 12h8';
                                            } elseif(str_contains($facilityName, 'locker') || str_contains($facilityName, 'lock')) {
                                                $iconPath = 'M3 11h18a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2M7 11V7a5 5 0 0 1 10 0v4';
                                            } elseif(str_contains($facilityName, 'en-suite bath') || str_contains($facilityName, 'bath') || str_contains($facilityName, 'shower')) {
                                                $iconPath = 'M9 12h6M12 3v18M4 12h16M4 16h16';
                                            } else {
                                                $iconPath = 'M3 3h18a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2M9 9h6M9 12h6M9 15h6';
                                            }
                                        @endphp
                                        <button class="icon-btn" title="{{ trim($facility) }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="{{ $iconPath }}"></path>
                                            </svg>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                            @if($room['is_sold_out'])
                                <button class="btn-select" style="background:#B0B0B0;cursor:not-allowed;">Sold Out</button>
                            @else
                                <button class="btn-select">Select Bed</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #7a857f;">
                    <p>No rooms available at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>
</main>

@include('components.footer')

</body>
</html>
