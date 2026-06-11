{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/featured-articles.blade.php --}}

@php
    $featuredArticlesData ??= \App\Models\LandingPageSetting::DEFAULTS['featured_articles'];
    $d = array_merge(\App\Models\LandingPageSetting::DEFAULTS['featured_articles'], $featuredArticlesData);
    $selectedArticles ??= collect();
    $allArticles      ??= collect();
    $maxSlots = 3;
    $slotsUsed = $selectedArticles->count();
@endphp

{{-- ── Flash ── --}}
@if(session('success'))
    <div style="margin-bottom:16px;padding:12px 16px;background:#e6f4e6;border:1px solid #a3d4a3;border-radius:10px;color:#2e7d32;font-size:13px;font-weight:600;">✓ {{ session('success') }}</div>
@endif
@if($errors->any())
    <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;border:1px solid #f5a5a5;border-radius:10px;color:#c62828;font-size:13px;">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
    </div>
@endif

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Journal &amp; Stories</h2>

<form method="POST"
      action="{{ route('admin.landing.featured-articles.update') }}"
      id="featuredArticlesForm">
    @csrf @method('PUT')

    {{-- ── Section Info (Bilingual) ── --}}
    <div class="lp-card">
        <div class="lp-field">
            <label class="lp-field-label">Section Title (EN)</label>
            <input type="text" class="lp-input lp-heading-input" name="section_title"
                   value="{{ old('section_title', $d['section_title'] ?? '') }}" maxlength="200">
        </div>
        
        <div class="lp-field">
            <label class="lp-field-label">Section Title (ID)</label>
            <input type="text" class="lp-input lp-heading-input" name="section_title_id"
                   value="{{ old('section_title_id', $d['section_title_id'] ?? '') }}" maxlength="200">
        </div>

        <div class="lp-field">
            <label class="lp-field-label">Section Description (EN)</label>
            <input type="text" class="lp-input" name="section_description"
                   value="{{ old('section_description', $d['section_description'] ?? '') }}" maxlength="500">
        </div>

        <div class="lp-field" style="margin-bottom:0;">
            <label class="lp-field-label">Section Description (ID)</label>
            <input type="text" class="lp-input" name="section_description_id"
                   value="{{ old('section_description_id', $d['section_description_id'] ?? '') }}" maxlength="500">
        </div>
    </div>

    {{-- ── Selected Articles ── --}}
    <div class="lp-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <p class="lp-card-label" style="margin:0;">Selected Articles</p>
            <span style="font-size:12px;color:#9aaa96;font-weight:600;">
                <span id="slotsUsedCount">{{ $slotsUsed }}</span> of {{ $maxSlots }} slots used
            </span>
        </div>

        <div id="selectedArticlesList">
            @foreach($selectedArticles as $article)
            <div class="lp-flora-card-item" id="articleRow_{{ $article->id }}"
                 style="padding:14px 0;border-bottom:1px solid #f0f4ee;">
                {{-- Thumbnail --}}
                <div style="flex-shrink:0;">
                    @if($article->thumbnail)
                        <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->title }}"
                             style="width:80px;height:60px;border-radius:8px;object-fit:cover;">
                    @else
                        <div style="width:80px;height:60px;border-radius:8px;background:#e8ede8;flex-shrink:0;"></div>
                    @endif
                </div>
                <div class="lp-flora-text">
                    <div style="font-size:10px;font-weight:700;color:#d97706;letter-spacing:.6px;text-transform:uppercase;margin-bottom:3px;">
                        {{ $article->category ?? '' }}
                    </div>
                    <div class="lp-flora-title" style="font-size:13px;">{{ $article->title }}</div>
                    <div class="lp-flora-desc">{{ Str::limit(strip_tags($article->content), 80) }}</div>
                </div>
                <button type="button" class="lp-remove-btn" style="flex-shrink:0;white-space:nowrap;"
                        onclick="removeArticle({{ $article->id }})">
                    Remove from Homepage
                </button>
                {{-- Hidden input ── --}}
                <input type="hidden" name="article_ids[]" value="{{ $article->id }}"
                       id="hArticle_{{ $article->id }}">
            </div>
            @endforeach
        </div>

        {{-- Add slot button ── --}}
        <button
            type="button"
            class="lp-dashed-btn"
            id="addArticleBtn"
            onclick="openModal('articlePickerModal')"
            {{ $slotsUsed >= $maxSlots ? 'disabled' : '' }}
            style="
                margin-top:16px;
                {{ $slotsUsed >= $maxSlots ? 'opacity:0.4;cursor:not-allowed;' : '' }}
            "
        >
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
            </svg>
            Select Article from Database
        </button>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid #f0f4ee;">
            <a href="{{ route('admin.settings', ['section' => 'landing']) }}"
               class="btn btn-orange-outline">Cancel</a>
            <button type="submit" class="btn btn-dark">Save Changes</button>
        </div>
    </div>

</form>

