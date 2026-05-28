{{-- resources/views/admin/settings/partials/gallery-settings.blade.php --}}

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div style="margin-bottom:16px; padding:12px 16px; background:#e6f4e6; border:1px solid #a3d4a3; border-radius:10px; color:#2e7d32; font-size:13px; font-weight:600;">
        ✓ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="margin-bottom:16px; padding:12px 16px; background:#fdecea; border:1px solid #f5a5a5; border-radius:10px; color:#c62828; font-size:13px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin:6px 0 0 16px; padding:0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ── Header ── --}}
<div class="section-header">
    <h2 class="section-title">Gallery Settings</h2>
    <button class="btn btn-dark" onclick="openUploadModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
        </svg>
        Upload Foto
    </button>
</div>

{{-- ── Filters ── --}}
<form method="GET" action="{{ route('admin.settings') }}" id="filterForm">
    <input type="hidden" name="section" value="gallery">
    <div class="table-toolbar">
        <div class="table-filters">
            <select class="filter-select" name="category" onchange="document.getElementById('filterForm').submit()">
                <option value="all" {{ ($filterCategory ?? 'all') === 'all' ? 'selected' : '' }}>All Categories</option>
                @foreach(\App\Models\Gallery::CATEGORIES as $key => $label)
                    <option value="{{ $key }}" {{ ($filterCategory ?? 'all') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" name="status" onchange="document.getElementById('filterForm').submit()">
                <option value="all"     {{ ($filterStatus ?? 'all') === 'all'     ? 'selected' : '' }}>All Status</option>
                <option value="active"  {{ ($filterStatus ?? 'all') === 'active'  ? 'selected' : '' }}>Active</option>
                <option value="inactive"{{ ($filterStatus ?? 'all') === 'inactive'? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" class="sort-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
                Sort
            </button>
        </div>
    </div>
</form>

{{-- ── Table ── --}}
<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Title</th>
                <th>Categories</th>
                <th>Column</th>
                <th>Order</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($photos as $photo)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $photo->image_path) }}"
                         alt="{{ $photo->alt_text ?? $photo->title }}"
                         class="photo-thumb">
                </td>
                <td><strong>{{ $photo->title }}</strong></td>
                <td>{{ \App\Models\Gallery::CATEGORIES[$photo->category] ?? ucfirst($photo->category) }}</td>
                <td>{{ ucfirst($photo->column_placement) }}</td>
                <td>{{ $photo->order_number }}</td>
                <td>
                    <span class="badge {{ $photo->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                        {{ ucfirst($photo->status) }}
                    </span>
                </td>
                <td>
                    <div class="action-icons">
                        {{-- Edit --}}
                        <button class="action-btn" title="Edit"
                            onclick="openEditModal(
                                {{ $photo->id }},
                                '{{ addslashes($photo->title) }}',
                                '{{ $photo->category }}',
                                '{{ $photo->column_placement }}',
                                {{ $photo->order_number }},
                                '{{ $photo->status }}',
                                '{{ addslashes($photo->alt_text ?? '') }}',
                                '{{ asset('storage/' . $photo->image_path) }}'
                            )">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>

                        {{-- Delete --}}
                        <form method="POST"
                              action="{{ route('admin.gallery.destroy', $photo->id) }}"
                              onsubmit="return confirm('Hapus foto \'{{ addslashes($photo->title) }}\'?')"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" title="Delete">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4h6v2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:40px; color:#9aaa96; font-size:13px;">
                    Belum ada foto. Klik <strong>Upload Foto</strong> untuk menambahkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($photos->hasPages())
    <div class="pagination-wrap">
        <span class="pagination-info">
            Menampilkan {{ $photos->firstItem() }}–{{ $photos->lastItem() }} dari {{ $photos->total() }} foto
        </span>
        <div class="pagination-controls">
            {{-- Prev --}}
            @if($photos->onFirstPage())
                <button class="page-btn arrow" disabled>‹</button>
            @else
                <a href="{{ $photos->previousPageUrl() }}&section=gallery" class="page-btn arrow">‹</a>
            @endif

            {{-- Page numbers --}}
            @foreach($photos->getUrlRange(max(1, $photos->currentPage()-2), min($photos->lastPage(), $photos->currentPage()+2)) as $page => $url)
                @if($page == $photos->currentPage())
                    <button class="page-btn active">{{ $page }}</button>
                @else
                    <a href="{{ $url }}&section=gallery" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($photos->hasMorePages())
                <a href="{{ $photos->nextPageUrl() }}&section=gallery" class="page-btn arrow">›</a>
            @else
                <button class="page-btn arrow" disabled>›</button>
            @endif
        </div>
    </div>
    @else
    <div class="pagination-wrap">
        <span class="pagination-info">
            Menampilkan {{ $photos->count() }} dari {{ $photos->total() }} foto
        </span>
    </div>
    @endif
