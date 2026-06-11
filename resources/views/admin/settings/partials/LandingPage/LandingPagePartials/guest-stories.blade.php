@php
    $guestStoriesSettings ??= null;
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['guest_stories'],
        $guestStoriesSettings?->data ?? []
    );
    $stories = $d['stories'] ?? [];
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

<h2 class="section-title" style="margin-bottom:24px;">Edit Guest Stories Section</h2>

<form method="POST"
      action="{{ route('admin.landing.guest-stories.update') }}"
      enctype="multipart/form-data"
      id="guestStoriesForm">
    @csrf @method('PUT')

    {{-- ── Section Title (Bilingual) ── --}}
    <div class="lp-card">
        <h3 style="font-size:16px;font-weight:600;color:#1a3d0a;margin:0 0 16px;">Section Headings</h3>
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px;">
            <div class="lp-field" style="margin:0;">
                <label class="lp-field-label">Title (English)</label>
                <input type="text" class="lp-input" name="title"
                       value="{{ old('title', $d['title'] ?? '') }}" maxlength="100">
            </div>
            <div class="lp-field" style="margin:0;">
                <label class="lp-field-label">Title (Indonesia)</label>
                <input type="text" class="lp-input" name="title_id"
                       value="{{ old('title_id', $d['title_id'] ?? '') }}" maxlength="100">
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:6px;margin-top:4px;">
            <svg width="13" height="13" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
            </svg>
            <span style="font-size:12px;color:#d97706;">
                This header text appears at the top of the guest experience swiper block.
            </span>
        </div>
    </div>

    {{-- ── Current Stories List ── --}}
    <div class="lp-card">
        <div class="lp-flora-cards-header" style="margin-bottom:16px;">
            <div>
                <p style="font-size:15px;font-weight:700;color:#1a3d0a;margin:0;">Current Guest Stories</p>
                <p style="font-size:12px;color:#7a8a76;margin:2px 0 0;">Manage your testimonial slider</p>
            </div>
            <button type="button" class="btn btn-dark" style="font-size:13px;padding:8px 14px;"
                    onclick="openStoryModal()">
                + Add New Story
            </button>
        </div>

        <div id="storiesList">
            @foreach($stories as $i => $story)
            <div class="lp-flora-card-item" id="storyRow_{{ $i }}">
                <div style="flex-shrink:0;">
                    @if(!empty($story['image_path']))
                        <img src="{{ asset('storage/'.$story['image_path']) }}"
                             alt="{{ $story['name'] }}" id="storyThumb_{{ $i }}"
                             style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                    @replace
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
                    <div class="lp-flora-desc">
                        <span style="color:#1a3d0a;font-weight:500;">EN:</span> {{ $story['origin'] ?? 'No origin' }} 
                        <span style="color:#7a8a76;margin:0 6px;">|</span>
                        <span style="color:#1a3d0a;font-weight:500;">ID:</span> {{ $story['origin_id'] ?? 'Belum ada asal' }}
                    </div>
                </div>

                <div class="action-icons">
                    <button type="button" class="action-btn" title="Edit"
                            onclick="editStoryFromRow({{ $i }}, '{{ !empty($story['image_path']) ? asset('storage/'.$story['image_path']) : '' }}')">
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

    {{-- ── Hidden Inputs Container (Keep sync for Form Request submission) ── --}}
    <div id="hiddenStoryInputs">
        @foreach($stories as $i => $story)
            <input type="hidden" name="stories[{{ $i }}][image_path]" id="hSImgPath_{{ $i }}" value="{{ $story['image_path'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][name]" id="hSName_{{ $i }}" value="{{ $story['name'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][origin]" id="hSOrigin_{{ $i }}" value="{{ $story['origin'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][origin_id]" id="hSOriginId_{{ $i }}" value="{{ $story['origin_id'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][quote]" id="hSQuote_{{ $i }}" value="{{ $story['quote'] ?? '' }}">
            <input type="hidden" name="stories[{{ $i }}][quote_id]" id="hSQuoteId_{{ $i }}" value="{{ $story['quote_id'] ?? '' }}">
        @endforeach
    </div>
</form>

{{-- Metadata --}}
@if($guestStoriesSettings?->updated_at)
<div class="lp-status-bar" style="margin-top:8px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved: <span style="color:#5a6a58; font-weight: 500;">{{ $guestStoriesSettings->updated_at->format('M j, Y H:i') }}</span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span><span class="lp-live-text">All systems operational</span>
    </div>
</div>
@endif


