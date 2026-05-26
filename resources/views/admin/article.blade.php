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
                    <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>

            <div class="content-area admin-article-page">
                <div class="article-page-head">
                    <h1>Manage Articles</h1>
                    <button type="button" class="article-create-btn">+ Write a New Article</button>
                </div>

                <section class="article-stat-grid" aria-label="Article summary">
                    <article class="article-stat-card">
                        <span>Total Articles</span>
                        <strong>24</strong>
                    </article>
                    <article class="article-stat-card">
                        <span>Published</span>
                        <strong>18</strong>
                    </article>
                    <article class="article-stat-card">
                        <span>Drafts</span>
                        <strong>6</strong>
                    </article>
                    <article class="article-stat-card highlight">
                        <span>Total Views</span>
                        <strong>1.2k</strong>
                    </article>
                </section>

                <section class="article-table-card">
                    <div class="article-toolbar">
                        <nav class="article-tabs" aria-label="Article filters">
                            <button type="button" class="active">All Content</button>
                            <button type="button">Published</button>
                            <button type="button">Drafts</button>
                        </nav>
                        <div class="article-tools">
                            <label class="article-search">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path></svg>
                                <input type="search" placeholder="Search articles...">
                            </label>
                            <button type="button" class="article-filter-btn">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M7 12h10M10 18h4"></path></svg>
                                Filter
                            </button>
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
                            <tbody>
                                <tr>
                                    <td><img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="Article thumbnail"></td>
                                    <td><strong>The Harmony of Islamic Values and Javanese Wisdom</strong></td>
                                    <td>Admin</td>
                                    <td>14/05/2026</td>
                                    <td><span class="article-status published">Published</span></td>
                                    <td><span class="article-views"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>128</span></td>
                                    <td>
                                        <div class="article-actions">
                                            <button type="button" aria-label="Edit article"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 20 4.5-1 10-10a2.1 2.1 0 0 0-3-3l-10 10L4 20Z"></path><path d="m14 7 3 3"></path></svg></button>
                                            <button type="button" aria-label="Open article"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="4" width="14" height="16" rx="2"></rect><path d="M9 8h6M9 12h6M9 16h4"></path></svg></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="{{ asset('images/journal/Herbal Javanese jamu.png') }}" alt="Article thumbnail"></td>
                                    <td><strong>The Healing Power of Archipelago Rhizomes</strong></td>
                                    <td>Admin</td>
                                    <td>10/05/2026</td>
                                    <td><span class="article-status draft">Draft</span></td>
                                    <td><span class="article-views"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>8</span></td>
                                    <td>
                                        <div class="article-actions">
                                            <button type="button" aria-label="Edit article"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 20 4.5-1 10-10a2.1 2.1 0 0 0-3-3l-10 10L4 20Z"></path><path d="m14 7 3 3"></path></svg></button>
                                            <button type="button" aria-label="Open article"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="4" width="14" height="16" rx="2"></rect><path d="M9 8h6M9 12h6M9 16h4"></path></svg></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="{{ asset('images/journal/Crafting with local community.png') }}" alt="Article thumbnail"></td>
                                    <td><strong>Connecting Through Handcrafted Art</strong></td>
                                    <td>Admin</td>
                                    <td>14/05/2026</td>
                                    <td><span class="article-status draft">Draft</span></td>
                                    <td><span class="article-views"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>128</span></td>
                                    <td>
                                        <div class="article-actions">
                                            <button type="button" aria-label="Edit article"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 20 4.5-1 10-10a2.1 2.1 0 0 0-3-3l-10 10L4 20Z"></path><path d="m14 7 3 3"></path></svg></button>
                                            <button type="button" aria-label="Open article"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="4" width="14" height="16" rx="2"></rect><path d="M9 8h6M9 12h6M9 16h4"></path></svg></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="article-table-foot">
                        <span>Showing 1 to 3 of 12 entries</span>
                        <div class="article-pagination">
                            <button type="button">Previous</button>
                            <button type="button" class="active">1</button>
                            <button type="button">2</button>
                            <button type="button">Next</button>
                        </div>
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
