{{-- Home - Guest Stories --}}

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

    /* ── SLIDER WRAPPER ── */
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

    .stories-slide {
        display: none;
    }
    .stories-slide.active {
        display: grid;
        grid-template-columns: 1fr 1fr;
        width: 100%;
    }

    /* ── PHOTO ── */
    .stories-photo {
        width: 100%;
        min-height: 480px;
        overflow: hidden;
    }
    .stories-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        display: block;
    }

    /* ── CONTENT ── */
    .stories-content {
        background: rgba(246, 246, 241, 0.30);
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

    .stories-author-name {
        font-family: 'Jost', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        color: #1a3d0a;
        margin: 0 0 5px;
    }

    .stories-author-origin {
        font-family: 'Jost', sans-serif;
        font-size: 12px;
        font-weight: 300;
        color: #888;
        margin: 0;
    }

    /* ── DOTS — di luar slide agar tidak ikut hide ── */
    .stories-dots-wrap {
        max-width: 1100px;
        margin: 0 auto 72px;
        padding: 0 72px;
        box-sizing: border-box;
    }

    .stories-dots {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 20px 56px 0;
    }

    .stories-dot {
        width: 28px;
        height: 3px;
        background: #b8d9a0;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: background 0.3s ease, width 0.3s ease;
    }
    .stories-dot.active {
        background: #1a3d0a;
        width: 36px;
    }

    /* ── BADGES ── */
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
        background: rgba(246, 246, 241, 0.50);
        padding: 20px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .stories-badge-item img {
        width: 36px;
        height: 36px;
        object-fit: contain;
        display: block;
    }

    .stories-badge-label {
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: #1a3d0a;
        text-align: center;
        margin: 0;
    }

    .stories-badge-sub {
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 300;
        color: #888;
        text-align: center;
        margin: 0;
    }

    /* ── Mobile ── */
    @media (max-width: 768px) {
        #home-stories { padding: 60px 0 72px; }

        .stories-slider-wrap {
            padding: 0 20px;
            margin-bottom: 0;
        }

        .stories-dots-wrap {
            padding: 0 20px;
            margin-bottom: 48px;
        }

        .stories-dots {
            padding: 16px 20px 0;
        }

        .stories-slider { min-height: unset; }

        .stories-slide.active {
            grid-template-columns: 1fr;
        }

        .stories-photo {
            min-height: 280px;
            height: 280px;
        }

        .stories-content {
            padding: 32px 28px 28px;
        }

        .stories-quote { font-size: 20px; }

        .stories-badges {
            padding: 0 20px;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stories-badge-item { padding: 16px 14px; }
    }
</style>

<section id="home-stories">

    {{-- SLIDER --}}
    <div class="stories-slider-wrap">
        <div class="stories-slider" id="storiesSlider">

            {{-- Slide 1 --}}
            <div class="stories-slide active">
                <div class="stories-photo">
                    <img src="{{ asset('images/guest-edward-claire.jpg') }}" alt="Edward & Claire">
                </div>
                <div class="stories-content">
                    <p class="stories-eyebrow">Guest Stories</p>
                    <span class="stories-quote-mark">"</span>
                    <p class="stories-quote">"A profound experience. The way the villa integrates with the jungle made us feel like we were sleeping in the canopy. The scent of jasmine in the morning is something I will never forget."</p>
                    <p class="stories-author-name">— Edward & Claire</p>
                    <p class="stories-author-origin">United Kingdom</p>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="stories-slide">
                <div class="stories-photo">
                    <img src="{{ asset('images/guest-2.jpg') }}" alt="Hiroshi & Yuki">
                </div>
                <div class="stories-content">
                    <p class="stories-eyebrow">Guest Stories</p>
                    <span class="stories-quote-mark">"</span>
                    <p class="stories-quote">"Waking up to birdsong and the rustling of leaves, completely surrounded by green. AlasAre gave us a new definition of what luxury truly means."</p>
                    <p class="stories-author-name">— Hiroshi & Yuki</p>
                    <p class="stories-author-origin">Japan</p>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div class="stories-slide">
                <div class="stories-photo">
                    <img src="{{ asset('images/guest-3.jpg') }}" alt="Sophie & Marc">
                </div>
                <div class="stories-content">
                    <p class="stories-eyebrow">Guest Stories</p>
                    <span class="stories-quote-mark">"</span>
                    <p class="stories-quote">"The most restorative stay we have ever had. Every detail, from the herbs in our meals to the sound of rain on the jungle canopy, was deeply intentional."</p>
                    <p class="stories-author-name">— Sophie & Marc</p>
                    <p class="stories-author-origin">France</p>
                </div>
            </div>

        </div>
    </div>

    {{-- DOTS — di luar slider agar tidak ikut tersembunyi --}}
    <div class="stories-dots-wrap">
        <div class="stories-dots" id="storiesDots"></div>
    </div>

    {{-- BADGES --}}
    <div class="stories-badges">
        <div class="stories-badge-item">
            <img src="{{ asset('images/badge-earthcheck.png') }}" alt="EarthCheck">
            <p class="stories-badge-label">EarthCheck</p>
            <p class="stories-badge-sub">Gold Certified</p>
        </div>
        <div class="stories-badge-item">
            <img src="{{ asset('images/badge-tripadvisor.png') }}" alt="Traveler's Choice">
            <p class="stories-badge-label">Traveler's Choice</p>
            <p class="stories-badge-sub">TripAdvisor 2025</p>
        </div>
        <div class="stories-badge-item">
            <img src="{{ asset('images/badge-heritage.png') }}" alt="Local Heritage">
            <p class="stories-badge-label">Local Heritage</p>
            <p class="stories-badge-sub">Preservation</p>
        </div>
        <div class="stories-badge-item">
            <img src="{{ asset('images/badge-zerowaste.png') }}" alt="Zero Waste">
            <p class="stories-badge-label">Zero Waste</p>
            <p class="stories-badge-sub">Initiative</p>
        </div>
    </div>

</section>

<script>
(function () {
    const slides   = Array.from(document.querySelectorAll('#storiesSlider .stories-slide'));
    const dotsWrap = document.getElementById('storiesDots');
    const TOTAL    = slides.length;
    const INTERVAL = 5000;
    let current    = 0;
    let timer      = null;

    /* Build dots */
    slides.forEach(function(_, i) {
        var btn = document.createElement('button');
        btn.className = 'stories-dot' + (i === 0 ? ' active' : '');
        btn.setAttribute('aria-label', 'Slide ' + (i + 1));
        btn.addEventListener('click', function() {
            goTo(i);
            startTimer();
        });
        dotsWrap.appendChild(btn);
    });

    var dots = Array.from(dotsWrap.querySelectorAll('.stories-dot'));

    function goTo(index) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (index + TOTAL) % TOTAL;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function startTimer() {
        if (timer) clearInterval(timer);
        timer = setInterval(function() {
            goTo(current + 1);
        }, INTERVAL);
    }

    /* Init */
    startTimer();

    /* Pause on hover */
    var slider = document.getElementById('storiesSlider');
    slider.addEventListener('mouseenter', function() { clearInterval(timer); timer = null; });
    slider.addEventListener('mouseleave', startTimer);
})();
</script>