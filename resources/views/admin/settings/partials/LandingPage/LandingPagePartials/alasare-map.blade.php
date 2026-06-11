@php
    $mapSettings ??= null;
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['map'],
        $mapSettings?->data ?? []
    );
    $mapImageUrl = !empty($d['map_image'])
        ? asset('storage/' . $d['map_image'])
        : asset('map-alasare.png');
@endphp

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#e6f4e6;border:1px solid #a3d4a3;border-radius:10px;color:#2e7d32;font-size:13px;font-weight:600;">
        ✓ {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;border:1px solid #f5a5a5;border-radius:10px;color:#c62828;font-size:13px;">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
    </div>
@endif

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit AlaSare Map</h2>

<form method="POST"
      action="{{ route('admin.landing.map.update') }}"
      enctype="multipart/form-data"
      id="mapForm">
    @csrf @method('PUT')

    {{-- ── Section Labels (Bilingual Layout) ── --}}
    <div class="lp-card" style="margin-bottom:16px;">
        <p class="lp-card-label" style="color: #4a5568; font-weight: 700; margin-bottom: 16px;">Section Labels</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            {{-- English Content --}}
            <div>
                <span style="font-size: 11px; font-weight: bold; color: #718096; text-transform: uppercase; display: block; margin-bottom: 10px;">English Content</span>
                
                <div class="lp-field">
                    <label class="lp-field-label">Subtitle <span style="font-weight:400;color:#b0b8b0;">(EN)</span></label>
                    <input type="text" class="lp-input" name="subtitle"
                           value="{{ old('subtitle', $d['subtitle'] ?? '') }}"
                           maxlength="100" placeholder="e.g. Explore the Ground">
                </div>

                <div class="lp-field" style="margin-bottom:0;">
                    <label class="lp-field-label">Section Title <span style="font-weight:400;color:#b0b8b0;">(EN)</span></label>
                    <input type="text" class="lp-input lp-heading-input" name="title"
                           value="{{ old('title', $d['title'] ?? '') }}"
                           maxlength="200" placeholder="e.g. AlaSare Map">
                </div>
            </div>

            {{-- Indonesian Content --}}
            <div>
                <span style="font-size: 11px; font-weight: bold; color: #718096; text-transform: uppercase; display: block; margin-bottom: 10px;">Indonesian Content</span>
                
                <div class="lp-field">
                    <label class="lp-field-label">Subtitle <span style="font-weight:400;color:#b0b8b0;">(ID)</span></label>
                    <input type="text" class="lp-input" name="subtitle_id"
                           value="{{ old('subtitle_id', $d['subtitle_id'] ?? '') }}"
                           maxlength="100" placeholder="misal: Jelajahi Area">
                </div>

                <div class="lp-field" style="margin-bottom:0;">
                    <label class="lp-field-label">Section Title <span style="font-weight:400;color:#b0b8b0;">(ID)</span></label>
                    <input type="text" class="lp-input lp-heading-input" name="title_id"
                           value="{{ old('title_id', $d['title_id'] ?? '') }}"
                           maxlength="200" placeholder="misal: Peta AlaSare">
                </div>
            </div>

        </div>
    </div>

    {{-- ── Map Image ── --}}
    <div class="lp-card">
        <p class="lp-card-label">Map Image (Landscape)</p>

        {{-- Preview Area --}}
        <div class="lp-image-wrap landscape" id="mapImgWrap">
            <img src="{{ $mapImageUrl }}"
                 alt="AlaSare Map" id="mapImgPreview"
                 style="height:280px;width:100%;object-fit:cover;border-radius:0;">
        </div>

        <input type="hidden" name="remove_map_image" id="removeMapFlag" value="0">

        <div class="lp-image-controls" style="margin-top:14px;">
            <label class="lp-upload-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                </svg>
                Upload New Map
                <input type="file" name="map_image" accept="image/*"
                       onchange="previewMapImage(this)" style="display:none">
            </label>
            <button type="button" class="lp-remove-btn" onclick="removeMapImage()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                </svg>
                Remove
            </button>
        </div>

        <div class="lp-info-box" style="margin-top: 16px;">
            <span class="lp-info-icon">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                </svg>
            </span>
            For the best visual experience, please use a high-resolution landscape image (at least 1920×820px).
            The map should clearly highlight the AlaSare landmarks using our brand's botanical color palette.
        </div>

        <div class="lp-form-footer" style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
               class="btn btn-orange-outline">Cancel</a>
            <button type="submit" class="btn btn-dark">Save Changes</button>
        </div>
    </div>

</form>

{{-- ── Metadata Footer ── --}}
<div class="lp-status-bar" style="margin-top:16px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last Updated:
        <span style="color:#5a6a58;">
            @if($mapSettings?->updated_at)
                {{ $mapSettings->updated_at->format('F j, Y') }} at {{ $mapSettings->updated_at->format('H:i') }}
                by {{ $d['updated_by_name'] ?? 'Admin' }}
            @else
                Belum pernah diupdate
            @endif
        </span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">Currently Published</span>
    </div>
</div>

<script>
function previewMapImage(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const wrap = document.getElementById('mapImgWrap');
        document.getElementById('mapImgPreview').src = e.target.result;
        wrap.style.display = 'block';
        document.getElementById('removeMapFlag').value = '0';
    };
    reader.readAsDataURL(input.files[0]);
}

function removeMapImage() {
    if (!confirm('Hapus gambar map?')) return;
    document.getElementById('mapImgWrap').style.display = 'none';
    document.getElementById('removeMapFlag').value = '1';
    document.querySelector('input[name="map_image"]').value = '';
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof initDropZone === 'function') {
        initDropZone('mapImgWrap', 'mapImgWrap', file => {
            const r = new FileReader();
            r.onload = e => {
                document.getElementById('mapImgPreview').src = e.target.result;
                document.getElementById('mapImgWrap').style.display = 'block';
                document.getElementById('removeMapFlag').value = '0';
            };
            r.readAsDataURL(file);
        });
    }
});
</script>