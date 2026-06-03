{{-- resources/views/admin/settings/partials/General/payment-methods.blade.php --}}

<style>
/* ── Reset & Base ── */
.pm-wrap * { box-sizing: border-box; }

/* ── Page Header ── */
.pm-back-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #4a7c3f;
    text-decoration: none;
    margin-bottom: 20px;
    font-weight: 500;
    transition: color 0.15s;
}
.pm-back-link:hover { color: #2d4a1e; }
.pm-back-link svg { flex-shrink: 0; }

.pm-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 6px;
}
.pm-page-title {
    font-size: 26px;
    font-weight: 700;
    color: #1a3a2a;
    margin: 0;
}
.pm-page-subtitle {
    color: #7a857f;
    font-size: 13.5px;
    margin: 0 0 24px;
}

/* ── Add New button ── */
.pm-btn-add-top {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #1A3D0A;
    color: #fff;
    border: none;
    border-radius: 2px;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background .15s;
    flex-shrink: 0;
}
.pm-btn-add-top:hover { background: #2d5a3d; }

/* ── Cards ── */
.pm-card {
    background: #fff;
    border: 1px solid #e5e9e6;
    border-radius: 8px;
    padding: 24px 28px;
    margin-bottom: 16px;
}

/* ── Card header row ── */
.pm-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.pm-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a3a2a;
    margin: 0;
}
.pm-card-subtitle {
    color: #8a9690;
    font-size: 13px;
    margin: 2px 0 0;
}

