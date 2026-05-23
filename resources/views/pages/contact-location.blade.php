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

                <form class="contact-form-card" aria-labelledby="contactDropTitle">
                    <h2 id="contactDropTitle">Drop us a line</h2>
                    <label>
                        <span>Full Name</span>
                        <input type="text" name="name" placeholder="e.g. Anna Laras">
                    </label>
                    <label>
                        <span>Email Address</span>
                        <input type="email" name="email" placeholder="Your booking email address">
                    </label>
                    <label>
                        <span>Phone Number</span>
                        <div class="contact-phone-row">
                            <select name="country_code" aria-label="Country code">
                                <option>+62</option>
                                <option>+1</option>
                                <option>+44</option>
                                <option>+81</option>
                            </select>
                            <input type="tel" name="phone" placeholder="WhatsApp number preferred">
                        </div>
                    </label>
                    <label>
                        <span class="sr-only">Message</span>
                        <textarea name="message" rows="6" placeholder="Type your message"></textarea>
                    </label>
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
                src="https://www.google.com/maps?q=Jl.%20Prof.%20Dr.%20Sutami%20No%2062%20Bandung%20Jawa%20Barat%2040152&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </section>

        <section class="location-info-section">
            <article class="location-address">
                <p class="section-kicker">Address</p>
                <h2>AlaSare Hostel</h2>
                <div class="location-address-card">
                    <p>Jl. Prof. Dr. Sutami No 62<br>Bandung, Jawa Barat 40152<br>Indonesia</p>
                    <a href="tel:+6282111990452">(+62) 8211990452</a>
                    <a href="tel:+6281210907777">(+62) 81210907777</a>
                    <a href="mailto:alasare@gmail.com">alasare@gmail.com</a>
                </div>
            </article>

            <article class="location-directions">
                <p class="section-kicker">Getting Here</p>
                <h2>How to reach us</h2>
                <div class="direction-list">
                    <details open>
                        <summary>
                            <span class="direction-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="4" y="9" width="16" height="8" rx="2"></rect>
                                    <path d="M6.5 9 8 5h8l1.5 4"></path>
                                    <path d="M7 17v2"></path>
                                    <path d="M17 17v2"></path>
                                    <path d="M7.5 13h.01"></path>
                                    <path d="M16.5 13h.01"></path>
                                </svg>
                            </span>
                            <span>Online Taxi</span>
                        </summary>
                        <p class="direction-description">Approximately 20 minutes from Bandung city center.</p>
                        <div class="direction-subitems">
                            <div class="direction-subitem">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="4" y="9" width="16" height="8" rx="2"></rect>
                                    <path d="M6.5 9 8 5h8l1.5 4"></path>
                                    <path d="M7 17v2"></path>
                                    <path d="M17 17v2"></path>
                                </svg>
                                <span>Trans Studio Bandung</span>
                            </div>
                            <div class="direction-subitem">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="4" y="9" width="16" height="8" rx="2"></rect>
                                    <path d="M6.5 9 8 5h8l1.5 4"></path>
                                    <path d="M7 17v2"></path>
                                    <path d="M17 17v2"></path>
                                </svg>
                                <span>Trans Studio Bandung</span>
                            </div>
                        </div>
                    </details>
                    <div class="direction-static-row">
                        <div class="direction-static-heading">
                            <span class="direction-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="6" cy="16" r="3"></circle>
                                    <circle cx="18" cy="16" r="3"></circle>
                                    <path d="M8.5 16h3.2l2.3-5h2l2 5"></path>
                                    <path d="M12 11h-2.2l-2 5"></path>
                                    <path d="M13.5 8h2.5"></path>
                                </svg>
                            </span>
                            <span>Motorcycle</span>
                            <span class="direction-chevron" aria-hidden="true"></span>
                        </div>
                        <p class="direction-description">Approximately 20 minutes from Bandung city center.</p>
                    </div>
                    <div class="direction-static-row">
                        <div class="direction-static-heading">
                            <span class="direction-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="5" r="2"></circle>
                                    <path d="m11 8-2 5 3 2 1 5"></path>
                                    <path d="m13 9 2 3 3 1"></path>
                                    <path d="m10 20-2 1"></path>
                                </svg>
                            </span>
                            <span>Walking</span>
                            <span class="direction-chevron" aria-hidden="true"></span>
                        </div>
                        <p class="direction-description">ApproximatWalkinely 20 minutes from Bandung city center.</p>
                    </div>
                    <div class="direction-static-row">
                        <div class="direction-static-heading">
                            <span class="direction-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="5" y="4" width="14" height="14" rx="2"></rect>
                                    <path d="M8 18v2"></path>
                                    <path d="M16 18v2"></path>
                                    <path d="M8 8h8"></path>
                                    <path d="M8 13h.01"></path>
                                    <path d="M16 13h.01"></path>
                                </svg>
                            </span>
                            <span>Bus / Trans</span>
                            <span class="direction-chevron" aria-hidden="true"></span>
                        </div>
                        <p class="direction-description">Approximately 20 minutes from Bandung city center.</p>
                    </div>
                </div>
            </article>
        </section>
    </main>

    @include('components.footer')
    <x-whatsapp_floating />
</body>
</html>