@if(isset($featuredArticlesSetting) && $featuredArticlesSetting->updated_at)
<div class="lp-status-bar" style="margin-top:8px;">
    <div class="lp-status-bar-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
        Last saved: <span style="color:#5a6a58;">{{ $featuredArticlesSetting->updated_at->format('M j, Y \a\t H:i') }}</span>
    </div>
    <div class="lp-status-bar-item">
        <span class="lp-live-dot"></span>
        <span class="lp-live-text">All systems operational</span>
    </div>
</div>
@endif


{{-- ════ MODAL: Article Picker ════ --}}
<div class="modal-overlay" id="articlePickerModal">
    <div class="modal-box" style="max-width:580px;">
        <div class="modal-header">
            <h3 class="modal-title">Select Article to Feature</h3>
            <button type="button" class="modal-close" onclick="closeModal('articlePickerModal')">✕</button>
        </div>

        {{-- Search & Filter ── --}}
        <div style="margin-bottom:14px;">
            {{-- Search input --}}
            <div class="search-wrap" style="width:100%;margin-bottom:10px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                     style="position:absolute;left:10px;color:#a0a8a0;">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" class="search-input" id="articleSearchInput"
                       placeholder="Search article title..."
                       style="width:100%;padding-left:34px;"
                       oninput="filterArticlePicker(this.value)">
            </div>

            {{-- Category dropdown filter ── --}}
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:12px;color:#7a857f;white-space:nowrap;flex-shrink:0;">Filter by:</span>
                <select
                    id="articleCatFilter"
                    onchange="filterByCat(this.value)"
                    style="
                        flex:1;
                        padding:7px 32px 7px 12px;
                        border:1px solid #d8e4d4;
                        border-radius:8px;
                        font-size:12px;
                        font-weight:600;
                        color:#2d4a1e;
                        background:#fff url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%232d4a1e' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E\") no-repeat right 10px center;
                        appearance:none;
                        -webkit-appearance:none;
                        cursor:pointer;
                        outline:none;
                        transition:border-color .15s;
                    "
                >
                    <option value="">All Categories</option>
                    @foreach($allArticles->pluck('category')->filter()->unique()->sort() as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Article list ── --}}
        <div style="max-height:360px;overflow-y:auto;border:1px solid #f0f4ee;border-radius:10px;"
             id="articlePickerList">
            @forelse($allArticles as $art)
            <label class="article-picker-row"
                   data-title="{{ strtolower($art->title) }}"
                   data-cat="{{ $art->category ?? '' }}"
                   data-id="{{ $art->id }}">
                {{-- Thumbnail --}}
                @if($art->thumbnail)
                    <img src="{{ asset($art->thumbnail) }}" alt="{{ $art->title }}"
                         style="width:68px;height:52px;border-radius:7px;object-fit:cover;flex-shrink:0;">
                @else
                    <div style="width:68px;height:52px;border-radius:7px;background:#e8ede8;flex-shrink:0;"></div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-size:10px;font-weight:700;color:#d97706;letter-spacing:.6px;text-transform:uppercase;margin-bottom:3px;">
                        {{ $art->category ?? 'Uncategorized' }}
                    </div>
                    <div style="font-size:13px;font-weight:600;color:#1a3d0a;margin-bottom:3px;line-height:1.4;">
                        {{ $art->title }}
                    </div>
                    <div style="font-size:11px;color:#9aaa96;line-height:1.5;">
                        {{ Str::limit(strip_tags($art->content), 80) }}
                    </div>
                </div>
                <input type="radio" name="picker_article" value="{{ $art->id }}"
                       style="width:18px;height:18px;accent-color:#2d4a1e;flex-shrink:0;margin-top:4px;">
            </label>
            @empty
            <div style="padding:32px;text-align:center;color:#9aaa96;font-size:13px;">
                Belum ada artikel yang dipublish.
            </div>
            @endforelse
        </div>

        {{-- Empty state saat filter tidak ada hasil --}}
        <div id="articlePickerEmpty"
             style="display:none;padding:32px;text-align:center;color:#9aaa96;font-size:13px;">
            Tidak ada artikel yang sesuai.
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-orange-outline" onclick="closeModal('articlePickerModal')">Cancel</button>
            <button type="button" class="btn btn-dark" onclick="addSelectedArticle()">Add to Homepage</button>
        </div>
    </div>
</div>

