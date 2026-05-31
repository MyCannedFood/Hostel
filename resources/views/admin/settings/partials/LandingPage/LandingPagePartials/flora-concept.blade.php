@php
    $floraSettings ??= null;
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['flora'],
        $floraSettings?->data ?? []
    );
    $cards = $d['cards'] ?? [];

    // Default fallback images per card
    $defaultImages = [
        'images/flora-nourishment.png',
        'images/flora-aromatherapy.png',
        'images/flora-architecture.png',
    ];
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

<h2 class="section-title" style="margin-bottom:24px;">Edit The Flora Concept</h2>

<form method="POST"
      action="{{ route('admin.landing.flora.update') }}"
      enctype="multipart/form-data"
      id="floraForm">
    @csrf @method('PUT')

    {{-- ── Section Header ── --}}
    <div class="lp-card">
        <p class="lp-card-label">Section Header</p>

        <div class="lp-field">
            <label class="lp-field-label">Eyebrow Label
                <span style="font-weight:400;color:#b0b8b0;">(kecil di atas judul)</span>
            </label>
            <input type="text" class="lp-input" name="eyebrow"
                   value="{{ old('eyebrow', $d['eyebrow']) }}" maxlength="100"
                   placeholder="e.g. Living Ecosystem">
        </div>

        <div class="lp-field">
            <label class="lp-field-label">Section Title</label>
            <input type="text" class="lp-input lp-heading-input" name="title"
                   value="{{ old('title', $d['title']) }}" maxlength="200">
        </div>

        <div class="lp-field" style="margin-bottom:0;">
            <label class="lp-field-label">Section Description</label>
            <textarea class="lp-textarea" name="description" rows="3"
                      maxlength="500">{{ old('description', $d['description']) }}</textarea>
        </div>
    </div>

    {{-- ── Flora Cards ── --}}
    <div class="lp-card">
        <div class="lp-flora-cards-header">
            <p class="lp-card-label" style="margin:0;">Flora Detail Cards</p>
            <button type="button" class="btn btn-dark" style="font-size:13px;padding:8px 14px;"
                    onclick="openFloraCardModal()">
                + Add New Card
            </button>
        </div>

        <div id="floraCardsList">
            @foreach($cards as $i => $card)
            <div class="lp-flora-card-item" data-index="{{ $i }}" id="card_{{ $i }}">

                {{-- Thumbnail --}}
                <div style="position:relative;flex-shrink:0;">
                    @if(!empty($card['image_path']))
                        <img src="{{ asset('storage/'.$card['image_path']) }}"
                             alt="{{ $card['title'] }}" class="lp-flora-thumb"
                             id="cardThumb_{{ $i }}">
                    @else
                        <img src="{{ asset($defaultImages[$i] ?? 'images/flora-nourishment.png') }}"
                             alt="{{ $card['title'] }}" class="lp-flora-thumb"
                             id="cardThumb_{{ $i }}">
                    @endif
                </div>

                <div class="lp-flora-text">
                    <div class="lp-flora-title">{{ $card['title'] }}</div>
                    <div class="lp-flora-desc" style="color:#9aaa96;font-size:11px;">
                        {{ $card['eyebrow'] ?? '' }}
                    </div>
                </div>

                <div class="action-icons">
                    <button type="button" class="action-btn" title="Edit"
                            onclick="openFloraCardModal({{ $i }}, {{ json_encode($card) }}, '{{ !empty($card['image_path']) ? asset('storage/'.$card['image_path']) : asset($defaultImages[$i] ?? 'images/flora-nourishment.png') }}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button type="button" class="action-btn delete" title="Delete"
                            onclick="removeFloraCard({{ $i }})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Save button (outside modal) ── --}}
    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:8px;">
        <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
           class="btn btn-orange-outline">Cancel</a>
        <button type="submit" class="btn btn-dark">Save Changes</button>
    </div>

    {{-- ── Hidden card data (submitted with form) ── --}}
    <div id="hiddenCardInputs">
        @foreach($cards as $i => $card)
            <input type="hidden" name="cards[{{ $i }}][image_path]"
                   id="hImgPath_{{ $i }}"
                   value="{{ $card['image_path'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][eyebrow]"
                   id="hEyebrow_{{ $i }}"
                   value="{{ $card['eyebrow'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][title]"
                   id="hTitle_{{ $i }}"
                   value="{{ $card['title'] ?? '' }}">
            <input type="hidden" name="cards[{{ $i }}][description]"
                   id="hDesc_{{ $i }}"
                   value="{{ $card['description'] ?? '' }}">
        @endforeach
    </div>

