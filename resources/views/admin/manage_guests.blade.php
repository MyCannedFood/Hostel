@php
    $admin = auth('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Guests - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/manage_guests.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Override body overflow-x:hidden dari app.css agar position:fixed tidak terpotong */
        body { overflow-x: visible !important; }
        /* Pastikan modal overlay selalu di atas segalanya */
        #guestAddOverlay, #guestActionOverlay {
            position: fixed !important;
            inset: 0 !important;
            z-index: 9999 !important;
            pointer-events: auto;
        }
        #guestAddOverlay[hidden], #guestActionOverlay[hidden] {
            display: none !important;
            pointer-events: none !important;
        }
        /* Fix scroll pada form step: rantai flex harus lengkap dari modal sampai scroll area */
        #guestActionModal {
            display: flex !important;
            flex-direction: column !important;
            max-height: calc(100vh - 48px) !important;
            overflow: hidden !important;
        }
        #guestActionStepCheckin,
        #guestActionStepCheckout {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
            overflow: hidden;
        }
        .guest-action-form-scroll {
            flex: 1 !important;
            min-height: 0 !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }
    </style>
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
                                        <th>Guest ID</th>
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
                                            $latestBooking = $guest->bookings->first();
                                            $editUrl = $latestBooking
                                                ? route('admin.booking.edit_popup', $latestBooking->id)
                                                : null;
                                            $guestData = [
                                                'id'               => $guest->id,
                                                'first_name'       => $guest->first_name,
                                                'last_name'        => $guest->last_name,
                                                'gender'           => $guest->gender,
                                                'age'              => $guest->age,
                                                'email'            => $guest->email,
                                                'phone'            => $guest->phone,
                                                'occupation'       => $guest->occupation,
                                                'id_number'        => $guest->id_number,
                                                'city'             => $guest->city,
                                                'country'          => $guest->country,
                                                'self_description' => $guest->self_description,
                                                'profile_picture'  => $guest->profile_picture ? asset('storage/' . $guest->profile_picture) : null,
                                                'id_card_photo'    => $guest->id_card_photo   ? asset('storage/' . $guest->id_card_photo)   : null,
                                            ];
                                        @endphp
                                        <tr>
                                            <td>{{ $guest->guest_code }}</td>
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
                                                <div class="guest-actions-cell">
                                                    {{-- Edit button: buka booking iframe jika ada booking, sinon buka modal edit guest --}}
                                                    <button class="btn-action btn-edit"
                                                        title="{{ $editUrl ? 'Edit Reservation' : 'Edit Guest Data' }}"
                                                        data-guest-edit-action
                                                        @if($editUrl)
                                                            data-edit-url="{{ $editUrl }}"
                                                        @else
                                                            data-edit-guest='@json($guestData)'
                                                            data-update-url="{{ route('admin.manage_guests.update', $guest->id) }}"
                                                        @endif
                                                        aria-label="Edit {{ $guest->first_name }}">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    </button>
                                                    <button class="btn-action btn-delete"
                                                        title="Delete Guest"
                                                        data-guest-delete-action
                                                        data-guest-id="{{ $guest->id }}"
                                                        data-guest-name="{{ $guest->first_name }} {{ $guest->last_name }}"
                                                        aria-label="Delete guest {{ $guest->first_name }}">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                                    </button>
                                                </div>
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

        <form class="guest-add-form" id="guestAddForm" novalidate method="POST" action="{{ route('admin.manage_guests.store') }}" enctype="multipart/form-data">
            @csrf
            
            @if ($errors->any())
                <div class="guest-add-errors" style="grid-column: span 2; background: rgba(220, 53, 69, 0.15); border: 1px solid #dc3545; padding: 12px 16px; border-radius: 4px; margin-bottom: 20px; font-size: 13px; color: #ff8484; font-family: 'EB Garamond', serif;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="guest-add-form-grid">
                <input type="hidden" name="guest_code" id="guest_custom_code" value="">

                <div class="guest-add-form-group">
                    <label for="guest_first_name">First Name</label>
                    <input type="text" id="guest_first_name" name="first_name" placeholder="e.g. Aria" value="{{ old('first_name') }}" required>
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_last_name">Last Name</label>
                    <input type="text" id="guest_last_name" name="last_name" value="{{ old('last_name') }}" placeholder="e.g. Kusuma">
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_gender">Gender</label>
                    <select id="guest_gender" name="gender" required>
                        <option value="" disabled {{ old('gender') ? '' : 'selected' }} hidden>Select Gender</option>
                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_age">Age</label>
                    <input type="number" id="guest_age" name="age" value="{{ old('age') }}" placeholder="e.g. 25">
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_email">Email</label>
                    <input type="email" id="guest_email" name="email" value="{{ old('email') }}" placeholder="e.g. aria@example.com">
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_phone">Phone</label>
                    <input type="text" id="guest_phone" name="phone" value="{{ old('phone') }}" placeholder="e.g. 08123456789">
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_occupation">Occupation</label>
                    <input type="text" id="guest_occupation" name="occupation" value="{{ old('occupation') }}" placeholder="e.g. Designer">
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_id_number">ID Number</label>
                    <input type="text" id="guest_id_number" name="id_number" value="{{ old('id_number') }}" placeholder="e.g. 3201234567890001">
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_city">City</label>
                    <input type="text" id="guest_city" name="city" value="{{ old('city') }}" placeholder="e.g. Bandung">
                </div>

                <div class="guest-add-form-group">
                    <label for="guest_country">Country</label>
                    <input type="text" id="guest_country" name="country" value="{{ old('country') }}" placeholder="e.g. Indonesia">
                </div>

                <div class="guest-add-form-group guest-add-form-full">
                    <label for="guest_self_description">Self Description</label>
                    <textarea id="guest_self_description" name="self_description" rows="3" placeholder="Additional notes about the guest...">{{ old('self_description') }}</textarea>
                </div>

                <div class="admin-guest-upload-grid guest-add-form-full">
                    <div class="admin-guest-upload-box">
                        <label class="admin-guest-upload-label" for="admin_profile_picture">Profile Picture</label>
                        <label class="admin-guest-upload-area" for="admin_profile_picture" style="position: relative; overflow: hidden;">
                            <input type="file" id="admin_profile_picture" name="profile_picture" accept="image/*" hidden>
                            
                            <div class="upload-placeholder" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="1.5" aria-hidden="true">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                                <span class="admin-guest-upload-hint">Click to upload</span>
                            </div>

                            <img class="upload-preview" src="" alt="Preview" style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                        </label>
                    </div>
                    
                    <div class="admin-guest-upload-box">
                        <label class="admin-guest-upload-label" for="admin_card_photo">Card Photo</label>
                        <label class="admin-guest-upload-area" for="admin_card_photo" style="position: relative; overflow: hidden;">
                            <input type="file" id="admin_card_photo" name="id_card_photo" accept="image/*" hidden>
                            
                            <div class="upload-placeholder" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="1.5" aria-hidden="true">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                                <span class="admin-guest-upload-hint">Click to upload</span>
                            </div>

                            <img class="upload-preview" src="" alt="Preview" style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                        </label>
                    </div>
                </div>
            </div>

            <div class="guest-add-form-footer">
                <button type="button" class="guest-add-btn-cancel" id="guestAddCancel">Cancel</button>
                <button type="button" class="guest-add-btn-add" id="guestAddSubmit">Create Guest</button>
            </div>
        </form>
    </div>
