{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/guest-stories.blade.php --}}

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Guest Stories</h2>

{{-- ── Section Title ── --}}
<div class="lp-card">
    <div class="lp-field">
        <label class="lp-field-label">Section Title</label>
        <input type="text" class="lp-input lp-heading-input" name="title"
               value="Guest Stories">
        <div style="display:flex;align-items:center;gap:6px;margin-top:8px;">
            <svg width="13" height="13" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
            </svg>
            <span style="font-size:12px;color:#d97706;">This appears at the top of the guest experience section.</span>
        </div>
    </div>
</div>

{{-- ── Current Stories list ── --}}
<div class="lp-card">
    <div class="lp-flora-cards-header">
        <p style="font-size:15px;font-weight:700;color:#1a3d0a;margin:0;">Current Stories</p>
        <button type="button" class="btn btn-dark" style="font-size:13px;padding:8px 14px;"
                onclick="openGuestStoryModal()">
            + Add New Story
        </button>
    </div>

    @php
    $stories = [
        ['id'=>1,'name'=>'Dr. Maria da Silva','origin'=>'Guest from Portugal','image'=>null],
        ['id'=>2,'name'=>'Jameson Thorne',    'origin'=>'Guest from Canada',   'image'=>null],
    ];
    @endphp

    @foreach($stories as $story)
    <div class="lp-flora-card-item">
        @if($story['image'])
            <img src="{{ asset('storage/'.$story['image']) }}" alt="{{ $story['name'] }}"
                 style="width:48px;height:48px;border-radius:50%;object-fit:cover;flex-shrink:0;">
        @else
            <div style="width:48px;height:48px;border-radius:50%;background:#e0e8dc;
                        display:flex;align-items:center;justify-content:center;
                        font-size:16px;font-weight:700;color:#4a7c3f;flex-shrink:0;">
                {{ strtoupper(substr($story['name'],0,1)) }}
            </div>
        @endif
        <div class="lp-flora-text">
            <div class="lp-flora-title">{{ $story['name'] }}</div>
            <div class="lp-flora-desc">{{ $story['origin'] }}</div>
        </div>
        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit"
                    onclick="openGuestStoryModal({{ json_encode($story) }})">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </button>
            <button type="button" class="action-btn delete" title="Delete">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
            </button>
        </div>
    </div>
    @endforeach
</div>


{{-- ════ MODAL: Add / Edit Guest Story ════ --}}
<div class="modal-overlay" id="guestStoryModal">
    <div class="modal-box" style="max-width:540px;">
        <div class="modal-header">
            <h3 class="modal-title" id="guestStoryModalTitle">Add New Guest Story</h3>
            <button type="button" class="modal-close" onclick="closeModal('guestStoryModal')">✕</button>
        </div>

        <form method="POST" action="#" enctype="multipart/form-data" id="guestStoryForm">
            @csrf
            <input type="hidden" name="story_id" id="storyId">

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Guest Name</label>
                    <input type="text" class="form-input" name="guest_name" id="storyName"
                           placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Guest Origin</label>
                    <input type="text" class="form-input" name="guest_origin" id="storyOrigin"
                           placeholder="e.g. Guest from Australia">
                </div>
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label class="form-label">Main Quote</label>
                <textarea class="form-textarea" name="quote" id="storyQuote" rows="4"
                          maxlength="300"
                          placeholder="Share their experience at AlaSare..."></textarea>
                <div style="text-align:right;font-size:11px;color:#9aaa96;margin-top:4px;">
                    Maximum 300 characters recommended.
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Side Image</label>
                <div class="upload-zone" id="storyImgZone"
                     onclick="document.getElementById('storyImgInput').click()"
                     style="padding:28px 20px;">
                    <div id="storyImgPreviewWrap" style="display:none;margin-bottom:10px;">
                        <img id="storyImgPreview" src="" alt=""
                             style="width:100%;max-height:140px;object-fit:cover;border-radius:8px;">
                    </div>
                    <div id="storyImgPlaceholder">
                        <svg width="32" height="32" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p style="font-size:14px;font-weight:600;color:#3a4a38;margin:0 0 4px;">
                            Drag and drop guest photo here
                        </p>
                        <p style="font-size:13px;color:#9aaa96;margin:0;">
                            or <span style="color:#d97706;font-weight:600;cursor:pointer;">browse files</span>
                        </p>
                        <p style="font-size:11px;color:#b0b8b0;margin:8px 0 0;text-transform:uppercase;letter-spacing:.5px;">
                            JPG, PNG up to 5MB (Square aspect ratio recommended)
                        </p>
                    </div>
                    <input type="file" id="storyImgInput" name="side_image" accept="image/*"
                           style="display:none" onchange="previewStoryImg(this)">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('guestStoryModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Story</button>
            </div>
        </form>
    </div>
</div>

<script>
function openGuestStoryModal(story) {
    document.getElementById('guestStoryModalTitle').textContent =
        story ? 'Edit Guest Story' : 'Add New Guest Story';
    document.getElementById('storyId').value    = story?.id ?? '';
    document.getElementById('storyName').value  = story?.name ?? '';
    document.getElementById('storyOrigin').value= story?.origin ?? '';
    document.getElementById('storyQuote').value = story?.quote ?? '';

    const wrap = document.getElementById('storyImgPreviewWrap');
    const ph   = document.getElementById('storyImgPlaceholder');
    if (story?.image) {
        document.getElementById('storyImgPreview').src = '/storage/'+story.image;
        wrap.style.display = 'block'; ph.style.display = 'none';
    } else {
        wrap.style.display = 'none'; ph.style.display = 'block';
    }
    openModal('guestStoryModal');
}

function previewStoryImg(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('storyImgPreview').src = e.target.result;
        document.getElementById('storyImgPreviewWrap').style.display = 'block';
        document.getElementById('storyImgPlaceholder').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}

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

// Init drag-and-drop
document.addEventListener('DOMContentLoaded', () => {
    initDropZone('storyImgZone','storyImgInput', file => {
        const r = new FileReader();
        r.onload = e => {
            document.getElementById('storyImgPreview').src = e.target.result;
            document.getElementById('storyImgPreviewWrap').style.display='block';
            document.getElementById('storyImgPlaceholder').style.display='none';
        };
        r.readAsDataURL(file);
    });
});
</script>