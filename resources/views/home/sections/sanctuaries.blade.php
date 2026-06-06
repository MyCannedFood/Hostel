{{-- resources/views/home/sections/sanctuaries.blade.php --}}

<section id="home-sanctuaries">
    @php
        $featuredRoomsData = $featuredRoomsData ?? [
            'title' => 'Sanctuaries',
            'description' => 'Each villa possesses a unique soul, crafted from reclaimed teak and designed to frame the forest.',
        ];
        $featuredRooms = collect($featuredRooms ?? []);
        $roomPhoto = function ($room) {
            if (!$room->photo) return asset('images/rooms/room_1.png');
            return str_starts_with($room->photo, 'images/')
                ? asset($room->photo)
                : asset('storage/' . $room->photo);
        };
    @endphp

    {{-- Header --}}
    <div class="sanctuaries-header">
        <h2 class="sanctuaries-title">{{ $featuredRoomsData['title'] ?? 'Sanctuaries' }}</h2>
        <p class="sanctuaries-subtitle">
            {{ $featuredRoomsData['description'] ?? 'Each villa possesses a unique soul, crafted from reclaimed teak and designed to frame the forest.' }}
        </p>
    </div>

    {{-- Carousel Wrapper --}}
    <div class="sanctuaries-carousel-outer">
        <button class="carousel-arrow carousel-arrow--left" id="sanctuariesPrev" aria-label="Previous">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <div class="sanctuaries-carousel" id="sanctuariesCarousel">

            @forelse($featuredRooms as $room)
                <div class="sanctuary-card">
                    <div class="card-image-wrapper">
                        @if($room->gender_type)
                            <span class="card-badge">{{ $room->gender_type }} Only</span>
                        @endif
                        <img src="{{ $roomPhoto($room) }}" alt="{{ $room->name }}" class="card-image">
                    </div>
                    <div class="card-body">
                        <div class="card-top-row">
                            <h3 class="card-title">{{ $room->name }}</h3>
                            <div class="card-price">{{ $room->beds_count ?: $room->capacity }}<span class="price-per"> beds</span></div>
                        </div>
                        <p class="card-desc">
                            {{ $room->description ?: 'A quiet shared sanctuary designed for comfort, rest, and simple daily rituals.' }}
                        </p>
                        <div class="card-footer">
                            <div class="card-amenities">
                                @if($room->main_facilities)
                                    @php $facilities = explode(',', $room->main_facilities); @endphp
                                    @foreach($facilities as $facility)
                                        @php
                                            $facilityName = strtolower(trim($facility));
                                            $iconFile = 'images/icon/walk-svgrepo-com.svg';
                                            if(str_contains($facilityName, 'wi-fi') || str_contains($facilityName, 'wifi')) {
                                                $iconFile = 'images/icon/wifi-svgrepo-com-1.svg';
                                            } elseif(str_contains($facilityName, 'ac') || str_contains($facilityName, 'air')) {
                                                $iconFile = 'images/icon/snow-svgrepo-com.svg';
                                            } elseif(str_contains($facilityName, 'locker') || str_contains($facilityName, 'lock')) {
                                                $iconFile = 'images/icon/lock-svgrepo-com.svg';
                                            } elseif(str_contains($facilityName, 'en-suite bath') || str_contains($facilityName, 'bath') || str_contains($facilityName, 'shower')) {
                                                $iconFile = 'images/icon/shower-svgrepo-com.svg';
                                            }
                                        @endphp
                                        <img src="{{ asset($iconFile) }}" alt="{{ trim($facility) }}" class="amenity-icon">
                                    @endforeach
                                @endif
                            </div>
                            <a href="{{ url('/rooms') }}" class="card-reserve">RESERVE</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="sanctuary-card">
                    <div class="card-body">
                        <h3 class="card-title">No featured rooms yet</h3>
                        <p class="card-desc">Select rooms from the admin settings to show them here.</p>
                    </div>
                </div>
            @endforelse

        </div>

        <button class="carousel-arrow carousel-arrow--right" id="sanctuariesNext" aria-label="Next">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>

    {{-- CTA Button --}}
    <div class="sanctuaries-cta">
        <a href="#" class="btn-view-all">View All Accommodations</a>
    </div>

</section>


