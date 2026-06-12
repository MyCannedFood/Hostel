<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact & Location - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.navbar')

    @php
    $svgPaths = [
        'car'        => '<rect x="4" y="9" width="16" height="8" rx="2"></rect><path d="M6.5 9 8 5h8l1.5 4"></path><path d="M7 17v2"></path><path d="M17 17v2"></path><path d="M7.5 13h.01"></path><path d="M16.5 13h.01"></path>',
        'motorcycle' => '<circle cx="6" cy="16" r="3"></circle><circle cx="18" cy="16" r="3"></circle><path d="M8.5 16h3.2l2.3-5h2l2 5"></path><path d="M12 11h-2.2l-2 5"></path><path d="M13.5 8h2.5"></path>',
        'bus'        => '<rect x="5" y="4" width="14" height="14" rx="2"></rect><path d="M8 18v2"></path><path d="M16 18v2"></path><path d="M8 8h8"></path><path d="M8 13h.01"></path><path d="M16 13h.01"></path>',
        'shuttle'    => '<rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 6v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
        'bicycle'    => '<circle cx="5" cy="17" r="3"/><circle cx="19" cy="17" r="3"/><path d="M9 17l3-7 3 3.5"/><path d="M12 10h3l2 4"/><path d="M9 17h10"/>',
        'walking'    => '<circle cx="12" cy="5" r="2"/><path d="m11 8-2 5 3 2 1 5"></path><path d="m13 9 2 3 3 1"></path><path d="m10 20-2 1"></path>',
        'boat'       => '<path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/><path d="M19 13V7l-7-3-7 3v6"/>',
    ];
    @endphp

    <main class="contact-location-page">

        {{-- ── Hero ──────────────────────────────────────────────────────── --}}
        <section class="contact-hero">
            <div class="contact-hero-inner">
                <img class="contact-hero-logo" src="{{ asset('images/logo_only.png') }}" alt="AlaSare logo">
                <div>
                    <h1>
                        <span data-en="{{ $heroTitle }}"
                              data-id="{{ $heroTitle_id }}">{{ $heroTitle }}</span>
                    </h1>
                    <p>
                        <span data-en="{{ $heroSubtitle }}"
                              data-id="{{ $heroSubtitle_id }}">{{ $heroSubtitle }}</span>
                    </p>
                </div>
            </div>
        </section>

        {{-- ── Contact Form ──────────────────────────────────────────────── --}}
        <section class="contact-drop-section" aria-labelledby="contactDropTitle">
            <div class="contact-drop-inner">
                <article class="contact-image-card">
                    <img src="{{ asset('images/gallery/forest-pathway.png') }}" alt="Garden pathway at AlaSare">
                    <div class="contact-photo-caption">
                        <span data-en="Contact Point" data-id="Titik Kontak">Contact Point</span>
                        <strong>AlaSare Core</strong>
                    </div>
                </article>

                <form class="contact-form-card" method="POST" action="{{ route('contact.store') }}" aria-labelledby="contactDropTitle">
                    @csrf
                    <h2 id="contactDropTitle">
                        <span data-en="Drop us a line" data-id="Kirim pesan untuk kami">Drop us a line</span>
                    </h2>

                    @if(session('success'))
                        <div style="background:#e6f4e6;border:1px solid #a3d4a3;border-radius:8px;padding:12px 16px;color:#2e7d32;font-size:13px;font-weight:600;margin-bottom:16px;">
                            ✓ <span data-en="Your message has been sent! We will get back to you shortly."
                                    data-id="Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.">{{ session('success') }}</span>
                        </div>
                    @endif

                    <label>
                        <span data-en="Full Name" data-id="Nama Lengkap">Full Name</span>
                        <input type="text" name="name" value="{{ old('name') }}"
                               data-placeholder-en="e.g. Anna Laras"
                               data-placeholder-id="mis. Anna Laras"
                               placeholder="e.g. Anna Laras">
                        @error('name')<span style="color:#c62828;font-size:12px">{{ $message }}</span>@enderror
                    </label>

                    <label>
                        <span data-en="Email Address" data-id="Alamat Email">Email Address</span>
                        <input type="email" name="email" value="{{ old('email') }}"
                               data-placeholder-en="Your booking email address"
                               data-placeholder-id="Alamat email untuk pemesanan"
                               placeholder="Your booking email address">
                        @error('email')<span style="color:#c62828;font-size:12px">{{ $message }}</span>@enderror
                    </label>

                    <label>
                        <span data-en="Phone Number" data-id="Nomor Telepon">Phone Number</span>
                        <div class="contact-phone-row">
                            <select name="country_code" aria-label="Country code">
                                <option {{ old('country_code') == '+62' ? 'selected' : '' }}>+62</option>
                                <option {{ old('country_code') == '+1'  ? 'selected' : '' }}>+1</option>
                                <option {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                <option {{ old('country_code') == '+81' ? 'selected' : '' }}>+81</option>
                            </select>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   data-placeholder-en="WhatsApp number preferred"
                                   data-placeholder-id="Nomor WhatsApp lebih disarankan"
                                   placeholder="WhatsApp number preferred">
                        </div>
                    </label>

                    <label>
                        <span class="sr-only" data-en="Message" data-id="Pesan">Message</span>
                        <textarea name="message" rows="6"
                                  data-placeholder-en="Type your message"
                                  data-placeholder-id="Ketik pesan Anda"
                                  placeholder="Type your message">{{ old('message') }}</textarea>
                        @error('message')<span style="color:#c62828;font-size:12px">{{ $message }}</span>@enderror
                    </label>

                    <button type="submit">
                        <span data-en="Send Message" data-id="Kirim Pesan">Send Message</span>
                    </button>
                </form>
            </div>
        </section>

        {{-- ── Location Heading ──────────────────────────────────────────── --}}
        <section class="location-heading">
            <div>
                <h2>
                    <span data-en="{{ $locationTitle }}"
                          data-id="{{ $locationTitle_id }}">{{ $locationTitle }}</span>
                </h2>
                <p>
                    <span data-en="{{ $locationDesc }}"
                          data-id="{{ $locationDesc_id }}">{{ $locationDesc }}</span>
                </p>
            </div>
        </section>

        {{-- ── Map ────────────────────────────────────────────────────────── --}}
        <section class="location-map-section" aria-label="AlaSare map location">
            <iframe
                title="AlaSare Hostel location map"
                src="{{ $mapsLink ?: 'https://www.google.com/maps?q='.urlencode($address).'&output=embed' }}"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </section>

        {{-- ── Address + Directions ──────────────────────────────────────── --}}
        <section class="location-info-section">
            <article class="location-address">
                <p class="section-kicker">
                    <span data-en="Address" data-id="Alamat">Address</span>
                </p>
                <h2>AlaSare Hostel</h2>
                <div class="location-address-card">
                    {{-- Show bilingual address if available, else same for both --}}
                    <p data-en="{{ $address }}"
                       data-id="{{ $address_id }}">{{ $address }}</p>

                    @if($phone)
                        <a href="tel:{{ $phone }}">{{ $phone }}</a>
                    @endif
                    @if($publicEmail)
                        <a href="mailto:{{ $publicEmail }}">{{ $publicEmail }}</a>
                    @endif
                </div>
            </article>

            <article class="location-directions">
                <p class="section-kicker">
                    <span data-en="Getting Here" data-id="Cara ke Sini">Getting Here</span>
                </p>
                <h2>
                    <span data-en="How to reach us" data-id="Cara menuju kami">How to reach us</span>
                </h2>

                <div class="direction-list">
                    @forelse($transports as $transport)
                        @php
                            $hasRoutes = !empty($transport->routes) && count($transport->routes) > 0;
                            $svg = $svgPaths[$transport->icon] ?? '<circle cx="12" cy="12" r="10"/>';

                            // Build bilingual data attributes
                            $titleEn  = $transport->title;
                            $titleId  = !empty($transport->title_id) ? $transport->title_id : $transport->title;
                            $descEn   = $transport->description ?? '';
                            $descId   = !empty($transport->description_id) ? $transport->description_id : $descEn;
                            $routesEn = json_encode($transport->routes ?? []);
                            $routesId = json_encode(!empty($transport->routes_id) ? $transport->routes_id : ($transport->routes ?? []));
                        @endphp

                        @if($hasRoutes)
                        <div class="direction-dropdown-row"
                             data-title-en="{{ $titleEn }}"
                             data-title-id="{{ $titleId }}"
                             data-desc-en="{{ $descEn }}"
                             data-desc-id="{{ $descId }}"
                             data-routes-en='{{ $routesEn }}'
                             data-routes-id='{{ $routesId }}'>
                            <button type="button" class="direction-dropdown-toggle"
                                    aria-expanded="false"
                                    aria-controls="transport{{ $transport->id }}">
                                <span class="direction-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        {!! $svg !!}
                                    </svg>
                                </span>
                                <span class="transport-title-text">{{ $titleEn }}</span>
                                <span class="direction-chevron" aria-hidden="true"></span>
                            </button>
                            @if($transport->description)
                                <p class="direction-description transport-desc-text">{{ $descEn }}</p>
                            @endif
                            <div class="direction-subitems" id="transport{{ $transport->id }}">
                                @foreach($transport->routes as $route)
                                <div class="direction-subitem">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        {!! $svg !!}
                                    </svg>
                                    <span class="transport-route-item">{{ $route }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="direction-static-row"
                             data-title-en="{{ $titleEn }}"
                             data-title-id="{{ $titleId }}"
                             data-desc-en="{{ $descEn }}"
                             data-desc-id="{{ $descId }}">
                            <div class="direction-static-heading">
                                <span class="direction-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        {!! $svg !!}
                                    </svg>
                                </span>
                                <span class="transport-title-text">{{ $titleEn }}</span>
                                <span class="direction-chevron" aria-hidden="true"></span>
                            </div>
                            @if($transport->description)
                                <p class="direction-description transport-desc-text">{{ $descEn }}</p>
                            @endif
                        </div>
                        @endif

                    @empty
                        <p style="color:#9aaa96;font-size:13px">
                            <span data-en="No transportation info available."
                                  data-id="Informasi transportasi belum tersedia.">No transportation info available.</span>
                        </p>
                    @endforelse
                </div>
            </article>
        </section>
    </main>

    @include('components.footer')
    <x-whatsapp_floating />



    <script>
    (function () {
        // ── Translatable text nodes (data-en / data-id spans) ──────────
        function applyLang(lang) {
            // Simple [data-en] spans
            document.querySelectorAll('[data-en]').forEach(function (el) {
                el.textContent = el.getAttribute('data-' + lang) || el.getAttribute('data-en');
            });

            // Inputs & textareas with data-placeholder-en / data-placeholder-id
            document.querySelectorAll('[data-placeholder-en]').forEach(function (el) {
                el.placeholder = el.getAttribute('data-placeholder-' + lang)
                    || el.getAttribute('data-placeholder-en');
            });

            // Transport rows: title, description, routes
            document.querySelectorAll('.direction-dropdown-row, .direction-static-row').forEach(function (row) {
                // Title
                var titleEl = row.querySelector('.transport-title-text');
                if (titleEl) {
                    titleEl.textContent = row.getAttribute('data-title-' + lang)
                        || row.getAttribute('data-title-en') || titleEl.textContent;
                }

                // Description
                var descEl = row.querySelector('.transport-desc-text');
                if (descEl) {
                    var desc = row.getAttribute('data-desc-' + lang)
                        || row.getAttribute('data-desc-en') || '';
                    descEl.textContent = desc;
                    descEl.style.display = desc ? '' : 'none';
                }

                // Routes (only dropdown rows have subitems)
                var routeItems = row.querySelectorAll('.transport-route-item');
                if (routeItems.length) {
                    var routesRaw = row.getAttribute('data-routes-' + lang)
                        || row.getAttribute('data-routes-en') || '[]';
                    var routes = [];
                    try { routes = JSON.parse(routesRaw); } catch (e) {}
                    routeItems.forEach(function (item, i) {
                        item.textContent = routes[i] !== undefined ? routes[i] : item.textContent;
                    });
                }
            });

            // Persist
            try { localStorage.setItem('alasare_lang', lang); } catch (e) {}

            // Update <html lang>
            document.documentElement.lang = lang;
        }

        // ── Expose applyLang globally so the navbar can call it ─────────
        window.applyLang = applyLang;

        // ── Init from localStorage or browser default ───────────────────
        var saved = 'en';
        try {
            var ls = localStorage.getItem('alasare_lang');
            if (ls === 'id' || ls === 'en') saved = ls;
        } catch (e) {}

        applyLang(saved);

        // ── Dropdown accordion (original behaviour preserved) ──────────
        document.querySelectorAll('.direction-dropdown-toggle').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                var row = toggle.closest('.direction-dropdown-row');
                var isOpen = row && row.classList.toggle('is-open');
                toggle.setAttribute('aria-expanded', String(Boolean(isOpen)));
            });
        });
    })();
    </script>
</body>
</html>