{{-- resources/views/admin/settings/partials/General/footer.blade.php --}}

<style>
.pm-back-link { display:inline-flex;align-items:center;gap:5px;font-size:13px;color:#4a7c3f;text-decoration:none;margin-bottom:20px;font-weight:500;transition:color .15s; }
.pm-back-link:hover { color:#2d4a1e; }
.pm-back-link svg { flex-shrink:0; }
.pm-page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:6px; }
.pm-page-title  { font-size:26px;font-weight:700;color:#1a3a2a;margin:0; }
.pm-page-subtitle { color:#7a857f;font-size:13.5px;margin:0 0 24px; }
.pm-card { background:#fff;border:1px solid #e5e9e6;border-radius:8px;padding:24px 28px;margin-bottom:16px; }
.pm-footer-actions { display:flex;justify-content:flex-end;gap:10px;margin-top:28px; }
.pm-btn-cancel { padding:10px 24px;border-radius:2px;border:none;background:#D9864A;color:#fff;font-size:13.5px;font-weight:600;cursor:pointer;transition:background .15s;font-family:inherit;text-decoration:none;display:inline-flex;align-items:center; }
.pm-btn-cancel:hover { background:#c4733a; }
.pm-btn-save { padding:10px 24px;border-radius:2px;border:none;background:#1A3D0A;color:#fff;font-size:13.5px;font-weight:600;cursor:pointer;transition:background .15s;font-family:inherit; }
.pm-btn-save:hover { background:#2d5a1a; }

.footer-info-box { display:flex;align-items:flex-start;gap:10px;font-size:13.5px;color:#5e655f;line-height:1.5; }
.footer-info-icon { width:20px;height:20px;flex-shrink:0;border-radius:50%;border:1.5px solid #4B9960;color:#4B9960;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;margin-top:1px; }
.footer-section-title { font-size:11.5px;font-weight:700;letter-spacing:.14em;color:#5a6b62;margin-bottom:12px;text-transform:uppercase; }

.footer-field { padding:12px 0 14px;border-bottom:1.5px solid #e0e6e2;margin-bottom:8px; }
.footer-field:last-child { margin-bottom:0; }
.footer-field-label { font-size:12px;color:#8a9690;font-weight:500;margin-bottom:6px;display:block; }
.footer-field-input,
.footer-field-textarea { width:100%;border:none;outline:none;font-size:14.5px;color:#1a3d0a;background:transparent;font-family:inherit;padding:0; }
.footer-field-input::placeholder,
.footer-field-textarea::placeholder { color:#c0ccc5; }
.footer-field-textarea { resize:vertical;min-height:60px;line-height:1.55; }

.footer-lang-group { margin-bottom:24px; }
.footer-lang-group:last-child { margin-bottom:0; }

.footer-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 32px;
    margin-top: 8px;
}
.footer-grid .footer-field {
    margin-bottom: 0;
    border-bottom: 1.5px solid #e0e6e2;
    padding-bottom: 14px;
}
.footer-grid-wrap { padding-top: 14px; margin-top: 0; }
@media (max-width:600px) {
    .footer-grid { grid-template-columns:1fr; gap:0; }
    .footer-grid .footer-field { border-bottom:1.5px solid #e0e6e2; padding-bottom:14px; margin-bottom:16px; }
    .footer-grid .footer-field:last-child { border-bottom:none; margin-bottom:0; }
}

.footer-social-item { display:flex;align-items:flex-start;gap:14px; }
.footer-social-icon { width:38px;height:38px;border-radius:50%;background:#f5f6f3;border:1px solid #e5e9e6;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:14px; }
.footer-social-icon svg { color:#5a6b62; }
.footer-social-content { flex:1; }

.footer-alert { display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:8px;font-size:13.5px;font-weight:500;margin-bottom:20px; }
.footer-alert-success { background:#eef7f0;color:#276c42;border:1px solid #b6dfc4; }
.footer-alert-error   { background:#fdecea;color:#c0392b;border:1px solid #f5c6c2; }

.footer-field.error .footer-field-input,
.footer-field.error .footer-field-textarea { color:#c0392b; }
.footer-field.error { border-bottom-color:#e57373; }
.footer-error-msg { font-size:11.5px;color:#c0392b;margin-top:4px;display:none; }
.footer-field.error .footer-error-msg { display:block; }
</style>

@if(session('success'))
<div class="footer-alert footer-alert-success">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="footer-alert footer-alert-error">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    {{ $errors->first() }}
</div>
@endif

<a href="{{ route('admin.settings', ['section' => 'general']) }}" class="pm-back-link">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M5 12l7-7M5 12l7 7"/></svg>
    Back to General Settings
</a>

<div class="pm-page-header">
    <div>
        <h2 class="pm-page-title">Footer Settings</h2>
        <p class="pm-page-subtitle" style="margin-top:4px;">Manage footer description, social links, and copyright texts.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.footer.update') }}">
@csrf
@method('PUT')

{{-- Info --}}
<div class="pm-card">
    <div class="footer-info-box">
        <div class="footer-info-icon">i</div>
        <span>Contact details in the footer are automatically synced from the <strong>Location &amp; Contact</strong> settings.</span>
    </div>
</div>

{{-- Card 1: Brand Description --}}
<div class="pm-card">
    <div class="footer-lang-group">
        <div class="footer-section-title">Brand Description (Under Logo)</div>
        <div class="footer-field @error('brand_desc') error @enderror" style="margin-bottom:8px;">
            <label class="footer-field-label" for="footer-brand-desc">🇬🇧 English</label>
            <textarea class="footer-field-textarea" id="footer-brand-desc" name="brand_desc"
                placeholder="Short tagline or description under your logo...">{{ old('brand_desc', $footer['brand_desc']) }}</textarea>
            <span class="footer-error-msg">@error('brand_desc'){{ $message }}@enderror</span>
        </div>
        <div class="footer-field @error('brand_desc_id') error @enderror" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
            <label class="footer-field-label" for="footer-brand-desc-id">🇮🇩 Indonesian</label>
            <textarea class="footer-field-textarea" id="footer-brand-desc-id" name="brand_desc_id"
                placeholder="Tagline atau deskripsi singkat di bawah logo...">{{ old('brand_desc_id', $footer['brand_desc_id'] ?? '') }}</textarea>
            <span class="footer-error-msg">@error('brand_desc_id'){{ $message }}@enderror</span>
        </div>
    </div>
</div>

{{-- Card 2: Newsletter Text --}}
<div class="pm-card">
    <div class="footer-lang-group">
        <div class="footer-section-title">Journal / Newsletter Text</div>
        <div class="footer-field @error('newsletter_text') error @enderror" style="margin-bottom:8px;">
            <label class="footer-field-label" for="footer-newsletter">🇬🇧 English</label>
            <input type="text" class="footer-field-input" id="footer-newsletter" name="newsletter_text"
                placeholder="e.g. Subscribe for seasonal updates..."
                value="{{ old('newsletter_text', $footer['newsletter_text']) }}">
            <span class="footer-error-msg">@error('newsletter_text'){{ $message }}@enderror</span>
        </div>
        <div class="footer-field @error('newsletter_text_id') error @enderror" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
            <label class="footer-field-label" for="footer-newsletter-id">🇮🇩 Indonesian</label>
            <input type="text" class="footer-field-input" id="footer-newsletter-id" name="newsletter_text_id"
                placeholder="mis. Berlangganan untuk pembaruan musiman..."
                value="{{ old('newsletter_text_id', $footer['newsletter_text_id'] ?? '') }}">
            <span class="footer-error-msg">@error('newsletter_text_id'){{ $message }}@enderror</span>
        </div>
    </div>
</div>

{{-- Card 3: Social Media --}}
<div class="pm-card">
    <div class="footer-section-title">Social Media Presence</div>

    <div class="footer-social-item">
        <div class="footer-social-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                <circle cx="12" cy="12" r="4"/>
                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
            </svg>
        </div>
        <div class="footer-social-content">
            <div class="footer-field @error('instagram_url') error @enderror">
                <label class="footer-field-label" for="footer-instagram">Instagram URL</label>
                <input type="text" class="footer-field-input" id="footer-instagram" name="instagram_url"
                    placeholder="https://instagram.com/yourhandle"
                    value="{{ old('instagram_url', $footer['instagram_url']) }}">
                <span class="footer-error-msg">@error('instagram_url'){{ $message }}@enderror</span>
            </div>
        </div>
    </div>

    <div class="footer-social-item">
        <div class="footer-social-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
            </svg>
        </div>
        <div class="footer-social-content">
            <div class="footer-field @error('facebook_url') error @enderror">
                <label class="footer-field-label" for="footer-facebook">Facebook URL</label>
                <input type="text" class="footer-field-input" id="footer-facebook" name="facebook_url"
                    placeholder="https://facebook.com/yourpage"
                    value="{{ old('facebook_url', $footer['facebook_url']) }}">
                <span class="footer-error-msg">@error('facebook_url'){{ $message }}@enderror</span>
            </div>
        </div>
    </div>

    <div class="footer-social-item">
        <div class="footer-social-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.04-2.83.18-.76 1.22-5.17 1.22-5.17s-.31-.62-.31-1.55c0-1.45.84-2.54 1.89-2.54.89 0 1.32.67 1.32 1.47 0 .9-.57 2.24-.87 3.48-.25 1.04.52 1.89 1.54 1.89 1.85 0 3.09-2.37 3.09-5.17 0-2.14-1.44-3.63-3.5-3.63-2.38 0-3.78 1.79-3.78 3.63 0 .72.28 1.49.62 1.91.07.08.08.15.06.24-.06.26-.2.82-.23.93-.04.15-.13.18-.3.11-1.12-.52-1.82-2.17-1.82-3.49 0-2.84 2.06-5.45 5.94-5.45 3.12 0 5.55 2.22 5.55 5.19 0 3.1-1.95 5.59-4.66 5.59-.91 0-1.77-.47-2.06-1.03l-.56 2.09c-.2.78-.75 1.75-1.12 2.34.85.26 1.74.4 2.67.4 5.52 0 10-4.48 10-10S17.52 2 12 2z"/>
            </svg>
        </div>
        <div class="footer-social-content">
            <div class="footer-field @error('pinterest_url') error @enderror" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
                <label class="footer-field-label" for="footer-pinterest">Pinterest URL</label>
                <input type="text" class="footer-field-input" id="footer-pinterest" name="pinterest_url"
                    placeholder="https://pinterest.com/yourprofile"
                    value="{{ old('pinterest_url', $footer['pinterest_url']) }}">
                <span class="footer-error-msg">@error('pinterest_url'){{ $message }}@enderror</span>
            </div>
        </div>
    </div>
</div>

{{-- Card 4: Copyright & Legal --}}
<div class="pm-card">
    <div class="footer-lang-group">
        <div class="footer-section-title">Copyright Text</div>
        <div class="footer-field @error('copyright_text') error @enderror" style="margin-bottom:8px;">
            <label class="footer-field-label" for="footer-copyright">🇬🇧 English</label>
            <input type="text" class="footer-field-input" id="footer-copyright" name="copyright_text"
                placeholder="© 2026 Your Company. All rights reserved."
                value="{{ old('copyright_text', $footer['copyright_text']) }}">
            <span class="footer-error-msg">@error('copyright_text'){{ $message }}@enderror</span>
        </div>
        <div class="footer-field @error('copyright_text_id') error @enderror" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
            <label class="footer-field-label" for="footer-copyright-id">🇮🇩 Indonesian</label>
            <input type="text" class="footer-field-input" id="footer-copyright-id" name="copyright_text_id"
                placeholder="© 2026 Perusahaan Anda. Seluruh hak cipta dilindungi."
                value="{{ old('copyright_text_id', $footer['copyright_text_id'] ?? '') }}">
            <span class="footer-error-msg">@error('copyright_text_id'){{ $message }}@enderror</span>
        </div>
    </div>

    <div class="footer-grid-wrap">
        <div class="footer-section-title" style="margin-bottom:12px;">Legal URLs</div>
        <div class="footer-grid">
            <div class="footer-field @error('privacy_url') error @enderror">
                <label class="footer-field-label" for="footer-privacy">Privacy Policy URL</label>
                <input type="text" class="footer-field-input" id="footer-privacy" name="privacy_url"
                    placeholder="/legal/privacy-policy"
                    value="{{ old('privacy_url', $footer['privacy_url']) }}">
                <span class="footer-error-msg">@error('privacy_url'){{ $message }}@enderror</span>
            </div>
            <div class="footer-field @error('terms_url') error @enderror">
                <label class="footer-field-label" for="footer-terms">Terms &amp; Conditions URL</label>
                <input type="text" class="footer-field-input" id="footer-terms" name="terms_url"
                    placeholder="/legal/terms"
                    value="{{ old('terms_url', $footer['terms_url']) }}">
                <span class="footer-error-msg">@error('terms_url'){{ $message }}@enderror</span>
            </div>
        </div>
    </div>
</div>

<div class="pm-footer-actions">
    <a href="{{ route('admin.settings', ['section' => 'general']) }}" class="pm-btn-cancel">Cancel</a>
    <button type="submit" class="pm-btn-save">Save Footer</button>
</div>

</form>