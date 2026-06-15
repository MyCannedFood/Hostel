@php
    $admin = auth('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Experience Management - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/admin-experience.css', 'resources/js/app.js'])
</head>
<body>
    <div class="dashboard-container">
        <x-admin_sidenavbar />
        <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>

        <main class="main-content">
            <header class="header">
                <button type="button" class="hamburger mobile-only" id="sidebarToggle"
                    aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
                <div class="header-actions">
                    <img src="{{ asset('images/admin/img_button_trailing.svg') }}" alt="Menu" width="34" height="28">
                    <a href="{{ route('admin.notification.index') }}">
                        <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    </a>
                    <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>

            <div class="content-area">

                {{-- Page Header --}}
                <div class="exp-page-header">
                    <div>
                        <h1 class="exp-page-title">Experience Management</h1>
                        <p class="exp-page-subtitle">Curating moments of zen for the mindful traveler</p>
                    </div>
                    <div class="exp-header-actions">
                        <button class="exp-btn-outline-promo" onclick="openPromoModal()">+ Promo Code</button>
                        <button class="exp-btn-primary" onclick="openExpModal()">+ Add New Experience</button>
                    </div>
                </div>

                {{-- Guest Check-In --}}
                <div class="exp-card">
                    <h2 class="exp-card-title">Guest Check-In</h2>
                    <div class="exp-checkin-row">
                        <button class="exp-btn-scan">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                                <path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M20 14h.01M20 17h.01M20 20h.01M17 20h.01M14 20h.01"/>
                            </svg>
                            Scan Ticket
                        </button>
                        <div class="exp-checkin-manual">
                            <label class="exp-manual-label">MANUAL TICKET ID / CODE</label>
                            <div class="exp-checkin-input-row">
                                <input type="text" class="exp-input" id="manualTicketInput" placeholder="Enter code...">
                                <button type="button" class="exp-btn-checkin" onclick="verifyManualTicket()">Check In</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Experience List --}}
                <div class="exp-card">
                    <div class="exp-filter-row">
                        <div class="exp-filter-left">
                            <span class="exp-filter-label">Filter by:</span>
                            <select class="exp-select" id="categoryFilter" onchange="filterExperiences()">
                                <option value="">All Categories</option>
                                <option value="Nature">Nature</option>
                                <option value="Culture">Culture</option>
                                <option value="Wellness">Wellness</option>
                            </select>
                            <div class="exp-status-tabs">
                                <span class="exp-status-label">Status:</span>
                                <button class="exp-tab active" data-status="">All</button>
                                <button class="exp-tab" data-status="Active">Active</button>
                                <button class="exp-tab" data-status="Inactive">Inactive</button>
                            </div>
                        </div>
                        <span class="exp-showing-label">SHOWING <span id="expCount">{{ $experiences->count() }}</span> EXPERIENCES</span>
                    </div>

                    <div class="exp-search-row">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" class="exp-search-input" id="expSearch" placeholder="Search experiences..." oninput="filterExperiences()">
                    </div>

                    <table class="exp-table">
                        <thead>
                            <tr>
                                <th>Experience Name</th>
                                <th>Category</th>
                                <th>Price (IDR)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="expTableBody">
                            @forelse($experiences as $exp)
                            <tr data-category="{{ $exp->category }}" data-status="{{ $exp->status }}" data-name="{{ strtolower($exp->name) }}">
                                <td>
                                    <div class="exp-name-cell">
                                        @if($exp->cover_image)
                                            <img src="{{ asset($exp->cover_image) }}" alt="{{ $exp->name }}" class="exp-thumb">
                                        @else
                                            <div class="exp-thumb" style="background:rgba(26,61,10,0.08);display:flex;align-items:center;justify-content:center;">
                                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="rgba(26,61,10,0.3)" stroke-width="2">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                                    <polyline points="21 15 16 10 5 21"/>
                                                </svg>
                                            </div>
                                        @endif
                                        {{ $exp->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="exp-badge exp-badge-{{ strtolower($exp->category) }}">{{ $exp->category }}</span>
                                </td>
                                <td class="exp-price">Rp {{ number_format($exp->price, 0, ',', '.') }}</td>
                                <td>
                                    <label class="exp-toggle">
                                        <input type="checkbox" {{ $exp->status === 'Active' ? 'checked' : '' }}
                                            onchange="toggleExperienceStatus({{ $exp->id }}, this)">
                                        <span class="exp-toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="exp-actions">
                                        <button class="exp-action-btn edit" onclick="openEditExpModal({{ $exp->id }})">
                                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="exp-action-btn delete" onclick="deleteExperience({{ $exp->id }}, this)">
                                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="noExpRow">
                                <td colspan="5" style="text-align:center;padding:24px;color:rgba(26,61,10,0.4);font-size:13px;">
                                    No experiences yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="exp-last-updated">
                        Last updated: {{ $experiences->first()?->updated_at?->format('M d, Y • h:i A') ?? 'No data' }}
                    </div>
                </div>

                {{-- Guest Registry --}}
                <div class="exp-card">
                    <div class="exp-registry-header">
                        <h2 class="exp-card-title">Guest Registry</h2>
                        <button type="button" class="exp-btn-primary" onclick="openAddGuestModal()">+ Add New Guest</button>
                    </div>

                    <table class="exp-table">
                        <thead>
                            <tr>
                                <th>Guest Name</th>
                                <th>Experience</th>
                                <th>Date & Time</th>
                                <th>Ticket ID</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td class="exp-guest-name">{{ $booking->guest_name }}</td>
                                <td>{{ $booking->experience->name ?? '-' }}</td>
                                <td class="exp-datetime">
                                    {{ $booking->scheduled_date->format('M d, Y') }} • {{ $booking->time_slot }}
                                </td>
                                <td class="exp-ticket">#{{ $booking->ticket_id }}</td>
                                <td>
                                    <span class="exp-status-badge {{ $booking->status === 'Checked In' ? 'checked-in' : 'awaiting' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td>
                                    <button class="exp-action-btn edit" onclick="openEditGuestModal({{ $booking->id }})">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:24px;color:rgba(26,61,10,0.4);font-size:13px;">
                                    No bookings yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Promo Codes --}}
                <div class="exp-card">
                    <div class="exp-registry-header">
                        <h2 class="exp-card-title">Promo Codes</h2>
                        <button type="button" class="exp-btn-primary" onclick="openPromoModal()">+ Promo Code</button>
                    </div>

                    <table class="exp-table promo-table">
                        <thead>
                            <tr>
                                <th>Promo Code</th>
                                <th>Discount</th>
                                <th>Validity Period</th>
                                <th>Quota</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="promoTableBody">
                            {{-- Rendered by JS --}}
                        </tbody>
                    </table>

                    <div class="promo-table-footer">
                        <span class="promo-count-label" id="promoCountLabel">Showing 0 promo codes</span>
                        <div class="promo-pagination">
                            <button class="promo-page-btn" onclick="promoChangePage(-1)">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="15 18 9 12 15 6"/>
                                </svg>
                            </button>
                            <button class="promo-page-btn" onclick="promoChangePage(1)">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- Modal Add / Edit Experience               --}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="exp-modal-overlay" id="addExpModal">
        <div class="exp-modal">
            <div class="exp-modal-header">
                <div>
                    <h2 class="exp-modal-title">Add New Experience</h2>
                    <p class="exp-modal-subtitle">Fill in the details to curate a new guest journey.</p>
                </div>
                <button class="exp-modal-close" onclick="closeExpModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <div class="exp-modal-body">
                {{-- Basic Information --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">BASIC INFORMATION</p>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Name (EN)</label>
                            <input type="text" class="exp-modal-input" id="expNameEn" placeholder="e.g. Sacred Monkey Forest Dawn Walk">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Name (ID)</label>
                            <input type="text" class="exp-modal-input" id="expNameId" placeholder="Misal: Jalan Fajar di Hutan Monyet Sakral">
                        </div>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Description (EN)</label>
                            <textarea class="exp-modal-input" id="expShortDescEn" rows="2"
                                placeholder="e.g. A soulful journey to the heart of our teak forest..." style="resize:vertical;"></textarea>
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Description (ID)</label>
                            <textarea class="exp-modal-input" id="expShortDescId" rows="2"
                                placeholder="Misal: Perjalanan spiritual ke jantung hutan jati kami..." style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Category</label>
                            <select class="exp-modal-select" id="expCategory">
                                <option value="Wellness">Wellness</option>
                                <option value="Nature">Nature</option>
                                <option value="Culture">Culture</option>
                            </select>
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Price (IDR)</label>
                            <div class="exp-price-input-wrap">
                                <span class="exp-price-prefix">Rp</span>
                                <input type="number" class="exp-modal-input exp-price-input" id="expPrice" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- What's Included --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">WHAT'S INCLUDED</p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Inclusions</label>
                        <p class="exp-field-hint">List key highlights that are included in the price.</p>
                        <div class="exp-inclusion-row">
                            <input type="text" class="exp-modal-input" id="inclusionInput" placeholder="e.g. Traditional Welcome Drink">
                            <button type="button" class="exp-inclusion-add" onclick="addInclusion()">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="exp-inclusion-list" id="inclusionList"></div>
                    </div>
                </div>

                {{-- Session Schedule --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">SESSION SCHEDULE</p>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Daily Time Slots</label>
                            <div class="exp-timeslot-row" id="timeslotList">
                                <div class="exp-timeslot">
                                    <input type="time" class="exp-modal-input exp-time-input" value="09:00">
                                    <span class="exp-time-sep">—</span>
                                    <input type="time" class="exp-modal-input exp-time-input" value="12:00">
                                    <button type="button" class="exp-add-slot-btn" onclick="addTimeSlot()">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="exp-field-hint">Manage up to 3 sessions per day.</p>
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Publication Status</label>
                            <div class="exp-pub-status">
                                <label class="exp-toggle">
                                    <input type="checkbox" id="pubStatusToggle" checked>
                                    <span class="exp-toggle-slider"></span>
                                </label>
                                <span class="exp-pub-label" id="pubStatusLabel">Activate Immediately</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Media & Visuals --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">MEDIA & VISUALS</p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Upload Cover Image</label>
                        <div class="exp-upload-zone" onclick="document.getElementById('expCoverInput').click()">
                            <input type="file" id="expCoverInput" accept="image/*" style="display:none" onchange="previewCover(this)">
                            <div id="expCoverPreview">
                                <svg viewBox="0 0 48 48" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.3">
                                    <rect x="6" y="6" width="36" height="36" rx="4"/>
                                    <circle cx="16" cy="18" r="3"/>
                                    <polyline points="6 34 16 22 24 30 32 20 42 34"/>
                                </svg>
                                <p class="exp-upload-hint">Drag & drop or click to upload</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closeExpModal()">Cancel</button>
                <button class="exp-btn-primary-form" id="expSubmitBtn" onclick="submitExperience()">Add Experience</button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- Modal Scan Ticket                         --}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="exp-modal-overlay" id="scanTicketModal">
        <div class="exp-modal" style="max-width: 350px;">
            <div class="exp-modal-header">
                <div>
                    <h2 class="exp-modal-title-scanner">Scan Ticket</h2>
                    <p class="exp-modal-subtitle-scanner">Position the guest's QR code within the frame to verify check-in.</p>
                </div>
                <button class="exp-modal-close" onclick="closeScanModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="exp-modal-body" style="gap: 20px;">
                <div class="scan-qr-frame">
                    <div class="scan-qr-corner tl"></div>
                    <div class="scan-qr-corner tr"></div>
                    <div class="scan-qr-corner bl"></div>
                    <div class="scan-qr-corner br"></div>
                    <svg viewBox="0 0 48 48" width="52" height="52" fill="none" stroke="rgba(26,61,10,0.3)" stroke-width="1.5">
                        <rect x="6" y="6" width="14" height="14" rx="2"/>
                        <rect x="28" y="6" width="14" height="14" rx="2"/>
                        <rect x="6" y="28" width="14" height="14" rx="2"/>
                        <rect x="10" y="10" width="6" height="6" fill="rgba(26,61,10,0.3)" stroke="none"/>
                        <rect x="32" y="10" width="6" height="6" fill="rgba(26,61,10,0.3)" stroke="none"/>
                        <rect x="10" y="32" width="6" height="6" fill="rgba(26,61,10,0.3)" stroke="none"/>
                    </svg>
                    <p class="scan-searching-label">SEARCHING...</p>
                </div>
                <div class="exp-modal-field">
                    <label class="exp-field-label">Manual Ticket ID</label>
                    <input type="text" class="exp-modal-input" id="scanManualInput" placeholder="Enter code...">
                </div>
            </div>
            <div class="exp-modal-footer" style="flex-direction: column; gap: 8px;">
                <button class="exp-btn-primary-form" style="width:100%;text-align:center;padding:11px;" onclick="verifyScan()">Verify & Check In</button>
                <button class="exp-btn-cancel" style="width:100%;text-align:center;" onclick="closeScanModal()">Cancel</button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- Modal Guest Details (Read-only after scan)--}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="exp-modal-overlay" id="guestDetailModal">
        <div class="exp-modal" style="max-width: 420px;">
            <div class="exp-modal-header">
                <div>
                    <p class="exp-guest-modal-tag">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        GUEST DOSSIER
                    </p>
                    <h2 class="exp-modal-title">Guest Details</h2>
                </div>
                <button class="exp-modal-close" onclick="closeGuestModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="exp-modal-body" style="gap:18px;">
                <div class="guest-profile-row">
                    <div class="guest-avatar">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="guest-name-label" id="guestName">—</p>
                        <p class="guest-role-label" id="guestRole">—</p>
                    </div>
                </div>
                <div class="guest-contact-row">
                    <div>
                        <p class="guest-detail-sublabel">EMAIL ADDRESS</p>
                        <p class="guest-detail-value" id="guestEmail">—</p>
                    </div>
                    <div>
                        <p class="guest-detail-sublabel">WHATSAPP</p>
                        <p class="guest-detail-value" id="guestPhone">—</p>
                    </div>
                </div>
                <div class="guest-section">
                    <div class="guest-section-header">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        BOOKING INFORMATION
                        <span class="guest-confirmed-badge" id="guestStatus">—</span>
                    </div>
                    <div class="guest-info-grid">
                        <div>
                            <p class="guest-detail-sublabel">SELECTED EXPERIENCE</p>
                            <p class="guest-detail-value" id="guestExperience">—</p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">TICKET ID</p>
                            <p class="guest-detail-value" id="guestTicket">—</p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">DATE</p>
                            <p class="guest-detail-value" id="guestDate">—</p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">TIME SLOT</p>
                            <p class="guest-detail-value" id="guestTime">—</p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">NUMBER OF GUESTS</p>
                            <p class="guest-detail-value" id="guestCount">—</p>
                        </div>
                    </div>
                </div>
                <div class="guest-section">
                    <div class="guest-section-header">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        SPECIAL NOTES
                    </div>
                    <p class="guest-notes-text" id="guestNotes">—</p>
                </div>
            </div>
            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closeGuestModal()">Close</button>
                <button class="exp-btn-primary" onclick="checkInGuest()">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Check In
                </button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- Modal Edit Guest                          --}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="exp-modal-overlay" id="editGuestModal">
        <div class="exp-modal" style="max-width: 440px;">
            <div class="exp-modal-header">
                <div>
                    <p class="exp-guest-modal-tag">GUEST RECORDS</p>
                    <h2 class="exp-modal-title">Edit Guest Details</h2>
                </div>
                <button class="exp-modal-close" onclick="closeEditGuestModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="exp-modal-body" style="gap:20px;">
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">BASIC INFORMATION</p>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Full Name</label>
                            <input type="text" class="exp-modal-input" id="editGuestName" placeholder="Full name">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Email Address</label>
                            <input type="email" class="exp-modal-input" id="editGuestEmail" placeholder="email@example.com">
                        </div>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">WhatsApp Number</label>
                            <input type="text" class="exp-modal-input" id="editGuestPhone" placeholder="+62 ...">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Experience</label>
                            <select class="exp-modal-select" id="editGuestExperience">
                                @foreach($experiences as $exp)
                                    <option value="{{ $exp->id }}">{{ $exp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Scheduled Date</label>
                            <input type="date" class="exp-modal-input" id="editGuestDate">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Time Slot</label>
                            <input type="text" class="exp-modal-input" id="editGuestTime" placeholder="09:00 AM">
                        </div>
                    </div>
                    <div class="exp-modal-field" style="max-width:48%;">
                        <label class="exp-field-label">Number of Guests</label>
                        <input type="number" class="exp-modal-input" id="editGuestCount" min="1" placeholder="1">
                    </div>
                </div>
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">SPECIAL NOTES</p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Notes for Host</label>
                        <textarea class="exp-modal-textarea" id="editGuestNotes" rows="4" placeholder="Any special requests..."></textarea>
                    </div>
                </div>
            </div>
            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closeEditGuestModal()">Cancel</button>
                <button class="exp-btn-primary-form" onclick="saveGuestChanges()">Save Changes</button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- Modal Add New Guest                       --}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="exp-modal-overlay" id="addGuestModal">
        <div class="exp-modal" style="max-width: 440px;">
            <div class="exp-modal-header">
                <div>
                    <p class="exp-guest-modal-tag">GUEST INFORMATION</p>
                    <h2 class="exp-modal-title">Add New Guest</h2>
                </div>
                <button class="exp-modal-close" onclick="closeAddGuestModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="exp-modal-body" style="gap:20px;">
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">GUEST INFORMATION</p>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Full Name</label>
                            <input type="text" class="exp-modal-input" id="newGuestName" placeholder="e.g. Julian Thorne">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">WhatsApp Number / Email</label>
                            <input type="text" class="exp-modal-input" id="newGuestContact" placeholder="e.g. +62 812...">
                        </div>
                    </div>
                </div>
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">EXPERIENCE DETAILS</p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Select Experience</label>
                        <select class="exp-modal-select" id="newGuestExperience" onchange="updateTotalAmount()">
                            @foreach($experiences->where('status', 'Active') as $exp)
                                <option value="{{ $exp->id }}" data-price="{{ $exp->price }}">{{ $exp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Select Date</label>
                            <input type="date" class="exp-modal-input" id="newGuestDate" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Session Time</label>
                            <div class="exp-session-time-group" id="sessionTimeGroup">
                                <button type="button" class="exp-time-slot-btn active" data-time="07:00 AM">07:00 AM</button>
                                <button type="button" class="exp-time-slot-btn" data-time="10:00 AM">10:00 AM</button>
                            </div>
                        </div>
                    </div>
                    <div class="exp-guest-counter-row">
                        <div>
                            <label class="exp-field-label">Number of Guests</label>
                            <span class="exp-counter-display" id="guestCountValue">1</span>
                        </div>
                        <div class="exp-counter-btns">
                            <button type="button" class="exp-counter-btn" onclick="changeGuestCount(-1)">−</button>
                            <button type="button" class="exp-counter-btn" onclick="changeGuestCount(1)">+</button>
                        </div>
                    </div>
                </div>
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">ADDITIONAL INFORMATION</p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Special Notes / Allergies</label>
                        <textarea class="exp-modal-textarea" id="newGuestNotes" rows="3" placeholder="Dietary restrictions or preferences..."></textarea>
                    </div>
                </div>
                <div class="exp-payment-summary">
                    <div class="exp-payment-row">
                        <div>
                            <p class="guest-detail-sublabel">Total Amount</p>
                            <p class="exp-total-amount" id="totalAmount">IDR 0</p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">Payment Status</p>
                            <div class="exp-payment-status-row">
                                <span class="exp-pay-label" id="payStatusLabel">Unpaid</span>
                                <label class="exp-toggle">
                                    <input type="checkbox" id="payStatusToggle" onchange="updatePayLabel()">
                                    <span class="exp-toggle-slider"></span>
                                </label>
                                <span class="exp-pay-label">Paid</span>
                            </div>
                        </div>
                    </div>
                    <div class="exp-modal-field" style="margin-top:12px;">
                        <label class="exp-field-label">Payment Method</label>
                        <select class="exp-modal-select" id="newGuestPayMethod">
                            <option>Cash</option>
                            <option>Transfer</option>
                            <option>Card</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closeAddGuestModal()">Cancel</button>
                <button class="exp-btn-primary-form" onclick="confirmBooking()">Confirm Booking</button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- Modal Add / Edit Promo Code               --}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="exp-modal-overlay" id="promoModal">
        <div class="exp-modal" style="max-width:480px;">
            <div class="exp-modal-header">
                <div>
                    <h2 class="exp-modal-title" id="promoModalTitle">Add Promo Code</h2>
                    <p class="exp-modal-subtitle">Set up a discount code for your guests.</p>
                </div>
                <button class="exp-modal-close" onclick="closePromoModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <div class="exp-modal-body" style="gap:20px;">
                <div class="exp-modal-field">
                    <label class="exp-field-label" style="font-size:11px;font-weight:700;letter-spacing:0.08em;">PROMO CODE</label>
                    <input type="text" class="exp-modal-input promo-code-input" id="promoCode" placeholder="e.g., ALASAREZEN">
                </div>
                <div class="exp-modal-row">
                    <div class="exp-modal-field">
                        <label class="exp-field-label" style="font-size:11px;font-weight:700;letter-spacing:0.08em;">START DATE</label>
                        <div class="promo-date-wrap">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="promo-date-icon">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <input type="date" class="exp-modal-input promo-date-input" id="promoStartDate">
                        </div>
                    </div>
                    <div class="exp-modal-field">
                        <label class="exp-field-label" style="font-size:11px;font-weight:700;letter-spacing:0.08em;">END DATE</label>
                        <div class="promo-date-wrap">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="promo-date-icon">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <input type="date" class="exp-modal-input promo-date-input" id="promoEndDate">
                        </div>
                    </div>
                </div>
                <div class="exp-modal-row">
                    <div class="exp-modal-field">
                        <label class="exp-field-label" style="font-size:11px;font-weight:700;letter-spacing:0.08em;">DISCOUNT VALUE</label>
                        <input type="number" class="exp-modal-input" id="promoDiscountValue" placeholder="e.g, 10" min="0">
                    </div>
                    <div class="exp-modal-field">
                        <label class="exp-field-label" style="font-size:11px;font-weight:700;letter-spacing:0.08em;">DISCOUNT TYPE</label>
                        <select class="exp-modal-select" id="promoDiscountType">
                            <option value="percentage">percentage %</option>
                            <option value="flat">flat IDR</option>
                        </select>
                    </div>
                </div>
                <div class="exp-modal-row" style="align-items:flex-start;">
                    <div class="exp-modal-field">
                        <label class="exp-field-label" style="font-size:11px;font-weight:700;letter-spacing:0.08em;">QUOTA</label>
                        <input type="number" class="exp-modal-input" id="promoQuota" placeholder="0" min="0" value="0">
                    </div>
                    <div class="exp-modal-field">
                        <label class="exp-field-label" style="font-size:11px;font-weight:700;letter-spacing:0.08em;">STATUS</label>
                        <div class="promo-status-box">
                            <label class="exp-toggle">
                                <input type="checkbox" id="promoStatusToggle" checked>
                                <span class="exp-toggle-slider"></span>
                            </label>
                            <div>
                                <p class="promo-status-main" id="promoStatusLabel">Enable</p>
                                <p class="promo-status-hint">Enable or disable this code instantly</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closePromoModal()">Cancel</button>
                <button class="exp-btn-primary-form" onclick="savePromoCode()">Save</button>
            </div>
        </div>
    </div>

    <script>
    @php
        $bookingPayload = $bookings->mapWithKeys(fn($b) => [$b->id => [
            'id'             => $b->id,
            'experience_id'  => $b->experience_id,
            'guest_name'     => $b->guest_name,
            'guest_email'    => $b->guest_email,
            'guest_whatsapp' => $b->guest_whatsapp,
            'scheduled_date' => optional($b->scheduled_date)->format('Y-m-d'),
            'time_slot'      => $b->time_slot,
            'guest_count'    => $b->guest_count,
            'special_notes'  => $b->special_notes,
            'status'         => $b->status,
            'ticket_id'      => $b->ticket_id,
        ]]);

        $experiencePayload = $experiences->mapWithKeys(fn($e) => [$e->id => [
            'id'                   => $e->id,
            'name_en'              => $e->name_en,
            'name_id'              => $e->name_id,
            'short_description_en' => $e->short_description_en,
            'short_description_id' => $e->short_description_id,
            'category'             => $e->category,
            'price'                => $e->price,
            'inclusions'           => $e->inclusions ?? [],
            'time_slots'           => $e->time_slots ?? [],
            'cover_image'          => $e->cover_image,
            'status'               => $e->status,
        ]]);

        {{-- Doc 2: promo codes passed directly from controller --}}
        $promoPayload = collect($promoCodes ?? [])->map(fn($p) => [
            'id'             => $p->id,
            'code'           => $p->code,
            'discount_value' => $p->discount_value,
            'discount_type'  => $p->discount_type,
            'start_date'     => optional($p->start_date)->format('Y-m-d'),
            'end_date'       => optional($p->end_date)->format('Y-m-d'),
            'quota'          => $p->quota,
            'used_count'     => $p->used_count,
            'status'         => $p->status,
        ])->values();
    @endphp

    const CSRF        = document.querySelector('meta[name="csrf-token"]').content;
    const bookings    = @json($bookingPayload);
    const experiences = @json($experiencePayload);
    let editingExperienceId = null;

    // ── UTILS ──
    async function parseJsonResponse(res) {
        const isJson = res.headers.get('content-type')?.includes('application/json');
        const data   = isJson ? await res.json() : null;
        if (!res.ok) {
            throw new Error(data?.message || `Server error: ${res.status}`);
        }
        if (data?.success === false) {
            throw new Error(data.message || Object.values(data.errors || {}).flat().join('\n') || 'Request failed.');
        }
        return data;
    }

    // ── SIDEBAR ──
    const sidebar         = document.getElementById('adminSidebar');
    const sidebarToggle   = document.getElementById('sidebarToggle');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    function setSidebarOpen(isOpen) {
        if (!sidebar || !sidebarToggle || !sidebarBackdrop) return;
        sidebar.classList.toggle('open', isOpen);
        sidebarBackdrop.hidden = !isOpen;
        document.body.classList.toggle('sidebar-open', isOpen);
        sidebarToggle.setAttribute('aria-expanded', String(isOpen));
    }
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => setSidebarOpen(!sidebar.classList.contains('open')));
        sidebarBackdrop?.addEventListener('click', () => setSidebarOpen(false));
        window.addEventListener('keydown', e => { if (e.key === 'Escape') setSidebarOpen(false); });
        window.addEventListener('resize', () => { if (window.innerWidth >= 1024) setSidebarOpen(false); });
    }

    // ── FILTER & SEARCH ──
    let activeStatusFilter = '';

    document.querySelectorAll('.exp-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.exp-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeStatusFilter = this.dataset.status;
            filterExperiences();
        });
    });

    function filterExperiences() {
        const search   = document.getElementById('expSearch').value.toLowerCase();
        const category = document.getElementById('categoryFilter').value;
        const rows     = document.querySelectorAll('#expTableBody tr[data-category]');
        let visible    = 0;

        rows.forEach(row => {
            const matchName     = row.dataset.name.includes(search);
            const matchCategory = !category || row.dataset.category === category;
            const matchStatus   = !activeStatusFilter || row.dataset.status === activeStatusFilter;
            const show          = matchName && matchCategory && matchStatus;
            row.style.display   = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('expCount').textContent = visible;
    }

    // ── ADD EXPERIENCE MODAL ──
    function openExpModal() {
        resetExpForm();
        document.getElementById('addExpModal').classList.add('open');
    }
    function closeExpModal() { document.getElementById('addExpModal').classList.remove('open'); }
    document.getElementById('addExpModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeExpModal(); });

    function addInclusion() {
        const input = document.getElementById('inclusionInput');
        const val   = input.value.trim();
        if (!val) return;
        addInclusionTag(val);
        input.value = '';
        input.focus();
    }
    function addInclusionTag(val) {
        const list = document.getElementById('inclusionList');
        const item = document.createElement('div');
        item.className = 'exp-inclusion-item';
        item.innerHTML = `<span>${val}</span><button class="exp-inclusion-remove" onclick="this.parentElement.remove()">×</button>`;
        list.appendChild(item);
    }
    document.getElementById('inclusionInput').addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); addInclusion(); }
    });

    let slotCount = 1;
    function getSlotHtml(start = '09:00', end = '12:00', removable = false) {
        return `
            <input type="time" class="exp-modal-input exp-time-input" value="${start}">
            <span class="exp-time-sep">—</span>
            <input type="time" class="exp-modal-input exp-time-input" value="${end}">
            ${removable
                ? '<button type="button" onclick="removeSlot(this)" style="background:none;border:none;cursor:pointer;color:rgba(26,61,10,0.4);font-size:18px;line-height:1;">×</button>'
                : '<button type="button" class="exp-add-slot-btn" onclick="addTimeSlot()"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></button>'
            }`;
    }
    function addTimeSlot() {
        if (slotCount >= 3) return;
        slotCount++;
        const slot = document.createElement('div');
        slot.className = 'exp-timeslot';
        slot.innerHTML = getSlotHtml('09:00', '12:00', true);
        document.getElementById('timeslotList').appendChild(slot);
    }
    function removeSlot(btn) { btn.closest('.exp-timeslot').remove(); slotCount--; }

    function setTimeSlots(slots = []) {
        const list       = document.getElementById('timeslotList');
        const normalized = slots.length ? slots : ['09:00 - 12:00'];
        list.innerHTML   = '';
        normalized.slice(0, 3).forEach((slotValue, index) => {
            const [start = '09:00', end = '12:00'] = String(slotValue).split(' - ');
            const slot = document.createElement('div');
            slot.className = 'exp-timeslot';
            slot.innerHTML = getSlotHtml(start, end, index > 0);
            list.appendChild(slot);
        });
        slotCount = list.querySelectorAll('.exp-timeslot').length;
    }

    function previewCover(input) {
        if (!input.files?.[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('expCoverPreview').innerHTML =
                `<img src="${e.target.result}" class="exp-upload-cover-preview" alt="Cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }

    function resetExpForm() {
        editingExperienceId = null;
        document.querySelector('#addExpModal .exp-modal-title').textContent = 'Add New Experience';
        document.getElementById('expSubmitBtn').textContent = 'Add Experience';
        document.getElementById('expNameEn').value          = '';
        document.getElementById('expNameId').value          = '';
        document.getElementById('expShortDescEn').value     = '';
        document.getElementById('expShortDescId').value     = '';
        document.getElementById('expCategory').value        = 'Wellness';
        document.getElementById('expPrice').value           = '';
        document.getElementById('inclusionList').innerHTML  = '';
        document.getElementById('pubStatusToggle').checked  = true;
        document.getElementById('pubStatusLabel').textContent = 'Activate Immediately';
        document.getElementById('expCoverInput').value      = '';
        document.getElementById('expCoverPreview').innerHTML = `
            <svg viewBox="0 0 48 48" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.3">
                <rect x="6" y="6" width="36" height="36" rx="4"/>
                <circle cx="16" cy="18" r="3"/>
                <polyline points="6 34 16 22 24 30 32 20 42 34"/>
            </svg>
            <p class="exp-upload-hint">Drag & drop or click to upload</p>`;
        setTimeSlots();
    }

    document.getElementById('pubStatusToggle').addEventListener('change', function () {
        document.getElementById('pubStatusLabel').textContent = this.checked ? 'Activate Immediately' : 'Save as Draft';
    });

    async function submitExperience() {
        const formData = new FormData();
        formData.append('name_en',              document.getElementById('expNameEn').value);
        formData.append('name_id',              document.getElementById('expNameId').value);
        formData.append('short_description_en', document.getElementById('expShortDescEn').value);
        formData.append('short_description_id', document.getElementById('expShortDescId').value);
        formData.append('category',             document.getElementById('expCategory').value);
        formData.append('price',                document.getElementById('expPrice').value);
        formData.append('status',               document.getElementById('pubStatusToggle').checked ? 'Active' : 'Inactive');
        formData.append('_token',               CSRF);

        document.querySelectorAll('#inclusionList .exp-inclusion-item span').forEach(el => {
            formData.append('inclusions[]', el.textContent);
        });
        document.querySelectorAll('#timeslotList .exp-timeslot').forEach(slot => {
            const inputs = slot.querySelectorAll('input[type=time]');
            if (inputs.length === 2) formData.append('time_slots[]', `${inputs[0].value} - ${inputs[1].value}`);
        });

        const cover = document.getElementById('expCoverInput');
        if (cover.files[0]) formData.append('cover_image', cover.files[0]);

        const url = editingExperienceId
            ? `/admin/experience/${editingExperienceId}/update`
            : '{{ route("admin.experience.store") }}';

        try {
            const res  = await fetch(url, { method: 'POST', body: formData });
            const data = await parseJsonResponse(res);
            if (data.success) { closeExpModal(); location.reload(); }
        } catch (err) {
            alert(err.message);
        }
    }

    // ── EXPERIENCE ACTIONS ──
    function openEditExpModal(id) {
        const exp = experiences[id];
        if (!exp) return;
        resetExpForm();
        editingExperienceId = id;
        document.querySelector('#addExpModal .exp-modal-title').textContent = 'Edit Experience';
        document.getElementById('expSubmitBtn').textContent    = 'Save Changes';
        document.getElementById('expNameEn').value             = exp.name_en || '';
        document.getElementById('expNameId').value             = exp.name_id || '';
        document.getElementById('expShortDescEn').value        = exp.short_description_en || '';
        document.getElementById('expShortDescId').value        = exp.short_description_id || '';
        document.getElementById('expCategory').value           = exp.category || 'Wellness';
        document.getElementById('expPrice').value              = parseInt(exp.price) || '';
        document.getElementById('pubStatusToggle').checked     = exp.status === 'Active';
        document.getElementById('pubStatusLabel').textContent  = exp.status === 'Active' ? 'Activate Immediately' : 'Save as Draft';
        (exp.inclusions || []).forEach(addInclusionTag);
        setTimeSlots(exp.time_slots || []);
        if (exp.cover_image) {
            document.getElementById('expCoverPreview').innerHTML =
                `<img src="${exp.cover_image}" class="exp-upload-cover-preview" alt="Cover">`;
        }
        document.getElementById('addExpModal').classList.add('open');
    }

    async function toggleExperienceStatus(id, checkbox) {
        try {
            const res = await fetch(`/admin/experience/${id}/toggle`, {
                method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF }
            });
            await parseJsonResponse(res);
            const row = checkbox.closest('tr');
            if (row) row.dataset.status = checkbox.checked ? 'Active' : 'Inactive';
            filterExperiences();
        } catch (err) {
            checkbox.checked = !checkbox.checked;
            alert(err.message);
        }
    }

    async function deleteExperience(id, btn) {
        if (!confirm('Delete this experience? This cannot be undone.')) return;
        const row = btn.closest('tr');
        try {
            const res  = await fetch(`/admin/experience/${id}`, {
                method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF }
            });
            const data = await parseJsonResponse(res);
            if (data.success) { row.remove(); filterExperiences(); }
        } catch (err) {
            alert(err.message);
        }
    }

    // ── SCAN TICKET MODAL ──
    document.querySelector('.exp-btn-scan').addEventListener('click', () => {
        document.getElementById('scanTicketModal').classList.add('open');
    });
    function closeScanModal() {
        document.getElementById('scanTicketModal').classList.remove('open');
        document.getElementById('scanManualInput').value = '';
    }
    document.getElementById('scanTicketModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeScanModal(); });

    async function verifyTicketCode(code) {
        code = code.trim().replace(/^#/, '');
        if (!code) return;
        const res  = await fetch('{{ route("admin.experience.verify") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ ticket_id: code }),
        });
        const data = await parseJsonResponse(res);
        const b    = data.booking;

        document.getElementById('guestDetailModal').dataset.bookingId = b.id;
        document.getElementById('guestName').textContent       = b.guest_name;
        document.getElementById('guestRole').textContent       = b.guest_whatsapp || '—';
        document.getElementById('guestEmail').textContent      = b.guest_email || '—';
        document.getElementById('guestPhone').textContent      = b.guest_whatsapp || '—';
        document.getElementById('guestExperience').textContent = b.experience?.name || '—';
        document.getElementById('guestTicket').textContent     = '#' + b.ticket_id;
        document.getElementById('guestDate').textContent       = b.scheduled_date;
        document.getElementById('guestTime').textContent       = b.time_slot;
        document.getElementById('guestCount').textContent      = b.guest_count + ' Guest(s)';
        document.getElementById('guestNotes').textContent      = b.special_notes || '—';
        document.getElementById('guestStatus').textContent     = b.status;

        closeScanModal();
        document.getElementById('guestDetailModal').classList.add('open');
    }

    async function verifyScan() {
        const val = document.getElementById('scanManualInput').value;
        if (!val.trim()) { document.getElementById('scanManualInput').focus(); return; }
        try { await verifyTicketCode(val); } catch (err) { alert(err.message); }
    }

    async function verifyManualTicket() {
        const val = document.getElementById('manualTicketInput').value;
        if (!val.trim()) { document.getElementById('manualTicketInput').focus(); return; }
        try { await verifyTicketCode(val); } catch (err) { alert(err.message); }
    }

    // ── GUEST DETAIL MODAL ──
    function closeGuestModal() { document.getElementById('guestDetailModal').classList.remove('open'); }
    document.getElementById('guestDetailModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeGuestModal(); });

    async function checkInGuest() {
        const id  = document.getElementById('guestDetailModal').dataset.bookingId;
        const res = await fetch(`/admin/experience/booking/${id}/checkin`, {
            method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF }
        });
        try {
            const data = await parseJsonResponse(res);
            if (data.success) { closeGuestModal(); location.reload(); }
        } catch (err) { alert(err.message); }
    }

    // ── EDIT GUEST MODAL ──
    function openEditGuestModal(bookingId) {
        const b = bookings[bookingId];
        if (!b) return;
        document.getElementById('editGuestModal').dataset.bookingId = bookingId;
        document.getElementById('editGuestName').value       = b.guest_name || '';
        document.getElementById('editGuestEmail').value      = b.guest_email || '';
        document.getElementById('editGuestPhone').value      = b.guest_whatsapp || '';
        document.getElementById('editGuestExperience').value = b.experience_id;
        document.getElementById('editGuestDate').value       = b.scheduled_date || '';
        document.getElementById('editGuestTime').value       = b.time_slot || '';
        document.getElementById('editGuestCount').value      = b.guest_count || 1;
        document.getElementById('editGuestNotes').value      = b.special_notes || '';
        document.getElementById('editGuestModal').classList.add('open');
    }
    function closeEditGuestModal() { document.getElementById('editGuestModal').classList.remove('open'); }
    document.getElementById('editGuestModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeEditGuestModal(); });

    async function saveGuestChanges() {
        const id   = document.getElementById('editGuestModal').dataset.bookingId;
        const body = {
            guest_name:     document.getElementById('editGuestName').value,
            guest_email:    document.getElementById('editGuestEmail').value,
            guest_whatsapp: document.getElementById('editGuestPhone').value,
            experience_id:  document.getElementById('editGuestExperience').value,
            scheduled_date: document.getElementById('editGuestDate').value,
            time_slot:      document.getElementById('editGuestTime').value,
            guest_count:    document.getElementById('editGuestCount').value,
            special_notes:  document.getElementById('editGuestNotes').value,
            _token:         CSRF,
        };
        try {
            const res  = await fetch(`/admin/experience/booking/${id}/update`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify(body),
            });
            const data = await parseJsonResponse(res);
            if (data.success) { closeEditGuestModal(); location.reload(); }
        } catch (err) { alert(err.message); }
    }

    // ── ADD GUEST MODAL ──
    function openAddGuestModal() { updateTotalAmount(); document.getElementById('addGuestModal').classList.add('open'); }
    function closeAddGuestModal() { document.getElementById('addGuestModal').classList.remove('open'); }
    document.getElementById('addGuestModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeAddGuestModal(); });

    document.querySelectorAll('.exp-time-slot-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.exp-time-slot-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    let guestCount = 1;
    function changeGuestCount(delta) {
        guestCount = Math.max(1, guestCount + delta);
        document.getElementById('guestCountValue').textContent = guestCount;
        updateTotalAmount();
    }

    function updateTotalAmount() {
        const select = document.getElementById('newGuestExperience');
        const price  = parseInt(select.options[select.selectedIndex]?.dataset.price) || 0;
        document.getElementById('totalAmount').textContent =
            'IDR ' + (price * guestCount).toLocaleString('id-ID');
    }

    function updatePayLabel() {
        const paid = document.getElementById('payStatusToggle').checked;
        document.getElementById('payStatusLabel').textContent = paid ? 'Paid' : 'Unpaid';
    }

    async function confirmBooking() {
        const select = document.getElementById('newGuestExperience');
        const opt    = select.options[select.selectedIndex];
        if (!opt) { alert('No active experiences available.'); return; }

        const body = {
            experience_id:  opt.value,
            guest_name:     document.getElementById('newGuestName').value,
            guest_email:    null,
            guest_whatsapp: document.getElementById('newGuestContact').value,
            scheduled_date: document.getElementById('newGuestDate').value,
            time_slot:      document.querySelector('.exp-time-slot-btn.active')?.dataset.time || '',
            guest_count:    guestCount,
            special_notes:  document.getElementById('newGuestNotes').value,
            total_amount:   parseInt(opt.dataset.price) * guestCount,
            payment_method: document.getElementById('newGuestPayMethod').value,
            payment_status: document.getElementById('payStatusToggle').checked ? 'Paid' : 'Unpaid',
            _token:         CSRF,
        };
        try {
            const res  = await fetch('{{ route("admin.experience.booking.store") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify(body),
            });
            const data = await parseJsonResponse(res);
            if (data.success) { closeAddGuestModal(); location.reload(); }
        } catch (err) { alert(err.message); }
    }

    // ══════════════════════════════════════════
    // PROMO CODE
    // ══════════════════════════════════════════
    const PROMO_PER_PAGE = 3;
    let promoPage      = 1;
    let editingPromoId = null;

    // Data baked-in dari server (tidak perlu fetch tambahan)
    let promoCodes = @json($promoPayload);

    function formatPromoDate(dateStr) {
        return new Date(dateStr + 'T00:00:00').toLocaleDateString('en-US', {
            month: 'short', day: '2-digit', year: 'numeric'
        });
    }

    function getValidityMeta(startDate, endDate, status) {
        if (status === 'non-active') return { label: 'Non-active', cls: 'expired' };
        const now   = new Date(); now.setHours(0, 0, 0, 0);
        const start = new Date(startDate + 'T00:00:00');
        const end   = new Date(endDate + 'T00:00:00');
        if (now < start) {
            const days = Math.ceil((start - now) / 86400000);
            return { label: `Starts in ${days} day${days !== 1 ? 's' : ''}`, cls: 'upcoming' };
        }
        if (now > end) return { label: 'Expired', cls: 'expired' };
        const remaining = Math.ceil((end - now) / 86400000);
        return { label: `${remaining} Day${remaining !== 1 ? 's' : ''} remaining`, cls: 'remaining' };
    }

    function renderPromoTable() {
        const tbody = document.getElementById('promoTableBody');
        const total = promoCodes.length;
        const start = (promoPage - 1) * PROMO_PER_PAGE;
        const paged = promoCodes.slice(start, start + PROMO_PER_PAGE);

        if (paged.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:28px;color:rgba(26,61,10,0.4);font-size:13px;">No promo codes yet.</td></tr>`;
        } else {
            tbody.innerHTML = paged.map(p => {
                const discountLabel = p.discount_type === 'percentage'
                    ? `${p.discount_value}%`
                    : `IDR ${parseInt(p.discount_value).toLocaleString('id-ID')}`;
                const meta = getValidityMeta(p.start_date, p.end_date, p.status);
                const statusBadge = p.status === 'active'
                    ? `<span class="promo-status-badge active">Active</span>`
                    : `<span class="promo-status-badge non-active">Non-active</span>`;
                return `
                <tr>
                    <td class="promo-code-cell">${p.code}</td>
                    <td class="promo-discount-cell">${discountLabel}</td>
                    <td class="promo-validity-cell">
                        <span>${formatPromoDate(p.start_date)} –</span><br>
                        <span>${formatPromoDate(p.end_date)}</span>
                        <div class="promo-validity-meta ${meta.cls}">${meta.label}</div>
                    </td>
                    <td class="promo-quota-cell">${p.used_count ?? 0} / ${p.quota}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="exp-actions">
                            <button class="exp-action-btn edit" onclick="openEditPromoModal(${p.id})">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button class="exp-action-btn delete" onclick="deletePromoCode(${p.id})">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>`;
            }).join('');
        }

        const activeCount = promoCodes.filter(p => p.status === 'active').length;
        document.getElementById('promoCountLabel').textContent =
            `Showing ${paged.length} of ${total} promo codes (${activeCount} active)`;
    }

    function promoChangePage(delta) {
        const maxPage = Math.max(1, Math.ceil(promoCodes.length / PROMO_PER_PAGE));
        promoPage = Math.max(1, Math.min(promoPage + delta, maxPage));
        renderPromoTable();
    }

    function openPromoModal() {
        editingPromoId = null;
        document.getElementById('promoModalTitle').textContent  = 'Add Promo Code';
        document.getElementById('promoCode').value              = '';
        document.getElementById('promoStartDate').value         = '';
        document.getElementById('promoEndDate').value           = '';
        document.getElementById('promoDiscountValue').value     = '';
        document.getElementById('promoDiscountType').value      = 'percentage';
        document.getElementById('promoQuota').value             = '0';
        document.getElementById('promoStatusToggle').checked    = true;
        document.getElementById('promoStatusLabel').textContent = 'Enable';
        document.getElementById('promoModal').classList.add('open');
    }
    function closePromoModal() { document.getElementById('promoModal').classList.remove('open'); }
    document.getElementById('promoModal').addEventListener('click', e => { if (e.target === e.currentTarget) closePromoModal(); });

    document.getElementById('promoStatusToggle').addEventListener('change', function () {
        document.getElementById('promoStatusLabel').textContent = this.checked ? 'Enable' : 'Disable';
    });
    document.getElementById('promoCode').addEventListener('input', function () {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    function openEditPromoModal(id) {
        const p = promoCodes.find(x => x.id === id);
        if (!p) return;
        editingPromoId = id;
        document.getElementById('promoModalTitle').textContent  = 'Edit Promo Code';
        document.getElementById('promoCode').value              = p.code;
        document.getElementById('promoStartDate').value         = p.start_date;
        document.getElementById('promoEndDate').value           = p.end_date;
        document.getElementById('promoDiscountValue').value     = p.discount_value;
        document.getElementById('promoDiscountType').value      = p.discount_type;
        document.getElementById('promoQuota').value             = p.quota;
        document.getElementById('promoStatusToggle').checked    = p.status === 'active';
        document.getElementById('promoStatusLabel').textContent = p.status === 'active' ? 'Enable' : 'Disable';
        document.getElementById('promoModal').classList.add('open');
    }

    async function savePromoCode() {
        const code   = document.getElementById('promoCode').value.trim();
        const start  = document.getElementById('promoStartDate').value;
        const end    = document.getElementById('promoEndDate').value;
        const value  = document.getElementById('promoDiscountValue').value;
        const type   = document.getElementById('promoDiscountType').value;
        const quota  = parseInt(document.getElementById('promoQuota').value) || 0;
        const status = document.getElementById('promoStatusToggle').checked ? 'active' : 'non-active';

        if (!code || !start || !end || !value) {
            alert('Please fill in all required fields.');
            return;
        }
        if (new Date(end) < new Date(start)) {
            alert('End date must be after start date.');
            return;
        }

        const body = {
            code, start_date: start, end_date: end,
            discount_value: value, discount_type: type,
            quota, status, _token: CSRF,
        };
        if (editingPromoId !== null) {
            body._method = 'PUT';
        }

        const url = editingPromoId !== null
            ? `/admin/promo/${editingPromoId}`
            : '{{ route("admin.promo.store") }}';

        try {
            const res  = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify(body),
            });
            const data = await parseJsonResponse(res);
            if (data.success) { closePromoModal(); location.reload(); }
        } catch (err) {
            alert(err.message);
        }
    }

    async function deletePromoCode(id) {
        if (!confirm('Delete this promo code? This cannot be undone.')) return;
        try {
            const res  = await fetch(`/admin/promo/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF },
            });
            const data = await parseJsonResponse(res);
            if (data.success) {
                promoCodes = promoCodes.filter(p => p.id !== id);
                renderPromoTable();
            }
        } catch (err) {
            alert(err.message);
        }
    }

    // Init
    renderPromoTable();
    </script>

</body>
</html>