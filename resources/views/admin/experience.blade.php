<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience Management - AlaSare</title>
    @vite(['resources/css/dashboard.css', 'resources/css/admin-experience.css', 'resources/js/app.js'])
</head>
<body>
    <div class="dashboard-container">
        <x-admin_sidenavbar />
        <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>

        <main class="main-content">
            <header class="header">
                <button type="button" class="hamburger mobile-only" id="sidebarToggle" aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header-actions">
                    <img src="{{ asset('images/admin/img_button_trailing.svg') }}" alt="Menu" width="34" height="28">
                    <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>

            <div class="content-area">

                {{-- Page Header --}}
                <div class="exp-page-header">
                    <div>
                        <h1 class="exp-page-title">Experience Management</h1>
                        <p class="exp-page-subtitle">Curating moments of zen for the mindful traveler</p>
                    </div>
                    <button class="exp-btn-primary" onclick="openExpModal()">+ Add New Experience</button>
                </div>

                {{-- Guest Check-In --}}
                <div class="exp-card">
                    <h2 class="exp-card-title">Guest Check-In</h2>
                    <div class="exp-checkin-row">
                        <button class="exp-btn-scan">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                <path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M20 14h.01M20 17h.01M20 20h.01M17 20h.01M14 20h.01"/>
                            </svg>
                            Scan Ticket
                        </button>
                        <div class="exp-checkin-manual">
                            <label class="exp-manual-label">MANUAL TICKET ID / CODE</label>
                            <div class="exp-checkin-input-row">
                                <input type="text" class="exp-input" placeholder="Enter code...">
                                <button class="exp-btn-checkin">Check In</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Experience List --}}
                <div class="exp-card">
                    <div class="exp-filter-row">
                        <div class="exp-filter-left">
                            <span class="exp-filter-label">Filter by:</span>
                            <select class="exp-select">
                                <option>All Categories</option>
                                <option>Nature</option>
                                <option>Culture</option>
                                <option>Wellness</option>
                            </select>
                            <div class="exp-status-tabs">
                                <span class="exp-status-label">Status:</span>
                                <button class="exp-tab active">All</button>
                                <button class="exp-tab">Active</button>
                                <button class="exp-tab">Inactive</button>
                            </div>
                        </div>
                        <span class="exp-showing-label">SHOWING 3 EXPERIENCES</span>
                    </div>

                    <div class="exp-search-row">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" class="exp-search-input" placeholder="Search experiences...">
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
                        <tbody>
                            @php
                            $experiences = [
                                ['img' => 'images/experience/Nurture the Earth - Tree Planting.png', 'name' => 'Nurture the Earth', 'category' => 'Nature', 'price' => 'Rp 450.000', 'active' => true],
                                ['img' => 'images/experience/Batik Canting Ritual.png', 'name' => 'Batik Tulis Ritual', 'category' => 'Culture', 'price' => 'Rp 600.000', 'active' => true],
                                ['img' => 'images/experience/Gamelan Sound Meditation.png', 'name' => 'Gamelan Sound Meditation', 'category' => 'Wellness', 'price' => 'Rp 350.000', 'active' => false],
                            ];
                            @endphp
                            @foreach($experiences as $exp)
                            <tr>
                                <td>
                                    <div class="exp-name-cell">
                                        <img src="{{ asset($exp['img']) }}" alt="{{ $exp['name'] }}" class="exp-thumb">
                                        {{ $exp['name'] }}
                                    </div>
                                </td>
                                <td>
                                    <span class="exp-badge exp-badge-{{ strtolower($exp['category']) }}">{{ $exp['category'] }}</span>
                                </td>
                                <td class="exp-price">{{ $exp['price'] }}</td>
                                <td>
                                    <label class="exp-toggle">
                                        <input type="checkbox" {{ $exp['active'] ? 'checked' : '' }}>
                                        <span class="exp-toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="exp-actions">
                                        <button class="exp-action-btn edit ">
                                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="exp-action-btn delete">
                                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="exp-last-updated">
                        Last updated: Oct 12, 2023 • 09:00 AM
                    </div>
                </div>

                {{-- Guest Registry --}}
                <div class="exp-card">
                    <div class="exp-registry-header">
                        <h2 class="exp-card-title">Guest Registry</h2>
                        <button class="exp-btn-primary">+ Add New Guest</button>
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
                            @php
                            $guests = [
                                ['name' => 'Wayan Sudarta', 'experience' => 'Nurture the Earth', 'datetime' => 'Oct 12, 2023 • 09:00 AM', 'ticket' => '#EXP-9021', 'status' => 'Checked In'],
                                ['name' => 'Sarah Jenkins', 'experience' => 'Batik Tulis Ritual', 'datetime' => 'Oct 12, 2023 • 11:30 AM', 'ticket' => '#EXP-9022', 'status' => 'Awaiting'],
                            ];
                            @endphp
                            @foreach($guests as $guest)
                            <tr>
                                <td class="exp-guest-name">{{ $guest['name'] }}</td>
                                <td>{{ $guest['experience'] }}</td>
                                <td class="exp-datetime">{{ $guest['datetime'] }}</td>
                                <td class="exp-ticket">{{ $guest['ticket'] }}</td>
                                <td>
                                    <span class="exp-status-badge {{ $guest['status'] === 'Checked In' ? 'checked-in' : 'awaiting' }}">
                                        {{ $guest['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <button class="exp-action-btn edit" onclick="openEditGuestModal()">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    {{-- Modal Add New Experience --}}
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
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Experience Name</label>
                        <input type="text" class="exp-modal-input" placeholder="e.g. Sacred Monkey Forest Dawn Walk">
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Category</label>
                            <select class="exp-modal-select">
                                <option>Wellness</option>
                                <option>Nature</option>
                                <option>Culture</option>
                            </select>
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Price (IDR)</label>
                            <div class="exp-price-input-wrap">
                                <span class="exp-price-prefix">Rp</span>
                                <input type="number" class="exp-modal-input exp-price-input" placeholder="0">
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
                <button class="exp-btn-primary">Add Experience</button>
            </div>
        </div>
    </div>

    {{-- Modal Scan Ticket --}}
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
                {{-- QR Frame --}}
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
                        <line x1="28" y1="28" x2="28" y2="28.01"/><line x1="34" y1="28" x2="34" y2="28.01"/>
                        <line x1="40" y1="28" x2="40" y2="28.01"/><line x1="28" y1="34" x2="28" y2="34.01"/>
                        <line x1="34" y1="34" x2="34" y2="34.01"/><line x1="40" y1="34" x2="40" y2="34.01"/>
                        <line x1="28" y1="40" x2="28" y2="40.01"/><line x1="34" y1="40" x2="34" y2="40.01"/>
                        <line x1="40" y1="40" x2="40" y2="40.01"/>
                    </svg>
                    <p class="scan-searching-label">SEARCHING...</p>
                </div>

                {{-- Manual Input --}}
                <div class="exp-modal-field">
                    <label class="exp-field-label">Manual Ticket ID</label>
                    <input type="text" class="exp-modal-input" id="scanManualInput" placeholder="Enter code...">
                </div>
            </div>

            <div class="exp-modal-footer" style="flex-direction: column; gap: 8px;">
                <button class="exp-btn-primary" style="width:100%; text-align:center; padding: 11px;" onclick="verifyScan()">Verify & Check In</button>
                <button class="exp-btn-cancel" style="width:100%; text-align:center;" onclick="closeScanModal()">Cancel</button>
            </div>
        </div>
    </div>

    {{-- Modal Guest Details --}}
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
                {{-- Profile --}}
                <div class="guest-profile-row">
                    <div class="guest-avatar">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="guest-name-label" id="guestName">Mateo Sastrawan</p>
                        <p class="guest-role-label" id="guestRole">Mindful Traveler & Digital Nomad</p>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="guest-contact-row">
                    <div>
                        <p class="guest-detail-sublabel">EMAIL ADDRESS</p>
                        <p class="guest-detail-value" id="guestEmail">mateo.s@journey.com</p>
                    </div>
                    <div>
                        <p class="guest-detail-sublabel">WHATSAPP</p>
                        <p class="guest-detail-value" id="guestPhone">+62 812-3456-7890</p>
                    </div>
                </div>

                {{-- Booking Info --}}
                <div class="guest-section">
                    <div class="guest-section-header">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        BOOKING INFORMATION
                        <span class="guest-confirmed-badge" id="guestStatus">Confirmed</span>
                    </div>
                    <div class="guest-info-grid">
                        <div>
                            <p class="guest-detail-sublabel">SELECTED EXPERIENCE</p>
                            <p class="guest-detail-value" id="guestExperience">Nature the Earth</p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">TICKET ID</p>
                            <p class="guest-detail-value" id="guestTicket">#AS-2023-9941</p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">DATE</p>
                            <p class="guest-detail-value" id="guestDate">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:3px">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                October 24, 2026
                            </p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">TIME SLOT</p>
                            <p class="guest-detail-value" id="guestTime">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:3px">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                09:00 AM
                            </p>
                        </div>
                        <div>
                            <p class="guest-detail-sublabel">NUMBER OF GUEST</p>
                            <p class="guest-detail-value">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:3px">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                1
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Special Notes --}}
                <div class="guest-section">
                    <div class="guest-section-header">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        SPECIAL NOTES
                    </div>
                    <p class="guest-notes-text" id="guestNotes">I enjoys organic experiences, prefers herbal tea over coffee, and is interested in the resort's herb planting activity.</p>
                </div>
            </div>

            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closeGuestModal()">Edit Details</button>
                <button class="exp-btn-primary" onclick="checkInGuest()">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Check In
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Edit Guest Details --}}
    <div class="exp-modal-overlay" id="editGuestModal">
        <div class="exp-modal" style="max-width: 440px;">
            <div class="exp-modal-header">
                <div>
                    <p class="exp-guest-modal-tag">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        GUEST RECORDS
                    </p>
                    <h2 class="exp-modal-title">Edit Guest Details</h2>
                </div>
                <button class="exp-modal-close" onclick="closeEditGuestModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <div class="exp-modal-body" style="gap:20px;">
                {{-- Basic Information --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">BASIC INFORMATION</p>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Full Name</label>
                            <input type="text" class="exp-modal-input" id="editGuestName" placeholder="Mateo Sastrawan">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Email Address</label>
                            <input type="email" class="exp-modal-input" id="editGuestEmail" placeholder="mateo.s@journey.com">
                        </div>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">WhatsApp Number</label>
                            <input type="text" class="exp-modal-input" id="editGuestPhone" placeholder="+61 812-3456-7890">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Experience Name</label>
                            <div style="position:relative;">
                                <select class="exp-modal-select" id="editGuestExperience">
                                    <option>Nature the Earth</option>
                                    <option>Batik Tulis Ritual</option>
                                    <option>Gamelan Sound Meditation</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Scheduled Date</label>
                            <input type="date" class="exp-modal-input" id="editGuestDate">
                        </div>
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Time Slot</label>
                            <div style="position:relative;">
                                <select class="exp-modal-select" id="editGuestTime">
                                    <option>09:00 AM</option>
                                    <option>12:00 PM</option>
                                    <option>03:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="exp-modal-field" style="max-width: 48%;">
                        <label class="exp-field-label">Number of Guest</label>
                        <input type="number" class="exp-modal-input" id="editGuestCount" min="1" placeholder="1">
                    </div>
                </div>

                {{-- Special Notes --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">SPECIAL NOTES</p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Notes for Host</label>
                        <textarea class="exp-modal-textarea" id="editGuestNotes" rows="4" placeholder="Any special requests or notes..."></textarea>
                    </div>
                </div>
            </div>

            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closeEditGuestModal()">Cancel</button>
                <button class="exp-btn-primary" onclick="saveGuestChanges()">Save Changes</button>
            </div>
        </div>
    </div>

    {{-- Modal Add New Guest --}}
    <div class="exp-modal-overlay" id="addGuestModal">
        <div class="exp-modal" style="max-width: 440px;">
            <div class="exp-modal-header">
                <div>
                    <p class="exp-guest-modal-tag">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        GUEST INFORMATION
                    </p>
                    <h2 class="exp-modal-title">Add New Guest</h2>
                </div>
                <button class="exp-modal-close" onclick="closeAddGuestModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <div class="exp-modal-body" style="gap:20px;">

                {{-- Guest Information --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        GUEST INFORMATION
                    </p>
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

                {{-- Experience Details --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        EXPERIENCE DETAILS
                    </p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Select Experience</label>
                        <select class="exp-modal-select" id="newGuestExperience" onchange="updateTotalAmount()">
                            <option value="450000">Nurture the Earth</option>
                            <option value="600000">Batik Tulis Ritual</option>
                            <option value="350000">Gamelan Sound Meditation</option>
                        </select>
                    </div>
                    <div class="exp-modal-row">
                        <div class="exp-modal-field">
                            <label class="exp-field-label">Select Date</label>
                            <input type="date" class="exp-modal-input" id="newGuestDate">
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

                {{-- Additional Information --}}
                <div class="exp-modal-section">
                    <p class="exp-modal-section-label">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                        </svg>
                        ADDITIONAL INFORMATION
                    </p>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">Special Notes / Allergies</label>
                        <textarea class="exp-modal-textarea" id="newGuestNotes" rows="3" placeholder="Enter any dietary restrictions or preferences..."></textarea>
                    </div>
                </div>

                {{-- Payment Summary --}}
                <div class="exp-payment-summary">
                    <div class="exp-payment-row">
                        <div>
                            <p class="guest-detail-sublabel">Total Amount</p>
                            <p class="exp-total-amount" id="totalAmount">IDR 450.000</p>
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
                <button class="exp-btn-primary" onclick="confirmBooking()">Confirm Booking</button>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
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
            window.addEventListener('keydown', e => { if (e.key === 'Escape') setSidebarOpen(false); });
            window.addEventListener('resize', () => { if (window.innerWidth >= 1024) setSidebarOpen(false); });
        }

        // Status tabs
        document.querySelectorAll('.exp-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.exp-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Modal
        function closeExpModal() {
            document.getElementById('addExpModal').classList.remove('open');
        }

        document.getElementById('addExpModal').addEventListener('click', function(e) {
            if (e.target === this) closeExpModal();
        });

        function openExpModal() {
            document.getElementById('addExpModal').classList.add('open');
        }

        // Inclusions
        function addInclusion() {
            const input = document.getElementById('inclusionInput');
            const val = input.value.trim();
            if (!val) return;
            const list = document.getElementById('inclusionList');
            const item = document.createElement('div');
            item.className = 'exp-inclusion-item';
            item.innerHTML = `<span>${val}</span><button class="exp-inclusion-remove" onclick="this.parentElement.remove()">×</button>`;
            list.appendChild(item);
            input.value = '';
            input.focus();
        }

        document.getElementById('inclusionInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); addInclusion(); }
        });

        // Time slots
        let slotCount = 1;
        function addTimeSlot() {
            if (slotCount >= 3) return;
            slotCount++;
            const list = document.getElementById('timeslotList');
            const slot = document.createElement('div');
            slot.className = 'exp-timeslot';
            slot.innerHTML = `
                <input type="time" class="exp-modal-input exp-time-input" value="09:00">
                <span class="exp-time-sep">—</span>
                <input type="time" class="exp-modal-input exp-time-input" value="12:00">
                <button type="button" onclick="removeSlot(this)" style="background:none;border:none;cursor:pointer;color:rgba(26,61,10,0.4);font-size:18px;line-height:1;">×</button>
            `;
            list.appendChild(slot);
        }

        function removeSlot(btn) {
            btn.closest('.exp-timeslot').remove();
            slotCount--;
        }

        // Cover preview
        function previewCover(input) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById('expCoverPreview');
                preview.innerHTML = `<img src="${e.target.result}" class="exp-upload-cover-preview" alt="Cover">`;
            };
            reader.readAsDataURL(input.files[0]);
        }

        // Publication toggle label
        document.getElementById('pubStatusToggle').addEventListener('change', function() {
            document.getElementById('pubStatusLabel').textContent = this.checked ? 'Activate Immediately' : 'Save as Draft';
        });

        // Scan Ticket Modal
        document.querySelector('.exp-btn-scan').addEventListener('click', () => {
            document.getElementById('scanTicketModal').classList.add('open');
        });

        function closeScanModal() {
            document.getElementById('scanTicketModal').classList.remove('open');
            document.getElementById('scanManualInput').value = '';
        }

        document.getElementById('scanTicketModal').addEventListener('click', function(e) {
            if (e.target === this) closeScanModal();
        });

        function verifyScan() {
            const code = document.getElementById('scanManualInput').value.trim();
            if (!code) {
                document.getElementById('scanManualInput').focus();
                return;
            }
            alert('Checking in: ' + code);
            closeScanModal();
        }

        function closeGuestModal() {
            document.getElementById('guestDetailModal').classList.remove('open');
        }

        document.getElementById('guestDetailModal').addEventListener('click', function(e) {
            if (e.target === this) closeGuestModal();
        });

        function verifyScan() {
            const code = document.getElementById('scanManualInput').value.trim();
            if (!code) {
                document.getElementById('scanManualInput').focus();
                return;
            }
            closeScanModal();
            document.getElementById('guestDetailModal').classList.add('open');
        }

        function checkInGuest() {
            closeGuestModal();
        }

        // Edit Guest Modal
        function openEditGuestModal(guest) {
            document.getElementById('editGuestName').value = guest?.name || '';
            document.getElementById('editGuestEmail').value = guest?.email || '';
            document.getElementById('editGuestPhone').value = guest?.phone || '';
            document.getElementById('editGuestDate').value = guest?.date || '';
            document.getElementById('editGuestCount').value = guest?.count || 1;
            document.getElementById('editGuestNotes').value = guest?.notes || '';

            document.getElementById('editGuestModal').classList.add('open');
        }

        function closeEditGuestModal() {
            document.getElementById('editGuestModal').classList.remove('open');
        }

        document.getElementById('editGuestModal').addEventListener('click', function(e) {
            if (e.target === this) closeEditGuestModal();
        });

        function saveGuestChanges() {
            closeEditGuestModal();
        }

        // Add New Guest Modal
        document.querySelector('.exp-registry-header .exp-btn-primary').addEventListener('click', () => {
            document.getElementById('addGuestModal').classList.add('open');
        });

        function closeAddGuestModal() {
            document.getElementById('addGuestModal').classList.remove('open');
        }

        document.getElementById('addGuestModal').addEventListener('click', function(e) {
            if (e.target === this) closeAddGuestModal();
        });

        // Session time toggle
        document.querySelectorAll('.exp-time-slot-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.exp-time-slot-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Guest counter
        let guestCount = 1;
        function changeGuestCount(delta) {
            guestCount = Math.max(1, guestCount + delta);
            document.getElementById('guestCountValue').textContent = guestCount;
            updateTotalAmount();
        }

        // Total amount
        const prices = { 'Nurture the Earth': 450000, 'Batik Tulis Ritual': 600000, 'Gamelan Sound Meditation': 350000 };
        function updateTotalAmount() {
            const select = document.getElementById('newGuestExperience');
            const price = parseInt(select.options[select.selectedIndex].value) || 0;
            const total = price * guestCount;
            document.getElementById('totalAmount').textContent = 'IDR ' + total.toLocaleString('id-ID');
        }

        // Payment label
        function updatePayLabel() {
            const paid = document.getElementById('payStatusToggle').checked;
            document.getElementById('payStatusLabel').textContent = paid ? 'Paid' : 'Unpaid';
        }

        function confirmBooking() {
            // Nanti connect ke backend
            closeAddGuestModal();
        }
    </script>
    
</body>
</html>