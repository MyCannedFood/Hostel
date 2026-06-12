@php
    use App\Models\SiteSetting;

    $footerBrandDesc      = SiteSetting::get('footer_brand_desc',         'A sanctuary where Javanese heritage meets ecological mindfulness. Retreat to the forest and rediscover balance.');
    $footerBrandDescId    = SiteSetting::get('footer_brand_desc_id',      $footerBrandDesc);
    $footerNewsletterTxt  = SiteSetting::get('footer_newsletter_text',    'Subscribe for seasonal updates and exclusive retreat offers.');
    $footerNewsletterTxtId= SiteSetting::get('footer_newsletter_text_id', $footerNewsletterTxt);
    $footerInstagram      = SiteSetting::get('footer_instagram_url',      '#');
    $footerFacebook       = SiteSetting::get('footer_facebook_url',       '#');
    $footerPinterest      = SiteSetting::get('footer_pinterest_url',      '#');
    $footerCopyright      = SiteSetting::get('footer_copyright_text',     '© 2026 AlaSare Eco-Sanctuary. All rights reserved.');
    $footerCopyrightId    = SiteSetting::get('footer_copyright_text_id',  $footerCopyright);
    $footerPrivacyUrl     = SiteSetting::get('footer_privacy_url',        '#');
    $footerTermsUrl       = SiteSetting::get('footer_terms_url',          '#');

    $address     = SiteSetting::get('address',      'Jl. Raya Hutan No. 88, Gianyar, Bali, Indonesia 80571');
    $publicEmail = SiteSetting::get('public_email', 'reservations@alasare.com');
    $phone       = SiteSetting::get('phone',        '+62 361 900 8888');
@endphp

<footer class="main-footer">
    <div class="footer-content">

        {{-- Brand column --}}
        <div class="footer-brand">
            <span class="logo">AlaSare</span>
            <p data-en="{{ $footerBrandDesc }}"
               data-id="{{ $footerBrandDescId }}">
                {{ $footerBrandDesc }}
            </p>
            <div class="contact-info">
                {!! nl2br(e($address)) !!}<br><br>
                {{ $publicEmail }}<br>
                {{ $phone }}
            </div>
        </div>

        {{-- Nav column --}}
        <div class="footer-nav">
            <h4 data-en="Discover" data-id="Jelajahi">Discover</h4>
            <ul class="footer-links">
                <li><a href="/"            data-en="Home"        data-id="Beranda">Home</a></li>
                <li><a href="/rooms"       data-en="Villas"      data-id="Vila">Villas</a></li>
                <li><a href="/gallery"     data-en="Gallery"     data-id="Galeri">Gallery</a></li>
                <li><a href="/experience"  data-en="Experience"  data-id="Pengalaman">Experience</a></li>
                <li><a href="/journal"     data-en="Journal"     data-id="Jurnal">Journal</a></li>
                <li><a href="/guest-story" data-en="Guest Story" data-id="Cerita Tamu">Guest Story</a></li>
                <li><a href="/contact"     data-en="Contact"     data-id="Kontak">Contact</a></li>
            </ul>
        </div>

        {{-- Newsletter + Social column --}}
        <div class="footer-newsletter">
            <h4 data-en="Journal" data-id="Jurnal">Journal</h4>
            <p data-en="{{ $footerNewsletterTxt }}"
               data-id="{{ $footerNewsletterTxtId }}">
                {{ $footerNewsletterTxt }}
            </p>
            <form class="newsletter-form">
                <input type="email"
                       data-en="Email address"
                       data-id="Alamat email"
                       placeholder="Email address"
                       required>
                <button type="submit"
                        data-en="Submit"
                        data-id="Kirim">Submit</button>
            </form>
            <div class="social-links">
                @if($footerInstagram && $footerInstagram !== '#')
                <a href="{{ $footerInstagram }}" class="social-icon" aria-label="Instagram" target="_blank" rel="noopener">
                @else
                <a href="#" class="social-icon" aria-label="Instagram">
                @endif
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                    </svg>
                </a>

                @if($footerFacebook && $footerFacebook !== '#')
                <a href="{{ $footerFacebook }}" class="social-icon" aria-label="Facebook" target="_blank" rel="noopener">
                @else
                <a href="#" class="social-icon" aria-label="Facebook">
                @endif
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                    </svg>
                </a>

                @if($footerPinterest && $footerPinterest !== '#')
                <a href="{{ $footerPinterest }}" class="social-icon" aria-label="Pinterest" target="_blank" rel="noopener">
                @else
                <a href="#" class="social-icon" aria-label="Pinterest">
                @endif
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8c-2.21 0-4 1.79-4 4 0 1.2.54 2.27 1.38 3l.62 3.5 1.5-1.5c.16.1.33.19.5.27.67.3 1.41.48 2.21.48a4 4 0 0 0 4-4c0-2.21-1.79-4-4-4z"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <div class="copyright"
             data-en="{{ $footerCopyright }}"
             data-id="{{ $footerCopyrightId }}">
            {{ $footerCopyright }}
        </div>
        <div class="footer-bottom-links">
            <a href="{{ $footerPrivacyUrl }}"
               data-en="Privacy Policy"
               data-id="Kebijakan Privasi">Privacy Policy</a>
            <a href="{{ $footerTermsUrl }}"
               data-en="Terms of Service"
               data-id="Syarat Layanan">Terms of Service</a>
        </div>
    </div>
</footer>