{{-- ===================== STYLES ===================== --}}
<style>
#home-sanctuaries {
        background-color: #ffffff;
        padding: 72px 0 80px;
        font-family: 'Georgia', 'Times New Roman', serif;
    }

    /* Header */
    .sanctuaries-header {
        text-align: center;
        margin-bottom: 48px;
        padding: 0 24px;
        width: 100%;
        display: block;
    }

    .sanctuaries-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 400;
        color: #2D4A2D;
        letter-spacing: 0.01em;
        margin: 0 0 16px;
        font-family: 'Garamond', 'Georgia', serif;
    }

    .sanctuaries-subtitle {
        font-size: 0.95rem;
        color: #5A6B5A;
        line-height: 1.65;
        margin: 0;
        font-family: 'Georgia', serif;
    }

    /* Carousel Outer */
    .sanctuaries-carousel-outer {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 0;
        padding: 0 48px;
        max-width: 1280px;
        margin: 0 auto;
    }

    /* Carousel Track */
    .sanctuaries-carousel {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding: 8px 4px 16px;
        flex: 1;
        scrollbar-width: none;
    }

    .sanctuaries-carousel::-webkit-scrollbar {
        display: none;
    }

    /* Arrow Buttons */
    .carousel-arrow {
        position: relative;
        top: 200px;
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1.5px solid #C4BAA8;
        background: #F2EFE7;
        color: #5A6B5A;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        z-index: 2;
        transform: translateY(-50%);
    }

    .carousel-arrow:hover {
        background: #2D4A2D;
        color: #fff;
        border-color: #2D4A2D;
    }

    .carousel-arrow--left {
        margin-right: 12px;
    }

    .carousel-arrow--right {
        margin-left: 12px;
    }

    /* Card */
    .sanctuary-card {
        flex: 0 0 420px;
        scroll-snap-align: start;
        background: #fff;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        display: flex;
        flex-direction: column;
    }

    /* Card Image */
    .card-image-wrapper {
        position: relative;
        width: 100%;
        height: 310px;
        overflow: hidden;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    .sanctuary-card:hover .card-image {
        transform: scale(1.03);
    }

    /* Badge */
    .card-badge {
        position: absolute;
        top: 18px;
        left: 18px;
        background: #2D4A2D;
        color: #fff;
        font-size: 0.78rem;
        font-family: 'Georgia', serif;
        padding: 6px 16px;
        border-radius: 100px;
        z-index: 1;
        letter-spacing: 0.03em;
    }

    /* Card Body */
    .card-body {
        padding: 22px 24px 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }

    .card-top-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .card-title {
        font-size: 1.45rem;
        font-weight: 400;
        color: #2A2A2A;
        margin: 0;
        font-family: 'Garamond', 'Georgia', serif;
        line-height: 1.2;
    }

    .card-price {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2A2A2A;
        white-space: nowrap;
        font-family: 'Georgia', serif;
        padding-top: 4px;
    }

    .price-per {
        font-weight: 400;
        font-size: 0.8rem;
        color: #888;
    }

    .card-desc {
        font-size: 0.82rem;
        color: #777;
        line-height: 1.6;
        margin: 0;
        font-family: 'Georgia', serif;
    }

    /* Card Footer */
    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 4px;
        padding-top: 14px;
        border-top: 1px dashed #E0DBD0;
    }

    .card-amenities {
        display: flex;
        gap: 14px;
        align-items: center;
    }

    .amenity-icon {
        width: 19px;
        height: 19px;
        object-fit: contain;
    }

    .card-reserve {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        color: #8B6914;
        text-decoration: none;
        font-family: 'Georgia', serif;
        transition: color 0.2s;
    }

    .card-reserve:hover {
        color: #2D4A2D;
    }

    /* CTA */
    .sanctuaries-cta {
        text-align: center;
        margin-top: 48px;
    }

    .btn-view-all {
        display: inline-block;
        padding: 14px 36px;
        background: #2D4A2D;
        color: #fff;
        font-size: 0.85rem;
        letter-spacing: 0.04em;
        text-decoration: none;
        font-family: 'Georgia', serif;
        transition: background 0.2s;
    }

    .btn-view-all:hover {
        background: #1e3320;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sanctuaries-carousel-outer {
            padding: 0 16px;
        }

        .sanctuary-card {
            flex: 0 0 320px;
        }

        .card-image-wrapper {
            height: 230px;
        }

        .carousel-arrow {
            display: none;
        }
    }
</style>


{{-- ===================== SCRIPTS ===================== --}}
<script>
    (function () {
        const carousel  = document.getElementById('sanctuariesCarousel');
        const btnPrev   = document.getElementById('sanctuariesPrev');
        const btnNext   = document.getElementById('sanctuariesNext');

        if (!carousel || !btnPrev || !btnNext) return;

        const scrollAmount = 444; // card width (420) + gap (24)

        btnPrev.addEventListener('click', function () {
            carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        btnNext.addEventListener('click', function () {
            carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    })();
</script>
