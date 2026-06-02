@php
    $guestStoriesSettings ??= null;
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['guest_stories'],
        $guestStoriesSettings?->data ?? []
    );
    $stories = $d['stories'] ?? [];
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

<h2 class="section-title" style="margin-bottom:24px;">Edit Guest Stories</h2>

<form method="POST"
      action="{{ route('admin.landing.guest-stories.update') }}"
      enctype="multipart/form-data"
      id="guestStoriesForm">
    @csrf @method('PUT')

    {{-- ── Section Title ── --}}
    <div class="lp-card">
        <div class="lp-field" style="margin-bottom:0;">
            <label class="lp-field-label">Section Title</label>
            <input type="text" class="lp-input lp-heading-input" name="title"
                   value="{{ old('title', $d['title']) }}"
                   maxlength="100">
            <div style="display:flex;align-items:center;gap:6px;margin-top:8px;">
                <svg width="13" height="13" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                </svg>
                <span style="font-size:12px;color:#d97706;">
                    This appears at the top of the guest experience section.
                </span>
            </div>
        </div>
    </div>

    {{-- ── Current Stories ── --}}
    <div class="lp-card">
        <div class="lp-flora-cards-header">
            <p style="font-size:15px;font-weight:700;color:#1a3d0a;margin:0;">Current Stories</p>
            <button type="button" class="btn btn-dark" style="font-size:13px;padding:8px 14px;"
                    onclick="openStoryModal()">
                + Add New Story
            </button>
        </div>

        <div id="storiesList">
            @foreach($stories as $i => $story)
            <div class="lp-flora-card-item" id="storyRow_{{ $i }}">
                {{-- Avatar / Photo ── --}}
                <div style="flex-shrink:0;">
                    @if(!empty($story['image_path']))
                        <img src="{{ asset('storage/'.$story['image_path']) }}"
                             alt="{{ $story['name'] }}" id="storyThumb_{{ $i }}"
                             style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                    @else
                        <div id="storyThumb_{{ $i }}"
                             style="width:48px;height:48px;border-radius:50%;background:#e0e8dc;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:16px;font-weight:700;color:#4a7c3f;">
                            {{ strtoupper(substr($story['name'] ?? 'G', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="lp-flora-text">
                    <div class="lp-flora-title" id="storyName_{{ $i }}">{{ $story['name'] }}</div>
                    <div class="lp-flora-desc">{{ $story['origin'] ?? '' }}</div>
                </div>

                <div class="action-icons">
                    <button type="button" class="action-btn" title="Edit"
                            onclick="openStoryModal({{ $i }}, {{ json_encode($story) }}, '{{ !empty($story['image_path']) ? asset('storage/'.$story['image_path']) : '' }}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button type="button" class="action-btn delete" title="Delete"
                            onclick="removeStory({{ $i }})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid #f0f4ee;">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
               class="btn btn-orange-outline">Cancel</a>
            <button type="submit" class="btn btn-dark">Save Changes</button>
        </div>
    </div>

    {{-- Hidden inputs for stories data ── --}}
    <div id="hiddenStoryInputs">
        @foreach($stories as $i => $story)
            <input type="hidden" name="stories[{{ $i }}][image_path]"
                   id="hSImgPath_{{ $i }}" value="{{ $story['image_path'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][name]"
                   id="hSName_{{ $i }}"    value="{{ $story['name'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][origin]"
                   id="hSOrigin_{{ $i }}"  value="{{ $story['origin'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][quote]"
                   id="hSQuote_{{ $i }}"   value="{{ $story['quote'] ?? '' }}">
        @endforeach
    </div>

</form>

{{-- Last saved ── --}}
@if($guestStoriesSettings?->updated_at)
<div class="lp-status-bar" style="margin-top:8px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved:
        <span style="color:#5a6a58;">
            {{ $guestStoriesSettings->updated_at->format('M j, Y') }}
            at {{ $guestStoriesSettings->updated_at->format('H:i') }}
        </span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">All systems operational</span>
    </div>
</div>
@endif


{{-- ════ MODAL: Add / Edit Story ════ --}}
<div class="modal-overlay" id="storyModal">
    <div class="modal-box" style="max-width:540px;">
        <div class="modal-header">
            <h3 class="modal-title" id="storyModalTitle">Add New Guest Story</h3>
            <button type="button" class="modal-close" onclick="closeModal('storyModal')">✕</button>
        </div>

        <div>
            <input type="hidden" id="editingStoryIndex" value="">

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Guest Name</label>
                    <input type="text" class="form-input" id="storyNameInput"
                           placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Guest Origin</label>
                    <input type="text" class="form-input" id="storyOriginInput"
                           placeholder="e.g. Guest from Australia">
                </div>
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label class="form-label">Main Quote</label>
                <textarea class="form-textarea" id="storyQuoteInput" rows="4"
                          maxlength="400"
                          oninput="updateStoryCharCount(this)"
                          placeholder="Share their experience at AlaSare..."></textarea>
                <div style="text-align:right;font-size:11px;color:#9aaa96;margin-top:4px;">
                    <span id="storyQuoteCount">0</span> / 400 characters recommended.
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Side Image</label>
                <div class="upload-zone" id="storyImgZone"
                     onclick="document.getElementById('storyImgFileInput').click()"
                     style="padding:28px 20px;">
                    <div id="storyModalImgPreviewWrap" style="display:none;margin-bottom:10px;">
                        <img id="storyModalImgPreview" src="" alt=""
                             style="width:100%;max-height:160px;object-fit:cover;border-radius:8px;">
                    </div>
                    <div id="storyModalImgPlaceholder">
                        <svg width="32" height="32" fill="none" stroke="#9aaa96" stroke-width="1.5"
                             viewBox="0 0 24 24" style="display:block;margin:0 auto 8px;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:14px;font-weight:600;color:#3a4a38;margin:0 0 4px;text-align:center;">
                            Drag and drop guest photo here
                        </p>
                        <p style="font-size:13px;color:#9aaa96;margin:0;text-align:center;">
                            or <span style="color:#d97706;font-weight:600;">browse files</span>
                        </p>
                        <p style="font-size:11px;color:#b0b8b0;margin:8px 0 0;text-align:center;text-transform:uppercase;letter-spacing:.5px;">
                            JPG, PNG up to 5MB (Square aspect ratio recommended)
                        </p>
                    </div>
                    <input type="file" id="storyImgFileInput" accept="image/*"
                           style="display:none" onchange="previewStoryModalImg(this)">
                </div>
                <input type="hidden" id="modalStoryImgPath"    value="">
                <input type="hidden" id="modalStoryImgDataUrl" value="">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline"
                        onclick="closeModal('storyModal')">Cancel</button>
                <button type="button" class="btn btn-dark"
                        onclick="saveStory()">Save Story</button>
            </div>
        </div>
    </div>
</div>


<script>
let storyCount = {{ count($stories) }};

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

/* ── Open Story Modal ── */
function openStoryModal(index, story, imgUrl) {
    const isEdit = index !== undefined;
    document.getElementById('storyModalTitle').textContent =
        isEdit ? 'Edit Guest Story' : 'Add New Guest Story';
    document.getElementById('editingStoryIndex').value = isEdit ? index : '';

    document.getElementById('storyNameInput').value   = story?.name   ?? '';
    document.getElementById('storyOriginInput').value = story?.origin ?? '';
    document.getElementById('storyQuoteInput').value  = story?.quote  ?? '';
    document.getElementById('modalStoryImgPath').value = story?.image_path ?? '';
    document.getElementById('modalStoryImgDataUrl').value = '';
    document.getElementById('storyImgFileInput').value = '';
    updateStoryCharCount(document.getElementById('storyQuoteInput'));

    const wrap    = document.getElementById('storyModalImgPreviewWrap');
    const preview = document.getElementById('storyModalImgPreview');
    const ph      = document.getElementById('storyModalImgPlaceholder');

    if (imgUrl) {
        preview.src        = imgUrl;
        wrap.style.display = 'block';
        ph.style.display   = 'none';
    } else {
        wrap.style.display = 'none';
        ph.style.display   = 'block';
    }

    openModal('storyModal');
}

/* ── Preview modal image ── */
function previewStoryModalImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('storyModalImgPreview').src       = e.target.result;
        document.getElementById('storyModalImgPreviewWrap').style.display = 'block';
        document.getElementById('storyModalImgPlaceholder').style.display = 'none';
        document.getElementById('modalStoryImgDataUrl').value     = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

function updateStoryCharCount(el) {
    document.getElementById('storyQuoteCount').textContent = el.value.length;
}

/* ── Save story → updates hidden inputs + list row ── */
function saveStory() {
    const idx    = document.getElementById('editingStoryIndex').value;
    const name   = document.getElementById('storyNameInput').value.trim();
    const origin = document.getElementById('storyOriginInput').value.trim();
    const quote  = document.getElementById('storyQuoteInput').value.trim();
    const imgPath= document.getElementById('modalStoryImgPath').value;
    const dataUrl= document.getElementById('modalStoryImgDataUrl').value;
    const fileIn = document.getElementById('storyImgFileInput');

    if (!name) { alert('Nama guest wajib diisi.'); return; }

    const isEdit = idx !== '';
    const i      = isEdit ? parseInt(idx) : storyCount++;
    const hidden = document.getElementById('hiddenStoryInputs');

    function setH(name, id, val) {
        let el = document.getElementById(id);
        if (!el) {
            el = document.createElement('input');
            el.type = 'hidden'; el.name = name; el.id = id;
            hidden.appendChild(el);
        }
        el.value = val;
    }

    setH(`stories[${i}][image_path]`, `hSImgPath_${i}`, imgPath);
    setH(`stories[${i}][name]`,       `hSName_${i}`,    name);
    setH(`stories[${i}][origin]`,     `hSOrigin_${i}`,  origin);
    setH(`stories[${i}][quote]`,      `hSQuote_${i}`,   quote);

    /* Attach file input if new photo selected */
    if (fileIn.files[0]) {
        const old = document.getElementById(`hSFile_${i}`);
        if (old) old.remove();
        const newIn = document.createElement('input');
        newIn.type = 'file'; newIn.name = `stories[${i}][image]`;
        newIn.id   = `hSFile_${i}`; newIn.style.display = 'none';
        const dt = new DataTransfer(); dt.items.add(fileIn.files[0]);
        newIn.files = dt.files;
        hidden.appendChild(newIn);
    }

    /* Update list row UI */
    const thumbSrc = dataUrl || (imgPath ? `/storage/${imgPath}` : '');
    updateStoryRow(i, name, origin, thumbSrc);
    closeModal('storyModal');
}

function updateStoryRow(i, name, origin, thumbSrc) {
    const list = document.getElementById('storiesList');
    let row    = document.getElementById(`storyRow_${i}`);

    if (!row) {
        row = document.createElement('div');
        row.className = 'lp-flora-card-item';
        row.id        = `storyRow_${i}`;
        list.appendChild(row);
    }

    const initial  = (name || 'G').charAt(0).toUpperCase();
    const thumbHtml = thumbSrc
        ? `<img src="${thumbSrc}" alt="${name}" id="storyThumb_${i}"
               style="width:48px;height:48px;border-radius:50%;object-fit:cover;">`
        : `<div id="storyThumb_${i}"
               style="width:48px;height:48px;border-radius:50%;background:#e0e8dc;
                      display:flex;align-items:center;justify-content:center;
                      font-size:16px;font-weight:700;color:#4a7c3f;">${initial}</div>`;

    row.innerHTML = `
        <div style="flex-shrink:0;">${thumbHtml}</div>
        <div class="lp-flora-text">
            <div class="lp-flora-title">${name}</div>
            <div class="lp-flora-desc">${origin}</div>
        </div>
        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit"
                    onclick="openStoryModal(${i},{name:'${name.replace(/'/g,"\\'")}',origin:'${origin.replace(/'/g,"\\'")}',quote:document.getElementById('hSQuote_${i}')?.value??'',image_path:'${document.getElementById('hSImgPath_'+i)?.value??''}'},'${thumbSrc}')">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </button>
            <button type="button" class="action-btn delete" title="Delete"
                    onclick="removeStory(${i})">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
            </button>
        </div>`;
}

function removeStory(i) {
    if (!confirm('Hapus story ini?')) return;
    document.getElementById(`storyRow_${i}`)?.remove();
    ['hSImgPath','hSName','hSOrigin','hSQuote','hSFile'].forEach(prefix => {
        document.getElementById(`${prefix}_${i}`)?.remove();
    });
}

/* ── Drag & drop ── */
document.addEventListener('DOMContentLoaded', () => {
    if (typeof initDropZone === 'function') {
        initDropZone('storyImgZone', 'storyImgFileInput', file => {
            const r = new FileReader();
            r.onload = e => {
                document.getElementById('storyModalImgPreview').src           = e.target.result;
                document.getElementById('storyModalImgPreviewWrap').style.display = 'block';
                document.getElementById('storyModalImgPlaceholder').style.display = 'none';
                document.getElementById('modalStoryImgDataUrl').value         = e.target.result;
            };
            r.readAsDataURL(file);
        });
    }
});
</script>