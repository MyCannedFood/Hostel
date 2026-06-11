{{-- resources/views/home/sections/hero.blade.php --}}

@php
    $heroData    ??= \App\Models\LandingPageSetting::DEFAULTS['hero'];
    $headline    = $heroData['headline']    ?? 'A Javanese Sanctuary, Woven by Nature';
    $subheadline = $heroData['subheadline'] ?? 'Immerse yourself in the deep tranquility of Nusantara culture, where architecture breathes with the forest.';
    $headlineId    = $heroData['headline_id']    ?? 'Surga Jawa, Terjalin oleh Alam';
    $subheadlineId = $heroData['subheadline_id'] ?? 'Benamkan diri Anda dalam ketenangan mendalam budaya Nusantara, di mana arsitektur menyatu dengan hutan.';
    $bgImageUrl  = !empty($heroData['bg_image'])
                   ? asset('storage/' . $heroData['bg_image'])
                   : asset('images/hero.png');
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap');

    :root {
        --green-dark:  #1a3d0a;
        --green-mid:   #4b9960;
        --green-light: #b8d9a0;
        --white-soft:  #f6f6f1;
        --terracotta:  #d9864a;
    }

    #home-hero {
        position: relative;
        width: 100vw;
        margin-left:  calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        margin-top: 0 !important;
        margin-bottom: 0;
        padding: 0 !important;
        height: calc(100vh - 64px);
        min-height: 540px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    #home-hero .hero-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center 30%;
        transform: scale(1.04);
        animation: heroZoom 14s ease-out forwards;
    }

    @keyframes heroZoom {
        from { transform: scale(1.04); }
        to   { transform: scale(1.00); }
    }

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
    }
</style>

<section id="home-hero">
    <div class="hero-bg" style="background-image: url('{{ $bgImageUrl }}');"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        {{-- Headline: data-en dari DB, data-id dari DB (atau fallback hardcode) --}}
        <h1 id="hero-headline"
            data-en="{{ $headline }}"
            data-id="{{ $headlineId }}">
            {!! nl2br(e($headline)) !!}
        </h1>

        <p id="hero-subheadline"
           data-en="{{ $subheadline }}"
           data-id="{{ $subheadlineId }}">
            {{ $subheadline }}
        </p>
    </div>

    <div class="hero-booking">
        <div class="hero-booking-field">
            <label for="hero-checkin"
                   data-en="Check-In" data-id="Tgl Masuk">Check-In</label>
            <input type="date" id="hero-checkin" name="checkin"
                   value="{{ date('Y-m-d', strtotime('+1 day')) }}">
        </div>

        <div class="hero-booking-field">
            <label for="hero-checkout"
                   data-en="Check-Out" data-id="Tgl Keluar">Check-Out</label>
            <input type="date" id="hero-checkout" name="checkout"
                   value="{{ date('Y-m-d', strtotime('+6 days')) }}">
        </div>

        <div class="hero-booking-field" style="border-right:none;">
            <label for="hero-guests"
                   data-en="Guests" data-id="Tamu">Guests</label>
            <select id="hero-guests" name="guests">
                {{-- Teks option ditranslate via JS --}}
                <option value="1a0c"
                        data-en="1 Male Adult, 0 Children"
                        data-id="1 Dewasa Pria, 0 Anak" selected>
                    1 Male Adult, 0 Children
                </option>
                <option value="1f0c"
                        data-en="1 Female Adult, 0 Children"
                        data-id="1 Dewasa Wanita, 0 Anak">
                    1 Female Adult, 0 Children
                </option>
                <option value="2a1c"
                        data-en="2 Male Adults, 1 Child"
                        data-id="2 Dewasa Pria, 1 Anak">
                    2 Male Adults, 1 Child
                </option>
                <option value="2f1c"
                        data-en="2 Female Adults, 1 Child"
                        data-id="2 Dewasa Wanita, 1 Anak">
                    2 Female Adults, 1 Child
                </option>
                <option value="2a2c"
                        data-en="2 Male Adults, 2 Children"
                        data-id="2 Dewasa Pria, 2 Anak">
                    2 Male Adults, 2 Children
                </option>
                <option value="2f2c"
                        data-en="2 Female Adults, 2 Children"
                        data-id="2 Dewasa Wanita, 2 Anak">
                    2 Female Adults, 2 Children
                </option>
            </select>
        </div>

        <div class="hero-booking-btn-wrap">
            <button class="hero-booking-btn" type="button"
                    data-en="Check Availability" data-id="Cek Ketersediaan"
                    onclick="window.location.href='/calendar'">
                Check Availability
            </button>
        </div>
    </div>
</section>

<script>
// Hero: re-apply terjemahan setiap kali bahasa berubah dari navbar
// (AlasLang sudah di-load oleh navbar sebelum section ini)
document.addEventListener('alas:langchange', function (e) {
    applyHeroLang(e.detail.lang);
});

function applyHeroLang(lang) {
    // Headline & subheadline pakai textContent biasa
    // (data-en / data-id sudah di-set di atribut elemen)
    var h1 = document.getElementById('hero-headline');
    var p  = document.getElementById('hero-subheadline');
    if (h1) h1.textContent = lang === 'id' ? h1.dataset.id : h1.dataset.en;
    if (p)  p.textContent  = lang === 'id' ? p.dataset.id  : p.dataset.en;

    // Option select tidak ditangani AlasLang (karena textContent-nya bukan teks murni)
    document.querySelectorAll('#hero-guests option').forEach(function (opt) {
        opt.textContent = lang === 'id' ? opt.dataset.id : opt.dataset.en;
    });
}

// Jalankan saat halaman load sesuai bahasa tersimpan
(function () {
    var lang = (window.AlasLang ? window.AlasLang.current() : null)
               || localStorage.getItem('alas_lang')
               || 'en';
    applyHeroLang(lang);
})();
</script>