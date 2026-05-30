{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/philosophy-section.blade.php --}}

@php
    $philosophySettings ??= null;

    // Merge DB data dengan DEFAULTS — key baru (body_1, body_2, badge_*)
    // tetap ada walau DB record dibuat sebelum kolom ini ditambahkan
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['philosophy'],
        $philosophySettings?->data ?? []
    );

    $features   = $d['features']  ?? [];
    $sideImgUrl = !empty($d['side_image'])
        ? asset('storage/' . $d['side_image'])
        : asset('images/Philosophy.png');
@endphp

{{-- ── Flash ── --}}
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

<h2 class="section-title" style="margin-bottom:6px;">Edit Our Philosophy Section</h2>
<p style="color:#7a857f;font-size:13px;margin:0 0 24px;">
    Manage content, features, and the vertical side image.
</p>

<form method="POST"
      action="{{ route('admin.landing.philosophy.update') }}"
      enctype="multipart/form-data"
      id="philosophyForm">
    @csrf @method('PUT')

    <div class="lp-card">
        <div class="lp-philosophy-grid">

            {{-- ════════ LEFT: Text ════════ --}}
            <div>
                <div class="lp-field">
                    <label class="lp-field-label">Section Tagline (Overline)</label>
                    <input type="text" class="lp-input" name="tagline"
                           value="{{ old('tagline', $d['tagline']) }}" maxlength="100">
                </div>

                <div class="lp-field">
                    <label class="lp-field-label">Main Heading</label>
                    <input type="text" class="lp-input lp-heading-input" name="heading"
                           value="{{ old('heading', $d['heading']) }}" maxlength="200">
                </div>

                <div class="lp-field">
                    <label class="lp-field-label">Description Paragraph 1</label>
                    <textarea class="lp-textarea" name="body_1" rows="4"
                              maxlength="600">{{ old('body_1', $d['body_1']) }}</textarea>
                </div>

                <div class="lp-field">
                    <label class="lp-field-label">
                        Description Paragraph 2
                        <span style="font-weight:400;color:#b0b8b0;">(optional)</span>
                    </label>
                    <textarea class="lp-textarea" name="body_2" rows="4"
                              maxlength="600">{{ old('body_2', $d['body_2'] ?? '') }}</textarea>
                </div>

                {{-- ── Features ── --}}
                <div style="margin-top:8px;">
                    <p class="lp-features-label">Featured Icons &amp; Labels</p>

                    <div id="featuresList">
                        @foreach($features as $i => $feat)
                        <div class="lp-feature-item" data-index="{{ $i }}">

                            {{-- Icon preview / upload --}}
                            <label style="cursor:pointer;flex-shrink:0;" title="Klik untuk ganti icon">
                                <div class="lp-feature-icon" id="iconPreview_{{ $i }}"
                                     style="background:#f0f4ee;overflow:hidden;">
                                    @if(!empty($feat['icon_path']))
                                        <img src="{{ asset('storage/'.$feat['icon_path']) }}"
                                             alt="" style="width:20px;height:20px;object-fit:contain;">
                                    @else
                                        <svg width="14" height="14" fill="none" stroke="#4a7c3f" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 2a4 4 0 0 1 4 4c0 4-4 8-4 8S8 10 8 6a4 4 0 0 1 4-4z"/>
                                        </svg>
                                    @endif
                                </div>
                                <input type="file" name="features[{{ $i }}][icon]"
                                       accept="image/png,image/jpeg,image/svg+xml"
                                       style="display:none"
                                       onchange="previewFeatureIcon(this, {{ $i }})">
                            </label>

                            <input type="hidden" name="features[{{ $i }}][icon_path]"
                                   value="{{ $feat['icon_path'] ?? '' }}">

                            <div style="flex:1;display:flex;flex-direction:column;gap:6px;">
                                <input type="text" class="lp-feature-input"
                                       name="features[{{ $i }}][title]"
                                       value="{{ $feat['title'] }}"
                                       placeholder="Feature title (e.g. Minimal Footprint)"
                                       style="font-weight:600;font-size:14px;">
                                <input type="text" class="lp-feature-input"
                                       name="features[{{ $i }}][description]"
                                       value="{{ $feat['description'] ?? '' }}"
                                       placeholder="Short description..."
                                       style="font-size:12px;color:#7a857f;">
                            </div>

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

                {{-- ── Badge ── --}}
                <div style="margin-top:28px;padding-top:20px;border-top:1px solid #f0f4ee;">
                    <p class="lp-features-label">Conservation Badge</p>
                    <div style="display:flex;gap:16px;">
                        <div class="lp-field" style="flex:1;margin-bottom:0;">
                            <label class="lp-field-label">Badge Label</label>
                            <input type="text" class="lp-input" name="badge_label"
                                   value="{{ old('badge_label', $d['badge_label'] ?? 'Conservation') }}"
                                   placeholder="e.g. Conservation">
                        </div>
                        <div class="lp-field" style="flex:1;margin-bottom:0;">
                            <label class="lp-field-label">Badge Value</label>
                            <input type="text" class="lp-input" name="badge_value"
                                   value="{{ old('badge_value', $d['badge_value'] ?? '80% Forest Cover') }}"
                                   placeholder="e.g. 80% Forest Cover">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════ RIGHT: Side Image ════════ --}}
            <div>
                <p class="lp-card-label" style="margin-bottom:12px;">Side Image (Portrait)</p>

                <div class="lp-image-wrap portrait" id="philoImgWrap"
                     style="{{ empty($d['side_image']) ? '' : '' }}">
                    <img src="{{ $sideImgUrl }}" alt="Philosophy Side Image"
                         id="philoImgPreview"
                         style="height:340px;width:100%;object-fit:cover;">
                </div>

                <input type="hidden" name="remove_side_image" id="removeSideFlag" value="0">

                <div class="lp-image-controls" style="margin-top:14px;">
                    <label class="lp-upload-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                            <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                        </svg>
                        Change Image
                        <input type="file" name="side_image" accept="image/*"
                               onchange="previewPhiloSide(this)" style="display:none">
                    </label>
                    <button type="button" class="lp-remove-btn"
                            onclick="removeSideImage()">Remove</button>
                </div>

                <div class="lp-info-box" style="margin-top:12px;">
                    <span class="lp-info-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                        </svg>
                    </span>
                    Recommended: 1200×1800px. High-resolution portrait of landscape or architecture.
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

