<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Guests - AlaSare</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manage_guests.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <img src="{{ asset('images/admin/img_button_trailing.svg') }}" alt="Menu" width="34" height="28">
                    <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>
      
            <!-- Content area -->
            <div class="content-area">
                
                <div class="guest-dashboard-header">
                    <h1 class="guest-page-title">Dashboard Guest</h1>
                    <button class="btn-add-guest"><span>+</span> Add Guest</button>
                </div>

                <!-- Top Stats -->
                <div class="guest-stats-grid">
                    
                    <!-- Today -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">Today</div>
                        <div class="guest-stat-value">18 / 25</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Foreigner</span><span>15 / 50.0%</span></div>
                            <div class="guest-breakdown-item"><span>Asia</span><span>7 / 23.3%</span></div>
                            <div class="guest-breakdown-item"><span>USA/EU/OC</span><span>3 / 10.0%</span></div>
                            <div class="guest-breakdown-item"><span>AF</span><span>4 / 13.3</span></div>
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Local</span><span>15 / 50.0%</span></div>
                        </div>
                    </div>

                    <!-- This Week -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">This Week</div>
                        <div class="guest-stat-value">50</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Foreigner</span><span>15 / 50.0%</span></div>
                            <div class="guest-breakdown-item"><span>Asia</span><span>7 / 23.3%</span></div>
                            <div class="guest-breakdown-item"><span>USA/EU/OC</span><span>3 / 10.0%</span></div>
                            <div class="guest-breakdown-item"><span>AF</span><span>4 / 13.3</span></div>
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Local</span><span>15 / 50.0%</span></div>
                        </div>
                    </div>

                    <!-- This Month -->
                    <div class="guest-stat-card">
                        <div class="guest-stat-title">This Month</div>
                        <div class="guest-stat-value">90</div>
                        <div class="guest-stat-sub">Guest</div>
                        <div class="guest-breakdown">
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Foreigner</span><span>15 / 50.0%</span></div>
                            <div class="guest-breakdown-item"><span>Asia</span><span>7 / 23.3%</span></div>
                            <div class="guest-breakdown-item"><span>USA/EU/OC</span><span>3 / 10.0%</span></div>
                            <div class="guest-breakdown-item"><span>AF</span><span>4 / 13.3</span></div>
                            <div class="guest-breakdown-item" style="font-weight: bold;"><span>Local</span><span>15 / 50.0%</span></div>
                        </div>
                    </div>

                    <!-- Check In/Out -->
                    <div class="guest-stat-card-split">
                        <div class="split-item">
                            <div class="split-value">7</div>
                            <div class="split-label">Check-out</div>
                        </div>
                        <div class="split-item">
                            <div class="split-value">25</div>
                            <div class="split-label">Check-in</div>
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
                                <input type="text" placeholder="Search Guest">
                            </div>
                        </div>
                        <div style="overflow-x: auto;">
                            <table class="guest-table">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Guest Name</th>
                                        <th>Country</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BK-2026-1042</td>
                                        <td>Aria Kusuma</td>
                                        <td>Indonesia</td>
                                    </tr>
                                    <tr>
                                        <td>BK-2026-1042</td>
                                        <td>Aria Kusuma</td>
                                        <td>Indonesia</td>
                                    </tr>
                                    <tr>
                                        <td>BK-2026-1042</td>
                                        <td>Aria Kusuma</td>
                                        <td>Indonesia</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Guests per Room -->
                    <div class="guests-room-card">
                        <div class="guests-room-title">Guests per Room</div>
                        
                        <div class="room-item">
                            <div>
                                <div class="room-info-name">Serene Heaven</div>
                                <div class="room-info-details">Top 3/4<br>Bottom 4/4</div>
                            </div>
                            <div class="room-count">7</div>
                        </div>

                        <div class="room-item">
                            <div>
                                <div class="room-info-name">Botanice</div>
                                <div class="room-info-details">Top 3/4<br>Bottom 4/4</div>
                            </div>
                            <div class="room-count">7</div>
                        </div>

                        <div class="room-item">
                            <div>
                                <div class="room-info-name">The Heritage</div>
                                <div class="room-info-details">Top 3/4<br>Bottom 4/4</div>
                            </div>
                            <div class="room-count">7</div>
                        </div>
                    </div>

                    <!-- Guest Trend -->
                    <div class="guest-trend-card">
                        <div class="guest-trend-header">
                            <div class="guest-trend-title">Guest Trend</div>
                            <select class="trend-dropdown">
                                <option>Days</option>
                                <option>Weeks</option>
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
  
    <script>
        // Sidebar Logic
        const sidebar = document.getElementById('adminSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function setSidebarOpen(isOpen) {
            if (!sidebar || !sidebarToggle || !sidebarBackdrop) {
                return;
            }
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

        // Guest Trend Chart
        const trendCtx = document.getElementById('guestTrendChart')?.getContext('2d');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        data: [7, 12, 5, 17, 20, 18, 10],
                        backgroundColor: '#29A4A1',
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            max: 20,
                            grid: { display: false },
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