<style>
.lp-dashed-btn {
    width:100%;padding:16px;border:1.5px dashed #c4d0c0;border-radius:10px;
    background:#fafcfa;font-size:13px;font-weight:600;color:#4a7c3f;
    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;
    transition:border-color .15s,background .15s;
}
.lp-dashed-btn:hover:not(:disabled){border-color:#4a7c3f;background:#f4f9f4;}

/* ── Article picker row: selalu flex ── */
.article-picker-row {
    display:flex !important;
    align-items:flex-start;
    gap:14px;
    padding:12px 14px;
    cursor:pointer;
    transition:background .15s;
    border-bottom:1px solid #f0f4ee;
}
.article-picker-row:hover { background:#f6f9f5; }
.article-picker-row:last-child { border-bottom:none; }

/* ── Category filter select focus ── */
#articleCatFilter:focus {
    border-color:#4a7c3f;
    box-shadow:0 0 0 3px rgba(74,124,63,.12);
}
</style>

@php
$articleJsData = $allArticles
    ->mapWithKeys(function ($art) {
        return [
            $art->id => [
                'id'        => $art->id,
                'title'     => $art->title,
                'category'  => $art->category ?? '',
                'thumbnail' => $art->thumbnail ? asset($art->thumbnail) : '',
                'excerpt'   => \Illuminate\Support\Str::limit(
                    strip_tags($art->content),
                    80
                ),
            ]
        ];
    })
    ->toArray();
@endphp

<script>
const articleData = @json($articleJsData);
const MAX_SLOTS   = 3;

/* ─────────────────────────────
    Modal open / close
───────────────────────────── */
function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('open');
    document.body.style.overflow = '';
}

// Close modal when clicking backdrop
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', function (e) {
            if (e.target === el) closeModal(el.id);
        });
    });
});

/* ─────────────────────────────
    Filter article picker
───────────────────────────── */
function filterArticlePicker(q) {
    const keyword    = (q || '').toLowerCase().trim();
    const activeCat  = (document.getElementById('articleCatFilter')?.value || '');
    let   visCount   = 0;

    document.querySelectorAll('.article-picker-row').forEach(row => {
        const matchTitle = (row.dataset.title || '').includes(keyword);
        const matchCat   = !activeCat || (row.dataset.cat || '') === activeCat;
        const show       = matchTitle && matchCat;

        row.style.display = show ? 'flex' : 'none';
        if (show) visCount++;
    });

    const emptyEl = document.getElementById('articlePickerEmpty');
    if (emptyEl) emptyEl.style.display = visCount === 0 ? 'block' : 'none';
}

function filterByCat(cat) {
    const searchInput = document.getElementById('articleSearchInput');
    filterArticlePicker(searchInput ? searchInput.value : '');
}

/* ─────────────────────────────
    Add selected article
───────────────────────────── */
function addSelectedArticle() {
    const radio = document.querySelector('input[name="picker_article"]:checked');

    if (!radio) {
        alert('Pilih artikel terlebih dahulu.');
        return;
    }

    const id = parseInt(radio.value);

    if (document.getElementById(`articleRow_${id}`)) {
        alert('Artikel ini sudah ada di daftar.');
        return;
    }

    const currentCount = document.querySelectorAll('input[name="article_ids[]"]').length;

    if (currentCount >= MAX_SLOTS) {
        alert('Maksimal 3 artikel.');
        return;
    }

    const art = articleData[id];
    if (!art) {
        console.error('Article data not found:', id);
        return;
    }

    const list = document.getElementById('selectedArticlesList');
    const div  = document.createElement('div');
    div.className   = 'lp-flora-card-item';
    div.id          = `articleRow_${id}`;
    div.style.cssText = 'padding:14px 0;border-bottom:1px solid #f0f4ee;';

    const thumbHtml = art.thumbnail
        ? `<img src="${art.thumbnail}" alt="${art.title}" style="width:80px;height:60px;border-radius:8px;object-fit:cover;">`
        : `<div style="width:80px;height:60px;border-radius:8px;background:#e8ede8;"></div>`;

    div.innerHTML = `
        <div style="flex-shrink:0;">${thumbHtml}</div>
        <div class="lp-flora-text">
            <div style="font-size:10px;font-weight:700;color:#d97706;letter-spacing:.6px;text-transform:uppercase;margin-bottom:3px;">
                ${art.category}
            </div>
            <div class="lp-flora-title" style="font-size:13px;">${art.title}</div>
            <div class="lp-flora-desc">${art.excerpt}</div>
        </div>
        <button type="button" class="lp-remove-btn" style="flex-shrink:0;white-space:nowrap;"
                onclick="removeArticle(${id})">
            Remove from Homepage
        </button>
        <input type="hidden" name="article_ids[]" value="${id}" id="hArticle_${id}">
    `;

    list.appendChild(div);
    updateSlotsCount();
    closeModal('articlePickerModal');
    radio.checked = false;
}

/* ─────────────────────────────
    Remove article
───────────────────────────── */
function removeArticle(id) {
    const row = document.getElementById(`articleRow_${id}`);
    if (row) row.remove();
    updateSlotsCount();
}

/* ─────────────────────────────
    Update slots counter & button state
───────────────────────────── */
function updateSlotsCount() {
    const count   = document.querySelectorAll('input[name="article_ids[]"]').length;
    const counter = document.getElementById('slotsUsedCount');
    const btn     = document.getElementById('addArticleBtn');

    if (counter) counter.textContent = count;

    if (btn) {
        btn.disabled      = count >= MAX_SLOTS;
        btn.style.opacity = count >= MAX_SLOTS ? '0.4' : '1';
        btn.style.cursor  = count >= MAX_SLOTS ? 'not-allowed' : 'pointer';
    }
}
</script>