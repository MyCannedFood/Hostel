@php
    $floraSettings ??= null;
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['flora'],
        $floraSettings?->data ?? []
    );
    $cards = $d['cards'] ?? [];

    $defaultImages = [
        'images/flora-nourishment.png',
        'images/flora-aromatherapy.png',
        'images/flora-architecture.png',
    ];
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

<h2 class="section-title" style="margin-bottom:24px;">Edit The Flora Concept</h2>

<form method="POST"
      action="{{ route('admin.landing.flora.update') }}"
      enctype="multipart/form-data"
      id="floraForm">
    @csrf @method('PUT')

    {{-- ── Section Header (Bilingual Split) ── --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        
        {{-- English Content --}}
        <div class="lp-card" style="margin-bottom: 0;">
            <p class="lp-card-label" style="color: #4a5568; font-weight: 700;">Section Header (English)</p>

            <div class="lp-field">
                <label class="lp-field-label">Eyebrow Label <span style="font-weight:400;color:#b0b8b0;">(EN)</span></label>
                <input type="text" class="lp-input" name="eyebrow" value="{{ old('eyebrow', $d['eyebrow'] ?? '') }}" maxlength="100">
            </div>

            <div class="lp-field">
                <label class="lp-field-label">Section Title <span style="font-weight:400;color:#b0b8b0;">(EN)</span></label>
                <input type="text" class="lp-input lp-heading-input" name="title" value="{{ old('title', $d['title'] ?? '') }}" maxlength="200">
            </div>

            <div class="lp-field" style="margin-bottom:0;">
                <label class="lp-field-label">Section Description <span style="font-weight:400;color:#b0b8b0;">(EN)</span></label>
                <textarea class="lp-textarea" name="description" rows="4" maxlength="500">{{ old('description', $d['description'] ?? '') }}</textarea>
            </div>
        </div>

        {{-- Indonesian Content --}}
        <div class="lp-card" style="margin-bottom: 0;">
            <p class="lp-card-label" style="color: #4a5568; font-weight: 700;">Section Header (Indonesian)</p>

            <div class="lp-field">
                <label class="lp-field-label">Eyebrow Label <span style="font-weight:400;color:#b0b8b0;">(ID)</span></label>
                <input type="text" class="lp-input" name="eyebrow_id" value="{{ old('eyebrow_id', $d['eyebrow_id'] ?? '') }}" maxlength="100">
            </div>

            <div class="lp-field">
                <label class="lp-field-label">Section Title <span style="font-weight:400;color:#b0b8b0;">(ID)</span></label>
                <input type="text" class="lp-input lp-heading-input" name="title_id" value="{{ old('title_id', $d['title_id'] ?? '') }}" maxlength="200">
            </div>

            <div class="lp-field" style="margin-bottom:0;">
                <label class="lp-field-label">Section Description <span style="font-weight:400;color:#b0b8b0;">(ID)</span></label>
                <textarea class="lp-textarea" name="description_id" rows="4" maxlength="500">{{ old('description_id', $d['description_id'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- ── Flora Cards List ── --}}
    <div class="lp-card">
        <div class="lp-flora-cards-header">
            <p class="lp-card-label" style="margin:0;">Flora Detail Cards</p>
            <button type="button" class="btn btn-dark" style="font-size:13px;padding:8px 14px;" onclick="openFloraCardModal()">
                + Add New Card
            </button>
        </div>

        <div id="floraCardsList">
            @foreach($cards as $i => $card)
            <div class="lp-flora-card-item" data-index="{{ $i }}" id="card_{{ $i }}">

                <div style="position:relative;flex-shrink:0;">
                    @if(!empty($card['image_path']))
                        <img src="{{ asset('storage/'.$card['image_path']) }}" alt="{{ $card['title'] }}" class="lp-flora-thumb" id="cardThumb_{{ $i }}">
                    @else
                        <img src="{{ asset($defaultImages[$i] ?? 'images/flora-nourishment.png') }}" alt="{{ $card['title'] }}" class="lp-flora-thumb" id="cardThumb_{{ $i }}">
                    @endif
                </div>

                <div class="lp-flora-text">
                    <div class="lp-flora-title">
                        <strong>EN:</strong> {{ $card['title'] }} <br>
                        <span style="color: #6b7280;"><strong>ID:</strong> {{ $card['title_id'] ?? '-' }}</span>
                    </div>
                    <div class="lp-flora-desc" style="color:#9aaa96;font-size:11px; margin-top: 4px;">
                        {{ $card['eyebrow'] ?? '' }} / {{ $card['eyebrow_id'] ?? '' }}
                    </div>
                </div>

                <div class="action-icons">
                    <button type="button" class="action-btn" title="Edit"
                            onclick="openFloraCardModal({{ $i }}, {{ json_encode($card) }}, '{{ !empty($card['image_path']) ? asset('storage/'.$card['image_path']) : asset($defaultImages[$i] ?? 'images/flora-nourishment.png') }}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button type="button" class="action-btn delete" title="Delete" onclick="removeFloraCard({{ $i }})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Form Action Buttons ── --}}
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
        <a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="btn btn-orange-outline">Cancel</a>
        <button type="submit" class="btn btn-dark">Save Changes</button>
    </div>

    {{-- ── Hidden Inputs State Matrix ── --}}
    <div id="hiddenCardInputs">
        @foreach($cards as $i => $card)
            <input type="hidden" name="cards[{{ $i }}][image_path]" id="hImgPath_{{ $i }}" value="{{ $card['image_path'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][eyebrow]" id="hEyebrow_{{ $i }}" value="{{ $card['eyebrow'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][title]" id="hTitle_{{ $i }}" value="{{ $card['title'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][description]" id="hDesc_{{ $i }}" value="{{ $card['description'] ?? '' }}">
            
            {{-- Indonesian Hidden Fields --}}
            <input type="hidden" name="cards[{{ $i }}][eyebrow_id]" id="hEyebrowId_{{ $i }}" value="{{ $card['eyebrow_id'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][title_id]" id="hTitleId_{{ $i }}" value="{{ $card['title_id'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][description_id]" id="hDescId_{{ $i }}" value="{{ $card['description_id'] ?? '' }}">
        @endforeach
    </div>
</form>

{{-- ════════════════════════════════════════
    MODAL: Add / Edit Flora Card (Bilingual Structure)
════════════════════════════════════════ --}}
<div class="modal-overlay" id="floraCardModal">
    <div class="modal-box" style="max-width:640px;">
        <div class="modal-header">
            <h3 class="modal-title" id="floraCardModalTitle">Add Flora Card</h3>
            <button type="button" class="modal-close" onclick="closeModal('floraCardModal')">✕</button>
        </div>

        <div>
            <input type="hidden" id="editingCardIndex" value="">

            {{-- Image Upload Zone --}}
            <div class="form-group">
                <label class="form-label">Card Image</label>
                <div class="upload-zone" id="cardImgZone" onclick="document.getElementById('cardImgFileInput').click()" style="padding:20px;">
                    <div id="cardImgPreviewWrap" style="display:none;margin-bottom:10px;">
                        <img id="cardImgPreview" src="" alt="" style="width:100%;max-height:140px;object-fit:cover;border-radius:8px;">
                    </div>
                    <div id="cardImgPlaceholder">
                        <svg width="24" height="24" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24" style="display:block;margin:0 auto 6px;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:12px;color:#9aaa96;margin:0;text-align:center;">Click or drag image here</p>
                    </div>
                    <input type="file" id="cardImgFileInput" accept="image/*" style="display:none" onchange="previewCardImg(this)">
                </div>
                <input type="hidden" id="modalImgPath" value="">
                <input type="hidden" id="modalImgDataUrl" value="">
            </div>

            {{-- Dual Columns for Languages --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                
                {{-- Column EN --}}
                <div>
                    <span style="font-size: 11px; font-weight: bold; color: #4a5568; text-transform: uppercase;">English Content</span>
                    <hr style="margin: 4px 0 12px; border: 0; border-top: 1px solid #e2e8f0;">

                    <div class="form-group">
                        <label class="form-label">Card Eyebrow (EN)</label>
                        <input type="text" class="form-input" id="cardEyebrowInput" placeholder="e.g. Nourishment" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Card Title (EN)</label>
                        <input type="text" class="form-input" id="cardTitleInput" placeholder="e.g. Edible Garden">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Card Description (EN)</label>
                        <textarea class="form-textarea" id="cardDescInput" rows="3" placeholder="Describe this flora concept..."></textarea>
                    </div>
                </div>

                {{-- Column ID --}}
                <div>
                    <span style="font-size: 11px; font-weight: bold; color: #4a5568; text-transform: uppercase;">Indonesian Content</span>
                    <hr style="margin: 4px 0 12px; border: 0; border-top: 1px solid #e2e8f0;">

                    <div class="form-group">
                        <label class="form-label">Card Eyebrow (ID)</label>
                        <input type="text" class="form-input" id="cardEyebrowIdInput" placeholder="misal: Nutrisi" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Card Title (ID)</label>
                        <input type="text" class="form-input" id="cardTitleIdInput" placeholder="misal: Kebun Edibel">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Card Description (ID)</label>
                        <textarea class="form-textarea" id="cardDescIdInput" rows="3" placeholder="Jelaskan konsep flora ini..."></textarea>
                    </div>
                </div>

            </div>

            <div class="modal-footer" style="margin-top: 16px; padding-top: 12px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('floraCardModal')">Cancel</button>
                <button type="button" class="btn btn-dark" onclick="saveFloraCard()">Save Card</button>
            </div>
        </div>
    </div>
</div>

{{-- Status bar saved log --}}
@if($floraSettings?->updated_at)
<div class="lp-status-bar" style="margin-top:16px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved: <span style="color:#5a6a58;">{{ $floraSettings->updated_at->format('M j, Y') }} at {{ $floraSettings->updated_at->format('H:i') }}</span>
    </div>
    <div class="lp-status-bar-item"><span class="lp-live-dot"></span><span class="lp-live-text">All systems operational</span></div>
</div>
@endif

<script>
let cardCount = {{ count($cards) }};

function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) closeModal(el.id); });
});

