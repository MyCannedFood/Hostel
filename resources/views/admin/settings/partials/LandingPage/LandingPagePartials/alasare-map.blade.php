{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/alasare-map.blade.php --}}

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit AlaSare Map</h2>

<form method="POST" action="#" enctype="multipart/form-data" id="mapForm">
    @csrf @method('PUT')

    <div class="lp-card">
        <p class="lp-card-label">Map Image (Landscape)</p>

        <div class="lp-image-wrap landscape" id="mapImgWrap">
            <img src="{{ $mapSettings->map_image ?? asset('images/map/alasare-map.png') }}"
                 alt="AlaSare Map" id="mapImgPreview"
                 style="height:280px; width:100%; object-fit:cover;">
        </div>

        <div class="lp-image-controls" style="margin-top:14px;">
            <label class="lp-upload-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                </svg>
                Upload New Map
                <input type="file" name="map_image" accept="image/*"
                       onchange="previewLpImage(this,'mapImgPreview')">
            </label>
            <button type="button" class="lp-remove-btn"
                    onclick="removeLpImage('mapImgPreview','mapImgWrap')">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                </svg>
                Remove
            </button>
        </div>

        <div class="lp-info-box">
            <span class="lp-info-icon">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                </svg>
            </span>
            For the best visual experience, please use a high-resolution landscape image (at least 1920×820px).
            The map should clearly highlight the AlaSare landmarks using our brand's botanical color palette.
        </div>

        <div class="lp-form-footer">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
               class="btn btn-orange-outline">Cancel</a>
            <button type="submit" class="btn btn-dark">Save Changes</button>
        </div>
    </div>

</form>

{{-- ── Metadata footer ── --}}
<div class="lp-status-bar" style="margin-top:8px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last Updated:
        <span style="color:#5a6a58;">
            {{ $mapSettings->updated_at?->format('F j, Y') ?? 'October 12, 2023' }}
            by {{ $mapSettings->updatedBy ?? 'Admin' }}
        </span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">Currently Published</span>
    </div>
</div>