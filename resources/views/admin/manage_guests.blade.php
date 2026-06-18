@php
    $admin = auth('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Guests - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="dashboard-container">
        <x-admin_sidenavbar />
        <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>
    
        <!-- Main content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <button type="button" class="hamburger mobile-only" id="sidebarToggle" aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header-actions">
                    <a href="{{ route('admin.notification.index') }}" class="notification-btn">

                        <span class="material-symbols-outlined">
                            notifications
                        </span>

                        @if(($unreadCount ?? 0) > 0)
                            <span class="notification-badge">
                                {{ $unreadCount }}
                            </span>
                        @endif

                    </a>
                    <a href="{{ route('admin.settings', [
                        'section' => 'general',
                        'sub' => 'profile'
                    ]) }}">
                        <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/admin/profile.png') }}"
                            alt="User profile"
                            width="40"
                            height="40">
                    </a>
                </div>
            </header>
      
            <!-- Content area -->
            <div class="content-area">
                
                <div class="guest-dashboard-header">
                    <h1 class="guest-page-title">Dashboard Guest</h1>
                    <button type="button" class="btn-add-guest" id="btnAddGuest"><span>+</span> Add Guest</button>
                </div>

                <!-- Top Stats -->
                <div class="guest-stats-grid">

                    <!-- Today -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">Today</div>
                        <div class="guest-stat-value">{{ $guestStats['today'] }}</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            @php $b = $guestStats['today_breakdown']; @endphp
                            <div class="guest-breakdown-item" style="font-weight:bold;">
                                <span>Foreigner</span>
                                <span>{{ $b['foreign'] }} / {{ $b['foreign_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>Asia</span>
                                <span>{{ $b['asia'] }} / {{ $b['asia_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>USA/EU/OC</span>
                                <span>{{ $b['us_eu_oc'] }} / {{ $b['us_eu_oc_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>AF</span>
                                <span>{{ $b['af'] }} / {{ $b['af_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item" style="font-weight:bold;">
                                <span>Local</span>
                                <span>{{ $b['local'] }} / {{ $b['local_pct'] }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- This Week -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">This Week</div>
                        <div class="guest-stat-value">{{ $guestStats['week'] }}</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            @php $b = $guestStats['week_breakdown']; @endphp
                            <div class="guest-breakdown-item" style="font-weight:bold;">
                                <span>Foreigner</span>
                                <span>{{ $b['foreign'] }} / {{ $b['foreign_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>Asia</span>
                                <span>{{ $b['asia'] }} / {{ $b['asia_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>USA/EU/OC</span>
                                <span>{{ $b['us_eu_oc'] }} / {{ $b['us_eu_oc_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>AF</span>
                                <span>{{ $b['af'] }} / {{ $b['af_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item" style="font-weight:bold;">
                                <span>Local</span>
                                <span>{{ $b['local'] }} / {{ $b['local_pct'] }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- This Month -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">This Month</div>
                        <div class="guest-stat-value">{{ $guestStats['month'] }}</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            @php $b = $guestStats['month_breakdown']; @endphp
                            <div class="guest-breakdown-item" style="font-weight:bold;">
                                <span>Foreigner</span>
                                <span>{{ $b['foreign'] }} / {{ $b['foreign_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>Asia</span>
                                <span>{{ $b['asia'] }} / {{ $b['asia_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>USA/EU/OC</span>
                                <span>{{ $b['us_eu_oc'] }} / {{ $b['us_eu_oc_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item">
                                <span>AF</span>
                                <span>{{ $b['af'] }} / {{ $b['af_pct'] }}%</span>
                            </div>
                            <div class="guest-breakdown-item" style="font-weight:bold;">
                                <span>Local</span>
                                <span>{{ $b['local'] }} / {{ $b['local_pct'] }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Check In/Out -->
                    <div class="guest-stat-card-split">
                        <div class="split-item">
                            <div class="split-value">{{ $guestStats['checkout_today'] }}</div>
                            <button type="button" class="split-label split-label-btn" data-guest-action="checkout">Check-out</button>
                        </div>
                        <div class="split-item">
                            <div class="split-value">{{ $guestStats['checkin_today'] }}</div>
                            <button type="button" class="split-label split-label-btn" data-guest-action="checkin">Check-in</button>
                        </div>
                    </div>

                </div>

                <!-- Middle Section -->
                <div class="guest-middle-grid">
                    
                    <!-- Guest List -->
                    <div class="guest-list-card">
                        <div class="guest-list-header">
                            <div class="guest-list-title">Guest list</div>
                            <div class="guest-search">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43493e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" placeholder="Search Guest" id="guestSearchInput">
                            </div>
                        </div>
                        <div class="guest-table-container">
                            <table class="guest-table">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Guest Name</th>
                                        <th>Country</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Booking Place</th>
                                        <th>Status</th>
                                        <th>Duration</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="guestListTbody">
                                    @foreach($guests ?? [] as $guest)
                                        @php
                                            $duration = $guest->check_in_date && $guest->check_out_date
                                                ? $guest->check_in_date->diffInDays($guest->check_out_date) . ' nights'
                                                : ($guest->check_in_date ? 'In Progress' : '-');
                                        @endphp
                                        <tr>
                                            <td>{{ $guest->booking_code }}</td>
                                            <td>{{ $guest->first_name }} {{ $guest->last_name }}</td>
                                            <td>{{ $guest->country }}</td>
                                            <td>{{ $guest->age ?? '-' }}</td>
                                            <td>{{ $guest->gender ?? '-' }}</td>
                                            <td>{{ $guest->booking_place ?? '-' }}</td>
                                            <td>
                                                <span class="guest-status {{ $guest->status === 'block' ? 'status-block' : 'status-save' }}">
                                                    {{ $guest->status === 'block' ? 'Blacklist' : 'Active' }}
                                                </span>
                                            </td>
                                            <td>{{ $duration }}</td>
                                            <td>{{ $guest->check_in_date ? $guest->check_in_date->format('d M Y') : '-' }}</td>
                                            <td>{{ $guest->check_out_date ? $guest->check_out_date->format('d M Y') : '-' }}</td>
                                            <td>
                                                <button class="btn-action btn-edit" title="Edit">✎</button>
                                                <button class="btn-action btn-delete" title="Delete">✕</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="guest-pagination">
                            {{ $guests->links('vendor.pagination.arrows') }}
                        </div>
                    </div>

                    <!-- Guests per Room -->
                    <div class="guests-room-card">
                        <div class="guests-room-title">Guests per Room</div>

                        @forelse($roomsWithGuests as $rg)
                            <div class="room-item">
                                <div>
                                    <div class="room-info-name">{{ $rg['name'] }}</div>
                                    @foreach($rg['beds'] as $bed)
                                        <div class="room-info-details">{{ $bed['position'] }} {{ $bed['occupied'] }}/{{ $bed['total'] }}</div>
                                    @endforeach
                                </div>
                                <div class="room-count">{{ $rg['total_guests'] }}</div>
                            </div>
                        @empty
                            <div style="padding:18px 0;color:#7a857f;font-size:13px;">No active guests.</div>
                        @endforelse
                    </div>

                    <!-- Guest Trend -->
                    <div class="guest-trend-card">
                        <div class="guest-trend-header">
                            <div class="guest-trend-title">Guest Trend</div>
                            <select class="trend-dropdown" id="trendDropdown">
                                <option value="days">Days</option>
                                <option value="weeks">Weeks</option>
                            </select>
                        </div>
                        <div class="guest-trend-chart">
                            <canvas id="guestTrendChart"></canvas>
                        </div>
                    </div>

                </div>
                
            </div>
        </main>
    </div>

    <!-- Guest Add Modal -->
    <div class="guest-add-overlay" id="guestAddOverlay" hidden>
        <div class="guest-add-modal" id="guestAddModal" role="dialog" aria-modal="true" aria-labelledby="guestAddTitle">
            <div class="guest-add-modal-header">
                <h2 class="guest-add-modal-title" id="guestAddTitle">Add Guest</h2>
                <button type="button" class="guest-add-close" id="guestAddClose" aria-label="Close">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form class="guest-add-form" id="guestAddForm" novalidate method="POST" action="{{ route('admin.manage_guests.store') }}">
                @csrf
                <div class="guest-add-form-grid">
                    <input type="hidden" name="booking_code" id="guest_booking_code" value="">

                    <div class="guest-add-form-group">
                        <label for="guest_first_name">First Name</label>
                        <input type="text" id="guest_first_name" name="first_name" placeholder="e.g. Aria">
                    </div>

                    <div class="guest-add-form-group">
                        <label for="guest_last_name">Last Name</label>
                        <input type="text" id="guest_last_name" name="last_name" placeholder="e.g. Kusuma">
                    </div>

                    <div class="guest-add-form-group guest-add-form-full">
                        <label for="guest_country">Country</label>
                        <input type="text" id="guest_country" name="country" placeholder="e.g. Indonesia">
                    </div>
                </div>

                <div class="guest-add-form-footer">
                    <button type="button" class="guest-add-btn-cancel" id="guestAddCancel">Cancel</button>
                    <button type="button" class="guest-add-btn-add" id="guestAddSubmit">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Guest Check-in / Check-out Modal -->
    <div class="guest-action-overlay" id="guestActionOverlay" hidden>
        <div class="guest-action-modal" id="guestActionModal" role="dialog" aria-modal="true" aria-labelledby="guestActionTitle">
            <div class="guest-action-modal-header">
                <h2 class="guest-action-modal-title" id="guestActionTitle">Guest Check-in</h2>
                <button type="button" class="guest-action-close" id="guestActionClose" aria-label="Close">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Step 1: Search booking -->
            <div class="guest-action-step" id="guestActionStepSearch">
                <label class="guest-action-label" for="guestBookingId">Input Booking ID</label>
                <div class="guest-action-search-row">
                    <input type="text" id="guestBookingId" class="guest-action-input" placeholder="" autocomplete="off">
                    <button type="button" class="guest-action-search-btn" id="guestActionSearch">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Search</span>
                    </button>
                </div>
            </div>

            <!-- Step 2a: Check-in form -->
            <div class="guest-action-step guest-action-step-checkin" id="guestActionStepCheckin" hidden>
                <p class="guest-action-booking-ref" id="guestActionBookingRef">BK-2026-1042</p>
                <div class="guest-action-form-scroll">
                    <x-admin_guest_details_form />
                </div>
                <div class="guest-action-form-footer">
                    <button type="button" class="guest-action-btn-back" id="guestActionFormBack">Back</button>
                    <button type="button" class="guest-action-btn-done" id="guestActionFormDone">Done</button>
                </div>
            </div>

            <!-- Step 2b: Check-out form -->
            <div class="guest-action-step guest-action-step-checkout" id="guestActionStepCheckout" hidden>
                <div class="guest-action-form-scroll">
                    <x-admin_guest_checkout_form />
                </div>
                <div class="guest-action-form-footer">
                    <button type="button" class="guest-action-btn-back" id="guestCheckoutFormBack">Back</button>
                    <button type="button" class="guest-action-btn-done" id="guestCheckoutFormDone">Done</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Inject backend data BEFORE any JS reads them ── --}}
    <script>
        window.guestTrendLabels = {!! json_encode($trendLabels) !!};
        window.guestTrendData   = {!! json_encode($trendData) !!};
    </script>

    <script>
        // ── Inline styles for Add Guest modal (fallback) ──────────────
        (function () {
            const styleId = 'guest-add-modal-style';
            if (document.getElementById(styleId)) return;
            const style = document.createElement('style');
            style.id = styleId;
            style.textContent = `
                .guest-add-overlay{position:fixed;inset:0;z-index:1200;display:flex;align-items:flex-start;justify-content:center;padding:24px;background:rgba(8,38,0,0.55);overflow-y:auto;box-sizing:border-box;}
                .guest-add-overlay[hidden]{display:none!important;}
                .guest-add-modal{width:100%;max-width:641px;background:#1a3d0a;border-radius:8px;padding:32px 40px 40px;box-sizing:border-box;color:#fff;display:flex;flex-direction:column;overflow:hidden;min-height:0;}
                .guest-add-modal-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:28px;flex-shrink:0;}
                .guest-add-modal-title{font-family:'EB Garamond',serif;font-size:36px;font-weight:400;margin:0;color:#fff;line-height:1.2;}
                .guest-add-close{flex-shrink:0;width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:transparent;border:1px solid rgba(255,255,255,0.8);border-radius:2px;color:#fff;cursor:pointer;padding:0;transition:background .2s ease;}
                .guest-add-close:hover{background:rgba(255,255,255,0.1);}
                .guest-add-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:8px;}
                .guest-add-form-group{display:flex;flex-direction:column;gap:8px;}
                .guest-add-form-full{grid-column:span 2;}
                .guest-add-form-group label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#f7f7f2;font-family:'EB Garamond',serif;}
                .guest-add-form-group input{background:#f7f7f2;border:none;border-radius:2px;padding:10px 14px;font-family:'EB Garamond',serif;font-size:14px;color:#1a3d0a;outline:none;width:100%;box-sizing:border-box;}
                .guest-add-form-group input::placeholder{color:rgba(26,61,10,0.4);}
                .guest-add-form-footer{padding-top:25px;display:flex;justify-content:space-between;gap:16px;flex-shrink:0;}
                .guest-add-btn-cancel,.guest-add-btn-add{border:none;border-radius:4px;padding:12px 32px;font-size:16px;font-weight:600;font-family:'EB Garamond',serif;cursor:pointer;transition:opacity .2s ease;}
                .guest-add-btn-cancel{background:#4ca761;color:#fff;}
                .guest-add-btn-add{background:#D9864A;color:#fff;}
                .guest-add-btn-cancel:hover,.guest-add-btn-add:hover{opacity:.9;}
                .guest-status{display:inline-block;padding:3px 10px;border-radius:100px;font-size:11px;font-weight:600;letter-spacing:.3px;}
                .status-save{background:#e6f4e0;color:#2d6a1e;}
                .status-block{background:#fce4e4;color:#b71c1c;}
                .btn-action{background:none;border:1px solid #ddd;border-radius:4px;padding:4px 8px;cursor:pointer;font-size:13px;transition:.15s;}
                .btn-action:hover{border-color:#999;}
                .btn-edit:hover{background:#f0f7ee;border-color:#4a7c3f;color:#4a7c3f;}
                .btn-delete:hover{background:#fdeaea;border-color:#c62828;color:#c62828;}
                @media(max-width:600px){.guest-add-modal{padding:24px;max-width:100%;}.guest-add-modal-title{font-size:28px;}.guest-add-form-grid{grid-template-columns:1fr;}.guest-add-form-full{grid-column:span 1;}.guest-add-form-footer{flex-direction:column;}.guest-add-btn-cancel,.guest-add-btn-add{width:100%;text-align:center;}}
            `;
            document.head.appendChild(style);
        })();

        // ── Sidebar ───────────────────────────────────────────────────
        const sidebar         = document.getElementById('adminSidebar');
        const sidebarToggle   = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function setSidebarOpen(isOpen) {
            if (!sidebar || !sidebarToggle || !sidebarBackdrop) return;
            sidebar.classList.toggle('open', isOpen);
            sidebarBackdrop.hidden = !isOpen;
            document.body.classList.toggle('sidebar-open', isOpen);
            sidebarToggle.setAttribute('aria-expanded', String(isOpen));
            sidebarToggle.setAttribute('aria-label', isOpen ? 'Close sidebar' : 'Open sidebar');
        }

        if (sidebarToggle && sidebarBackdrop && sidebar) {
            sidebarToggle.addEventListener('click', () => setSidebarOpen(!sidebar.classList.contains('open')));
            sidebarBackdrop.addEventListener('click', () => setSidebarOpen(false));
            window.addEventListener('resize', () => { if (window.innerWidth >= 1024) setSidebarOpen(false); });
        }

        // ── Add Guest Modal ───────────────────────────────────────────
        const btnAddGuest       = document.getElementById('btnAddGuest');
        const guestAddOverlay   = document.getElementById('guestAddOverlay');
        const guestAddClose     = document.getElementById('guestAddClose');
        const guestAddCancel    = document.getElementById('guestAddCancel');
        const guestAddSubmit    = document.getElementById('guestAddSubmit');
        const guestAddForm      = document.getElementById('guestAddForm');
        const guestFirstName    = document.getElementById('guest_first_name');
        const guestLastName     = document.getElementById('guest_last_name');
        const guestCountry      = document.getElementById('guest_country');
        const guestBookingCode  = document.getElementById('guest_booking_code');

        function openGuestAddModal() {
            if (!guestAddOverlay) return;
            guestAddOverlay.removeAttribute('hidden');
            guestAddOverlay.classList.add('is-open');
            document.body.classList.add('guest-action-open');
            guestFirstName?.focus();
        }

        function closeGuestAddModal() {
            if (!guestAddOverlay) return;
            guestAddOverlay.classList.remove('is-open');
            guestAddOverlay.setAttribute('hidden', '');
            document.body.classList.remove('guest-action-open');
            guestAddForm?.reset();
        }

        btnAddGuest?.addEventListener('click', openGuestAddModal);
        guestAddClose?.addEventListener('click', closeGuestAddModal);
        guestAddCancel?.addEventListener('click', closeGuestAddModal);

        guestAddOverlay?.addEventListener('click', function (e) {
            if (e.target === guestAddOverlay) closeGuestAddModal();
        });

        guestAddSubmit?.addEventListener('click', function () {
            const firstName = (guestFirstName?.value || '').trim();
            const lastName  = (guestLastName?.value  || '').trim();
            const country   = (guestCountry?.value   || '').trim();

            if (!firstName) { guestFirstName?.focus(); return; }
            if (!lastName)  { guestLastName?.focus();  return; }
            if (!country)   { guestCountry?.focus();   return; }

            if (guestBookingCode) guestBookingCode.value = 'BK-' + Date.now();
            guestAddForm?.submit();
        });

        // ── Check-in / Check-out Modal ────────────────────────────────
        const guestActionOverlay    = document.getElementById('guestActionOverlay');
        const guestActionModal      = document.getElementById('guestActionModal');
        const guestActionTitle      = document.getElementById('guestActionTitle');
        const guestActionClose      = document.getElementById('guestActionClose');
        const guestBookingId        = document.getElementById('guestBookingId');
        const guestActionSearchBtn  = document.getElementById('guestActionSearch');
        const guestActionStepSearch = document.getElementById('guestActionStepSearch');
        const guestActionStepCheckin  = document.getElementById('guestActionStepCheckin');
        const guestActionStepCheckout = document.getElementById('guestActionStepCheckout');
        const guestActionBookingRef = document.getElementById('guestActionBookingRef');
        const guestActionFormBack   = document.getElementById('guestActionFormBack');
        const guestActionFormDone   = document.getElementById('guestActionFormDone');
        const guestCheckoutFormBack = document.getElementById('guestCheckoutFormBack');
        const guestCheckoutFormDone = document.getElementById('guestCheckoutFormDone');

        let currentGuestAction = 'checkin';
        const guestActionTitles = { checkin: 'Guest Check-in', checkout: 'Guest Check-out' };

        function showGuestActionSearchStep() {
            guestActionStepSearch?.removeAttribute('hidden');
            guestActionStepCheckin?.setAttribute('hidden', '');
            guestActionStepCheckout?.setAttribute('hidden', '');
            guestActionModal?.classList.remove('is-form-step', 'is-checkout-step');
            guestActionTitle?.removeAttribute('hidden');
        }

        // Tabs inside check-in form
        const adminGuestTabs  = document.querySelectorAll('.admin-guest-tab');
        const adminTabIdCard  = document.getElementById('adminTabIdCard');
        const adminTabDeposit = document.getElementById('adminTabDeposit');

        function setAdminGuestTab(tabName) {
            const isDeposit = tabName === 'deposit';
            adminGuestTabs.forEach(tab => {
                const active = tab.dataset.tab === tabName;
                tab.classList.toggle('active', active);
                tab.setAttribute('aria-selected', String(active));
            });
            if (isDeposit) {
                adminTabIdCard?.setAttribute('hidden', '');
                adminTabDeposit?.removeAttribute('hidden');
            } else {
                adminTabIdCard?.removeAttribute('hidden');
                adminTabDeposit?.setAttribute('hidden', '');
            }
        }

        adminGuestTabs.forEach(tab => tab.addEventListener('click', () => setAdminGuestTab(tab.dataset.tab)));

        function showGuestActionCheckinStep(bookingId) {
            setAdminGuestTab('id-card');
            if (guestActionBookingRef) guestActionBookingRef.textContent = bookingId;
            guestActionStepSearch?.setAttribute('hidden', '');
            guestActionStepCheckout?.setAttribute('hidden', '');
            guestActionStepCheckin?.removeAttribute('hidden');
            guestActionModal?.classList.add('is-form-step');
            guestActionModal?.classList.remove('is-checkout-step');
            guestActionTitle?.setAttribute('hidden', '');
            document.getElementById('admin_first_name')?.focus();
        }

        let checkoutGuestData = null;

        function showGuestActionCheckoutStep(bookingId) {
            resetCheckoutForm();
            document.getElementById('checkout_booking_code').value = bookingId;

            if (checkoutGuestData) {
                document.getElementById('checkoutStayingFee').textContent = 'IDR ' + Number(checkoutGuestData.total_price).toLocaleString('id-ID');
            }

            guestActionStepSearch?.setAttribute('hidden', '');
            guestActionStepCheckin?.setAttribute('hidden', '');
            guestActionStepCheckout?.removeAttribute('hidden');
            guestActionModal?.classList.add('is-form-step', 'is-checkout-step');
            if (guestActionTitle) {
                guestActionTitle.removeAttribute('hidden');
                guestActionTitle.textContent = guestActionTitles.checkout;
            }
            document.getElementById('checkout_notes')?.focus();
        }

        function openGuestActionModal(action) {
            if (!guestActionOverlay || !guestActionTitle) return;
            currentGuestAction = action || 'checkin';
            guestActionTitle.textContent = guestActionTitles[currentGuestAction] || 'Guest Check-in';
            guestActionTitle.removeAttribute('hidden');
            showGuestActionSearchStep();
            guestActionOverlay.removeAttribute('hidden');
            guestActionOverlay.classList.add('is-open');
            document.body.classList.add('guest-action-open');
            if (guestBookingId) { guestBookingId.value = ''; guestBookingId.focus(); }
        }

        function closeGuestActionModal() {
            checkoutGuestData = null;
            if (!guestActionOverlay) return;
            guestActionOverlay.classList.remove('is-open');
            guestActionOverlay.setAttribute('hidden', '');
            document.body.classList.remove('guest-action-open');
            showGuestActionSearchStep();
        }

        function handleGuestActionSearch() {
            const bookingId = guestBookingId?.value.trim();
            if (!bookingId) { guestBookingId?.focus(); return; }
            if (currentGuestAction === 'checkin') {
                showGuestActionCheckinStep(bookingId);
                return;
            }

            const searchBtn = guestActionSearchBtn;
            searchBtn.disabled = true;
            searchBtn.textContent = 'Searching...';

            fetch('/admin/manage-guests/search/' + encodeURIComponent(bookingId))
                .then(r => r.json())
                .then(data => {
                    searchBtn.disabled = false;
                    searchBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><span>Search</span>';

                    if (!data.found) {
                        alert(data.message || 'Booking ID tidak ditemukan.');
                        return;
                    }
                    checkoutGuestData = data.guest;
                    showGuestActionCheckoutStep(bookingId);
                })
                .catch(() => {
                    searchBtn.disabled = false;
                    searchBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><span>Search</span>';
                    alert('Gagal mencari booking.');
                });
        }

        document.querySelectorAll('.split-label-btn').forEach(btn => {
            btn.addEventListener('click', () => openGuestActionModal(btn.dataset.guestAction));
        });

        guestActionClose?.addEventListener('click', closeGuestActionModal);
        guestActionFormBack?.addEventListener('click', showGuestActionSearchStep);
        guestCheckoutFormBack?.addEventListener('click', showGuestActionSearchStep);
        guestActionFormDone?.addEventListener('click', closeGuestActionModal);
        guestCheckoutFormDone?.addEventListener('click', function () {
            const form = document.getElementById('adminGuestCheckoutForm');
            const bookingCode = document.getElementById('checkout_booking_code')?.value;
            const status = document.getElementById('checkout_status')?.value;
            const notes = document.getElementById('checkout_notes')?.value;

            if (!bookingCode) { alert('Booking ID tidak ditemukan.'); return; }

            const btn = guestCheckoutFormDone;
            btn.disabled = true;
            btn.textContent = 'Processing...';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ booking_code: bookingCode, status: status === 'blacklist' ? 'blacklist' : 'safe', notes: notes })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeGuestActionModal();
                    location.reload();
                } else {
                    alert('Gagal: ' + (data.message || 'Unknown error'));
                    btn.disabled = false;
                    btn.textContent = 'Done';
                }
            })
            .catch(() => {
                alert('Terjadi kesalahan jaringan.');
                btn.disabled = false;
                btn.textContent = 'Done';
            });
        });

        guestActionSearchBtn?.addEventListener('click', handleGuestActionSearch);
        guestBookingId?.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); handleGuestActionSearch(); } });

        guestActionOverlay?.addEventListener('click', e => { if (e.target === guestActionOverlay) closeGuestActionModal(); });

        // ── Checkout charges ──────────────────────────────────────────
        const checkoutChargesList   = document.getElementById('checkoutChargesList');
        const checkoutChargeDesc    = document.getElementById('checkout_charge_desc');
        const checkoutChargeNominal = document.getElementById('checkout_charge_nominal');
        const checkoutAddCharge     = document.getElementById('checkoutAddCharge');
        const checkoutRefunded      = document.getElementById('checkoutRefunded');
        const checkoutStatus        = document.getElementById('checkout_status');
        const checkoutNotes         = document.getElementById('checkout_notes');
        const CHECKOUT_DEPOSIT      = 200000;

        const formatIdr    = amount => 'IDR ' + Math.max(0, Math.round(amount)).toLocaleString('id-ID');
        const parseNominal = value  => { const d = String(value).replace(/\D/g, ''); return d ? parseInt(d, 10) : 0; };

        function getCheckoutExtraTotal() {
            let t = 0;
            checkoutChargesList?.querySelectorAll('.admin-checkout-charge-item').forEach(el => { t += parseInt(el.dataset.amount, 10) || 0; });
            return t;
        }

        function updateCheckoutRefunded() {
            if (checkoutRefunded) checkoutRefunded.textContent = formatIdr(CHECKOUT_DEPOSIT - getCheckoutExtraTotal());
        }

        function resetCheckoutForm() {
            if (checkoutChargesList) checkoutChargesList.innerHTML = '';
            if (checkoutChargeDesc)    checkoutChargeDesc.value = '';
            if (checkoutChargeNominal) checkoutChargeNominal.value = '';
            if (checkoutNotes)  checkoutNotes.value = '';
            if (checkoutStatus) { checkoutStatus.value = 'safe'; checkoutStatus.classList.remove('is-blacklist'); }
            updateCheckoutRefunded();
        }

        function addCheckoutCharge(desc, amount) {
            if (!checkoutChargesList || !desc || amount <= 0) return;
            const li = document.createElement('li');
            li.className = 'admin-checkout-charge-item';
            li.dataset.amount = String(amount);

            const main   = document.createElement('div'); main.className = 'admin-checkout-charge-main';
            const dSpan  = document.createElement('span'); dSpan.className = 'admin-checkout-charge-desc';   dSpan.textContent = desc;
            const aSpan  = document.createElement('span'); aSpan.className = 'admin-checkout-charge-amount'; aSpan.textContent = '-IDR ' + amount.toLocaleString('id-ID');
            const rmBtn  = document.createElement('button');
            rmBtn.type = 'button'; rmBtn.className = 'admin-checkout-charge-remove';
            rmBtn.innerHTML = '<span aria-hidden="true">✕</span> Close';
            rmBtn.setAttribute('aria-label', 'Remove ' + desc);
            rmBtn.addEventListener('click', () => { li.remove(); updateCheckoutRefunded(); });

            main.append(dSpan, aSpan);
            li.append(main, rmBtn);
            checkoutChargesList.appendChild(li);
            updateCheckoutRefunded();
        }

        checkoutAddCharge?.addEventListener('click', () => {
            const desc   = checkoutChargeDesc?.value.trim();
            const amount = parseNominal(checkoutChargeNominal?.value);
            if (!desc || amount <= 0) { (desc ? checkoutChargeNominal : checkoutChargeDesc)?.focus(); return; }
            addCheckoutCharge(desc, amount);
            if (checkoutChargeDesc)    checkoutChargeDesc.value = '';
            if (checkoutChargeNominal) checkoutChargeNominal.value = '';
        });

        checkoutStatus?.addEventListener('change', () => {
            checkoutStatus.classList.toggle('is-blacklist', checkoutStatus.value === 'blacklist');
        });

        // ── File upload hints ─────────────────────────────────────────
        document.querySelectorAll('.admin-guest-upload-area input[type="file"]').forEach(input => {
            input.addEventListener('change', () => {
                const hint = input.closest('.admin-guest-upload-area')?.querySelector('.admin-guest-upload-hint');
                if (hint && input.files?.[0]) hint.textContent = input.files[0].name;
            });
        });

        // ── Global Escape key ─────────────────────────────────────────
        window.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            if (guestAddOverlay?.classList.contains('is-open')) { closeGuestAddModal(); return; }
            if (guestActionOverlay?.classList.contains('is-open')) {
                const onForm = (guestActionStepCheckin  && !guestActionStepCheckin.hasAttribute('hidden'))
                            || (guestActionStepCheckout && !guestActionStepCheckout.hasAttribute('hidden'));
                onForm ? showGuestActionSearchStep() : closeGuestActionModal();
            }
        });

        // ── Guest search / filter ─────────────────────────────────────
        document.getElementById('guestSearchInput')?.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#guestListTbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });

        // ── Guest Trend Chart ─────────────────────────────────────────
        const trendCtx = document.getElementById('guestTrendChart')?.getContext('2d');
        let trendChart = null;

        if (trendCtx) {
            trendChart = new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: window.guestTrendLabels || ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                    datasets: [{
                        data: window.guestTrendData || [0,0,0,0,0,0,0],
                        backgroundColor: '#29A4A1',
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            suggestedMax: Math.max(10, ...(window.guestTrendData || [0])) + 2,
                            grid: { display: false },
                            ticks: { stepSize: 5 }
                        }
                    }
                }
            });
        }

        // Trend dropdown: Days vs Weeks
        document.getElementById('trendDropdown')?.addEventListener('change', function () {
            if (!trendChart) return;
            if (this.value === 'weeks') {
                // Group guestTrendData into weeks (we only have 7 days, so show as single week)
                trendChart.data.labels  = ['This Week'];
                trendChart.data.datasets[0].data = [
                    (window.guestTrendData || []).reduce((a, b) => a + b, 0)
                ];
            } else {
                trendChart.data.labels  = window.guestTrendLabels || ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                trendChart.data.datasets[0].data = window.guestTrendData || [0,0,0,0,0,0,0];
            }
            trendChart.options.scales.y.suggestedMax = Math.max(10, ...trendChart.data.datasets[0].data) + 2;
            trendChart.update();
        });
    </script>
</body>
</html>