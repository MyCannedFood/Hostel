<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlaSare Management Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" async src="https://static.rocket.new/rocket-web.js?_cfg=https%3A%2F%2Fhostelman8354back.builtwithrocket.new&_be=https%3A%2F%2Fappanalytics.rocket.new&_v=0.1.18"></script>
    <script type="module" defer src="https://static.rocket.new/rocket-shot.js?v=0.0.2"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Component -->
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
                <!-- Dashboard overview -->
                <section>
                    <div class="content-header">
                        <h2 class="page-title">Dashboard Overview</h2>
                        <div class="dropdown">
                            <select aria-label="Select time period">
                                <option>Today</option>
                                <option>This Week</option>
                                <option>This Month</option>
                            </select>
                            <img src="{{ asset('images/admin/img_arrow_down.svg') }}" alt="Open dropdown" aria-hidden="true">
                        </div>
                        
                    </div>
          
                    <!-- Stats cards -->
                    <div class="stats-grid">
                        <!-- Guest card -->
                        <article class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Guest</h3>
                                <div class="stat-icon">
                                    <img src="{{ asset('images/admin/img_icon_green_800.svg') }}" alt="" width="22" height="16">
                                </div>
                            </div>
                            <div class="stat-body">
                                <p class="stat-label">All Guests</p>
                                <p class="stat-value">18 Guests</p>
                                <p class="stat-detail">50 Guests (week)</p>
                                <p class="stat-detail">90 Guests (month)</p>
                            </div>
                            <p class="stat-footer">6 Check-outs today</p>
                        </article>
            
                        <!-- Occupation card -->
                        <article class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Occupation</h3>
                                <div class="stat-icon">
                                    <img src="{{ asset('images/admin/img_icon_green_800_14x20.svg') }}" alt="" width="20" height="14">
                                </div>
                            </div>
                            <div class="stat-body">
                                <p class="stat-label">% Occupancy</p>
                                <p class="stat-value">75%</p>
                                <p class="stat-detail">88% (week)</p>
                                <p class="stat-detail">97% (month)</p>
                            </div>
                            <p class="stat-footer"><img src="{{ asset('images/admin/img_margin.svg') }}" alt="Occupation trend visualization" class="occupation-bar"></p>
                            
                        </article>
            
                        <!-- Booking card -->
                        <article class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Booking</h3>
                                <div class="stat-icon">
                                    <img src="{{ asset('images/admin/img_icon_green_800_22x14.svg') }}" alt="" width="14" height="22">
                                </div>
                            </div>
                            <div class="stat-body">
                                <p class="stat-label">Incoming booking</p>
                                <p class="stat-value">5 New</p>
                                <p class="stat-detail">5 New (week)</p>
                                <p class="stat-detail">5 New (month)</p>
                            </div>
                            <p class="stat-footer">Active today</p>
                        </article>
            
                        <!-- Revenue card -->
                        <article class="stat-card">
                            <div class="stat-header">
                                <h3 class="stat-title">Revenue</h3>
                                <div class="stat-icon">
                                    <img src="{{ asset('images/admin/img_icon_green_800_16x22.svg') }}" alt="" width="22" height="16">
                                </div>
                            </div>
                            <div class="stat-body">
                                <p class="stat-label">Total Revenue</p>
                                <p class="stat-value">IDR 4.200.000</p>
                                <p class="stat-detail">IDR 4.200.000 (week)</p>
                                <p class="stat-detail">IDR 4.200.000 (month)</p>
                            </div>
                            <p class="stat-footer positive">+12% above target</p>
                        </article>
                    </div>
                </section>
        
                <!-- Unit availability -->
                <section>
                    <div class="section-header">
                        <h2 class="section-title">Unit availability Status</h2>
                    </div>
          
                    <div class="unit-availability">
                        <div class="unit-slider">
                            <!-- Serene Haven -->
                            <article class="unit-card">
                                <div class="unit-header">
                                    <h3 class="unit-name">Serene Haven</h3>
                                    <span class="unit-badge">4 Beds Available</span>
                                </div>
                                <div class="unit-occupancy">
                                    <div class="occupancy-header">
                                            <span class="occupancy-label">Room Occupancy</span>
                                            <span class="occupancy-value">4/8 Beds Occupied</span>
                                    </div>
                                    <div class="occupancy-bars">
                                        <div class="occupancy-bar-item occupied"></div>
                                        <div class="occupancy-bar-item occupied"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                    </div>
                                </div>
                            </article>
              
                            <!-- Botanika -->
                            <article class="unit-card">
                                <div class="unit-header">
                                    <h3 class="unit-name">Botanika</h3>
                                    <span class="unit-badge">4 Beds Available</span>
                                </div>
                                <div class="unit-occupancy">
                                    <div class="occupancy-header">
                                            <span class="occupancy-label">Room Occupancy</span>
                                            <span class="occupancy-value">2/6 Beds Occupied</span>
                                    </div>
                                    <div class="occupancy-bars">
                                        <div class="occupancy-bar-item occupied"></div>
                                        <div class="occupancy-bar-item occupied"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                    </div>
                                </div>
                            </article>
              
                            <!-- Heritage -->
                            <article class="unit-card">
                                <div class="unit-header">
                                    <h3 class="unit-name">Heritage</h3>
                                    <span class="unit-badge">5 Beds Available</span>
                                </div>
                                <div class="unit-occupancy">
                                    <div class="occupancy-header">
                                            <span class="occupancy-label">Room Occupancy</span>
                                            <span class="occupancy-value">3/8 Beds Occupied</span>
                                    </div>
                                    <div class="occupancy-bars">
                                        <div class="occupancy-bar-item occupied"></div>
                                        <div class="occupancy-bar-item occupied"></div>
                                        <div class="occupancy-bar-item occupied"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                        <div class="occupancy-bar-item available"></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>

                <!-- Charts -->
                 <section class="charts-grid">
                    <!-- Statistics Booking -->
                    <article class="chart-card">
                        <div class="chart-header">
                            <h2 class="chart-title">Statistics Booking</h2>
                            <div class="dropdown">
                                <select aria-label="Select booking statistics period">
                                    <option>Day</option>
                                    <option>Week</option>
                                    <option>Month</option>
                                </select>
                                <img src="{{ asset('images/admin/img_arrow_down.svg') }}" alt="Open dropdown" aria-hidden="true">
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="bookingChart" role="img" aria-label="Bar chart showing daily booking statistics"></canvas>
                        </div>
                    </article>
          
                    <!-- Trend Revenue -->
                    <article class="chart-card">
                        <div class="chart-header">
                            <h2 class="chart-title">Trend Revenue</h2>
                            <div class="dropdown">
                                <select aria-label="Select revenue trend period">
                                    <option>Week</option>
                                    <option>Month</option>
                                    <option>Year</option>
                                </select>
                                <img src="{{ asset('images/admin/img_arrow_down.svg') }}" alt="Open dropdown" aria-hidden="true">
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="revenueChart" role="img" aria-label="Area chart showing weekly revenue trends"></canvas>
                        </div>
                    </article>
                </section>
        
                <!-- Confirmation wait list -->
                <section>
                    <div class="section-header">
                        <h2 class="section-title">Confirmation wait list</h2>
                            <div class="view-all">
                            <span class="view-all-text">View All</span>
                            <img src="{{ asset('images/admin/img_arrow_right.svg') }}" alt="" width="20" height="10">
                        </div>
                    </div>
          
                    <div class="table-container">
                        <table role="table">
                            <thead>
                                <tr>
                                    <th>ID Booking</th>
                                    <th>Guest Name</th>
                                    <th>Room Type</th>
                                    <th>Bed No</th>
                                    <th>Check-in</th>
                                    <th>Total Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#BK-2023-1042</td>
                                    <td>Aria Kusuma</td>
                                    <td>Serene Haven</td>
                                    <td>Bed 3U</td>
                                    <td>24 Okt 2023</td>
                                    <td>IDR 350.000</td>
                                    <td><span class="status-badge">Pending</span></td>
                                    <td><button class="btn-confirm">Confirm</button></td>
                                </tr>
                                <tr>
                                    <td>#BK-2023-1043</td>
                                    <td>Budi Santoso</td>
                                    <td>Botanika</td>
                                    <td>Bed 1U</td>
                                    <td>25 Okt 2023</td>
                                    <td>IDR 400.000</td>
                                    <td><span class="status-badge">Pending</span></td>
                                    <td><button class="btn-confirm">Confirm</button></td>
                                </tr>
                                <tr>
                                    <td>#BK-2023-1044</td>
                                    <td>Citra Lestari</td>
                                    <td>Heritage</td>
                                    <td>Bed 1B</td>
                                    <td>26 Okt 2023</td>
                                    <td>IDR 550.000</td>
                                    <td><span class="status-badge">Pending</span></td>
                                    <td><button class="btn-confirm">Confirm</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
        
                
                
            </div>
        </main>
    </div>
  
    <script>
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
                if (event.key === 'Escape') {
                    setSidebarOpen(false);
                }
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    setSidebarOpen(false);
                }
            });
        }

        // Booking Statistics Chart
        const bookingCtx = document.getElementById('bookingChart')?.getContext('2d');
        if (!bookingCtx || typeof Chart === 'undefined') {
            console.warn('Chart.js not available, showing placeholder');
            const bookingContainer = document.getElementById('bookingChart');
            if (bookingContainer) {
                bookingContainer.innerHTML = '<div class="chart-placeholder">Chart Placeholder</div>';
            }
        } else {
            new Chart(bookingCtx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Bookings',
                        data: [4, 3, 12, 15, 13, 6],
                        backgroundColor: '#26A7A9',
                        borderRadius: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        x: {
                            offset: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 20,
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        }
    
        // Revenue Trend Chart
        const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
        if (!revenueCtx || typeof Chart === 'undefined') {
            console.warn('Chart.js not available, showing placeholder');
            const revenueContainer = document.getElementById('revenueChart');
            if (revenueContainer) {
                revenueContainer.innerHTML = '<div class="chart-placeholder">Chart Placeholder</div>';
            }
        } else {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        label: 'Revenue (M)',
                        data: [1, 1.5, 3, 8],
                        backgroundColor: 'rgba(255, 127, 80, 0.2)',
                        borderColor: '#ff7f50',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        x: {
                            offset: true,
                            ticks: {
                                padding: 8
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 8,
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 2,
                                callback: function(value) {
                                    return value + 'M';
                                }
                            }
                        }
                    }
                }
            });
        }
    
        // Interactive menu items
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuItems.forEach(mi => mi.classList.remove('active'));
                this.classList.add('active');
            });
      
            item.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    this.click();
                }
            });
        });
    
        // Logout button interaction
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    alert('Logging out...');
                }
            });
        }
    </script>
</body>
</html>
