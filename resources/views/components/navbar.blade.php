{{-- resources/views/components/navbar.blade.php --}}

{{-- Preconnect Google Translate — percepat load widget --}}
<link rel="preconnect" href="https://translate.google.com">
<link rel="preconnect" href="https://translate.googleapis.com">
<link rel="dns-prefetch" href="https://translate.google.com">
<link rel="dns-prefetch" href="https://translate.googleapis.com">

@php
    $currentLang = request('lang', 'en');
@endphp

<style>
    /* ── Desktop nav links ── */
    .alas-nav-links {
        display: flex;
        align-items: center;
        gap: 28px;
    }

    .alas-nav-links a {
        text-decoration: none;
        font-family: 'Georgia', serif;
        font-size: 13px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #1a3d0a;
        padding-bottom: 3px;
        transition: opacity 0.2s, border-color 0.2s;
        border-bottom: 2px solid transparent;
    }

    .alas-nav-links a.active-nav {
        font-weight: 700;
        opacity: 1;
        border-bottom: 2px solid #1a3d0a;
    }

    .alas-nav-links a.inactive-nav {
        font-weight: 500;
        opacity: 0.65;
    }

    .alas-nav-links a.inactive-nav:hover {
        opacity: 1;
    }

    /* ── Desktop language switcher ── */
    .alas-lang-btn button {
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'Georgia', serif;
        font-size: 13px;
        letter-spacing: 0.08em;
        color: #1a3d0a;
        padding: 0;
    }

    .alas-lang-btn button.active-lang-nav {
        font-weight: 700;
        opacity: 1;
    }

    .alas-lang-btn button.inactive-lang-nav {
        font-weight: 500;
        opacity: 0.55;
        transition: opacity 0.2s;
    }

    .alas-lang-btn button.inactive-lang-nav:hover {
        opacity: 1;
    }

    /* ── Mobile hamburger ── */
    .alas-hamburger {
        display: none;
    }

    /* ── Mobile drawer ── */
    .alas-drawer {
        display: none;
        flex-direction: column;
        background: #f6f6f1;
        border-top: 1px solid rgba(26,61,10,0.10);
        padding: 20px 20px 24px;
        gap: 0;
    }

    .alas-drawer a {
        text-decoration: none;
        font-family: 'Georgia', serif;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.10em;
        text-transform: uppercase;
        color: #1a3d0a;
        padding: 13px 0;
        border-bottom: 1px solid rgba(26,61,10,0.08);
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .alas-drawer a.active-link {
        font-weight: 700;
        opacity: 1;
    }

    .alas-drawer .drawer-lang {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 13px 0;
        border-bottom: 1px solid rgba(26,61,10,0.08);
    }

    .alas-drawer .drawer-lang button {
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'Georgia', serif;
        font-size: 13px;
        letter-spacing: 0.08em;
        color: #1a3d0a;
        padding: 0;
        font-weight: 500;
        opacity: 0.55;
    }

    .alas-drawer .drawer-lang button.active-lang {
        font-weight: 700;
        opacity: 1;
    }

    .alas-drawer .drawer-lang span {
        color: #1a3d0a;
        opacity: 0.3;
        font-size: 13px;
    }

    .alas-drawer .drawer-book {
        margin-top: 16px;
        text-decoration: none;
        background: #d9864a;
        color: #fff !important;
        font-family: 'Georgia', serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 13px 0;
        border-radius: 4px;
        text-align: center;
        opacity: 1 !important;
        border: none !important;
        display: block;
    }

    @media (max-width: 768px) {
        .alas-nav-links {
            display: none !important;
        }

        .alas-lang-btn {
            display: none !important;
        }

        .alas-book-btn {
            display: none !important;
        }

        .alas-hamburger {
            display: flex !important;
        }

        .alas-drawer.open {
            display: flex;
        }
    }

    /* ── Sembunyikan toolbar Google Translate ── */
    .goog-te-banner-frame,
    .skiptranslate {
        display: none !important;
    }

    body {
        top: 0 !important;
    }
</style>

<nav style="
    width: 100%;
    background: #f6f6f1;
    box-sizing: border-box;
    border-bottom: 1px solid rgba(26,61,10,0.08);
    position: relative;
    z-index: 100;
">

    {{-- Main Bar --}}
    <div style="
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 64px;
        padding: 0 32px;
        max-width: 1280px;
        margin: 0 auto;
        box-sizing: border-box;
    ">

        {{-- Left Side --}}
        <div style="display:flex; align-items:center; gap:36px;">

            {{-- Logo --}}
            <a href="/"
               style="text-decoration:none; display:flex; align-items:center; gap:8px; flex-shrink:0;">

                <img src="{{ asset('images/logo_only.png') }}"
                     alt="AlaSare Logo"
                     style="
                        width:26px;
                        height:26px;
                        border-radius:50%;
                        object-fit:cover;
                     ">

                <span style="
                    font-family: 'Georgia', 'Times New Roman', serif;
                    font-size: 16px;
                    font-weight: 700;
                    color: #1a3d0a;
                    letter-spacing: 0.01em;
                    line-height: 1;
                    display: inline-flex;
                    align-items: center;
                ">
                    AlaSare
                </span>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="alas-nav-links">

                <a href="/"
                   class="{{ request()->is('/') ? 'active-nav' : 'inactive-nav' }}">
                    Home
                </a>

                <a href="/rooms"
                   class="{{ request()->is('rooms') ? 'active-nav' : 'inactive-nav' }}">
                    Villas
                </a>

                <a href="/gallery"
                   class="{{ request()->is('gallery') ? 'active-nav' : 'inactive-nav' }}">
                    Gallery
                </a>

                <a href="/experience"
                   class="{{ request()->is('experience') ? 'active-nav' : 'inactive-nav' }}">
                    Experiences
                </a>

                <a href="/journal"
                   class="{{ request()->is('journal') ? 'active-nav' : 'inactive-nav' }}">
                    Journal
                </a>

                <a href="/guest-story"
                   class="{{ request()->is('guest-story') ? 'active-nav' : 'inactive-nav' }}">
                    Guest Story
                </a>

                <a href="/contact"
                   class="{{ request()->is('contact') ? 'active-nav' : 'inactive-nav' }}">
                    Contact
                </a>

            </div>
        </div>

        {{-- Right Side --}}
        <div style="display:flex; align-items:center; gap:16px; flex-shrink:0;">

            {{-- Language Switcher (Desktop) --}}
            <div class="alas-lang-btn" style="display:flex; align-items:center; gap:6px;">

                <button id="btnLangID"
                        onclick="setLang('id')"
                        class="inactive-lang-nav">
                    ID
                </button>

                <span style="color:#1a3d0a; opacity:0.3; font-size:13px; line-height:1;">|</span>

                <button id="btnLangEN"
                        onclick="setLang('en')"
                        class="active-lang-nav">
                    EN
                </button>

            </div>

            {{-- Book Now --}}
            <a href="/calendar"
               class="alas-book-btn"
               style="
                    text-decoration: none;
                    background: #d9864a;
                    color: #fff;
                    font-family: 'Georgia', serif;
                    font-size: 13px;
                    font-weight: 700;
                    letter-spacing: 0.12em;
                    text-transform: uppercase;
                    padding: 10px 22px;
                    border-radius: 4px;
                    transition: background 0.2s, transform 0.15s;
                    display: inline-block;
                    white-space: nowrap;
               "
               onmouseover="this.style.background='#c4733a'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='#d9864a'; this.style.transform='translateY(0)'">
                Book Now
            </a>

            {{-- Hamburger --}}
            <button class="alas-hamburger"
                    id="alasHamburger"
                    type="button"
                    aria-label="Open menu"
                    style="
                        border: none;
                        background: transparent;
                        cursor: pointer;
                        padding: 6px;
                        flex-direction: column;
                        gap: 5px;
                        align-items: center;
                        justify-content: center;
                    ">

                <span id="alasBar1"
                      style="display:block; width:22px; height:2px; background:#1a3d0a; border-radius:2px; transition: transform 0.25s, opacity 0.25s;">
                </span>
                <span id="alasBar2"
                      style="display:block; width:22px; height:2px; background:#1a3d0a; border-radius:2px; transition: transform 0.25s, opacity 0.25s;">
                </span>
                <span id="alasBar3"
                      style="display:block; width:22px; height:2px; background:#1a3d0a; border-radius:2px; transition: transform 0.25s, opacity 0.25s;">
                </span>
            </button>
        </div>
    </div>

    {{-- Google Translate widget — hidden, hanya dipakai sebagai engine terjemahan --}}
    <div id="google_translate_element" style="display:none; visibility:hidden; height:0; overflow:hidden; position:absolute;"></div>

    {{-- Mobile Drawer --}}
    <div class="alas-drawer" id="alasDrawer">

        <a href="/" class="{{ request()->is('/') ? 'active-link' : '' }}">Home</a>
        <a href="/rooms" class="{{ request()->is('rooms') ? 'active-link' : '' }}">Villas</a>
        <a href="/gallery" class="{{ request()->is('gallery') ? 'active-link' : '' }}">Gallery</a>
        <a href="/experience" class="{{ request()->is('experience') ? 'active-link' : '' }}">Experiences</a>
        <a href="/journal" class="{{ request()->is('journal') ? 'active-link' : '' }}">Journal</a>
        <a href="/guest-story" class="{{ request()->is('guest-story') ? 'active-link' : '' }}">Guest Story</a>
        <a href="/contact" class="{{ request()->is('contact') ? 'active-link' : '' }}">Contact</a>

        {{-- Mobile Language --}}
        <div class="drawer-lang">
            <button id="btnLangID_mobile" onclick="setLang('id')" class="">ID</button>
            <span>|</span>
            <button id="btnLangEN_mobile" onclick="setLang('en')" class="active-lang">EN</button>
        </div>

        <a href="/calendar" class="drawer-book">Book Now</a>
    </div>

    {{-- Global WhatsApp floating button --}}
    @include('components.whatsapp_floating')
</nav>

<script>
(function () {

    // ── Helpers cookie ────────────────────────────────────────────────────────
    function setCookie(name, value, days) {
        var expires = '';
        if (days) {
            var d = new Date();
            d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
            expires = '; expires=' + d.toUTCString();
        }
        document.cookie = name + '=' + value + expires + '; path=/';
        document.cookie = name + '=' + value + expires + '; path=/; domain=' + location.hostname;
    }

    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }

    // ── State bahasa aktif ────────────────────────────────────────────────────
    // Prioritas: cookie googtrans > localStorage > default 'en'
    var gtCookie = getCookie('googtrans');
    var currentLang;
    if (gtCookie && gtCookie.indexOf('/id') !== -1) {
        currentLang = 'id';
    } else {
        currentLang = localStorage.getItem('alasLang') || 'en';
    }

    // ── Update tampilan tombol ────────────────────────────────────────────────
    function updateButtons(lang) {
        var btnID  = document.getElementById('btnLangID');
        var btnEN  = document.getElementById('btnLangEN');
        var btnIDm = document.getElementById('btnLangID_mobile');
        var btnENm = document.getElementById('btnLangEN_mobile');

        if (btnID && btnEN) {
            btnID.className = (lang === 'id') ? 'active-lang-nav' : 'inactive-lang-nav';
            btnEN.className = (lang === 'en') ? 'active-lang-nav' : 'inactive-lang-nav';
        }
        if (btnIDm && btnENm) {
            btnIDm.className = (lang === 'id') ? 'active-lang' : '';
            btnENm.className = (lang === 'en') ? 'active-lang' : '';
        }
    }

    // ── Trigger terjemahan ────────────────────────────────────────────────────
    function doTranslate(lang) {
        // 1. Set cookie googtrans
        if (lang === 'id') {
            setCookie('googtrans', '/en/id', 1);
        } else {
            setCookie('googtrans', '/en/en', -1);
        }

        // 2. Polling cari .goog-te-combo
        var attempts = 0;
        var maxAttempts = 40; // 20 detik total
        var interval = setInterval(function () {
            attempts++;

            // Cara 1: via combo select
            var select = document.querySelector('.goog-te-combo');
            if (select) {
                clearInterval(interval);
                select.value = (lang === 'id') ? 'id' : '';
                select.dispatchEvent(new Event('change', { bubbles: true }));
                return;
            }

            // Cara 2: via iframe menu Google Translate
            var frame = document.querySelector('.goog-te-menu-frame');
            if (frame) {
                try {
                    var frameDoc = frame.contentDocument || frame.contentWindow.document;
                    var links = frameDoc.querySelectorAll('.goog-te-menu2-item');
                    for (var i = 0; i < links.length; i++) {
                        var text = links[i].textContent || '';
                        if (lang === 'id' && text.indexOf('Indonesian') !== -1) {
                            links[i].click();
                            clearInterval(interval);
                            return;
                        }
                        if (lang === 'en' && text.indexOf('English') !== -1) {
                            links[i].click();
                            clearInterval(interval);
                            return;
                        }
                    }
                } catch (e) { /* cross-origin, skip */ }
            }

            // Cara 3 (last resort): reload — cookie sudah di-set
            if (attempts >= maxAttempts) {
                clearInterval(interval);
                location.reload();
            }

        }, 500);
    }

    // ── Public: dipanggil saat klik tombol ID / EN ────────────────────────────
    window.setLang = function (lang) {
        if (lang === currentLang) return;
        currentLang = lang;
        localStorage.setItem('alasLang', lang);
        updateButtons(lang);
        doTranslate(lang);
    };

    // ── Google Translate widget init callback ─────────────────────────────────
    window.googleTranslateElementInit = function () {
        var el = document.getElementById('google_translate_element');
        if (!el) return;

        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,id',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');

        // Terapkan bahasa tersimpan setelah widget siap
        if (currentLang === 'id') {
            doTranslate('id');
        }
    };

    // ── Load Google Translate script lebih awal (async + defer) ──────────────
    if (!document.querySelector('script[data-gte="1"]')) {
        var s = document.createElement('script');
        s.setAttribute('data-gte', '1');
        s.async = true;
        s.defer = true;
        s.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
        document.head.appendChild(s);
    }

    // ── Init tampilan tombol sesuai state awal ────────────────────────────────
    updateButtons(currentLang);

    // ── Hamburger menu ────────────────────────────────────────────────────────
    var hamburger = document.getElementById('alasHamburger');
    var drawer    = document.getElementById('alasDrawer');
    var bar1      = document.getElementById('alasBar1');
    var bar2      = document.getElementById('alasBar2');
    var bar3      = document.getElementById('alasBar3');

    if (!hamburger || !drawer) return;

    var open = false;

    hamburger.addEventListener('click', function () {
        open = !open;
        drawer.classList.toggle('open', open);

        if (open) {
            bar1.style.transform = 'translateY(7px) rotate(45deg)';
            bar2.style.opacity   = '0';
            bar3.style.transform = 'translateY(-7px) rotate(-45deg)';
            hamburger.setAttribute('aria-label', 'Close menu');
        } else {
            bar1.style.transform = '';
            bar2.style.opacity   = '1';
            bar3.style.transform = '';
            hamburger.setAttribute('aria-label', 'Open menu');
        }
    });

})();
</script>