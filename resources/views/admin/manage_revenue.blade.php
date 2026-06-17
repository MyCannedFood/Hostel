@php
    $admin = auth('admin')->user();
@endphp



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlaSare - Revenue Overview</title>

    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&family=Be+Vietnam+Pro:wght@400;500;600;700&family=Libre+Caslon+Text:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

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

        {{-- Page content --}}
        {{-- FIX: tambah class .page-revenue sebagai namespace CSS --}}
            <div class="content-area page-revenue">

            <h1 class="page-title">Revenue Overview</h1>

            {{-- ===== STAT CARDS ===== --}}
            <div class="stats-grid">

                {{-- Revenue (match finance-accounting: Total Cash In) --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Revenue
                        <div class="stat-icon green"><i class="fa-solid fa-wallet"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format($totalCashIn ?? $totalRevenue, 0, ',', '.') }}</div>
                    <div class="stat-badge {{ ($totalCashIn ?? $totalRevenue) > 0 ? 'up' : 'down' }}">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        {{ ($totalCashIn ?? $totalRevenue) > 0 ? 'Active' : 'No income' }}
                    </div>
                    <div class="stat-sub">Total Cash In</div>
                </div>

                {{-- Expenses (match finance-accounting: Total Cash Out) --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Expenses
                        <div class="stat-label-right">
                            <div class="stat-icon orange"><i class="fa-solid fa-cart-shopping"></i></div>
                        </div>
                    </div>
                    <div class="stat-value">IDR {{ number_format($totalCashOut ?? $totalExpenses, 0, ',', '.') }}</div>
                    <div class="progress-bar"><div class="progress-fill" style="width: {{ ($totalCashIn ?? $totalRevenue) > 0 ? round(($totalCashOut / $totalCashIn) * 100) : 0 }}%;"></div></div>
                    <div class="stat-sub" style="margin-bottom:6px;">{{ ($totalCashIn ?? $totalRevenue) > 0 ? round(($totalCashOut / $totalCashIn) * 100) : 0 }}% of revenue allocated</div>
                    <div class="stat-sub">Cash Out</div>
                </div>

                {{-- Net Profit (same) --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Net Profit
                        <div class="stat-icon green"><i class="fa-solid fa-building-columns"></i></div>
                    </div>
                    <div class="stat-value">IDR {{ number_format($netProfit, 0, ',', '.') }}</div>
                    <div class="stat-badge {{ $netProfit >= 0 ? 'healthy' : '' }}">
                        <i class="fa-solid fa-circle-check"></i> {{ $netProfit >= 0 ? 'Healthy' : 'Deficit' }}
                    </div>
                    <div class="stat-sub">
                        {{ ($totalCashIn ?? $totalRevenue) > 0 ? round(($netProfit / ($totalCashIn ?? $totalRevenue)) * 100, 1) . '% margin' : 'No income yet' }}
                    </div>
                </div>

                {{-- Growth (hasil perhitungan keuntungan/pengeluaran) --}}
                <div class="stat-card growth-card">
                    <div class="stat-label">
                        Growth
                        <div class="stat-icon green"><i class="fa-solid fa-chart-line"></i></div>
                    </div>
                    @php
                        $growthFromKPI = ($totalCashIn ?? $totalRevenue) > 0
                            ? round((($totalCashIn ?? $totalRevenue) - ($totalCashOut ?? $totalExpenses)) / ($totalCashIn ?? $totalRevenue) * 100, 1)
                            : 0;
                    @endphp
                    <div class="stat-value">{{ $growthFromKPI >= 0 ? '+' : '' }}{{ $growthFromKPI }}%</div>
                    <div class="stat-sub" style="margin-bottom:4px; color:#8A9A8E; font-size:12px;">Net Profit margin vs Cash In</div>
                    <div class="growth-row"><span>Cash In</span><span class="growth-val">IDR {{ number_format($totalCashIn ?? $totalRevenue, 0, ',', '.') }}</span></div>
                    <div class="growth-row"><span>Cash Out</span><span class="growth-val">IDR {{ number_format($totalCashOut ?? $totalExpenses, 0, ',', '.') }}</span></div>
                    <div class="growth-row"><span>Net Profit</span><span class="growth-val">IDR {{ number_format($netProfit, 0, ',', '.') }}</span></div>
                </div>

            </div>{{-- /stats-grid --}}


            {{-- ===== CHARTS ===== --}}
            <div class="charts-row">

                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Revenue Statistics</div>
                        <div class="chart-filter">Unit: IDR &nbsp; Day <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></div>
                    </div>
                    <div class="chart-body" style="position:relative; height:220px;">
                        <canvas id="revenueStatChart"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Financial Trend</div>
                        <div class="chart-filter">Day <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></div>
                    </div>
                    <div class="chart-body" style="position:relative; height:220px;">
                        <canvas id="financialTrendChart"></canvas>
                    </div>
                    <div class="area-legend" style="margin-top:10px;">
                        <div class="legend-item"><div class="legend-dot orange-dot" style="background:#d9864a;"></div> Cash Out</div>
                        <div class="legend-item"><div class="legend-dot green-dot" style="background:#26A7A9;"></div> Cash In</div>
                    </div>
                </div>

            </div>{{-- /charts-row --}}


            {{-- ===== TABLE ===== --}}
            <div class="table-card">
                <div class="table-header">
                    <div class="table-title">Recent Financial Transactions</div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Trans ID</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="recentTransactionsBody">
                            @foreach ($transactions as $t)
                        <tr class="recent-transaction-row">
                            <td>{{ $t['id'] }}</td>
                            <td>{{ $t['date'] ?? '—' }}</td>
                            <td>{{ $t['description'] }}</td>
                            <td>{{ $t['category'] }}</td>
                            <td>{{ $t['type'] }}</td>
                            <td>{{ number_format($t['amount'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                {{-- Pagination (same style/logic as Master General Ledger) --}}
                <div class="finance-ledger-foot recent-transactions-foot" id="recentTransactionsPaginationWrap" style="{{ count($transactions) <= 5 ? 'display:none;' : '' }}">
                    <span id="recentTransactionsMeta"></span>
                    <div class="recent-transactions-pagination-inner">
                        <button type="button" class="finance-page-btn" id="recentPrevBtn">Prev</button>
                        <div id="recentPageNumbers" class="recent-transactions-page-numbers"></div>
                        <button type="button" class="finance-page-btn" id="recentNextBtn">Next</button>
                    </div>
                </div>
            </div>



        </div>{{-- /content-area.page-revenue --}}
    </div>{{-- /main-content --}}
</div>{{-- /dashboard-container --}}

{{-- Modals --}}
@include('admin.modal-expense')
@include('admin.modal-lpj')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Pagination — make it look like finance-accounting */
    #recentTransactionsPaginationWrap .finance-page-btn {
        padding: 4px 12px;
        border: 1px solid #dde3de;
        border-radius: 4px;
        background: #fff;
        cursor: pointer;
        font-size: 12px;
        color: #3a5a40;
        transition: background 0.18s;
    }
    #recentTransactionsPaginationWrap .finance-page-btn:hover { background: #edf1ed; }
    #recentTransactionsPaginationWrap .finance-page-btn:disabled { opacity: 0.4; cursor: default; }

    #recentTransactionsPaginationWrap .finance-page-num,
    #recentTransactionsPaginationWrap .recent-transactions-page-numbers > div.finance-page-num {
        width: 28px; height: 28px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid #dde3de;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        color: #3a5a40;
        transition: background 0.18s;
    }
    #recentTransactionsPaginationWrap .finance-page-num.active { background: #3a5a40; color: #fff; border-color: #3a5a40; }
    #recentTransactionsPaginationWrap .finance-page-num:hover:not(.active) { background: #edf1ed; }

    #recentTransactionsPaginationWrap .recent-transactions-page-numbers {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    #recentTransactionsPaginationWrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #7a857f;
        font-size: 10px;
        padding-top: 10px;
    }
    #recentTransactionsPaginationWrap .recent-transactions-pagination-inner,
    #recentTransactionsPaginationWrap .recent-transactions-pagination-inner {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* fallback for inner wrapper that we don't explicitly style */
    #recentTransactionsPaginationWrap > div:not(#recentTransactionsPaginationWrap) {
        display: flex;
        gap: 8px;
        align-items: center;
    }
</style>

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

/* ── Generic Pagination (same as finance-accounting) ── */
function initTablePagination({ rowSelector, prevBtnId, nextBtnId, pageNumbersId, metaId, pageSize = 5, wrapId = null }) {
    const allRows   = Array.from(document.querySelectorAll(rowSelector));
    const prevBtn   = document.getElementById(prevBtnId);
    const nextBtn   = document.getElementById(nextBtnId);
    const pageNums  = document.getElementById(pageNumbersId);
    const metaEl    = document.getElementById(metaId);
    const wrapEl    = wrapId ? document.getElementById(wrapId) : null;

    let currentPage = 1;
    const totalPages = Math.ceil(allRows.length / pageSize);

    if (wrapEl && allRows.length <= pageSize) {
        wrapEl.style.display = 'none';
    }

    function render() {
        const start = (currentPage - 1) * pageSize;
        const end   = start + pageSize;

        allRows.forEach((row, idx) => {
            row.style.display = idx >= start && idx < end ? '' : 'none';
        });

        const from = allRows.length === 0 ? 0 : start + 1;
        const to   = Math.min(end, allRows.length);
        if (metaEl) metaEl.textContent = `Showing ${from}–${to} of ${allRows.length}`;

        if (prevBtn) prevBtn.disabled = currentPage <= 1;
        if (nextBtn) nextBtn.disabled = currentPage >= totalPages;

        if (pageNums) {
            pageNums.innerHTML = '';
            const startP = Math.max(1, currentPage - 2);
            const endP   = Math.min(totalPages, currentPage + 2);
            for (let p = startP; p <= endP; p++) {
                const el = document.createElement('div');
                el.className = 'finance-page-num' + (p === currentPage ? ' active' : '');
                el.textContent = p;
                el.addEventListener('click', () => {
                    currentPage = p;
                    render();
                });
                pageNums.appendChild(el);
            }
        }
    }

    prevBtn?.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            render();
        }
    });
    nextBtn?.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            render();
        }
    });

    if (allRows.length > 0) render();
}

