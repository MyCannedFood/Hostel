{{-- resources/views/admin/settings/partials/staff-access.blade.php --}}

@php $activeTab = request('tab', 'staff-list'); @endphp

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

{{-- Tabs --}}
<div class="tabs">
    <a href="?section=staff&tab=staff-list"
       class="tab-btn {{ $activeTab === 'staff-list' ? 'active' : '' }}">
        Staff List
    </a>
    <a href="?section=staff&tab=access-info"
       class="tab-btn {{ $activeTab === 'access-info' ? 'active' : '' }}">
        Access Info
    </a>
</div>


{{-- ── Tab: Staff List ── --}}
@if($activeTab === 'staff-list')
<div>
    <div class="table-toolbar">
        <div class="search-wrap">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" class="search-input" placeholder="Search staff name...">
        </div>
        <button class="filter-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="4" y1="6" x2="16" y2="6"/><line x1="4" y1="12" x2="12" y2="12"/><line x1="4" y1="18" x2="8" y2="18"/>
            </svg>
            Filter
        </button>
    </div>

    <div class="data-table-wrap">
        <table class="data-table">
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
                @forelse ($staffList ?? [] as $staff)
                <tr>
                    <td>
                        <div class="staff-name-cell">
                            <div class="avatar avatar-{{ $staff->avatar_color ?? 'gray' }}">
                                {{ strtoupper(substr($staff->first_name, 0, 1) . substr($staff->last_name, 0, 1)) }}
                            </div>
                            <span class="staff-fullname">{{ $staff->first_name }} {{ $staff->last_name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $staff->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </td>
                    <td>{{ $staff->access_type }}</td>
                    <td style="color:#5a6a58;">{{ $staff->email }}</td>
                    <td>
                        <a href="#" class="action-btn edit-only" title="Edit">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                {{-- Demo rows --}}
                <tr>
                    <td>
                        <div class="staff-name-cell">
                            <div class="avatar avatar-gray">SJ</div>
                            <span class="staff-fullname">Sarah Jenkins</span>
                        </div>
                    </td>
                    <td><span class="badge badge-active">Active</span></td>
                    <td>Front Office</td>
                    <td style="color:#5a6a58;">sarah.alasare@email.com</td>
                    <td>
                        <a href="#" class="action-btn edit-only" title="Edit">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="staff-name-cell">
                            <div class="avatar avatar-orange">MT</div>
                            <span class="staff-fullname">Marcus Thorne</span>
                        </div>
                    </td>
                    <td><span class="badge badge-active">Active</span></td>
                    <td>Manager</td>
                    <td style="color:#5a6a58;">morcus.alasare@email.com</td>
                    <td>
                        <a href="#" class="action-btn edit-only" title="Edit">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="staff-name-cell">
                            <div class="avatar avatar-teal">ER</div>
                            <span class="staff-fullname">Elena Rossi</span>
                        </div>
                    </td>
                    <td><span class="badge badge-inactive">Inactive</span></td>
                    <td>Housekeeping</td>
                    <td style="color:#5a6a58;">elena.alasare@email.com</td>
                    <td>
                        <a href="#" class="action-btn edit-only" title="Edit">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="staff-name-cell">
                            <div class="avatar avatar-green">ST</div>
                            <span class="staff-fullname">Satoshi Tanaka</span>
                        </div>
                    </td>
                    <td><span class="badge badge-active">Active</span></td>
                    <td>Finance</td>
                    <td style="color:#5a6a58;">sato.finance@email.com</td>
                    <td>
                        <a href="#" class="action-btn edit-only" title="Edit">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif


{{-- ── Tab: Access Info ── --}}
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
                @forelse ($roles ?? [] as $role)
                <tr>
                    <td>
                        <span class="badge-role badge-{{ strtolower($role->name) }}">
                            {{ strtoupper($role->name) }}
                        </span>
                    </td>
                    <td>
                        <ol class="features-list">
                            @foreach($role->features as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ol>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="#" class="action-btn" title="Edit">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <button class="action-btn delete" title="Delete">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                {{-- Demo rows --}}
                <tr>
                    <td><span class="badge-role badge-owner">OWNER</span></td>
                    <td>
                        <ol class="features-list">
                            <li>Access full Dashboard &amp; Analytics</li>
                            <li>Manage Users and Access Rights management</li>
                            <li>Full access to Financial Reports &amp; Budgeting</li>
                            <li>System Settings &amp; Gallery Integration</li>
                        </ol>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="#" class="action-btn" title="Edit">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <button class="action-btn delete" title="Delete">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="badge-role badge-finance">FINANCE</span></td>
                    <td>
                        <ol class="features-list">
                            <li>View Financial Summary on Dashboard</li>
                            <li>Manage Booking Transactions &amp; Payments</li>
                            <li>Input &amp; Generate Monthly Financial Reports</li>
                            <li>Access Operational Budgeting Management</li>
                        </ol>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="#" class="action-btn" title="Edit">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <button class="action-btn delete" title="Delete">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="badge-role badge-receptionist">RECEPTIONIST</span></td>
                    <td>
                        <ol class="features-list">
                            <li>Manage Guest Check-in &amp; Check-out</li>
                            <li>Update Room Status &amp; Bed Management</li>
                            <li>Create Manual Bookings for Walk-ins</li>
                            <li>View Room Availability Calendar</li>
                        </ol>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="#" class="action-btn" title="Edit">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <button class="action-btn delete" title="Delete">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="badge-role badge-staff">STAFF</span></td>
                    <td>
                        <ol class="features-list">
                            <li>View Cleaning Schedule &amp; Room Maintenance</li>
                            <li>Update Cleaning Task Status</li>
                            <li>Read Internal Articles &amp; Standard Operations</li>
                        </ol>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="#" class="action-btn" title="Edit">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <button class="action-btn delete" title="Delete">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
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