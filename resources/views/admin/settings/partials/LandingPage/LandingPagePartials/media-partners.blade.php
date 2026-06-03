{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/media-partners.blade.php --}}

@php
    $mediaPartnersSettings ??= null;

    // Merge DB data dengan DEFAULTS
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['media_partners'],
        $mediaPartnersSettings?->data ?? []
    );

    $partners = $d['partners'] ?? [];
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

<h2 class="section-title" style="margin-bottom:24px;">Edit Media &amp; Partners</h2>

<form method="POST"
      action="{{ route('admin.landing.media-partners.update') }}"
      enctype="multipart/form-data"
      id="mediaPartnersForm">
    @csrf @method('PUT')

    <div class="lp-card">
        <div class="lp-field">
            <label class="lp-field-label">Section Title</label>
            <input type="text" class="lp-input lp-heading-input" name="title"
                   value="{{ old('title', $d['title']) }}" maxlength="100">
        </div>

        <p class="lp-card-label" style="margin-top:20px;">Added Partners</p>

        <div id="partnersList">
            @forelse($partners as $idx => $partner)
            <div class="lp-flora-card-item" data-index="{{ $idx }}" data-name="{{ $partner['name'] }}" data-url="{{ $partner['url'] ?? '' }}" data-logo="{{ $partner['logo_path'] ?? '' }}">
                {{-- Logo thumbnail --}}
                <div style="width:52px;height:40px;border-radius:7px;background:#f0f4ee;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                            border:1px solid #e0e8de;">
                    @if(!empty($partner['logo_path']))
                        <img src="{{ asset('storage/'.$partner['logo_path']) }}" alt="{{ $partner['name'] }}"
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
                    @if(!empty($partner['url']))
                        <div class="lp-flora-desc">{{ $partner['url'] }}</div>
                    @endif
                </div>

                <div class="action-icons">
                    <button type="button" class="action-btn" title="Edit"
                            onclick="editPartner({{ $idx }})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button type="button" class="action-btn delete" title="Delete" onclick="removePartner({{ $idx }})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <p style="color:#9aaa96;font-size:13px;text-align:center;padding:24px;">
                No partners added yet.
            </p>
            @endforelse
        </div>

        <button type="button" class="lp-dashed-btn" style="margin-top:16px;"
                onclick="openPartnerModal()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
            </svg>
            + Add New Partner
        </button>
    </div>

    {{-- HIDDEN INPUTS FOR FORM SUBMISSION - Direct children of form --}}
    <div id="partnersDataInputs" style="display:none;"></div>

    <div style="margin-top:24px;display:flex;gap:12px;justify-content:flex-end;">
        <a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-dark">Save Changes</button>
    </div>
</form>


{{-- ════ MODAL: Add / Edit Partner ════ --}}
<div class="modal-overlay" id="partnerModal">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <h3 class="modal-title" id="partnerModalTitle">Add New Partner</h3>
            <button type="button" class="modal-close" onclick="closeModal('partnerModal')">✕</button>
        </div>

        <div id="partnerFormContainer">
            {{-- Form fields will be injected here --}}
        </div>
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

.btn {
    padding:10px 20px;border-radius:6px;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:.2s;
}
.btn-dark {
    background:#1a3d0a;color:#fff;
}
.btn-dark:hover {
    background:#0f2800;
}
.btn-gray {
    background:#e0e8de;color:#2a3d2a;
}
.btn-gray:hover {
    background:#d0dace;
}
</style>

<script>
let currentPartnerIndex = null;
let partnerFiles = {}; // Store files temporarily
let partnersData = [];  // Store all partner data

// Initialize from DOM on page load
document.addEventListener('DOMContentLoaded', function() {
    syncPartnersFromDOM();
});

function syncPartnersFromDOM() {
    const items = document.querySelectorAll('#partnersList .lp-flora-card-item');
    partnersData = [];
    items.forEach((item, idx) => {
        partnersData.push({
            index: idx,
            name: item.dataset.name,
            url: item.dataset.url,
            logo_path: item.dataset.logo,
            style: ''
        });
    });
}

function openPartnerModal(index, data) {
    currentPartnerIndex = (index !== undefined) ? index : null;
    const isEdit = data !== undefined;
    
    document.getElementById('partnerModalTitle').textContent = isEdit ? 'Edit Partner' : 'Add New Partner';

    const partnerData = data || {name: '', url: '', logo_path: null, style: ''};
    
    const formHTML = `
        <form id="partnerForm" onsubmit="savePartner(event)">
            {{-- Logo Upload ── --}}
            <div class="form-group">
                <label class="form-label">Partner Logo (Monochrome)</label>
                <div style="display:flex;align-items:center;gap:14px;">
                    <div id="partnerLogoWrap"
                         style="width:72px;height:64px;border:1.5px dashed #c4d0c0;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;
                                background:#fafcfa;flex-shrink:0;overflow:hidden;cursor:pointer;"
                         onclick="document.getElementById('partnerLogoInput').click()">
                        <div id="partnerLogoPlaceholder" ${!partnerData.logo_path ? '' : 'style="display:none;"'}>
                            <svg width="28" height="28" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24">
                                <polyline points="16 16 12 12 8 16"/>
                                <line x1="12" y1="12" x2="12" y2="21"/>
                                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                            </svg>
                        </div>
                        <img id="partnerLogoPreview" src="${partnerData.logo_path ? '/storage/' + partnerData.logo_path : ''}" alt=""
                             style="display:${partnerData.logo_path ? 'block' : 'none'};width:100%;height:100%;object-fit:contain;padding:6px;">
                    </div>

                    <div>
                        <label class="lp-upload-btn" style="margin-bottom:8px;display:inline-flex;">
                            Upload Logo
                            <input type="file" id="partnerLogoInput" 
                                   accept="image/svg+xml,image/png,image/jpeg" style="display:none"
                                   onchange="previewPartnerLogo(this)">
                        </label>
                        <p style="font-size:12px;color:#9aaa96;margin:0;">
                            PNG, SVG, or JPG. Monochrome preferred.
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Partner Name <span style="color:#c62828;">*</span></label>
                <input type="text" class="form-input" id="partnerName"
                       value="${escapeHtml(partnerData.name)}"
                       placeholder="e.g., National Geographic" required>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Website URL (Optional)</label>
                <input type="url" class="form-input" id="partnerUrl"
                       value="${escapeHtml(partnerData.url)}"
                       placeholder="https://...">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-gray" onclick="closeModal('partnerModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Partner</button>
            </div>
        </form>
    `;
    
    document.getElementById('partnerFormContainer').innerHTML = formHTML;
    openModal('partnerModal');
}