</div>


{{-- ════════════════════════════════════════
     MODAL: Upload Foto Baru
════════════════════════════════════════ --}}
<div class="modal-overlay" id="uploadModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title">Upload New Photo</h3>
            <button type="button" class="modal-close" onclick="closeUploadModal()">✕</button>
        </div>

        <form method="POST"
              action="{{ route('admin.gallery.store') }}"
              enctype="multipart/form-data"
              id="uploadForm">
            @csrf

            {{-- Drop Zone --}}
            <div class="upload-zone" id="uploadZone" onclick="document.getElementById('uploadFileInput').click()">
                <div class="upload-icon">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <polyline points="16 16 12 12 8 16"/>
                        <line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                    </svg>
                </div>
                <p class="upload-main-text" id="uploadZoneText">Click to upload or drag photo here</p>
                <p class="upload-sub-text">PNG, JPG, WEBP (MAX. 5MB). Recommended 1200×800px.</p>
                <input type="file" id="uploadFileInput" name="image" accept="image/*"
                       style="display:none" onchange="previewUpload(this)">
            </div>

            <div class="form-group">
                <label class="form-label">Photo Title</label>
                <input type="text" class="form-input" name="title"
                       placeholder="Example: Deluxe Terrace View"
                       value="{{ old('title') }}">
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category">
                        <option value="" disabled selected>Select Category</option>
                        @foreach(\App\Models\Gallery::CATEGORIES as $key => $label)
                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Column Placement</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="column_placement" value="left"
                                   {{ old('column_placement', 'left') === 'left' ? 'checked' : '' }}> Left
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="column_placement" value="right"
                                   {{ old('column_placement') === 'right' ? 'checked' : '' }}> Right
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row" style="margin-top:16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Order Number</label>
                    <input type="number" class="form-input" name="order_number"
                           value="{{ old('order_number', 1) }}" min="1">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Publication Status</label>
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="checkbox" name="activate_immediately" value="1"
                                   {{ old('activate_immediately', '1') ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-text">Activate Immediately</span>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label class="form-label">Alt Text Description (SEO)</label>
                <textarea class="form-textarea" name="alt_text"
                          placeholder="Describe what's in the photo for screen readers...">{{ old('alt_text') }}</textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeUploadModal()">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Photo</button>
            </div>
        </form>
    </div>
</div>


{{-- ════════════════════════════════════════
     MODAL: Edit Foto
════════════════════════════════════════ --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title">Edit Photo</h3>
            <button type="button" class="modal-close" onclick="closeEditModal()">✕</button>
        </div>

        <form method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Preview gambar saat ini --}}
            <div style="margin-bottom:16px;">
                <label class="form-label">Current Photo</label>
                <img id="editCurrentImg" src="" alt="Current Photo"
                     style="width:100%; max-height:180px; object-fit:cover; border-radius:10px; border:1px solid #dde3de;">
            </div>

            {{-- Upload gambar baru (opsional) --}}
            <div class="upload-zone" id="editDropZone" style="margin-bottom:16px;" onclick="document.getElementById('editFileInput').click()">
                <div class="upload-icon" style="font-size:22px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <polyline points="16 16 12 12 8 16"/>
                        <line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                    </svg>
                </div>
                <p class="upload-main-text" style="font-size:13px;" id="editZoneText">
                    Klik untuk ganti foto (opsional)
                </p>
                <p class="upload-sub-text">PNG, JPG, WEBP · MAX 5MB</p>
                <input type="file" id="editFileInput" name="image" accept="image/*"
                       style="display:none" onchange="previewEdit(this)">
            </div>

            <div class="form-group">
                <label class="form-label">Photo Title</label>
                <input type="text" class="form-input" name="title" id="editTitle" placeholder="Photo title">
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category" id="editCategory">
                        @foreach(\App\Models\Gallery::CATEGORIES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Column Placement</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="column_placement" id="editColLeft" value="left"> Left
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="column_placement" id="editColRight" value="right"> Right
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row" style="margin-top:16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Order Number</label>
                    <input type="number" class="form-input" name="order_number" id="editOrderNumber" min="1">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Publication Status</label>
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="checkbox" name="activate_immediately" id="editStatus" value="1">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-text">Active</span>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label class="form-label">Alt Text Description (SEO)</label>
                <textarea class="form-textarea" name="alt_text" id="editAltText"
                          placeholder="Describe what's in the photo..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Changes</button>
            </div>
        </form>
    </div>
</div>


<script>
/* ── Upload Modal ── */
function openUploadModal() {
    document.getElementById('uploadModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('open');
    document.body.style.overflow = '';
}

/* ══════════════════════════════════════════════════
   DRAG & DROP — helper terpusat
   Dipakai oleh upload zone (modal upload) dan edit zone (modal edit)
══════════════════════════════════════════════════ */

/**
 * Aktifkan drag-and-drop pada sebuah zone.
 * @param {string} zoneId       — id elemen drop zone
 * @param {string} fileInputId  — id <input type="file">
 * @param {Function} onFile     — callback(file) setelah file diterima
 */
function initDropZone(zoneId, fileInputId, onFile) {
    const zone  = document.getElementById(zoneId);
    const input = document.getElementById(fileInputId);
    if (!zone || !input) return;

    /* Cegah browser buka file secara langsung */
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
        zone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); });
        document.body.addEventListener(evt, e => e.preventDefault());
    });

    /* Visual feedback saat file di-hover */
    zone.addEventListener('dragenter', () => zone.classList.add('drag-over'));
    zone.addEventListener('dragover',  () => zone.classList.add('drag-over'));
    zone.addEventListener('dragleave', e => {
        /* Hanya hilangkan class kalau pointer benar-benar keluar zona */
        if (!zone.contains(e.relatedTarget)) zone.classList.remove('drag-over');
    });

    /* Drop handler */
    zone.addEventListener('drop', e => {
        zone.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (!file) return;

        /* Validasi tipe file di sisi klien */
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
            return;
        }

        /* Validasi ukuran (5MB) */
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file melebihi 5MB.');
            return;
        }

        /* Inject file ke input supaya bisa di-submit bersama form */
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;

        onFile(file);
    });
}

