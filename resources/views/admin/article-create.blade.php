@php
    $admin = auth('admin')->user();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
    <title>Write New Article - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/admin-article.css', 'resources/css/admin-article-create.css', 'resources/js/app.js'])
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
                    <a href="{{ route('admin.notification.index') }}">
                        <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    </a>
                    <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
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

                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                            <h2 class="editor-title" style="margin:0;">{{ isset($article) ? 'Edit Your Article' : 'Organize Your Articles' }}</h2>
                            <div style="display:flex;align-items:center;gap:4px;background:#f3f4f6;border-radius:6px;padding:3px;">
                                <button type="button" class="lang-switch-btn active" data-lang="id" style="padding:6px 14px;border:none;border-radius:4px;cursor:pointer;font-size:12px;font-weight:600;letter-spacing:0.08em;transition:all 0.2s;">ID</button>
                                <button type="button" class="lang-switch-btn" data-lang="en" style="padding:6px 14px;border:none;border-radius:4px;cursor:pointer;font-size:12px;font-weight:600;letter-spacing:0.08em;transition:all 0.2s;">EN</button>
                            </div>
                        </div>

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

                        <input type="text" id="titleInput" class="article-title-field" rows="2" placeholder="Judul Artikel" value="">

                        <div id="quill-editor" style="min-height: 320px;"></div>

                        <input type="hidden" name="title" id="hiddenTitle" value="{{ old('title', $article->title ?? '') }}">
                        <textarea name="content" id="hiddenContent" style="display:none;">{{ old('content', $article->content ?? '') }}</textarea>
                        <input type="hidden" name="title_en" id="hiddenTitleEn" value="{{ old('title_en', $article->title_en ?? '') }}">
                        <textarea name="content_en" id="hiddenContentEn" style="display:none;">{{ old('content_en', $article->content_en ?? '') }}</textarea>
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
        const inlineImageInput = document.getElementById('inlineImageInput');

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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
    <script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'On the mist-covered hillsides of dawn...',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic'],
                    [{ header: 2 }],
                    ['blockquote'],
                    ['image', 'link'],
                ],
                handlers: {
                    image: imageHandler,
                    link: linkHandler
                }
            }
        }
    });

    let currentLang = 'id';

    function getContentInputId(lang) {
        return lang === 'id' ? 'hiddenContent' : 'hiddenContentEn';
    }

    function getTitleInputId(lang) {
        return lang === 'id' ? 'hiddenTitle' : 'hiddenTitleEn';
    }

    function saveCurrentToHidden(lang) {
        const titleEl = document.getElementById('titleInput');
        const hiddenTitle = document.getElementById(getTitleInputId(lang));
        const hiddenContent = document.getElementById(getContentInputId(lang));
        hiddenTitle.value = titleEl.value;
        const html = quill.root.innerHTML;
        hiddenContent.value = (html === '<p><br></p>') ? '' : html;
    }

    function loadFromHidden(lang) {
        const titleEl = document.getElementById('titleInput');
        const hiddenTitle = document.getElementById(getTitleInputId(lang));
        const hiddenContent = document.getElementById(getContentInputId(lang));
        titleEl.value = hiddenTitle.value;
        const content = hiddenContent.value.trim();
        if (content) {
            quill.clipboard.dangerouslyPasteHTML(content);
        } else {
            quill.setText('');
        }
    }

    function switchLang(lang) {
        if (lang === currentLang) return;
        saveCurrentToHidden(currentLang);
        currentLang = lang;
        loadFromHidden(lang);

        document.querySelectorAll('.lang-switch-btn').forEach(function(btn) {
            btn.classList.toggle('active', btn.dataset.lang === lang);
            btn.style.background = btn.dataset.lang === lang ? '#fff' : 'transparent';
            btn.style.color = btn.dataset.lang === lang ? '#1a3d0a' : '#888';
            btn.style.boxShadow = btn.dataset.lang === lang ? '0 1px 3px rgba(0,0,0,0.12)' : 'none';
        });

        const placeholder = lang === 'id' ? 'Judul Artikel' : 'Article Title';
        document.getElementById('titleInput').placeholder = placeholder;
    }

    // Init: determine which language to show
    const existingId = document.getElementById('hiddenContent').value.trim();
    const existingEn = document.getElementById('hiddenContentEn').value.trim();
    if (existingId) {
        document.getElementById('titleInput').value = document.getElementById('hiddenTitle').value;
        quill.clipboard.dangerouslyPasteHTML(existingId);
    } else if (existingEn) {
        switchLang('en');
    }

    // Setup lang switch buttons
    document.querySelectorAll('.lang-switch-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            switchLang(this.dataset.lang);
        });
    });

    // Initial active state
    document.querySelectorAll('.lang-switch-btn').forEach(function(btn) {
        if (btn.dataset.lang === currentLang) {
            btn.style.background = '#fff';
            btn.style.color = '#1a3d0a';
            btn.style.boxShadow = '0 1px 3px rgba(0,0,0,0.12)';
        } else {
            btn.style.background = 'transparent';
            btn.style.color = '#888';
        }
    });

    // Save to hidden fields on text change
    quill.on('text-change', function() {
        const html = quill.root.innerHTML;
        document.getElementById(getContentInputId(currentLang)).value = (html === '<p><br></p>') ? '' : html;
    });

    document.getElementById('titleInput').addEventListener('input', function() {
        document.getElementById(getTitleInputId(currentLang)).value = this.value;
    });

    // Validate on submit — sync visible fields to the right hidden fields
    document.querySelector('form').addEventListener('submit', function(e) {
        const html = quill.root.innerHTML;
        const titleVal = document.getElementById('titleInput').value;
        const isEmpty = html === '<p><br></p>' || !html.trim();

        // Simpan visible fields ke hidden sesuai bahasa aktif
        if (currentLang === 'id') {
            document.getElementById('hiddenTitle').value = titleVal;
            document.getElementById('hiddenContent').value = isEmpty ? '' : html;
        } else {
            document.getElementById('hiddenTitleEn').value = titleVal;
            document.getElementById('hiddenContentEn').value = isEmpty ? '' : html;
        }

        // Validasi: konten ID wajib
        const idContent = document.getElementById('hiddenContent').value.trim();
        if (!idContent) {
            e.preventDefault();
            alert('Konten bahasa Indonesia tidak boleh kosong!');
            switchLang('id');
            quill.focus();
            return;
        }
    });

    // Image handler
    function imageHandler() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.click();

        input.addEventListener('change', async () => {
            const file = input.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            try {
                const res = await fetch('{{ route("admin.upload.image") }}', {
                    method: 'POST',
                    body: formData,
                });
                const data = await res.json();
                if (data.url) {
                    const range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', data.url);
                    quill.setSelection(range.index + 1);
                }
            } catch (err) {
                alert('Upload failed. Please try again.');
            }
        });
    }

    function linkHandler(value) {
        if (value) {
            const range = quill.getSelection();
            if (range && range.length > 0) {
                const url = prompt('Masukkan URL:');
                if (url) quill.format('link', url);
            } else {
                const url = prompt('Masukkan URL:');
                if (!url) return;
                const text = prompt('Teks link:') || url;
                const pos = quill.getSelection(true);
                quill.insertText(pos.index, text, 'link', url);
            }
        } else {
            quill.format('link', false);
        }
    }
    </script>
</body>
</html>
