@php
    $admin = auth('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Occupation - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
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

                <div class="occ-dashboard-header">
                    <h1 class="occ-page-title">Dashboard Occupation</h1>
                </div>

                <!-- Top Stats -->
                <div class="occ-stats-grid">
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">Today</div>
                        <div class="occ-stat-value">{{ $occupancyToday }}%</div>
                        <div class="occ-progress-bar"><div class="occ-progress-fill {{ $occupancyToday >= 60 ? 'green' : ($occupancyToday >= 20 ? 'orange' : 'light') }}" style="width: {{ $occupancyToday }}%;"></div></div>
                    </div>
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">This Week</div>
                        <div class="occ-stat-value">{{ $occupancyWeek }}%</div>
                        <div class="occ-progress-bar"><div class="occ-progress-fill {{ $occupancyWeek >= 60 ? 'green' : ($occupancyWeek >= 20 ? 'orange' : 'light') }}" style="width: {{ $occupancyWeek }}%;"></div></div>
                    </div>
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">This Month</div>
                        <div class="occ-stat-value">{{ $occupancyMonth }}%</div>
                        <div class="occ-progress-bar"><div class="occ-progress-fill {{ $occupancyMonth >= 60 ? 'green' : ($occupancyMonth >= 20 ? 'orange' : 'light') }}" style="width: {{ $occupancyMonth }}%;"></div></div>
                    </div>
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">avg. Stay</div>
                        <div class="occ-stat-value" style="font-size: 30px;">{{ $avgStay }} Nights</div>
                    </div>
                </div>

                <!-- Avg Room Occupation -->
                <div class="occ-avg-section">
                    <h2 class="occ-avg-title">Avg. Room Occupation this Month</h2>
                    <div class="occ-avg-grid">
                        @foreach($rooms as $room)
                            <div class="occ-avg-room">
                                <div class="occ-avg-room-name">{{ $room->name }}</div>
                                <div class="occ-avg-room-header">
                                    <span class="occ-avg-room-label" style="font-weight:bold">Room occupation</span>
                                    <span class="occ-avg-room-pct" style="font-weight:bold">{{ $room->pct }} %</span>
                                </div>
                                <div class="occ-avg-bars">
                                    @foreach($room->bars as $bar)
                                        <div class="occ-avg-bar {{ $bar }}"></div>
                                    @endforeach
                                </div>
                                <div class="occ-avg-room-header">
                                    <span class="occ-avg-room-label">Web</span>
                                    <span class="occ-avg-room-pct">{{ $room->web_pct }} %</span>
                                </div>
                                <div class="occ-avg-room-header">
                                    <span class="occ-avg-room-label">App</span>
                                    <span class="occ-avg-room-pct">{{ $room->app_pct }} %</span>
                                </div>
                                <div class="occ-avg-room-header">
                                    <span class="occ-avg-room-label">Walk in</span>
                                    <span class="occ-avg-room-pct">{{ $room->walkin_pct }} %</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Bed Occupation Today -->
                <h2 class="occ-bed-section-title">Bed Occupation Today</h2>
                <div class="occ-bed-grid">
                    @foreach($bedOccupation as $room)
                        <div class="occ-bed-card">
                            <div class="occ-bed-card-title">{{ $room->name }}</div>
                            <div class="occ-bed-divider {{ $room->divider_color }}"></div>
                            <div class="occ-bed-list">
                                @foreach($room->beds as $bed)
                                    <div class="occ-bed-item {{ $bed->status }}-bg">
                                        <div>
                                            <div class="occ-bed-name">{{ $bed->name }}</div>
                                            @if($bed->guest_name)
                                                <div class="occ-bed-guest">{{ $bed->guest_name }}</div>
                                            @endif
                                        </div>
                                        <span class="occ-bed-badge {{ $bed->status }}">
                                            {{ ucfirst($bed->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
        </main>
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
            sidebarToggle.addEventListener('click', function () {
                setSidebarOpen(!sidebar.classList.contains('open'));
            });
            sidebarBackdrop.addEventListener('click', function () {
                setSidebarOpen(false);
            });
            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') setSidebarOpen(false);
            });
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) setSidebarOpen(false);
            });
        }
    </script>
</body>
</html>