{{-- ── Last saved ── --}}
@if($philosophySettings?->updated_at)
<div class="lp-status-bar">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved:
        <span style="color:#5a6a58;">
            {{ $philosophySettings->updated_at->format('M j, Y') }}
            at {{ $philosophySettings->updated_at->format('H:i') }}
        </span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">All systems operational</span>
    </div>
</div>
@endif

<script>
let featureCount = {{ count($features) }};

function addFeature() {
    const idx  = featureCount++;
    const list = document.getElementById('featuresList');
    const div  = document.createElement('div');
    div.className     = 'lp-feature-item';
    div.dataset.index = idx;
    div.innerHTML = `
        <label style="cursor:pointer;flex-shrink:0;" title="Klik untuk upload icon">
            <div class="lp-feature-icon" id="iconPreview_${idx}"
                 style="background:#f0f4ee;overflow:hidden;">
                <svg width="14" height="14" fill="none" stroke="#4a7c3f" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2a4 4 0 0 1 4 4c0 4-4 8-4 8S8 10 8 6a4 4 0 0 1 4-4z"/>
                </svg>
            </div>
            <input type="file" name="features[${idx}][icon]"
                   accept="image/png,image/jpeg,image/svg+xml"
                   style="display:none"
                   onchange="previewFeatureIcon(this, ${idx})">
        </label>
        <input type="hidden" name="features[${idx}][icon_path]" value="">
        <div style="flex:1;display:flex;flex-direction:column;gap:6px;">
            <input type="text" class="lp-feature-input"
                   name="features[${idx}][title]"
                   placeholder="Feature title"
                   style="font-weight:600;font-size:14px;">
            <input type="text" class="lp-feature-input"
                   name="features[${idx}][description]"
                   placeholder="Short description..."
                   style="font-size:12px;color:#7a857f;">
        </div>
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

function previewFeatureIcon(input, idx) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const wrap = document.getElementById('iconPreview_' + idx);
        wrap.innerHTML = `<img src="${e.target.result}"
                              style="width:20px;height:20px;object-fit:contain;">`;
    };
    reader.readAsDataURL(input.files[0]);
}

function previewPhiloSide(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('philoImgPreview').src = e.target.result;
        document.getElementById('removeSideFlag').value = '0';
    };
    reader.readAsDataURL(input.files[0]);
}

function removeSideImage() {
    if (!confirm('Hapus side image?')) return;
    document.getElementById('philoImgPreview').src = '';
    document.getElementById('philoImgWrap').style.display = 'none';
    document.getElementById('removeSideFlag').value = '1';
    document.querySelector('input[name="side_image"]').value = '';
}
</script>