</form>


{{-- ════════════════════════════════════════
     MODAL: Add / Edit Flora Card
════════════════════════════════════════ --}}
<div class="modal-overlay" id="floraCardModal">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <h3 class="modal-title" id="floraCardModalTitle">Add Flora Card</h3>
            <button type="button" class="modal-close" onclick="closeModal('floraCardModal')">✕</button>
        </div>

        {{-- Modal form is separate — on save, updates hidden inputs in main form --}}
        <div>
            <input type="hidden" id="editingCardIndex" value="">

            {{-- Card Image --}}
            <div class="form-group">
                <label class="form-label">Card Image</label>
                <div class="upload-zone" id="cardImgZone"
                     onclick="document.getElementById('cardImgFileInput').click()"
                     style="padding:24px;">
                    <div id="cardImgPreviewWrap" style="display:none;margin-bottom:10px;">
                        <img id="cardImgPreview" src="" alt=""
                             style="width:100%;max-height:160px;object-fit:cover;border-radius:8px;">
                    </div>
                    <div id="cardImgPlaceholder">
                        <svg width="28" height="28" fill="none" stroke="#9aaa96" stroke-width="1.5"
                             viewBox="0 0 24 24" style="display:block;margin:0 auto 8px;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:13px;color:#9aaa96;margin:0;text-align:center;">
                            Click or drag image here
                        </p>
                        <p style="font-size:11px;color:#b0b8b0;margin:4px 0 0;text-align:center;text-transform:uppercase;letter-spacing:.5px;">
                            JPG, PNG, WEBP · Max 3MB
                        </p>
                    </div>
                    <input type="file" id="cardImgFileInput" accept="image/*"
                           style="display:none" onchange="previewCardImg(this)">
                </div>
                <input type="hidden" id="modalImgPath" value="">
                <input type="hidden" id="modalImgDataUrl" value="">
            </div>

            <div class="form-group">
                <label class="form-label">Card Eyebrow
                    <span style="font-weight:400;color:#b0b8b0;">(label kecil di atas judul)</span>
                </label>
                <input type="text" class="form-input" id="cardEyebrowInput"
                       placeholder="e.g. Nourishment" maxlength="100">
            </div>

            <div class="form-group">
                <label class="form-label">Card Title</label>
                <input type="text" class="form-input" id="cardTitleInput"
                       placeholder="e.g. Edible Garden">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Card Description</label>
                <textarea class="form-textarea" id="cardDescInput" rows="3"
                          placeholder="Describe this flora concept..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline"
                        onclick="closeModal('floraCardModal')">Cancel</button>
                <button type="button" class="btn btn-dark"
                        onclick="saveFloraCard()">Save Card</button>
            </div>
        </div>
    </div>
</div>

{{-- Last saved --}}
@if($floraSettings?->updated_at)
<div class="lp-status-bar" style="margin-top:8px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved:
        <span style="color:#5a6a58;">
            {{ $floraSettings->updated_at->format('M j, Y') }}
            at {{ $floraSettings->updated_at->format('H:i') }}
        </span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">All systems operational</span>
    </div>
</div>
@endif


<script>
let cardCount = {{ count($cards) }};

/* ── Modal helpers ── */
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

/* ── Open card modal ── */
function openFloraCardModal(index, card, imgUrl) {
    const isEdit = index !== undefined;
    document.getElementById('floraCardModalTitle').textContent =
        isEdit ? 'Edit Flora Card' : 'Add Flora Card';
    document.getElementById('editingCardIndex').value = isEdit ? index : '';

    // Reset
    document.getElementById('cardEyebrowInput').value = card?.eyebrow     ?? '';
    document.getElementById('cardTitleInput').value   = card?.title       ?? '';
    document.getElementById('cardDescInput').value    = card?.description ?? '';
    document.getElementById('modalImgPath').value     = card?.image_path  ?? '';
    document.getElementById('modalImgDataUrl').value  = '';
    document.getElementById('cardImgFileInput').value = '';

    const preview = document.getElementById('cardImgPreview');
    const wrap    = document.getElementById('cardImgPreviewWrap');
    const ph      = document.getElementById('cardImgPlaceholder');

    if (imgUrl) {
        preview.src         = imgUrl;
        wrap.style.display  = 'block';
        ph.style.display    = 'none';
    } else {
        wrap.style.display  = 'none';
        ph.style.display    = 'block';
    }

    openModal('floraCardModal');
}