/* ── Preview helper ── */
function applyPreviewUpload(file) {
    document.getElementById('uploadZoneText').textContent = file.name;
}

function applyPreviewEdit(file) {
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('editCurrentImg').src = e.target.result;
    };
    reader.readAsDataURL(file);
    document.getElementById('editZoneText').textContent = file.name;
}

/* ── Inisialisasi setelah DOM siap ── */
document.addEventListener('DOMContentLoaded', () => {
    initDropZone('uploadZone', 'uploadFileInput', applyPreviewUpload);
    initDropZone('editDropZone', 'editFileInput', applyPreviewEdit);
});

/* ── Preview via klik (input onchange) ── */
function previewUpload(input) {
    if (input.files && input.files[0]) applyPreviewUpload(input.files[0]);
}
function previewEdit(input) {
    if (input.files && input.files[0]) {
        applyPreviewEdit(input.files[0]);
    }
}

/* ── Edit Modal ── */
function openEditModal(id, title, category, column, order, status, altText, imgUrl) {
    // Set form action ke route update dengan method spoofing
    const form = document.getElementById('editForm');
    form.action = '/admin/gallery/' + id;

    // Populate fields
    document.getElementById('editCurrentImg').src   = imgUrl;
    document.getElementById('editTitle').value      = title;
    document.getElementById('editOrderNumber').value = order;
    document.getElementById('editAltText').value    = altText;

    // Category select
    const catSelect = document.getElementById('editCategory');
    for (let i = 0; i < catSelect.options.length; i++) {
        catSelect.options[i].selected = catSelect.options[i].value === category;
    }

    // Column radio
    document.getElementById('editColLeft').checked  = column === 'left';
    document.getElementById('editColRight').checked = column === 'right';

    // Status toggle
    document.getElementById('editStatus').checked = status === 'active';

    // Reset file input & zone text
    document.getElementById('editFileInput').value = '';
    document.getElementById('editZoneText').textContent = 'Klik untuk ganti foto (opsional)';

    document.getElementById('editModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('open');
    document.body.style.overflow = '';
}

/* ── Close modal on backdrop click ── */
['uploadModal', 'editModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
});

/* ── Auto-open upload modal jika ada validation error dari store ── */
@if($errors->any() && old('_token'))
    document.addEventListener('DOMContentLoaded', () => openUploadModal());
@endif
</script>