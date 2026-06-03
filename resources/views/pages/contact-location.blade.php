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
        <section class="contact-hero">
            <div class="contact-hero-inner">
                <img class="contact-hero-logo" src="{{ asset('images/logo_only.png') }}" alt="AlaSare logo">
                <div>
                    <h1>We're here for you</h1>
                    <p>Questions, group bookings, collaborations, or just saying hi - we respond to everything within a few hours.</p>
                </div>
            </div>
        </section>

        <section class="contact-drop-section" aria-labelledby="contactDropTitle">
            <div class="contact-drop-inner">
                <article class="contact-image-card">
                    <img src="{{ asset('images/gallery/forest-pathway.png') }}" alt="Garden pathway at AlaSare">
                    <div class="contact-photo-caption">
                        <span>Contact Point</span>
                        <strong>AlaSare Core</strong>
                    </div>
                </article>

                <form class="contact-form-card" method="POST" action="{{ route('contact.store') }}" aria-labelledby="contactDropTitle">
                    @csrf
                    <h2 id="contactDropTitle">Drop us a line</h2>

                    @if(session('success'))
                        <div style="background:#e6f4e6;border:1px solid #a3d4a3;border-radius:8px;padding:12px 16px;color:#2e7d32;font-size:13px;font-weight:600;margin-bottom:16px;">
                            ✓ {{ session('success') }}
                        </div>
                    @endif

                    <label>
                        <span>Full Name</span>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Anna Laras">
                        @error('name')<span style="color:#c62828;font-size:12px">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Email Address</span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Your booking email address">
                        @error('email')<span style="color:#c62828;font-size:12px">{{ $message }}</span>@enderror
                    </label>
                    <label>
                        <span>Phone Number</span>
                        <div class="contact-phone-row">
                            <select name="country_code" aria-label="Country code">
                                <option {{ old('country_code') == '+62' ? 'selected' : '' }}>+62</option>
                                <option {{ old('country_code') == '+1'  ? 'selected' : '' }}>+1</option>
                                <option {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                <option {{ old('country_code') == '+81' ? 'selected' : '' }}>+81</option>
                            </select>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="WhatsApp number preferred">
                        </div>
                    </label>
                    <label>
                        <span class="sr-only">Message</span>
                        <textarea name="message" rows="6" placeholder="Type your message">{{ old('message') }}</textarea>
                        @error('message')<span style="color:#c62828;font-size:12px">{{ $message }}</span>@enderror
                    </label>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </section>

        <section class="location-heading">
            <div>
                <h2>Find us in ...</h2>
                <p>Tucked in a green pocket of Bandung - close to everything that matters, removed from everything that doesn't.</p>
            </div>
        </section>

        <section class="location-map-section" aria-label="AlaSare map location">
            <iframe
                title="AlaSare Hostel location map"
                src="{{ $mapsLink ?: 'https://www.google.com/maps?q='.urlencode($address).'&output=embed' }}"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </section>

        <section class="location-info-section">
            <article class="location-address">
                <p class="section-kicker">Address</p>
                <h2>AlaSare Hostel</h2>
                <div class="location-address-card">
                    <p>{{ $address }}</p>
                    @if($phone)
                        <a href="tel:{{ $phone }}">{{ $phone }}</a>
                    @endif
                    @if($publicEmail)
                        <a href="mailto:{{ $publicEmail }}">{{ $publicEmail }}</a>
                    @endif
                </div>
            </article>

            <article class="location-directions">
                <p class="section-kicker">Getting Here</p>
                <h2>How to reach us</h2>
                <div class="direction-list">
                    @forelse($transports as $transport)
                        @php
                            $hasRoutes = !empty($transport->routes) && count($transport->routes) > 0;
                            $svg = $svgPaths[$transport->icon] ?? '<circle cx="12" cy="12" r="10"/>';
                        @endphp

                        @if($hasRoutes)
                        <div class="direction-dropdown-row">
                            <button type="button" class="direction-dropdown-toggle"
                                    aria-expanded="false"
                                    aria-controls="transport{{ $transport->id }}">
                                <span class="direction-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        {!! $svg !!}
                                    </svg>
                                </span>
                                <span>{{ $transport->title }}</span>
                                <span class="direction-chevron" aria-hidden="true"></span>
                            </button>
                            @if($transport->description)
                                <p class="direction-description">{{ $transport->description }}</p>
                            @endif
                            <div class="direction-subitems" id="transport{{ $transport->id }}">
                                @foreach($transport->routes as $route)
                                <div class="direction-subitem">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        {!! $svg !!}
                                    </svg>
                                    <span>{{ $route }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="direction-static-row">
                            <div class="direction-static-heading">
                                <span class="direction-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        {!! $svg !!}
                                    </svg>
                                </span>
                                <span>{{ $transport->title }}</span>
                                <span class="direction-chevron" aria-hidden="true"></span>
                            </div>
                            @if($transport->description)
                                <p class="direction-description">{{ $transport->description }}</p>
                            @endif
                        </div>
                        @endif

                    @empty
                        <p style="color:#9aaa96;font-size:13px">No transportation info available.</p>
                    @endforelse
                </div>
            </article>
        </section>
    </main>

    @include('components.footer')
    <x-whatsapp_floating />

    <script>
        document.querySelectorAll('.direction-dropdown-toggle').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const row = toggle.closest('.direction-dropdown-row');
                const isOpen = row?.classList.toggle('is-open');
                toggle.setAttribute('aria-expanded', String(Boolean(isOpen)));
            });
        });
    </script>
</body>
</html>