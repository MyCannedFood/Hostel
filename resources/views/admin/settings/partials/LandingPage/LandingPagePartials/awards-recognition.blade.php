{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/awards-recognition.blade.php --}}

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:6px;">Edit Awards &amp; Recognition</h2>
<p style="color:#7a857f;font-size:13px;margin:0 0 24px;">
    Manage the accolades and certifications that highlight your commitment to sustainability and excellence.
</p>

@php
$awards = [
    ['id'=>1,'icon'=>null,'title'=>'Nature & Environment Award'],
    ['id'=>2,'icon'=>null,'title'=>'Sustainable Practices Recognition'],
];
@endphp

<div class="lp-card">
    <div class="lp-field">
        <label class="lp-field-label">Section Title</label>
        <input type="text" class="lp-input lp-heading-input" name="title"
               value="Awards and Recognition">
        <div style="display:flex;align-items:center;gap:6px;margin-top:8px;">
            <svg width="13" height="13" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
            </svg>
            <span style="font-size:12px;color:#d97706;">This will be displayed as the main header on the homepage section.</span>
        </div>
    </div>

    <p class="lp-card-label" style="margin-top:8px;">Added Awards</p>

    @foreach($awards as $award)
    <div class="lp-flora-card-item">
        {{-- Icon circle --}}
        <div style="width:40px;height:40px;border-radius:50%;background:#f0f4ee;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @if($award['icon'])
                <img src="{{ asset('storage/'.$award['icon']) }}" alt=""
                     style="width:24px;height:24px;object-fit:contain;">
            @else
                <svg width="20" height="20" fill="none" stroke="#4a7c3f" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="6"/>
                    <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                </svg>
            @endif
        </div>
        <div class="lp-flora-text">
            <div class="lp-flora-title">{{ $award['title'] }}</div>
        </div>
        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit"
                    onclick="openAwardModal({{ json_encode($award) }})">
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

    <button type="button" class="lp-dashed-btn" style="margin-top:16px;"
            onclick="openAwardModal()">
        + Add New Award
    </button>
</div>


{{-- ════ MODAL: Add / Edit Award ════ --}}
<div class="modal-overlay" id="awardModal">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <h3 class="modal-title" id="awardModalTitle">Add New Award</h3>
            <button type="button" class="modal-close" onclick="closeModal('awardModal')">✕</button>
        </div>

        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="award_id" id="awardId">

            <div class="form-group">
                <label class="form-label">Award Icon</label>
                <div style="display:flex;align-items:flex-start;gap:14px;">
                    {{-- Icon preview box --}}
                    <div style="width:72px;height:72px;border:1.5px dashed #c4d0c0;border-radius:10px;
                                display:flex;flex-direction:column;align-items:center;justify-content:center;
                                background:#fafcfa;flex-shrink:0;cursor:pointer;"
                         onclick="document.getElementById('awardIconInput').click()">
                        <svg width="22" height="22" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span style="font-size:9px;color:#b0b8b0;margin-top:4px;text-align:center;line-height:1.3;">
                            SVG/PNG
                        </span>
                    </div>
                    <div>
                        <label class="lp-upload-btn" style="margin-bottom:8px;display:inline-flex;">
                            Upload Icon
                            <input type="file" id="awardIconInput" name="award_icon"
                                   accept="image/svg+xml,image/png" style="display:none">
                        </label>
                        <p style="font-size:12px;color:#9aaa96;margin:0;line-height:1.5;">
                            Upload a minimalist botanical icon that represents<br>
                            this recognition. Preferred size: 200×200px.
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Award Title</label>
                <input type="text" class="lp-input" name="award_title" id="awardTitle"
                       placeholder="e.g., Nature & Environment Award">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('awardModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Award</button>
            </div>
        </form>
    </div>
</div>

<style>
.lp-dashed-btn {
    width:100%;padding:16px;border:1.5px dashed #c4d0c0;border-radius:10px;
    background:#fafcfa;font-size:13px;font-weight:600;color:#4a7c3f;
    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;
    transition:border-color .15s,background .15s;
}
.lp-dashed-btn:hover { border-color:#4a7c3f;background:#f4f9f4; }
</style>

<script>
function openAwardModal(award) {
    document.getElementById('awardModalTitle').textContent = award ? 'Edit Award' : 'Add New Award';
    document.getElementById('awardId').value    = award?.id ?? '';
    document.getElementById('awardTitle').value = award?.title ?? '';
    openModal('awardModal');
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
</script>