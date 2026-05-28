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
                @if($errors->any())
                    <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 6px; border: 1px solid #f5c6cb;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($article) ? route('admin.article.update', $article->id) : route('admin.article.store') }}" method="POST" enctype="multipart/form-data" class="editor-container">
                    @csrf
                    @if(isset($article))
                        @method('PUT')
                    @endif

                    <!-- Left Side: Main Editor Area -->
                    <div class="editor-main">
                        <a href="{{ route('admin.article') }}" class="back-to-list-link">
                            <svg viewBox="0 0 24 24" aria-hidden="true" width="16" height="16">
                                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7"/>
                            </svg>
                            Return to Article List
                        </a>

                        <h2 class="editor-title">{{ isset($article) ? 'Edit Your Article' : 'Organize Your Articles' }}</h2>

                        <div class="thumbnail-upload-zone" onclick="document.getElementById('thumbnailInput').click();" style="cursor: pointer;">
                            @if(isset($article) && $article->thumbnail)
                                <img src="{{ asset($article->thumbnail) }}" alt="Article Thumbnail" class="thumbnail-preview-img" id="thumbnailPreview">
                            @else
                                <div id="thumbnailPreview" class="thumbnail-empty-state" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;width:100%;height:100%;">
                                    <svg viewBox="0 0 48 48" width="48" height="48" fill="none" stroke="rgba(26,61,10,0.35)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="6" width="36" height="36" rx="4"/><circle cx="16" cy="18" r="3"/><polyline points="6 34 16 22 24 30 32 20 42 34"/></svg>
                                    <span style="font-size:13px;color:rgba(26,61,10,0.45);font-family:inherit;">Click to upload thumbnail</span>
                                </div>
                            @endif
                            <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*" style="display: none;" onchange="previewImage(this);">
                            <div class="alasare-badge">ALASARE</div>
                        </div>

                        <textarea class="article-title-field" name="title" rows="2" placeholder="Enter article title...">{{ old('title', $article->title ?? '') }}</textarea>

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

                        <textarea class="article-body-textarea" name="content" placeholder="On the mist-covered hillsides of dawn, AlaSare stands not merely as a place of rest, but as a visual narrative of balance...">{{ old('content', $article->content ?? '') }}</textarea>
                    </div>

                    <!-- Right Side: Metadata / Publish Panel -->
                    <div class="editor-sidebar-panel">
                        <div class="sidebar-action-card">
                            <button type="submit" name="status" value="Published" class="publish-submit-btn">{{ isset($article) ? 'Update & Publish' : 'Publish' }}</button>
                            <button type="submit" name="status" value="Draft" class="draft-save-btn">Save as Draft</button>
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
                                    @php
                                        $authorName = isset($article) ? ($article->admin?->name ?? 'Admin') : (Auth::guard('admin')->user()?->name ?? 'Admin');
                                    @endphp
                                    <input type="text" class="meta-input-element" name="author" placeholder="{{ $authorName }}" value="{{ old('author') }}">
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
                                    @php
                                        $publishVal = old('publish_at', isset($article) && $article->publish_at ? $article->publish_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i'));
                                    @endphp
                                    <input type="datetime-local" class="meta-input-element" name="publish_at" value="{{ $publishVal }}">
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
                                    <input type="text" class="meta-input-element" name="source" placeholder="e.g. AlaSare.com" value="{{ old('source', isset($article) ? ($article->source ?? '') : '') }}">
                                </div>
                            </div>

                            <div class="meta-field-group">
                                <label class="meta-field-label">CATEGORY</label>
                                <div class="meta-select-container">
                                    @php $selectedCat = old('category', isset($article) ? ($article->category ?? 'Culture & Serenity') : 'Culture & Serenity'); @endphp
                                    <select class="meta-select-element" name="category">
                                        <option value="Culture & Serenity" {{ $selectedCat == 'Culture & Serenity' ? 'selected' : '' }}>Culture & Serenity</option>
                                        <option value="Wellness & Nature" {{ $selectedCat == 'Wellness & Nature' ? 'selected' : '' }}>Wellness & Nature</option>
                                        <option value="Eco & Discovery" {{ $selectedCat == 'Eco & Discovery' ? 'selected' : '' }}>Eco & Discovery</option>
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
                                <textarea class="meta-textarea-element" name="meta_description" placeholder="A brief description of SEO...">{{ old('meta_description', isset($article) ? ($article->meta_description ?? '') : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const ta = document.querySelector('textarea[name="content"]');

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

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('thumbnailPreview');
                    // If it's the empty-state div, replace it with an img
                    if (preview.tagName === 'DIV') {
                        const img = document.createElement('img');
                        img.id = 'thumbnailPreview';
                        img.alt = 'Article Thumbnail';
                        img.className = 'thumbnail-preview-img';
                        img.src = e.target.result;
                        preview.replaceWith(img);
                    } else {
                        preview.src = e.target.result;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function getSelection() {
            const start = ta.selectionStart;
            const end = ta.selectionEnd;
            return { start, end, text: ta.value.substring(start, end) };
        }

        function replaceSelection(before, after) {
            const { start, end, text } = getSelection();
            const selected = text || 'text';
            ta.value = ta.value.substring(0, start) + before + selected + after + ta.value.substring(end);
            const newPos = start + before.length + selected.length;
            ta.setSelectionRange(newPos, newPos);
            ta.focus();
        }

        function wrapLines(prefix) {
            const { start, end } = getSelection();
            const val = ta.value;
            const lineStart = val.lastIndexOf('\n', start - 1) + 1;
            const lineEnd = val.indexOf('\n', end);
            const endPos = lineEnd === -1 ? val.length : lineEnd;
            const lines = val.substring(lineStart, endPos).split('\n');
            const already = lines.every(l => l.startsWith(prefix));
            const newLines = already ? lines.map(l => l.slice(prefix.length)).join('\n') : lines.map(l => prefix + l).join('\n');
            ta.value = val.substring(0, lineStart) + newLines + val.substring(endPos);
            ta.setSelectionRange(lineStart, lineStart + newLines.length);
            ta.focus();
        }

        document.querySelector('.format-bold-btn').addEventListener('click', () => {
            const { start, end, text } = getSelection();
            if (text.startsWith('**') && text.endsWith('**')) {
                const inner = text.slice(2, -2);
                ta.value = ta.value.substring(0, start) + inner + ta.value.substring(end);
                ta.setSelectionRange(start, start + inner.length);
                ta.focus();
            } else { replaceSelection('**', '**'); }
        });

        document.querySelector('.format-italic-btn').addEventListener('click', () => {
            const { start, end, text } = getSelection();
            if (text.startsWith('_') && text.endsWith('_')) {
                const inner = text.slice(1, -1);
                ta.value = ta.value.substring(0, start) + inner + ta.value.substring(end);
                ta.setSelectionRange(start, start + inner.length);
                ta.focus();
            } else { replaceSelection('_', '_'); }
        });

        document.querySelector('.format-h2-btn').addEventListener('click', () => wrapLines('## '));
        document.querySelector('.format-quote-btn').addEventListener('click', () => wrapLines('> '));

        document.querySelector('.format-image-btn').addEventListener('click', () => {
            const url = prompt('Image URL:');
            if (!url) return;
            const alt = prompt('Alt text (optional):') || 'image';
            const { start, end } = getSelection();
            const md = `![${alt}](${url})`;
            ta.value = ta.value.substring(0, start) + md + ta.value.substring(end);
            ta.setSelectionRange(start + md.length, start + md.length);
            ta.focus();
        });

        document.querySelector('.format-link-btn').addEventListener('click', () => {
            const { start, end, text } = getSelection();
            const url = prompt('URL:');
            if (!url) return;
            const label = text || prompt('Link text:') || url;
            const md = `[${label}](${url})`;
            ta.value = ta.value.substring(0, start) + md + ta.value.substring(end);
            ta.setSelectionRange(start + md.length, start + md.length);
            ta.focus();
        });

        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && document.activeElement === ta) {
                if (e.key === 'b') { e.preventDefault(); document.querySelector('.format-bold-btn').click(); }
                if (e.key === 'i') { e.preventDefault(); document.querySelector('.format-italic-btn').click(); }
            }
        });
    </script>
</body>
</html>
