{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/hero-section.blade.php --}}

@php
    $heroData = array_merge(\App\Models\LandingPageSetting::DEFAULTS['hero'], $heroSettings?->data ?? []);
    $bgImageUrl = !empty($heroData['bg_image'])
        ? asset('storage/' . $heroData['bg_image'])
        : asset('images/hero.png');
@endphp

{{-- ── Flash ── --}}
@if(session('success'))
    <div style="margin-bottom:16px; padding:12px 16px; background:#e6f4e6; border:1px solid #a3d4a3; border-radius:10px; color:#2e7d32; font-size:13px; font-weight:600;">
        ✓ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="margin-bottom:16px; padding:12px 16px; background:#fdecea; border:1px solid #f5a5a5; border-radius:10px; color:#c62828; font-size:13px;">
        @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
    </div>
@endif

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Hero Section</h2>

<form method="POST"
      action="{{ route('admin.landing.hero.update') }}"
      enctype="multipart/form-data"
      id="heroForm">
    @csrf
    @method('PUT')

    {{-- ── Background Image ── --}}
    <div class="lp-card">
        <h3 style="font-size:17px; font-weight:600; color:#1a3d0a; margin:0 0 16px;">
            Background Image
        </h3>

        {{-- Preview --}}
        <div class="lp-image-wrap landscape" id="heroImgWrap"
             style="{{ empty($heroData['bg_image']) ? 'display:none;' : '' }}">
            <img src="{{ $bgImageUrl }}"
                 alt="Hero Background" id="heroImgPreview"
                 style="height:280px; width:100%; object-fit:cover;">
        </div>

        {{-- Placeholder kalau belum ada gambar --}}
        <div id="heroImgPlaceholder"
             style="{{ !empty($heroData['bg_image']) ? 'display:none;' : '' }}
                    height:180px; background:#f0f4ee; border-radius:10px;
                    display:flex; align-items:center; justify-content:center;
                    color:#9aaa96; font-size:13px; margin-bottom:14px; border:1.5px dashed #c4d0c0;">
            Belum ada gambar background
        </div>

        <div class="lp-image-controls">
            <label class="lp-upload-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                </svg>
                Upload Image
                <input type="file" name="bg_image" accept="image/*"
                       onchange="previewHeroBg(this)">
            </label>

            @if(!empty($heroData['bg_image']))
            <button type="button" class="lp-remove-btn" onclick="removeHeroBg()">
                Remove
            </button>
            @endif
        </div>

        {{-- Hidden flag for remove action --}}
        <input type="hidden" name="remove_bg_image" id="removeBgFlag" value="0">

        <p class="lp-image-hint" style="margin-top:8px;">
            Recommended size: 1920×1080px. Max 2MB.
        </p>
    </div>

    {{-- ── Text Content ── --}}
    <div class="lp-card">
        <h3 style="font-size:17px; font-weight:600; color:#1a3d0a; margin:0 0 20px;">
            Main Headline
        </h3>
        <div class="lp-field">
            <input type="text" class="lp-input" name="headline"
                   value="{{ old('headline', $heroData['headline']) }}"
                   maxlength="150" required>
        </div>

        <h3 style="font-size:17px; font-weight:600; color:#1a3d0a; margin:24px 0 20px;">
            Sub-headline
        </h3>
        <div class="lp-field">
            <textarea class="lp-textarea" name="subheadline"
                      maxlength="200" id="heroSubheadline" rows="3"
                      oninput="updateCharCount(this,'heroSubCount',200)"
                      required>{{ old('subheadline', $heroData['subheadline']) }}</textarea>
            <div class="lp-char-counter">
                <span id="heroSubCount">{{ strlen(old('subheadline', $heroData['subheadline'])) }}</span>
                / 200 characters
            </div>
        </div>

        <div class="lp-form-footer">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
               class="btn btn-orange-outline">Cancel</a>
            <button type="submit" class="btn btn-dark">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Save Changes
            </button>
        </div>
    </div>

</form>

{{-- ── Last saved metadata ── --}}
@if($heroSettings?->updated_at)
<div class="lp-status-bar">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved:
        <span style="color:#5a6a58;">
            {{ $heroSettings->updated_at->format('M j, Y') }}
            at {{ $heroSettings->updated_at->format('H:i') }}
            @if($heroSettings->editor) by {{ $heroSettings->editor->name }} @endif
        </span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">All systems operational</span>
    </div>
</div>
@endif

<script>
function updateCharCount(el, countId, max) {
    document.getElementById(countId).textContent = el.value.length;
}

function previewHeroBg(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const wrap    = document.getElementById('heroImgWrap');
        const img     = document.getElementById('heroImgPreview');
        const ph      = document.getElementById('heroImgPlaceholder');
        img.src             = e.target.result;
        wrap.style.display  = 'block';
        ph.style.display    = 'none';
        // Reset remove flag
        document.getElementById('removeBgFlag').value = '0';
    };
    reader.readAsDataURL(input.files[0]);
}

function removeHeroBg() {
    if (!confirm('Hapus background image?')) return;
    document.getElementById('heroImgWrap').style.display   = 'none';
    document.getElementById('heroImgPlaceholder').style.display = 'flex';
    document.getElementById('removeBgFlag').value          = '1';
    // Clear file input
    const fileInput = document.querySelector('input[name="bg_image"]');
    if (fileInput) fileInput.value = '';
}

// Init char count
document.addEventListener('DOMContentLoaded', () => {
    const ta = document.getElementById('heroSubheadline');
    if (ta) updateCharCount(ta, 'heroSubCount', 200);
});
</script>