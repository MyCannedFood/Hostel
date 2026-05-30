{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/flora-concept.blade.php --}}

@php $floraSettings ??= null; @endphp

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit The Flora Concept</h2>

<form method="POST" action="#" enctype="multipart/form-data" id="floraForm">
    @csrf @method('PUT')

    {{-- ── General Content ── --}}
    <div class="lp-card">
        <p class="lp-card-label">General Content</p>

        <div class="lp-field">
            <label class="lp-field-label">Section Title</label>
            <input type="text" class="lp-input lp-heading-input" name="title"
                   value="{{ $floraSettings->title ?? 'The Flora Concept' }}">
        </div>

        <div class="lp-field">
            <label class="lp-field-label">Section Description</label>
            <textarea class="lp-textarea" name="description"
                      rows="3">{{ $floraSettings->description ?? 'Our commitment to Indonesian biodiversity is reflected in every corner of AlaSare, from the herbs in our kitchen to the fibers in your linens.' }}</textarea>
        </div>
    </div>

    {{-- ── Flora Detail Cards ── --}}
    <div class="lp-card">
        <div class="lp-flora-cards-header">
            <p class="lp-card-label" style="margin:0;">Flora Detail Cards</p>
            <button type="button" class="btn btn-dark" style="font-size:13px; padding:8px 14px;"
                    onclick="openFloraCardModal()">
                + Add New Card
            </button>
        </div>

        <div id="floraCardsList">
            @php
            $floraCards = $floraSettings->cards ?? [
                ['id'=>1,'image'=>null,'title'=>'Home-Grown Ingredients',  'description'=>'32% of our kitchen produce is grown on-site...'],
                ['id'=>2,'image'=>null,'title'=>'The Scent of Java',        'description'=>'Daily botanical aromatics to soothe your senses...'],
                ['id'=>3,'image'=>null,'title'=>'Sustainable Fibers',       'description'=>'Linen and cotton textiles dyed with plant extracts...'],
            ];
            @endphp

            @foreach($floraCards as $card)
            <div class="lp-flora-card-item" data-id="{{ $card['id'] ?? loop->index }}">
                @if(!empty($card['image']))
                    <img src="{{ asset('storage/'.$card['image']) }}"
                         alt="{{ $card['title'] }}" class="lp-flora-thumb">
                @else
                    <div class="lp-flora-thumb-placeholder"></div>
                @endif
                <div class="lp-flora-text">
                    <div class="lp-flora-title">{{ $card['title'] }}</div>
                    <div class="lp-flora-desc">{{ $card['description'] }}</div>
                </div>
                <div class="action-icons">
                    <button type="button" class="action-btn" title="Edit"
                            onclick="openFloraCardModal({{ json_encode($card) }})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button type="button" class="action-btn delete" title="Delete"
                            onclick="deleteFloraCard(this, {{ $card['id'] ?? 0 }})">
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
</form>


{{-- ════════════════════════════════════════
     MODAL: Add / Edit Flora Card
════════════════════════════════════════ --}}
<div class="modal-overlay" id="floraCardModal">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <h3 class="modal-title" id="floraCardModalTitle">Add Flora Card</h3>
            <button type="button" class="modal-close" onclick="closeFloraCardModal()">✕</button>
        </div>

        <form method="POST" action="#" enctype="multipart/form-data" id="floraCardForm">
            @csrf

            <input type="hidden" name="card_id" id="floraCardId">

            {{-- Card Image --}}
            <div class="form-group">
                <label class="form-label">Card Image</label>
                <div class="lp-modal-upload-zone" onclick="document.getElementById('floraCardImg').click()">
                    <div id="floraCardImgPreviewWrap" style="display:none; margin-bottom:10px;">
                        <img id="floraCardImgPreview" src="" alt=""
                             style="width:100%; max-height:140px; object-fit:cover; border-radius:8px;">
                    </div>
                    <div id="floraCardUploadPlaceholder">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                    </div>
                    <button type="button" class="lp-modal-upload-btn" style="margin-top:8px;">
                        Change Image
                    </button>
                    <input type="file" id="floraCardImg" name="card_image" accept="image/*"
                           style="display:none" onchange="previewFloraCardImg(this)">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Card Title</label>
                <input type="text" class="form-input" name="card_title" id="floraCardTitle"
                       placeholder="e.g. Home-Grown Ingredients">
            </div>

            <div class="form-group">
                <label class="form-label">Card Description</label>
                <textarea class="form-textarea" name="card_description" id="floraCardDesc"
                          rows="3" placeholder="Describe this flora concept..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeFloraCardModal()">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Card</button>
            </div>
        </form>
    </div>
</div>


<script>
/* ── Flora Card Modal ── */
function openFloraCardModal(card) {
    const isEdit = card && card.id;
    document.getElementById('floraCardModalTitle').textContent = isEdit ? 'Edit Flora Card' : 'Add Flora Card';
    document.getElementById('floraCardId').value    = card?.id ?? '';
    document.getElementById('floraCardTitle').value = card?.title ?? '';
    document.getElementById('floraCardDesc').value  = card?.description ?? '';

    // Reset image preview
    const previewWrap = document.getElementById('floraCardImgPreviewWrap');
    const preview     = document.getElementById('floraCardImgPreview');
    const placeholder = document.getElementById('floraCardUploadPlaceholder');
    if (card?.image) {
        preview.src = '/storage/' + card.image;
        previewWrap.style.display = 'block';
        placeholder.style.display = 'none';
    } else {
        previewWrap.style.display = 'none';
        placeholder.style.display = 'block';
    }

    document.getElementById('floraCardModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeFloraCardModal() {
    document.getElementById('floraCardModal').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('floraCardForm').reset();
}

function previewFloraCardImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('floraCardImgPreview');
            const wrap    = document.getElementById('floraCardImgPreviewWrap');
            const ph      = document.getElementById('floraCardUploadPlaceholder');
            preview.src           = e.target.result;
            wrap.style.display    = 'block';
            ph.style.display      = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function deleteFloraCard(btn, id) {
    if (!confirm('Hapus card ini?')) return;
    btn.closest('.lp-flora-card-item').remove();
    // TODO: backend delete via AJAX / form
}

document.getElementById('floraCardModal').addEventListener('click', function(e) {
    if (e.target === this) closeFloraCardModal();
});
</script>