/* ── Toggle ── */
.pm-toggle-wrap { display: flex; align-items: center; gap: 10px; }
.pm-toggle {
    position: relative;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
    cursor: pointer;
}
.pm-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
.pm-toggle-slider {
    position: absolute;
    inset: 0;
    border-radius: 16px;
    background: #d1d9d4;
    transition: background #4B9960;
}
.pm-toggle-slider::after {
    content: '';
    position: absolute;
    top: 3px; left: 3px;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
    transition: transform .2s;
}
.pm-toggle input:checked + .pm-toggle-slider { background: #2d7a4f; }
.pm-toggle input:checked + .pm-toggle-slider::after { transform: translateX(20px); }

/* ── Cash textarea ── */
.pm-label {
    font-size: 12.5px;
    color: #5a6b62;
    font-weight: 500;
    margin: 18px 0 7px;
    display: block;
}
.pm-textarea {
    width: 100%;
    min-height: 90px;
    border: 1px solid #e0e6e2;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 13.5px;
    color: #2a3d33;
    background: #f8faf9;
    resize: vertical;
    outline: none;
    font-family: inherit;
    transition: border-color .15s;
}
.pm-textarea:focus { border-color: #2d7a4f; background: #fff; }

/* ── Divider ── */
.pm-divider {
    border: none;
    border-top: 1px solid #eef1ee;
    margin: 20px 0;
}

/* ── Bank list ── */
.pm-bank-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f0f4f1;
}
.pm-bank-row:last-of-type { border-bottom: none; }
.pm-bank-info { flex: 1; min-width: 0; }
.pm-bank-name { font-size: 14px; font-weight: 600; color: #1a3a2a; margin: 0 0 2px; }
.pm-bank-meta { font-size: 12.5px; color: #8a9690; }
.pm-bank-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.pm-icon-btn {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 8px;
    border: 1px solid #e5e9e6;
    background: #fff;
    cursor: pointer;
    color: #1A3D0A;
    transition: all .15s;
}
.pm-icon-btn:hover { background: #f0f4f1; border-color: #c8d4cc; color: #1a3a2a; }
.pm-icon-btn.danger{
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 8px;
    border: 1px solid #e5e9e6;
    background: #fff;
    cursor: pointer;
    color: #D9864A;
    transition: all .15s;
}
.pm-icon-btn.danger:hover {
    background: #fce8e6;
    border-color: #f5c5c0;
    color: #c0392b;
}

/* ── Add Bank button ── */
.pm-btn-add-bank {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #1A3D0A;
    color: #fff;
    border: none;
    border-radius: 2px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 14px;
    transition: background .15s;
}
.pm-btn-add-bank:hover { background: #2d5a3d; }

/* ── QRIS configure link ── */
.pm-configure-link {
    font-size: 13px;
    font-weight: 600;
    color: #c07a2a;
    text-decoration: none;
    cursor: pointer;
    transition: opacity .15s;
}
.pm-configure-link:hover { opacity: .7; }

/* ── Midtrans key inputs ── */
.pm-keys-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 18px;
}
.pm-key-group label {
    display: block;
    font-size: 12.5px;
    color: #5a6b62;
    font-weight: 500;
    margin-bottom: 7px;
}
.pm-key-input {
    width: 100%;
    border: 1px solid #e0e6e2;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #2a3d33;
    background: #f8faf9;
    outline: none;
    font-family: inherit;
    transition: border-color .15s;
}
.pm-key-input:focus { border-color: #2d7a4f; background: #fff; }

/* ── Footer actions ── */
.pm-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 28px;
}
.pm-btn-cancel {
    padding: 10px 24px;
    border-radius: 2px;
    border: none;
    background: #D9864A;
    color: #fff;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    font-family: inherit;
}
.pm-btn-cancel:hover { background: #D9864A; }
.pm-btn-save {
    padding: 10px 24px;
    border-radius: 2px;
    border: none;
    background: #1A3D0A;
    color: #fff;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    font-family: inherit;
}
.pm-btn-save:hover { background: #1A3D0A; }

/* ══════════════════════════════
   MODAL SHARED
══════════════════════════════ */
.pm-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.35);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.pm-overlay.open { display: flex; }

.pm-modal {
    background: #fff;
    border-radius: 8px;
    padding: 32px 32px 28px;
    width: 100%;
    max-width: 460px;
    margin: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    position: relative;
    animation: pmSlideIn .2s ease;
}
@keyframes pmSlideIn {
    from { opacity: 0; transform: translateY(14px) scale(.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.pm-modal-close {
    position: absolute;
    top: 18px; right: 20px;
    width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 8px;
    border: none;
    background: transparent;
    cursor: pointer;
    color: #7a857f;
    font-size: 18px;
    transition: background .15s;
}
.pm-modal-close:hover { background: #f0f4f1; color: #1a3a2a; }

.pm-modal h3 { font-size: 18px; font-weight: 700; color: #1a3a2a; margin: 0 0 6px; }
.pm-modal p.pm-modal-sub { font-size: 13px; color: #7a857f; margin: 0 0 22px; line-height: 1.5; }

.pm-form-group { margin-bottom: 16px; }
.pm-form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #5a6b62;
    letter-spacing: .04em;
    text-transform: uppercase;
    margin-bottom: 7px;
}
.pm-form-input,
.pm-form-select {
    width: 100%;
    border: 1.5px solid #e0e6e2;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #2a3d33;
    background: #fff;
    outline: none;
    font-family: inherit;
    transition: border-color .15s;
    appearance: none;
}
.pm-form-input:focus,
.pm-form-select:focus { border-color: #2d7a4f; }
.pm-form-input::placeholder { color: #b0bdb6; }

.pm-select-wrap { position: relative; }
.pm-select-wrap::after {
    content: '';
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid #6b7c72;
    pointer-events: none;
}

.pm-input-icon-wrap { position: relative; }
.pm-input-icon-wrap .pm-form-input { padding-right: 40px; }
.pm-input-icon {
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    color: #9aaa96;
    font-size: 15px;
}

.pm-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 4px 0;
}
.pm-toggle-row-label .pm-toggle-row-title {
    font-size: 14px;
    font-weight: 600;
    color: #1a3a2a;
}
.pm-toggle-row-label .pm-toggle-row-desc {
    font-size: 12.5px;
    color: #8a9690;
    margin-top: 1px;
}

.pm-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 24px;
}
.pm-modal-footer .pm-btn-cancel { padding: 9px 22px; }
.pm-modal-footer .pm-btn-save { padding: 9px 22px; }

/* Bank list edit state */
.pm-bank-row[data-editing="true"] { background: #f8faf9; border-radius: 8px; padding: 10px 12px; margin: 4px -12px; }
</style>

<div class="pm-wrap">

    {{-- ── Back link ── --}}
    <a href="{{ route('admin.settings', ['section' => 'general']) }}" class="pm-back-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
        </svg>
        Back to General Settings
    </a>

    {{-- ── Page heading ── --}}
    <div class="pm-page-header">
        <h2 class="pm-page-title">Payment Methods</h2>
        <button class="pm-btn-add-top" onclick="openModal('pm-modal-new-method')">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New Payment Methods
        </button>
    </div>
    <p class="pm-page-subtitle">Manage cash, manual bank transfers, e-wallets, and payment gateways.</p>

    {{-- ══════════════════════════════════════
         CARD 1 — Pay at Property (Cash)
    ══════════════════════════════════════ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <h3 class="pm-card-title">Pay at Property (Cash)</h3>
            <label class="pm-toggle" title="Enable / Disable">
                <input type="checkbox" checked id="toggle-cash">
                <span class="pm-toggle-slider"></span>
            </label>
        </div>
        <label class="pm-label" for="cash-instruction">Guest Instruction (Display at checkout)</label>
        <textarea class="pm-textarea" id="cash-instruction"
            placeholder="Please prepare exact cash in IDR upon arrival at the front desk."
        >Please prepare exact cash in IDR upon arrival at the front desk.</textarea>
    </div>

    {{-- ══════════════════════════════════════
         CARD 2 — Manual Bank Transfers
    ══════════════════════════════════════ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <h3 class="pm-card-title">Manual Bank Transfers</h3>
        </div>

        <hr class="pm-divider" style="margin-top:14px;">

        <div id="pm-bank-list">
            {{-- Rendered by JS --}}
        </div>

        <button class="pm-btn-add-bank" onclick="openModal('pm-modal-add-bank')">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New Bank Account
        </button>
    </div>

    {{-- ══════════════════════════════════════
         CARD 3 — QRIS Integration
    ══════════════════════════════════════ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <div>
                <h3 class="pm-card-title">QRIS Integration</h3>
                <p class="pm-card-subtitle">Accept payments via GoPay, OVO, Dana.</p>
            </div>
            <div class="pm-toggle-wrap">
                <a class="pm-configure-link" href="#" onclick="return false;">Configure QR</a>
                <label class="pm-toggle" title="Enable / Disable">
                    <input type="checkbox" checked id="toggle-qris">
                    <span class="pm-toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         CARD 4 — Midtrans / Payment Gateway
    ══════════════════════════════════════ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <h3 class="pm-card-title">Midtrans / Payment Gateway</h3>
            <label class="pm-toggle" title="Enable / Disable">
                <input type="checkbox" checked id="toggle-midtrans">
                <span class="pm-toggle-slider"></span>
            </label>
        </div>
        <div class="pm-keys-grid">
            <div class="pm-key-group">
                <label for="midtrans-client-key">Client Key</label>
                <input class="pm-key-input" id="midtrans-client-key" type="text"
                    placeholder="Mid-client-xxxx..." value="Mid-client-xxxx...">
            </div>
            <div class="pm-key-group">
                <label for="midtrans-server-key">Server Key</label>
                <input class="pm-key-input" id="midtrans-server-key" type="password"
                    placeholder="Mid-server-xxxx..." value="Mid-server-xxxx...">
            </div>
        </div>
    </div>

    {{-- ── Footer actions ── --}}
    <div class="pm-footer">
        <button class="pm-btn-cancel" onclick="handleCancel()">Cancel</button>
        <button class="pm-btn-save" onclick="handleSave()">Save Settings</button>
    </div>

</div>{{-- .pm-wrap --}}


{{-- ══════════════════════════════════════════════════
     MODAL 1 — Add New Bank Account
══════════════════════════════════════════════════ --}}
<div class="pm-overlay" id="pm-modal-add-bank">
    <div class="pm-modal">
        <button class="pm-modal-close" onclick="closeModal('pm-modal-add-bank')">&#x2715;</button>
        <h3 id="pm-bank-modal-title">Add New Bank Account</h3>
        <p class="pm-modal-sub">Connect a new bank account to your management profile.</p>

        <input type="hidden" id="pm-bank-edit-index" value="">

        <div class="pm-form-group">
            <label class="pm-form-label">Select Bank</label>
            <div class="pm-select-wrap">
                <select class="pm-form-select" id="pm-bank-select">
                    <option value="">Choose your banking provider</option>
                    <option value="Bank Central Asia (BCA)">Bank Central Asia (BCA)</option>
                    <option value="Bank Mandiri">Bank Mandiri</option>
                    <option value="Bank Rakyat Indonesia (BRI)">Bank Rakyat Indonesia (BRI)</option>
                    <option value="Bank Negara Indonesia (BNI)">Bank Negara Indonesia (BNI)</option>
                    <option value="CIMB Niaga">CIMB Niaga</option>
                    <option value="Danamon">Danamon</option>
                    <option value="Permata Bank">Permata Bank</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
        </div>

        <div class="pm-form-group">
            <label class="pm-form-label">Account Holder Name</label>
            <input class="pm-form-input" id="pm-bank-holder" type="text"
                placeholder="e.g., AlaSare Eco-Hostel">
        </div>

        <div class="pm-form-group">
            <label class="pm-form-label">Account Number</label>
            <input class="pm-form-input" id="pm-bank-number" type="text"
                placeholder="e.g., 1234567890" inputmode="numeric">
        </div>

        <div class="pm-toggle-row">
            <div class="pm-toggle-row-label">
                <div class="pm-toggle-row-title">Set as Default Payment Method</div>
                <div class="pm-toggle-row-desc">Primary account for all incoming transactions.</div>
            </div>
            <label class="pm-toggle">
                <input type="checkbox" id="pm-bank-default">
                <span class="pm-toggle-slider"></span>
            </label>
        </div>

        <div class="pm-modal-footer">
            <button class="pm-btn-cancel" onclick="closeModal('pm-modal-add-bank')">Cancel</button>
            <button class="pm-btn-save" onclick="submitBankForm()">Add Account</button>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════
     MODAL 2 — Add New Payment Method
══════════════════════════════════════════════════ --}}
<div class="pm-overlay" id="pm-modal-new-method">
    <div class="pm-modal">
        <button class="pm-modal-close" onclick="closeModal('pm-modal-new-method')">&#x2715;</button>
        <h3>Add New Payment Method</h3>
        <p class="pm-modal-sub">Choose your preferred payment method and provide the necessary details for secure transactions.</p>

        <div class="pm-form-group">
            <label class="pm-form-label">Select Payment Type</label>
            <div class="pm-select-wrap">
                <select class="pm-form-select" id="pm-method-type">
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Virtual Account">Virtual Account</option>
                    <option value="Payment Gateway">Payment Gateway</option>
                </select>
            </div>
        </div>

        <div class="pm-form-group">
            <label class="pm-form-label">Provider Name</label>
            <input class="pm-form-input" id="pm-method-provider" type="text"
                placeholder="e.g., Chase, Visa, PayPal">
        </div>

        <div class="pm-form-group">
            <label class="pm-form-label">Account / Card Number</label>
            <input class="pm-form-input" id="pm-method-number" type="text"
                placeholder="e.g., 1234 5678 9012 3456">
        </div>

        <div class="pm-form-group">
            <label class="pm-form-label">Email ID / Username</label>
            <div class="pm-input-icon-wrap">
                <input class="pm-form-input" id="pm-method-email" type="email"
                    placeholder="email@example.com">
                <span class="pm-input-icon">@</span>
            </div>
        </div>

        <div class="pm-toggle-row">
            <div class="pm-toggle-row-label">
                <div class="pm-toggle-row-title">Set as Default Method</div>
                <div class="pm-toggle-row-desc">Use this for all future transactions</div>
            </div>
            <label class="pm-toggle">
                <input type="checkbox" id="pm-method-default" checked>
                <span class="pm-toggle-slider"></span>
            </label>
        </div>

        <div class="pm-modal-footer">
            <button class="pm-btn-cancel" onclick="closeModal('pm-modal-new-method')">Cancel</button>
            <button class="pm-btn-save" onclick="submitMethodForm()">Add Payment Method</button>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════
     JAVASCRIPT — Local state, no backend
══════════════════════════════════════════════════ --}}
<script>
(function () {

    /* ── Local state ── */
    var banks = [
        { id: 1, bank: 'Bank Central Asia (BCA)', holder: 'AlaSare Hostel', number: '1234567890', active: true,  isDefault: false },
        { id: 2, bank: 'Bank Mandiri',             holder: 'AlaSare Hostel', number: '0987654321', active: false, isDefault: false },
    ];
    var nextId = 3;

    /* ── Helpers ── */
    function svgEdit() {
        return '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">'
             + '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>'
             + '<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>'
             + '</svg>';
    }
    function svgTrash() {
        return '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">'
             + '<polyline points="3 6 5 6 21 6"/>'
             + '<path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>'
             + '<path d="M10 11v6M14 11v6"/>'
             + '<path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>'
             + '</svg>';
    }

    /* ── Render bank list ── */
    function renderBanks() {
        var container = document.getElementById('pm-bank-list');
        if (!banks.length) {
            container.innerHTML = '<p style="color:#9aaa96;font-size:13px;padding:8px 0;">No bank accounts added yet.</p>';
            return;
        }
        container.innerHTML = banks.map(function (b, i) {
            return '<div class="pm-bank-row" data-id="' + b.id + '">'
                 +   '<div class="pm-bank-info">'
                 +     '<p class="pm-bank-name">' + escHtml(b.bank) + (b.isDefault ? ' <span style="font-size:11px;background:#eef7f2;color:#2d7a4f;padding:1px 7px;border-radius:20px;font-weight:600;">Default</span>' : '') + '</p>'
                 +     '<span class="pm-bank-meta">A/N ' + escHtml(b.holder) + ' &bull; Acc: ' + escHtml(b.number) + '</span>'
                 +   '</div>'
                 +   '<div class="pm-bank-actions">'
                 +     '<button class="pm-icon-btn" onclick="editBank(' + i + ')" title="Edit">' + svgEdit() + '</button>'
                 +     '<button class="pm-icon-btn danger" onclick="deleteBank(' + i + ')" title="Delete">' + svgTrash() + '</button>'
                 +     '<label class="pm-toggle" title="Enable / Disable">'
                 +       '<input type="checkbox" ' + (b.active ? 'checked' : '') + ' onchange="toggleBank(' + i + ', this.checked)">'
                 +       '<span class="pm-toggle-slider"></span>'
                 +     '</label>'
                 +   '</div>'
                 + '</div>';
        }).join('');
    }

    /* ── Bank CRUD ── */
    window.editBank = function (idx) {
        var b = banks[idx];
        document.getElementById('pm-bank-modal-title').textContent = 'Edit Bank Account';
        document.getElementById('pm-bank-edit-index').value = idx;
        document.getElementById('pm-bank-select').value   = b.bank;
        document.getElementById('pm-bank-holder').value   = b.holder;
        document.getElementById('pm-bank-number').value   = b.number;
        document.getElementById('pm-bank-default').checked = b.isDefault;
        document.querySelector('#pm-modal-add-bank .pm-btn-save').textContent = 'Update Account';
        openModal('pm-modal-add-bank');
    };

    window.deleteBank = function (idx) {
        if (!confirm('Remove "' + banks[idx].bank + '"?')) return;
        banks.splice(idx, 1);
        renderBanks();
    };

    window.toggleBank = function (idx, val) {
        banks[idx].active = val;
    };

    window.submitBankForm = function () {
        var bank    = document.getElementById('pm-bank-select').value.trim();
        var holder  = document.getElementById('pm-bank-holder').value.trim();
        var number  = document.getElementById('pm-bank-number').value.trim();
        var isDefault = document.getElementById('pm-bank-default').checked;
        var editIdx = document.getElementById('pm-bank-edit-index').value;

        if (!bank || !holder || !number) {
            alert('Please fill in all required fields.');
            return;
        }

        if (isDefault) {
            banks.forEach(function (b) { b.isDefault = false; });
        }

        if (editIdx !== '') {
            banks[parseInt(editIdx)] = Object.assign(banks[parseInt(editIdx)], { bank: bank, holder: holder, number: number, isDefault: isDefault });
        } else {
            banks.push({ id: nextId++, bank: bank, holder: holder, number: number, active: true, isDefault: isDefault });
        }

        renderBanks();
        closeModal('pm-modal-add-bank');
        resetBankForm();
    };

    function resetBankForm() {
        document.getElementById('pm-bank-modal-title').textContent = 'Add New Bank Account';
        document.getElementById('pm-bank-edit-index').value = '';
        document.getElementById('pm-bank-select').value    = '';
        document.getElementById('pm-bank-holder').value    = '';
        document.getElementById('pm-bank-number').value    = '';
        document.getElementById('pm-bank-default').checked = false;
        document.querySelector('#pm-modal-add-bank .pm-btn-save').textContent = 'Add Account';
    }

    /* ── New Payment Method ── */
    window.submitMethodForm = function () {
        var type     = document.getElementById('pm-method-type').value;
        var provider = document.getElementById('pm-method-provider').value.trim();
        var number   = document.getElementById('pm-method-number').value.trim();
        var email    = document.getElementById('pm-method-email').value.trim();

        if (!provider) {
            alert('Please enter a provider name.');
            return;
        }

        // In a real app: push to method list; here just notify + close
        alert('Payment method "' + provider + '" (' + type + ') added successfully.');
        closeModal('pm-modal-new-method');
        document.getElementById('pm-method-provider').value = '';
        document.getElementById('pm-method-number').value   = '';
        document.getElementById('pm-method-email').value    = '';
    };

    /* ── Modal helpers ── */
    window.openModal = function (id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    };
    window.closeModal = function (id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
        if (id === 'pm-modal-add-bank') resetBankForm();
    };

    /* Close on overlay click */
    document.querySelectorAll('.pm-overlay').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (e.target === el) closeModal(el.id);
        });
    });

    /* ── Save / Cancel ── */
    window.handleSave = function () {
        // Collect all state here and send via AJAX / form submission
        var payload = {
            cash: {
                active: document.getElementById('toggle-cash').checked,
                instruction: document.getElementById('cash-instruction').value,
            },
            banks: banks,
            qris:  { active: document.getElementById('toggle-qris').checked },
            midtrans: {
                active:    document.getElementById('toggle-midtrans').checked,
                clientKey: document.getElementById('midtrans-client-key').value,
                serverKey: document.getElementById('midtrans-server-key').value,
            }
        };
        console.log('Save payload:', payload);
        alert('Settings saved! (FE-only demo — check console for payload)');
    };

    window.handleCancel = function () {
            window.location.href = '{{ route("admin.settings", ["section" => "general"]) }}';
    };

    /* ── Escape HTML ── */
    function escHtml(str) {
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    /* ── Init ── */
    renderBanks();

})();
</script>