{{-- resources/views/components/navbar.blade.php --}}

<style>
    /* ── Google Translate: hide UI elements ── */
    .goog-te-banner-frame,
    #goog-gt-tt,
    .goog-te-balloon-frame,
    .skiptranslate {
        display: none !important;
    }
    body { top: 0 !important; }

    /* ── Google Translate init holder ── */
    #gt_holder { display: none; }

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
    .active-lang-nav {
        text-decoration: none;
        font-family: 'Georgia', serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #1a3d0a;
        opacity: 1;
    }

    .inactive-lang-nav {
        text-decoration: none;
        font-family: 'Georgia', serif;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.08em;
        color: #1a3d0a;
        opacity: 0.55;
        transition: opacity 0.2s;
    }

    .inactive-lang-nav:hover {
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

    .alas-drawer .drawer-lang a {
        border: none;
        padding: 0;
        font-size: 13px;
        opacity: 0.55;
        text-transform: none;
        letter-spacing: 0.08em;
    }

    .alas-drawer .drawer-lang a.active-lang {
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

            {{-- Language Switcher --}}
            <div class="alas-lang-btn notranslate" style="display:flex; align-items:center; gap:6px;">

                <a href="javascript:void(0)" onclick="changeLanguage('id')"
                   class="inactive-lang-nav notranslate" id="langIdDesktop">
                    ID
                </a>

                <span class="notranslate" style="color:#1a3d0a; opacity:0.3; font-size:13px; line-height:1;">
                    |
                </span>

                <a href="javascript:void(0)" onclick="changeLanguage('en')"
                   class="active-lang-nav notranslate" id="langEnDesktop">
                    EN
                </a>

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

    {{-- Mobile Drawer --}}
    <div class="alas-drawer" id="alasDrawer">

        <a href="/"
           class="{{ request()->is('/') ? 'active-link' : '' }}">
            Home
        </a>

        <a href="/rooms"
           class="{{ request()->is('rooms') ? 'active-link' : '' }}">
            Villas
        </a>

        <a href="/gallery"
           class="{{ request()->is('gallery') ? 'active-link' : '' }}">
            Gallery
        </a>

        <a href="/experience"
           class="{{ request()->is('experience') ? 'active-link' : '' }}">
            Experiences
        </a>

        <a href="/journal"
           class="{{ request()->is('journal') ? 'active-link' : '' }}">
            Journal
        </a>

        <a href="/guest-story"
           class="{{ request()->is('guest-story') ? 'active-link' : '' }}">
            Guest Story
        </a>

        <a href="/contact"
           class="{{ request()->is('contact') ? 'active-link' : '' }}">
            Contact
        </a>

        {{-- Mobile Language --}}
        <div class="drawer-lang notranslate">

            <a href="javascript:void(0)" onclick="changeLanguage('id')"
               class="notranslate" id="langIdMobile">
                ID
            </a>

            <span class="notranslate">|</span>

            <a href="javascript:void(0)" onclick="changeLanguage('en')"
               class="notranslate active-lang" id="langEnMobile">
                EN
            </a>

        </div>

        <a href="/calendar" class="drawer-book">
            Book Now
        </a>
    </div>


    {{-- Global WhatsApp floating button --}}
    @include('components.whatsapp_floating')

    <div id="gt_holder"></div>
</nav>

<script>
function changeLanguage(lang) {
    document.cookie = 'googtrans=/en/' + lang;
    location.reload();
}

(function initLangUI() {
    var match = document.cookie.match(/googtrans=.*\/([a-z]{2})/);
    if (match) updateLangUI(match[1]);
})();

function hideGoogleTranslateBar() {
    document.querySelectorAll('iframe.goog-te-banner-frame, .goog-te-banner-frame, .skiptranslate iframe, .skiptranslate').forEach(function(el) {
        el.style.setProperty('display', 'none', 'important');
    });
    document.body.style.setProperty('top', '0', 'important');
    document.body.style.setProperty('position', 'static', 'important');
}

var observer = new MutationObserver(function() {
    hideGoogleTranslateBar();
});
observer.observe(document.body, { childList: true, subtree: true });

hideGoogleTranslateBar();

function updateLangUI(lang) {
    document.querySelectorAll('[id^="langId"]').forEach(function(el) {
        el.className = lang === 'id' ? (el.id.includes('Mobile') ? 'active-lang' : 'active-lang-nav') : (el.id.includes('Mobile') ? '' : 'inactive-lang-nav');
    });
    document.querySelectorAll('[id^="langEn"]').forEach(function(el) {
        el.className = lang === 'en' ? (el.id.includes('Mobile') ? 'active-lang' : 'active-lang-nav') : (el.id.includes('Mobile') ? '' : 'inactive-lang-nav');
    });
}

function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,id',
        autoDisplay: false
    }, 'gt_holder');
}

(function () {


    const hamburger = document.getElementById('alasHamburger');
    const drawer = document.getElementById('alasDrawer');

    const bar1 = document.getElementById('alasBar1');
    const bar2 = document.getElementById('alasBar2');
    const bar3 = document.getElementById('alasBar3');

    if (!hamburger || !drawer) return;

    let open = false;

    hamburger.addEventListener('click', function () {

        open = !open;

        drawer.classList.toggle('open', open);

        if (open) {

            bar1.style.transform = 'translateY(7px) rotate(45deg)';
            bar2.style.opacity = '0';
            bar3.style.transform = 'translateY(-7px) rotate(-45deg)';

            hamburger.setAttribute('aria-label', 'Close menu');

        } else {

            bar1.style.transform = '';
            bar2.style.opacity = '1';
            bar3.style.transform = '';

            hamburger.setAttribute('aria-label', 'Open menu');
        }
    });

})();
</script>

<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