{{-- ════ MODAL: Add / Edit Story ════ --}}
<div class="modal-overlay" id="storyModal">
    <div class="modal-box" style="max-width:640px;">
        <div class="modal-header">
            <h3 class="modal-title" id="storyModalTitle">Add New Guest Story</h3>
            <button type="button" class="modal-close" onclick="closeModal('storyModal')">✕</button>
        </div>

        <div>
            <input type="hidden" id="editingStoryIndex" value="">

            {{-- Row 1: Shared Guest Identity --}}
            <div class="form-group" style="margin-bottom:16px;">
                <label class="form-label">Guest Name</label>
                <input type="text" class="form-input" id="storyNameInput" placeholder="e.g. Sarah Jenkins">
            </div>

            {{-- Row 2: Guest Origins (Bilingual) --}}
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:16px;">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Guest Origin (English)</label>
                    <input type="text" class="form-input" id="storyOriginInput" placeholder="e.g. Solo Traveler from Australia">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Guest Origin (Indonesia)</label>
                    <input type="text" class="form-input" id="storyOriginIdInput" placeholder="e.g. Wisatawan Solo dari Australia">
                </div>
            </div>

            {{-- Row 3: English Main Quote --}}
            <div class="form-group" style="margin-bottom:16px; padding:12px; background:#f9faf8; border-radius:6px; border:1px solid #e2e8e0;">
                <label class="form-label" style="color:#2e4a24; font-weight:700;">Main Quote (English)</label>
                <textarea class="form-textarea" id="storyQuoteInput" rows="3" maxlength="400"
                          oninput="document.getElementById('enCount').textContent = this.value.length"
                          placeholder="Share their experience in English..."></textarea>
                <div style="text-align:right;font-size:11px;color:#9aaa96;margin-top:4px;">
                    <span id="enCount">0</span> / 400 characters
                </div>
            </div>

            {{-- Row 4: Indonesian Main Quote --}}
            <div class="form-group" style="margin-bottom:16px; padding:12px; background:#f5f8f3; border-radius:6px; border:1px solid #dce4da;">
                <label class="form-label" style="color:#2e4a24; font-weight:700;">Main Quote (Indonesia)</label>
                <textarea class="form-textarea" id="storyQuoteIdInput" rows="3" maxlength="400"
                          oninput="document.getElementById('idCount').textContent = this.value.length"
                          placeholder="Bagikan pengalaman mereka dalam Bahasa Indonesia..."></textarea>
                <div style="text-align:right;font-size:11px;color:#9aaa96;margin-top:4px;">
                    <span id="idCount">0</span> / 400 characters
                </div>
            </div>

            {{-- Row 5: Media Upload Zone --}}
            <div class="form-group">
                <label class="form-label">Guest Avatar / Photo</label>
                <div class="upload-zone" id="storyImgZone"
                     onclick="document.getElementById('storyImgFileInput').click()"
                     style="padding:20px; border: 1.5px dashed #c4d0c0;">
                    <div id="storyModalImgPreviewWrap" style="display:none;margin-bottom:10px;">
                        <img id="storyModalImgPreview" src="" alt=""
                             style="width:80px;height:80px;object-fit:cover;border-radius:50%;display:block;margin:0 auto;box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    </div>
                    <div id="storyModalImgPlaceholder">
                        <svg width="24" height="24" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24" style="display:block;margin:0 auto 4px;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:13px;font-weight:600;color:#3a4a38;margin:0;text-align:center;">
                            Drag photo here or <span style="color:#d97706;">browse files</span>
                        </p>
                    </div>
                    <input type="file" id="storyImgFileInput" accept="image/*" style="display:none" onchange="previewStoryModalImg(this)">
                </div>
                <input type="hidden" id="modalStoryImgPath" value="">
                <input type="hidden" id="modalStoryImgDataUrl" value="">
            </div>

            <div class="modal-footer" style="margin-top:24px; padding-top:16px; border-top:1px solid #e9ece8;">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('storyModal')">Cancel</button>
                <button type="button" class="btn btn-dark" onclick="saveStory()">Save Story</button>
            </div>
        </div>
    </div>
</div>

<script>
let storyCount = {{ count($stories) }};

function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

/* Safe Bridge: Menarik data langsung dari DOM hidden inputs untuk menghindari crash karakter khusus */
function editStoryFromRow(i, thumbSrc) {
    const story = {
        name: document.getElementById(`hSName_${i}`)?.value ?? '',
        origin: document.getElementById(`hSOrigin_${i}`)?.value ?? '',
        origin_id: document.getElementById(`hSOriginId_${i}`)?.value ?? '',
        quote: document.getElementById(`hSQuote_${i}`)?.value ?? '',
        quote_id: document.getElementById(`hSQuoteId_${i}`)?.value ?? '',
        image_path: document.getElementById(`hSImgPath_${i}`)?.value ?? ''
    };
    openStoryModal(i, story, thumbSrc);
}

