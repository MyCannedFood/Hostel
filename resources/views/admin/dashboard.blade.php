@php
    $admin = auth('admin')->user();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlaSare Management Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <a href="{{ route('admin.notifications') }}">
                        <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    </a>
                    <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">

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
                        <article class="stat-card clickable" onclick="window.location.href='/admin/manage-guests'" role="button" tabindex="0">
                            <div class="stat-header">
                                <h3 class="stat-title">Guest</h3>
                                <div class="stat-icon">
                                    <img src="{{ asset('images/admin/img_icon_green_800.svg') }}" alt="" width="22" height="16">
                                </div>
                            </div>
                            <div class="stat-body">
                                <p class="stat-label">All Guests</p>
                                <p class="stat-value">{{ $guestStats['today'] ?? 0 }} Guests</p>
                                <p class="stat-detail">{{ $guestStats['week'] ?? 0 }} Guests (week)</p>
                                <p class="stat-detail">{{ $guestStats['month'] ?? 0 }} Guests (month)</p>
                            </div>
                            <p class="stat-footer">Check-outs today</p>
                        </article>
            
                        <!-- Occupation card -->
                        <article class="stat-card clickable" onclick="window.location.href='/admin/manage-occupation'" role="button" tabindex="0">
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
                        <article class="stat-card clickable" onclick="window.location.href='/admin/manage-revenue'" role="button" tabindex="0">
                            <div class="stat-header">
                                <h3 class="stat-title">Revenue</h3>
                                <div class="stat-icon">
                                    <img src="{{ asset('images/admin/img_icon_green_800_16x22.svg') }}" alt="" width="22" height="16">
                                </div>
                            </div>
                            <div class="stat-body">
                                <p class="stat-label">Total Revenue</p>
                                <p class="stat-value">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                                <p class="stat-detail">IDR {{ number_format($revenueThisWeek, 0, ',', '.') }} (week)</p>
                                <p class="stat-detail">IDR {{ number_format($revenueThisMonth, 0, ',', '.') }} (month)</p>
                            </div>
                            <p class="stat-footer {{ $revenueGrowth >= 0 ? 'positive' : 'negative' }}">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}% above target</p>
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
                    </div>
          
                    <div class="table-container">
                        <div class="waitlist-controls">
                            <div class="waitlist-search">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43493e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input id="waitlistSearchBookingId" type="text" placeholder="Search Booking ID" autocomplete="off" />
                            </div>

                            <div class="waitlist-filters">
                                <input id="waitlistFilterName" type="text" placeholder="Filter by name" autocomplete="off" />
                                <input id="waitlistFilterDate" type="text" placeholder="Filter by check-in (e.g. 24 Okt 2023)" autocomplete="off" />
                            </div>
                        </div>

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

                            <tbody id="waitlistTableBody">
                                <tr data-waitlist-id="#BK-2023-1042">
                                    <td>#BK-2023-1042</td>
                                    <td>Aria Kusuma</td>
                                    <td>Serene Haven</td>
                                    <td>Bed 3U</td>
                                    <td>24 Okt 2023</td>
                                    <td>IDR 350.000</td>
                                    <td><span class="status-badge">Pending</span></td>
                                    <td><button class="btn-confirm">Confirm</button></td>
                                </tr>
                                <tr data-waitlist-id="#BK-2023-1043">
                                    <td>#BK-2023-1043</td>
                                    <td>Budi Santoso</td>
                                    <td>Botanika</td>
                                    <td>Bed 1U</td>
                                    <td>25 Okt 2023</td>
                                    <td>IDR 400.000</td>
                                    <td><span class="status-badge">Pending</span></td>
                                    <td><button class="btn-confirm">Confirm</button></td>
                                </tr>
                                <tr data-waitlist-id="#BK-2023-1044">
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

                        <div class="waitlist-pagination" aria-label="Wait list pagination">
                            <button type="button" class="waitlist-page-btn" id="waitlistPrevBtn" disabled>Prev</button>
                            <div class="waitlist-page-numbers" id="waitlistPageNumbers"></div>
                            <button type="button" class="waitlist-page-btn" id="waitlistNextBtn">Next</button>
                        </div>
                    </div>
                </section>
        
                
                
            </div>
        </main>
    </div>
  
    <script>
        // Confirmation wait list (front-end) : search + filter + pagination (max 5 rows/page)
        (function () {
            const tableBody = document.getElementById('waitlistTableBody');
            if (!tableBody) return;

            const rows = Array.from(tableBody.querySelectorAll('tr'));

            const searchBookingId = document.getElementById('waitlistSearchBookingId');
            const filterName = document.getElementById('waitlistFilterName');
            const filterDate = document.getElementById('waitlistFilterDate');

            const prevBtn = document.getElementById('waitlistPrevBtn');
            const nextBtn = document.getElementById('waitlistNextBtn');
            const pageNumbersEl = document.getElementById('waitlistPageNumbers');

            const PAGE_SIZE = 5;
            let currentPage = 1;

            function getRowText(row) {
                const bookingId = (row.querySelector('td:nth-child(1)')?.textContent || '').trim();
                const name = (row.querySelector('td:nth-child(2)')?.textContent || '').trim();
                const date = (row.querySelector('td:nth-child(5)')?.textContent || '').trim();
                return { bookingId, name, date };
            }

            function normalize(str) {
                return String(str || '').toLowerCase().trim();
            }

            function applyFilters() {
                const qBookingId = normalize(searchBookingId?.value);
                const qName = normalize(filterName?.value);
                const qDate = normalize(filterDate?.value);

                return rows.filter(row => {
                    const { bookingId, name, date } = getRowText(row);

                    const matchBookingId = !qBookingId || normalize(bookingId).includes(qBookingId);
                    const matchName = !qName || normalize(name).includes(qName);
                    const matchDate = !qDate || normalize(date).includes(qDate);

                    return matchBookingId && matchName && matchDate;
                });
            }

            function renderPagination(filteredRows) {
                const totalPages = Math.max(1, Math.ceil(filteredRows.length / PAGE_SIZE));
                currentPage = Math.min(currentPage, totalPages);

                prevBtn && (prevBtn.disabled = currentPage <= 1);
                nextBtn && (nextBtn.disabled = currentPage >= totalPages);

                if (!pageNumbersEl) return;
                pageNumbersEl.innerHTML = '';

                for (let p = 1; p <= totalPages; p++) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'waitlist-page-num-btn' + (p === currentPage ? ' is-active' : '');
                    btn.textContent = String(p);
                    btn.setAttribute('aria-label', 'Page ' + p);
                    btn.addEventListener('click', function () {
                        currentPage = p;
                        refresh();
                    });
                    pageNumbersEl.appendChild(btn);
                }
            }

            function renderPage(filteredRows) {
                const start = (currentPage - 1) * PAGE_SIZE;
                const end = start + PAGE_SIZE;
                const pageRows = filteredRows.slice(start, end);

                rows.forEach(r => (r.style.display = 'none'));
                pageRows.forEach(r => (r.style.display = 'table-row'));
            }

            function refresh() {
                const filtered = applyFilters();
                renderPagination(filtered);
                renderPage(filtered);
            }

            // Events
            [searchBookingId, filterName, filterDate].forEach(el => {
                if (!el) return;
                el.addEventListener('input', function () {
                    currentPage = 1;
                    refresh();
                });
            });

            prevBtn && prevBtn.addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    refresh();
                }
            });

            nextBtn && nextBtn.addEventListener('click', function () {
                currentPage++;
                refresh();
            });

            // initial render
            refresh();
        })();

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

        // Inject booking chart data from backend
        window.bookingChartDay = {!! json_encode($bookingStats['day']['data'] ?? []) !!};
        window.bookingChartDayLabels = {!! json_encode($bookingStats['day']['labels'] ?? []) !!};
        window.bookingChartWeek = {!! json_encode($bookingStats['week']['data'] ?? []) !!};
        window.bookingChartWeekLabels = {!! json_encode($bookingStats['week']['labels'] ?? []) !!};
        window.bookingChartMonth = {!! json_encode($bookingStats['month']['data'] ?? []) !!};
        window.bookingChartMonthLabels = {!! json_encode($bookingStats['month']['labels'] ?? []) !!};
        window.bookingChartRevenue = {!! json_encode($bookingStats['revenue']['data'] ?? []) !!};
        window.bookingChartRevenueScaled = window.bookingChartRevenue;
        window.bookingChartRevenueLabels = {!! json_encode($bookingStats['revenue']['labels'] ?? []) !!};

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
                    labels: window.bookingChartDayLabels?.length ? window.bookingChartDayLabels : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Bookings',
                        data: window.bookingChartDay?.length ? window.bookingChartDay : [0, 0, 0, 0, 0, 0, 0],
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
                            max: Math.max(...(window.bookingChartDay || [0])) || 20,
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
                        labels: window.bookingChartRevenueLabels?.length ? window.bookingChartRevenueLabels : ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        label: 'Revenue (M)',
                        data: window.bookingChartRevenue?.length ? window.bookingChartRevenue : [0, 0, 0, 0],
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