// Init pagination Recent Transactions
// Init pagination Recent Transactions
if (document.getElementById('recentTransactionsPaginationWrap')) {
    initTablePagination({
        rowSelector:   '#recentTransactionsBody .recent-transaction-row',
        prevBtnId:     'recentPrevBtn',
        nextBtnId:     'recentNextBtn',
        pageNumbersId: 'recentPageNumbers',
        metaId:        'recentTransactionsMeta',
        wrapId:        'recentTransactionsPaginationWrap',
        pageSize:      5,
    });
}
</script>


<script>
    // ── Revenue Statistics Chart (match finance-accounting) ──
    const revenueStatCtx = document.getElementById('revenueStatChart')?.getContext('2d');
    if (revenueStatCtx) {
        const revenueData   = {!! json_encode($revenueData) !!};
        const revenueLabels = {!! json_encode($revenueLabels) !!};

        new Chart(revenueStatCtx, {
            type: 'bar',
            data: {
                labels: revenueLabels,
                datasets: [{
                    data: revenueData,
                    backgroundColor: '#26A7A9',
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'IDR ' + ctx.parsed.y.toLocaleString('id-ID'),
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: {
                            callback: val => {
                                if (val >= 1000000) return (val / 1000000) + 'M';
                                if (val >= 1000) return (val / 1000) + 'K';
                                return val;
                            }
                        }
                    }
                }
            }
        });
    }

        // ── Financial Trend Chart (Cash In vs Cash Out) ──
    const trendCtx = document.getElementById('financialTrendChart')?.getContext('2d');
    if (trendCtx) {
        const trendLabels  = {!! json_encode($trendLabels) !!};
        const trendCashIn  = {!! json_encode($trendCashIn) !!};
        const trendCashOut = {!! json_encode($trendCashOut) !!};


        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [
                    {
                        label: 'Cash In',
                        data: trendCashIn,
                        borderColor: '#26A7A9',
                        backgroundColor: 'rgba(38,167,169,0.12)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#26A7A9',
                    },
                    {
                        label: 'Cash Out',
                        data: trendCashOut,
                        borderColor: '#d9864a',
                        backgroundColor: 'rgba(217,134,74,0.12)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#d9864a',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.dataset.label + ': IDR ' + ctx.parsed.y.toLocaleString('id-ID'),
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: {
                            callback: val => {
                                if (val >= 1000000) return (val / 1000000) + 'M';
                                if (val >= 1000) return (val / 1000) + 'K';
                                return val;
                            }
                        }
                    }
                }
            }
        });
    }
</script>


</body>
</html>

