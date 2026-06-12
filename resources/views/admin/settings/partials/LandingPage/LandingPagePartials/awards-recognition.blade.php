@php
    $awardsSettings ??= null;
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['awards'],
        $awardsSettings?->data ?? []
    );
    $items       = $d['items'] ?? [];
    $visibleCount = collect($items)->where('is_visible', true)->count();
@endphp

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#e6f4e6;border:1px solid #a3d4a3;border-radius:0;color:#2e7d32;font-size:13px;font-weight:600;">
        ✓ {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;border:1px solid #f5a5a5;border-radius:0;color:#c62828;font-size:13px;">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
    </div>
@endif

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    &larr; Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:6px;">Edit Awards &amp; Recognition</h2>
<p style="color:#7a857f;font-size:13px;margin:0 0 24px;">
    Manage the accolades and certifications that highlight your commitment to sustainability and excellence.
</p>

<form method="POST"
      action="{{ route('admin.landing.awards.update') }}"
      enctype="multipart/form-data"
      id="awardsForm">
    @csrf @method('PUT')

    {{-- ── Section Title (Bilingual) ── --}}
    <div class="lp-card" style="border-radius:0; display: flex; flex-direction: column; gap: 16px;">
        <div class="lp-field" style="margin-bottom:0;">
            <label class="lp-field-label">Section Title (English)</label>
            <input type="text" class="lp-input lp-heading-input" name="section_title"
                   value="{{ old('section_title', $d['section_title'] ?? '') }}" maxlength="150" style="border-radius:0;">
        </div>

        <div class="lp-field" style="margin-bottom:0;">
            <label class="lp-field-label">Section Title (Indonesian)</label>
            <input type="text" class="lp-input lp-heading-input" name="section_title_id"
                   value="{{ old('section_title_id', $d['section_title_id'] ?? '') }}" maxlength="150" style="border-radius:0;" placeholder="Contoh: Penghargaan & Pengakuan">
        </div>
        
        <div style="display:flex;align-items:center;gap:6px;">
            <svg width="13" height="13" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
            </svg>
            <span style="font-size:12px;color:#d97706;">
                These titles will be displayed as the main headers based on selected language.
            </span>
        </div>
    </div>

    {{-- ── Awards List ── --}}
    <div class="lp-card" style="border-radius:0;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <p class="lp-card-label" style="margin:0;">Added Awards</p>
            <div style="display:flex;align-items:center;gap:8px;">
                <span id="visibleCountBadge"
                      style="font-size:12px;font-weight:700;padding:3px 10px;border-radius:0;
                             background:{{ $visibleCount >= 4 ? '#fdecea' : '#e6f4e6' }};
                             color:{{ $visibleCount >= 4 ? '#c62828' : '#2e7d32' }};">
                    {{ $visibleCount }}/4 tampil
                </span>
                <span style="font-size:12px;color:#9aaa96;">Max 4 di homepage</span>
            </div>
        </div>

        <div id="awardItemsList">
            @foreach($items as $i => $item)
            <div class="lp-flora-card-item" id="awardRow_{{ $i }}" data-index="{{ $i }}"
                 style="padding:14px 0;border-bottom:1px solid #f0f4ee; display:flex; align-items:center; gap:12px;">

                {{-- Icon Wrapper --}}
                <div class="icon-indicator-wrap" style="width:40px;height:40px;border-radius:0;background:#f0f4ee;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                    @if(!empty($item['icon_path']))
                        <img src="{{ asset('storage/'.$item['icon_path']) }}" class="row-img-preview"
                             style="width:24px;height:24px;object-fit:contain;">
                    @else
                        <svg width="20" height="20" fill="none" stroke="#4a7c3f" stroke-width="1.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="6"/>
                            <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                    @endif
                </div>

                {{-- Title + Sub (Menampilkan info EN & ID sekaligus di panel admin) ── --}}
                <div class="lp-flora-text" style="flex-grow:1;">
                    <div class="lp-flora-title" style="font-weight:600; color:#1a1a1a;">
                        {{ $item['title'] }} <span style="font-weight:400; color:#8a958f; font-size:12px;">/ {{ $item['title_id'] ?? '-' }}</span>
                    </div>
                    <div class="lp-flora-desc" style="font-size:12px; color:#7a857f;">
                        {{ $item['sub'] ?? '' }} <span style="color:#b0b8b0;">{{ !empty($item['sub_id']) ? '/ '.$item['sub_id'] : '' }}</span>
                    </div>
                </div>

                {{-- Visibility Toggle ── --}}
                <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
                    <span style="font-size:12px;color:#7a857f;">Tampil</span>
                    <label class="toggle-switch award-toggle" id="toggleLabel_{{ $i }}">
                        <input type="checkbox"
                               name="items[{{ $i }}][is_visible]"
                               value="1"
                               id="toggleInput_{{ $i }}"
                               class="award-visibility-cb"
                               data-index="{{ $i }}"
                               {{ ($item['is_visible'] ?? false) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                {{-- Actions ── --}}
                <div class="action-icons" style="display:flex; gap:8px;">
                    <button type="button" class="action-btn" title="Edit" onclick="editAwardFromRow(this)">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button type="button" class="action-btn delete" title="Delete" onclick="removeAward({{ $i }})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>

                {{-- Hidden data inputs Bilingual ── --}}
                <input type="hidden" name="items[{{ $i }}][icon_path]" class="h-icon-path" id="hAIconPath_{{ $i }}" value="{{ $item['icon_path'] ?? '' }}">
                <input type="hidden" name="items[{{ $i }}][title]"     class="h-title"     id="hATitle_{{ $i }}"     value="{{ $item['title'] ?? '' }}">
                <input type="hidden" name="items[{{ $i }}][title_id]"  class="h-title-id"  id="hATitleId_{{ $i }}"   value="{{ $item['title_id'] ?? '' }}">
                <input type="hidden" name="items[{{ $i }}][sub]"       class="h-sub"       id="hASub_{{ $i }}"       value="{{ $item['sub'] ?? '' }}">
                <input type="hidden" name="items[{{ $i }}][sub_id]"     class="h-sub-id"    id="hASubId_{{ $i }}"     value="{{ $item['sub_id'] ?? '' }}">
            </div>
            @endforeach
        </div>

        {{-- Add new award dashed button ── --}}
        <button type="button" class="lp-dashed-btn" style="margin-top:16px; border-radius:0;" onclick="openAwardModal()">
            + Add New Award
        </button>

        <div style="display:flex;justify-content:flex-end;gap:10px; margin-top:20px;padding-top:16px;border-top:1px solid #f0f4ee;">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="btn btn-orange-outline" style="border-radius:0;">Cancel</a>
            <button type="submit" class="btn btn-dark" style="border-radius:0;">Save Changes</button>
        </div>
    </div>
</form>

{{-- Last saved ── --}}
@if($awardsSettings?->updated_at)
<div class="lp-status-bar" style="margin-top:8px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved:
        <span style="color:#5a6a58;">
            {{ $awardsSettings->updated_at->format('M j, Y') }} at {{ $awardsSettings->updated_at->format('H:i') }}
        </span>
    </div>
</div>
@endif


{{-- ════ MODAL: Add / Edit Award (Bilingual) ════ --}}
<div class="modal-overlay" id="awardModal">
    <div class="modal-box" style="max-width:520px; border-radius:0;">
        <div class="modal-header">
            <h3 class="modal-title" id="awardModalTitle">Add New Award</h3>
            <button type="button" class="modal-close" onclick="closeModal('awardModal')">✕</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            <input type="hidden" id="editingAwardIndex" value="">

            {{-- Icon Upload ── --}}
            <div class="form-group">
                <label class="form-label">Award Icon <span style="font-weight:400;color:#b0b8b0;">(SVG/PNG)</span></label>
                <div style="display:flex;align-items:flex-start;gap:14px;">
                    <div style="width:72px;height:72px;border:1.5px dashed #c4d0c0;border-radius:0;
                                display:flex;flex-direction:column;align-items:center;justify-content:center;
                                background:#fafcfa;flex-shrink:0;cursor:pointer;overflow:hidden;"
                         id="awardIconPreviewWrap"
                         onclick="document.getElementById('awardIconFileInput').click()">
                        <div id="awardIconPlaceholder">
                            <svg width="22" height="22" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24" style="display:block;margin:0 auto;">
                                <circle cx="12" cy="8" r="6"/>
                                <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                            </svg>
                        </div>
                        <img id="awardIconPreview" src="" alt="" style="display:none;width:100%;height:100%;object-fit:contain;padding:6px;">
                    </div>
                    <div>
                        <label class="lp-upload-btn" style="display:inline-flex;margin-bottom:8px; border-radius:0;">
                            Upload Icon
                            <input type="file" id="awardIconFileInput" name="award_icon_upload"
                                   accept="image/svg+xml,image/png,image/jpeg" style="display:none"
                                   onchange="previewAwardIcon(this)">
                        </label>
                        <p style="font-size:12px;color:#9aaa96;margin:0;line-height:1.4;"> Preferred size 200×200px. </p>
                    </div>
                </div>
                <input type="hidden" id="modalAwardIconPath"    value="">
                <input type="hidden" id="modalAwardIconDataUrl" value="">
            </div>

            {{-- Title EN & ID ── --}}
            <div class="form-group">
                <label class="form-label">Award Title (English)</label>
                <input type="text" class="form-input" id="awardTitleInput" placeholder="e.g., Nature & Environment Award" style="border-radius:0;">
            </div>

            <div class="form-group">
                <label class="form-label">Award Title (Indonesian)</label>
                <input type="text" class="form-input" id="awardTitleIdInput" placeholder="Contoh: Penghargaan Alam & Lingkungan" style="border-radius:0;">
            </div>

            {{-- Sub EN & ID ── --}}
            <div class="form-group">
                <label class="form-label">Award Sub-label (English) <span style="font-weight:400;color:#b0b8b0;">(optional)</span></label>
                <input type="text" class="form-input" id="awardSubInput" placeholder="e.g., Gold Certified" style="border-radius:0;">
            </div>

            <div class="form-group">
                <label class="form-label">Award Sub-label (Indonesian) <span style="font-weight:400;color:#b0b8b0;">(opsional)</span></label>
                <input type="text" class="form-input" id="awardSubIdInput" placeholder="Contoh: Bersertifikat Emas" style="border-radius:0;">
            </div>

            <div class="modal-footer" style="margin-top: 10px;">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('awardModal')" style="border-radius:0;">Cancel</button>
                <button type="button" class="btn btn-dark" onclick="saveAward()" style="border-radius:0;">Save Award</button>
            </div>
        </div>
    </div>
</div>

<style>
.lp-dashed-btn {
    width:100%;padding:16px;border:1.5px dashed #c4d0c0;border-radius:0;
    background:#fafcfa;font-size:13px;font-weight:600;color:#4a7c3f;
    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;
    transition:border-color .15s,background .15s;
}
.lp-dashed-btn:hover { border-color:#4a7c3f;background:#f4f9f4; }
</style>

<script>
let awardCount = {{ count($items) }};
const MAX_VISIBLE = 4;

function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id){ document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) closeModal(el.id); });
});