/* ── Open card modal with loaded parameters ── */
function openFloraCardModal(index, card, imgUrl) {
    const isEdit = index !== undefined;
    document.getElementById('floraCardModalTitle').textContent = isEdit ? 'Edit Flora Card' : 'Add Flora Card';
    document.getElementById('editingCardIndex').value = isEdit ? index : '';

    // Reset fields to defaults / explicit existing states
    document.getElementById('cardEyebrowInput').value   = card?.eyebrow     ?? '';
    document.getElementById('cardTitleInput').value     = card?.title       ?? '';
    document.getElementById('cardDescInput').value      = card?.description ?? '';
    
    document.getElementById('cardEyebrowIdInput').value = card?.eyebrow_id  ?? '';
    document.getElementById('cardTitleIdInput').value   = card?.title_id    ?? '';
    document.getElementById('cardDescIdInput').value    = card?.description_id ?? '';
    
    document.getElementById('modalImgPath').value       = card?.image_path  ?? '';
    document.getElementById('modalImgDataUrl').value    = '';
    document.getElementById('cardImgFileInput').value   = '';

    const preview = document.getElementById('cardImgPreview');
    const wrap    = document.getElementById('cardImgPreviewWrap');
    const ph      = document.getElementById('cardImgPlaceholder');

    if (imgUrl) {
        preview.src = imgUrl;
        wrap.style.display = 'block';
        ph.style.display = 'none';
    } else {
        wrap.style.display = 'none';
        ph.style.display = 'block';
    }

    openModal('floraCardModal');
}

function previewCardImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('cardImgPreview').src = e.target.result;
        document.getElementById('cardImgPreviewWrap').style.display = 'block';
        document.getElementById('cardImgPlaceholder').style.display = 'none';
        document.getElementById('modalImgDataUrl').value = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

/* ── Sync modal inputs to hidden matrix data entries ── */
function saveFloraCard() {
    const idx        = document.getElementById('editingCardIndex').value;
    const eyebrow    = document.getElementById('cardEyebrowInput').value.trim();
    const title      = document.getElementById('cardTitleInput').value.trim();
    const desc       = document.getElementById('cardDescInput').value.trim();
    
    const eyebrowId  = document.getElementById('cardEyebrowIdInput').value.trim();
    const titleId    = document.getElementById('cardTitleIdInput').value.trim();
    const descId     = document.getElementById('cardDescIdInput').value.trim();
    
    const imgPath    = document.getElementById('modalImgPath').value;
    const dataUrl    = document.getElementById('modalImgDataUrl').value;
    const fileInput  = document.getElementById('cardImgFileInput');

    if (!title || !titleId) { 
        alert('Card title wajib diisi untuk kedua bahasa (EN & ID).'); 
        return; 
    }

    const isEdit = idx !== '';
    const i      = isEdit ? parseInt(idx) : cardCount++;

    const hiddenWrap = document.getElementById('hiddenCardInputs');

    function setHidden(name, id, val) {
        let el = document.getElementById(id);
        if (!el) {
            el = document.createElement('input');
            el.type = 'hidden';
            el.name = name;
            el.id   = id;
            hiddenWrap.appendChild(el);
        }
        el.value = val;
    }

    // Set English Values
    setHidden(`cards[${i}][image_path]`,  `hImgPath_${i}`,   imgPath);
    setHidden(`cards[${i}][eyebrow]`,     `hEyebrow_${i}`,    eyebrow);
    setHidden(`cards[${i}][title]`,       `hTitle_${i}`,      title);
    setHidden(`cards[${i}][description]`, `hDesc_${i}`,       desc);
    
    // Set Indonesian Values
    setHidden(`cards[${i}][eyebrow_id]`,   `hEyebrowId_${i}`,  eyebrowId);
    setHidden(`cards[${i}][title_id]`,     `hTitleId_${i}`,    titleId);
    setHidden(`cards[${i}][description_id]`,`hDescId_${i}`,     descId);

    if (fileInput.files[0]) {
        const oldFile = document.getElementById(`hFile_${i}`);
        if (oldFile) oldFile.remove();

        const newFileInput = document.createElement('input');
        newFileInput.type  = 'file';
        newFileInput.name  = `cards[${i}][image]`;
        newFileInput.id    = `hFile_${i}`;
        newFileInput.style.display = 'none';

        const dt = new DataTransfer();
        dt.items.add(fileInput.files[0]);
        newFileInput.files = dt.files;
        hiddenWrap.appendChild(newFileInput);
    }

    const thumbSrc = dataUrl || (imgPath ? `/storage/${imgPath}` : '');
    updateCardListRow(i, eyebrow, title, desc, eyebrowId, titleId, descId, thumbSrc, imgPath);

    closeModal('floraCardModal');
}