function openStoryModal(index, story, imgUrl) {
    const isEdit = index !== undefined;
    document.getElementById('storyModalTitle').textContent = isEdit ? 'Edit Guest Story' : 'Add New Guest Story';
    document.getElementById('editingStoryIndex').value = isEdit ? index : '';

    // Assign Values
    document.getElementById('storyNameInput').value     = story?.name ?? '';
    document.getElementById('storyOriginInput').value   = story?.origin ?? '';
    document.getElementById('storyOriginIdInput').value = story?.origin_id ?? '';
    document.getElementById('storyQuoteInput').value    = story?.quote ?? '';
    document.getElementById('storyQuoteIdInput').value  = story?.quote_id ?? '';
    document.getElementById('modalStoryImgPath').value  = story?.image_path ?? '';
    document.getElementById('modalStoryImgDataUrl').value = '';
    document.getElementById('storyImgFileInput').value  = '';
    
    // Refresh counters
    document.getElementById('enCount').textContent = (story?.quote ?? '').length;
    document.getElementById('idCount').textContent = (story?.quote_id ?? '').length;

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

function previewStoryModalImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('storyModalImgPreview').src = e.target.result;
        document.getElementById('storyModalImgPreviewWrap').style.display = 'block';
        document.getElementById('storyModalImgPlaceholder').style.display = 'none';
        document.getElementById('modalStoryImgDataUrl').value = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

function saveStory() {
    const idx      = document.getElementById('editingStoryIndex').value;
    const name     = document.getElementById('storyNameInput').value.trim();
    const origin   = document.getElementById('storyOriginInput').value.trim();
    const originId = document.getElementById('storyOriginIdInput').value.trim();
    const quote    = document.getElementById('storyQuoteInput').value.trim();
    const quoteId  = document.getElementById('storyQuoteIdInput').value.trim();
    const imgPath  = document.getElementById('modalStoryImgPath').value;
    const dataUrl  = document.getElementById('modalStoryImgDataUrl').value;
    const fileIn   = document.getElementById('storyImgFileInput');

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

    // Update target hidden inputs
    setH(`stories[${i}][image_path]`, `hSImgPath_${i}`, imgPath);
    setH(`stories[${i}][name]`,       `hSName_${i}`,       name);
    setH(`stories[${i}][origin]`,     `hSOrigin_${i}`,     origin);
    setH(`stories[${i}][origin_id]`,  `hSOriginId_${i}`,   originId);
    setH(`stories[${i}][quote]`,      `hSQuote_${i}`,      quote);
    setH(`stories[${i}][quote_id]`,   `hSQuoteId_${i}`,    quoteId);

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

    const thumbSrc = dataUrl || (imgPath ? `/storage/${imgPath}` : '');
    updateStoryRow(i, name, origin, originId, thumbSrc);
    closeModal('storyModal');
}

function updateStoryRow(i, name, origin, originId, thumbSrc) {
    const list = document.getElementById('storiesList');
    let row    = document.getElementById(`storyRow_${i}`);

    if (!row) {
        row = document.createElement('div');
        row.className = 'lp-flora-card-item';
        row.id        = `storyRow_${i}`;
        list.appendChild(row);
    }

    const initial   = (name || 'G').charAt(0).toUpperCase();
    const thumbHtml = thumbSrc
        ? `<img src="${thumbSrc}" alt="${name}" id="storyThumb_${i}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">`
        : `<div id="storyThumb_${i}" style="width:48px;height:48px;border-radius:50%;background:#e0e8dc;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#4a7c3f;">${initial}</div>`;

    row.innerHTML = `
        <div style="flex-shrink:0;">${thumbHtml}</div>
        <div class="lp-flora-text">
            <div class="lp-flora-title">${name}</div>
            <div class="lp-flora-desc">
                <span style="color:#1a3d0a;font-weight:500;">EN:</span> ${origin || 'No origin'} 
                <span style="color:#7a8a76;margin:0 6px;">|</span>
                <span style="color:#1a3d0a;font-weight:500;">ID:</span> ${originId || 'Belum ada asal'}
            </div>
        </div>
        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit" onclick="editStoryFromRow(${i}, '${thumbSrc}')">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </button>
            <button type="button" class="action-btn delete" title="Delete" onclick="removeStory(${i})">
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
    ['hSImgPath','hSName','hSOrigin','hSOriginId','hSQuote','hSQuoteId','hSFile'].forEach(prefix => {
        document.getElementById(`${prefix}_${i}`)?.remove();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof initDropZone === 'function') {
        initDropZone('storyImgZone', 'storyImgFileInput', file => {
            const r = new FileReader();
            r.onload = e => {
                document.getElementById('storyModalImgPreview').src = e.target.result;
                document.getElementById('storyModalImgPreviewWrap').style.display = 'block';
                document.getElementById('storyModalImgPlaceholder').style.display = 'none';
                document.getElementById('modalStoryImgDataUrl').value = e.target.result;
            };
            r.readAsDataURL(file);
        });
    }
});
</script>