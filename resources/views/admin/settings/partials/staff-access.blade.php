{{-- resources/views/admin/settings/partials/staff-access.blade.php --}}

@php $activeTab = request('tab', 'staff-list'); @endphp

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div style="margin-bottom:16px; padding:12px 16px; background:#e6f4e6; border:1px solid #a3d4a3; border-radius:10px; color:#2e7d32; font-size:13px; font-weight:600;">
        ✓ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="margin-bottom:16px; padding:12px 16px; background:#fdecea; border:1px solid #f5a5a5; border-radius:10px; color:#c62828; font-size:13px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin:6px 0 0 16px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

{{-- ── Header ── --}}
<div class="section-header">
    <h2 class="section-title">Staff &amp; Access Rights</h2>
    @if($activeTab === 'staff-list')
        <button class="btn btn-dark" onclick="openAddAccountModal()">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
            + Add Account
        </button>
    @else
        <button class="btn btn-orange" onclick="openAddRoleModal()">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
            Add Role
        </button>
    @endif
</div>

{{-- ── Tabs ── --}}
<div class="tabs">
    <a href="?section=staff&tab=staff-list"
       class="tab-btn {{ $activeTab === 'staff-list' ? 'active' : '' }}">Staff List</a>
    <a href="?section=staff&tab=access-info"
       class="tab-btn {{ $activeTab === 'access-info' ? 'active' : '' }}">Access Info</a>
</div>


