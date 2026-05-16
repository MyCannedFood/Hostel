{{-- Home - Hero --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap');

    :root {
        --green-dark:   #1a3d0a;
        --green-mid:    #4b9960;
        --green-light:  #b8d9a0;
        --white-soft:   #f6f6f1;
        --terracotta:   #d9864a;
    }

    /* ── Hero wrapper — true full-bleed, flush to navbar ── */
    #home-hero {
        position: relative;
        width: 100vw;
        /* Breakout dari parent container apapun */
        margin-left:  calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        margin-top: 0 !important;
        margin-bottom: 0;
        padding: 0 !important;
        /* Tinggi = full viewport dikurangi tinggi navbar (64px) */
        height: calc(100vh - 64px);
        min-height: 540px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    /* Background image */
    #home-hero .hero-bg {
        position: absolute;
        inset: 0;
        background-image: url("{{ asset('images/hero.png') }}");
        background-size: cover;
        background-position: center 30%;
        transform: scale(1.04);
        animation: heroZoom 14s ease-out forwards;
    }

    @keyframes heroZoom {
        from { transform: scale(1.04); }
        to   { transform: scale(1.00); }
    }

    /* Dark gradient overlay */
    #home-hero .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(10,22,8,0.10) 0%,
            rgba(10,22,8,0.38) 45%,
            rgba(10,22,8,0.65) 100%
        );
    }

    /* Content */
    #home-hero .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 0 20px;
        animation: heroFadeUp 1.1s cubic-bezier(.22,.8,.36,1) both;
        animation-delay: 0.2s;
    }

    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    #home-hero .hero-content h1 {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 300;
        font-size: clamp(42px, 6.5vw, 80px);
        line-height: 1.10;
        color: #fff;
        margin: 0 0 18px;
        letter-spacing: -0.01em;
    }

    #home-hero .hero-content p {
        font-family: 'Jost', sans-serif;
        font-weight: 300;
        font-size: clamp(14px, 1.4vw, 16px);
        color: rgba(255,255,255,0.82);
        max-width: 420px;
        margin: 0 auto;
        line-height: 1.65;
        letter-spacing: 0.01em;
    }

    /* ── Booking bar ── */
    #home-hero .hero-booking {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        width: min(820px, 92vw);
        background: #fff;
        border-radius: 8px 8px 0 0;
        box-shadow: 0 -6px 40px rgba(0,0,0,0.12);
        display: flex;
        align-items: stretch;
        animation: bookingSlideUp 0.9s cubic-bezier(.22,.8,.36,1) both;
        animation-delay: 0.55s;
    }

    @keyframes bookingSlideUp {
        from { opacity: 0; transform: translateX(-50%) translateY(20px); }
        to   { opacity: 1; transform: translateX(-50%) translateY(0); }
    }

    .hero-booking-field {
        flex: 1;
        padding: 16px 20px 14px;
        border-right: 1px solid #eee;
        display: flex;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        transition: background 0.15s;
    }
    .hero-booking-field:hover { background: #fafaf7; }

    .hero-booking-field label {
        font-family: 'Jost', sans-serif;
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #999;
        cursor: pointer;
    }

    .hero-booking-field input,
    .hero-booking-field select {
        border: none;
        outline: none;
        background: transparent;
        font-family: 'Jost', sans-serif;
        font-size: 14px;
        font-weight: 400;
        color: #1a1a1a;
        cursor: pointer;
        width: 100%;
        padding: 0;
        appearance: none;
        -webkit-appearance: none;
    }

    .hero-booking-field input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0.35;
        cursor: pointer;
    }

    .hero-booking-btn-wrap {
        display: flex;
        align-items: center;
        padding: 10px 14px 10px 10px;
        flex-shrink: 0;
    }

    .hero-booking-btn {
        background: var(--green-dark);
        color: #fff;
        border: none;
        border-radius: 5px;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.05em;
        padding: 14px 26px;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s, transform 0.15s;
    }
    .hero-booking-btn:hover {
        background: #254f0e;
        transform: translateY(-1px);
    }

    /* ── WhatsApp floating button (removed, use global navbar component) ── */
    /* .hero-wa-btn { ... } */

    /* ── Mobile ── */
    @media (max-width: 640px) {
        #home-hero {
            height: calc(100svh - 64px);
            min-height: 480px;
        }

        #home-hero .hero-booking {
            width: 100%;
            border-radius: 0;
            flex-direction: column;
        }

        .hero-booking-field {
            border-right: none;
            border-bottom: 1px solid #eee;
            padding: 12px 16px;
        }

        .hero-booking-btn-wrap {
            padding: 12px 16px 16px;
        }

        .hero-booking-btn {
            width: 100%;
            padding: 14px;
            font-size: 14px;
        }

        .hero-wa-btn {
            bottom: 20px;
            right: 20px;
            width: 48px;
            height: 48px;
        }
    }
</style>

<section id="home-hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>A Javanese Sanctuary,<br>Woven by Nature</h1>
        <p>Immerse yourself in the deep tranquility of Nusantara culture, where architecture breathes with the forest.</p>
    </div>

    <div class="hero-booking">
        <div class="hero-booking-field">
            <label for="hero-checkin">Check-In</label>
            <input type="date" id="hero-checkin" name="checkin" value="2026-10-12">
        </div>

        <div class="hero-booking-field">
            <label for="hero-checkout">Check-Out</label>
            <input type="date" id="hero-checkout" name="checkout" value="2026-10-15">
        </div>

        <div class="hero-booking-field" style="border-right:none;">
            <label for="hero-guests">Guests</label>
            <select id="hero-guests" name="guests">
                <option value="2a0c">2 Adults, 0 Children</option>
                <option value="2a1c">2 Adults, 1 Child</option>
                <option value="2a2c">2 Adults, 2 Children</option>
                <option value="1a0c">1 Adult, 0 Children</option>
            </select>
        </div>

        <div class="hero-booking-btn-wrap">
            <button class="hero-booking-btn" type="button"
                onclick="window.location.href='/rooms'">
                Check Availability
            </button>
        </div>
    </div>
</section>
</a>