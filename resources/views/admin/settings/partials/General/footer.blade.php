{{-- resources/views/admin/settings/partials/General/footer.blade.php --}}
{{-- Pure Frontend — self-contained, semua footer-* style ada di sini --}}

<style>
/* ════════════════════════════════════════════════
   PM-* BASE STYLES (sama persis dengan profile.blade.php)
   ════════════════════════════════════════════════ */

.pm-back-link {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; color: #4a7c3f; text-decoration: none;
    margin-bottom: 20px; font-weight: 500; transition: color 0.15s;
}
.pm-back-link:hover { color: #2d4a1e; }
.pm-back-link svg { flex-shrink: 0; }

.pm-page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 6px; }
.pm-page-title  { font-size: 26px; font-weight: 700; color: #1a3a2a; margin: 0; }
.pm-page-subtitle { color: #7a857f; font-size: 13.5px; margin: 0 0 24px; }

.pm-card { background: #fff; border: 1px solid #e5e9e6; border-radius: 8px; padding: 24px 28px; margin-bottom: 16px; }

.pm-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 28px; }
.pm-btn-cancel {
    padding: 10px 24px; border-radius: 2px; border: none;
    background: #D9864A; color: #fff; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: background .15s; font-family: inherit;
}
.pm-btn-cancel:hover { background: #c4733a; }
.pm-btn-save {
    padding: 10px 24px; border-radius: 2px; border: none;
    background: #1A3D0A; color: #fff; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: background .15s; font-family: inherit;
}
.pm-btn-save:hover { background: #2d5a1a; }

/* ════════════════════════════════════════════════
   FOOTER-SPECIFIC STYLES
   ════════════════════════════════════════════════ */

/* Info box */
.footer-info-box {
    display: flex; align-items: flex-start; gap: 10px;
    font-size: 13.5px; color: #5e655f; line-height: 1.5;
}
.footer-info-icon {
    width: 20px; height: 20px; flex-shrink: 0;
    border-radius: 50%; border: 1.5px solid #4B9960; color: #4B9960;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; margin-top: 1px;
}

/* Section title */
.footer-section-title {
    font-size: 11.5px; font-weight: 700; letter-spacing: .14em;
    color: #5a6b62; margin-bottom: 22px; text-transform: uppercase;
}

/* Fields — sama persis dengan prof-field */
.footer-field { padding: 12px 0 14px; border-bottom: 1.5px solid #e0e6e2; margin-bottom: 16px; }
.footer-field:last-child { margin-bottom: 0; }
.footer-field-label { font-size: 12px; color: #8a9690; font-weight: 500; margin-bottom: 6px; display: block; }
.footer-field-input,
.footer-field-textarea {
    width: 100%; border: none; outline: none;
    font-size: 14.5px; color: #1a3d0a; background: transparent;
    font-family: inherit; padding: 0;
}
.footer-field-input::placeholder,
.footer-field-textarea::placeholder { color: #c0ccc5; }
.footer-field-textarea { resize: vertical; min-height: 60px; line-height: 1.55; }

/* Grid untuk Privacy & Terms */
.footer-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 32px; }
.footer-grid .footer-field { margin-bottom: 0; }
@media (max-width: 600px) { .footer-grid { grid-template-columns: 1fr; } }

/* Social item */
.footer-social-item { display: flex; align-items: flex-start; gap: 14px; }
.footer-social-icon {
    width: 38px; height: 38px; border-radius: 50%;
    background: #f5f6f3; border: 1px solid #e5e9e6;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 14px;
}
.footer-social-icon svg { color: #5a6b62; }
.footer-social-content { flex: 1; }

@media (max-width: 600px) {
    .pm-footer { flex-direction: column-reverse; }
    .pm-btn-cancel, .pm-btn-save { width: 100%; }
}
</style>

{{-- ── Back link ── --}}
<a href="{{ route('admin.settings', ['section' => 'general']) }}" class="pm-back-link">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
    </svg>
    Back to General Settings
</a>

{{-- ── Page heading ── --}}
<div class="pm-page-header">
    <div>
        <h2 class="pm-page-title">Footer Settings</h2>
        <p class="pm-page-subtitle" style="margin-top:4px;">Manage footer description, social links, and copyright texts.</p>
    </div>
</div>

{{-- ══════════════════════════════════
     INFO CARD
══════════════════════════════════ --}}
<div class="pm-card">
    <div class="footer-info-box">
        <div class="footer-info-icon">i</div>
        <span>Contact details in the footer are automatically synced from the 'Location &amp; Contact' settings.</span>
    </div>
</div>

{{-- ══════════════════════════════════
     CARD 1 — Brand & Newsletter
══════════════════════════════════ --}}
<div class="pm-card">
    <div class="footer-field">
        <label class="footer-field-label" for="footer-brand-desc">Brand Description (Under Logo)</label>
        <textarea class="footer-field-textarea" id="footer-brand-desc">A sanctuary where Javanese heritage meets modern ecological luxury, offering an immersive escape into the rhythmic beauty of Indonesia's nature.</textarea>
    </div>

    <div class="footer-field">
        <label class="footer-field-label" for="footer-newsletter">Journal / Newsletter Text</label>
        <input type="text" class="footer-field-input" id="footer-newsletter" value="Subscribe for seasonal updates and exclusive retreat offers.">
    </div>
</div>

{{-- ══════════════════════════════════
     CARD 2 — Social Media
══════════════════════════════════ --}}
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
            <div class="footer-field" style="margin-bottom:0">
                <label class="footer-field-label" for="footer-instagram">Instagram URL</label>
                <input type="text" class="footer-field-input" id="footer-instagram" value="https://instagram.com/alasare.eco">
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
            <div class="footer-field" style="margin-bottom:0">
                <label class="footer-field-label" for="footer-facebook">Facebook URL</label>
                <input type="text" class="footer-field-input" id="footer-facebook" value="https://facebook.com/alasarehostel">
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
            <div class="footer-field" style="margin-bottom:0">
                <label class="footer-field-label" for="footer-pinterest">Pinterest URL</label>
                <input type="text" class="footer-field-input" id="footer-pinterest" value="https://pinterest.com/alasaredesign">
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════
     CARD 3 — Copyright & Legal
══════════════════════════════════ --}}
<div class="pm-card">
    <div class="footer-field">
        <label class="footer-field-label" for="footer-copyright">Copyright Text</label>
        <input type="text" class="footer-field-input" id="footer-copyright" value="© 2026 ALASARE ECO-SANCTUARY. ALL RIGHTS RESERVED.">
    </div>

    <div class="footer-grid">
        <div class="footer-field">
            <label class="footer-field-label" for="footer-privacy">Privacy Policy URL</label>
            <input type="text" class="footer-field-input" id="footer-privacy" value="/legal/privacy-policy">
        </div>
        <div class="footer-field">
            <label class="footer-field-label" for="footer-terms">Terms &amp; Conditions URL</label>
            <input type="text" class="footer-field-input" id="footer-terms" value="/legal/terms">
        </div>
    </div>
</div>

{{-- ── Footer ── --}}
<div class="pm-footer">
    <button class="pm-btn-cancel" onclick="footerHandleCancel()">Cancel</button>
    <button class="pm-btn-save" onclick="footerHandleSave()">Save Footer</button>
</div>


{{-- ════════════════════════════════
     JAVASCRIPT
════════════════════════════════ --}}
<script>
(function () {

    /* ── Cancel / Back ── */
    window.footerHandleCancel = function () {
        window.location.href = '{{ route("admin.settings", ["section" => "general"]) }}';
    };

    /* ── Save ── */
    window.footerHandleSave = function () {
        var brandDesc     = document.getElementById('footer-brand-desc').value.trim();
        var newsletterTxt = document.getElementById('footer-newsletter').value.trim();
        var instagramUrl  = document.getElementById('footer-instagram').value.trim();
        var facebookUrl   = document.getElementById('footer-facebook').value.trim();
        var pinterestUrl  = document.getElementById('footer-pinterest').value.trim();
        var copyrightTxt  = document.getElementById('footer-copyright').value.trim();
        var privacyUrl    = document.getElementById('footer-privacy').value.trim();
        var termsUrl      = document.getElementById('footer-terms').value.trim();

        var payload = {
            brandDesc, newsletterTxt,
            social: { instagram: instagramUrl, facebook: facebookUrl, pinterest: pinterestUrl },
            copyright: { text: copyrightTxt, privacyUrl, termsUrl }
        };

        console.log('Footer save payload:', payload);
        alert('Footer saved! (FE-only — lihat console untuk payload)');
    };

})();
</script>