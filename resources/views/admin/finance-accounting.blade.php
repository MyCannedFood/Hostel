<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Accounting - AlaSare</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/dashboard.css', 'resources/css/finance-accounting.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <x-admin_sidenavbar />
        <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>

        <main class="main-content">
            <header class="header">
                <button type="button" class="hamburger mobile-only" id="sidebarToggle" aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                    <span></span><span></span><span></span>
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
                </div>

                {{-- ===== KPI CARDS ===== --}}
                <section class="finance-kpi-grid" aria-label="Finance summary">

                    {{-- Total Cash In --}}
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
                        <strong>IDR {{ number_format($totalCashIn, 0, ',', '.') }}</strong>
                        @if($totalCashIn > 0)
                            <p class="positive"><i class="fa-solid fa-arrow-up"></i> From income sources</p>
                        @else
                            <p style="color:#7a857f; font-size:12px;">No income recorded yet</p>
                        @endif
                    </article>

                    {{-- Total Cash Out --}}
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
                        <strong>IDR {{ number_format($totalCashOut, 0, ',', '.') }}</strong>
                        @if($totalCashOut > 0)
                            <p class="warning">From accountability reports</p>
                        @else
                            <p style="color:#7a857f; font-size:12px;">No expenditure recorded yet</p>
                        @endif
                    </article>

                    <article class="finance-kpi-card">
                        <div class="finance-kpi-top">
                            <span>Net Profit</span>
                            <span class="finance-kpi-icon {{ $netProfit >= 0 ? 'green' : 'orange' }}">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4 19h16"></path>
                                    <path d="M7 16V9"></path>
                                    <path d="M12 16V5"></path>
                                    <path d="M17 16v-4"></path>
                                    <path d="m15 7-3-3-3 3"></path>
                                </svg>
                            </span>
                        </div>
                        <strong>IDR {{ number_format($netProfit, 0, ',', '.') }}</strong>
                        @if($netProfit > 0)
                            <p><span class="healthy-badge">Healthy</span></p>
                        @elseif($netProfit < 0)
                            <p><span class="healthy-badge" style="background:#fdf0e6; color:#d9864a;">Deficit</span></p>
                        @else
                            <p><span class="healthy-badge" style="background:#f4f5f2; color:#7a857f;">Break Even</span></p>
                        @endif
                        <small>
                            {{ $totalCashIn > 0 ? round(($netProfit / $totalCashIn) * 100, 1) . '% margin' : 'No income yet' }}
                        </small>
                    </article>

                    {{-- Pending Actions — dari database --}}
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
                        <strong id="pendingCount">{{ $pendingRequests->count() }} Request</strong>
                        @php $pendingByType = $pendingRequests->groupBy('type'); @endphp
                        @foreach($pendingByType as $type => $items)
                            <small>{{ $items->count() }} {{ $type }} request</small>
                        @endforeach
                        @if($pendingRequests->isEmpty())
                            <small>No pending requests</small>
                        @endif
                    </article>

                </section>
                {{-- ===== CHARTS ===== --}}
                <section class="finance-chart-grid">

                    {{-- Revenue Statistics --}}
                    <article class="finance-panel">
                        <div class="finance-panel-head">
                            <h2>Revenue Statistics</h2>
                            <span>Unit: IDR | Day</span>
                        </div>
                        <div style="position:relative; height:220px;">
                            <canvas id="revenueStatChart"></canvas>
                        </div>
                    </article>

                    {{-- Financial Trend --}}
                    <article class="finance-panel">
                        <div class="finance-panel-head">
                            <h2>Financial Trend</h2>
                            <span>Weekly</span>
                        </div>
                        <div style="position:relative; height:220px;">
                            <canvas id="financialTrendChart"></canvas>
                        </div>
                        <div class="finance-legend" style="margin-top:12px;">
                            <span><i style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#26A7A9;margin-right:5px;"></i> Cash In</span>
                            <span><i style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#d9864a;margin-right:5px;"></i> Cash Out</span>
                        </div>
                    </article>

                </section>

                {{-- ===== PENDING APPROVALS ===== --}}
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
                                    <th>Requested By</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="pendingApprovalsBody">
                                @forelse($pendingRequests as $req)
                                <tr id="pending-row-{{ $req->id }}" class="pending-approval-row">
                                    <td>{{ $req->created_at->format('d M Y') }}</td>
                                    <td>{{ $req->requested_by ?? '—' }}</td>
                                    <td><span class="tag {{ $req->type === 'Operational' ? 'green' : 'muted' }}">{{ $req->type }}</span></td>
                                    <td>{{ $req->title }}</td>
                                    <td>IDR {{ number_format($req->estimated_total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn-approve-action" onclick="handleApproveReject({{ $req->id }}, 'approve')">Approve</button>
                                        <button class="btn-approve-action reject" onclick="handleApproveReject({{ $req->id }}, 'reject')">Reject</button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="pending-empty-row">
                                    <td colspan="6" style="text-align:center; padding:24px; color:#7a857f;">No pending requests</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Pending Approvals --}}
                    <div class="finance-ledger-foot" id="pendingPaginationWrap" style="{{ $pendingRequests->count() <= 5 ? 'display:none;' : '' }}">
                        <span id="pendingMeta"></span>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <button type="button" class="finance-page-btn" id="pendingPrevBtn">Prev</button>
                            <div id="pendingPageNumbers" style="display:flex; gap:6px;"></div>
                            <button type="button" class="finance-page-btn" id="pendingNextBtn">Next</button>
                        </div>
                    </div>
                </section>

                {{-- ===== MASTER GENERAL LEDGER ===== --}}
                <section class="finance-panel finance-ledger-panel">
                    <div class="finance-table-title ledger">
                        <h2>Master General Ledger</h2>
                        <small id="ledgerLastUpdated">
                            @if($ledgerEntries->count() > 0)
                                Last updated: {{ $ledgerEntries->first()->created_at->diffForHumans() }}
                            @else
                                No entries yet
                            @endif
                        </small>
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
                                </tr>
                            </thead>
                            <tbody id="ledgerBody">
                                @forelse($ledgerEntries as $entry)
                                <tr class="ledger-row">
                                    <td>{{ $entry->trans_code }}</td>
                                    <td>{{ $entry->created_at->format('d-m-y') }}</td>
                                    <td>{{ $entry->description }}</td>
                                    <td>{{ $entry->category }}</td>
                                    <td><span class="type {{ strtolower($entry->type) }}">{{ $entry->type }}</span></td>
                                    <td>{{ number_format($entry->amount, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr id="ledger-empty-row">
                                    <td colspan="6" style="text-align:center; padding:24px; color:#7a857f;">No ledger entries yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination General Ledger --}}
                    <div class="finance-ledger-foot">
                        <span id="ledgerMeta"></span>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <button type="button" class="finance-page-btn" id="ledgerPrevBtn">Prev</button>
                            <div id="ledgerPageNumbers" style="display:flex; gap:6px;"></div>
                            <button type="button" class="finance-page-btn" id="ledgerNextBtn">Next</button>
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>

    <style>
        .finance-page-btn {
            padding: 4px 12px;
            border: 1px solid #dde3de;
            border-radius: 4px;
            background: #fff;
            cursor: pointer;
            font-size: 12px;
            color: #3a5a40;
            transition: background 0.18s;
        }
        .finance-page-btn:hover { background: #edf1ed; }
        .finance-page-btn:disabled { opacity: 0.4; cursor: default; }
        .finance-page-num {
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid #dde3de; border-radius: 4px;
            cursor: pointer; font-size: 12px; color: #3a5a40;
            transition: background 0.18s;
        }
        .finance-page-num.active { background: #3a5a40; color: #fff; border-color: #3a5a40; }
        .finance-page-num:hover:not(.active) { background: #edf1ed; }
    </style>

    <script>
        /* ── Sidebar ── */
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
            sidebarToggle.addEventListener('click', () => setSidebarOpen(!sidebar.classList.contains('open')));
            sidebarBackdrop.addEventListener('click', () => setSidebarOpen(false));
            window.addEventListener('keydown', e => { if (e.key === 'Escape') setSidebarOpen(false); });
            window.addEventListener('resize', () => { if (window.innerWidth >= 1024) setSidebarOpen(false); });
        }

        /* ── Generic Pagination ── */
        function initTablePagination({ rowSelector, prevBtnId, nextBtnId, pageNumbersId, metaId, pageSize = 5, wrapId = null }) {
            const allRows  = Array.from(document.querySelectorAll(rowSelector));
            const prevBtn  = document.getElementById(prevBtnId);
            const nextBtn  = document.getElementById(nextBtnId);
            const pageNums = document.getElementById(pageNumbersId);
            const metaEl   = document.getElementById(metaId);
            const wrapEl   = wrapId ? document.getElementById(wrapId) : null;

            let currentPage = 1;
            const totalPages = Math.ceil(allRows.length / pageSize);

            // Sembunyikan wrap pagination kalau data <= pageSize
            if (wrapEl && allRows.length <= pageSize) {
                wrapEl.style.display = 'none';
            }

            function render() {
                const start = (currentPage - 1) * pageSize;
                const end   = start + pageSize;

                allRows.forEach((row, idx) => {
                    row.style.display = idx >= start && idx < end ? '' : 'none';
                });

                // Meta
                const from = allRows.length === 0 ? 0 : start + 1;
                const to   = Math.min(end, allRows.length);
                if (metaEl) metaEl.textContent = `Showing ${from}–${to} of ${allRows.length}`;

                // Buttons
                if (prevBtn) prevBtn.disabled = currentPage <= 1;
                if (nextBtn) nextBtn.disabled = currentPage >= totalPages;

                // Page numbers
                if (pageNums) {
                    pageNums.innerHTML = '';
                    const startP = Math.max(1, currentPage - 2);
                    const endP   = Math.min(totalPages, currentPage + 2);
                    for (let p = startP; p <= endP; p++) {
                        const el = document.createElement('div');
                        el.className   = 'finance-page-num' + (p === currentPage ? ' active' : '');
                        el.textContent = p;
                        el.addEventListener('click', () => { currentPage = p; render(); });
                        pageNums.appendChild(el);
                    }
                }
            }

            prevBtn?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; render(); } });
            nextBtn?.addEventListener('click', () => { if (currentPage < totalPages) { currentPage++; render(); } });

            if (allRows.length > 0) render();
        }

        // Init pagination Pending Approvals
        initTablePagination({
            rowSelector:  '#pendingApprovalsBody .pending-approval-row',
            prevBtnId:    'pendingPrevBtn',
            nextBtnId:    'pendingNextBtn',
            pageNumbersId:'pendingPageNumbers',
            metaId:       'pendingMeta',
            wrapId:       'pendingPaginationWrap',
            pageSize:     5,
        });

        // Init pagination General Ledger
        initTablePagination({
            rowSelector:  '#ledgerBody .ledger-row',
            prevBtnId:    'ledgerPrevBtn',
            nextBtnId:    'ledgerNextBtn',
            pageNumbersId:'ledgerPageNumbers',
            metaId:       'ledgerMeta',
            pageSize:     5,
        });

        /* ── Approve / Reject ── */
        async function handleApproveReject(id, action) {
            if (!confirm(action === 'approve' ? 'Approve budget request ini?' : 'Reject budget request ini?')) return;

            let notes = '';
            if (action === 'reject') {
                notes = prompt('Alasan penolakan (opsional):') || '';
            }

            try {
                const res = await fetch('{{ route("admin.finance.approve-reject") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ id, action, notes }),
                });

                if (!res.ok) throw new Error('Request failed');
                const json = await res.json();

                if (json.success) {
                    // Hapus row
                    const row = document.getElementById('pending-row-' + id);
                    if (row) row.remove();

                    // Cek kalau kosong
                    const tbody = document.getElementById('pendingApprovalsBody');
                    if (tbody && tbody.querySelectorAll('.pending-approval-row').length === 0) {
                        tbody.innerHTML = `
                            <tr id="pending-empty-row">
                                <td colspan="6" style="text-align:center; padding:24px; color:#7a857f;">
                                    No pending requests
                                </td>
                            </tr>`;
                        // Sembunyikan pagination
                        const wrap = document.getElementById('pendingPaginationWrap');
                        if (wrap) wrap.style.display = 'none';
                    }

                    // Update counter
                    const pendingCount = document.getElementById('pendingCount');
                    if (pendingCount) {
                        const current = parseInt(pendingCount.textContent) || 0;
                        pendingCount.textContent = Math.max(0, current - 1) + ' Request';
                    }

                    // Re-init pagination pending setelah row dihapus
                    initTablePagination({
                        rowSelector:   '#pendingApprovalsBody .pending-approval-row',
                        prevBtnId:     'pendingPrevBtn',
                        nextBtnId:     'pendingNextBtn',
                        pageNumbersId: 'pendingPageNumbers',
                        metaId:        'pendingMeta',
                        wrapId:        'pendingPaginationWrap',
                        pageSize:      5,
                    });
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan, silakan coba lagi.');
            }
        }
    </script>

    <script>
        // ── Revenue Statistics Chart ──
        const revenueStatCtx = document.getElementById('revenueStatChart')?.getContext('2d');
        if (revenueStatCtx) {
            const revenueData   = {!! json_encode($revenueData) !!};
            const revenueLabels = {!! json_encode($revenueLabels) !!};
            const maxRevenue    = Math.max(...revenueData, 1);

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
                                    if (val >= 1000)    return (val / 1000) + 'K';
                                    return val;
                                }
                            }
                        }
                    }
                }
            });
        }

        // ── Financial Trend Chart ──
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
                                    if (val >= 1000)    return (val / 1000) + 'K';
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