/* ── Build or rewrite item row inside the UI list ── */
function updateCardListRow(i, eyebrow, title, desc, eyebrowId, titleId, descId, thumbSrc, imgPath) {
    const list = document.getElementById('floraCardsList');
    let row    = document.getElementById(`card_${i}`);

    if (!row) {
        row = document.createElement('div');
        row.className   = 'lp-flora-card-item';
        row.id          = `card_${i}`;
        row.dataset.index = i;
        list.appendChild(row);
    }

    const thumbHtml = thumbSrc
        ? `<img src="${thumbSrc}" alt="${title}" class="lp-flora-thumb" id="cardThumb_${i}">`
        : `<div class="lp-flora-thumb-placeholder" id="cardThumb_${i}"></div>`;

    // Secure localized params parsing inside single quotes for inline JS execution 
    const escapeJS = (str) => str.replace(/'/g, "\\'").replace(/\n/g, "\\n");

    row.innerHTML = `
        <div style="flex-shrink:0;">${thumbHtml}</div>
        <div class="lp-flora-text">
            <div class="lp-flora-title">
                <strong>EN:</strong> ${title} <br>
                <span style="color: #6b7280;"><strong>ID:</strong> ${titleId}</span>
            </div>
            <div class="lp-flora-desc" style="color:#9aaa96;font-size:11px; margin-top:4px;">
                ${eyebrow || '-'} / ${eyebrowId || '-'}
            </div>
        </div>
        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit"
                    onclick="openFloraCardModal(${i}, {eyebrow:'${escapeJS(eyebrow)}',title:'${escapeJS(title)}',description:'${escapeJS(desc)}',eyebrow_id:'${escapeJS(eyebrowId)}',title_id:'${escapeJS(titleId)}',description_id:'${escapeJS(descId)}',image_path:'${imgPath}'}, '${thumbSrc}')">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </button>
            <button type="button" class="action-btn delete" title="Delete" onclick="removeFloraCard(${i})">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
            </button>
        </div>`;
}

function removeFloraCard(i) {
    if (!confirm('Hapus card ini?')) return;
    document.getElementById(`card_${i}`)?.remove();
    ['hImgPath','hEyebrow','hTitle','hDesc','hImgPathId','hEyebrowId','hTitleId','hDescId','hFile'].forEach(prefix => {
        document.getElementById(`${prefix}_${i}`)?.remove();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof initDropZone === 'function') {
        initDropZone('cardImgZone', 'cardImgFileInput', file => {
            const r = new FileReader();
            r.onload = e => {
                document.getElementById('cardImgPreview').src = e.target.result;
                document.getElementById('cardImgPreviewWrap').style.display = 'block';
                document.getElementById('cardImgPlaceholder').style.display = 'none';
                document.getElementById('modalImgDataUrl').value = e.target.result;
            };
            r.readAsDataURL(file);
        });
    }
});
</script>