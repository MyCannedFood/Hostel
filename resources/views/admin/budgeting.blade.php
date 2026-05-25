{{-- resources/views/admin/budgeting-report.blade.php --}}

@php
    // Stat card data
    $stats = [
        'approved_budget'   => 10500000,
        'total_savings'     => 1200000,
        'total_spent'       => 8200000,
        'spent_pct'         => 78,
        'remaining_balance' => 2300000,
        'remaining_pct'     => 22,
    ];

    // Budget distribution chart
    $distribution = [
        ['label' => 'Maintenance', 'color' => '#4b9960', 'pct' => 40],
        ['label' => 'Garden',      'color' => '#b8d9a0', 'pct' => 30],
        ['label' => 'Facility',    'color' => '#d9864a', 'pct' => 20],
        ['label' => 'Supplies',    'color' => '#d8e8da', 'pct' => 10],
    ];

    // Top requestors
    $requestors = [
        [
            'initials' => 'AK',
            'name' => 'Aris K.',
            'role' => 'Maintenance Lead',
            'count' => 12,
            'bg' => '#eaf4ed',
            'color' => '#4b9960'
        ],
        [
            'initials' => 'DS',
            'name' => 'Dewi S.',
            'role' => 'Guest Relations',
            'count' => 8,
            'bg' => '#fdf0e6',
            'color' => '#d9864a'
        ],
    ];

    // Budget request rows
    $budgetRequests = [
        [
            'date' => '12 Oct 2023',
            'title' => 'Bamboo Fencing',
            'type' => 'Operational',
            'category' => 'Maintenance',
            'amount' => 1500000,
            'status' => 'Approved'
        ],
        [
            'date' => '14 Oct 2023',
            'title' => 'Hemp Twine',
            'type' => 'Operational',
            'category' => 'Supplies',
            'amount' => 250000,
            'status' => 'Pending'
        ],
        [
            'date' => '15 Oct 2023',
            'title' => 'Solar Panel Repair',
            'type' => 'Maintenance',
            'category' => 'Facility',
            'amount' => 3200000,
            'status' => 'Approved'
        ],
    ];

    // Pagination
    $totalRecords = 24;
    $totalPages = 3;
    $currentPage = 1;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlaSare – Budgeting & Report</title>

    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&family=Be+Vietnam+Pro:wght@400;500;600;700&family=Libre+Caslon+Text:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    @vite([
        'resources/css/dashboard.css',
        'resources/css/budgeting.css',
        'resources/css/modal-revenue.css',
    ])
</head>
<body>