/* ── Preview image in modal ── */
function previewCardImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('cardImgPreview').src          = e.target.result;
        document.getElementById('cardImgPreviewWrap').style.display = 'block';
        document.getElementById('cardImgPlaceholder').style.display = 'none';
        document.getElementById('modalImgDataUrl').value       = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

/* ── Save card — updates hidden inputs + list row ── */
function saveFloraCard() {
    const idx      = document.getElementById('editingCardIndex').value;
    const eyebrow  = document.getElementById('cardEyebrowInput').value.trim();
    const title    = document.getElementById('cardTitleInput').value.trim();
    const desc     = document.getElementById('cardDescInput').value.trim();
    const imgPath  = document.getElementById('modalImgPath').value;
    const dataUrl  = document.getElementById('modalImgDataUrl').value;
    const fileInput= document.getElementById('cardImgFileInput');

    if (!title) { alert('Card title wajib diisi.'); return; }

    const isEdit = idx !== '';
    const i      = isEdit ? parseInt(idx) : cardCount++;

    /* ── Update/create hidden inputs ── */
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

    setHidden(`cards[${i}][image_path]`,  `hImgPath_${i}`,   imgPath);
    setHidden(`cards[${i}][eyebrow]`,     `hEyebrow_${i}`,   eyebrow);
    setHidden(`cards[${i}][title]`,       `hTitle_${i}`,     title);
    setHidden(`cards[${i}][description]`, `hDesc_${i}`,      desc);

    /* ── If new image file selected, create real file input ── */
    if (fileInput.files[0]) {
        // Remove old file input for this index if exists
        const oldFile = document.getElementById(`hFile_${i}`);
        if (oldFile) oldFile.remove();

        // Clone file input and attach to form
        const newFileInput = document.createElement('input');
        newFileInput.type  = 'file';
        newFileInput.name  = `cards[${i}][image]`;
        newFileInput.id    = `hFile_${i}`;
        newFileInput.style.display = 'none';

        // Transfer files using DataTransfer
        const dt = new DataTransfer();
        dt.items.add(fileInput.files[0]);
        newFileInput.files = dt.files;
        hiddenWrap.appendChild(newFileInput);
    }

    /* ── Update card list row UI ── */
    const thumbSrc = dataUrl || (imgPath ? `/storage/${imgPath}` : '');
    updateCardListRow(i, eyebrow, title, desc, thumbSrc, imgPath);

    closeModal('floraCardModal');
}

function updateCardListRow(i, eyebrow, title, desc, thumbSrc, imgPath) {
    const list  = document.getElementById('floraCardsList');
    let row     = document.getElementById(`card_${i}`);

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

    row.innerHTML = `
        <div style="flex-shrink:0;">${thumbHtml}</div>
        <div class="lp-flora-text">
            <div class="lp-flora-title">${title}</div>
            <div class="lp-flora-desc" style="color:#9aaa96;font-size:11px;">${eyebrow}</div>
        </div>
        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit"
                    onclick="openFloraCardModal(${i}, {eyebrow:'${eyebrow.replace(/'/g,"\\'")}',title:'${title.replace(/'/g,"\\'")}',description:'${desc.replace(/'/g,"\\'")}',image_path:'${imgPath}'}, '${thumbSrc}')">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </button>
            <button type="button" class="action-btn delete" title="Delete"
                    onclick="removeFloraCard(${i})">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
            </button>
        </div>`;
}

/* ── Remove card ── */
function removeFloraCard(i) {
    if (!confirm('Hapus card ini?')) return;
    document.getElementById(`card_${i}`)?.remove();
    // Clear hidden inputs
    ['hImgPath','hEyebrow','hTitle','hDesc','hFile'].forEach(prefix => {
        document.getElementById(`${prefix}_${i}`)?.remove();
    });
}

/* ── Drag & drop for card image ── */
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initDropZone === 'function') {
        initDropZone('cardImgZone', 'cardImgFileInput', file => {
            const r = new FileReader();
            r.onload = e => {
                document.getElementById('cardImgPreview').src          = e.target.result;
                document.getElementById('cardImgPreviewWrap').style.display = 'block';
                document.getElementById('cardImgPlaceholder').style.display = 'none';
                document.getElementById('modalImgDataUrl').value       = e.target.result;
            };
            r.readAsDataURL(file);
        });
    }
});
</script>