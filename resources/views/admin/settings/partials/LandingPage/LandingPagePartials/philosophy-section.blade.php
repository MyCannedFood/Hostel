{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/philosophy-section.blade.php --}}

@php $philosophySettings ??= null; @endphp

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:6px;">Edit Our Philosophy Section</h2>
<p style="color:#7a857f; font-size:13px; margin:0 0 24px;">Manage content, features, and the vertical side image.</p>

<form method="POST" action="#" enctype="multipart/form-data" id="philosophyForm">
    @csrf @method('PUT')

    <div class="lp-card">
        <div class="lp-philosophy-grid">

            {{-- ── LEFT: Text content ── --}}
            <div>
                <div class="lp-field">
                    <label class="lp-field-label">Section Tagline (Overline)</label>
                    <input type="text" class="lp-input" name="tagline"
                           value="{{ $philosophySettings->tagline ?? 'OUR PHILOSOPHY' }}">
                </div>

                <div class="lp-field">
                    <label class="lp-field-label">Main Heading</label>
                    <input type="text" class="lp-input lp-heading-input" name="heading"
                           value="{{ $philosophySettings->heading ?? 'Breathing with the Earth' }}">
                </div>

                <div class="lp-field">
                    <label class="lp-field-label">Description Paragraph</label>
                    <textarea class="lp-textarea" name="description"
                              rows="6">{{ $philosophySettings->description ?? 'Our architecture follows a strict 4:1 land ratio, ensuring that for every square meter of built space, four remain wild. We utilize traditional Javanese structures designed to breathe naturally without modern air conditioning, fostering a deep connection between the traveler and the Indonesian landscape.' }}</textarea>
                </div>

                {{-- ── Featured Icons & Labels ── --}}
                <div style="margin-top:8px;">
                    <p class="lp-features-label">Featured Icons &amp; Labels</p>

                    <div id="featuresList">
                        @php
                        $features = $philosophySettings->features ?? [
                            ['icon' => '🌿', 'label' => 'Minimal Footprint'],
                            ['icon' => '🌱', 'label' => 'Rewilding Project'],
                        ];
                        @endphp
                        @foreach($features as $i => $feat)
                        <div class="lp-feature-item" data-index="{{ $i }}">
                            <div class="lp-feature-icon">{{ $feat['icon'] }}</div>
                            <input type="text" class="lp-feature-input"
                                   name="features[{{ $i }}][label]"
                                   value="{{ $feat['label'] }}"
                                   placeholder="Feature label">
                            <input type="hidden" name="features[{{ $i }}][icon]" value="{{ $feat['icon'] }}">
                            <button type="button" class="action-btn delete"
                                    onclick="removeFeature(this)" title="Remove">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="lp-add-feature-btn" onclick="addFeature()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
                        </svg>
                        + Add Feature
                    </button>
                </div>
            </div>

            {{-- ── RIGHT: Side Image ── --}}
            <div>
                <p class="lp-card-label" style="margin-bottom:12px;">Side Image (Portrait)</p>

                <div class="lp-image-wrap portrait" id="philoImgWrap">
                    <img src="{{ $philosophySettings->side_image ?? asset('images/gallery/forest-pathway.png') }}"
                         alt="Philosophy Side Image" id="philoImgPreview"
                         style="height:340px; width:100%; object-fit:cover;">
                </div>

                <div class="lp-image-controls" style="margin-top:14px;">
                    <label class="lp-upload-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                            <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                        </svg>
                        Change Image
                        <input type="file" name="side_image" accept="image/*"
                               onchange="previewLpImage(this,'philoImgPreview')">
                    </label>
                    <button type="button" class="lp-remove-btn"
                            onclick="removeLpImage('philoImgPreview','philoImgWrap')">
                        Remove
                    </button>
                </div>

                <div class="lp-info-box" style="margin-top:12px;">
                    <span class="lp-info-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                        </svg>
                    </span>
                    Recommended dimensions: 1200×1800px. High-resolution portrait imagery of the landscape or architecture works best here.
                </div>
            </div>

        </div>{{-- /grid --}}

        <div class="lp-form-footer">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
               class="btn btn-orange-outline">Cancel</a>
            <button type="submit" class="btn btn-dark">Save Changes</button>
        </div>
    </div>
</form>

<div class="lp-status-bar">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved: <span style="color:#5a6a58;">Today at 09:42 AM</span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">All systems operational</span>
    </div>
</div>

<script>
let featureCount = {{ count($features ?? [['icon'=>'🌿','label'=>''],['icon'=>'🌱','label'=>'']]) }};

function addFeature() {
    const list = document.getElementById('featuresList');
    const idx  = featureCount++;
    const div  = document.createElement('div');
    div.className = 'lp-feature-item';
    div.dataset.index = idx;
    div.innerHTML = `
        <div class="lp-feature-icon">🌿</div>
        <input type="text" class="lp-feature-input"
               name="features[${idx}][label]" placeholder="Feature label">
        <input type="hidden" name="features[${idx}][icon]" value="🌿">
        <button type="button" class="action-btn delete" onclick="removeFeature(this)" title="Remove">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14H6L5 6"/>
                <path d="M10 11v6M14 11v6"/>
            </svg>
        </button>`;
    list.appendChild(div);
}

function removeFeature(btn) {
    btn.closest('.lp-feature-item').remove();
}
</script>