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

    /* ── WhatsApp floating button ── */
    .hero-wa-btn {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 999;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #25d366;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(37,211,102,0.40);
        text-decoration: none;
        transition: transform 0.2s, box-shadow 0.2s;
        animation: waPop 0.5s cubic-bezier(.34,1.56,.64,1) both;
        animation-delay: 1s;
    }
    @keyframes waPop {
        from { opacity: 0; transform: scale(0.5); }
        to   { opacity: 1; transform: scale(1); }
    }
    .hero-wa-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 28px rgba(37,211,102,0.50);
    }
    .hero-wa-btn svg {
        width: 28px;
        height: 28px;
        fill: #fff;
    }

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

{{-- WhatsApp floating button (fixed, muncul di semua halaman) --}}
<a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20menanyakan%20informasi%20villa%20AlaSare"
   class="hero-wa-btn"
   target="_blank"
   rel="noopener noreferrer"
   title="Chat via WhatsApp">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.558 4.117 1.532 5.847L.054 23.447a.5.5 0 00.499.553h.056l5.765-1.512A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.894a9.877 9.877 0 01-5.031-1.378l-.36-.214-3.733.979.995-3.64-.235-.374A9.861 9.861 0 012.106 12C2.106 6.535 6.535 2.106 12 2.106S21.894 6.535 21.894 12 17.465 21.894 12 21.894z"/>
    </svg>
</a>