{{-- ════════════════════════════════════════
     TAB: STAFF LIST
════════════════════════════════════════ --}}
@if($activeTab === 'staff-list')
<div>
    <div class="table-toolbar">
        <div class="search-wrap">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" class="search-input" id="staffSearch" placeholder="Search staff name..."
                   oninput="filterStaffTable(this.value)">
        </div>
        <button class="filter-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="4" y1="6" x2="16" y2="6"/><line x1="4" y1="12" x2="12" y2="12"/><line x1="4" y1="18" x2="8" y2="18"/>
            </svg>
            Filter
        </button>
    </div>

    <div class="data-table-wrap">
        <table class="data-table" id="staffTable">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Status</th>
                    <th>Access Type</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffList ?? [] as $staff)
                <tr>
                    <td>
                        <div class="staff-name-cell">
                            <div class="avatar avatar-{{ $staff->avatar_color ?? 'gray' }}">
                                {{ strtoupper(substr($staff->name, 0, 1)) }}{{ strtoupper(substr(strrchr($staff->name, ' '), 1, 1)) }}
                            </div>
                            <span class="staff-fullname">{{ $staff->name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $staff->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </td>
                    <td>{{ $staff->role ?? '-' }}</td>
                    <td style="color:#5a6a58;">{{ $staff->email }}</td>
                    <td>
                        <button class="action-btn edit-only" title="Edit"
                            onclick="openEditStaffModal('{{ $staff->id }}','{{ addslashes($staff->name) }}','{{ $staff->email }}','{{ $staff->role }}')">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                {{-- Demo rows --}}
                @foreach([
                    ['SJ','Sarah Jenkins','sarah.alasare@email.com','Front Office','active','gray'],
                    ['MT','Marcus Thorne','morcus.alasare@email.com','Manager','active','orange'],
                    ['ER','Elena Rossi','elena.alasare@email.com','Housekeeping','inactive','teal'],
                    ['ST','Satoshi Tanaka','sato.finance@email.com','Finance','active','green'],
                ] as $s)
                <tr>
                    <td>
                        <div class="staff-name-cell">
                            <div class="avatar avatar-{{ $s[5] }}">{{ $s[0] }}</div>
                            <span class="staff-fullname">{{ $s[1] }}</span>
                        </div>
                    </td>
                    <td><span class="badge {{ $s[4]==='active'?'badge-active':'badge-inactive' }}">{{ ucfirst($s[4]) }}</span></td>
                    <td>{{ $s[3] }}</td>
                    <td style="color:#5a6a58;">{{ $s[2] }}</td>
                    <td>
                        <button class="action-btn edit-only" title="Edit">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif


{{-- ════════════════════════════════════════
     TAB: ACCESS INFO
════════════════════════════════════════ --}}
@if($activeTab === 'access-info')
<div>
    <div class="access-info-intro">
        <h3 class="access-info-title">Access Info Overview</h3>
        <p class="access-info-sub">Feature and access information based on user roles</p>
    </div>

    <div class="data-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:160px;">Access Type</th>
                    <th>Features</th>
                    <th style="width:100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles ?? [] as $role)
                <tr>
                    <td><span class="badge-role badge-{{ strtolower($role->name) }}">{{ strtoupper($role->name) }}</span></td>
                    <td>
                        <ol class="features-list">
                            @foreach($role->permissions as $perm)<li>{{ $perm }}</li>@endforeach
                        </ol>
                    </td>
                    <td>
                        <div class="action-icons">
                            <button class="action-btn" title="Edit"
                                onclick="openEditRoleModal('{{ $role->id }}','{{ addslashes($role->name) }}','{{ addslashes($role->description ?? '') }}',{{ json_encode($role->permissions) }})">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" onsubmit="return confirm('Hapus role \'' . addslashes($role->name) . '\''?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                {{-- Demo rows --}}
                @foreach([
                    ['owner','OWNER',['Access full Dashboard & Analytics','Manage Users and Access Rights management','Full access to Financial Reports & Budgeting','System Settings & Gallery Integration']],
                    ['finance','FINANCE',['View Financial Summary on Dashboard','Manage Booking Transactions & Payments','Input & Generate Monthly Financial Reports','Access Operational Budgeting Management']],
                    ['receptionist','RECEPTIONIST',['Manage Guest Check-in & Check-out','Update Room Status & Bed Management','Create Manual Bookings for Walk-ins','View Room Availability Calendar']],
                    ['staff','STAFF',['View Cleaning Schedule & Room Maintenance','Update Cleaning Task Status','Read Internal Articles & Standard Operations']],
                ] as $r)
                <tr>
                    <td><span class="badge-role badge-{{ $r[0] }}">{{ $r[1] }}</span></td>
                    <td>
                        <ol class="features-list">
                            @foreach($r[2] as $f)<li>{{ $f }}</li>@endforeach
                        </ol>
                    </td>
                    <td>
                        <div class="action-icons">
                            <button class="action-btn" title="Edit">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="action-btn delete" title="Delete">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="attention-box">
        <div class="attention-icon">ℹ</div>
        <div>
            <p class="attention-title">Attention</p>
            <p class="attention-text">
                Access rights settings will affect the menus accessible by each user role.
                Changes saved will be immediately applied when users login or refresh the page.
                Ensure each role has the minimum required access to perform their duties.
            </p>
        </div>
    </div>
</div>
@endif


{{-- ════════════════════════════════════════
     MODAL: Add New Account
════════════════════════════════════════ --}}
<div class="modal-overlay" id="addAccountModal">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <div>
                <h3 class="modal-title">Add New Account</h3>
                <p style="margin:4px 0 0; font-size:13px; color:#7a857f;">Grant system access to a new team member.</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('addAccountModal')">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.staff.store') }}" id="addAccountForm">
            <input type="hidden" name="_form_source" value="add_account">

            @if($errors->any() && old('_form_source') === 'add_account')
            <div style="margin-bottom:14px; padding:10px 14px; background:#fdecea; border:1px solid #f5a5a5; border-radius:8px; color:#c62828; font-size:12px;">
                @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
            </div>
            @endif
            @csrf

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-input" name="name"
                       placeholder="e.g. Wayan Sudarta" autocomplete="off" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" name="email"
                       placeholder="wayan.s@alasare.com" autocomplete="off" value="{{ old('email') }}">
            </div>

            <div class="form-row" style="align-items:flex-end;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Select Role</label>
                    <select class="form-select" name="role">
                        <option value="admin">Admin</option>
                        <option value="finance">Finance</option>
                        <option value="receptionist">Receptionist</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Password</label>
                    <div style="position:relative;">
                        <input type="password" class="form-input" name="password"
                               id="accountPassword" placeholder="••••••••" autocomplete="new-password"
                               style="padding-right:40px;">
                        <button type="button"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9aaa96;padding:0;"
                                onclick="togglePassword('accountPassword',this)">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('addAccountModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Add Account</button>
            </div>
        </form>
    </div>
</div>


{{-- ════════════════════════════════════════
     MODAL: Add New Role
════════════════════════════════════════ --}}
<div class="modal-overlay" id="addRoleModal">
    <div class="modal-box" style="max-width:520px;">
        <div class="modal-header">
            <div>
                <h3 class="modal-title">Add New Role</h3>
                <p style="margin:4px 0 0; font-size:13px; color:#7a857f;">Define permissions and access levels for new management positions.</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('addRoleModal')">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.roles.store') }}" id="addRoleForm">
            <input type="hidden" name="_form_source" value="add_role">

            @if($errors->any() && old('_form_source') === 'add_role')
            <div style="margin-bottom:14px; padding:10px 14px; background:#fdecea; border:1px solid #f5a5a5; border-radius:8px; color:#c62828; font-size:12px;">
                @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
            </div>
            @endif
            @csrf

            <div class="form-group">
                <label class="form-label">Role Name</label>
                <input type="text" class="form-input" name="role_name"
                       placeholder="e.g. Finance Manager">
            </div>

            <div class="form-group">
                <label class="form-label">Role Description</label>
                <textarea class="form-textarea" name="role_description" rows="2"
                          placeholder="Describe the responsibilities of this role..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" style="margin-bottom:12px;">Access Permissions</label>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px 24px;">
                    @php
                    $permissions = [
                        'dashboard'         => 'Dashboard',
                        'room_bed'          => 'Room & Bed',
                        'reservation'       => 'Reservation',
                        'article'           => 'Article',
                        'budgeting_report'  => 'Budgeting & Report',
                        'settings'          => 'Settings',
                        'finance_accounting'=> 'Finance Accounting',
                        'experience'        => 'Experience',
                    ];
                    @endphp
                    @foreach($permissions as $key => $label)
                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#3a4a38; cursor:pointer;">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}"
                               style="width:16px; height:16px; accent-color:#2d4a1e; cursor:pointer; flex-shrink:0;">
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('addRoleModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Add Role</button>
            </div>
        </form>
    </div>
</div>


{{-- ════════════════════════════════════════
     MODAL: Edit Staff
════════════════════════════════════════ --}}
<div class="modal-overlay" id="editStaffModal">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <div>
                <h3 class="modal-title">Edit Account</h3>
                <p style="margin:4px 0 0; font-size:13px; color:#7a857f;">Update staff account details.</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('editStaffModal')">✕</button>
        </div>

        <form method="POST" id="editStaffForm">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-input" name="name" id="editStaffName">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" name="email" id="editStaffEmail">
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Role</label>
                    <select class="form-select" name="role_id" id="editStaffRole">
                        @forelse($roleOptions ?? [] as $r)
                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @empty
                            <option value="">No roles yet</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">New Password <span style="font-weight:400;color:#9aaa96;">(optional)</span></label>
                    <div style="position:relative;">
                        <input type="password" class="form-input" name="password"
                               id="editStaffPassword" placeholder="Leave blank to keep current" autocomplete="new-password"
                               style="padding-right:40px;">
                        <button type="button"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9aaa96;padding:0;"
                                onclick="togglePassword('editStaffPassword',this)">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('editStaffModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Changes</button>
            </div>
        </form>
    </div>
</div>


{{-- ════════════════════════════════════════
     MODAL: Edit Role
════════════════════════════════════════ --}}
<div class="modal-overlay" id="editRoleModal">
    <div class="modal-box" style="max-width:520px;">
        <div class="modal-header">
            <div>
                <h3 class="modal-title">Edit Role</h3>
                <p style="margin:4px 0 0; font-size:13px; color:#7a857f;">Update permissions for this role.</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('editRoleModal')">✕</button>
        </div>

        <form method="POST" id="editRoleForm">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Role Name</label>
                <input type="text" class="form-input" name="role_name" id="editRoleName">
            </div>

            <div class="form-group">
                <label class="form-label">Role Description</label>
                <textarea class="form-textarea" name="role_description" rows="2" id="editRoleDescription"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" style="margin-bottom:12px;">Access Permissions</label>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px 24px;">
                    @foreach($permissions ?? [
                        'dashboard'         => 'Dashboard',
                        'room_bed'          => 'Room & Bed',
                        'reservation'       => 'Reservation',
                        'article'           => 'Article',
                        'budgeting_report'  => 'Budgeting & Report',
                        'settings'          => 'Settings',
                        'finance_accounting'=> 'Finance Accounting',
                        'experience'        => 'Experience',
                    ] as $key => $label)
                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#3a4a38; cursor:pointer;">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}"
                               class="edit-role-perm"
                               style="width:16px; height:16px; accent-color:#2d4a1e; cursor:pointer; flex-shrink:0;">
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('editRoleModal')">Cancel</button>
                <button type="submit" class="btn btn-dark">Save Changes</button>
            </div>
        </form>
    </div>
</div>


<script>
/* ── Generic modal helpers ── */
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}

/* Close on backdrop click */
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

/* ── Add Account ── */
function openAddAccountModal() { openModal('addAccountModal'); }

/* ── Add Role ── */
function openAddRoleModal() { openModal('addRoleModal'); }

/* ── Edit Staff ── */
function openEditStaffModal(id, name, email, role) {
    document.getElementById('editStaffName').value  = name;
    document.getElementById('editStaffEmail').value = email;
    const sel = document.getElementById('editStaffRole');
    for (let o of sel.options) o.selected = o.value === role.toLowerCase();
    document.getElementById('editStaffForm').action = '/admin/staff/' + id;
    openModal('editStaffModal');
}

/* ── Edit Role ── */
function openEditRoleModal(id, name, description, perms) {
    document.getElementById('editRoleName').value        = name;
    document.getElementById('editRoleDescription').value = description;
    const boxes = document.querySelectorAll('.edit-role-perm');
    const permArr = Array.isArray(perms) ? perms : [];
    boxes.forEach(cb => { cb.checked = permArr.includes(cb.value); });
    document.getElementById('editRoleForm').action = '/admin/roles/' + id;
    openModal('editRoleModal');
}

/* ── Password show/hide toggle ── */
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.style.color = isText ? '#9aaa96' : '#2d4a1e';
}

/* ── Staff table search (client-side for now) ── */
function filterStaffTable(query) {
    const q = query.toLowerCase();
    document.querySelectorAll('#staffTable tbody tr').forEach(row => {
        const name = row.querySelector('.staff-fullname')?.textContent.toLowerCase() ?? '';
        row.style.display = name.includes(q) ? '' : 'none';
    });
}
</script>