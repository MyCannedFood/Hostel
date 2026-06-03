{{-- resources/views/admin/settings/partials/contact-location-settings.blade.php --}}

<link rel="stylesheet"
href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />

<style>
/* ── Location & Contact Settings ── */
.lp-card {
    background: #fff;
    border: 1px solid #e2e8de;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 20px;
}
.lp-card-header {
    display: flex;
    align-items: center;
    gap: 9px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f4ee;
    margin-bottom: 20px;
}
.lp-card-header.spaced { justify-content: space-between; }
.lp-card-icon {
    width: 28px; height: 28px;
    background: #eef5ec;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.lp-card-title { font-size: 16px; font-weight: 700; color: #2d6a1e; margin: 0; }

.page-header { margin-bottom: 28px; }
.page-title  { font-size: 26px; font-weight: 700; color: #1a3d0a; letter-spacing: -0.3px; margin-bottom: 4px; }
.page-sub    { font-size: 14px; color: #7a857f; }

.alert-success {
    margin-bottom: 16px; padding: 12px 16px;
    background: #e6f4e6; border: 1px solid #a3d4a3;
    border-radius: 8px; color: #2e7d32;
    font-size: 13px; font-weight: 600;
    display: none;
}
.alert-success.show { display: block; }

.form-group    { margin-bottom: 16px; }
.form-label    {
    display: block; font-size: 11.5px; font-weight: 600;
    color: #4a5a46; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 6px;
}
.form-input, .form-textarea, .form-select {
    width: 100%; padding: 10px 12px;
    border: 1.5px solid #c8d5c4; border-radius: 8px;
    font-size: 14px; color: #1a3d0a;
    background: #fff; outline: none;
    transition: border-color 0.15s; font-family: inherit;
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
    border-color: #2d6a1e;
    box-shadow: 0 0 0 3px rgba(45,106,30,0.08);
}
.form-textarea { resize: vertical; min-height: 80px; line-height: 1.5; }
.form-row      { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-error    { font-size: 12px; color: #c62828; margin-top: 4px; }
.is-invalid    { border-color: #c62828 !important; }

.select-wrap  { position: relative; }
.select-icon  {
    position: absolute; left: 11px; top: 50%;
    transform: translateY(-50%);
    pointer-events: none; color: #4a5a46;
    display: flex; align-items: center;
}
.form-select  { padding-left: 36px; }

.info-box {
    display: flex; align-items: flex-start; gap: 7px;
    background: #f0f9f4; border: 1px solid #b8dfc4;
    border-radius: 8px; padding: 10px 12px;
    font-size: 12.5px; color: #2d6a1e; margin-top: 10px;
}
.info-box svg { flex-shrink: 0; margin-top: 1px; }

.btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 2px;
    font-size: 13.5px; font-weight: 600;
    cursor: pointer; border: none;
    transition: all 0.15s; font-family: inherit;
}
.btn:active   { transform: scale(0.97); }
.btn-dark     { background: #1a3d0a; color: #fff; }
.btn-dark:hover { background: #1a5213; }
.btn-cancel   { background: #D9864A; color: #fff; }
.btn-cancel:hover  { background: #C6783F; }
.btn-sm       { padding: 7px 14px; font-size: 12.5px; }
.form-footer  { display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px; padding-bottom: 8px; }

.add-route-btn {
    width: 100%; background: none;
    border: 1.5px dashed #c8d5c4; border-radius: 8px;
    padding: 9px 14px; font-size: 13px;
    color: #2d6a1e; cursor: pointer;
    font-family: inherit; font-weight: 600;
}
.add-route-btn:hover { background: #f0f4ee; }

.transport-item {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 4px; border-bottom: 1px solid #f0f4ee;
}
.transport-item:last-child { border-bottom: none; }
.transport-icon {
    width: 40px; height: 40px; border-radius: 50%;
    background: #D9864A; color: #fff;
    display: flex; align-items: center; justify-content: center;
}
.transport-name  { font-size: 14px; font-weight: 600; color: #1a3d0a; }
.transport-empty { text-align: center; padding: 36px 20px; color: #9aaa96; font-size: 13px; }
.action-icons    { display: flex; gap: 6px; }
.action-btn {
    background: none; border: none; cursor: pointer;
    width: 30px; height: 30px; border-radius: 2px;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s;
}
.action-btn.del          { color: #D9864A; }
.action-btn.del:hover    { background: #FDF1E8; color: #C6783F; }
.action-btn:not(.del)    { color: #1A3D0A; }
.action-btn:not(.del):hover { background: #EDF5EF; }

.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.5); z-index: 999;
    align-items: center; justify-content: center; padding: 20px;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: #fff; border-radius: 8px;
    width: 100%; max-width: 480px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.18); overflow: hidden;
}
.modal-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px 14px; border-bottom: 1px solid #e2e8de;
}
.modal-head h3 { font-size: 16px; font-weight: 700; color: #1a3d0a; margin: 0; }
.modal-close {
    background: none; border: none; cursor: pointer; font-size: 16px;
    color: #7a857f; width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s;
}
.modal-close:hover { background: #f0f4ee; }
.modal-body  { padding: 20px 22px; max-height: 65vh; overflow-y: auto; }
.modal-foot  { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 22px; border-top: 1px solid #e2e8de; }

.route-row {
    display: flex; align-items: center; gap: 8px;
    background: #fff; border: 1.5px solid #c8d5c4;
    border-radius: 8px; padding: 8px 12px; margin-bottom: 8px;
}
.route-input {
    flex: 1; border: none; outline: none;
    font-size: 13px; color: #1a3d0a;
    background: transparent; font-family: inherit;
}
.route-input::placeholder { color: #b0b8b0; }
.route-remove {
    background: none; border: none; cursor: pointer;
    color: #d97706; display: flex; align-items: center; padding: 0 2px;
}
.route-remove:hover { color: #c62828; }
</style>




    {{-- Flash success --}}
    @if(session('success'))
    <div class="alert-success show">✓ {{ session('success') }}</div>
    @endif

    <div class="page-header">
        <h2 class="page-title">Location & Contact Settings</h2>
        <p class="page-sub">Manage public contact details and system routing.</p>
    </div>

    {{-- ── CARD 1: Public Contact Info ────────────────────────────────── --}}
    <form method="POST" action="{{ route('admin.settings.location.update') }}" id="settingsForm">
        @csrf

        <div class="lp-card">
            <div class="lp-card-header">
                <span class="lp-card-icon">
                    <svg width="14" height="14" fill="none" stroke="#2d6a1e" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                </span>
                <h3 class="lp-card-title">Public Contact Information</h3>
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Address</label>
                <textarea class="form-textarea @error('address') is-invalid @enderror"
                    id="address" name="address" rows="3"
                    placeholder="e.g., Jl. Prof. Dr. Sutami No 62, Bandung...">{{ old('address', $address ?? '') }}</textarea>
                @error('address')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="text" class="form-input @error('phone') is-invalid @enderror"
                        id="phone" name="phone"
                        value="{{ old('phone', $phone ?? '') }}" placeholder="+62 812 3456 7890">
                    @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label" for="public_email">Public Email</label>
                    <input type="email" class="form-input @error('public_email') is-invalid @enderror"
                        id="public_email" name="public_email"
                        value="{{ old('public_email', $publicEmail ?? '') }}" placeholder="hello@example.com">
                    @error('public_email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group" style="margin-top:16px;margin-bottom:0">
                <label class="form-label" for="maps_link">Google Maps Link</label>
                <input type="url" class="form-input @error('maps_link') is-invalid @enderror"
                    id="maps_link" name="maps_link"
                    value="{{ old('maps_link', $mapsLink ?? '') }}" placeholder="https://maps.google.com/...">
                @error('maps_link')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- ── CARD 2: System Config ─────────────────────────────────────── --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <span class="lp-card-icon">
                    <svg width="14" height="14" fill="none" stroke="#2d6a1e" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/>
                        <polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/>
                    </svg>
                </span>
                <h3 class="lp-card-title">System Configuration</h3>
            </div>

            <div class="form-group" style="margin-bottom:0">
                <label class="form-label" for="contact_email">Contact Form Receiver Email</label>
                <input type="email" class="form-input @error('contact_email') is-invalid @enderror"
                    id="contact_email" name="contact_email"
                    value="{{ old('contact_email', $contactEmail ?? '') }}" placeholder="admin@alasare.com">
                @error('contact_email')<div class="form-error">{{ $message }}</div>@enderror
                <div class="info-box">
                    <svg width="14" height="14" fill="none" stroke="#2d6a1e" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    All messages from the "Drop us a line" form will be forwarded to this email.
                </div>
            </div>
        </div>

        {{-- ── CARD 3: Transportation ────────────────────────────────────── --}}
        <div class="lp-card">
            <div class="lp-card-header spaced">
                <div style="display:flex;align-items:center;gap:9px;">
                    <span class="lp-card-icon">
                        <svg width="14" height="14" fill="none" stroke="#2d4a1e" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="1" y="3" width="15" height="13" rx="2"/>
                            <path d="M16 8h4l3 6v3h-7V8z"/>
                            <circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
                        </svg>
                    </span>
                    <h3 class="lp-card-title" style="color:var(--green-800, #1a3d0a)">Transportation Info</h3>
                </div>
                <button type="button" class="btn btn-dark btn-sm" onclick="openModal('add')">
                    <svg width="13" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
                    </svg>
                    Add Transportation Info
                </button>
            </div>

            <div id="transportList">
                @php
                    // Map dari value database 'icon' ke class name 'Material Symbols'
                    $iconMapper = [
                        'car'        => 'directions_car',
                        'motorcycle' => 'two_wheeler',
                        'bus'        => 'directions_bus',
                        'shuttle'    => 'airport_shuttle',
                        'bicycle'    => 'directions_bike',
                        'walking'    => 'directions_walk',
                        'boat'       => 'directions_boat',
                    ];
                @endphp

                @forelse($transports ?? [] as $transport)
                <div class="transport-item"
                  data-id="{{ $transport->id }}"
                  data-transport='@json($transport)'
                  onclick="openViewModal(JSON.parse(this.dataset.transport))"
                  style="cursor:pointer;">

                  <div style="display:flex;align-items:center;gap:12px;">
                      <span class="transport-icon">
                          <span class="material-symbols-rounded">
                              {{ $iconMapper[$transport->icon] ?? 'help_outline' }}
                              
                          </span>
                      </span>

                      <span class="transport-name">
                          {{ $transport->title }}
                      </span>
                  </div>

                  <div class="action-icons">

                      {{-- EDIT --}}
                      <button
                          type="button"
                          class="action-btn"
                          title="Edit"
                          data-transport='@json($transport)'
                          onclick="event.stopPropagation(); openModal('edit', JSON.parse(this.dataset.transport))">

                          <svg width="15"
                              height="15"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              viewBox="0 0 24 24">
                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                          </svg>

                      </button>

                      {{-- DELETE --}}
                      <button type="button"
                        class="action-btn del"
                        title="Delete"
                        onclick="event.stopPropagation(); deleteTransport({{ $transport->id }}, '{{ $transport->title }}')">
                          
                              <svg width="15"
                                  height="15"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  viewBox="0 0 24 24">

                                  <polyline points="3 6 5 6 21 6"/>
                                  <path d="M19 6l-1 14H6L5 6"/>
                                  <path d="M10 11v6M14 11v6"/>
                                  <path d="M9 6V4h6v2"/>

                              </svg>

                          </button>

                      

                  </div>

              </div>
              @empty
              <div class="transport-empty">
                  No transportation info added yet.
              </div>
              @endforelse
              </div>
        </div>

        {{-- Footer buttons --}}
        <div class="form-footer">
            <a href="{{ route('admin.settings', ['section' => 'location']) }}" class="btn btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-dark">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Save Settings
            </button>
        </div>
    </form>

{{-- ═══ MODAL: Add / Edit Transport ════════════════════════════════════════ --}}
<div class="modal-overlay" id="transportModal">
    <div class="modal-box">
        <div class="modal-head">
            <h3 id="modalTitle">Add Transportation Info</h3>
            <button type="button" class="modal-close" onclick="closeModal()">✕</button>
        </div>

        <form id="transportForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="modal-body">

                <div class="form-group">
                    <label class="form-label">Transport Type (Icon)</label>
                    <div class="select-wrap">
                        <span class="select-icon" id="selectIconPreview">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="1" y="3" width="15" height="13" rx="2"/>
                                <path d="M16 8h4l3 6v3h-7V8z"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                        </span>
                        <select class="form-select" name="icon" id="iconType" onchange="previewIcon(this.value)" required>
                            <option value="" disabled selected>Select type...</option>
                            <option value="car">Car / Online Taxi</option>
                            <option value="motorcycle">Motorcycle</option>
                            <option value="bus">Bus</option>
                            <option value="shuttle">Shuttle Van</option>
                            <option value="bicycle">Bicycle</option>
                            <option value="walking">Walking</option>
                            <option value="boat">Boat / Ferry</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Transportation Title</label>
                    <input type="text" class="form-input" name="title" id="transTitle" placeholder="e.g., Online Taxi" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Short Description (Optional)</label>
                    <input type="text" class="form-input" name="description" id="transDesc" placeholder="e.g., Approximately 20 minutes...">
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Route / Drop Points</label>
                    <div id="routeList"></div>
                    <button type="button" class="add-route-btn" onclick="addRoute()">+ Add another route point</button>
                </div>

            </div>

            <div class="modal-foot">
                <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Info</button>
            </div>
        </form>
    </div>
</div>

<!-- View Modal -->
 <div class="modal-overlay" id="viewTransportModal">
    <div class="modal-box">

        <div class="modal-head">
            <h3>Transportation Details</h3>
            <button type="button" class="modal-close" onclick="closeViewModal()">✕</button>
        </div>

        <div class="modal-body" style="text-align:center">

            <span class="material-symbols-rounded"
                  id="viewIcon"
                  style="font-size:42px;color:#D9864A;">
            </span>

            <h3 id="viewTitle" style="margin-top:10px;"></h3>

            <p id="viewDescription" style="color:#777;"></p>

            <ul id="viewRoutes"
                style="text-align:left;margin-top:15px;padding-left:20px;">
            </ul>

        </div>

    </div>
</div>

 <!-- Delete Confirm Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box" style="max-width:380px">
        <div class="modal-head">
            <h3 style="color:#1a3d0a">Delete Transportation?</h3>
            <button type="button" class="modal-close" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-body" style="text-align:center;padding:24px 22px">
            <svg width="48" height="48" fill="none" stroke="#D9864A" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom:12px">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14H6L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4h6v2"/>
            </svg>
            <p style="font-size:14px;color:#4a5a46;margin:0">Are you sure you want to delete <strong id="deleteItemName"></strong>?</p>
            <p style="font-size:12px;color:#9aaa96;margin-top:6px">This action cannot be undone.</p>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn btn-dark"  onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
const ICONS = {
    car:        'directions_car',
    motorcycle: 'two_wheeler',
    bus:        'directions_bus',
    shuttle:    'airport_shuttle',
    bicycle:    'directions_bike',
    walking:    'directions_walk',
    boat:       'directions_boat',
};

function previewIcon(v){
    const icon = ICONS[v] || 'help_outline';
    document.getElementById('selectIconPreview').innerHTML =
        `<span class="material-symbols-rounded" style="font-size:18px">${icon}</span>`;
}

function openModal(mode, data = null){
    const form   = document.getElementById('transportForm');
    const method = document.getElementById('formMethod');

    if (mode === 'edit' && data) {
        document.getElementById('modalTitle').textContent = 'Edit Transportation Info';
        
        // Memakai Route Url bawaan laravel untuk mode PUT/Edit
        let editUrl = '{{ route("admin.settings.location.transport.update", ":id") }}';
        form.action = editUrl.replace(':id', data.id);
        
        method.value = 'PUT';
        document.getElementById('iconType').value   = data.icon        || '';
        document.getElementById('transTitle').value = data.title       || '';
        document.getElementById('transDesc').value  = data.description || '';
        previewIcon(data.icon || '');
        
        // Parsing data routes jika bentuknya string JSON dari DB
        let routesArray = data.routes;
        if(typeof routesArray === 'string') {
            try { routesArray = JSON.parse(routesArray); } catch(e) { routesArray = ['', '']; }
        }
        buildRoutes(routesArray || ['', '']);
    } else {
        document.getElementById('modalTitle').textContent = 'Add Transportation Info';
        form.action = '{{ route("admin.settings.location.transport.store") }}';
        method.value = 'POST';
        document.getElementById('iconType').value   = '';
        document.getElementById('transTitle').value = '';
        document.getElementById('transDesc').value  = '';
        previewIcon('');
        buildRoutes(['', '']);
    }

    document.getElementById('transportModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(){
    document.getElementById('transportModal').classList.remove('open');
    document.body.style.overflow = '';
}

document.getElementById('transportModal').addEventListener('click', function(e){
    if (e.target === this) closeModal();
});

function buildRoutes(arr){
    const list = document.getElementById('routeList');
    list.innerHTML = '';
    (arr && arr.length ? arr : ['', '']).forEach(v => addRouteRow(v));
}

function addRoute(){ addRouteRow(''); }

function addRouteRow(val){
    const row = document.createElement('div');
    row.className = 'route-row';
    row.innerHTML = `
        <svg width="14" height="14" fill="none" stroke="#9aaa96" stroke-width="2" viewBox="0 0 24 24">
            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
        </svg>
        <input class="route-input" type="text" name="routes[]" placeholder="e.g., Trans Studio Bandung"
            value="${val.replace(/"/g,'&quot;')}">
        <button type="button" class="route-remove" onclick="rmRoute(this)">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    `;
    document.getElementById('routeList').appendChild(row);
}

function rmRoute(btn){
    const list = document.getElementById('routeList');
    if (list.children.length > 1) btn.closest('.route-row').remove();
}

function openViewModal(data)
{
    document.getElementById('viewIcon').textContent =
        ICONS[data.icon] || 'help_outline';

    document.getElementById('viewTitle').textContent =
        data.title || '-';

    document.getElementById('viewDescription').textContent =
        data.description || '-';

    const routes = document.getElementById('viewRoutes');
    routes.innerHTML = '';

    (data.routes || []).forEach(route => {
        routes.innerHTML += `<li>${route}</li>`;
    });

    document.getElementById('viewTransportModal')
        .classList.add('open');
}

function closeViewModal()
{
    document.getElementById('viewTransportModal')
        .classList.remove('open');
}

let _deleteId = null;

function deleteTransport(id, name) {
    _deleteId = id;
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    _deleteId = null;
    document.getElementById('deleteModal').classList.remove('open');
    document.body.style.overflow = '';
}

function confirmDelete() {
    if (!_deleteId) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/settings/location/transportation/' + _deleteId;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';

    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'DELETE';

    form.appendChild(csrf);
    form.appendChild(method);
    document.body.appendChild(form);
    form.submit();
}
</script>