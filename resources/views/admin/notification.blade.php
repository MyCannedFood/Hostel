@php
    $admin = auth('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications - AlaSare</title>
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        .notif-page { padding: 2.5rem 2.75rem; }

        .notif-header {
            display: flex; align-items: flex-start;
            justify-content: space-between; margin-bottom: 2rem;
        }
        .notif-header-left h1 {
            font-size: 2rem; font-weight: 700; color: #1a3d0a;
            margin: 0 0 0.25rem; letter-spacing: -0.02em;
        }
        .notif-header-left p { font-size: 0.875rem; color: #1a3d0a; margin: 0; opacity: 0.5; }

        .btn-mark-read {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.55rem 1.1rem; border: 1.5px solid #ccc;
            border-radius: 2px; background: #fff; color: #1a3d0a; opacity: 0.7;
            font-size: 0.8rem; font-weight: 500; cursor: pointer;
            transition: all 0.18s ease; white-space: nowrap;
        }
        .btn-mark-read:hover { border-color: #2D5016; color: #2D5016; }

        .notif-search-wrap { position: relative; margin-bottom: 1.25rem; }
        .notif-search-wrap svg.search-icon {
            position: absolute; left: 1rem; top: 50%;
            transform: translateY(-50%); color: #aaa;
        }
        .notif-search {
            width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1.5px solid #E0DDD7; border-radius: 8px;
            background: #fff; font-size: 0.875rem; color: #333;
            outline: none; transition: border-color 0.18s; box-sizing: border-box;
        }
        .notif-search:focus { border-color: #2D5016; }
        .notif-search::placeholder { color: #bbb; }

        .notif-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
        .tab-btn {
            padding: 0.45rem 1.1rem; border-radius: 8px;
            border: 1.5px solid #E0DDD7; background: transparent;
            color: #666; font-size: 0.8rem; font-weight: 500; cursor: pointer;
            transition: all 0.18s ease;
        }
        .tab-btn.active { background: #2D5016; border-color: #2D5016; color: #fff; }
        .tab-btn:not(.active):hover { border-color: #2D5016; color: #2D5016; }

        .notif-list { display: flex; flex-direction: column; gap: 0.75rem; }
        .notif-card {
            background: #fff; border: 1.5px solid #E8E5DF;
            border-radius: 12px; padding: 1.2rem 1.4rem;
            display: flex; flex-direction: column; gap: 0.55rem;
            transition: box-shadow 0.18s ease, border-color 0.18s ease;
        }
        .notif-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); border-color: #d0cdc6; }
        .notif-card.is-unread { border-left: 4px solid #2D5016; }
        .notif-card-row { display: flex; align-items: flex-start; gap: 1rem; }
        .notif-icon {
            width: 40px; height: 40px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 2px;
        }
        .notif-icon.booking    { background: #E8F0E0; color: #2D5016; }
        .notif-icon.experience { background: #EDE8DF; color: #6B4F2A; }
        .notif-body { flex: 1; min-width: 0; }
        .notif-body-top {
            display: flex; align-items: flex-start;
            justify-content: space-between; gap: 1rem;
        }
        .notif-title { font-size: 0.9rem; font-weight: 600; color: #1a3d0a; margin: 0; }
        .notif-meta { display: flex; align-items: center; gap: 0.4rem; flex-shrink: 0; }
        .notif-time { font-size: 0.75rem; color: #aaa; white-space: nowrap; }
        .notif-dot { width: 8px; height: 8px; border-radius: 50%; background: #2D5016; flex-shrink: 0; }
        .notif-desc { font-size: 0.8rem; color: #777; margin: 0; line-height: 1.5; }
        .notif-actions { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.2rem; }
        .btn-view-details {
            padding: 0.38rem 0.9rem; border-radius: 2px;
            background: #2D5016; color: #fff; font-size: 0.775rem;
            font-weight: 500; border: none; cursor: pointer; transition: background 0.18s;
        }
        .btn-view-details:hover { background: #3a6b1e; }
        .btn-dismiss {
            padding: 0.38rem 0.9rem; border-radius: 2px;
            background: transparent; color: #1a3d0a; font-size: 0.775rem;
            opacity: 0.7; font-weight: 500; border: none; cursor: pointer; transition: color 0.18s;
        }
        .btn-dismiss:hover { color: #C0392B; }
        .badge-processed {
            display: inline-block; padding: 0.3rem 0.8rem; border-radius: 7px;
            border: 1.5px solid #E0DDD7; color: #1a3d0a; font-size: 0.775rem; font-weight: 500;
            opacity: 0.7;
        }

        .notif-empty { text-align: center; padding: 4rem 2rem; color: #aaa; display: none; }
        .notif-empty svg { opacity: 0.35; margin-bottom: 1rem; }
        .notif-empty p { font-size: 0.9rem; margin: 0; }

        /* Modals */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.35);
            backdrop-filter: blur(2px); display: flex;
            align-items: center; justify-content: center;
            z-index: 9999; opacity: 0; pointer-events: none;
            transition: opacity 0.22s ease;
        }
        .modal-overlay.open { opacity: 1; pointer-events: auto; }
        .modal-box {
            background: #FAFAF7; border-radius: 8px;
            padding: 2rem 2.2rem 1.8rem; width: 100%; max-width: 480px;
            position: relative; transform: translateY(14px) scale(0.98);
            transition: transform 0.22s ease; box-shadow: 0 24px 64px rgba(0,0,0,0.15);
        }
        .modal-overlay.open .modal-box { transform: translateY(0) scale(1); }
        .modal-close {
            position: absolute; top: 1.1rem; right: 1.2rem;
            background: none; border: none; cursor: pointer; color: #999;
            padding: 0.25rem; border-radius: 2px; line-height: 0;
            transition: color 0.15s, background 0.15s;
        }
        .modal-close:hover { color: #333; background: #f0ede8; }
        .modal-title { font-size: 1.2rem; font-weight: 700; color: #1a3d0a; margin: 0 0 1.5rem; }
        .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem 1.5rem; margin-bottom: 1.2rem; }
        .modal-field label {
            display: block; font-size: 0.68rem; font-weight: 600;
            letter-spacing: 0.06em; text-transform: uppercase; color: #aaa; margin-bottom: 0.22rem;
        }
        .modal-field p { font-size: 0.95rem; font-weight: 600; color: #1a3d0a; margin: 0; }
        .modal-field p.status-notified { color: #2D5016; }
        .modal-field p.price { color: #2D5016; }
        .modal-note { background: #F0EDE8; border-radius: 2px; padding: 1rem 1.1rem; margin-bottom: 1.5rem; }
        .modal-note label {
            display: block; font-size: 0.68rem; font-weight: 600;
            letter-spacing: 0.06em; text-transform: uppercase; color: #aaa; margin-bottom: 0.4rem;
        }
        .modal-note p { font-size: 0.825rem; color: #555; margin: 0; line-height: 1.6; }
        .modal-actions { display: flex; gap: 0.75rem; }
        .btn-modal-confirm {
            flex: 1; padding: 0.8rem 1rem; border-radius: 2px;
            background: #2D5016; color: #fff; font-size: 0.875rem;
            font-weight: 600; border: none; cursor: pointer; transition: background 0.18s;
        }
        .btn-modal-confirm:hover { background: #3a6b1e; }
        .btn-modal-close {
            flex: 1; padding: 0.8rem 1rem; border-radius: 2px;
            background: #D4813A; color: #fff; font-size: 0.875rem;
            font-weight: 600; border: none; cursor: pointer; transition: background 0.18s;
        }
        .btn-modal-close:hover { background: #b86e2e; }
        .notification-btn{
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
        }

        .notification-btn .material-symbols-outlined{
            font-size: 28px;
        }

        .notification-badge{
            position: absolute;
            top: -4px;
            right: -6px;

            width: 18px;
            height: 18px;

            border-radius: 50%;

            background: #D9864A;
            color: white;

            font-size: 10px;
            font-weight: 600;

            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
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

        <div class="content-area">
            <div class="notif-page">

                <div class="notif-header">
                    <div class="notif-header-left">
                        <h1>Notifications</h1>
                        <p>Stay updated with the latest activity across AlaSare Eco-Luxury Hostel.</p>
                    </div>
                    <button class="btn-mark-read" id="btnMarkAllRead">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Mark all as read
                    </button>
                </div>

                <div class="notif-search-wrap">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" class="notif-search" id="notifSearch" placeholder="Search Notifications">
                </div>

                <div class="notif-tabs">
                    <button class="tab-btn active" data-filter="all">All</button>
                    <button class="tab-btn" data-filter="bookings">Bookings</button>
                    <button class="tab-btn" data-filter="experiences">Experiences</button>
                </div>

                <div class="notif-list" id="notifList">

                    @forelse ($notification as $notif)
                    @php
                        $card  = $notif->card;
                        $modal = $card['modal'];
                        $isBooking = $notif->type === 'booking';
                    @endphp

                    <div class="notif-card {{ !$notif->is_read ? 'is-unread' : '' }}"
                         data-type="{{ $isBooking ? 'bookings' : 'experiences' }}"
                         data-id="{{ $notif->id }}"
                         data-modal='@json($modal)'
                         data-notif-type="{{ $notif->type }}">

                        <div class="notif-card-row">
                            <div class="notif-icon {{ $isBooking ? 'booking' : 'experience' }}">
                                @if ($isBooking)
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                @else
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                                @endif
                            </div>

                            <div class="notif-body">
                                <div class="notif-body-top">
                                    <p class="notif-title">{{ $card['title'] }}</p>
                                    <div class="notif-meta">
                                        <span class="notif-time">{{ $card['time'] }}</span>
                                        @if (!$notif->is_read)
                                            <span class="notif-dot"></span>
                                        @endif
                                    </div>
                                </div>
                                <p class="notif-desc">{{ $card['desc'] }}</p>
                                <div class="notif-actions">
                                    <button class="btn-view-details js-view-details">View Details</button>
                                    <button class="btn-dismiss js-dismiss">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Kosong dari server — empty state langsung tampil --}}
                    @endforelse

                </div>

                <div class="notif-empty" id="notifEmpty"
                     @if($notification->isEmpty()) style="display:block;" @endif>
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <p>No notifications found.</p>
                </div>

            </div>
        </div>
    </main>
</div>

{{-- Single Booking Modal --}}
<div class="modal-overlay" id="modalBooking">
    <div class="modal-box">
        <button class="modal-close" id="closeModalBooking">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <h2 class="modal-title">Booking Detail</h2>
        <div class="modal-grid">
            <div class="modal-field"><label>Guest Name</label><p id="mGuestName">—</p></div>
            <div class="modal-field"><label>Booking Type</label><p id="mBookingType">—</p></div>
            <div class="modal-field"><label>Dates</label><p id="mDates">—</p></div>
            <div class="modal-field"><label>Duration</label><p id="mDuration">—</p></div>
        </div>
        <div class="modal-grid" style="grid-template-columns:1fr;margin-bottom:0;">
            <div class="modal-field"><label>Total Price</label><p class="price" id="mPrice">—</p></div>
        </div>
        <div class="modal-note" style="margin-top:1.2rem;">
            <label>Special Notes</label>
            <p id="mNotes">—</p>
        </div>
        <div class="modal-actions">
            <button class="btn-modal-confirm" id="btnConfirmBooking">Confirm Booking</button>
            <button class="btn-modal-close" id="closeModalBooking2">Dismiss</button>
        </div>
    </div>
</div>

{{-- Single Experience Modal --}}
<div class="modal-overlay" id="modalExperience">
    <div class="modal-box">
        <button class="modal-close" id="closeModalExp">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <h2 class="modal-title">Experience Detail</h2>
        <div class="modal-grid">
            <div class="modal-field"><label>Guest Name</label><p id="eGuestName">—</p></div>
            <div class="modal-field"><label>Experience</label><p id="eExperience">—</p></div>
            <div class="modal-field"><label>Date &amp; Time</label><p id="eDateTime">—</p></div>
            <div class="modal-field"><label>Participants</label><p id="eParticipants">—</p></div>
        </div>
        <div class="modal-grid" style="grid-template-columns:1fr;margin-bottom:0;">
            <div class="modal-field"><label>Status</label><p class="status-notified" id="eStatus">—</p></div>
        </div>
        <div class="modal-note" style="margin-top:1.2rem;">
            <label>Internal Note</label>
            <p id="eNotes">—</p>
        </div>
        <div class="modal-actions">
            <button class="btn-modal-confirm" id="btnConfirmExp">Confirm</button>
            <button class="btn-modal-close" id="closeModalExp2">Close</button>
        </div>
    </div>
</div>

<script>
(function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // ── Sidebar ─────────────────────────────────────────
    const sidebar         = document.getElementById('adminSidebar');
    const sidebarToggle   = document.getElementById('sidebarToggle');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    function setSidebarOpen(isOpen) {
        if (!sidebar) return;
        sidebar.classList.toggle('open', isOpen);
        sidebarBackdrop.hidden = !isOpen;
        document.body.classList.toggle('sidebar-open', isOpen);
        sidebarToggle.setAttribute('aria-expanded', String(isOpen));
    }
    sidebarToggle?.addEventListener('click', () => setSidebarOpen(!sidebar.classList.contains('open')));
    sidebarBackdrop?.addEventListener('click', () => setSidebarOpen(false));
    window.addEventListener('keydown', e => { if (e.key === 'Escape') setSidebarOpen(false); });
    window.addEventListener('resize', () => { if (window.innerWidth >= 1024) setSidebarOpen(false); });

    // ── Filter & Search ─────────────────────────────────
    const tabs   = document.querySelectorAll('.tab-btn');
    const empty  = document.getElementById('notifEmpty');
    const search = document.getElementById('notifSearch');

    function visibleCards() {
        return document.querySelectorAll('.notif-card');
    }

    function applyFilters() {
        const activeFilter = document.querySelector('.tab-btn.active').dataset.filter;
        const q = search.value.toLowerCase().trim();
        let visible = 0;
        visibleCards().forEach(card => {
            const show = (activeFilter === 'all' || card.dataset.type === activeFilter)
                      && (!q || card.textContent.toLowerCase().includes(q));
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        empty.style.display = visible === 0 ? 'block' : 'none';
    }

    tabs.forEach(tab => tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        applyFilters();
    }));
    search.addEventListener('input', applyFilters);

    // ── Mark All Read ────────────────────────────────────
    document.getElementById('btnMarkAllRead').addEventListener('click', async () => {
        await fetch('{{ route("admin.notification.readAll") }}', {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        document.querySelectorAll('.notif-card.is-unread').forEach(card => {
            card.classList.remove('is-unread');
            card.querySelector('.notif-dot')?.remove();
        });
    });

    // ── Dismiss ──────────────────────────────────────────
    document.getElementById('notifList').addEventListener('click', async e => {
        const btn = e.target.closest('.js-dismiss');
        if (!btn) return;

        const card = btn.closest('.notif-card');
        const id   = card.dataset.id;

        await fetch(`/admin/notification/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });

        card.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
        card.style.opacity    = '0';
        card.style.transform  = 'translateX(12px)';
        setTimeout(() => { card.remove(); applyFilters(); }, 300);
    });

    // ── View Details → populate & open modal ────────────
    let activeCard = null; // referensi card yang sedang dibuka modalnya

    document.getElementById('notifList').addEventListener('click', async e => {
        const btn = e.target.closest('.js-view-details');
        if (!btn) return;

        const card  = btn.closest('.notif-card');
        const type  = card.dataset.notifType;  // 'booking' | 'experience'
        const modal = JSON.parse(card.dataset.modal);
        activeCard  = card;

        // Tandai sudah dibaca
        const notifId = card.dataset.id;
        if (card.classList.contains('is-unread')) {
            fetch(`/admin/notification/${notifId}/read`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            card.classList.remove('is-unread');
            card.querySelector('.notif-dot')?.remove();
        }

        if (type === 'booking') {
            document.getElementById('mGuestName').textContent   = modal.guest_name;
            document.getElementById('mBookingType').textContent = modal.booking_type;
            document.getElementById('mDates').textContent       = modal.dates;
            document.getElementById('mDuration').textContent    = modal.duration;
            document.getElementById('mPrice').textContent       = modal.total_price;
            document.getElementById('mNotes').textContent       = modal.special_notes;
            openModal('booking');
        } else {
            document.getElementById('eGuestName').textContent   = modal.guest_name;
            document.getElementById('eExperience').textContent  = modal.experience;
            document.getElementById('eDateTime').textContent    = modal.datetime;
            document.getElementById('eParticipants').textContent = modal.participants;
            document.getElementById('eStatus').textContent      = modal.status;
            document.getElementById('eNotes').textContent       = modal.notes;
            openModal('experience');
        }
    });

    // ── Confirm ──────────────────────────────────────────
    document.getElementById('btnConfirmBooking').addEventListener('click', async () => {
        if (!activeCard) return;
        await confirmNotif(activeCard);
        closeModal('booking');
    });

    document.getElementById('btnConfirmExp').addEventListener('click', async () => {
        if (!activeCard) return;
        await confirmNotif(activeCard);
        closeModal('experience');
    });

    async function confirmNotif(card) {
        const id = card.dataset.id;
        await fetch(`/admin/notification/${id}/confirm`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        card.classList.remove('is-unread');
        card.querySelector('.notif-dot')?.remove();
        card.querySelector('.notif-actions').innerHTML =
            '<span class="badge-processed">Confirmed</span>';
    }

    // ── Modal Helpers ────────────────────────────────────
    const overlays = {
        booking:    document.getElementById('modalBooking'),
        experience: document.getElementById('modalExperience'),
    };
    function openModal(type)  { overlays[type]?.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeModal(type) { overlays[type]?.classList.remove('open'); document.body.style.overflow = ''; }

    document.getElementById('closeModalBooking').addEventListener('click',  () => closeModal('booking'));
    document.getElementById('closeModalBooking2').addEventListener('click', () => closeModal('booking'));
    document.getElementById('closeModalExp').addEventListener('click',      () => closeModal('experience'));
    document.getElementById('closeModalExp2').addEventListener('click',     () => closeModal('experience'));

    Object.values(overlays).forEach(o =>
        o.addEventListener('click', e => {
            if (e.target === o) { o.classList.remove('open'); document.body.style.overflow = ''; }
        })
    );
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            Object.values(overlays).forEach(o => o.classList.remove('open'));
            document.body.style.overflow = '';
        }
    });

})();
</script>
</body>
</html>