<div class="dashboard-container">

    {{-- ===== SIDEBAR (dari komponen global) ===== --}}
    <x-admin_sidenavbar />

    {{-- Backdrop mobile --}}
    <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>

    <div class="main-content">

         {{-- Top header --}}
        <header class="header">
            <button type="button" class="hamburger mobile-only" id="sidebarToggle"
                    aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <div class="header-actions">
                <img src="{{ asset('images/admin/img_button_trailing.svg') }}"   alt="Menu"          width="34" height="28">
                <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                <img src="{{ asset('images/admin/profile.png') }}"               alt="Profile"       width="40" height="40">
            </div>
        </header>
        

        {{-- ===== PAGE CONTENT ===== --}}
        <div class="content-area page-budgeting">

            {{-- Page header --}}
            <div class="page-header">
                <h1 class="page-title">Budgeting and Report</h1>
                <div class="header-actions">
                     <button class="btn btn-outline" onclick="openModal('overlayLpj')">
                        <i class="fa-solid fa-file-chart-column"></i>
                        Accountability Report
                    </button>
                    <button class="btn btn-primary" onclick="openModal('overlayExpense')">
                        <i class="fa-solid fa-plus"></i> New Budgeting
                    </button>
                </div>
            </div>

            {{-- ===== STAT CARDS ===== --}}
            <div class="stats-grid">

                {{-- Total Approved Budget --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Total Approved Budget
                        <div class="stat-icon green"><i class="fa-solid fa-file-circle-check"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format(10500000, 0, ',', '.') }}</div>
                    <div class="stat-badge up">
                        <i class="fa-solid fa-arrow-trend-up"></i> +12.4% from last period
                    </div>
                </div>

                {{-- Total Savings --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Total Savings
                        <div class="stat-icon green"><i class="fa-solid fa-piggy-bank"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format(1200000, 0, ',', '.') }}</div>
                    <div class="stat-badge up">
                        <i class="fa-solid fa-arrow-trend-up"></i> +5.2% from last period
                    </div>
                </div>

                {{-- Total Actual Spent --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Total Actual Spent
                        <div class="stat-icon orange"><i class="fa-solid fa-money-bill-wave"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format(8200000, 0, ',', '.') }}</div>
                    <div class="progress-bar">
                        <div class="progress-fill fill-orange" style="width:78%"></div>
                    </div>
                    <div class="stat-sub">78% of total budget used</div>
                </div>

                {{-- Remaining Balance --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Remaining Balance
                        <div class="stat-icon green"><i class="fa-solid fa-wallet"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format(2300000, 0, ',', '.') }}</div>
                    <div class="progress-bar">
                        <div class="progress-fill fill-green" style="width:22%"></div>
                    </div>
                    <div class="stat-sub">Updated 2 hours ago</div>
                </div>

            </div>{{-- /stats-grid --}}

            {{-- ===== MID ROW: Donut chart + Top Requestors ===== --}}
            <div class="mid-row">

                {{-- Budget Distribution (Donut) --}}
                <div class="card">
                    <div class="card-title">Budget Distribution by Category</div>
                    <div class="card-sub">
                        Analysis of total expenditures across primary operational departments.
                    </div>
                    
                    <div class="donut-layout">

                        {{-- LEFT --}}
                        <div class="donut-left">

                            {{-- Donut --}}
                            <div class="donut-wrap">
                                <svg viewBox="0 0 148 148" xmlns="http://www.w3.org/2000/svg">

                                    <circle cx="74" cy="74" r="55"
                                        fill="none"
                                        stroke="#edf1ed"
                                        stroke-width="20"/>

                                    <circle cx="74" cy="74" r="55"
                                        fill="none"
                                        stroke="#4b9960"
                                        stroke-width="20"
                                        stroke-dasharray="138.2 207.3"
                                        stroke-dashoffset="86.4"/>

                                    <circle cx="74" cy="74" r="55"
                                        fill="none"
                                        stroke="#b8d9a0"
                                        stroke-width="20"
                                        stroke-dasharray="103.7 241.8"
                                        stroke-dashoffset="-51.8"/>

                                    <circle cx="74" cy="74" r="55"
                                        fill="none"
                                        stroke="#d9864a"
                                        stroke-width="20"
                                        stroke-dasharray="69.1 276.4"
                                        stroke-dashoffset="-155.5"/>

                                    <circle cx="74" cy="74" r="55"
                                        fill="none"
                                        stroke="#d8e8da"
                                        stroke-width="20"
                                        stroke-dasharray="34.6 310.9"
                                        stroke-dashoffset="-224.6"/>
                                </svg>

                                <div class="donut-center">
                                    <div class="donut-center-value">100%</div>
                                    <div class="donut-center-label">Total</div>
                                </div>
                            </div>

                            {{-- Summary --}}
                            <div class="budget-summary">

                                <div class="summary-card">
                                    <span>Total Budget</span>
                                    <strong>IDR 10.5M</strong>
                                </div>

                                <div class="summary-card">
                                    <span>Highest Spending</span>
                                    <strong>Maintenance</strong>
                                </div>

                                <div class="summary-card">
                                    <span>Lowest Spending</span>
                                    <strong>Supplies</strong>
                                </div>

                                <div class="summary-card">
                                    <span>Monthly Growth</span>
                                    <strong style="color:#4b9960;">+12.4%</strong>
                                </div>

                            </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="category-list">

                        <div class="cat-row">
                            <div class="cat-dot" style="background:#4b9960"></div>
                            <div class="cat-name">Maintenance</div>

                            <div class="cat-progress">
                                <div class="cat-progress-fill"
                                    style="width:40%; background:#4b9960"></div>
                            </div>

                            <div class="cat-pct">40%</div>
                        </div>

                        <div class="cat-row">
                            <div class="cat-dot" style="background:#b8d9a0"></div>
                            <div class="cat-name">Garden</div>

                            <div class="cat-progress">
                                <div class="cat-progress-fill"
                                    style="width:30%; background:#b8d9a0"></div>
                            </div>

                            <div class="cat-pct">30%</div>
                        </div>

                        <div class="cat-row">
                            <div class="cat-dot" style="background:#d9864a"></div>
                            <div class="cat-name">Facility</div>

                            <div class="cat-progress">
                                <div class="cat-progress-fill"
                                    style="width:20%; background:#d9864a"></div>
                            </div>

                            <div class="cat-pct">20%</div>
                        </div>

                        <div class="cat-row">
                            <div class="cat-dot" style="background:#d8e8da"></div>
                            <div class="cat-name">Supplies</div>

                            <div class="cat-progress">
                                <div class="cat-progress-fill"
                                    style="width:10%; background:#d8e8da"></div>
                            </div>

                            <div class="cat-pct">10%</div>
                        </div>

                    </div>

                </div>

                </div>{{-- /Budget Distribution --}}

                {{-- Top Requestors --}}
                <div class="card">
                    <div class="requestors-header">
                        <div>
                            <div class="card-title">Top Requestors</div>
                            <div class="requestors-sub">This month</div>
                        </div>
                        <a href="#" class="view-all-link">
                            View All <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i>
                        </a>
                    </div>

                    <div class="req-item">
                        <div class="req-avatar">AK</div>
                        <div class="req-info">
                            <div class="req-name">Aris K.</div>
                            <div class="req-role">Maintenance Lead</div>
                        </div>
                        <div class="req-count">
                            <div class="req-count-num">12</div>
                            <div class="req-count-label">Requests</div>
                        </div>
                    </div>

                    <div class="req-item">
                        <div class="req-avatar" style="background:#fdf0e6;color:#d9864a;">DS</div>
                        <div class="req-info">
                            <div class="req-name">Dewi S.</div>
                            <div class="req-role">Guest Relations</div>
                        </div>
                        <div class="req-count">
                            <div class="req-count-num" style="color:#d9864a;">8</div>
                            <div class="req-count-label">Requests</div>
                        </div>
                    </div>

                    <div class="req-item">
                        <div class="req-avatar" style="background:#e8f0fb;color:#4a82c4;">RW</div>
                        <div class="req-info">
                            <div class="req-name">Rian W.</div>
                            <div class="req-role">Operations</div>
                        </div>
                        <div class="req-count">
                            <div class="req-count-num" style="color:#4a82c4;">5</div>
                            <div class="req-count-label">Requests</div>
                        </div>
                    </div>

                    <div class="req-item">
                        <div class="req-avatar" style="background:#f3edf7;color:#8a5baa;">LM</div>
                        <div class="req-info">
                            <div class="req-name">Laras M.</div>
                            <div class="req-role">Housekeeping</div>
                        </div>
                        <div class="req-count">
                            <div class="req-count-num" style="color:#8a5baa;">3</div>
                            <div class="req-count-label">Requests</div>
                        </div>
                    </div>

                </div>{{-- /Top Requestors --}}

            </div>{{-- /mid-row --}}

            {{-- ===== BUDGET REQUESTS TABLE ===== --}}
            <div class="table-card">
                <div class="table-header">
                    <div class="table-title">Budget Requests</div>
                    <div class="table-filters">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Search report title...">
                        </div>
                        <div class="filter-btn">
                            Category <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
                        </div>
                        <div class="filter-btn">
                            Status <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
                        </div>
                        <div class="filter-btn">
                            <i class="fa-regular fa-calendar" style="font-size:11px;"></i>
                            Oct 2023
                            <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
                        </div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Request Title</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Amount (IDR)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budgetRequests as $item)
                        <tr>
                            <td style="color:#7a857f;">{{ $item['date'] }}</td>
                            <td><strong>{{ $item['title'] }}</strong></td>
                            <td>
                                <span class="{{ $item['type'] === 'Operational' ? 'type-operational' : 'type-maintenance' }}">
                                    {{ $item['type'] }}
                                </span>
                            </td>
                            <td><span class="category-badge">{{ $item['category'] }}</span></td>
                            <td><strong>{{ number_format($item['amount'], 0, ',', '.') }}</strong></td>
                            <td>
                                @if ($item['status'] === 'Approved')
                                    <span class="status-badge status-approved">
                                        <i class="fa-solid fa-circle" style="font-size:7px;"></i> Approved
                                    </span>
                                @elseif ($item['status'] === 'Pending')
                                    <span class="status-badge status-pending">
                                        <i class="fa-solid fa-circle" style="font-size:7px;"></i> Pending
                                    </span>
                                @else
                                    <span class="status-badge status-rejected">
                                        <i class="fa-solid fa-circle" style="font-size:7px;"></i> Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="action-cell">
                                <button class="action-btn edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="table-footer">
                    <span>Showing {{ count($budgetRequests) }} of {{ $totalRecords }} records</span>
                    <div class="pagination">
                        <div class="page-btn">
                            <i class="fa-solid fa-chevron-left" style="font-size:10px;"></i>
                        </div>
                        @for ($p = 1; $p <= $totalPages; $p++)
                            <div class="page-btn {{ $p === $currentPage ? 'active' : '' }}">{{ $p }}</div>
                        @endfor
                        <div class="page-btn">
                            <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
                        </div>
                    </div>
                </div>

            </div>{{-- /table-card --}}

        </div>{{-- /content-area.page-budgeting --}}
    </div>{{-- /main-content --}}
