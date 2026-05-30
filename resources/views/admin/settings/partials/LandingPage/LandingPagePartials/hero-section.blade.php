{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/hero-section.blade.php --}}

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Hero Section</h2>

<form method="POST" action="#" enctype="multipart/form-data" id="heroForm">
    @csrf @method('PUT')

    <div class="lp-card">
        {{-- ── Background Image ── --}}
        <h3 style="font-size:17px; font-weight:600; color:#1a3d0a; margin:0 0 16px;">Background Image</h3>

        <div class="lp-image-wrap landscape" id="heroImgWrap">
            <img src="{{ $heroSettings->bg_image ?? asset('images/gallery/hero-gallery.png') }}"
                 alt="Hero Background" id="heroImgPreview"
                 style="max-height:280px; width:100%; object-fit:cover;">
        </div>

        <div class="lp-image-controls">
            <label class="lp-upload-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                </svg>
                Upload Image
                <input type="file" name="bg_image" accept="image/*"
                       onchange="previewLpImage(this,'heroImgPreview')">
            </label>
            <button type="button" class="lp-remove-btn" onclick="removeLpImage('heroImgPreview','heroImgWrap')">
                Remove
            </button>
        </div>
        <p class="lp-image-hint">Recommended size: 1920×1080px. Max 2MB.</p>
    </div>

    <div class="lp-card">
        {{-- ── Main Headline ── --}}
        <h3 style="font-size:17px; font-weight:600; color:#1a3d0a; margin:0 0 20px;">Main Headline</h3>
        <div class="lp-field">
            <input type="text" class="lp-input" name="headline"
                   value="{{ $heroSettings->headline ?? 'A Javanese Sanctuary, Woven by Nature' }}"
                   maxlength="100">
        </div>

        {{-- ── Sub-headline ── --}}
        <h3 style="font-size:17px; font-weight:600; color:#1a3d0a; margin:0 0 20px;">Sub-headline</h3>
        <div class="lp-field">
            <textarea class="lp-textarea" name="subheadline" maxlength="200"
                      id="heroSubheadline"
                      oninput="updateCharCount(this,'heroSubCount',200)"
                      rows="3">{{ $heroSettings->subheadline ?? 'Immerse in the timeless beauty of Nusantara culture, where architecture breathes with the forest.' }}</textarea>
            <div class="lp-char-counter">
                <span id="heroSubCount">{{ strlen($heroSettings->subheadline ?? 'Immerse in the timeless beauty of Nusantara culture, where architecture breathes with the forest.') }}</span> / 200 characters
            </div>
        </div>

        <div class="lp-form-footer">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
               class="btn btn-orange-outline">Cancel</a>
            <button type="submit" class="btn btn-dark">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
                Save Changes
            </button>
        </div>
    </div>
</form>

<script>
function updateCharCount(el, countId, max) {
    document.getElementById(countId).textContent = el.value.length;
}
// Init count on load
document.addEventListener('DOMContentLoaded', () => {
    const ta = document.getElementById('heroSubheadline');
    if (ta) updateCharCount(ta, 'heroSubCount', 200);
});
</script>