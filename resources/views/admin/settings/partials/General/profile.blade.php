{{-- resources/views/admin/settings/partials/General/profile.blade.php --}}

<style>
/* ════════════════════════════════════════════════
   PM-* BASE STYLES
   ════════════════════════════════════════════════ */
.pm-back-link { display:inline-flex;align-items:center;gap:5px;font-size:13px;color:#4a7c3f;text-decoration:none;margin-bottom:20px;font-weight:500;transition:color .15s; }
.pm-back-link:hover { color:#2d4a1e; }
.pm-back-link svg { flex-shrink:0; }
.pm-page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:6px; }
.pm-page-title  { font-size:26px;font-weight:700;color:#1a3a2a;margin:0; }
.pm-page-subtitle { color:#7a857f;font-size:13.5px;margin:0 0 24px; }
.pm-card { background:#fff;border:1px solid #e5e9e6;border-radius:8px;padding:24px 28px;margin-bottom:16px; }
.pm-footer { display:flex;justify-content:flex-end;gap:10px;margin-top:28px; }
.pm-btn-cancel { padding:10px 24px;border-radius:2px;border:none;background:#D9864A;color:#fff;font-size:13.5px;font-weight:600;cursor:pointer;transition:background .15s;font-family:inherit; }
.pm-btn-cancel:hover { background:#c4733a; }
.pm-btn-save { padding:10px 24px;border-radius:2px;border:none;background:#1A3D0A;color:#fff;font-size:13.5px;font-weight:600;cursor:pointer;transition:background .15s;font-family:inherit; }
.pm-btn-save:hover { background:#2d5a1a; }

/* ════════════════════════════════════════════════
   PROFILE-SPECIFIC STYLES
   ════════════════════════════════════════════════ */
.prof-avatar-wrap { display:flex;align-items:center;gap:18px;margin-bottom:28px;padding-bottom:24px;border-bottom:1px solid #eef1ee; }
.prof-avatar { width:64px;height:64px;border-radius:50%;background:#e8ede8;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;border:2px solid #dde3de;transition:border-color .15s; }
.prof-avatar img { width:100%;height:100%;object-fit:cover; }
.prof-avatar svg { color:#9aaa96; }
.prof-upload-link { font-size:13px;font-weight:600;color:#1A3D0A;cursor:pointer;transition:opacity .15s; }
.prof-upload-link:hover { opacity:.7; }
.prof-upload-link input[type="file"] { display:none; }
.prof-fields-grid { display:grid;grid-template-columns:1fr 1fr;gap:0 32px; }
@media (max-width:600px) { .prof-fields-grid { grid-template-columns:1fr; } }
.prof-field { padding:12px 0 16px;border-bottom:1.5px solid #e0e6e2;margin-bottom:12px; }
.prof-field-label { font-size:12px;color:#8a9690;font-weight:500;margin-bottom:6px;display:block; }
.prof-field-input { width:100%;border:none;outline:none;font-size:14.5px;color:#1a3d0a;background:transparent;font-family:inherit;padding:0; }
.prof-field-input::placeholder { color:#c0ccc5; }
.prof-field-input[readonly] { color:#8a9690;cursor:default; }
.prof-pw-header { display:flex;align-items:center;gap:9px;margin-bottom:22px; }
.prof-pw-header svg { color:#1A3D0A;flex-shrink:0; }
.prof-pw-title { font-size:15px;font-weight:700;color:#1a3d0a;margin:0; }
.prof-pw-field { padding:10px 0 14px;border-bottom:1.5px solid #e0e6e2;margin-bottom:16px; }
.prof-pw-hint { display:flex;align-items:flex-start;gap:7px;margin-top:16px;font-size:12.5px;color:#8a9690;line-height:1.5; }
.prof-pw-hint svg { flex-shrink:0;margin-top:1px; }
.prof-pw-wrap { position:relative; }
.prof-pw-wrap .prof-field-input { padding-right:28px; }
.prof-eye-btn { position:absolute;right:0;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9aaa96;padding:0;display:flex;transition:color .15s; }
.prof-eye-btn:hover { color:#1A3D0A; }
.prof-field.error .prof-field-input,
.prof-pw-field.error .prof-field-input { color:#c0392b; }
.prof-field.error,
.prof-pw-field.error { border-bottom-color:#e57373; }
.prof-error-msg { font-size:11.5px;color:#c0392b;margin-top:4px;display:none; }
.prof-field.error .prof-error-msg,
.prof-pw-field.error .prof-error-msg { display:block; }

/* ── Alert (success / error dari session) ── */
.prof-alert { display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:8px;font-size:13.5px;font-weight:500;margin-bottom:20px; }
.prof-alert-success { background:#eef7f0;color:#276c42;border:1px solid #b6dfc4; }
.prof-alert-error   { background:#fdecea;color:#c0392b;border:1px solid #f5c6c2; }
.prof-alert svg { flex-shrink:0; }

/* ════════════════════════════════════════════════
   CROP MODAL
   ════════════════════════════════════════════════ */
.prof-crop-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center; }
.prof-crop-overlay.open { display:flex; }
.prof-crop-modal { background:#fff;border-radius:8px;padding:28px;width:100%;max-width:420px;margin:16px;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:profSlideIn .2s ease; }
@keyframes profSlideIn { from{opacity:0;transform:translateY(14px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
.prof-crop-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:4px; }
.prof-crop-title  { font-size:17px;font-weight:700;color:#1a3d0a;margin:0; }
.prof-crop-sub    { font-size:13px;color:#8a9690;margin:0 0 18px; }
.prof-crop-close  { width:30px;height:30px;border:none;border-radius:7px;background:#f0f4ee;color:#7a857f;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s; }
.prof-crop-close:hover { background:#e0e8de; }
.prof-crop-stage { position:relative;width:100%;aspect-ratio:1;background:#111;border-radius:8px;overflow:hidden;cursor:grab;user-select:none;margin-bottom:14px;touch-action:none; }
.prof-crop-stage:active { cursor:grabbing; }
#prof-crop-canvas { display:block;width:100%;height:100%; }
.prof-crop-mask { position:absolute;inset:0;pointer-events:none; }
.prof-zoom-wrap  { display:flex;align-items:center;gap:10px;margin-bottom:20px; }
.prof-zoom-icon  { color:#9aaa96;flex-shrink:0; }
.prof-zoom-slider { flex:1;-webkit-appearance:none;appearance:none;height:4px;border-radius:4px;background:#e0e6e2;outline:none;cursor:pointer; }
.prof-zoom-slider::-webkit-slider-thumb { -webkit-appearance:none;width:16px;height:16px;border-radius:50%;background:#1A3D0A;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,.2); }
.prof-zoom-slider::-moz-range-thumb { width:16px;height:16px;border-radius:50%;background:#1A3D0A;border:none;cursor:pointer; }
.prof-crop-footer { display:flex;justify-content:flex-end;gap:10px; }
</style>

{{-- ── Flash messages ── --}}
@if(session('success'))
<div class="prof-alert prof-alert-success">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="prof-alert prof-alert-error">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
    </svg>
    {{ $errors->first() }}
</div>
@endif

{{-- ── Back link ── --}}
<a href="{{ route('admin.settings', ['section' => 'general']) }}" class="pm-back-link">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
    </svg>
    Back to General Settings
</a>

{{-- ── Page heading ── --}}
<div class="pm-page-header">
    <div>
        <h2 class="pm-page-title">Admin Profile</h2>
        <p class="pm-page-subtitle" style="margin-top:4px;">Manage your personal account details and security settings.</p>
    </div>
</div>

{{-- ══════════════════════════════════
     FORM
══════════════════════════════════ --}}
<form
    id="prof-form"
    method="POST"
    action="{{ route('admin.settings.profile.update') }}"
    enctype="multipart/form-data"
>
@csrf
@method('PUT')

{{-- Hidden: base64 hasil crop --}}
<input type="hidden" name="avatar_data" id="prof-avatar-data">

{{-- ── Card 1: Personal Info ── --}}
<div class="pm-card">
    <div class="prof-avatar-wrap">
        <div class="prof-avatar" id="prof-avatar-preview">
            @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar">
            @else
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            @endif
        </div>
        <label class="prof-upload-link">
            + Upload Photo
            <input type="file" id="prof-file-input" accept="image/*" onchange="profOnFileChange(this)">
        </label>
    </div>

    <div class="prof-fields-grid">
        <div>
            <div class="prof-field @error('full_name') error @enderror" id="field-fullname">
                <label class="prof-field-label" for="prof-fullname">Full Name</label>
                <input class="prof-field-input" id="prof-fullname" name="full_name" type="text"
                    value="{{ old('full_name', $user->name) }}" placeholder="Your full name">
                <span class="prof-error-msg">@error('full_name'){{ $message }}@else Full name is required. @enderror</span>
            </div>
        </div>
        <div>
            <div class="prof-field">
                <label class="prof-field-label">Role</label>
                <input class="prof-field-input" type="text" value="{{ $user->role ?? 'Super Admin' }}" readonly>
            </div>
        </div>
        <div>
            <div class="prof-field @error('email') error @enderror" id="field-email">
                <label class="prof-field-label" for="prof-email">Email Address</label>
                <input class="prof-field-input" id="prof-email" name="email" type="email"
                    value="{{ old('email', $user->email) }}" placeholder="email@example.com">
                <span class="prof-error-msg">@error('email'){{ $message }}@else Enter a valid email. @enderror</span>
            </div>
        </div>
        <div>
            <div class="prof-field @error('phone') error @enderror" id="field-phone">
                <label class="prof-field-label" for="prof-phone">Phone Number</label>
                <input class="prof-field-input" id="prof-phone" name="phone" type="tel"
                    value="{{ old('phone', $user->phone) }}" placeholder="+62 8xx xxxx xxxx">
                <span class="prof-error-msg">@error('phone'){{ $message }}@else Phone number is required. @enderror</span>
            </div>
        </div>
    </div>
</div>

{{-- ── Card 2: Change Password ── --}}
<div class="pm-card">
    <div class="prof-pw-header">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        <h3 class="prof-pw-title">Change Password</h3>
    </div>

    <div class="prof-pw-field @error('current_password') error @enderror" id="field-current-pw">
        <label class="prof-field-label" for="prof-current-pw">Current Password</label>
        <div class="prof-pw-wrap">
            <input class="prof-field-input" id="prof-current-pw" name="current_password"
                type="password" placeholder="Enter current password" autocomplete="current-password">
            <button class="prof-eye-btn" type="button" onclick="profTogglePw('prof-current-pw', this)">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        <span class="prof-error-msg">@error('current_password'){{ $message }}@else Current password is required. @enderror</span>
    </div>

    <div class="prof-pw-field @error('new_password') error @enderror" id="field-new-pw">
        <label class="prof-field-label" for="prof-new-pw">New Password</label>
        <div class="prof-pw-wrap">
            <input class="prof-field-input" id="prof-new-pw" name="new_password"
                type="password" placeholder="Enter new password" autocomplete="new-password">
            <button class="prof-eye-btn" type="button" onclick="profTogglePw('prof-new-pw', this)">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        <span class="prof-error-msg">@error('new_password'){{ $message }}@else Min 8 karakter dan mengandung angka. @enderror</span>
    </div>

    <div class="prof-pw-field" id="field-confirm-pw">
        <label class="prof-field-label" for="prof-confirm-pw">Confirm New Password</label>
        <div class="prof-pw-wrap">
            <input class="prof-field-input" id="prof-confirm-pw" name="new_password_confirmation"
                type="password" placeholder="Repeat new password" autocomplete="new-password">
            <button class="prof-eye-btn" type="button" onclick="profTogglePw('prof-confirm-pw', this)">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
    </div>

    <div class="prof-pw-hint">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
        </svg>
        Password must be at least 8 characters long and include a number.
    </div>
</div>

{{-- ── Footer ── --}}
<div class="pm-footer">
    <a href="{{ route('admin.settings', ['section' => 'general']) }}" class="pm-btn-cancel">Cancel</a>
    <button type="submit" class="pm-btn-save">Save Profile</button>
</div>

</form>{{-- end form --}}


{{-- ══════════════════════════════════
     CROP MODAL (di luar form)
══════════════════════════════════ --}}
<div class="prof-crop-overlay" id="prof-crop-overlay">
    <div class="prof-crop-modal">
        <div class="prof-crop-header">
            <h3 class="prof-crop-title">Crop Photo</h3>
            <button class="prof-crop-close" onclick="profCloseCrop()">&#x2715;</button>
        </div>
        <p class="prof-crop-sub">Drag to reposition · Scroll or slide to zoom</p>

        <div class="prof-crop-stage" id="prof-crop-stage">
            <canvas id="prof-crop-canvas"></canvas>
            <svg class="prof-crop-mask" viewBox="0 0 100 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <mask id="profCircleMask">
                        <rect width="100" height="100" fill="white"/>
                        <circle cx="50" cy="50" r="42" fill="black"/>
                    </mask>
                </defs>
                <rect width="100" height="100" fill="rgba(0,0,0,0.55)" mask="url(#profCircleMask)"/>
                <circle cx="50" cy="50" r="42" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="0.5"/>
            </svg>
        </div>

        <div class="prof-zoom-wrap">
            <span class="prof-zoom-icon">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35M11 8v6M8 11h6"/>
                </svg>
            </span>
            <input class="prof-zoom-slider" id="prof-zoom-slider" type="range" min="1" max="3" step="0.01" value="1">
            <span class="prof-zoom-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35M11 8v6M8 11h6"/>
                </svg>
            </span>
        </div>

        <div class="prof-crop-footer">
            <button class="pm-btn-cancel" style="padding:9px 20px;" onclick="profCloseCrop()">Cancel</button>
            <button class="pm-btn-save"   style="padding:9px 20px;" onclick="profApplyCrop()">Use Photo</button>
        </div>
    </div>
</div>


<script>
(function () {

    /* ══ CROP ══════════════════════════════════════════════ */
    var cropImg = null, cropScale = 1, cropX = 0, cropY = 0;
    var dragging = false, dragStartX = 0, dragStartY = 0;
    var CANVAS_SIZE = 360;

    window.profOnFileChange = function (input) {
        if (!input.files || !input.files[0]) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.onload = function () {
                cropImg = img; cropScale = 1; cropX = 0; cropY = 0;
                document.getElementById('prof-zoom-slider').value = 1;
                var canvas = document.getElementById('prof-crop-canvas');
                canvas.width = canvas.height = CANVAS_SIZE;
                document.getElementById('prof-crop-overlay').classList.add('open');
                document.body.style.overflow = 'hidden';
                drawCrop();
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        input.value = '';
    };

    function drawCrop() {
        var canvas = document.getElementById('prof-crop-canvas');
        var ctx = canvas.getContext('2d');
        var S = CANVAS_SIZE;
        ctx.clearRect(0, 0, S, S);
        if (!cropImg) return;
        var ar = cropImg.width / cropImg.height;
        var bW = ar > 1 ? S * ar : S;
        var bH = ar > 1 ? S : S / ar;
        var dW = bW * cropScale, dH = bH * cropScale;
        var r = S * 0.42;
        cropX = Math.max(-(dW/2-r), Math.min(dW/2-r, cropX));
        cropY = Math.max(-(dH/2-r), Math.min(dH/2-r, cropY));
        ctx.drawImage(cropImg, S/2 - dW/2 + cropX, S/2 - dH/2 + cropY, dW, dH);
    }

    window.profApplyCrop = function () {
        var src = document.getElementById('prof-crop-canvas');
        var out = document.createElement('canvas');
        var S = CANVAS_SIZE;
        out.width = out.height = S;
        var ctx = out.getContext('2d');
        ctx.beginPath();
        ctx.arc(S/2, S/2, S*0.42, 0, Math.PI*2);
        ctx.clip();
        ctx.drawImage(src, 0, 0);

        var dataUrl = out.toDataURL('image/png');
        // Simpan ke hidden input → dikirim ke BE saat form submit
        document.getElementById('prof-avatar-data').value = dataUrl;
        // Update preview avatar
        document.getElementById('prof-avatar-preview').innerHTML = '<img src="' + dataUrl + '" alt="Avatar">';
        profCloseCrop();
    };

    window.profCloseCrop = function () {
        document.getElementById('prof-crop-overlay').classList.remove('open');
        document.body.style.overflow = '';
    };
    document.getElementById('prof-crop-overlay').addEventListener('click', function (e) {
        if (e.target === this) profCloseCrop();
    });

    document.getElementById('prof-zoom-slider').addEventListener('input', function () {
        cropScale = parseFloat(this.value); drawCrop();
    });

    var stage = document.getElementById('prof-crop-stage');
    stage.addEventListener('mousedown', function (e) {
        dragging = true; dragStartX = e.clientX - cropX; dragStartY = e.clientY - cropY; e.preventDefault();
    });
    window.addEventListener('mousemove', function (e) {
        if (!dragging) return; cropX = e.clientX - dragStartX; cropY = e.clientY - dragStartY; drawCrop();
    });
    window.addEventListener('mouseup', function () { dragging = false; });
    stage.addEventListener('touchstart', function (e) {
        var t = e.touches[0]; dragging = true; dragStartX = t.clientX - cropX; dragStartY = t.clientY - cropY; e.preventDefault();
    }, { passive: false });
    window.addEventListener('touchmove', function (e) {
        if (!dragging) return; var t = e.touches[0]; cropX = t.clientX - dragStartX; cropY = t.clientY - dragStartY; drawCrop();
    }, { passive: true });
    window.addEventListener('touchend', function () { dragging = false; });
    stage.addEventListener('wheel', function (e) {
        e.preventDefault();
        var sl = document.getElementById('prof-zoom-slider');
        cropScale = Math.min(3, Math.max(1, cropScale - e.deltaY * 0.002));
        sl.value = cropScale; drawCrop();
    }, { passive: false });

    /* ══ PASSWORD TOGGLE ═══════════════════════════════════ */
    window.profTogglePw = function (id, btn) {
        var el = document.getElementById(id);
        var hide = el.type === 'text';
        el.type = hide ? 'password' : 'text';
        btn.innerHTML = hide
            ? '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>'
            : '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M1 1l22 22"/></svg>';
    };

})();
</script>