{{-- resources/views/admin/budgeting.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AlaSare – Budgeting</title>

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

    <x-admin_sidenavbar />
    <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>

    <div class="main-content">

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

        <div class="content-area page-budgeting">

            {{-- Page header --}}
            <div class="page-header">
                <h1 class="page-title">Budgeting</h1>
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
                    <div class="stat-value" data-stat="approved_budget">IDR 0</div>
                    <div class="stat-badge up">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span data-stat="spent_pct_text">—</span>
                    </div>
                </div>

                {{-- Total Savings --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Total Savings
                        <div class="stat-icon green"><i class="fa-solid fa-piggy-bank"></i></div>
                    </div>
                    <div class="stat-value" data-stat="total_savings">IDR 0</div>
                    <div class="stat-badge up">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span data-stat="savings_text">—</span>
                    </div>
                </div>

                {{-- Total Actual Spent --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Total Actual Spent
                        <div class="stat-icon orange"><i class="fa-solid fa-money-bill-wave"></i></div>
                    </div>
                    <div class="stat-value" data-stat="total_spent">IDR 0</div>
                    <div class="progress-bar">
                        <div class="progress-fill fill-orange" data-stat-bar="spent_pct" style="width:0%"></div>
                    </div>
                    <div class="stat-sub" data-stat-sub="spent_pct">0% of total budget used</div>
                </div>

                {{-- Remaining Balance --}}
                <div class="stat-card">
                    <div class="stat-label">
                        Remaining Balance
                        <div class="stat-icon green"><i class="fa-solid fa-wallet"></i></div>
                    </div>
                    <div class="stat-value" data-stat="remaining_balance">IDR 0</div>
                    <div class="progress-bar">
                        <div class="progress-fill fill-green" data-stat-bar="remaining_pct" style="width:0%"></div>
                    </div>
                    <div class="stat-sub" data-stat-sub="remaining_pct">0% remaining</div>
                </div>

            </div>{{-- /stats-grid --}}

            {{-- ===== MID ROW ===== --}}
            <div class="mid-row">

                {{-- Budget Distribution --}}
                <div class="card">
                    <div class="card-title">Budget Distribution by Category</div>
                    <div class="card-sub">
                        Analysis of total expenditures across primary operational departments.
                    </div>

                    <div class="donut-layout">
                        <div class="donut-left">
                            <div class="donut-wrap">
                                <svg viewBox="0 0 148 148" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="74" cy="74" r="55" fill="none" stroke="#edf1ed" stroke-width="20"/>
                                    <circle cx="74" cy="74" r="55" fill="none" stroke="#4b9960" stroke-width="20"
                                        stroke-dasharray="138.2 207.3" stroke-dashoffset="86.4"/>
                                    <circle cx="74" cy="74" r="55" fill="none" stroke="#b8d9a0" stroke-width="20"
                                        stroke-dasharray="103.7 241.8" stroke-dashoffset="-51.8"/>
                                    <circle cx="74" cy="74" r="55" fill="none" stroke="#d9864a" stroke-width="20"
                                        stroke-dasharray="69.1 276.4" stroke-dashoffset="-155.5"/>
                                    <circle cx="74" cy="74" r="55" fill="none" stroke="#d8e8da" stroke-width="20"
                                        stroke-dasharray="34.6 310.9" stroke-dashoffset="-224.6"/>
                                </svg>
                                <div class="donut-center">
                                    <div class="donut-center-value">100%</div>
                                    <div class="donut-center-label">Total</div>
                                </div>
                            </div>

                            <div class="budget-summary">
                                <div class="summary-card">
                                    <span>Total Budget</span>
                                    <strong id="budgetTotalSummary">IDR 0</strong>
                                </div>
                                <div class="summary-card">
                                    <span>Highest Spending</span>
                                    <strong id="budgetHighestCategory">—</strong>
                                </div>
                                <div class="summary-card">
                                    <span>Lowest Spending</span>
                                    <strong id="budgetLowestCategory">—</strong>
                                </div>
                                <div class="summary-card">
                                    <span>Monthly Growth</span>
                                    <strong style="color:#4b9960;" id="budgetMonthlyGrowth">—</strong>
                                </div>
                            </div>
                        </div>

                        <div class="category-list" id="budgetCategoryList">
                            {{-- Diisi JS --}}
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
                    {{-- Diisi JS --}}
                </div>{{-- /Top Requestors --}}

            </div>{{-- /mid-row --}}

            {{-- ===== BUDGET REQUESTS TABLE ===== --}}
            <div class="table-card">
                <div class="table-header">
                    <div class="table-title">Budget Requests</div>
                    <div class="table-filters">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="searchInput" placeholder="Search report title...">
                        </div>

                        {{-- Filter Category --}}
                        <div class="filter-dropdown-wrap" id="filterCategoryWrap">
                            <div class="filter-btn" id="filterCategoryBtn">
                                Category <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
                            </div>
                            <div class="filter-dropdown-menu" id="filterCategoryMenu" hidden>
                                <div class="filter-dropdown-item" data-value="">All Categories</div>
                                <div class="filter-dropdown-item" data-value="Maintenance">Maintenance</div>
                                <div class="filter-dropdown-item" data-value="Operational">Operational</div>
                                <div class="filter-dropdown-item" data-value="Utilities">Utilities</div>
                                <div class="filter-dropdown-item" data-value="Marketing">Marketing</div>
                            </div>
                        </div>

                        {{-- Filter Status --}}
                        <div class="filter-dropdown-wrap" id="filterStatusWrap">
                            <div class="filter-btn" id="filterStatusBtn">
                                Status <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>
                            </div>
                            <div class="filter-dropdown-menu" id="filterStatusMenu" hidden>
                                <div class="filter-dropdown-item" data-value="">All Status</div>
                                <div class="filter-dropdown-item" data-value="Pending">Pending</div>
                                <div class="filter-dropdown-item" data-value="Approved">Approved</div>
                                <div class="filter-dropdown-item" data-value="Rejected">Rejected</div>
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
                        <tr>
                            <td colspan="7" style="padding:24px; color:#7a857f; text-align:center;">
                                Loading budget requests…
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-footer">
                    <span id="budgetRequestsMeta">Showing 0 records</span>
                    <div class="pagination">
                        <div class="page-btn" id="budgetPrevBtn">
                            <i class="fa-solid fa-chevron-left" style="font-size:10px;"></i>
                        </div>
                        <div id="budgetPageNumbers" style="display:flex; gap:8px; align-items:center;"></div>
                        <div class="page-btn" id="budgetNextBtn">
                            <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
                        </div>
                    </div>
                </div>
            </div>{{-- /table-card --}}

        </div>{{-- /content-area --}}
    </div>{{-- /main-content --}}
</div>{{-- /dashboard-container --}}

{{-- ===== MODALS ===== --}}
@include('admin.modal-expense')
@include('admin.modal-lpj')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.loadStats)    window.loadStats();
        if (window.loadRequests) window.loadRequests();
    });
</script>
@endif

<script>
/* ── Backend-driven budgeting UI ── */
(function initBudgetingUI() {
    const statsUrl    = '/admin/budgeting/stats';
    const requestsUrl = '/admin/budgeting/requests';

    function formatIDR(n) {
        return 'IDR ' + Number(n || 0).toLocaleString('id-ID');
    }

    function renderStats(stats) {
        if (!stats) return;
        const q = sel => document.querySelector(sel);

        q('[data-stat="approved_budget"]')   && (q('[data-stat="approved_budget"]').textContent   = formatIDR(stats.approved_budget));
        q('[data-stat="total_spent"]')       && (q('[data-stat="total_spent"]').textContent       = formatIDR(stats.total_spent));
        q('[data-stat="total_savings"]')     && (q('[data-stat="total_savings"]').textContent     = formatIDR(stats.total_savings));
        q('[data-stat="remaining_balance"]') && (q('[data-stat="remaining_balance"]').textContent = formatIDR(stats.remaining_balance));

        const spentPctText = q('[data-stat="spent_pct_text"]');
        const savingsText  = q('[data-stat="savings_text"]');
        spentPctText && (spentPctText.textContent = stats.spent_pct + '% used');
        savingsText  && (savingsText.textContent  = stats.remaining_pct + '% remaining');

        const spentBar     = q('[data-stat-bar="spent_pct"]');
        const remainingBar = q('[data-stat-bar="remaining_pct"]');
        spentBar     && (spentBar.style.width     = stats.spent_pct + '%');
        remainingBar && (remainingBar.style.width = stats.remaining_pct + '%');

        const spentSub  = q('[data-stat-sub="spent_pct"]');
        const remainSub = q('[data-stat-sub="remaining_pct"]');
        spentSub  && (spentSub.textContent  = stats.spent_pct + '% of total budget used');
        remainSub && (remainSub.textContent = stats.remaining_pct + '% remaining');

        const totalSummary = document.getElementById('budgetTotalSummary');
        totalSummary && (totalSummary.textContent = formatIDR(stats.approved_budget));
    }

    function renderDistribution(distribution) {
        const list = document.getElementById('budgetCategoryList');
        if (!list) return;
        list.innerHTML = '';

        const palette = ['#4b9960', '#b8d9a0', '#d9864a', '#d8e8da', '#97cbd0', '#c9a27f'];
        (distribution || []).slice(0, 6).forEach((d, idx) => {
            const color = d.color || palette[idx % palette.length];
            const row   = document.createElement('div');
            row.className = 'cat-row';
            row.innerHTML = `
                <div class="cat-dot" style="background:${color}"></div>
                <div class="cat-name">${d.label}</div>
                <div class="cat-progress">
                    <div class="cat-progress-fill" style="width:${d.pct}%; background:${color}"></div>
                </div>
                <div class="cat-pct">${d.pct}%</div>
            `;
            list.appendChild(row);
        });

        const sorted  = [...(distribution || [])].sort((a, b) => b.pct - a.pct);
        const highest = document.getElementById('budgetHighestCategory');
        const lowest  = document.getElementById('budgetLowestCategory');
        highest && (highest.textContent = sorted[0]?.label || '—');
        lowest  && (lowest.textContent  = sorted[sorted.length - 1]?.label || '—');
    }

    function renderTopRequestors(requestors) {
        const card = document.querySelector('.card .requestors-header')?.closest('.card');
        if (!card) return;
        card.querySelectorAll('.req-item').forEach(n => n.remove());

        (requestors || []).slice(0, 4).forEach(r => {
            const row = document.createElement('div');
            row.className = 'req-item';
            row.innerHTML = `
                <div class="req-avatar">${r.initials || '??'}</div>
                <div class="req-info">
                    <div class="req-name">${r.name || '—'}</div>
                    <div class="req-role">${r.role || '—'}</div>
                </div>
                <div class="req-count">
                    <div class="req-count-num">${r.count || 0}</div>
                    <div class="req-count-label">Requests</div>
                </div>
            `;
            card.appendChild(row);
        });
    }

    async function loadStats() {
        try {
            const res  = await fetch(statsUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) throw new Error('Failed stats');
            const json = await res.json();
            renderStats(json.stats);
            renderDistribution(json.distribution);
            renderTopRequestors(json.requestors);
        } catch (e) { console.warn(e); }
    }

    let currentPage    = 1;
    const pageSizeDefault = 5;
    let currentFilters = { q_title: '', status: '', category: '' };

    function renderRequestsRows(rows) {
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;
        tbody.innerHTML = '';

        if (!rows || !rows.length) {
            tbody.innerHTML = `<tr><td colspan="7" style="padding:24px; color:#7a857f; text-align:center;">Tidak ada data</td></tr>`;
            return;
        }

        rows.forEach(r => {
            const statusBadge = r.status === 'Approved'
                ? `<span class="status-badge status-approved"><i class="fa-solid fa-circle" style="font-size:7px;"></i> Approved</span>`
                : r.status === 'Pending'
                ? `<span class="status-badge status-pending"><i class="fa-solid fa-circle" style="font-size:7px;"></i> Pending</span>`
                : `<span class="status-badge status-rejected"><i class="fa-solid fa-circle" style="font-size:7px;"></i> Rejected</span>`;

            const typeBadge = `<span class="${r.type === 'Operational' ? 'type-operational' : 'type-maintenance'}">${r.type}</span>`;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="color:#7a857f;">${(r.created_at || '').slice(0, 10) || '—'}</td>
                <td><strong>${r.title || '—'}</strong></td>
                <td>${typeBadge}</td>
                <td><span class="category-badge">${r.category || '—'}</span></td>
                <td><strong>${Number(r.estimated_total_amount || 0).toLocaleString('id-ID')}</strong></td>
                <td>${statusBadge}</td>
                <td class="action-cell">
                    <button class="action-btn edit" type="button" onclick="alert('Detail: ${r.title}')">
                        <i class="fa-solid fa-eye"></i> View
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderPagination(pagination) {
        const meta        = document.getElementById('budgetRequestsMeta');
        const pageNumbers = document.getElementById('budgetPageNumbers');
        const prevBtn     = document.getElementById('budgetPrevBtn');
        const nextBtn     = document.getElementById('budgetNextBtn');
        if (!pagination) return;

        const perPage = pagination.per_page || pageSizeDefault;
        const from    = pagination.total === 0 ? 0 : (currentPage - 1) * perPage + 1;
        const to      = Math.min(currentPage * perPage, pagination.total);
        meta && (meta.textContent = `Showing ${from}–${to} of ${pagination.total} records`);

        const last = pagination.last_page || 1;
        prevBtn && (prevBtn.style.opacity = currentPage <= 1 ? '0.5' : '1');
        nextBtn && (nextBtn.style.opacity = currentPage >= last ? '0.5' : '1');

        if (!pageNumbers) return;
        pageNumbers.innerHTML = '';
        const start = Math.max(1, currentPage - 2);
        const end   = Math.min(last, currentPage + 2);
        for (let p = start; p <= end; p++) {
            const el = document.createElement('div');
            el.className    = 'page-btn' + (p === currentPage ? ' active' : '');
            el.textContent  = p;
            el.style.cursor = 'pointer';
            el.addEventListener('click', () => { currentPage = p; loadRequests(); });
            pageNumbers.appendChild(el);
        }
    }

    async function loadRequests() {
        try {
            const params = new URLSearchParams({
                page:     String(currentPage),
                per_page: String(pageSizeDefault),
                ...(currentFilters.q_title   && { q_title:  currentFilters.q_title }),
                ...(currentFilters.status    && { status:   currentFilters.status }),
                ...(currentFilters.category  && { category: currentFilters.category }),
            });
            const res  = await fetch(`${requestsUrl}?${params.toString()}`);
            if (!res.ok) throw new Error('Failed requests');
            const json = await res.json();
            renderRequestsRows(json.data);
            renderPagination(json.pagination);
        } catch (e) { console.warn(e); }
    }

    // Pagination buttons
    document.getElementById('budgetPrevBtn')?.addEventListener('click', () => {
        if (currentPage > 1) { currentPage--; loadRequests(); }
    });
    document.getElementById('budgetNextBtn')?.addEventListener('click', () => {
        currentPage++; loadRequests();
    });

    // Search input
    document.getElementById('searchInput')?.addEventListener('input', e => {
        currentPage = 1;
        currentFilters.q_title = e.target.value;
        loadRequests();
    });

    // Filter dropdowns
    function initFilterDropdown({ wrapId, btnId, menuId, filterKey, labelDefault }) {
        const wrap = document.getElementById(wrapId);
        const btn  = document.getElementById(btnId);
        const menu = document.getElementById(menuId);
        if (!wrap || !btn || !menu) return;

        btn.addEventListener('click', e => {
            e.stopPropagation();
            const isOpen = !menu.hidden;
            document.querySelectorAll('.filter-dropdown-menu').forEach(m => m.hidden = true);
            menu.hidden = isOpen;
        });

        menu.querySelectorAll('.filter-dropdown-item').forEach(item => {
            item.addEventListener('click', () => {
                const value = item.dataset.value;

                menu.querySelectorAll('.filter-dropdown-item').forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                btn.innerHTML = (value || labelDefault)
                    + ` <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i>`;

                currentFilters[filterKey] = value;
                currentPage = 1;
                loadRequests();

                menu.hidden = true;
            });
        });
    }

    initFilterDropdown({
        wrapId:       'filterCategoryWrap',
        btnId:        'filterCategoryBtn',
        menuId:       'filterCategoryMenu',
        filterKey:    'category',
        labelDefault: 'Category',
    });

    initFilterDropdown({
        wrapId:       'filterStatusWrap',
        btnId:        'filterStatusBtn',
        menuId:       'filterStatusMenu',
        filterKey:    'status',
        labelDefault: 'Status',
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.filter-dropdown-menu').forEach(m => m.hidden = true);
    });

    loadStats();
    loadRequests();

    window.loadStats    = loadStats;
    window.loadRequests = loadRequests;
})();

/* ── Sidebar ── */
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

/* ── Add Item di modal-expense ── */
(function initExpenseForm() {
    const btnAddItem = document.getElementById('btnAddItem');
    const itemRows   = document.getElementById('itemRows');
    if (!btnAddItem || !itemRows) return;

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.item-amount').forEach(input => {
            total += Number(input.value || 0);
        });
        const el = document.getElementById('grandTotalVal');
        if (el) el.textContent = total.toLocaleString('id-ID');
    }

    function reindexItems() {
        itemRows.querySelectorAll('.item-entry').forEach((entry, idx) => {
            entry.querySelectorAll('[name]').forEach(el => {
                const match = el.name.match(/items\[\d+\]\[(.+?)\]/);
                if (match) el.name = `items[${idx}][${match[1]}]`;
            });
        });
    }

    function removeItem(btn) {
        const entry = btn.closest('.item-entry');
        if (!entry) return;
        if (itemRows.querySelectorAll('.item-entry').length <= 1) {
            alert('Minimal harus ada 1 item');
            return;
        }
        entry.remove();
        reindexItems();
        updateGrandTotal();
    }

    btnAddItem.addEventListener('click', () => {
        const template = itemRows.querySelector('.item-entry');
        if (!template) return;
        const newEntry = template.cloneNode(true);
        const idx      = itemRows.querySelectorAll('.item-entry').length;

        newEntry.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
            input.value = input.type === 'number' ? '0' : '';
            const match = input.name?.match(/items\[\d+\]\[(.+?)\]/);
            if (match) input.name = `items[${idx}][${match[1]}]`;
        });
        newEntry.querySelectorAll('select').forEach(select => {
            select.value = '';
            const match = select.name?.match(/items\[\d+\]\[(.+?)\]/);
            if (match) select.name = `items[${idx}][${match[1]}]`;
        });
        newEntry.querySelectorAll('input[type="file"]').forEach(input => {
            const match = input.name?.match(/items\[\d+\]\[(.+?)\]/);
            if (match) input.name = `items[${idx}][${match[1]}]`;
        });

        newEntry.querySelector('.btn-del-row')?.addEventListener('click', function () {
            removeItem(this);
        });
        newEntry.querySelector('.item-amount')?.addEventListener('input', updateGrandTotal);

        itemRows.appendChild(newEntry);
    });

    itemRows.querySelectorAll('.btn-del-row').forEach(btn => {
        btn.addEventListener('click', function () { removeItem(this); });
    });
    itemRows.querySelectorAll('.item-amount').forEach(input => {
        input.addEventListener('input', updateGrandTotal);
    });

    updateGrandTotal();
})();

/* ── LPJ modal: load approved requests ── */
(function initLpjForm() {
    const formLpj       = document.getElementById('formLpj');
    const selectRequest = formLpj?.querySelector('select[name="budget_request_id"]');
    const lpjItemRows   = document.getElementById('lpjItemRows');
    const btnAddLpj     = document.getElementById('btnAddLpj');
    if (!formLpj || !selectRequest || !lpjItemRows) return;

    async function loadApprovedRequests() {
        try {
            // ✅ FIX: tambah exclude_with_lpj=1 agar request yang sudah dilaporkan tidak muncul
            const res  = await fetch('/admin/budgeting/requests?status=Approved&per_page=100&exclude_with_lpj=1');
            const json = await res.json();
            selectRequest.innerHTML = '<option value="" disabled selected>Select an approved request...</option>';
            (json.data || []).forEach(r => {
                const opt = document.createElement('option');
                opt.value       = r.id;
                opt.textContent = `${r.request_code}: ${r.title}`;
                selectRequest.appendChild(opt);
            });
        } catch (e) { console.warn(e); }
    }

    selectRequest.addEventListener('change', async e => {
        const id = e.target.value;
        if (!id) { lpjItemRows.innerHTML = ''; return; }
        try {
            const res  = await fetch(`/admin/budgeting/requests?id=${id}`);
            const json = await res.json();
            renderLpjItems(json.data[0]?.items || []);
        } catch (e) { console.warn(e); }
    });

    function makeLpjRow(idx, item = {}) {
        const div = document.createElement('div');
        div.className = 'lpj-item-entry';
        div.innerHTML = `
            <div class="form-group lpj-fg-amount">
                <input type="number" class="lpj-est-amount" name="items[${idx}][estimated_amount]"
                    value="${item.estimated_amount || 0}" min="0">
            </div>
            <div class="form-group lpj-fg-notes">
                <input type="text" name="items[${idx}][notes]" placeholder="Add description...">
            </div>
            <div class="form-group lpj-fg-invoice">
                <label class="upload-invoice-label lpj-upload">
                    <input type="file" hidden accept=".pdf,.jpg,.jpeg,.png" name="items[${idx}][invoice]">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    <span>Upload</span>
                </label>
            </div>
            <div class="form-group lpj-fg-actual">
                <div class="input-idr-wrap">
                    <span class="idr-prefix">IDR</span>
                    <input type="number" class="lpj-actual-amount" name="items[${idx}][actual_amount]"
                        placeholder="0" min="0">
                </div>
            </div>
            <div class="lpj-fg-del">
                <button type="button" class="btn-del-row">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
        return div;
    }

    function attachLpjListeners() {
        lpjItemRows.querySelectorAll('.btn-del-row').forEach(btn => {
            btn.onclick = () => {
                if (lpjItemRows.querySelectorAll('.lpj-item-entry').length <= 1) {
                    alert('Minimal harus ada 1 item'); return;
                }
                btn.closest('.lpj-item-entry').remove();
                updateLpjTotals();
            };
        });
        lpjItemRows.querySelectorAll('.lpj-est-amount, .lpj-actual-amount').forEach(input => {
            input.oninput = updateLpjTotals;
        });
    }

    function renderLpjItems(items) {
        lpjItemRows.innerHTML = '';
        const list = items.length ? items : [{}];
        list.forEach((item, idx) => lpjItemRows.appendChild(makeLpjRow(idx, item)));
        attachLpjListeners();
        updateLpjTotals();
    }

    btnAddLpj?.addEventListener('click', () => {
        const idx = lpjItemRows.querySelectorAll('.lpj-item-entry').length;
        lpjItemRows.appendChild(makeLpjRow(idx));
        attachLpjListeners();
    });

    function updateLpjTotals() {
        let totalEst = 0, totalActual = 0;
        lpjItemRows.querySelectorAll('.lpj-item-entry').forEach(entry => {
            totalEst    += Number(entry.querySelector('.lpj-est-amount')?.value    || 0);
            totalActual += Number(entry.querySelector('.lpj-actual-amount')?.value || 0);
        });
        const estEl    = document.getElementById('lpjTotalEst');
        const actualEl = document.getElementById('lpjTotalActual');
        estEl    && (estEl.textContent    = 'IDR ' + totalEst.toLocaleString('id-ID'));
        actualEl && (actualEl.textContent = 'IDR ' + totalActual.toLocaleString('id-ID'));
    }

    window.updateLpjTotals = updateLpjTotals;

    const lpjOverlay = document.getElementById('overlayLpj');
    if (lpjOverlay) {
        new MutationObserver(mutations => {
            mutations.forEach(m => {
                if (m.target.classList.contains('open')) loadApprovedRequests();
            });
        }).observe(lpjOverlay, { attributes: true });
    }
})();
</script>

</body>
</html>