function updateToggles() {
    const cbs     = Array.from(document.querySelectorAll('.award-visibility-cb'));
    const checked = cbs.filter(cb => cb.checked).length;
    const badge   = document.getElementById('visibleCountBadge');

    if (badge) {
        badge.textContent = `${checked}/4 tampil`;
        badge.style.background = checked >= MAX_VISIBLE ? '#fdecea' : '#e6f4e6';
        badge.style.color      = checked >= MAX_VISIBLE ? '#c62828' : '#2e7d32';
    }

    cbs.forEach(cb => {
        if (!cb.checked) {
            const disabled = checked >= MAX_VISIBLE;
            cb.disabled = disabled;
            const slider = cb.nextElementSibling;
            if (slider) {
                slider.style.opacity = disabled ? '0.35' : '1';
                slider.style.cursor  = disabled ? 'not-allowed' : 'pointer';
            }
        } else {
            cb.disabled = false;
            const slider = cb.nextElementSibling;
            if (slider) { slider.style.opacity = '1'; slider.style.cursor = 'pointer'; }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    updateToggles();
    document.getElementById('awardItemsList').addEventListener('change', e => {
        if (e.target.classList.contains('award-visibility-cb')) updateToggles();
    });
});

function openAwardModal(index, item, iconUrl) {
    const isEdit = index !== undefined && index !== '';
    document.getElementById('awardModalTitle').textContent = isEdit ? 'Edit Award' : 'Add New Award';
    document.getElementById('editingAwardIndex').value     = isEdit ? index : '';
    
    // Set bilingual value inputs
    document.getElementById('awardTitleInput').value       = item?.title ?? '';
    document.getElementById('awardTitleIdInput').value     = item?.title_id ?? '';
    document.getElementById('awardSubInput').value         = item?.sub   ?? '';
    document.getElementById('awardSubIdInput').value       = item?.sub_id   ?? '';
    
    document.getElementById('modalAwardIconPath').value    = item?.icon_path ?? '';
    document.getElementById('modalAwardIconDataUrl').value = '';
    document.getElementById('awardIconFileInput').value    = '';

    const preview = document.getElementById('awardIconPreview');
    const ph      = document.getElementById('awardIconPlaceholder');
    if (iconUrl) {
        preview.src = iconUrl; preview.style.display = 'block'; ph.style.display = 'none';
    } else {
        preview.style.display = 'none'; ph.style.display = 'block';
    }
    openModal('awardModal');
}

function editAwardFromRow(button) {
    const row = button.closest('.lp-flora-card-item');
    const index = row.dataset.index;
    const title = row.querySelector('.h-title').value;
    const title_id = row.querySelector('.h-title-id').value;
    const sub = row.querySelector('.h-sub').value;
    const sub_id = row.querySelector('.h-sub-id').value;
    const iconPath = row.querySelector('.h-icon-path').value;
    const imgEl = row.querySelector('.row-img-preview');
    const iconUrl = imgEl ? imgEl.src : '';

    openAwardModal(index, { title, title_id, sub, sub_id, icon_path: iconPath }, iconUrl);
}

function previewAwardIcon(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('awardIconPreview').src       = e.target.result;
        document.getElementById('awardIconPreview').style.display = 'block';
        document.getElementById('awardIconPlaceholder').style.display = 'none';
        document.getElementById('modalAwardIconDataUrl').value = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

function saveAward() {
    const idx      = document.getElementById('editingAwardIndex').value;
    const title    = document.getElementById('awardTitleInput').value.trim();
    const titleId  = document.getElementById('awardTitleIdInput').value.trim();
    const sub      = document.getElementById('awardSubInput').value.trim();
    const subId    = document.getElementById('awardSubIdInput').value.trim();
    const iconPath = document.getElementById('modalAwardIconPath').value;
    const dataUrl  = document.getElementById('modalAwardIconDataUrl').value;
    const fileIn   = document.getElementById('awardIconFileInput');

    if (!title || !titleId) { alert('Judul award (English & Indonesian) wajib diisi.'); return; }

    const isEdit = idx !== '';
    const i      = isEdit ? parseInt(idx) : awardCount++;
    const form   = document.getElementById('awardsForm');

    const currentCb = document.getElementById(`toggleInput_${i}`);
    const isVisible = currentCb ? currentCb.checked : false;

    function setHiddenInput(name, id, val) {
        let el = document.getElementById(id);
        if (!el) { el = document.createElement('input'); el.type='hidden'; el.name=name; el.id=id; form.appendChild(el); }
        el.value = val;
    }

    setHiddenInput(`items[${i}][icon_path]`, `hAIconPath_${i}`, iconPath);
    setHiddenInput(`items[${i}][title]`,     `hATitle_${i}`,     title);
    setHiddenInput(`items[${i}][title_id]`,  `hATitleId_${i}`,   titleId);
    setHiddenInput(`items[${i}][sub]`,       `hASub_${i}`,       sub);
    setHiddenInput(`items[${i}][sub_id]`,     `hASubId_${i}`,     subId);

    if (fileIn.files[0]) {
        document.getElementById(`hAFile_${i}`)?.remove();
        const newIn = document.createElement('input');
        newIn.type='file'; newIn.name=`items[${i}][icon]`; newIn.id=`hAFile_${i}`; newIn.style.display='none';
        const dt = new DataTransfer(); dt.items.add(fileIn.files[0]); newIn.files = dt.files;
        form.appendChild(newIn);
    }

    updateAwardRow(i, title, titleId, sub, subId, dataUrl || (iconPath ? `/storage/${iconPath}` : ''), iconPath, isVisible);
    closeModal('awardModal');
}

function updateAwardRow(i, title, titleId, sub, subId, iconSrc, iconPath, isVisible) {
    const list = document.getElementById('awardItemsList');
    let row    = document.getElementById(`awardRow_${i}`);

    if (!row) {
        row = document.createElement('div');
        row.className = 'lp-flora-card-item';
        row.id        = `awardRow_${i}`;
        row.dataset.index = i;
        row.style.cssText = 'padding:14px 0;border-bottom:1px solid #f0f4ee; display:flex; align-items:center; gap:12px;';
        list.appendChild(row);
    }

    const iconHtml = iconSrc
        ? `<img src="${iconSrc}" class="row-img-preview" style="width:24px;height:24px;object-fit:contain;">`
        : `<svg width="20" height="20" fill="none" stroke="#4a7c3f" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>`;

    row.innerHTML = `
        <div class="icon-indicator-wrap" style="width:40px;height:40px;border-radius:0;background:#f0f4ee;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
            ${iconHtml}
        </div>
        <div class="lp-flora-text" style="flex-grow:1;">
            <div class="lp-flora-title" style="font-weight:600; color:#1a1a1a;">${title} <span style="font-weight:400; color:#8a958f; font-size:12px;">/ ${titleId}</span></div>
            <div class="lp-flora-desc" style="font-size:12px; color:#7a857f;">${sub} <span style="color:#b0b8b0;">${subId ? '/ ' + subId : ''}</span></div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
            <span style="font-size:12px;color:#7a857f;">Tampil</span>
            <label class="toggle-switch award-toggle" id="toggleLabel_${i}">
                <input type="checkbox" name="items[${i}][is_visible]" value="1"
                       id="toggleInput_${i}" class="award-visibility-cb" data-index="${i}"
                       ${isVisible ? 'checked' : ''}>
                <span class="toggle-slider"></span>
            </label>
        </div>
        <div class="action-icons" style="display:flex; gap:8px;">
            <button type="button" class="action-btn" title="Edit" onclick="editAwardFromRow(this)">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button type="button" class="action-btn delete" title="Delete" onclick="removeAward(${i})">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
        </div>
        <input type="hidden" name="items[${i}][icon_path]" class="h-icon-path" id="hAIconPath_${i}" value="${iconPath ?? ''}">
        <input type="hidden" name="items[${i}][title]"     class="h-title"     id="hATitle_${i}"     value="${title}">
        <input type="hidden" name="items[${i}][title_id]"  class="h-title-id"  id="hATitleId_${i}"   value="${titleId}">
        <input type="hidden" name="items[${i}][sub]"       class="h-sub"       id="hASub_${i}"       value="${sub}">
        <input type="hidden" name="items[${i}][sub_id]"     class="h-sub-id"    id="hASubId_${i}"     value="${subId}">
    `;

    updateToggles();
}

function removeAward(i) {
    if (!confirm('Hapus award ini?')) return;
    document.getElementById(`awardRow_${i}`)?.remove();
    ['hAIconPath','hATitle','hATitleId','hASub','hASubId','hAFile'].forEach(p => document.getElementById(`${p}_${i}`)?.remove());
    updateToggles();
}
</script>