@php
    $admin = auth('admin')->user();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles - AlaSare</title>
    @vite(['resources/css/dashboard.css', 'resources/css/admin-article.css', 'resources/js/app.js'])
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
                    <a href="{{ route('admin.notifications') }}">
                        <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    </a>
                    <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>

            <div class="content-area admin-article-page">
                <div class="article-page-head">
                    <h1>Manage Articles</h1>
                    <button type="button" class="article-create-btn" onclick="window.location.href='{{ route('admin.article.create') }}'">+ Write a New Article</button>
                </div>

                <section class="article-stat-grid" aria-label="Article summary">
                    <article class="article-stat-card">
                        <span>Total Articles</span>
                        <strong>{{ $stats['total'] }}</strong>
                    </article>
                    <article class="article-stat-card">
                        <span>Published</span>
                        <strong>{{ $stats['published'] }}</strong>
                    </article>
                    <article class="article-stat-card">
                        <span>Drafts</span>
                        <strong>{{ $stats['drafts'] }}</strong>
                    </article>
                    <article class="article-stat-card highlight">
                        <span>Total Views</span>
                        <strong>{{ $stats['views'] }}</strong>
                    </article>
                </section>

                <section class="article-table-card">
                    @if(session('success'))
                        <div style="background-color: #d4edda; color: #155724; padding: 12px; margin-bottom: 20px; border-radius: 6px; border: 1px solid #c3e6cb;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="article-toolbar">
                        <nav class="article-tabs" aria-label="Article filters">
                            <button type="button" class="active" data-filter="all">All Content</button>
                            <button type="button" data-filter="published">Published</button>
                            <button type="button" data-filter="draft">Drafts</button>
                        </nav>
                        <div class="article-tools" style="position: relative;">
                            <label class="article-search">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path></svg>
                                <input type="search" id="articleSearch" placeholder="Search articles...">
                            </label>
                            <button type="button" class="article-filter-btn" id="filterBtn">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M7 12h10M10 18h4"></path></svg>
                                Filter
                            </button>
                            <div id="filterDropdown" style="display:none; position:absolute; top:100%; right:0; background:#fff; border:1px solid rgba(26,61,10,0.15); border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.10); min-width:210px; z-index:100; padding:8px 0; margin-top:4px;">
                                <div style="padding:8px 16px; font-size:11px; font-weight:600; color:#888; letter-spacing:0.08em;">CATEGORY</div>
                                <button type="button" class="filter-category-btn active" data-category="all"
                                    style="display:block;width:100%;text-align:left;padding:8px 16px;border:none;cursor:pointer;font-size:14px;background:#1a6ea8;color:#fff;">
                                    All Categories
                                </button>
                                <button type="button" class="filter-category-btn" data-category="Culture & Serenity"
                                    style="display:block;width:100%;text-align:left;padding:8px 16px;background:none;border:none;cursor:pointer;font-size:14px;color:inherit;">
                                    Culture & Serenity
                                </button>
                                <button type="button" class="filter-category-btn" data-category="Wellness & Nature"
                                    style="display:block;width:100%;text-align:left;padding:8px 16px;background:none;border:none;cursor:pointer;font-size:14px;color:inherit;">
                                    Wellness & Nature
                                </button>
                                <button type="button" class="filter-category-btn" data-category="Eco & Discovery"
                                    style="display:block;width:100%;text-align:left;padding:8px 16px;background:none;border:none;cursor:pointer;font-size:14px;color:inherit;">
                                    Eco & Discovery
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="article-table-wrap">
                        <table class="article-table">
                            <thead>
                                <tr>
                                    <th>Thumbnail</th>
                                    <th>Article Title</th>
                                    <th>Writer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="articleTableBody">
                                @forelse($articles as $art)
                                    <tr data-status="{{ strtolower($art->status) }}"
                                        data-title="{{ strtolower($art->title) }}"
                                        data-category="{{ $art->category ?? '' }}">
                                        <td>
                                            @if($art->thumbnail)
                                                <img src="{{ asset($art->thumbnail) }}" alt="Article thumbnail">
                                            @else
                                                <img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="Article thumbnail">
                                            @endif
                                        </td>
                                        <td><strong>{{ $art->title }}</strong></td>
                                        <td>{{ $art->admin->name ?? 'Admin' }}</td>
                                        <td>{{ $art->publish_at ? $art->publish_at->format('d/m/Y') : $art->created_at->format('d/m/Y') }}</td>
                                        <td><span class="article-status {{ strtolower($art->status) }}">{{ $art->status }}</span></td>
                                        <td>
                                            <span class="article-views">
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                                                {{ $art->views_count }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="article-actions" style="display: flex; align-items: center; gap: 8px;">
                                                <button type="button" aria-label="Edit article" onclick="window.location.href='{{ route('admin.article.edit', $art->id) }}'">
                                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 20 4.5-1 10-10a2.1 2.1 0 0 0-3-3l-10 10L4 20Z"></path><path d="m14 7 3 3"></path></svg>
                                                </button>
                                                <form action="{{ route('admin.article.destroy', $art->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" aria-label="Delete article" style="background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 4px; border: 1px solid rgba(26, 61, 10, 0.15); color: #d9534f; transition: all 0.2s;">
                                                        <svg viewBox="0 0 24 24" aria-hidden="true" style="width: 14px; height: 14px; fill: currentColor;"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyRow">
                                        <td colspan="7" style="text-align: center; padding: 32px; color: #888;">
                                            No articles found. Write a new article to get started!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="article-table-foot">
                        <span id="articleCount">Showing 1 to {{ $articles->count() }} of {{ $articles->count() }} entries</span>
                        <div class="article-pagination">
                            <button type="button" disabled>Previous</button>
                            <button type="button" class="active">1</button>
                            <button type="button" disabled>Next</button>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        // ── Sidebar toggle ───────────────────────────────────────────
        const sidebar        = document.getElementById('adminSidebar');
        const sidebarToggle  = document.getElementById('sidebarToggle');
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

        // ── Filter, Search & Category ────────────────────────────────
        let activeFilter   = 'all';
        let searchQuery    = '';
        let activeCategory = 'all';

        const allRows = () => document.querySelectorAll('#articleTableBody tr[data-status]');

        function applyFilters() {
            let visible = 0;
            const total = allRows().length;

            allRows().forEach(row => {
                const matchTab      = activeFilter === 'all' || row.dataset.status === activeFilter;
                const matchSearch   = row.dataset.title.includes(searchQuery);
                const matchCategory = activeCategory === 'all' || row.dataset.category === activeCategory;

                if (matchTab && matchSearch && matchCategory) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update footer counter
            const countEl = document.getElementById('articleCount');
            if (countEl) countEl.textContent = `Showing ${visible} of ${total} entries`;

            // No results row
            let noResultRow = document.getElementById('noResultRow');
            if (visible === 0 && total > 0) {
                if (!noResultRow) {
                    noResultRow = document.createElement('tr');
                    noResultRow.id = 'noResultRow';
                    noResultRow.innerHTML = `<td colspan="7" style="text-align:center;padding:32px;color:#888;">No articles match your search.</td>`;
                    document.getElementById('articleTableBody').appendChild(noResultRow);
                }
                noResultRow.style.display = '';
            } else if (noResultRow) {
                noResultRow.style.display = 'none';
            }
        }

        // Tab buttons
        document.querySelectorAll('.article-tabs button').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.article-tabs button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilter = this.dataset.filter;
                applyFilters();
            });
        });

        // Search input
        document.getElementById('articleSearch')?.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFilters();
        });

        // Filter dropdown toggle
        const filterBtn      = document.getElementById('filterBtn');
        const filterDropdown = document.getElementById('filterDropdown');

        filterBtn?.addEventListener('click', function (e) {
            e.stopPropagation();
            filterDropdown.style.display = filterDropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown on outside click
        document.addEventListener('click', function () {
            if (filterDropdown) filterDropdown.style.display = 'none';
        });

        filterDropdown?.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Category buttons
        document.querySelectorAll('.filter-category-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.filter-category-btn').forEach(b => {
                    b.style.background = 'none';
                    b.style.color = 'inherit';
                });
                this.style.background = '#1a6ea8';
                this.style.color = '#fff';
                activeCategory = this.dataset.category;
                filterDropdown.style.display = 'none';
                applyFilters();
            });
        });
    </script>
</body>
</html>