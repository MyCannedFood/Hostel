<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings — AlaSare Management</title>
<link rel="stylesheet"
href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{
  --green-50:#f0f4ee;--green-100:#d4e6cc;--green-200:#a8cc99;
  --green-600:#2d6a1e;--green-700:#1a5213;--green-800:#1a3d0a;
  --orange-400:#f59e0b;--orange-500:#d97706;--orange-100:#fef3c7;
  --bg-page:#f5f2eb;--bg-card:#fff;--bg-sidebar:#fff;
  --text-main:#1a3d0a;--text-muted:#7a857f;--text-label:#4a5a46;
  --border:#e2e8de;--border-strong:#c8d5c4;
  --sidebar-w:220px;--topbar-h:56px;
  --radius-lg:8px;
  --radius-sm:2px;
}
html,body{height:100%;font-family:'Segoe UI',system-ui,sans-serif;background:var(--bg-page);color:var(--text-main);}


/* ── Settings 2-col ── */
.settings-layout{display:flex;min-height:100%;}
.settings-sidebar{
  width:260px;flex-shrink:0;padding:32px 20px;border-right:1px solid var(--border);
}
.settings-content{flex:1;padding:0 36px;max-width:1000px;}
.settings-section-title{font-size:18px;font-weight:700;color:var(--text-muted);margin-bottom:6px;}
.settings-section-sub{font-size:12.5px;color:var(--text-muted);margin-bottom:20px;}
.settings-nav-item{
  display:flex;align-items:center;justify-content:space-between;
  padding:13px 14px;border-radius:8px;cursor:pointer;
  font-size:13.5px;font-weight:500;color:#4a5a46;
  transition:background 0.12s,color 0.12s;margin-bottom:4px;
  border:1px solid transparent;
}
.settings-nav-item:hover{background:var(--green-50);}
.settings-nav-item.active{
  background:var(--green-800);color:#fff;border-color:var(--green-800);
}
.settings-nav-item .sni-icon{
  width:30px;height:30px;border-radius:8px;background:var(--green-50);
  display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--green-700);
}
.settings-nav-item.active .sni-icon{background:rgba(255,255,255,0.15);color:#fff;}
.sni-label{flex:1;margin-left:10px;}
.sni-arrow{opacity:0.5;}
.settings-nav-item.active .sni-arrow{opacity:0.7;}

/* ── Page header ── */
.page-header{margin-bottom:28px;}
.page-title{font-size:26px;font-weight:700;color:var(--green-800);letter-spacing:-0.3px;margin-bottom:4px;}
.page-sub{font-size:14px;color:var(--text-muted);}

/* ── Alert ── */
.alert-success{
  margin-bottom:16px;padding:12px 16px;background:#e6f4e6;
  border:1px solid #a3d4a3;border-radius:8px;color:#2e7d32;font-size:13px;font-weight:600;
  display:none;
}
.alert-success.show{display:block;}

/* ── Cards ── */
.lp-card{background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-lg);padding:24px;margin-bottom:20px;}
.lp-card-header{
  display:flex;align-items:center;gap:9px;
  padding-bottom:16px;border-bottom:1px solid var(--green-50);margin-bottom:20px;
}
.lp-card-header.spaced{justify-content:space-between;}
.lp-card-icon{
  width:28px;height:28px;background:#eef5ec;border-radius:50%;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.lp-card-title{font-size:16px;font-weight:700;color:var(--green-600);margin:0;}

/* ── Form ── */
.form-group{margin-bottom:16px;}
.form-label{
  display:block;font-size:11.5px;font-weight:600;color:var(--text-label);
  text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;
}
.form-input,.form-textarea,.form-select{
  width:100%;padding:10px 12px;border:1.5px solid var(--border-strong);
  border-radius:var(--radius-lg);font-size:14px;color:var(--text-main);
  background:#fff;outline:none;transition:border-color 0.15s;font-family:inherit;
}
.form-input:focus,.form-textarea:focus,.form-select:focus{border-color:var(--green-600);box-shadow:0 0 0 3px rgba(45,106,30,0.08);}
.form-textarea{resize:vertical;min-height:80px;line-height:1.5;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.select-wrap{position:relative;}
.select-icon{position:absolute;left:11px;top:50%;transform:translateY(-50%);pointer-events:none;color:var(--text-label);display:flex;align-items:center;}
.form-select{padding-left:36px;}

/* ── Info box ── */
.info-box{
  display:flex;align-items:flex-start;gap:7px;
  background:#f0f9f4;border:1px solid #b8dfc4;
  border-radius:8px;padding:10px 12px;font-size:12.5px;color:var(--green-600);margin-top:10px;
}
.info-box svg{flex-shrink:0;margin-top:1px;}

/* ── Buttons ── */
.btn{
  display:inline-flex;align-items:center;gap:7px;padding:9px 18px;
  border-radius:var(--radius-sm);font-size:13.5px;font-weight:600;cursor:pointer;
  border:none;transition:all 0.15s;font-family:inherit;
}
.btn:active{transform:scale(0.97);}
.btn-dark{background:var(--green-800);color:#fff;}
.btn-dark:hover{background:var(--green-700);}
.btn-cancel{
    background:#D9864A;
    color:#fff;
}

.btn-cancel:hover{
    background:#C6783F;
}

.btn-cancel:active{
    background:#B56D39;
}

.btn-sm{padding:7px 14px;font-size:12.5px;}

.form-footer{display:flex;justify-content:flex-end;gap:12px;margin-top:8px;padding-bottom:8px;}

/* ── Add route btn ── */
.add-route-btn{
  width:100%;background:none;border:1.5px dashed var(--border-strong);
  border-radius:8px;padding:9px 14px;font-size:13px;
  color:var(--green-600);cursor:pointer;font-family:inherit;font-weight:600;
}
.add-route-btn:hover{background:var(--green-50);}

/* ── Transport list ── */
.transport-item{
  display:flex;align-items:center;justify-content:space-between;
  padding:13px 4px;border-bottom:1px solid var(--green-50);
}
.transport-item:last-child{border-bottom:none;}
.transport-icon{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#D9864A;
    color:#FFFFFF;
    display:flex;
    align-items:center;
    justify-content:center;
}

.material-symbols-rounded{
    font-size:20px;
    font-variation-settings:
      'FILL' 1,
      'wght' 400,
      'GRAD' 0,
      'opsz' 24;
}
.transport-name{font-size:14px;font-weight:600;color:var(--green-800);}
.transport-empty{text-align:center;padding:36px 20px;color:#9aaa96;font-size:13px;}
.action-icons{display:flex;gap:6px;}
.action-btn{
    background:none;
    border:none;
    cursor:pointer;
    width:30px;
    height:30px;
    border-radius:2px;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:all .15s;
}
.action-btn.del{
    color:#D9864A;
}

.action-btn.del:hover{
    background:#FDF1E8;
    color:#C6783F;
}

.action-btn:not(.del){
    color:#1A3D0A;
}

.action-btn:not(.del):hover{
    background:#EDF5EF;
    color:#1A3D0A;
}

/* ── Modal ── */
.modal-overlay{
  display:none;position:fixed;inset:0;
  background:rgba(0,0,0,0.5);z-index:999;
  align-items:center;justify-content:center;padding:20px;
}
.modal-overlay.open{display:flex;}
.modal-box{
  background:#fff;border-radius:var(--radius-lg);width:100%;max-width:480px;
  box-shadow:0 12px 40px rgba(0,0,0,0.18);overflow:hidden;
}
.modal-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 22px 14px;border-bottom:1px solid var(--border);
}
.modal-head h3{font-size:16px;font-weight:700;color:var(--green-800);margin:0;}
.modal-close{
  background:none;border:none;cursor:pointer;font-size:16px;
  color:var(--text-muted);width:28px;height:28px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;transition:background 0.15s;
}
.modal-close:hover{background:var(--green-50);}
.modal-body{padding:20px 22px;max-height:65vh;overflow-y:auto;}
.modal-foot{display:flex;justify-content:flex-end;gap:10px;padding:14px 22px;border-top:1px solid var(--border);}

/* ── Route rows ── */
.route-row{
  display:flex;align-items:center;gap:8px;
  background:#fff;border:1.5px solid var(--border-strong);
  border-radius:var(--radius-lg);padding:8px 12px;margin-bottom:8px;
}
.route-input{flex:1;border:none;outline:none;font-size:13px;color:var(--green-800);background:transparent;font-family:inherit;}
.route-input::placeholder{color:#b0b8b0;}
.route-remove{background:none;border:none;cursor:pointer;color:var(--orange-500);display:flex;align-items:center;padding:0 2px;}
.route-remove:hover{color:#c62828;}
</style>
</head>
<body>


        <!-- Main Content -->
        <div class="settings-content">

          <!-- Flash (hidden, shown on save) -->
          <div class="alert-success" id="flashSuccess">✓ Settings saved successfully!</div>

          <div class="page-header">
            <h2 class="page-title">Location &amp; Contact Settings</h2>
            <p class="page-sub">Manage public contact details and system routing.</p>
          </div>

          <!-- CARD 1: Public Contact Information -->
          <div class="lp-card">
            <div class="lp-card-header">
              <span class="lp-card-icon">
                <svg width="14" height="14" fill="none" stroke="#2d6a1e" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
              </span>
              <h3 class="lp-card-title">Public Contact Information</h3>
            </div>

            <div class="form-group">
              <label class="form-label">Address</label>
              <textarea class="form-textarea" id="address" rows="3" placeholder="e.g., Jalan Raya Ubud No. 1, Gianyar, Bali, Indonesia...">Jalan Raya Ubud No. 1, Gianyar, Bali, Indonesia</textarea>
            </div>

            <div class="form-row">
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-input" id="phone" value="+62 812 3456 7890" placeholder="+62 812 3456 7890">
              </div>
              <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Public Email</label>
                <input type="email" class="form-input" id="publicEmail" value="hello@tropicalzen.com" placeholder="hello@example.com">
              </div>
            </div>

            <div class="form-group" style="margin-top:16px;margin-bottom:0">
              <label class="form-label">Google Maps Link</label>
              <input type="url" class="form-input" id="mapsLink" placeholder="https://maps.google.com/...">
            </div>
          </div>

          <!-- CARD 2: System Configuration -->
          <div class="lp-card">
            <div class="lp-card-header">
              <span class="lp-card-icon">
                <svg width="14" height="14" fill="none" stroke="#2d6a1e" stroke-width="2" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
              </span>
              <h3 class="lp-card-title">System Configuration</h3>
            </div>

            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Contact Form Receiver Email</label>
              <input type="email" class="form-input" id="contactEmail" value="admin@alasare.com" placeholder="admin@alasare.com">
              <div class="info-box">
                <svg width="14" height="14" fill="none" stroke="#2d6a1e" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                All messages from the "Drop us a line" form will be forwarded to this email.
              </div>
            </div>
          </div>

          <!-- CARD 3: Transportation Info -->
          <div class="lp-card">
            <div class="lp-card-header spaced">
              <div style="display:flex;align-items:center;gap:9px;">
                <span class="lp-card-icon">
                  <svg width="14" height="14" fill="none" stroke="#2d4a1e" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 6v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </span>
                <h3 class="lp-card-title" style="color:var(--green-800)">Transportation Info</h3>
              </div>
              <button class="btn btn-dark btn-sm" onclick="openModal('add')">
                <svg width="13" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                Add Transportation Info
              </button>
            </div>

            <div id="transportList">
                <!-- Online Taxi -->
                <div class="transport-item">
                    <div style="display:flex;align-items:center;gap:12px;">
                    <span class="transport-icon">
                        <span class="material-symbols-rounded">directions_car</span>
                    </span>
                    <span class="transport-name">Online Taxi</span>
                    </div>

                    <div class="action-icons">
                    <button class="action-btn" title="Edit"
                        onclick="openModal('edit',{id:1,icon:'car',title:'Online Taxi',desc:'Approximately 20 minutes from city center',routes:['Trans Studio Bandung','Bandung Station','Husein Sastranegara Airport']})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>

                    <button class="action-btn del" title="Delete" onclick="deleteTransport(this)">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                    </div>
                </div>

                <!-- Motorcycle -->
                <div class="transport-item">
                    <div style="display:flex;align-items:center;gap:12px;">
                    <span class="transport-icon">
                        <span class="material-symbols-rounded">two_wheeler</span>
                    </span>
                    <span class="transport-name">Motorcycle</span>
                    </div>

                    <div class="action-icons">
                    <button class="action-btn" title="Edit"
                        onclick="openModal('edit',{id:2,icon:'motorcycle',title:'Motorcycle',desc:'Faster through small alleys',routes:['Alun-Alun Bandung','Pasar Baru']})">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>

                    <button class="action-btn del" title="Delete" onclick="deleteTransport(this)">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                    </div>
                </div>

            </div>
          </div>

          <!-- Footer -->
          <div class="form-footer">
            <button class="btn btn-cancel" onclick="cancelForm()">Cancel</button>
            <button class="btn btn-dark" onclick="saveSettings()">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              Save Settings
            </button>
          </div>

        </div><!-- /settings-content -->
    </div><!-- /content-wrap -->



<!-- ═══ MODAL ═══ -->
<div class="modal-overlay" id="transportModal">
  <div class="modal-box">
    <div class="modal-head">
      <h3 id="modalTitle">Add Transportation Info</h3>
      <button class="modal-close" onclick="closeModal()">✕</button>
    </div>
    <div class="modal-body">

      <div class="form-group">
        <label class="form-label">Transport Type (Icon)</label>
        <div class="select-wrap">
          <span class="select-icon" id="selectIconPreview">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 6v3h-7V8z"/>
              <circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </span>
          <select class="form-select" id="iconType" onchange="previewIcon(this.value)">
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
        <input type="text" class="form-input" id="transTitle" placeholder="e.g., ONLINE TAXI">
      </div>

      <div class="form-group">
        <label class="form-label">Short Description (Optional)</label>
        <input type="text" class="form-input" id="transDesc" placeholder="e.g., Approximately 20 minutes...">
      </div>

      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Route / Drop Points</label>
        <div id="routeList"></div>
        <button type="button" class="add-route-btn" onclick="addRoute()">+ Add another route point</button>
      </div>

    </div>
    <div class="modal-foot">
      <button class="btn btn-cancel" onclick="closeModal()">Cancel</button>
      <button class="btn btn-dark" onclick="saveTransport()">Save Info</button>
    </div>
  </div>
</div>


<script>
/* ── Nav helpers ── */
function setNav(el){
  document.querySelectorAll('.sb-item').forEach(i=>i.classList.remove('active'));
  el.classList.add('active');
}
function setSettingsNav(el){
  document.querySelectorAll('.settings-nav-item').forEach(i=>i.classList.remove('active'));
  el.classList.add('active');
}

/* ── Icon SVGs ── */
const ICONS = {
  car: "directions_car",
  motorcycle: "two_wheeler",
  bus: "directions_bus",
  shuttle: "airport_shuttle",
  bicycle: "directions_bike",
  walking: "directions_walk",
  boat: "directions_boat",
  _default: "help_outline"
};

function materialIcon(type){
  return `<span class="material-symbols-rounded">${ICONS[type] || ICONS._default}</span>`;
}

function previewIcon(v){
  document.getElementById('selectIconPreview').innerHTML = materialIcon(v);
}

/* ── Modal ── */
let _editId = null;

function openModal(mode, data=null){
  _editId = null;
  document.getElementById('modalTitle').textContent = mode==='edit' ? 'Edit Transportation Info' : 'Add Transportation Info';
  document.getElementById('iconType').value   = data?.icon || '';
  document.getElementById('transTitle').value = data?.title || '';
  document.getElementById('transDesc').value  = data?.desc  || '';
  previewIcon(data?.icon || '');
  buildRoutes(data?.routes || ['','']);
  if(mode==='edit') _editId = data.id;
  document.getElementById('transportModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal(){
  document.getElementById('transportModal').classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('transportModal').addEventListener('click', function(e){
  if(e.target===this) closeModal();
});

/* ── Route points ── */
function buildRoutes(arr){
  const list = document.getElementById('routeList');
  list.innerHTML = '';
  (arr.length ? arr : ['','']).forEach(v => _addRouteRow(v));
}

function addRoute(){ _addRouteRow(''); }

function _addRouteRow(val){
  const list = document.getElementById('routeList');
  const row  = document.createElement('div');
  row.className = 'route-row';
  row.innerHTML = `
    <svg width="14" height="14" fill="none" stroke="#9aaa96" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
    <input class="route-input" type="text" placeholder="e.g., Trans Studio Bandung" value="${esc(val)}">
    <button type="button" class="route-remove" onclick="rmRoute(this)" title="Remove">
      <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  `;
  list.appendChild(row);
}

function rmRoute(btn){
  const list = document.getElementById('routeList');
  if(list.children.length > 1) btn.closest('.route-row').remove();
}

function esc(s){ return String(s).replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

/* ── Save transport ── */
function saveTransport(){
  const title = document.getElementById('transTitle').value.trim();
  const icon  = document.getElementById('iconType').value || 'shuttle';
  if(!title){ alert('Masukkan judul transportasi!'); return; }

  if(_editId === null){
    // Add new
    const list = document.getElementById('transportList');
    const item = document.createElement('div');
    item.className = 'transport-item';
    const newId = Date.now();
    const desc  = document.getElementById('transDesc').value;
    const routes = [...document.querySelectorAll('#routeList .route-input')].map(i=>i.value);
    item.innerHTML = `
      <div style="display:flex;align-items:center;gap:12px;">
        <span class="transport-icon">${svgIcon(icon)}</span>
        <span class="transport-name">${esc(title)}</span>
      </div>
      <div class="action-icons">
        <button class="action-btn" title="Edit"
          onclick="openModal('edit',{id:${newId},icon:'${icon}',title:'${esc(title)}',desc:'${esc(desc)}',routes:${JSON.stringify(routes)}})">
          <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
        <button class="action-btn del" title="Delete" onclick="deleteTransport(this)">
          <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
        </button>
      </div>
    `;
    list.appendChild(item);
  } else {
    // Update existing — find by onclick attribute containing the id
    // Simple approach: update the name and icon of the matching item
    const items = document.querySelectorAll('#transportList .transport-item');
    items.forEach(item => {
      const editBtn = item.querySelector('.action-btn[title="Edit"]');
      if(editBtn && editBtn.getAttribute('onclick') && editBtn.getAttribute('onclick').includes(`id:${_editId}`)){
        item.querySelector('.transport-icon').innerHTML = svgIcon(icon);
        item.querySelector('.transport-name').textContent = title;
        const desc  = document.getElementById('transDesc').value;
        const routes = [...document.querySelectorAll('#routeList .route-input')].map(i=>i.value);
        editBtn.setAttribute('onclick',
          `openModal('edit',{id:${_editId},icon:'${icon}',title:'${esc(title)}',desc:'${esc(desc)}',routes:${JSON.stringify(routes)}})`
        );
      }
    });
  }

  closeModal();
}

/* ── Delete transport ── */
function deleteTransport(btn){
  if(confirm('Yakin hapus item ini?')) btn.closest('.transport-item').remove();
}

/* ── Save settings ── */
function saveSettings(){
  const flash = document.getElementById('flashSuccess');
  flash.classList.add('show');
  setTimeout(()=> flash.classList.remove('show'), 3000);
  document.querySelector('.content-wrap').scrollTop = 0;
}

function cancelForm(){
  if(confirm('Batalkan perubahan?')){
    document.getElementById('address').value     = 'Jalan Raya Ubud No. 1, Gianyar, Bali, Indonesia';
    document.getElementById('phone').value       = '+62 812 3456 7890';
    document.getElementById('publicEmail').value = 'hello@tropicalzen.com';
    document.getElementById('mapsLink').value    = '';
    document.getElementById('contactEmail').value= 'admin@alasare.com';
  }
}
</script>

</body>
</html>