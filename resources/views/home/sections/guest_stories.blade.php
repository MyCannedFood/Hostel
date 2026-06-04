{{-- resources/views/home/sections/guest_stories.blade.php --}}
{{-- Data: $guestStoriesData, $awardsData dari PageController --}}

@php
    // ── Guest Stories ──
    $guestStoriesData ??= \App\Models\LandingPageSetting::DEFAULTS['guest_stories'];
    $guestStoriesData   = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['guest_stories'],
        $guestStoriesData
    );
    $sectionTitle = $guestStoriesData['title']   ?? 'Guest Stories';
    $stories      = $guestStoriesData['stories'] ?? [];

    if (count($stories) === 0) {
        $stories = \App\Models\LandingPageSetting::DEFAULTS['guest_stories']['stories'];
    }

    $defaultStoryImages = [
        'images/guest.png',
        'images/guest-2.jpg',
        'images/guest-3.jpg',
    ];

    // ── Awards / Badges ──
    $awardsData ??= \App\Models\LandingPageSetting::DEFAULTS['awards'];
    $awardsData   = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['awards'],
        $awardsData
    );

    // Ambil max 4 yang is_visible = true
    $visibleAwards = collect($awardsData['items'] ?? [])
        ->filter(fn($a) => !empty($a['is_visible']))
        ->take(4)
        ->values();

    // Default badge fallbacks (urutan sama dengan DEFAULTS)
    $defaultBadgeIcons = [
        'images/badge-earthcheck.png',
        'images/badge-tripadvisor.png',
        'images/badge-heritage.png',
        'images/badge-zerowaste.png',
    ];

    // Kalau DB kosong, pakai hardcoded defaults
    if ($visibleAwards->isEmpty()) {
        $visibleAwards = collect([
            ['icon_path' => null, 'title' => 'EarthCheck',        'sub' => 'Gold Certified'],
            ['icon_path' => null, 'title' => "Traveler's Choice", 'sub' => 'TripAdvisor 2025'],
            ['icon_path' => null, 'title' => 'Local Heritage',    'sub' => 'Preservation'],
            ['icon_path' => null, 'title' => 'Zero Waste',        'sub' => 'Initiative'],
        ]);
    }
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap');

    #home-stories {
        background: #ffffff;
        padding: 80px 0 100px;
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        box-sizing: border-box;
    }

    .stories-slider-wrap {
        max-width: 1100px;
        margin: 0 auto 72px;
        padding: 0 72px;
        box-sizing: border-box;
    }

    .stories-slider {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(26,61,10,0.08);
        min-height: 480px;
    }

    .stories-slide         { display: none; }
    .stories-slide.active  { display: grid; grid-template-columns: 1fr 1fr; width: 100%; }

    .stories-photo { width: 100%; min-height: 480px; overflow: hidden; }
    .stories-photo img { width: 100%; height: 100%; object-fit: cover; object-position: center top; display: block; }

    .stories-content {
        background: rgba(246,246,241,0.30);
        padding: 60px 56px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .stories-eyebrow {
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #7d9d75;
        margin: 0 0 20px;
    }

    .stories-quote-mark {
        font-family: 'Cormorant Garamond', serif;
        font-size: 80px;
        line-height: 0.6;
        color: #b8d9a0;
        display: block;
        margin-bottom: 20px;
    }

    .stories-quote {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-weight: 300;
        font-size: clamp(22px, 2.2vw, 30px);
        line-height: 1.55;
        color: #1a3d0a;
        margin: 0 0 36px;
    }

    .stories-author-name   { font-family: 'Jost', sans-serif; font-size: 13.5px; font-weight: 600; color: #1a3d0a; margin: 0 0 5px; }
    .stories-author-origin { font-family: 'Jost', sans-serif; font-size: 12px; font-weight: 300; color: #888; margin: 0; }

    .stories-dots-wrap {
        max-width: 1100px;
        margin: 0 auto 72px;
        padding: 0 72px;
        box-sizing: border-box;
    }

    .stories-dots { display: flex; align-items: center; gap: 10px; padding: 20px 56px 0; }

    .stories-dot {
        width: 28px; height: 3px;
        background: #b8d9a0; border: none; padding: 0;
        cursor: pointer;
        transition: background 0.3s ease, width 0.3s ease;
    }
    .stories-dot.active { background: #1a3d0a; width: 36px; }

    .stories-badges {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 72px;
        box-sizing: border-box;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stories-badge-item {
        border: 1px solid rgba(26,61,10,0.10);
        background: rgba(246,246,241,0.50);
        padding: 20px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .stories-badge-item img { width: 36px; height: 36px; object-fit: contain; display: block; }
    .stories-badge-label { font-family: 'Jost', sans-serif; font-size: 13px; font-weight: 600; color: #1a3d0a; text-align: center; margin: 0; }
    .stories-badge-sub   { font-family: 'Jost', sans-serif; font-size: 11px; font-weight: 300; color: #888; text-align: center; margin: 0; }

    @media (max-width: 768px) {
        #home-stories        { padding: 60px 0 72px; }
        .stories-slider-wrap { padding: 0 20px; margin-bottom: 0; }
        .stories-dots-wrap   { padding: 0 20px; margin-bottom: 48px; }
        .stories-dots        { padding: 16px 20px 0; }
        .stories-slider      { min-height: unset; }
        .stories-slide.active{ grid-template-columns: 1fr; }
        .stories-photo       { min-height: 280px; height: 280px; }
        .stories-content     { padding: 32px 28px 28px; }
        .stories-quote       { font-size: 20px; }
        .stories-badges      { padding: 0 20px; grid-template-columns: repeat(2,1fr); gap: 12px; }
        .stories-badge-item  { padding: 16px 14px; }
    }
</style>

<section id="home-stories">

    {{-- ── SLIDER ── --}}
    <div class="stories-slider-wrap">
        <div class="stories-slider" id="storiesSlider">
            @foreach($stories as $i => $story)
            <div class="stories-slide {{ $loop->first ? 'active' : '' }}">
                <div class="stories-photo">
                    @if(!empty($story['image_path']))
                        <img src="{{ asset('storage/' . $story['image_path']) }}"
                             alt="{{ $story['name'] ?? '' }}" loading="lazy">
                    @else
                        <img src="{{ asset($defaultStoryImages[$i] ?? 'images/guest.png') }}"
                             alt="{{ $story['name'] ?? '' }}" loading="lazy">
                    @endif
                </div>
                <div class="stories-content">
                    <p class="stories-eyebrow">{{ $sectionTitle }}</p>
                    <span class="stories-quote-mark">"</span>
                    <p class="stories-quote">"{{ $story['quote'] ?? '' }}"</p>
                    <p class="stories-author-name">— {{ $story['name'] ?? '' }}</p>
                    <p class="stories-author-origin">{{ $story['origin'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── DOTS ── --}}
    <div class="stories-dots-wrap">
        <div class="stories-dots" id="storiesDots"></div>
    </div>

    {{-- ── BADGES (dari Awards & Recognition DB) ── --}}
    <div class="stories-badges">
        @foreach($visibleAwards as $j => $award)
        <div class="stories-badge-item">
            @if(!empty($award['icon_path']))
                <img src="{{ asset('storage/' . $award['icon_path']) }}"
                     alt="{{ $award['title'] ?? '' }}">
            @else
                <img src="{{ asset($defaultBadgeIcons[$j] ?? 'images/badge-earthcheck.png') }}"
                     alt="{{ $award['title'] ?? '' }}">
            @endif
            <p class="stories-badge-label">{{ $award['title'] ?? '' }}</p>
            @if(!empty($award['sub']))
                <p class="stories-badge-sub">{{ $award['sub'] }}</p>
            @endif
        </div>
        @endforeach
    </div>

</section>

<script>
(function () {
    const slides   = Array.from(document.querySelectorAll('#storiesSlider .stories-slide'));
    const dotsWrap = document.getElementById('storiesDots');
    const TOTAL    = slides.length;
    const INTERVAL = 5000;
    let current = 0, timer = null;

    if (TOTAL === 0) return;

    slides.forEach(function(_, i) {
        var btn = document.createElement('button');
        btn.className = 'stories-dot' + (i === 0 ? ' active' : '');
        btn.setAttribute('aria-label', 'Slide ' + (i + 1));
        btn.addEventListener('click', function() { goTo(i); startTimer(); });
        dotsWrap.appendChild(btn);
    });

    var dots = Array.from(dotsWrap.querySelectorAll('.stories-dot'));

    function goTo(index) {
        slides[current].classList.remove('active'); dots[current].classList.remove('active');
        current = (index + TOTAL) % TOTAL;
        slides[current].classList.add('active'); dots[current].classList.add('active');
    }

    function startTimer() {
        if (timer) clearInterval(timer);
        if (TOTAL > 1) timer = setInterval(function() { goTo(current + 1); }, INTERVAL);
    }

    startTimer();
    var slider = document.getElementById('storiesSlider');
    slider.addEventListener('mouseenter', function() { clearInterval(timer); timer = null; });
    slider.addEventListener('mouseleave', startTimer);
})();
</script>