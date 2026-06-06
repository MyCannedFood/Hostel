@php
    $admin = auth('admin')->user();
@endphp

@php
$transactions = [
    ['id' => 'TR-1042', 'description' => 'Booking #BK-9021',          'category' => 'Accommodation', 'type' => 'Income',  'amount' => 350000],
    ['id' => 'TR-1043', 'description' => 'Cleaning Supplies Purchase', 'category' => 'Operational',   'type' => 'Expense', 'amount' => 400000],
    ['id' => 'TR-1044', 'description' => 'Laundry Service',            'category' => 'Service',       'type' => 'Income',  'amount' => 150000],
];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlaSare - Revenue Overview</title>

    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&family=Be+Vietnam+Pro:wght@400;500;600;700&family=Libre+Caslon+Text:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    @vite([
        'resources/css/app.css',
        'resources/css/manage-revenue.css',
        'resources/css/modal-revenue.css',
        'resources/js/app.js',
    ])
</head>
<body>

<div class="dashboard-container">

    {{-- Sidebar (dari komponen) --}}
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
                <a href="{{ route('admin.notifications') }}">
                        <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    </a>
                <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">>
            </div>
        </header>

        {{-- Page content --}}
        {{-- FIX: tambah class .page-revenue sebagai namespace CSS --}}
        <div class="content-area page-revenue">

            <h1 class="page-title">Revenue Overview</h1>

            {{-- ===== STAT CARDS ===== --}}
            <div class="stats-grid">

                {{-- Revenue --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Revenue
                        <div class="stat-icon green"><i class="fa-solid fa-wallet"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="stat-badge {{ $growthPercent >= 0 ? 'up' : 'down' }}">
                        <i class="fa-solid fa-arrow-trend-{{ $growthPercent >= 0 ? 'up' : 'down' }}"></i>
                        {{ $growthPercent >= 0 ? '+' : '' }}{{ $growthPercent }}% from target
                    </div>
                    <div class="stat-sub">IDR {{ number_format($revenueThisWeek, 0, ',', '.') }} (week)<br>IDR {{ number_format($revenueThisMonth, 0, ',', '.') }} (month)</div>
                </div>

                {{-- Expenses --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Expenses
                        <div class="stat-label-right">
                            <div class="stat-icon orange"><i class="fa-solid fa-cart-shopping"></i></div>
                            <div class="dots-wrapper">
                                <div class="three-dots" id="expenseDotsBtn" onclick="toggleDropdown(event, 'expenseDropdown')">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </div>
                                <div class="dropdown" id="expenseDropdown">
                                    <div class="dropdown-item" onclick="openModal('overlayExpense'); closeAllDropdowns()">
                                        <i class="fa-solid fa-file-circle-plus"></i> Request Expense
                                    </div>
                                    <div class="dropdown-item" onclick="openModal('overlayLpj'); closeAllDropdowns()">
                                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload LPJ
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-value">IDR {{ number_format($totalExpenses, 0, ',', '.') }}</div>
                    <div class="progress-bar"><div class="progress-fill" style="width: {{ $expenseRatio }}%;"></div></div>
                    <div class="stat-sub" style="margin-bottom:6px;">{{ $expenseRatio }}% of revenue allocated</div>
                    <div class="stat-sub">Operational: IDR {{ number_format($expensesOperational, 0, ',', '.') }}<br>Maintenance: IDR {{ number_format($expensesMaintenance, 0, ',', '.') }}</div>
                </div>

                {{-- Net Profit --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Net Profit
                        <div class="stat-icon green"><i class="fa-solid fa-building-columns"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format($netProfit, 0, ',', '.') }}</div>
                    <div class="stat-badge {{ $netProfit >= 0 ? 'healthy' : '' }}">
                        <i class="fa-solid fa-circle-check"></i> {{ $netProfit >= 0 ? 'Healthy' : 'Loss' }}
                    </div>
                    <div class="stat-sub">{{ $profitMargin }}% margin achieved this period</div>
                </div>

                {{-- Growth --}}
                <div class="stat-card growth-card">
                    <div class="stat-label">
                        Growth
                        <div class="stat-icon green"><i class="fa-solid fa-chart-line"></i></div>
                    </div>
                    <div class="stat-value">{{ $growthPercent >= 0 ? '+' : '' }}{{ $growthPercent }}%</div>
                    <div class="stat-sub" style="margin-bottom:4px; color:#8A9A8E; font-size:12px;">Vs last month (IDR {{ number_format($revenueLastMonth, 0, ',', '.') }})</div>
                    <div class="growth-row"><span>Daily Growth</span><span class="growth-val">{{ $dailyGrowth >= 0 ? '+' : '' }}{{ $dailyGrowth }}%</span></div>
                    <div class="growth-row"><span>Weekly Growth</span><span class="growth-val">{{ $weeklyGrowth >= 0 ? '+' : '' }}{{ $weeklyGrowth }}%</span></div>
                    <div class="growth-row"><span>Monthly Avg</span><span class="growth-val">{{ $growthPercent >= 0 ? '+' : '' }}{{ $growthPercent }}%</span></div>
                </div>

            </div>{{-- /stats-grid --}}

            {{-- ===== CHARTS ===== --}}
            <div class="charts-row">

                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Revenue Statistics</div>
                        <div class="chart-filter">Unit: IDR &nbsp; Day <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></div>
                    </div>
                    <div class="chart-body">
                        @php
                            $ymax = $revenueMax;
                            $steps = 5;
                            $stepVal = $ymax > 0 ? ceil($ymax / $steps / 100000) * 100000 : 100000;
                        @endphp
                        <div class="y-axis">
                            @for ($s = $steps; $s >= 0; $s--)
                                <div class="y-label">IDR {{ number_format($s * $stepVal, 0, ',', '.') }}</div>
                            @endfor
                        </div>
                        <div class="bar-chart">
                            @foreach ($revenueLabels as $i => $label)
                                <div class="bar-wrap">
                                    <div class="bar" style="height: {{ $revenueMax > 0 ? ($revenueData[$i] / $revenueMax) * 100 : 0 }}%"></div>
                                    <div class="bar-label">{{ $label }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Financial Trend</div>
                        <div class="chart-filter">Day <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></div>
                    </div>
                    <div class="area-chart-wrap">
                        <svg width="100%" height="160" viewBox="0 0 400 160" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="areaGrad1" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#D9864A" stop-opacity="0.2"/>
                                    <stop offset="100%" stop-color="#D9864A" stop-opacity="0"/>
                                </linearGradient>
                                <linearGradient id="areaGrad2" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#4B9960" stop-opacity="0.15"/>
                                    <stop offset="100%" stop-color="#4B9960" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <path d="{{ $pathTarget }}" stroke="#D9864A" stroke-width="2" fill="none"/>
                            <path d="{{ $pathTargetArea }}" fill="url(#areaGrad1)"/>
                            <path d="{{ $pathRevenue }}" stroke="#4B9960" stroke-width="2" fill="none"/>
                            <path d="{{ $pathRevenueArea }}" fill="url(#areaGrad2)"/>
                        </svg>
                    </div>
                    <div class="area-legend">
                        <div class="legend-item"><div class="legend-dot orange-dot"></div> Revenue Target</div>
                        <div class="legend-item"><div class="legend-dot green-dot"></div> Actual Income</div>
                    </div>
                </div>

            </div>{{-- /charts-row --}}

            {{-- ===== TABLE ===== --}}
            <div class="table-card">
                <div class="table-header">
                    <div class="table-title">Recent Financial Transactions</div>
                    <a href="#" class="view-all-link">View All <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $t)
                        <tr>
                            <td>#{{ $t['id'] }}</td>
                            <td>{{ $t['description'] }}</td>
                            <td><span class="category-badge">{{ $t['category'] }}</span></td>
                            <td>
                                @if ($t['type'] === 'Income')
                                    <span class="type-income"><i class="fa-solid fa-arrow-down"></i> Income</span>
                                @else
                                    <span class="type-expense"><i class="fa-solid fa-arrow-up"></i> Expense</span>
                                @endif
                            </td>
                            <td><strong>IDR {{ number_format($t['amount'], 0, ',', '.') }}</strong></td>
                            <td><div class="action-dots"><i class="fa-solid fa-ellipsis"></i></div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>{{-- /content-area.page-revenue --}}
    </div>{{-- /main-content --}}
</div>{{-- /dashboard-container --}}

{{-- Modals --}}
@include('admin.modal-expense')
@include('admin.modal-lpj')

<script>
/* ── Sidebar toggle (dari dashboard.css / layout bawaan) ── */
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

/* ── Dropdown ── */
function toggleDropdown(e, id) {
    e.stopPropagation();
    const dd = document.getElementById(id);
    const isOpen = dd.classList.contains('open');
    closeAllDropdowns();
    if (!isOpen) dd.classList.add('open');
}

function closeAllDropdowns() {
    document.querySelectorAll('.dots-wrapper .dropdown').forEach(d => d.classList.remove('open'));
}

document.addEventListener('click', closeAllDropdowns);

/* ── Modal ── */
function openModal(id) {
    closeAllDropdowns();
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

/* Klik backdrop menutup modal */
document.querySelectorAll('.overlay').forEach(overlay => {
    overlay.addEventListener('click', e => {
        if (e.target === overlay) closeModal(overlay.id);
    });
});

/* ESC */
window.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    document.querySelectorAll('.overlay.open').forEach(m => closeModal(m.id));
    setSidebarOpen(false);
});
</script>

</body>
</html>