</div>

    <!-- Edit Reservation Modal (iframe) -->
    <div class="guest-edit-modal-overlay" id="guestEditModalOverlay" hidden aria-hidden="true">
        <iframe class="guest-edit-modal-frame" id="guestEditModalFrame" src="" title="Edit Reservation" frameborder="0"></iframe>
    </div>

    <!-- Edit Guest Data Modal (untuk guest tanpa booking) -->
    <div class="guest-add-overlay" id="guestDataEditOverlay" hidden role="dialog" aria-modal="true" aria-labelledby="guestDataEditTitle">
        <div class="guest-add-modal" id="guestDataEditModal" style="max-width:700px;">
            <div class="guest-add-modal-header">
                <h2 class="guest-add-modal-title" id="guestDataEditTitle">Edit Guest Data</h2>
                <button type="button" class="guest-add-close" id="guestDataEditClose" aria-label="Close">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <form id="guestDataEditForm" enctype="multipart/form-data">
                <input type="hidden" id="gde_guest_id" name="guest_id">
                <input type="hidden" id="gde_update_url" name="_update_url">
                <div class="guest-add-form-grid">
                    <div class="guest-add-form-group">
                        <label for="gde_first_name">First Name *</label>
                        <input type="text" id="gde_first_name" name="first_name" placeholder="First Name" required>
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_last_name">Last Name</label>
                        <input type="text" id="gde_last_name" name="last_name" placeholder="Last Name">
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_gender">Gender</label>
                        <select id="gde_gender" name="gender" style="background:#f7f7f2;border:none;border-radius:2px;padding:10px 14px;font-family:'EB Garamond',serif;font-size:14px;color:#1a3d0a;outline:none;width:100%;box-sizing:border-box;">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_age">Age</label>
                        <input type="number" id="gde_age" name="age" placeholder="Age" min="0">
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_email">Email</label>
                        <input type="email" id="gde_email" name="email" placeholder="Email">
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_phone">Phone</label>
                        <input type="text" id="gde_phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_occupation">Occupation</label>
                        <input type="text" id="gde_occupation" name="occupation" placeholder="Occupation">
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_id_number">ID Number</label>
                        <input type="text" id="gde_id_number" name="id_number" placeholder="KTP / Passport Number">
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_city">City</label>
                        <input type="text" id="gde_city" name="city" placeholder="City">
                    </div>
                    <div class="guest-add-form-group">
                        <label for="gde_country">Country</label>
                        <input type="text" id="gde_country" name="country" placeholder="Country">
                    </div>
                    <div class="guest-add-form-group guest-add-form-full">
                        <label for="gde_self_description">Self Description</label>
                        <textarea id="gde_self_description" name="self_description" rows="2" placeholder="Notes about this guest..." style="background:#f7f7f2;border:none;border-radius:2px;padding:10px 14px;font-family:'EB Garamond',serif;font-size:14px;color:#1a3d0a;outline:none;width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                    </div>

                    {{-- Upload foto --}}
                    <div class="guest-add-form-group">
                        <label>Profile Picture</label>
                        <label class="admin-guest-upload-area" for="gde_profile_picture" style="position:relative;overflow:hidden;height:120px;display:flex;align-items:center;justify-content:center;background:#f7f7f2;border-radius:4px;cursor:pointer;">
                            <input type="file" id="gde_profile_picture" name="profile_picture" accept="image/*" hidden>
                            <div class="gde-upload-placeholder" style="display:flex;flex-direction:column;align-items:center;gap:6px;color:#D9864A;font-size:12px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                <span>Profile Photo</span>
                            </div>
                            <img id="gde_profile_preview" src="" alt="Preview" style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                        </label>
                    </div>
                    <div class="guest-add-form-group">
                        <label>ID Card Photo</label>
                        <label class="admin-guest-upload-area" for="gde_id_card_photo" style="position:relative;overflow:hidden;height:120px;display:flex;align-items:center;justify-content:center;background:#f7f7f2;border-radius:4px;cursor:pointer;">
                            <input type="file" id="gde_id_card_photo" name="id_card_photo" accept="image/*" hidden>
                            <div class="gde-upload-placeholder" style="display:flex;flex-direction:column;align-items:center;gap:6px;color:#D9864A;font-size:12px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                <span>ID Card Photo</span>
                            </div>
                            <img id="gde_idcard_preview" src="" alt="Preview" style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                        </label>
                    </div>
                </div>

                <div class="guest-add-form-footer">
                    <button type="button" class="guest-add-btn-cancel" id="guestDataEditCancel">Cancel</button>
                    <button type="button" class="guest-add-btn-add" id="guestDataEditSubmit">Save Changes</button>
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
                <label class="guest-action-label" for="guestBookingId" id="guestActionSearchLabel">Input Booking ID</label>
                <div class="guest-action-search-row">
                    <input type="text" id="guestBookingId" class="guest-action-input" placeholder="" autocomplete="off">
                    {{-- Dropdown for checkout mode (hidden by default) --}}
                    <select id="guestCheckoutDropdown" class="guest-action-input" style="display:none;">
                        <option value="">— Pilih Reservasi —</option>
                        @foreach($checkedInBookings as $cb)
                            <option value="{{ $cb['booking_code'] }}" data-guest-code="{{ $cb['guest_code'] }}">{{ $cb['label'] }}</option>
                        @endforeach
                    </select>
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
                <div class="guest-action-booking-ref" style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px;">
                    <span>Booking Code: <strong id="guestActionBookingRef" style="color: #D9864A;">-</strong></span>
                    <span>|</span>
                    <span>Guest ID: <strong id="guestActionGuestCodeRef" style="color: #D9864A;">-</strong></span>
                </div>
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
        // ── Inline styles for Modals (Force Show Fallback) ──────────────
        (function () {
            const styleId = 'guest-modal-style-fix';
            if (document.getElementById(styleId)) return;
            const style = document.createElement('style');
            style.id = styleId;
            style.textContent = `
                /* Add Guest Overlay */
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
                @media(max-width:600px){.guest-add-modal{padding:24px;max-width:100%;}.guest-add-modal-title{font-size:28px;}.guest-add-form-grid{grid-template-columns:1fr;}.guest-add-form-full{grid-column:span 1;}.guest-add-form-footer{flex-direction:column;}.guest-add-btn-cancel,.guest-add-btn-add{width:100%;text-align:center;}}
                
                /* =========================================
                   FORCE SHOW & FALLBACK UNTUK CHECK-IN/OUT MODAL
                   ========================================= */
                .guest-action-overlay {
                    position: fixed;
                    inset: 0;
                    z-index: 1300;
                    display: flex;
                    align-items: flex-start;
                    justify-content: center;
                    padding: 24px;
                    background: rgba(8, 38, 0, 0.55);
                    box-sizing: border-box;
                    overflow-y: auto;
                }
                .guest-action-overlay[hidden] {
                    display: none !important;
                }
                .guest-action-overlay.is-open {
                    display: flex !important;
                    opacity: 1 !important;
                    visibility: visible !important;
                }
                .guest-action-modal {
                    width: 100%;
                    max-width: 641px;
                    max-height: calc(100vh - 48px);
                    margin: auto;
                    flex-shrink: 0;
                    background: #1a3d0a;
                    border-radius: 8px;
                    padding: 32px 40px 40px;
                    box-sizing: border-box;
                    color: #fff;
                    display: flex;
                    flex-direction: column;
                    overflow: hidden;
                    min-height: 0;
                }
                .guest-action-modal.is-form-step {
                    max-width: 900px;
                    padding: 32px 32px 24px;
                }
                .guest-action-modal.is-checkout-step {
                    max-width: 1072px;
                    background: #fff;
                    color: #1a3d0a;
                    border: 1px solid rgba(26, 61, 10, 0.25);
                    padding: 32px;
                }
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

        document.addEventListener('DOMContentLoaded', function() {
            // ====================================================================
            // 0. PORTAL: Pindahkan modal ke document.body agar position:fixed
            //    tidak terpotong oleh overflow:hidden pada ancestor
            // ====================================================================
            ['guestAddOverlay', 'guestActionOverlay'].forEach(id => {
                const el = document.getElementById(id);
                if (el && el.parentNode !== document.body) {
                    document.body.appendChild(el);
                }
            });

            // ====================================================================
            // 0b. PEMBERSIHAN EVENT LISTENER HANTU DARI APP.JS
            // ====================================================================
            const oldBtnAddGuest = document.getElementById('btnAddGuest');
            if (oldBtnAddGuest) {
                const newBtnAddGuest = oldBtnAddGuest.cloneNode(true);
                oldBtnAddGuest.parentNode.replaceChild(newBtnAddGuest, oldBtnAddGuest);
            }

            document.querySelectorAll('[data-guest-action]').forEach(btn => {
                const newBtn = btn.cloneNode(true);
                btn.parentNode.replaceChild(newBtn, btn);
            });


            // ====================================================================
            // 1. ADD GUEST MODAL 
            // ====================================================================
            const btnAddGuest       = document.getElementById('btnAddGuest');
            const guestAddOverlay   = document.getElementById('guestAddOverlay');
            const guestAddClose     = document.getElementById('guestAddClose');
            const guestAddCancel    = document.getElementById('guestAddCancel');
            const guestAddSubmit    = document.getElementById('guestAddSubmit');
            const guestAddForm      = document.getElementById('guestAddForm');

            const guestFirstName    = document.getElementById('guest_first_name');
            const guestGender       = document.getElementById('guest_gender');
            const guestCustomCode   = document.getElementById('guest_custom_code');

            function openGuestAddModal() {
                if (!guestAddOverlay) return;
                closeGuestActionModal(); // Tutup modal lain

                guestAddOverlay.style.display = 'flex'; // Force show
                guestAddOverlay.removeAttribute('hidden');
                guestAddOverlay.classList.add('is-open');
                document.body.classList.add('guest-action-open');
                guestFirstName?.focus();
            }

            function closeGuestAddModal() {
                if (!guestAddOverlay) return;
                guestAddOverlay.style.display = 'none'; // Force hide
                guestAddOverlay.classList.remove('is-open');
                guestAddOverlay.setAttribute('hidden', '');
                document.body.classList.remove('guest-action-open');
                guestAddForm?.reset();

                document.querySelectorAll('.upload-preview').forEach(img => {
                    img.src = '';
                    img.style.display = 'none';
                });
                document.querySelectorAll('.upload-placeholder').forEach(ph => {
                    ph.style.display = 'flex';
                });
            }

            btnAddGuest?.addEventListener('click', function(e) {
                e.preventDefault();
                openGuestAddModal();
            });

            guestAddClose?.addEventListener('click', closeGuestAddModal);
            guestAddCancel?.addEventListener('click', closeGuestAddModal);
            guestAddOverlay?.addEventListener('click', function (e) {
                if (e.target === guestAddOverlay) closeGuestAddModal();
            });

            document.querySelectorAll('.admin-guest-upload-area input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const area = this.closest('.admin-guest-upload-area');
                    const placeholder = area.querySelector('.upload-placeholder');
                    const previewImg = area.querySelector('.upload-preview');

                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (previewImg) {
                                previewImg.src = e.target.result;
                                previewImg.style.display = 'block';
                            }
                            if (placeholder) placeholder.style.display = 'none'; 
                        }
                        reader.readAsDataURL(this.files[0]);
                    } else {
                        if (previewImg) { previewImg.src = ''; previewImg.style.display = 'none'; }
                        if (placeholder) placeholder.style.display = 'flex';
                    }
                });
            });

            guestAddSubmit?.addEventListener('click', function () {
                const firstName = (guestFirstName?.value || '').trim();
                const gender    = guestGender?.value || '';

                if (!firstName) { guestFirstName?.focus(); return; }
                if (!gender) { guestGender?.focus(); return; }

                if (guestCustomCode) {
                    const year = new Date().getFullYear();
                    const randomString = Date.now().toString().slice(-6);
                    guestCustomCode.value = `GST-${year}-${randomString}`;
                }
                guestAddForm?.submit();
            });

        
            // ====================================================================
            // 2. CHECK-IN / CHECK-OUT MODAL 
            // ====================================================================
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
            const guestCheckoutDropdown = document.getElementById('guestCheckoutDropdown');
            const guestActionSearchLabel = document.getElementById('guestActionSearchLabel');

            let currentGuestAction = 'checkin';
            const guestActionTitles = { checkin: 'Guest Check-in', checkout: 'Guest Check-out' };

            function showGuestActionSearchStep() {
                if (guestActionStepSearch) guestActionStepSearch.style.display = 'block';
                guestActionStepSearch?.removeAttribute('hidden');
                guestActionStepCheckin?.setAttribute('hidden', '');
                guestActionStepCheckout?.setAttribute('hidden', '');
                if (guestActionStepCheckin) guestActionStepCheckin.style.display = 'none';
                if (guestActionStepCheckout) guestActionStepCheckout.style.display = 'none';
                guestActionModal?.classList.remove('is-form-step', 'is-checkout-step');
                guestActionTitle?.removeAttribute('hidden');

                // Toggle input vs dropdown based on current action
                if (currentGuestAction === 'checkout') {
                    if (guestBookingId) guestBookingId.style.display = 'none';
                    if (guestCheckoutDropdown) { guestCheckoutDropdown.style.display = 'block'; guestCheckoutDropdown.value = ''; }
                    if (guestActionSearchLabel) guestActionSearchLabel.textContent = 'Pilih Reservasi';
                } else {
                    if (guestBookingId) guestBookingId.style.display = 'block';
                    if (guestCheckoutDropdown) guestCheckoutDropdown.style.display = 'none';
                    if (guestActionSearchLabel) guestActionSearchLabel.textContent = 'Input Booking ID';
                }
            }

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
                    if(adminTabIdCard) adminTabIdCard.style.display = 'none';
                    adminTabDeposit?.removeAttribute('hidden');
                    if(adminTabDeposit) adminTabDeposit.style.display = 'block';
                } else {
                    adminTabIdCard?.removeAttribute('hidden');
                    if(adminTabIdCard) adminTabIdCard.style.display = 'block';
                    adminTabDeposit?.setAttribute('hidden', '');
                    if(adminTabDeposit) adminTabDeposit.style.display = 'none';
                }
            }

            adminGuestTabs.forEach(tab => tab.addEventListener('click', () => setAdminGuestTab(tab.dataset.tab)));

            function showGuestActionCheckinStep(bookingId, guestData) {
                setAdminGuestTab('id-card');
                const bookingRefEl = document.getElementById('guestActionBookingRef');
                const guestRefEl = document.getElementById('guestActionGuestCodeRef');
                if (bookingRefEl) bookingRefEl.textContent = guestData ? (guestData.booking_code || '-') : bookingId;
                if (guestRefEl) guestRefEl.textContent = guestData ? (guestData.guest_code || '-') : '-';
                
                // Isi form dengan data guest yang sudah ada
                if (guestData) {
                    const set = (id, val) => { const el = document.getElementById(id); if (el) el.value = val ?? ''; };
                    set('admin_first_name',      guestData.first_name);
                    set('admin_last_name',       guestData.last_name);
                    set('admin_email',           guestData.email);
                    set('admin_phone',           guestData.phone);
                    set('admin_age',             guestData.age);
                    set('admin_occupation',      guestData.occupation);
                    set('admin_country',         guestData.country);
                    set('admin_city',            guestData.city);
                    set('admin_self_description',guestData.self_description);
                    set('admin_personal_notes',  guestData.personal_notes);
                    set('admin_id_number',       guestData.id_number);
                    set('admin_address',         guestData.address);
                    set('admin_deposit_amount',  guestData.deposit_amount);
                    set('admin_deposit_notes',   guestData.deposit_notes);

                    // Preview Profile Picture dari DB
                    const profileImg = document.getElementById('admin_profile_picture_preview');
                    const profileArea = profileImg?.closest('.admin-guest-upload-area');
                    const profilePlaceholder = profileArea?.querySelector('.upload-placeholder');
                    if (profileImg && guestData.profile_picture) {
                        profileImg.src = guestData.profile_picture;
                        profileImg.style.display = 'block';
                        if (profilePlaceholder) profilePlaceholder.style.display = 'none';
                    } else {
                        if (profileImg) { profileImg.src = ''; profileImg.style.display = 'none'; }
                        if (profilePlaceholder) profilePlaceholder.style.display = 'flex';
                    }

                    // Preview Card Photo dari DB
                    const cardImg = document.getElementById('admin_card_photo_preview');
                    const cardArea = cardImg?.closest('.admin-guest-upload-area');
                    const cardPlaceholder = cardArea?.querySelector('.upload-placeholder');
                    if (cardImg && guestData.id_card_photo) {
                        cardImg.src = guestData.id_card_photo;
                        cardImg.style.display = 'block';
                        if (cardPlaceholder) cardPlaceholder.style.display = 'none';
                    } else {
                        if (cardImg) { cardImg.src = ''; cardImg.style.display = 'none'; }
                        if (cardPlaceholder) cardPlaceholder.style.display = 'flex';
                    }
                }
                
                guestActionStepSearch?.setAttribute('hidden', '');
                if (guestActionStepSearch) guestActionStepSearch.style.display = 'none';
                
                guestActionStepCheckout?.setAttribute('hidden', '');
                if (guestActionStepCheckout) guestActionStepCheckout.style.display = 'none';
                
                guestActionStepCheckin?.removeAttribute('hidden');
                if (guestActionStepCheckin) guestActionStepCheckin.style.display = 'flex';
                
                guestActionModal?.classList.add('is-form-step');
                guestActionModal?.classList.remove('is-checkout-step');
                guestActionTitle?.setAttribute('hidden', '');
                document.getElementById('admin_first_name')?.focus();
            }

            let checkoutGuestData = null;

            function showGuestActionCheckoutStep(bookingId) {
                resetCheckoutForm();
                const checkoutBookingCode = document.getElementById('checkout_booking_code');
                if(checkoutBookingCode) checkoutBookingCode.value = bookingId;

                const checkoutBookingRef = document.getElementById('checkoutBookingRef');
                if(checkoutBookingRef) checkoutBookingRef.textContent = bookingId;

                // Fill Guest Code
                const checkoutGuestCodeEl = document.getElementById('checkoutGuestCode');
                if(checkoutGuestCodeEl && checkoutGuestData) {
                    checkoutGuestCodeEl.textContent = checkoutGuestData.guest_code || '—';
                }

                if (checkoutGuestData) {
                    CHECKOUT_DEPOSIT = Number(checkoutGuestData.deposit_amount) || 0;

                    // Tampilkan staying fee
                    const stayingFeeEl = document.getElementById('checkoutStayingFee');
                    if(stayingFeeEl) stayingFeeEl.textContent = 'IDR ' + Number(checkoutGuestData.total_price).toLocaleString('id-ID');

                    // Tampilkan deposit info & catatan deposit jika ada
                    const depositInfoEl = document.getElementById('checkoutDepositInfo');
                    const depositNotesEl = document.getElementById('checkoutDepositNotesDisplay');
                    if (CHECKOUT_DEPOSIT > 0) {
                        if (depositInfoEl) depositInfoEl.style.display = 'block';
                        if (depositNotesEl) depositNotesEl.textContent = checkoutGuestData.deposit_notes || 'No notes';
                    } else {
                        if (depositInfoEl) depositInfoEl.style.display = 'none';
                    }

                    // Tampilkan baris Deposit di summary jika > 0
                    const depositRowEl = document.getElementById('checkoutDepositRow');
                    const depositValEl = document.getElementById('checkoutDeposit');
                    if (CHECKOUT_DEPOSIT > 0) {
                        if (depositRowEl) depositRowEl.style.display = 'flex';
                        if (depositValEl) depositValEl.textContent = 'IDR ' + CHECKOUT_DEPOSIT.toLocaleString('id-ID');
                    } else {
                        if (depositRowEl) depositRowEl.style.display = 'none';
                    }
                }

                updateCheckoutSummary();

                guestActionStepSearch?.setAttribute('hidden', '');
                if (guestActionStepSearch) guestActionStepSearch.style.display = 'none';
                
                guestActionStepCheckin?.setAttribute('hidden', '');
                if (guestActionStepCheckin) guestActionStepCheckin.style.display = 'none';
                
                guestActionStepCheckout?.removeAttribute('hidden');
                if (guestActionStepCheckout) guestActionStepCheckout.style.display = 'flex';
                
                guestActionModal?.classList.add('is-form-step', 'is-checkout-step');
                if (guestActionTitle) {
                    guestActionTitle.removeAttribute('hidden');
                    guestActionTitle.textContent = guestActionTitles.checkout;
                }
                document.getElementById('checkout_notes')?.focus();
            }

            function openGuestActionModal(action) {
                if (!guestActionOverlay || !guestActionTitle) return;
                
                if(typeof closeGuestAddModal === 'function') closeGuestAddModal();

                currentGuestAction = action || 'checkin';
                guestActionTitle.textContent = guestActionTitles[currentGuestAction] || 'Guest Check-in';
                guestActionTitle.removeAttribute('hidden');
                showGuestActionSearchStep();
                
                // --- PAKSA TAMPIL DI SINI ---
                guestActionOverlay.style.display = "flex";
                guestActionOverlay.style.opacity = "1";
                guestActionOverlay.style.visibility = "visible";
                // ----------------------------
                
                guestActionOverlay.removeAttribute('hidden');
                guestActionOverlay.classList.add('is-open');
                document.body.classList.add('guest-action-open');
                document.documentElement.classList.add('guest-action-open');

                // Toggle input vs dropdown for checkout
                if (currentGuestAction === 'checkout') {
                    if (guestCheckoutDropdown) { guestCheckoutDropdown.value = ''; guestCheckoutDropdown.focus(); }
                } else {
                    if (guestBookingId) { guestBookingId.value = ''; guestBookingId.focus(); }
                }
            }

            function closeGuestActionModal() {
                checkoutGuestData = null;
                if (!guestActionOverlay) return;
                
                // --- PAKSA HILANG DI SINI ---
                guestActionOverlay.style.display = "none";
                // ----------------------------
                
                guestActionOverlay.classList.remove('is-open');
                guestActionOverlay.setAttribute('hidden', '');
                document.body.classList.remove('guest-action-open');
                document.documentElement.classList.remove('guest-action-open');
                showGuestActionSearchStep();
            }

            function handleGuestActionSearch(overrideBookingId) {
                // For checkout, use the dropdown value; for check-in, use the text input
                const bookingId = overrideBookingId || (currentGuestAction === 'checkout' 
                    ? guestCheckoutDropdown?.value.trim()
                    : guestBookingId?.value.trim());
                if (!bookingId) { 
                    if (currentGuestAction === 'checkout') guestCheckoutDropdown?.focus();
                    else guestBookingId?.focus();
                    return; 
                }

                const searchBtn = guestActionSearchBtn;
                if (searchBtn) {
                    searchBtn.disabled = true;
                    searchBtn.textContent = 'Searching...';
                }

                const resetSearchBtn = () => {
                    if (searchBtn) {
                        searchBtn.disabled = false;
                        searchBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><span>Search</span>';
                    }
                };

                fetch('/admin/manage-guests/search/' + encodeURIComponent(bookingId))
                    .then(r => r.json())
                    .then(data => {
                        resetSearchBtn();
                        if (!data.found) { alert(data.message || 'Booking ID tidak ditemukan.'); return; }

                        if (currentGuestAction === 'checkin') {
                            showGuestActionCheckinStep(bookingId, data.guest);
                        } else {
                            checkoutGuestData = data.guest;
                            showGuestActionCheckoutStep(bookingId);
                        }
                    })
                    .catch(() => {
                        resetSearchBtn();
                        alert('Gagal mencari booking.');
                    });
            }

            guestActionClose?.addEventListener('click', closeGuestActionModal);
            guestActionFormBack?.addEventListener('click', showGuestActionSearchStep);
            guestCheckoutFormBack?.addEventListener('click', showGuestActionSearchStep);
            
            guestActionFormDone?.addEventListener('click', function () {
                const form = document.getElementById('adminGuestCheckinForm');
                if (!form) return;

                const bookingCode = document.getElementById('guestActionBookingRef')?.textContent.trim();
                if (!bookingCode) { alert('Booking Code tidak ditemukan.'); return; }

                const btn = guestActionFormDone;
                btn.disabled = true;
                btn.textContent = 'Processing...';

                const formData = new FormData(form);
                formData.append('booking_code', bookingCode);

                fetch('/admin/manage-guests/checkin', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: formData
                })
                .then(async r => {
                    const isJson = r.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await r.json() : null;
                    if (!r.ok) {
                        throw new Error(data?.message || 'Server error ' + r.status);
                    }
                    return data;
                })
                .then(data => {
                    if (data && data.success) {
                        closeGuestActionModal();
                        location.reload();
                    } else {
                        alert('Gagal check-in: ' + (data?.message || 'Unknown error'));
                        btn.disabled = false;
                        btn.textContent = 'Done';
                    }
                })
                .catch((err) => {
                    alert('Gagal check-in: ' + err.message);
                    btn.disabled = false;
                    btn.textContent = 'Done';
                });
            });
            
            guestCheckoutFormDone?.addEventListener('click', function () {
                const form = document.getElementById('adminGuestCheckoutForm');
                const bookingCode = document.getElementById('checkout_booking_code')?.value;
                const status = document.getElementById('checkout_status')?.value;
                const notes = document.getElementById('checkout_notes')?.value;

                if (!bookingCode) { alert('Booking ID tidak ditemukan.'); return; }

                const btn = guestCheckoutFormDone;
                btn.disabled = true;
                btn.textContent = 'Processing...';

                // Ambil daftar checkout charges
                const charges = [];
                checkoutChargesList?.querySelectorAll('.admin-checkout-charge-item').forEach(el => {
                    charges.push({
                        description: el.dataset.desc || '',
                        amount: parseInt(el.dataset.amount, 10) || 0
                    });
                });

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ 
                        booking_code: bookingCode, 
                        status: status === 'blacklist' ? 'blacklist' : 'safe', 
                        checkout_notes: notes,
                        extra_charges: charges
                    })
                })
                .then(async r => {
                    const isJson = r.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await r.json() : null;
                    if (!r.ok) {
                        throw new Error(data?.message || 'Server error ' + r.status);
                    }
                    return data;
                })
                .then(data => {
                    if (data && data.success) { 
                        closeGuestActionModal(); 
                        location.reload(); 
                    } else { 
                        alert('Gagal: ' + (data?.message || 'Unknown error')); 
                        btn.disabled = false; 
                        btn.textContent = 'Done'; 
                    }
                })
                .catch((err) => { 
                    alert('Gagal: ' + err.message); 
                    btn.disabled = false; 
                    btn.textContent = 'Done'; 
                });
            });

            guestActionSearchBtn?.addEventListener('click', () => handleGuestActionSearch());
            guestBookingId?.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); handleGuestActionSearch(); } });
            guestCheckoutDropdown?.addEventListener('change', function() {
                if (this.value) handleGuestActionSearch(this.value);
            });
            guestActionOverlay?.addEventListener('click', e => { if (e.target === guestActionOverlay) closeGuestActionModal(); });

            // ── Checkout charges ──────────────────────────────────────────
            const checkoutChargesList   = document.getElementById('checkoutChargesList');
            const checkoutChargeDesc    = document.getElementById('checkout_charge_desc');
            const checkoutChargeNominal = document.getElementById('checkout_charge_nominal');
            const checkoutAddCharge     = document.getElementById('checkoutAddCharge');
            const checkoutRefunded      = document.getElementById('checkoutRefunded');
            const checkoutStatus        = document.getElementById('checkout_status');
            const checkoutNotes         = document.getElementById('checkout_notes');
            let CHECKOUT_DEPOSIT        = 0;

            const formatIdr    = amount => 'IDR ' + Math.max(0, Math.round(amount)).toLocaleString('id-ID');
            const parseNominal = value  => { const d = String(value).replace(/\D/g, ''); return d ? parseInt(d, 10) : 0; };

            function getCheckoutExtraTotal() {
                let t = 0;
                checkoutChargesList?.querySelectorAll('.admin-checkout-charge-item').forEach(el => { t += parseInt(el.dataset.amount, 10) || 0; });
                return t;
            }

            function updateCheckoutSummary() {
                const extraTotal = getCheckoutExtraTotal();
                
                // Update Extra Charges Row
                const extraRowEl = document.getElementById('checkoutExtraRow');
                const extraTotalEl = document.getElementById('checkoutExtraTotal');
                if (extraTotal > 0) {
                    if (extraRowEl) extraRowEl.style.display = 'flex';
                    if (extraTotalEl) extraTotalEl.textContent = 'IDR ' + extraTotal.toLocaleString('id-ID');
                } else {
                    if (extraRowEl) extraRowEl.style.display = 'none';
                }

                // Kalkulasi Refund dan Additional
                let refunded = 0;
                let additional = 0;

                if (CHECKOUT_DEPOSIT > 0) {
                    if (extraTotal <= CHECKOUT_DEPOSIT) {
                        refunded = CHECKOUT_DEPOSIT - extraTotal;
                        additional = 0;
                    } else {
                        refunded = 0;
                        additional = extraTotal - CHECKOUT_DEPOSIT;
                    }
                } else {
                    refunded = 0;
                    additional = extraTotal; // Kalau tidak ada deposit, semua biaya ekstra masuk ke additional
                }

                // Update Refunded Row (hanya jika ada deposit)
                const refundedRowEl = document.getElementById('checkoutRefundedRow');
                const refundedEl = document.getElementById('checkoutRefunded');
                if (CHECKOUT_DEPOSIT > 0) {
                    if (refundedRowEl) refundedRowEl.style.display = 'flex';
                    if (refundedEl) refundedEl.textContent = 'IDR ' + refunded.toLocaleString('id-ID');
                } else {
                    if (refundedRowEl) refundedRowEl.style.display = 'none';
                }

                // Update Additional Charge Row
                const additionalRowEl = document.getElementById('checkoutAdditionalRow');
                const additionalEl = document.getElementById('checkoutAdditional');
                if (additional > 0) {
                    if (additionalRowEl) additionalRowEl.style.display = 'flex';
                    if (additionalEl) additionalEl.textContent = 'IDR ' + additional.toLocaleString('id-ID');
                } else {
                    if (additionalRowEl) additionalRowEl.style.display = 'none';
                }
            }

            function resetCheckoutForm() {
                if (checkoutChargesList) checkoutChargesList.innerHTML = '';
                if (checkoutChargeDesc)    checkoutChargeDesc.value = '';
                if (checkoutChargeNominal) checkoutChargeNominal.value = '';
                if (checkoutNotes)  checkoutNotes.value = '';
                if (checkoutStatus) { checkoutStatus.value = 'safe'; checkoutStatus.classList.remove('is-blacklist'); }
                updateCheckoutSummary();
            }

            function addCheckoutCharge(desc, amount) {
                if (!checkoutChargesList || !desc || amount <= 0) return;
                const li = document.createElement('li');
                li.className = 'admin-checkout-charge-item';
                li.dataset.amount = String(amount);
                li.dataset.desc = desc;

                const main   = document.createElement('div'); main.className = 'admin-checkout-charge-main';
                const dSpan  = document.createElement('span'); dSpan.className = 'admin-checkout-charge-desc';   dSpan.textContent = desc;
                const aSpan  = document.createElement('span'); aSpan.className = 'admin-checkout-charge-amount'; aSpan.textContent = '-IDR ' + amount.toLocaleString('id-ID');
                const rmBtn  = document.createElement('button');
                rmBtn.type = 'button'; rmBtn.className = 'admin-checkout-charge-remove';
                rmBtn.innerHTML = '<span aria-hidden="true">✕</span> Close';
                rmBtn.setAttribute('aria-label', 'Remove ' + desc);
                rmBtn.addEventListener('click', () => { li.remove(); updateCheckoutSummary(); });

                main.append(dSpan, aSpan);
                li.append(main, rmBtn);
                checkoutChargesList.appendChild(li);
                updateCheckoutSummary();
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

            document.querySelectorAll('.admin-guest-upload-area input[type="file"]').forEach(input => {
                input.addEventListener('change', () => {
                    const hint = input.closest('.admin-guest-upload-area')?.querySelector('.admin-guest-upload-hint');
                    if (hint && input.files?.[0]) hint.textContent = input.files[0].name;
                });
            });

            // ── Global Escape key ─────────────────────────────────────────
            window.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                
                if (typeof guestAddOverlay !== 'undefined' && guestAddOverlay?.classList.contains('is-open')) { 
                    if(typeof closeGuestAddModal === 'function') closeGuestAddModal(); 
                    return; 
                }
                
                if (typeof guestActionOverlay !== 'undefined' && guestActionOverlay?.classList.contains('is-open')) {
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

            if (trendCtx && typeof Chart !== 'undefined') {
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

            document.getElementById('trendDropdown')?.addEventListener('change', function () {
                if (!trendChart) return;
                if (this.value === 'weeks') {
                    trendChart.data.labels  = ['This Week'];
                    trendChart.data.datasets[0].data = [ (window.guestTrendData || []).reduce((a, b) => a + b, 0) ];
                } else {
                    trendChart.data.labels  = window.guestTrendLabels || ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                    trendChart.data.datasets[0].data = window.guestTrendData || [0,0,0,0,0,0,0];
                }
                trendChart.options.scales.y.suggestedMax = Math.max(10, ...trendChart.data.datasets[0].data) + 2;
                trendChart.update();
            });

            // ====================================================================
            // 3. EVENT LISTENER CHECK-IN / CHECK-OUT
            // ====================================================================
            document.querySelectorAll('[data-guest-action]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault(); 
                    const action = btn.getAttribute('data-guest-action');
                    if (action === 'checkin' || action === 'checkout') {
                        openGuestActionModal(action);
                    }
                });
            });

            // ====================================================================
            // 4. EDIT RESERVATION (iframe modal)
            // ====================================================================
            const guestEditOverlay = document.getElementById('guestEditModalOverlay');
            const guestEditFrame   = document.getElementById('guestEditModalFrame');

            // Inject overlay CSS
            (function() {
                const s = document.createElement('style');
                s.textContent = `
                    .guest-edit-modal-overlay {
                        position: fixed; inset: 0; z-index: 2000;
                        display: flex; justify-content: center; align-items: center;
                        padding: 20px; background: transparent;
                        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
                    }
                    .guest-edit-modal-overlay[hidden] { display: none !important; }
                    .guest-edit-modal-frame {
                        width: min(100%, 1100px); height: min(90vh, 920px);
                        border: 0; border-radius: 12px; overflow: hidden;
                        display: block; background: transparent;
                        box-shadow: 0 30px 60px rgba(0,0,0,0.28);
                    }
                `;
                document.head.appendChild(s);
            })();

            function openGuestEditModal(url) {
                if (!guestEditOverlay || !guestEditFrame || !url) return;
                guestEditFrame.src = url;
                guestEditOverlay.removeAttribute('hidden');
                guestEditOverlay.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
            }

            function closeGuestEditModal() {
                if (!guestEditOverlay || !guestEditFrame) return;
                guestEditOverlay.setAttribute('hidden', '');
                guestEditOverlay.setAttribute('aria-hidden', 'true');
                guestEditFrame.src = '';
                document.body.classList.remove('modal-open');
            }

            // Listen for postMessage from the iframe when edit is saved
            window.addEventListener('message', function(event) {
                if (event.origin !== window.location.origin) return;
                if (event.data && event.data.type === 'close-reservation-modal') {
                    closeGuestEditModal();
                    if (event.data.success && event.data.message) {
                        try { alert(event.data.message); } catch(e) {}
                    }
                    if (event.data.success) window.location.reload();
                }
            });

            // Click backdrop to close
            guestEditOverlay?.addEventListener('click', function(e) {
                if (e.target === guestEditOverlay) closeGuestEditModal();
            });

            // Wire Edit buttons — dua jalur:
            //   a) data-edit-url ada  → buka booking iframe (ada booking)
            //   b) data-edit-guest ada → buka modal edit data guest (tidak ada booking)
            document.querySelectorAll('[data-guest-edit-action]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const bookingUrl  = this.getAttribute('data-edit-url');
                    const guestRaw    = this.getAttribute('data-edit-guest');
                    const updateUrl   = this.getAttribute('data-update-url');

                    if (bookingUrl) {
                        // Ada booking → buka iframe edit reservation
                        openGuestEditModal(bookingUrl);
                    } else if (guestRaw) {
                        // Tidak ada booking → buka modal edit data guest
                        try {
                            const guestData = JSON.parse(guestRaw);
                            openGuestDataEditModal(guestData, updateUrl);
                        } catch(e) {
                            console.error('Failed to parse guest data:', e);
                        }
                    }
                });
            });

            // ====================================================================
            // 5. DELETE GUEST
            // ====================================================================
            const csrfTokenGuest = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            document.querySelectorAll('[data-guest-delete-action]').forEach(btn => {
                btn.addEventListener('click', async function() {
                    const guestId   = this.getAttribute('data-guest-id');
                    const guestName = this.getAttribute('data-guest-name');
                    if (!guestId) return;

                    if (!confirm(`Yakin ingin menghapus guest "${guestName}" beserta semua booking terkait? Aksi ini tidak bisa dibatalkan.`)) return;

                    this.disabled = true;
                    this.innerHTML = '...';

                    try {
                        const response = await fetch(`/admin/manage-guests/${guestId}`, {
                            method: 'DELETE',
                            credentials: 'same-origin',
                            headers: {
                                'X-CSRF-TOKEN': csrfTokenGuest,
                                'Accept': 'application/json',
                            },
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            alert(data.message || 'Guest berhasil dihapus.');
                            window.location.reload();
                        } else {
                            throw new Error(data.message || 'Gagal menghapus guest.');
                        }
                    } catch(err) {
                        alert('Error: ' + (err.message || 'Gagal menghapus guest.'));
                        this.disabled = false;
                        this.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>';
                    }
                });
            });

            // ====================================================================
            // 6. EDIT GUEST DATA MODAL (untuk guest tanpa booking)
            // ====================================================================
            const gdeOverlay    = document.getElementById('guestDataEditOverlay');
            const gdeForm       = document.getElementById('guestDataEditForm');
            const gdeSubmitBtn  = document.getElementById('guestDataEditSubmit');
            const gdeCancelBtn  = document.getElementById('guestDataEditCancel');
            const gdeCloseBtn   = document.getElementById('guestDataEditClose');

            function openGuestDataEditModal(guest, updateUrl) {
                if (!gdeOverlay || !gdeForm) return;

                // Prefill semua field
                document.getElementById('gde_guest_id').value      = guest.id || '';
                document.getElementById('gde_update_url').value    = updateUrl || '';
                document.getElementById('gde_first_name').value    = guest.first_name || '';
                document.getElementById('gde_last_name').value     = guest.last_name  || '';
                document.getElementById('gde_age').value           = guest.age        || '';
                document.getElementById('gde_email').value         = guest.email      || '';
                document.getElementById('gde_phone').value         = guest.phone      || '';
                document.getElementById('gde_occupation').value    = guest.occupation || '';
                document.getElementById('gde_id_number').value     = guest.id_number  || '';
                document.getElementById('gde_city').value          = guest.city       || '';
                document.getElementById('gde_country').value       = guest.country    || '';
                document.getElementById('gde_self_description').value = guest.self_description || '';

                // Gender select
                const genderEl = document.getElementById('gde_gender');
                if (genderEl) genderEl.value = guest.gender || '';

                // Preview foto yang sudah ada di database
                const profilePreview = document.getElementById('gde_profile_preview');
                const profilePlaceholder = profilePreview?.previousElementSibling;
                if (guest.profile_picture && profilePreview) {
                    profilePreview.src = guest.profile_picture;
                    profilePreview.style.display = 'block';
                    if (profilePlaceholder) profilePlaceholder.style.display = 'none';
                } else if (profilePreview) {
                    profilePreview.src = '';
                    profilePreview.style.display = 'none';
                    if (profilePlaceholder) profilePlaceholder.style.display = 'flex';
                }

                const idcardPreview = document.getElementById('gde_idcard_preview');
                const idcardPlaceholder = idcardPreview?.previousElementSibling;
                if (guest.id_card_photo && idcardPreview) {
                    idcardPreview.src = guest.id_card_photo;
                    idcardPreview.style.display = 'block';
                    if (idcardPlaceholder) idcardPlaceholder.style.display = 'none';
                } else if (idcardPreview) {
                    idcardPreview.src = '';
                    idcardPreview.style.display = 'none';
                    if (idcardPlaceholder) idcardPlaceholder.style.display = 'flex';
                }

                // Reset file inputs
                document.getElementById('gde_profile_picture').value = '';
                document.getElementById('gde_id_card_photo').value   = '';

                gdeOverlay.removeAttribute('hidden');
                document.body.classList.add('modal-open');
                document.getElementById('gde_first_name').focus();
            }

            function closeGuestDataEditModal() {
                if (!gdeOverlay) return;
                gdeOverlay.setAttribute('hidden', '');
                document.body.classList.remove('modal-open');
            }

            // Close handlers
            gdeCloseBtn?.addEventListener('click', closeGuestDataEditModal);
            gdeCancelBtn?.addEventListener('click', closeGuestDataEditModal);
            gdeOverlay?.addEventListener('click', e => { if (e.target === gdeOverlay) closeGuestDataEditModal(); });

            // Live preview saat pilih file baru di modal edit guest
            document.getElementById('gde_profile_picture')?.addEventListener('change', function() {
                const preview = document.getElementById('gde_profile_preview');
                const placeholder = preview?.previousElementSibling;
                if (this.files && this.files[0] && preview) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        if (placeholder) placeholder.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            document.getElementById('gde_id_card_photo')?.addEventListener('change', function() {
                const preview = document.getElementById('gde_idcard_preview');
                const placeholder = preview?.previousElementSibling;
                if (this.files && this.files[0] && preview) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        if (placeholder) placeholder.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Submit AJAX
            gdeSubmitBtn?.addEventListener('click', async function() {
                const updateUrl = document.getElementById('gde_update_url').value;
                if (!updateUrl) return;

                const firstName = document.getElementById('gde_first_name').value.trim();
                if (!firstName) {
                    alert('First name wajib diisi.');
                    document.getElementById('gde_first_name').focus();
                    return;
                }

                gdeSubmitBtn.disabled = true;
                gdeSubmitBtn.textContent = 'Saving...';

                try {
                    const formData = new FormData(gdeForm);
                    // Hapus hidden fields yang tidak perlu dikirim ke controller
                    formData.delete('guest_id');
                    formData.delete('_update_url');

                    const response = await fetch(updateUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': csrfTokenGuest,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        alert(data.message || 'Data guest berhasil diperbarui.');
                        closeGuestDataEditModal();
                        window.location.reload();
                    } else {
                        alert('Gagal: ' + (data.message || 'Harap periksa kembali isian form.'));
                    }
                } catch(err) {
                    alert('Terjadi kesalahan jaringan: ' + (err.message || ''));
                } finally {
                    gdeSubmitBtn.disabled = false;
                    gdeSubmitBtn.textContent = 'Save Changes';
                }
            });


            // Auto-open modal Add Guest jika ada error validasi dari Laravel
            @if ($errors->any())
                openGuestAddModal();
            @endif

        });
    </script>
    
</body>
</html>