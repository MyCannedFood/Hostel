<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Accounting - AlaSare</title>
    @vite(['resources/css/dashboard.css', 'resources/css/finance-accounting.css', 'resources/js/app.js'])
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

            <div class="content-area finance-accounting-page">
                <div class="finance-page-head">
                    <h1>Finance Accounting</h1>
                    <div class="finance-head-actions">
                        <button type="button">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                            New Budgeting
                        </button>
                        <button type="button" class="primary">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 3h7l4 4v14H8z"/><path d="M15 3v5h4"/><path d="M11 13h5M11 17h5"/></svg>
                            Accountability Report
                        </button>
                    </div>
                </div>

                <section class="finance-kpi-grid" aria-label="Finance summary">
                    <article class="finance-kpi-card">
                        <div class="finance-kpi-top">
                            <span>Total Cash In</span>
                            <span class="finance-kpi-icon green">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="4" y="6" width="16" height="12" rx="2"></rect>
                                    <path d="M8 10h8M8 14h5"></path>
                                    <path d="M17 9v6M14 12h6"></path>
                                </svg>
                            </span>
                        </div>
                        <strong>IDR 25,000,000</strong>
                        <p class="positive">
                            <i class="fa-solid fa-arrow-up"></i>
                            +12% from target
                        </p>
                        <small>+9% from booking</small>
                        <small>+3% from experience</small>
                    </article>

                    <article class="finance-kpi-card">
                        <div class="finance-kpi-top">
                            <span>Total Cash Out</span>
                            <span class="finance-kpi-icon orange">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="4" y="6" width="16" height="12" rx="2"></rect>
                                    <path d="M8 10h8M8 14h5"></path>
                                    <path d="M14 12h6"></path>
                                </svg>
                            </span>
                        </div>
                        <strong>IDR 12,000,000</strong>
                        <p class="warning">-5% from budget</p>
                        <small>-2% for maintenance</small>
                        <small>-3% for operational</small>
                    </article>

                    <article class="finance-kpi-card">
                        <div class="finance-kpi-top">
                            <span>Net Profit</span>
                            <span class="finance-kpi-icon green">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4 19h16"></path>
                                    <path d="M7 16V9"></path>
                                    <path d="M12 16V5"></path>
                                    <path d="M17 16v-4"></path>
                                    <path d="m15 7-3-3-3 3"></path>
                                </svg>
                            </span>
                        </div>
                        <strong>IDR 2,700,000</strong>
                        <p><span class="healthy-badge">Healthy</span></p>
                        <small>64% margin achieved this period</small>
                    </article>

                    <article class="finance-kpi-card pending">
                        <div class="finance-kpi-top">
                            <span>Pending Actions</span>
                            <span class="finance-kpi-icon orange">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 3a7 7 0 0 0-7 7v3l-2 3h18l-2-3v-3a7 7 0 0 0-7-7Z"></path>
                                    <path d="M10 20h4"></path>
                                    <path d="M12 7v5"></path>
                                    <path d="M12 15h.01"></path>
                                </svg>
                            </span>
                        </div>
                        <strong>4 Request</strong>
                        <small>2 Maintenance request</small>
                        <small>2 Operational request</small>
                    </article>
                </section>

                <section class="finance-chart-grid">
                    <article class="finance-panel">
                        <div class="finance-panel-head">
                            <h2>Revenue Statistics</h2>
                            <span>Unit: IDR | Day</span>
                        </div>
                        <div class="finance-bar-chart" aria-label="Revenue statistics bar chart">
                            <div class="finance-y-axis">
                                <span>50M</span>
                                <span>40M</span>
                                <span>30M</span>
                                <span>20M</span>
                                <span>10M</span>
                                <span>0</span>
                            </div>
                            <div class="finance-bars">
                                <div><span style="height: 42%"></span><small>Mon</small></div>
                                <div><span style="height: 66%"></span><small>Tue</small></div>
                                <div><span style="height: 32%"></span><small>Wed</small></div>
                                <div><span style="height: 80%"></span><small>Thu</small></div>
                                <div><span style="height: 54%"></span><small>Fri</small></div>
                                <div><span style="height: 86%"></span><small>Sat</small></div>
                                <div><span style="height: 60%"></span><small>Sun</small></div>
                            </div>
                        </div>
                    </article>

                    <article class="finance-panel">
                        <div class="finance-panel-head">
                            <h2>Financial Trend</h2>
                            <span>Day</span>
                        </div>
                        <div class="finance-area-chart" aria-label="Financial trend area chart">
                            <svg viewBox="0 0 520 230" preserveAspectRatio="none" role="img" aria-hidden="true">
                                <defs>
                                    <linearGradient id="financeTrendFill" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#d9864a" stop-opacity="0.34"/>
                                        <stop offset="100%" stop-color="#d9864a" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path class="grid" d="M0 42H520M0 88H520M0 134H520M0 180H520"/>
                                <path class="area" d="M0 135 C38 126 70 139 104 134 C148 128 170 146 214 132 C252 120 276 104 318 99 C362 94 392 102 426 106 C458 110 472 82 498 80 C508 80 516 84 520 88 L520 230 L0 230 Z"/>
                                <path class="line" d="M0 135 C38 126 70 139 104 134 C148 128 170 146 214 132 C252 120 276 104 318 99 C362 94 392 102 426 106 C458 110 472 82 498 80 C508 80 516 84 520 88"/>
                            </svg>
                            <div class="finance-week-labels">
                                <span>Week 1</span>
                                <span>Week 2</span>
                                <span>Week 3</span>
                                <span>Week 4</span>
                            </div>
                            <div class="finance-legend">
                                <span><i class="target"></i> Revenue Target</span>
                                <span><i class="actual"></i> Actual Income</span>
                            </div>
                        </div>
                    </article>
                </section>

                <section class="finance-panel finance-approval-panel">
                    <div class="finance-table-title">
                        <h2>Pending Approvals</h2>
                        <span>Required Action</span>
                    </div>
                    <div class="finance-table-wrap">
                        <table class="finance-table approvals">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Staff Name</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>12 Oct 2023</td>
                                    <td>Aris K.</td>
                                    <td><span class="tag green">Reimbursement</span></td>
                                    <td>Maintenance Spare Parts</td>
                                    <td>IDR 1,250,000</td>
                                    <td><button>Approve</button><button class="reject">Reject</button></td>
                                </tr>
                                <tr>
                                    <td>12 Oct 2023</td>
                                    <td>Dewi S.</td>
                                    <td><span class="tag muted">Supplies</span></td>
                                    <td>Kitchen Inventory - Herbs</td>
                                    <td>IDR 450,000</td>
                                    <td><button>Approve</button><button class="reject">Reject</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="finance-panel finance-ledger-panel">
                    <div class="finance-table-title ledger">
                        <h2>Master General Ledger</h2>
                        <small>Last updated: 5 minutes ago</small>
                    </div>
                    <div class="finance-table-wrap">
                        <table class="finance-table ledger-table">
                            <thead>
                                <tr>
                                    <th>Trans ID</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    <th>Doc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>TR-9961</td>
                                    <td>10-10-23</td>
                                    <td>Room 302 Booking - 3 Nights</td>
                                    <td>Accommodation</td>
                                    <td><span class="type in">In</span></td>
                                    <td>3,500,000</td>
                                    <td>13,500,000</td>
                                    <td>View</td>
                                </tr>
                                <tr>
                                    <td>TR-9965</td>
                                    <td>09-10-23</td>
                                    <td>Electricity Bill - Oct</td>
                                    <td>Utilities</td>
                                    <td><span class="type out">Out</span></td>
                                    <td>1,200,000</td>
                                    <td>9,500,000</td>
                                    <td>View</td>
                                </tr>
                                <tr>
                                    <td>TR-9962</td>
                                    <td>08-10-23</td>
                                    <td>Spa & Massage Services</td>
                                    <td>Amenity</td>
                                    <td><span class="type in">In</span></td>
                                    <td>750,000</td>
                                    <td>10,700,000</td>
                                    <td>View</td>
                                </tr>
                                <tr>
                                    <td>TR-9671</td>
                                    <td>07-10-23</td>
                                    <td>Kitchen Equipment Repair</td>
                                    <td>Maintenance</td>
                                    <td><span class="type out">Out</span></td>
                                    <td>2,100,000</td>
                                    <td>9,950,000</td>
                                    <td>View</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="finance-ledger-foot">
                        <span>Showing 4 of 288 Transactions</span>
                        <span>Previous&nbsp;&nbsp; Next</span>
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
