<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write New Article - AlaSare</title>
    @vite(['resources/css/dashboard.css', 'resources/css/admin-article.css', 'resources/css/admin-article-create.css', 'resources/js/app.js'])
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
                <div class="editor-container">
                    <!-- Left Side: Main Editor Area -->
                    <div class="editor-main">
                        <a href="{{ route('admin.article') }}" class="back-to-list-link">
                            <svg viewBox="0 0 24 24" aria-hidden="true" width="16" height="16">
                                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7"/>
                            </svg>
                            Return to Article List
                        </a>

                        <h2 class="editor-title">Organize Your Articles</h2>

                        <div class="thumbnail-upload-zone">
                            <img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="Article Thumbnail" class="thumbnail-preview-img">
                            <div class="alasare-badge">ALASARE</div>
                        </div>

                        <textarea class="article-title-field" rows="2" placeholder="Enter article title...">Embracing Serenity: The Harmony of Islamic Values and Javanese Wisdom amidst Nature’s Lush Embrace</textarea>

                        <div class="editor-toolbar-row">
                            <button type="button" class="toolbar-icon-btn format-bold-btn">B</button>
                            <button type="button" class="toolbar-icon-btn format-italic-btn">I</button>
                            <span class="toolbar-v-divider"></span>
                            <button type="button" class="toolbar-icon-btn format-h2-btn">H2</button>
                            <button type="button" class="toolbar-icon-btn format-quote-btn">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                                </svg>
                            </button>
                            <span class="toolbar-v-divider"></span>
                            <button type="button" class="toolbar-icon-btn format-image-btn">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </button>
                            <button type="button" class="toolbar-icon-btn format-link-btn">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                </svg>
                            </button>
                        </div>

                        <textarea class="article-body-textarea" placeholder="On the mist-covered hillsides of dawn, AlaSare stands not merely as a place of rest, but as a visual narrative of balance...">On the mist-covered hillsides of dawn, AlaSare stands not merely as a place of rest, but as a visual narrative of balance. Here, the "Tropical Zen" philosophy is translated through the humble touch of Javanese vernacular architecture, blending intimately with the principles of...</textarea>
                    </div>

                    <!-- Right Side: Metadata / Publish Panel -->
                    <div class="editor-sidebar-panel">
                        <div class="sidebar-action-card">
                            <button type="button" class="publish-submit-btn">Update & Publish</button>
                            <button type="button" class="draft-save-btn">Save as Draft</button>
                        </div>

                        <div class="sidebar-details-card">
                            <h3>Details</h3>
                            <div class="card-title-separator"></div>

                            <div class="meta-field-group">
                                <label class="meta-field-label">AUTHOR</label>
                                <div class="meta-input-container">
                                    <span class="meta-input-icon">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </span>
                                    <input type="text" class="meta-input-element" value="Admin">
                                </div>
                            </div>

                            <div class="meta-field-group">
                                <label class="meta-field-label">PUBLISH DATE</label>
                                <div class="meta-input-container">
                                    <span class="meta-input-icon">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                    </span>
                                    <input type="text" class="meta-input-element" value="14 Mei 2026">
                                </div>
                            </div>

                            <div class="meta-field-group">
                                <label class="meta-field-label">SOURCE</label>
                                <div class="meta-input-container">
                                    <span class="meta-input-icon">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="2" y1="12" x2="22" y2="12"/>
                                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                        </svg>
                                    </span>
                                    <input type="text" class="meta-input-element" value="AlaSare.com">
                                </div>
                            </div>

                            <div class="meta-field-group">
                                <label class="meta-field-label">CATEGORY</label>
                                <div class="meta-select-container">
                                    <select class="meta-select-element">
                                        <option>Culture & Serenity</option>
                                        <option>Wellness & Nature</option>
                                        <option>Eco & Discovery</option>
                                    </select>
                                    <span class="meta-select-arrow">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="meta-field-group">
                                <label class="meta-field-label">META DESCRIPTION</label>
                                <textarea class="meta-textarea-element" placeholder="A brief description of SEO..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
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
