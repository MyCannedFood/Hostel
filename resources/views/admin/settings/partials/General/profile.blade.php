{{-- resources/views/admin/settings/partials/General/profile.blade.php --}}


<style>
/* ════════════════════════════════════════════════
   PM-* BASE STYLES (sama persis dengan payment-methods)
   ════════════════════════════════════════════════ */

.pm-back-link {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; color: #4a7c3f; text-decoration: none;
    margin-bottom: 20px; font-weight: 500; transition: color 0.15s;
}
.pm-back-link:hover { color: #2d4a1e; }
.pm-back-link svg { flex-shrink: 0; }

.pm-page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 6px; }
.pm-page-title  { font-size: 26px; font-weight: 700; color: #1a3a2a; margin: 0; }
.pm-page-subtitle { color: #7a857f; font-size: 13.5px; margin: 0 0 24px; }

.pm-card { background: #fff; border: 1px solid #e5e9e6; border-radius: 8px; padding: 24px 28px; margin-bottom: 16px; }

.pm-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 28px; }
.pm-btn-cancel {
    padding: 10px 24px; border-radius: 2px; border: none;
    background: #D9864A; color: #fff; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: background .15s; font-family: inherit;
}
.pm-btn-cancel:hover { background: #c4733a; }
.pm-btn-save {
    padding: 10px 24px; border-radius: 2px; border: none;
    background: #1A3D0A; color: #fff; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: background .15s; font-family: inherit;
}
.pm-btn-save:hover { background: #2d5a1a; }

/* ════════════════════════════════════════════════
   PROFILE-SPECIFIC STYLES
   ════════════════════════════════════════════════ */

/* Avatar */
.prof-avatar-wrap {
    display: flex; align-items: center; gap: 18px;
    margin-bottom: 28px; padding-bottom: 24px;
    border-bottom: 1px solid #eef1ee;
}
.prof-avatar {
    width: 64px; height: 64px; border-radius: 50%;
    background: #e8ede8; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden; border: 2px solid #dde3de;
    transition: border-color .15s;
}
.prof-avatar img { width: 100%; height: 100%; object-fit: cover; }
.prof-avatar svg { color: #9aaa96; }
.prof-upload-link {
    font-size: 13px; font-weight: 600; color: #1A3D0A;
    cursor: pointer; transition: opacity .15s;
}
.prof-upload-link:hover { opacity: .7; }
.prof-upload-link input[type="file"] { display: none; }

/* Fields */
.prof-fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 32px; }
@media (max-width: 600px) { .prof-fields-grid { grid-template-columns: 1fr; } }

.prof-field { padding: 12px 0 16px; border-bottom: 1.5px solid #e0e6e2; margin-bottom: 12px; }
.prof-field-label { font-size: 12px; color: #8a9690; font-weight: 500; margin-bottom: 6px; display: block; }
.prof-field-input {
    width: 100%; border: none; outline: none;
    font-size: 14.5px; color: #1a3d0a; background: transparent;
    font-family: inherit; padding: 0;
}
.prof-field-input::placeholder { color: #c0ccc5; }
.prof-field-input[readonly]    { color: #8a9690; cursor: default; }

/* Password card */
.prof-pw-header { display: flex; align-items: center; gap: 9px; margin-bottom: 22px; }
.prof-pw-header svg { color: #1A3D0A; flex-shrink: 0; }
.prof-pw-title  { font-size: 15px; font-weight: 700; color: #1a3d0a; margin: 0; }

.prof-pw-field { padding: 10px 0 14px; border-bottom: 1.5px solid #e0e6e2; margin-bottom: 16px; }
.prof-pw-field:last-of-type { margin-bottom: 0; }
.prof-pw-hint {
    display: flex; align-items: flex-start; gap: 7px;
    margin-top: 16px; font-size: 12.5px; color: #8a9690; line-height: 1.5;
}
.prof-pw-hint svg { flex-shrink: 0; margin-top: 1px; }
.prof-pw-wrap { position: relative; }
.prof-pw-wrap .prof-field-input { padding-right: 28px; }
.prof-eye-btn {
    position: absolute; right: 0; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: #9aaa96;
    padding: 0; display: flex; transition: color .15s;
}
.prof-eye-btn:hover { color: #1A3D0A; }

/* Validation */
.prof-field.error .prof-field-input,
.prof-pw-field.error .prof-field-input { color: #c0392b; }
.prof-field.error,
.prof-pw-field.error { border-bottom-color: #e57373; }
.prof-error-msg { font-size: 11.5px; color: #c0392b; margin-top: 4px; display: none; }
.prof-field.error .prof-error-msg,
.prof-pw-field.error .prof-error-msg { display: block; }

/* ════════════════════════════════════════════════
   CROP MODAL
   ════════════════════════════════════════════════ */
.prof-crop-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.5); z-index: 1000;
    align-items: center; justify-content: center;
}
.prof-crop-overlay.open { display: flex; }

.prof-crop-modal {
    background: #fff; border-radius: 8px; padding: 28px;
    width: 100%; max-width: 420px; margin: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    animation: profSlideIn .2s ease;
}
@keyframes profSlideIn {
    from { opacity: 0; transform: translateY(14px) scale(.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

.prof-crop-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px; }
.prof-crop-title  { font-size: 17px; font-weight: 700; color: #1a3d0a; margin: 0; }
.prof-crop-sub    { font-size: 13px; color: #8a9690; margin: 0 0 18px; }
.prof-crop-close  {
    width: 30px; height: 30px; border: none; border-radius: 7px;
    background: #f0f4ee; color: #7a857f; font-size: 16px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: background .15s;
}
.prof-crop-close:hover { background: #e0e8de; }

/* Canvas stage */
.prof-crop-stage {
    position: relative; width: 100%; aspect-ratio: 1;
    background: #111; border-radius: 8px; overflow: hidden;
    cursor: grab; user-select: none; margin-bottom: 14px;
    touch-action: none;
}
.prof-crop-stage:active { cursor: grabbing; }
#prof-crop-canvas { display: block; width: 100%; height: 100%; }

/* SVG circle mask overlay */
.prof-crop-mask { position: absolute; inset: 0; pointer-events: none; }

/* Zoom */
.prof-zoom-wrap  { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.prof-zoom-icon  { color: #9aaa96; flex-shrink: 0; }
.prof-zoom-slider {
    flex: 1; -webkit-appearance: none; appearance: none;
    height: 4px; border-radius: 4px; background: #e0e6e2;
    outline: none; cursor: pointer;
}
.prof-zoom-slider::-webkit-slider-thumb {
    -webkit-appearance: none; width: 16px; height: 16px;
    border-radius: 50%; background: #1A3D0A; cursor: pointer;
    box-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.prof-zoom-slider::-moz-range-thumb {
    width: 16px; height: 16px; border-radius: 50%;
    background: #1A3D0A; border: none; cursor: pointer;
}

.prof-crop-footer { display: flex; justify-content: flex-end; gap: 10px; }
</style>

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
     CARD 1 — Personal Info
══════════════════════════════════ --}}
<div class="pm-card">
    <div class="prof-avatar-wrap">
        <div class="prof-avatar" id="prof-avatar-preview">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <label class="prof-upload-link">
            + Upload Photo
            <input type="file" id="prof-file-input" accept="image/*" onchange="profOnFileChange(this)">
        </label>
    </div>

    <div class="prof-fields-grid">
        <div>
            <div class="prof-field" id="field-fullname">
                <label class="prof-field-label" for="prof-fullname">Full Name</label>
                <input class="prof-field-input" id="prof-fullname" type="text" value="Admin AlaSare" placeholder="Your full name">
                <span class="prof-error-msg">Full name is required.</span>
            </div>
        </div>
        <div>
            <div class="prof-field">
                <label class="prof-field-label">Role</label>
                <input class="prof-field-input" type="text" value="Super Admin" readonly>
            </div>
        </div>
        <div>
            <div class="prof-field" id="field-email">
                <label class="prof-field-label" for="prof-email">Email Address</label>
                <input class="prof-field-input" id="prof-email" type="email" value="admin@alasare.com" placeholder="email@example.com">
                <span class="prof-error-msg">Enter a valid email address.</span>
            </div>
        </div>
        <div>
            <div class="prof-field" id="field-phone">
                <label class="prof-field-label" for="prof-phone">Phone Number</label>
                <input class="prof-field-input" id="prof-phone" type="tel" value="+62 812 3456 7890" placeholder="+62 8xx xxxx xxxx">
                <span class="prof-error-msg">Phone number is required.</span>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════
     CARD 2 — Change Password
══════════════════════════════════ --}}
<div class="pm-card">
    <div class="prof-pw-header">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        <h3 class="prof-pw-title">Change Password</h3>
    </div>

    <div class="prof-pw-field" id="field-current-pw">
        <label class="prof-field-label" for="prof-current-pw">Current Password</label>
        <div class="prof-pw-wrap">
            <input class="prof-field-input" id="prof-current-pw" type="password" placeholder="Enter current password">
            <button class="prof-eye-btn" type="button" onclick="profTogglePw('prof-current-pw', this)">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        <span class="prof-error-msg">Current password is required.</span>
    </div>

    <div class="prof-pw-field" id="field-new-pw">
        <label class="prof-field-label" for="prof-new-pw">New Password</label>
        <div class="prof-pw-wrap">
            <input class="prof-field-input" id="prof-new-pw" type="password" placeholder="Enter new password">
            <button class="prof-eye-btn" type="button" onclick="profTogglePw('prof-new-pw', this)">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        <span class="prof-error-msg">Min 8 karakter dan mengandung angka.</span>
    </div>

    <div class="prof-pw-field" id="field-confirm-pw">
        <label class="prof-field-label" for="prof-confirm-pw">Confirm New Password</label>
        <div class="prof-pw-wrap">
            <input class="prof-field-input" id="prof-confirm-pw" type="password" placeholder="Repeat new password">
            <button class="prof-eye-btn" type="button" onclick="profTogglePw('prof-confirm-pw', this)">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
        <span class="prof-error-msg">Password tidak cocok.</span>
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
    <button class="pm-btn-cancel" onclick="profHandleCancel()">Cancel</button>
    <button class="pm-btn-save" onclick="profHandleSave()">Save Profile</button>
</div>


{{-- ══════════════════════════════════
     CROP MODAL
══════════════════════════════════ --}}
<div class="prof-crop-overlay" id="prof-crop-overlay">
    <div class="prof-crop-modal">
        <div class="prof-crop-header">
            <h3 class="prof-crop-title">Crop Photo</h3>
            <button class="prof-crop-close" onclick="profCloseCrop()">&#x2715;</button>
        </div>
        <p class="prof-crop-sub">Drag to reposition · Scroll or slide to zoom</p>

        {{-- Canvas + SVG mask overlay --}}
        <div class="prof-crop-stage" id="prof-crop-stage">
            <canvas id="prof-crop-canvas"></canvas>
            {{-- Dark overlay with circle cutout --}}
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

        {{-- Zoom slider --}}
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


{{-- ════════════════════════════════
     JAVASCRIPT
════════════════════════════════ --}}
<script>
(function () {

    /* ══════════════════════════════
       CROP STATE
    ══════════════════════════════ */
    var cropImg    = null;   // HTMLImageElement
    var cropScale  = 1;
    var cropX      = 0;     // offset of image center from canvas center
    var cropY      = 0;
    var dragging   = false;
    var dragStartX = 0;
    var dragStartY = 0;
    var CANVAS_SIZE = 360;  // internal canvas resolution

    /* ── Open crop modal after file chosen ── */
    window.profOnFileChange = function (input) {
        if (!input.files || !input.files[0]) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.onload = function () {
                cropImg   = img;
                cropScale = 1;
                cropX     = 0;
                cropY     = 0;
                document.getElementById('prof-zoom-slider').value = 1;
                initCanvas();
                document.getElementById('prof-crop-overlay').classList.add('open');
                document.body.style.overflow = 'hidden';
                drawCrop();
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        /* Reset input so same file can be re-selected */
        input.value = '';
    };

    /* ── Init canvas size ── */
    function initCanvas() {
        var canvas = document.getElementById('prof-crop-canvas');
        canvas.width  = CANVAS_SIZE;
        canvas.height = CANVAS_SIZE;
    }

    /* ── Draw current crop state ── */
    function drawCrop() {
        var canvas = document.getElementById('prof-crop-canvas');
        var ctx    = canvas.getContext('2d');
        var S      = CANVAS_SIZE;

        ctx.clearRect(0, 0, S, S);

        if (!cropImg) return;

        /* Fit image into canvas at scale=1 (cover) */
        var imgAspect    = cropImg.width / cropImg.height;
        var baseW, baseH;
        if (imgAspect > 1) { baseH = S; baseW = S * imgAspect; }
        else               { baseW = S; baseH = S / imgAspect; }

        var drawW = baseW * cropScale;
        var drawH = baseH * cropScale;

        /* Clamp so circle (radius = S*0.42) stays covered */
        var r    = S * 0.42;
        var minX = -(drawW / 2 - r);
        var maxX =  (drawW / 2 - r);
        var minY = -(drawH / 2 - r);
        var maxY =  (drawH / 2 - r);
        cropX = Math.max(minX, Math.min(maxX, cropX));
        cropY = Math.max(minY, Math.min(maxY, cropY));

        var x = S / 2 - drawW / 2 + cropX;
        var y = S / 2 - drawH / 2 + cropY;

        ctx.drawImage(cropImg, x, y, drawW, drawH);
    }

    /* ── Apply crop → output circular avatar ── */
    window.profApplyCrop = function () {
        var src    = document.getElementById('prof-crop-canvas');
        var out    = document.createElement('canvas');
        var S      = CANVAS_SIZE;
        out.width  = S;
        out.height = S;
        var ctx    = out.getContext('2d');

        /* Clip to circle */
        ctx.beginPath();
        ctx.arc(S / 2, S / 2, S * 0.42, 0, Math.PI * 2);
        ctx.clip();
        ctx.drawImage(src, 0, 0);

        var dataUrl = out.toDataURL('image/png');
        var wrap = document.getElementById('prof-avatar-preview');
        wrap.innerHTML = '<img src="' + dataUrl + '" alt="Avatar">';

        profCloseCrop();
    };

    window.profCloseCrop = function () {
        document.getElementById('prof-crop-overlay').classList.remove('open');
        document.body.style.overflow = '';
    };

    /* Close on overlay click */
    document.getElementById('prof-crop-overlay').addEventListener('click', function (e) {
        if (e.target === this) profCloseCrop();
    });

    /* ── Zoom slider ── */
    document.getElementById('prof-zoom-slider').addEventListener('input', function () {
        cropScale = parseFloat(this.value);
        drawCrop();
    });

    /* ── Mouse drag ── */
    var stage = document.getElementById('prof-crop-stage');

    stage.addEventListener('mousedown', function (e) {
        dragging   = true;
        dragStartX = e.clientX - cropX;
        dragStartY = e.clientY - cropY;
        e.preventDefault();
    });
    window.addEventListener('mousemove', function (e) {
        if (!dragging) return;
        cropX = e.clientX - dragStartX;
        cropY = e.clientY - dragStartY;
        drawCrop();
    });
    window.addEventListener('mouseup', function () { dragging = false; });

    /* ── Touch drag ── */
    stage.addEventListener('touchstart', function (e) {
        var t  = e.touches[0];
        dragging   = true;
        dragStartX = t.clientX - cropX;
        dragStartY = t.clientY - cropY;
        e.preventDefault();
    }, { passive: false });
    window.addEventListener('touchmove', function (e) {
        if (!dragging) return;
        var t  = e.touches[0];
        cropX  = t.clientX - dragStartX;
        cropY  = t.clientY - dragStartY;
        drawCrop();
    }, { passive: true });
    window.addEventListener('touchend', function () { dragging = false; });

    /* ── Scroll to zoom (mouse wheel) ── */
    stage.addEventListener('wheel', function (e) {
        e.preventDefault();
        var slider = document.getElementById('prof-zoom-slider');
        cropScale  = Math.min(3, Math.max(1, cropScale - e.deltaY * 0.002));
        slider.value = cropScale;
        drawCrop();
    }, { passive: false });

    /* ══════════════════════════════
       PASSWORD TOGGLE
    ══════════════════════════════ */
    window.profTogglePw = function (inputId, btn) {
        var input  = document.getElementById(inputId);
        var isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.innerHTML = isText
            ? '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>'
            : '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M1 1l22 22"/></svg>';
    };

    /* ══════════════════════════════
       SAVE / CANCEL
    ══════════════════════════════ */
    function setError(id, show) {
        var el = document.getElementById(id);
        if (el) el.classList.toggle('error', show);
    }
    function isValidEmail(v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); }
    function isValidPw(v)    { return v.length >= 8 && /\d/.test(v); }

    window.profHandleSave = function () {
        var fullname  = document.getElementById('prof-fullname').value.trim();
        var email     = document.getElementById('prof-email').value.trim();
        var phone     = document.getElementById('prof-phone').value.trim();
        var currentPw = document.getElementById('prof-current-pw').value;
        var newPw     = document.getElementById('prof-new-pw').value;
        var confirmPw = document.getElementById('prof-confirm-pw').value;
        var hasError  = false;

        setError('field-fullname', !fullname);
        setError('field-email',    !isValidEmail(email));
        setError('field-phone',    !phone);
        if (!fullname || !isValidEmail(email) || !phone) hasError = true;

        var pwTouched = currentPw || newPw || confirmPw;
        if (pwTouched) {
            setError('field-current-pw', !currentPw);
            setError('field-new-pw',     !isValidPw(newPw));
            setError('field-confirm-pw', newPw !== confirmPw);
            if (!currentPw || !isValidPw(newPw) || newPw !== confirmPw) hasError = true;
        } else {
            ['field-current-pw','field-new-pw','field-confirm-pw'].forEach(function (id) { setError(id, false); });
        }

        if (hasError) return;

        var payload = { fullname, email, phone, changePassword: pwTouched ? { currentPw, newPw } : null };
        console.log('Profile save payload:', payload);
        alert('Profile saved! (FE-only — lihat console untuk payload)');
    };

    window.profHandleCancel = function () {
        
            window.location.href = '{{ route("admin.settings", ["section" => "general"]) }}';

    };

})();
</script>