<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Occupation - AlaSare</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manage_occupation.css') }}">
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

                <div class="occ-dashboard-header">
                    <h1 class="occ-page-title">Dashboard Occupation</h1>
                </div>

                <!-- Top Stats -->
                <div class="occ-stats-grid">
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">Today</div>
                        <div class="occ-stat-value">75%</div>
                        <div class="occ-progress-bar"><div class="occ-progress-fill green" style="width: 75%;"></div></div>
                    </div>
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">This Week</div>
                        <div class="occ-stat-value">88%</div>
                        <div class="occ-progress-bar"><div class="occ-progress-fill green" style="width: 88%;"></div></div>
                    </div>
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">This Month</div>
                        <div class="occ-stat-value">97%</div>
                        <div class="occ-progress-bar"><div class="occ-progress-fill green" style="width: 97%;"></div></div>
                    </div>
                    <div class="occ-stat-card">
                        <div class="occ-stat-title">avg. Stay</div>
                        <div class="occ-stat-value" style="font-size: 30px;">3.2 Nights</div>
                    </div>
                </div>

                <!-- Avg Room Occupation -->
                <div class="occ-avg-section">
                    <h2 class="occ-avg-title">Avg. Room Occupation this Month</h2>
                    <div class="occ-avg-grid">

                        <!-- Serene Haven -->
                        <div class="occ-avg-room">
                            <div class="occ-avg-room-name">Serene Haven</div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label" style="font-weight:bold">Room occupation</span>
                                <span class="occ-avg-room-pct" style="font-weight:bold">90 %</span>
                            </div>
                            <div class="occ-avg-bars">
                                <div class="occ-avg-bar occupied"></div>
                                <div class="occ-avg-bar occupied"></div>
                                <div class="occ-avg-bar occupied"></div>
                                <div class="occ-avg-bar occupied"></div>
                                <div class="occ-avg-bar occupied"></div>
                                <div class="occ-avg-bar occupied"></div>
                                <div class="occ-avg-bar occupied"></div>
                                <div class="occ-avg-bar available"></div>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">Web</span>
                                <span class="occ-avg-room-pct">50 %</span>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">App</span>
                                <span class="occ-avg-room-pct">25 %</span>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">Walk in</span>
                                <span class="occ-avg-room-pct">25 %</span>
                            </div>
                        </div>

                        <!-- Botanika -->
                        <div class="occ-avg-room">
                            <div class="occ-avg-room-name">Botanika</div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label" style="font-weight:bold">Room occupation</span>
                                <span class="occ-avg-room-pct" style="font-weight:bold">50 %</span>
                            </div>
                            <div class="occ-avg-bars">
                                <div class="occ-avg-bar warning"></div>
                                <div class="occ-avg-bar warning"></div>
                                <div class="occ-avg-bar warning"></div>
                                <div class="occ-avg-bar warning"></div>
                                <div class="occ-avg-bar available"></div>
                                <div class="occ-avg-bar available"></div>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">Web</span>
                                <span class="occ-avg-room-pct">50 %</span>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">App</span>
                                <span class="occ-avg-room-pct">25 %</span>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">Walk in</span>
                                <span class="occ-avg-room-pct">25 %</span>
                            </div>
                        </div>

                        <!-- Heritage -->
                        <div class="occ-avg-room">
                            <div class="occ-avg-room-name">Heritage</div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label" style="font-weight:bold">Room occupation</span>
                                <span class="occ-avg-room-pct" style="font-weight:bold">20 %</span>
                            </div>
                            <div class="occ-avg-bars">
                                <div class="occ-avg-bar warning"></div>
                                <div class="occ-avg-bar warning"></div>
                                <div class="occ-avg-bar warning"></div>
                                <div class="occ-avg-bar available"></div>
                                <div class="occ-avg-bar available"></div>
                                <div class="occ-avg-bar available"></div>
                                <div class="occ-avg-bar available"></div>
                                <div class="occ-avg-bar available"></div>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">Web</span>
                                <span class="occ-avg-room-pct">50 %</span>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">App</span>
                                <span class="occ-avg-room-pct">25 %</span>
                            </div>
                            <div class="occ-avg-room-header">
                                <span class="occ-avg-room-label">Walk in</span>
                                <span class="occ-avg-room-pct">25 %</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Bed Occupation Today -->
                <h2 class="occ-bed-section-title">Bed Occupation Today</h2>
                <div class="occ-bed-grid">

                    <!-- Serene Heaven -->
                    <div class="occ-bed-card">
                        <div class="occ-bed-card-title">Serene Heaven</div>
                        <div class="occ-bed-divider green"></div>
                        <div class="occ-bed-list">
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 1 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 1 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 2 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 2 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 3 Top</div></div>
                                <span class="occ-bed-badge empty">Empty</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 3 Bottom</div></div>
                                <span class="occ-bed-badge empty">Empty</span>
                            </div>
                            <div class="occ-bed-item upcoming-bg">
                                <div><div class="occ-bed-name">Bed 4 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge upcoming">Upcoming</span>
                            </div>
                            <div class="occ-bed-item upcoming-bg">
                                <div><div class="occ-bed-name">Bed 4 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge upcoming">Upcoming</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botanika -->
                    <div class="occ-bed-card">
                        <div class="occ-bed-card-title">Serene Heaven</div>
                        <div class="occ-bed-divider green"></div>
                        <div class="occ-bed-list">
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 1 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 1 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 2 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 2 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 3 Top</div></div>
                                <span class="occ-bed-badge empty">Empty</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 3 Bottom</div></div>
                                <span class="occ-bed-badge empty">Empty</span>
                            </div>
                            <div class="occ-bed-item upcoming-bg">
                                <div><div class="occ-bed-name">Bed 4 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge upcoming">Upcoming</span>
                            </div>
                            <div class="occ-bed-item upcoming-bg">
                                <div><div class="occ-bed-name">Bed 4 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge upcoming">Upcoming</span>
                            </div>
                        </div>
                    </div>

                    <!-- Heritage -->
                    <div class="occ-bed-card">
                        <div class="occ-bed-card-title">Serene Heaven</div>
                        <div class="occ-bed-divider teal"></div>
                        <div class="occ-bed-list">
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 1 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 1 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 2 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 2 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge occupied">Occupied</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 3 Top</div></div>
                                <span class="occ-bed-badge empty">Empty</span>
                            </div>
                            <div class="occ-bed-item occupied-bg">
                                <div><div class="occ-bed-name">Bed 3 Bottom</div></div>
                                <span class="occ-bed-badge empty">Empty</span>
                            </div>
                            <div class="occ-bed-item upcoming-bg">
                                <div><div class="occ-bed-name">Bed 4 Top</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge upcoming">Upcoming</span>
                            </div>
                            <div class="occ-bed-item upcoming-bg">
                                <div><div class="occ-bed-name">Bed 4 Bottom</div><div class="occ-bed-guest">joan doe</div></div>
                                <span class="occ-bed-badge upcoming">Upcoming</span>
                            </div>
                        </div>
                    </div>

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
