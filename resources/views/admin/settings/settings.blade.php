{{-- resources/views/admin/settings/settings.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AlaSare</title>
    @vite(['resources/css/dashboard.css', 'resources/css/settings.css', 'resources/js/app.js'])
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
                    <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>

            <div class="content-area">

                @php
                    $section = $section ?? request('section', 'gallery');
                @endphp

                <div class="settings-wrapper">

                    {{-- ── Left Navigation Panel ── --}}
                    <nav class="settings-nav" aria-label="Settings navigation">
                        <h2 class="settings-nav-title">Settings</h2>
                        <p class="settings-nav-subtitle">Manage system settings</p>

                        <ul class="settings-nav-list">
                            <li>
                                <a href="{{ route('admin.settings', ['section' => 'gallery']) }}"
                                   class="settings-nav-card {{ $section === 'gallery' ? 'active' : '' }}">
                                    <span class="settings-nav-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                    </span>
                                    <span class="settings-nav-label">Gallery Settings</span>
                                    <span class="settings-nav-chevron">›</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.settings', ['section' => 'staff']) }}"
                                   class="settings-nav-card {{ $section === 'staff' ? 'active' : '' }}">
                                    <span class="settings-nav-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </span>
                                    <span class="settings-nav-label">Staff &amp; Access Rights</span>
                                    <span class="settings-nav-chevron">›</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.settings', ['section' => 'general']) }}"
                                   class="settings-nav-card {{ $section === 'general' ? 'active' : '' }}">
                                    <span class="settings-nav-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="3"/>
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                        </svg>
                                    </span>
                                    <span class="settings-nav-label">General Settings</span>
                                    <span class="settings-nav-chevron">›</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
                                   class="settings-nav-card {{ $section === 'landing' ? 'active' : '' }}">
                                    <span class="settings-nav-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <path d="M3 9h18M9 21V9"/>
                                        </svg>
                                    </span>
                                    <span class="settings-nav-label">Landing Page Settings</span>
                                    <span class="settings-nav-chevron">›</span>
                                </a>
                            </li>

                              <li>
                                <a href="{{ route('admin.settings', ['section' => 'location']) }}"
                                   class="settings-nav-card {{ $section === 'location' ? 'active' : '' }}">
                                    <span class="settings-nav-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                    </span>
                                    <span class="settings-nav-label">Location and Contact Settings</span>
                                    <span class="settings-nav-chevron">›</span>
                                </a>
                            </li>
                            
                        </ul>

                    </nav>

                    {{-- ── Right Content Panel ── --}}
                    <div class="settings-content">
                        @if($section === 'gallery')
                            @include('admin.settings.partials.gallery-settings')

                        @elseif($section === 'staff')
                            @include('admin.settings.partials.staff-access')

                        @elseif($section === 'general')
                            @include('admin.settings.partials.general-settings')

                        @elseif($section === 'landing')
                            @include('admin.settings.partials.landing-page-settings')

                        @elseif($section === 'location')
                            @include('admin.settings.partials.contact-location-settings')

                        @else
                            @include('admin.settings.partials.gallery-settings')
                        @endif
                    </div>

                </div>
            </div>
        </main>
    </div>

    <script>
        /* ── Sidebar toggle ── */
        const sidebar        = document.getElementById('adminSidebar');
        const sidebarToggle  = document.getElementById('sidebarToggle');
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
    </script>

    {{-- ── Shared helpers untuk Landing Page image previews ── --}}
    <script>
    function previewLpImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById(previewId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeLpImage(previewId, wrapId) {
        const img  = document.getElementById(previewId);
        const wrap = document.getElementById(wrapId);
        img.src = '';
        wrap.style.display = 'none';
    }
    </script>
</body>
</html>