function savePartner(e) {
    e.preventDefault();
    
    const name = document.getElementById('partnerName').value.trim();
    const url = document.getElementById('partnerUrl').value.trim();
    const logoInput = document.getElementById('partnerLogoInput');
    const logoFile = logoInput?.files[0] || null;
    
    if (!name) {
        alert('Partner name is required.');
        return;
    }

    const partners = document.getElementById('partnersList');
    let index = currentPartnerIndex !== null ? currentPartnerIndex : partners.children.length;

    if (currentPartnerIndex !== null) {
        // Edit existing - remove old item
        const item = partners.querySelector(`[data-index="${index}"]`);
        if (item) item.remove();
    }

    // Create new item
    const displayLogoSrc = logoFile 
        ? URL.createObjectURL(logoFile)
        : (document.getElementById('partnerLogoPreview')?.src || null);
    
    const displayLogo = displayLogoSrc 
        ? `<img src="${displayLogoSrc}" alt="${escapeHtml(name)}" style="width:44px;height:32px;object-fit:contain;">`
        : `<svg width="20" height="20" fill="none" stroke="#9aaa96" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 12h.01M10 12h.01M14 12h4"/></svg>`;

    const newItem = document.createElement('div');
    newItem.className = 'lp-flora-card-item';
    newItem.setAttribute('data-index', index);
    newItem.setAttribute('data-name', name);
    newItem.setAttribute('data-url', url);
    newItem.setAttribute('data-logo', ''); // Will be updated on actual upload

    let itemHTML = `
        <div style="width:52px;height:40px;border-radius:7px;background:#f0f4ee;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;
                    border:1px solid #e0e8de;">
            ${displayLogo}
        </div>

        <div class="lp-flora-text">
            <div class="lp-flora-title">${escapeHtml(name)}</div>
            ${url ? `<div class="lp-flora-desc">${escapeHtml(url)}</div>` : ''}
        </div>

        <div class="action-icons">
            <button type="button" class="action-btn" title="Edit" onclick="editPartner(${index})">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </button>
            <button type="button" class="action-btn delete" title="Delete" onclick="removePartner(${index})">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
            </button>
        </div>
    `;

    newItem.innerHTML = itemHTML;
    partners.appendChild(newItem);

    // Store file if present
    if (logoFile) {
        partnerFiles[index] = logoFile;
    }

    syncPartnersFromDOM();
    closeModal('partnerModal');
    currentPartnerIndex = null;
}

function editPartner(index) {
    const item = document.querySelector(`[data-index="${index}"]`);
    if (!item) return;
    
    const partner = {
        name: item.dataset.name,
        url: item.dataset.url,
        logo_path: item.dataset.logo || null
    };
    openPartnerModal(index, partner);
}

function removePartner(index) {
    if (!confirm('Are you sure you want to remove this partner?')) return;
    
    const item = document.querySelector(`[data-index="${index}"]`);
    if (item) item.remove();
    
    if (partnerFiles[index]) {
        delete partnerFiles[index];
    }
    
    syncPartnersFromDOM();
}

function previewPartnerLogo(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('partnerLogoPreview');
        const ph = document.getElementById('partnerLogoPlaceholder');
        preview.src = e.target.result;
        preview.style.display = 'block';
        ph.style.display = 'none';
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

function escapeHtml(text) {
    const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
    return (text || '').replace(/[&<>"']/g, m => map[m]);
}

document.getElementById('partnerModal')?.addEventListener('click', e => {
    if (e.target === e.currentTarget) closeModal('partnerModal');
});

// Handle form submission
document.getElementById('mediaPartnersForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('title', document.querySelector('input[name="title"]').value);
    formData.append('_method', 'PUT');
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    // Add all partners
    const items = document.querySelectorAll('#partnersList .lp-flora-card-item');
    items.forEach((item, idx) => {
        formData.append(`partners[${idx}][name]`, item.dataset.name);
        formData.append(`partners[${idx}][url]`, item.dataset.url);
        formData.append(`partners[${idx}][logo_path]`, item.dataset.logo || '');
        formData.append(`partners[${idx}][style]`, '');
        
        // Add file if exists
        const dataIndex = item.dataset.index;
        if (partnerFiles[dataIndex]) {
            formData.append(`partners[${idx}][logo]`, partnerFiles[dataIndex]);
        }
    });

    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            window.location.href = response.url || window.location.href;
        } else {
            const text = await response.text();
            console.error('Response:', text);
            alert('Error: ' + (response.statusText || 'Unknown error'));
        }
    } catch (err) {
        console.error('Error:', err);
        alert('Error saving partners: ' + err.message);
    }
});
</script>