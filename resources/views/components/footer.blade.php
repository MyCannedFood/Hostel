{{--
    Ganti <footer class="main-footer"> yang sekarang hardcoded
    dengan versi ini yang fetch dari SiteSetting & SiteSetting (location).

    Letakkan di: resources/views/components/footer.blade.php
    atau langsung inline di layout utama.
--}}

@php
    use App\Models\SiteSetting;

    // ── Brand / Footer settings ──────────────────────────────
    $footerBrandDesc     = SiteSetting::get('footer_brand_desc',      'A sanctuary where Javanese heritage meets ecological mindfulness. Retreat to the forest and rediscover balance.');
    $footerNewsletterTxt = SiteSetting::get('footer_newsletter_text', 'Subscribe for seasonal updates and exclusive retreat offers.');
    $footerInstagram     = SiteSetting::get('footer_instagram_url',   '#');
    $footerFacebook      = SiteSetting::get('footer_facebook_url',    '#');
    $footerPinterest     = SiteSetting::get('footer_pinterest_url',   '#');
    $footerCopyright     = SiteSetting::get('footer_copyright_text',  '© 2026 AlaSare Eco-Sanctuary. All rights reserved.');
    $footerPrivacyUrl    = SiteSetting::get('footer_privacy_url',     '#');
    $footerTermsUrl      = SiteSetting::get('footer_terms_url',       '#');

    // ── Contact / Location settings (sudah ada dari LocationSettings) ──
    $address     = SiteSetting::get('address',      'Jl. Raya Hutan No. 88, Gianyar, Bali, Indonesia 80571');
    $publicEmail = SiteSetting::get('public_email', 'reservations@alasare.com');
    $phone       = SiteSetting::get('phone',        '+62 361 900 8888');
@endphp

<footer class="main-footer">
    <div class="footer-content">

        {{-- Brand column --}}
        <div class="footer-brand">
            <span class="logo">AlaSare</span>
            <p>{{ $footerBrandDesc }}</p>
            <div class="contact-info">
                {!! nl2br(e($address)) !!}<br><br>
                {{ $publicEmail }}<br>
                {{ $phone }}
            </div>
        </div>

        {{-- Nav column (static — bisa dijadikan dynamic juga kalau perlu) --}}
        <div class="footer-nav">
            <h4>Discover</h4>
            <ul class="footer-links">
                <li><a href="#">Our Story</a></li>
                <li><a href="#">Villas &amp; Rates</a></li>
                <li><a href="#">Botanical Spa</a></li>
                <li><a href="#">Dining</a></li>
                <li><a href="#">Sustainability</a></li>
            </ul>
        </div>

        {{-- Newsletter + Social column --}}
        <div class="footer-newsletter">
            <h4>Journal</h4>
            <p>{{ $footerNewsletterTxt }}</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Email address" required>
                <button type="submit">Submit</button>
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
        <div class="copyright">
            {{ $footerCopyright }}
        </div>
        <div class="footer-bottom-links">
            <a href="{{ $footerPrivacyUrl }}">Privacy Policy</a>
            <a href="{{ $footerTermsUrl }}">Terms of Service</a>
        </div>
    </div>
</footer>