{{-- resources/views/admin/settings/partials/General/payment-methods.blade.php --}}

<style>
.pm-wrap * { box-sizing: border-box; }
.pm-back-link { display:inline-flex;align-items:center;gap:5px;font-size:13px;color:#4a7c3f;text-decoration:none;margin-bottom:20px;font-weight:500;transition:color .15s; }
.pm-back-link:hover { color:#2d4a1e; }
.pm-page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:6px; }
.pm-page-title { font-size:26px;font-weight:700;color:#1a3a2a;margin:0; }
.pm-page-subtitle { color:#7a857f;font-size:13.5px;margin:0 0 24px; }
.pm-btn-add-top { display:inline-flex;align-items:center;gap:7px;background:#1A3D0A;color:#fff;border:none;border-radius:2px;padding:10px 18px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;flex-shrink:0; }
.pm-btn-add-top:hover { background:#2d5a3d; }
.pm-card { background:#fff;border:1px solid #e5e9e6;border-radius:8px;padding:24px 28px;margin-bottom:16px; }
.pm-card-header { display:flex;align-items:center;justify-content:space-between;gap:12px; }
.pm-card-title { font-size:16px;font-weight:700;color:#1a3a2a;margin:0; }
.pm-card-subtitle { color:#8a9690;font-size:13px;margin:2px 0 0; }
.pm-toggle-wrap { display:flex;align-items:center;gap:10px; }
.pm-toggle { position:relative;width:44px;height:24px;flex-shrink:0;cursor:pointer; }
.pm-toggle input { opacity:0;width:0;height:0;position:absolute; }
.pm-toggle-slider { position:absolute;inset:0;border-radius:16px;background:#d1d9d4;transition:background .2s; }
.pm-toggle-slider::after { content:'';position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.2);transition:transform .2s; }
.pm-toggle input:checked + .pm-toggle-slider { background:#2d7a4f; }
.pm-toggle input:checked + .pm-toggle-slider::after { transform:translateX(20px); }
.pm-label { font-size:12.5px;color:#5a6b62;font-weight:500;margin:18px 0 7px;display:block; }
.pm-textarea { width:100%;min-height:90px;border:1px solid #e0e6e2;border-radius:8px;padding:12px 14px;font-size:13.5px;color:#2a3d33;background:#f8faf9;resize:vertical;outline:none;font-family:inherit;transition:border-color .15s; }
.pm-textarea:focus { border-color:#2d7a4f;background:#fff; }
.pm-divider { border:none;border-top:1px solid #eef1ee;margin:20px 0; }
.pm-bank-row { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px solid #f0f4f1; }
.pm-bank-row:last-of-type { border-bottom:none; }
.pm-bank-info { flex:1;min-width:0; }
.pm-bank-name { font-size:14px;font-weight:600;color:#1a3a2a;margin:0 0 2px; }
.pm-bank-meta { font-size:12.5px;color:#8a9690; }
.pm-bank-actions { display:flex;align-items:center;gap:10px;flex-shrink:0; }
.pm-icon-btn { width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1px solid #e5e9e6;background:#fff;cursor:pointer;color:#1A3D0A;transition:all .15s; }
.pm-icon-btn:hover { background:#f0f4f1;border-color:#c8d4cc; }
.pm-icon-btn.danger { color:#D9864A; }
.pm-icon-btn.danger:hover { background:#fce8e6;border-color:#f5c5c0;color:#c0392b; }
.pm-btn-add-bank { display:inline-flex;align-items:center;gap:7px;background:#1A3D0A;color:#fff;border:none;border-radius:2px;padding:9px 16px;font-size:13px;font-weight:600;cursor:pointer;margin-top:14px;transition:background .15s; }
.pm-btn-add-bank:hover { background:#2d5a3d; }
.pm-keys-grid { display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:18px; }
.pm-key-group label { display:block;font-size:12.5px;color:#5a6b62;font-weight:500;margin-bottom:7px; }
.pm-key-input { width:100%;border:1px solid #e0e6e2;border-radius:8px;padding:10px 14px;font-size:13.5px;color:#2a3d33;background:#f8faf9;outline:none;font-family:inherit;transition:border-color .15s; }
.pm-key-input:focus { border-color:#2d7a4f;background:#fff; }
.pm-footer { display:flex;justify-content:flex-end;gap:10px;margin-top:28px; }
.pm-btn-cancel { padding:10px 24px;border-radius:2px;border:none;background:#D9864A;color:#fff;font-size:13.5px;font-weight:600;cursor:pointer;transition:background .15s;font-family:inherit; }
.pm-btn-cancel:hover { background:#c4733a; }
.pm-btn-save { padding:10px 24px;border-radius:2px;border:none;background:#1A3D0A;color:#fff;font-size:13.5px;font-weight:600;cursor:pointer;transition:background .15s;font-family:inherit; }
.pm-btn-save:hover { background:#2d5a1a; }
.pm-alert { display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:8px;font-size:13.5px;font-weight:500;margin-bottom:20px; }
.pm-alert-success { background:#eef7f0;color:#276c42;border:1px solid #b6dfc4; }
.pm-alert-error   { background:#fdecea;color:#c0392b;border:1px solid #f5c6c2; }
.pm-type-badge { display:inline-block;padding:2px 9px;border-radius:20px;font-size:11px;font-weight:600;background:#f0f4ee;color:#4a7c3f;margin-right:6px; }
.pm-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:1000;align-items:center;justify-content:center; }
.pm-overlay.open { display:flex; }
.pm-modal { background:#fff;border-radius:8px;padding:32px 32px 28px;width:100%;max-width:460px;margin:16px;box-shadow:0 20px 60px rgba(0,0,0,.18);position:relative;animation:pmSlideIn .2s ease; }
@keyframes pmSlideIn { from{opacity:0;transform:translateY(14px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
.pm-modal-close { position:absolute;top:18px;right:20px;width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:none;background:transparent;cursor:pointer;color:#7a857f;font-size:18px;transition:background .15s; }
.pm-modal-close:hover { background:#f0f4f1;color:#1a3a2a; }
.pm-modal h3 { font-size:18px;font-weight:700;color:#1a3a2a;margin:0 0 6px; }
.pm-modal p.pm-modal-sub { font-size:13px;color:#7a857f;margin:0 0 22px;line-height:1.5; }
.pm-form-group { margin-bottom:16px; }
.pm-form-label { display:block;font-size:12px;font-weight:600;color:#5a6b62;letter-spacing:.04em;text-transform:uppercase;margin-bottom:7px; }
.pm-form-input,.pm-form-select { width:100%;border:1.5px solid #e0e6e2;border-radius:8px;padding:10px 14px;font-size:13.5px;color:#2a3d33;background:#fff;outline:none;font-family:inherit;transition:border-color .15s;appearance:none; }
.pm-form-input:focus,.pm-form-select:focus { border-color:#2d7a4f; }
.pm-form-input::placeholder { color:#b0bdb6; }
.pm-select-wrap { position:relative; }
.pm-select-wrap::after { content:'';position:absolute;right:14px;top:50%;transform:translateY(-50%);width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;border-top:6px solid #6b7c72;pointer-events:none; }
.pm-input-icon-wrap { position:relative; }
.pm-input-icon-wrap .pm-form-input { padding-right:40px; }
.pm-input-icon { position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#9aaa96;font-size:15px; }
.pm-toggle-row { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:4px 0; }
.pm-toggle-row-label .pm-toggle-row-title { font-size:14px;font-weight:600;color:#1a3a2a; }
.pm-toggle-row-label .pm-toggle-row-desc { font-size:12.5px;color:#8a9690;margin-top:1px; }
.pm-modal-footer { display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:18px;border-top:1px solid #f0f4f1; }
</style>

@if(session('success'))
<div class="pm-alert pm-alert-success">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="pm-alert pm-alert-error">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('admin.settings.payment-methods.store') }}" enctype="multipart/form-data">
@csrf

<div class="pm-wrap">

    <a href="{{ route('admin.settings', ['section' => 'general']) }}" class="pm-back-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M5 12l7-7M5 12l7 7"/></svg>
        Back to General Settings
    </a>

    <div class="pm-page-header">
        <h2 class="pm-page-title">Payment Methods</h2>
        <button type="button" class="pm-btn-add-top" onclick="pmOpenModal('pm-modal-new-method')">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Add New Payment Methods
        </button>
    </div>
    <p class="pm-page-subtitle">Manage cash, manual bank transfers, QRIS, and payment gateways.</p>

    {{-- ══ CARD 1: Cash ══ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <h3 class="pm-card-title">Pay at Property (Cash)</h3>
            <label class="pm-toggle">
                <input type="checkbox" name="cash_enabled" value="1"
                    {{ old('cash_enabled', $settings->cash_enabled) ? 'checked' : '' }}>
                <span class="pm-toggle-slider"></span>
            </label>
        </div>
        <label class="pm-label" for="cash-instruction">Guest Instruction (Display at checkout)</label>
        <textarea class="pm-textarea" id="cash-instruction" name="cash_instruction">{{ old('cash_instruction', $settings->cash_instruction) }}</textarea>
    </div>

    {{-- ══ CARD 2: Bank Transfers ══ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <h3 class="pm-card-title">Manual Bank Transfers</h3>
        </div>
        <hr class="pm-divider" style="margin-top:14px;">
        <div id="pm-bank-list">
            @forelse ($banks as $bank)
            <div class="pm-bank-row" data-id="{{ $bank->id }}">
                <div class="pm-bank-info">
                    <p class="pm-bank-name">
                        {{ $bank->bank_name }}
                        @if($bank->is_default)
                            <span style="font-size:11px;background:#eef7f2;color:#2d7a4f;padding:1px 7px;border-radius:20px;font-weight:600;">Default</span>
                        @endif
                    </p>
                    <span class="pm-bank-meta">A/N {{ $bank->account_holder }} &bull; Acc: {{ $bank->account_number }}</span>
                </div>
                <div class="pm-bank-actions">
                    <button type="button" class="pm-icon-btn"
                        onclick="pmEditBank({{ $bank->id }}, {{ $bank->toJson() }})" title="Edit">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button type="button" class="pm-icon-btn danger"
                        onclick="pmDeleteBank({{ $bank->id }})" title="Delete">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    </button>
                    <label class="pm-toggle">
                        <input type="checkbox" {{ $bank->is_active ? 'checked' : '' }}
                            onchange="pmToggleBank({{ $bank->id }})">
                        <span class="pm-toggle-slider"></span>
                    </label>
                </div>
            </div>
            @empty
            <p id="pm-bank-empty" style="color:#9aaa96;font-size:13px;padding:8px 0;">No bank accounts added yet.</p>
            @endforelse
        </div>
        <button type="button" class="pm-btn-add-bank" onclick="pmOpenModal('pm-modal-add-bank')">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Add New Bank Account
        </button>
    </div>

    {{-- ══ CARD 3: QRIS ══ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <div>
                <h3 class="pm-card-title">QRIS Integration</h3>
                <p class="pm-card-subtitle">Accept payments via GoPay, OVO, Dana.</p>
            </div>
            <label class="pm-toggle">
                <input type="checkbox" name="qris_enabled" value="1"
                    {{ old('qris_enabled', $settings->qris_enabled) ? 'checked' : '' }}>
                <span class="pm-toggle-slider"></span>
            </label>
        </div>
        <div style="margin-top:16px;">
            <label class="pm-label">QRIS Merchant ID</label>
            <input type="text" name="qris_merchant_id" class="pm-key-input"
                value="{{ old('qris_merchant_id', $settings->qris_merchant_id) }}"
                placeholder="Enter Merchant ID">
        </div>
        <div style="margin-top:16px;">
            <label class="pm-label">
                Upload QRIS QR Code
                <span style="font-weight:400;color:#9aaa96;font-size:11.5px;margin-left:6px;">PNG / JPG · maks. 2 MB</span>
            </label>
            <input type="file" name="qris_image" accept="image/png,image/jpeg,image/jpg" style="font-size:13px;">
            @if(!empty($settings->qris_image_path))
            <div style="margin-top:10px;display:flex;align-items:flex-start;gap:12px;">
                <img src="{{ Storage::url($settings->qris_image_path) }}" alt="QRIS QR Code"
                     style="max-width:140px;border-radius:8px;border:1px solid #e5e9e6;">
                <span style="font-size:12px;color:#8a9690;margin-top:4px;">Current QR image.<br>Upload baru untuk mengganti.</span>
            </div>
            @endif
        </div>
    </div>

    {{-- ══ CARD 4: Midtrans ══ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <h3 class="pm-card-title">Midtrans / Payment Gateway</h3>
            <label class="pm-toggle">
                <input type="checkbox" name="midtrans_enabled" value="1"
                    {{ old('midtrans_enabled', $settings->midtrans_enabled) ? 'checked' : '' }}>
                <span class="pm-toggle-slider"></span>
            </label>
        </div>
        <div class="pm-keys-grid">
            <div class="pm-key-group">
                <label for="midtrans-client-key">Client Key</label>
                <input class="pm-key-input" id="midtrans-client-key" name="midtrans_client_key" type="text"
                    value="{{ old('midtrans_client_key', $settings->midtrans_client_key) }}"
                    placeholder="Mid-client-xxxx...">
            </div>
            <div class="pm-key-group">
                <label for="midtrans-server-key">Server Key</label>
                <input class="pm-key-input" id="midtrans-server-key" name="midtrans_server_key" type="password"
                    value="{{ old('midtrans_server_key', $settings->midtrans_server_key) }}"
                    placeholder="Mid-server-xxxx...">
            </div>
        </div>
        <div style="margin-top:18px;">
            <div class="pm-toggle-row">
                <div class="pm-toggle-row-label">
                    <div class="pm-toggle-row-title">Production Mode</div>
                    <div class="pm-toggle-row-desc">Disable for sandbox / testing.</div>
                </div>
                <label class="pm-toggle">
                    <input type="checkbox" name="midtrans_production" value="1"
                        {{ old('midtrans_production', $settings->midtrans_production) ? 'checked' : '' }}>
                    <span class="pm-toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>

    {{-- ══ CARD 5: Custom Payment Methods ══ --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <div>
                <h3 class="pm-card-title">Other Payment Methods</h3>
                <p class="pm-card-subtitle">Credit card, e-wallet, virtual account, dan metode lainnya.</p>
            </div>
        </div>
        <hr class="pm-divider" style="margin-top:14px;">
        <div id="pm-method-list">
            @forelse ($methods as $method)
            <div class="pm-bank-row" data-id="{{ $method->id }}">
                <div class="pm-bank-info">
                    <p class="pm-bank-name">
                        <span class="pm-type-badge">{{ $method->type }}</span>
                        {{ $method->provider_name }}
                        @if($method->is_default)
                            <span style="font-size:11px;background:#eef7f2;color:#2d7a4f;padding:1px 7px;border-radius:20px;font-weight:600;margin-left:4px;">Default</span>
                        @endif
                    </p>
                    <span class="pm-bank-meta">
                        @if($method->account_number) Acc: {{ $method->account_number }} @endif
                        @if($method->account_number && $method->email_username) &bull; @endif
                        @if($method->email_username) {{ $method->email_username }} @endif
                    </span>
                </div>
                <div class="pm-bank-actions">
                    <button type="button" class="pm-icon-btn"
                        onclick="pmEditMethod({{ $method->id }}, {{ $method->toJson() }})" title="Edit">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button type="button" class="pm-icon-btn danger"
                        onclick="pmDeleteMethod({{ $method->id }})" title="Delete">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    </button>
                    <label class="pm-toggle">
                        <input type="checkbox" {{ $method->is_active ? 'checked' : '' }}
                            onchange="pmToggleMethod({{ $method->id }})">
                        <span class="pm-toggle-slider"></span>
                    </label>
                </div>
            </div>
            @empty
            <p id="pm-method-empty" style="color:#9aaa96;font-size:13px;padding:8px 0;">No custom payment methods added yet.</p>
            @endforelse
        </div>
    </div>

    <div class="pm-footer">
        <button type="button" class="pm-btn-cancel"
            onclick="window.location.href='{{ route('admin.settings', ['section' => 'general']) }}'">Cancel</button>
        <button type="submit" class="pm-btn-save">Save Changes</button>
    </div>

</div>
</form>


{{-- ══ MODAL A: Add / Edit Bank Account ══ --}}
<div class="pm-overlay" id="pm-modal-add-bank">
    <div class="pm-modal">
        <button type="button" class="pm-modal-close" onclick="pmCloseModal('pm-modal-add-bank')">&#x2715;</button>
        <h3 id="pm-bank-modal-title">Add New Bank Account</h3>
        <p class="pm-modal-sub">Connect a new bank account to your management profile.</p>
        <input type="hidden" id="pm-bank-edit-id" value="">

        <div class="pm-form-group">
            <label class="pm-form-label">Select Bank</label>
            <div class="pm-select-wrap">
                <select class="pm-form-select" id="pm-bank-select">
                    <option value="">Choose your banking provider</option>
                    <option>Bank Central Asia (BCA)</option>
                    <option>Bank Mandiri</option>
                    <option>Bank Rakyat Indonesia (BRI)</option>
                    <option>Bank Negara Indonesia (BNI)</option>
                    <option>CIMB Niaga</option>
                    <option>Danamon</option>
                    <option>Permata Bank</option>
                    <option>Lainnya</option>
                </select>
            </div>
        </div>
        <div class="pm-form-group">
            <label class="pm-form-label">Account Holder Name</label>
            <input class="pm-form-input" id="pm-bank-holder" type="text" placeholder="e.g., AlaSare Eco-Hostel">
        </div>
        <div class="pm-form-group">
            <label class="pm-form-label">Account Number</label>
            <input class="pm-form-input" id="pm-bank-number" type="text" placeholder="e.g., 1234567890" inputmode="numeric">
        </div>
        <div class="pm-toggle-row">
            <div class="pm-toggle-row-label">
                <div class="pm-toggle-row-title">Set as Default</div>
                <div class="pm-toggle-row-desc">Primary account for all incoming transactions.</div>
            </div>
            <label class="pm-toggle"><input type="checkbox" id="pm-bank-default"><span class="pm-toggle-slider"></span></label>
        </div>
        <div id="pm-bank-error" style="display:none;color:#c0392b;font-size:13px;margin-top:10px;padding:8px 12px;background:#fdecea;border-radius:6px;"></div>
        <div class="pm-modal-footer">
            <button type="button" class="pm-btn-cancel" onclick="pmCloseModal('pm-modal-add-bank')">Cancel</button>
            <button type="button" class="pm-btn-save" id="pm-bank-submit-btn" onclick="pmSubmitBank()">Add Account</button>
        </div>
    </div>
</div>


{{-- ══ MODAL B: Add / Edit Custom Payment Method ══ --}}
<div class="pm-overlay" id="pm-modal-new-method">
    <div class="pm-modal">
        <button type="button" class="pm-modal-close" onclick="pmCloseModal('pm-modal-new-method')">&#x2715;</button>
        <h3 id="pm-method-modal-title">Add New Payment Method</h3>
        <p class="pm-modal-sub">Choose your preferred payment method and provide the necessary details for secure transactions.</p>
        <input type="hidden" id="pm-method-edit-id" value="">

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
            <input class="pm-form-input" id="pm-method-provider" type="text" placeholder="e.g., Visa, GoPay, PayPal">
        </div>
        <div class="pm-form-group">
            <label class="pm-form-label">Account / Card Number <span style="font-weight:400;color:#9aaa96;">(optional)</span></label>
            <input class="pm-form-input" id="pm-method-number" type="text" placeholder="e.g., 1234 5678 9012 3456">
        </div>
        <div class="pm-form-group">
            <label class="pm-form-label">Email ID / Username <span style="font-weight:400;color:#9aaa96;">(optional)</span></label>
            <div class="pm-input-icon-wrap">
                <input class="pm-form-input" id="pm-method-email" type="email" placeholder="email@example.com">
                <span class="pm-input-icon">@</span>
            </div>
        </div>
        <div class="pm-toggle-row">
            <div class="pm-toggle-row-label">
                <div class="pm-toggle-row-title">Set as Default Method</div>
                <div class="pm-toggle-row-desc">Use this for all future transactions.</div>
            </div>
            <label class="pm-toggle"><input type="checkbox" id="pm-method-default"><span class="pm-toggle-slider"></span></label>
        </div>
        <div id="pm-method-error" style="display:none;color:#c0392b;font-size:13px;margin-top:10px;padding:8px 12px;background:#fdecea;border-radius:6px;"></div>
        <div class="pm-modal-footer">
            <button type="button" class="pm-btn-cancel" onclick="pmCloseModal('pm-modal-new-method')">Cancel</button>
            <button type="button" class="pm-btn-save" id="pm-method-submit-btn" onclick="pmSubmitMethod()">Add Payment Method</button>
        </div>
    </div>
</div>


<script>
(function () {
    var csrf        = '{{ csrf_token() }}';
    var bankStore   = '{{ route("admin.bank-accounts.store") }}';
    var bankUpdate  = '{{ route("admin.bank-accounts.update", ["bankAccount" => ":id"]) }}';
    var bankDestroy = '{{ route("admin.bank-accounts.destroy", ["bankAccount" => ":id"]) }}';
    var bankToggle  = '{{ route("admin.bank-accounts.toggle", ["bankAccount" => ":id"]) }}';
    var methodStore  = '{{ route("admin.payment-methods.store") }}';
    var methodUpdate  = '{{ route("admin.payment-methods.update", ["paymentMethod" => ":id"]) }}';
    var methodDestroy = '{{ route("admin.payment-methods.destroy", ["paymentMethod" => ":id"]) }}';
    var methodToggle  = '{{ route("admin.payment-methods.toggle", ["paymentMethod" => ":id"]) }}';

    function pmUrl(template, id) { return template.replace(':id', id); }

    /* ── Modal helpers ─────────────────────────────────────────────── */
    window.pmOpenModal  = function (id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    };
    window.pmCloseModal = function (id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
        if (id === 'pm-modal-add-bank')   pmResetBank();
        if (id === 'pm-modal-new-method') pmResetMethod();
    };
    document.querySelectorAll('.pm-overlay').forEach(function (el) {
        el.addEventListener('click', function (e) { if (e.target === el) pmCloseModal(el.id); });
    });

    /* ════════════════ BANK ACCOUNTS ════════════════ */
    function pmResetBank() {
        document.getElementById('pm-bank-modal-title').textContent = 'Add New Bank Account';
        document.getElementById('pm-bank-submit-btn').textContent  = 'Add Account';
        ['pm-bank-edit-id','pm-bank-select','pm-bank-holder','pm-bank-number']
            .forEach(function (id) { document.getElementById(id).value = ''; });
        document.getElementById('pm-bank-default').checked = false;
        document.getElementById('pm-bank-error').style.display = 'none';
    }

    window.pmEditBank = function (id, data) {
        document.getElementById('pm-bank-modal-title').textContent = 'Edit Bank Account';
        document.getElementById('pm-bank-submit-btn').textContent  = 'Update Account';
        document.getElementById('pm-bank-edit-id').value  = id;
        document.getElementById('pm-bank-select').value   = data.bank_name;
        document.getElementById('pm-bank-holder').value   = data.account_holder;
        document.getElementById('pm-bank-number').value   = data.account_number;
        document.getElementById('pm-bank-default').checked = !!data.is_default;
        pmOpenModal('pm-modal-add-bank');
    };

    window.pmDeleteBank = function (id) {
        if (!confirm('Remove this bank account?')) return;
        fetch(pmUrl(bankDestroy, id), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(function (res) {
            if (res.success) pmRemoveRow('#pm-bank-list', id, 'pm-bank-empty', 'No bank accounts added yet.');
        });
    };

    window.pmToggleBank = function (id) {
        fetch(pmUrl(bankToggle, id), {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        });
    };

    window.pmSubmitBank = function () {
        var bankName = document.getElementById('pm-bank-select').value.trim();
        var holder   = document.getElementById('pm-bank-holder').value.trim();
        var number   = document.getElementById('pm-bank-number').value.trim();
        var isDef    = document.getElementById('pm-bank-default').checked;
        var editId   = document.getElementById('pm-bank-edit-id').value;
        var errEl    = document.getElementById('pm-bank-error');

        if (!bankName || !holder || !number) {
            errEl.textContent = 'Please fill in all required fields.';
            errEl.style.display = 'block';
            return;
        }
        errEl.style.display = 'none';

        pmAjaxSave(
            editId ? pmUrl(bankUpdate, editId) : bankStore,
            editId ? 'PUT' : 'POST',
            { bank_name: bankName, account_holder: holder, account_number: number, is_default: isDef, is_active: true },
            errEl,
            function () { window.location.reload(); }
        );
    };

    /* ════════════════ CUSTOM PAYMENT METHODS ════════════════ */
    function pmResetMethod() {
        document.getElementById('pm-method-modal-title').textContent = 'Add New Payment Method';
        document.getElementById('pm-method-submit-btn').textContent  = 'Add Payment Method';
        ['pm-method-edit-id','pm-method-provider','pm-method-number','pm-method-email']
            .forEach(function (id) { document.getElementById(id).value = ''; });
        document.getElementById('pm-method-type').value = 'Credit Card';
        document.getElementById('pm-method-default').checked = false;
        document.getElementById('pm-method-error').style.display = 'none';
    }

    window.pmEditMethod = function (id, data) {
        document.getElementById('pm-method-modal-title').textContent = 'Edit Payment Method';
        document.getElementById('pm-method-submit-btn').textContent  = 'Update Payment Method';
        document.getElementById('pm-method-edit-id').value   = id;
        document.getElementById('pm-method-type').value      = data.type;
        document.getElementById('pm-method-provider').value  = data.provider_name;
        document.getElementById('pm-method-number').value    = data.account_number || '';
        document.getElementById('pm-method-email').value     = data.email_username  || '';
        document.getElementById('pm-method-default').checked = !!data.is_default;
        pmOpenModal('pm-modal-new-method');
    };

    window.pmDeleteMethod = function (id) {
        if (!confirm('Remove this payment method?')) return;
        fetch(pmUrl(methodDestroy, id), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(function (res) {
            if (res.success) pmRemoveRow('#pm-method-list', id, 'pm-method-empty', 'No custom payment methods added yet.');
        });
    };

    window.pmToggleMethod = function (id) {
        fetch(pmUrl(methodToggle, id), {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        });
    };

    window.pmSubmitMethod = function () {
        var provider = document.getElementById('pm-method-provider').value.trim();
        var editId   = document.getElementById('pm-method-edit-id').value;
        var errEl    = document.getElementById('pm-method-error');

        if (!provider) {
            errEl.textContent = 'Provider name is required.';
            errEl.style.display = 'block';
            return;
        }
        errEl.style.display = 'none';

        pmAjaxSave(
            editId ? pmUrl(methodUpdate, editId) : methodStore,
            editId ? 'PUT' : 'POST',
            {
                type:           document.getElementById('pm-method-type').value,
                provider_name:  provider,
                account_number: document.getElementById('pm-method-number').value.trim() || null,
                email_username: document.getElementById('pm-method-email').value.trim()  || null,
                is_default:     document.getElementById('pm-method-default').checked,
                is_active:      true,
            },
            errEl,
            function () { window.location.reload(); }
        );
    };

    /* ════════════════ SHARED HELPERS ════════════════ */
    function pmAjaxSave(url, method, body, errEl, onSuccess) {
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN':  csrf,
                'Accept':        'application/json',
                'Content-Type':  'application/json',
            },
            body: JSON.stringify(body),
        })
        .then(r => r.json())
        .then(function (res) {
            if (res.success) {
                onSuccess();
            } else {
                var msg = res.message
                    || (res.errors ? Object.values(res.errors).flat().join(' ') : 'Failed to save.');
                errEl.textContent   = msg;
                errEl.style.display = 'block';
            }
        })
        .catch(function () {
            errEl.textContent   = 'Network error. Please try again.';
            errEl.style.display = 'block';
        });
    }

    function pmRemoveRow(listSelector, id, emptyId, emptyMsg) {
        var row = document.querySelector(listSelector + ' .pm-bank-row[data-id="' + id + '"]');
        if (row) row.remove();
        if (!document.querySelector(listSelector + ' .pm-bank-row')) {
            document.querySelector(listSelector).innerHTML =
                '<p id="' + emptyId + '" style="color:#9aaa96;font-size:13px;padding:8px 0;">' + emptyMsg + '</p>';
        }
    }
})();
</script>