</div>{{-- /dashboard-container --}}

{{-- ===== MODALS ===== --}}
@include('admin.modal-expense')
@include('admin.modal-lpj')



<script>
/* ── Sidebar toggle ── */
const sidebar         = document.getElementById('adminSidebar');
const sidebarToggle   = document.getElementById('sidebarToggle');
const sidebarBackdrop = document.getElementById('sidebarBackdrop');

function setSidebarOpen(open) {
    if (!sidebar || !sidebarToggle || !sidebarBackdrop) return;
    sidebar.classList.toggle('open', open);
    sidebarBackdrop.hidden = !open;
    document.body.classList.toggle('sidebar-open', open);
    sidebarToggle.setAttribute('aria-expanded', String(open));
    sidebarToggle.setAttribute('aria-label', open ? 'Close sidebar' : 'Open sidebar');
}

sidebarToggle   && sidebarToggle.addEventListener('click',  () => setSidebarOpen(!sidebar.classList.contains('open')));
sidebarBackdrop && sidebarBackdrop.addEventListener('click', () => setSidebarOpen(false));
window.addEventListener('resize', () => { if (window.innerWidth >= 1024) setSidebarOpen(false); });

/* ── Modal ── */
function openModal(id) {
    const m = document.getElementById(id);
    if (!m) return;
    m.classList.add('open');
    document.body.classList.add('modal-open');
}

function closeModal(id) {
    const m = document.getElementById(id);
    if (m) m.classList.remove('open');
    if (!document.querySelector('.overlay.open')) {
        document.body.classList.remove('modal-open');
    }
}

document.querySelectorAll('.overlay').forEach(overlay => {
    overlay.addEventListener('click', e => {
        if (e.target === overlay) closeModal(overlay.id);
    });
});

window.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    document.querySelectorAll('.overlay.open').forEach(m => closeModal(m.id));
    setSidebarOpen(false);
});
</script>

</body>
</html>