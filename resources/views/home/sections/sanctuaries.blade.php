{{-- resources/views/home/sections/sanctuaries.blade.php --}}

<section id="home-sanctuaries">

    {{-- Header --}}
    <div class="sanctuaries-header">
        <h2 class="sanctuaries-title">Sanctuaries</h2>
        <p class="sanctuaries-subtitle">
            Each villa possesses a unique soul, crafted from<br>
            reclaimed teak and designed to frame the forest.
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

            {{-- Card 1: The Teak Nest --}}
            <div class="sanctuary-card">
                <div class="card-image-wrapper">
                    <img src="{{ asset('images/villas/teak-nest.png') }}" alt="The Teak Nest" class="card-image">
                </div>
                <div class="card-body">
                    <div class="card-top-row">
                        <h3 class="card-title">The Teak Nest</h3>
                        <div class="card-price">IDR 3.5M<span class="price-per">/night</span></div>
                    </div>
                    <p class="card-desc">
                        Elevated among the canopy, this intimate space features 100-year-old reclaimed teak and a private terrace overlooking the...
                    </p>
                    <div class="card-footer">
                        <div class="card-amenities">
                            {{-- Wifi --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="currentColor"/></svg>
                            {{-- Coffee --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="6" y1="2" x2="6" y2="4"/><line x1="10" y1="2" x2="10" y2="4"/><line x1="14" y1="2" x2="14" y2="4"/></svg>
                            {{-- Hiking/Nature --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m3 17 4-8 4 4 2.5-5L17 17"/><path d="M21 17H3"/></svg>
                        </div>
                        <a href="#" class="card-reserve">RESERVE</a>
                    </div>
                </div>
            </div>

            {{-- Card 2: Jasmine Pavilion --}}
            <div class="sanctuary-card">
                <div class="card-image-wrapper">
                    <span class="card-badge">Male Only</span>
                    <img src="{{ asset('images/villas/jasmine-pavilion.png') }}" alt="Jasmine Pavilion" class="card-image">
                </div>
                <div class="card-body">
                    <div class="card-top-row">
                        <h3 class="card-title">Jasmine Pavilion</h3>
                        <div class="card-price">IDR 5.2M<span class="price-per">/night</span></div>
                    </div>
                    <p class="card-desc">
                        Surrounded by our aromatic gardens, featuring a private plunge pool and a semi-outdoor stone bathtub under the stars.
                    </p>
                    <div class="card-footer">
                        <div class="card-amenities">
                            {{-- Wifi --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="currentColor"/></svg>
                            {{-- Pool --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12h20"/><path d="M2 12c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/><path d="M2 18c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/><path d="M6 6v3"/><path d="M18 6v3"/><path d="M9 3h6"/></svg>
                            {{-- Bathtub --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 6 6.5 3.5a1.5 1.5 0 0 0-1-.5C4.683 3 4 3.683 4 4.5V17a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/><line x1="10" y1="10" x2="8" y2="12"/><line x1="14" y1="10" x2="12" y2="12"/><line x1="18" y1="10" x2="16" y2="12"/></svg>
                        </div>
                        <a href="#" class="card-reserve">RESERVE</a>
                    </div>
                </div>
            </div>

            {{-- Card 3: The Heritage House --}}
            <div class="sanctuary-card">
                <div class="card-image-wrapper">
                    <img src="{{ asset('images/villas/heritage-house.png') }}" alt="The Heritage House" class="card-image">
                </div>
                <div class="card-body">
                    <div class="card-top-row">
                        <h3 class="card-title">The Heritage House</h3>
                        <div class="card-price">IDR 7.8M<span class="price-per">/night</span></div>
                    </div>
                    <p class="card-desc">
                        A meticulously restored traditional Joglo house for families seeking a deep cultural immersion...
                    </p>
                    <div class="card-footer">
                        <div class="card-amenities">
                            {{-- Wifi --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="currentColor"/></svg>
                            {{-- Family --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            {{-- Dining --}}
                            <svg class="amenity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg>
                        </div>
                        <a href="#" class="card-reserve">RESERVE</a>
                    </div>
                </div>
            </div>

            {{-- Tambahkan card lainnya di sini --}}

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
        color: #7A8C7A;
        stroke: #7A8C7A;
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