{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/media-partners.blade.php --}}

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Media &amp; Partners</h2>

@php
$partners = [
    ['id'=>1,'logo'=>null,'name'=>'Travel + Leisure','url'=>''],
    ['id'=>2,'logo'=>null,'name'=>'National Geographic','url'=>''],
];
@endphp

<div class="lp-card">
    <div class="lp-field">
        <label class="lp-field-label">Section Title</label>
        <input type="text" class="lp-input lp-heading-input" name="title"
               value="Media and Partners">
    </div>

    <p class="lp-card-label" style="margin-top:8px;">Added Partners</p>

    @foreach($partners as $partner)
    <div class="lp-flora-card-item">
        {{-- Logo thumbnail --}}
        <div style="width:52px;height:40px;border-radius:7px;background:#f0f4ee;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;
                    border:1px solid #e0e8de;">
            @if($partner['logo'])
                <img src="{{ asset('storage/'.$partner['logo']) }}" alt="{{ $partner['name'] }}"
                     style="width:44px;height:32px;object-fit:contain;">
            @else
                <svg width="20" height="20" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="2" y="6" width="20" height="12" rx="2"/>
                    <path d="M6 12h.01M10 12h.01M14 12h4"/>
                </svg>
            @endif
        </div>

        <div class="lp-flora-text">
            <div class="lp-flora-title">{{ $partner['name'] }}</div>
            @if($partner['url'])
                <div class="lp-flora-desc">{{ $partner['url'] }}</div>
            @endif
        </div>

        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit"
                    onclick="openPartnerModal({{ json_encode($partner) }})">
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
            onclick="openPartnerModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
        </svg>
        + Add New Partner
    </button>
</div>


{{-- ════ MODAL: Add / Edit Partner ════ --}}
<div class="modal-overlay" id="partnerModal">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <h3 class="modal-title" id="partnerModalTitle">Add New Partner</h3>
            <button type="button" class="modal-close" onclick="closeModal('partnerModal')">✕</button>
        </div>

        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="partner_id" id="partnerId">

            {{-- Logo Upload ── --}}
            <div class="form-group">
                <label class="form-label">Partner Logo (Monochrome)</label>
                <div style="display:flex;align-items:center;gap:14px;">
                    {{-- Logo preview box --}}
                    <div id="partnerLogoWrap"
                         style="width:72px;height:64px;border:1.5px dashed #c4d0c0;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;
                                background:#fafcfa;flex-shrink:0;overflow:hidden;cursor:pointer;"
                         onclick="document.getElementById('partnerLogoInput').click()">
                        <div id="partnerLogoPlaceholder">
                            <svg width="28" height="28" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24">
                                <polyline points="16 16 12 12 8 16"/>
                                <line x1="12" y1="12" x2="12" y2="21"/>
                                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                            </svg>
                        </div>
                        <img id="partnerLogoPreview" src="" alt=""
                             style="display:none;width:100%;height:100%;object-fit:contain;padding:6px;">
                    </div>

                    <div>
                        <label class="lp-upload-btn" style="margin-bottom:8px;display:inline-flex;">
                            Upload Logo
                            <input type="file" id="partnerLogoInput" name="partner_logo"
                                   accept="image/svg+xml,image/png" style="display:none"
                                   onchange="previewPartnerLogo(this)">
                        </label>
                        <p style="font-size:12px;color:#9aaa96;margin:0;">
                            PNG or SVG, monochrome preferred.
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Partner Name</label>
                <input type="text" class="form-input" name="partner_name" id="partnerName"
                       placeholder="e.g., National Geographic">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Website URL (Optional)</label>
                <input type="url" class="form-input" name="partner_url" id="partnerUrl"
                       placeholder="https://...">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('partnerModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Partner</button>
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
function openPartnerModal(partner) {
    document.getElementById('partnerModalTitle').textContent = partner ? 'Edit Partner' : 'Add New Partner';
    document.getElementById('partnerId').value   = partner?.id ?? '';
    document.getElementById('partnerName').value = partner?.name ?? '';
    document.getElementById('partnerUrl').value  = partner?.url ?? '';

    const preview = document.getElementById('partnerLogoPreview');
    const ph      = document.getElementById('partnerLogoPlaceholder');
    if (partner?.logo) {
        preview.src          = '/storage/' + partner.logo;
        preview.style.display = 'block';
        ph.style.display     = 'none';
    } else {
        preview.style.display = 'none';
        ph.style.display     = 'flex';
    }
    openModal('partnerModal');
}

function previewPartnerLogo(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('partnerLogoPreview');
        const ph      = document.getElementById('partnerLogoPlaceholder');
        preview.src          = e.target.result;
        preview.style.display = 'block';
        ph.style.display     = 'none';
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
</script>