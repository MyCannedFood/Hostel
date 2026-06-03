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

    {{-- ── Section Info ── --}}
    <div class="lp-card">
        <div class="lp-field">
            <label class="lp-field-label">Section Title</label>
            <input type="text" class="lp-input lp-heading-input" name="section_title"
                   value="{{ old('section_title', $d['section_title']) }}" maxlength="200">
        </div>
        <div class="lp-field" style="margin-bottom:0;">
            <label class="lp-field-label">Section Description</label>
            <input type="text" class="lp-input" name="section_description"
                   value="{{ old('section_description', $d['section_description']) }}" maxlength="500">
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
        <button type="button" class="lp-dashed-btn" style="margin-top:16px;"
                id="addArticleBtn"
                onclick="openModal('articlePickerModal')"
                {{ $slotsUsed >= $maxSlots ? 'disabled' : '' }}
                style="{{ $slotsUsed >= $maxSlots ? 'opacity:0.4;cursor:not-allowed;' : '' }}">
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

        {{-- Search ── --}}
        <div style="margin-bottom:14px;">
            <div class="search-wrap" style="width:100%;margin-bottom:10px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                     style="position:absolute;left:10px;color:#a0a8a0;">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" class="search-input" placeholder="Search article title..."
                       style="width:100%;padding-left:34px;" oninput="filterArticlePicker(this.value)">
            </div>
            {{-- Category filter ── --}}
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <span style="font-size:12px;color:#7a857f;">Filter by:</span>
                <button type="button" class="sort-btn article-cat-filter active" data-cat=""
                        onclick="filterByCat(this,'')">All Categories</button>
                @foreach($allArticles->pluck('category')->filter()->unique()->sort() as $cat)
                <button type="button" class="sort-btn article-cat-filter" data-cat="{{ $cat }}"
                        onclick="filterByCat(this,'{{ $cat }}')">{{ $cat }}</button>
                @endforeach
            </div>
        </div>

        {{-- Article list ── --}}
        <div style="max-height:360px;overflow-y:auto;border:1px solid #f0f4ee;border-radius:10px;"
             id="articlePickerList">
            @forelse($allArticles as $art)
            <label class="article-picker-row"
                   data-title="{{ strtolower($art->title) }}"
                   data-cat="{{ $art->category ?? '' }}"
                   data-id="{{ $art->id }}"
                   style="display:flex;align-items:flex-start;gap:14px;padding:12px 14px;
                          cursor:pointer;transition:background .15s;border-bottom:1px solid #f0f4ee;">
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
.article-picker-row:hover{background:#f6f9f5;}
.article-cat-filter.active{background:#2d4a1e;color:#fff;border-color:#2d4a1e;}
</style>

<script>
// ── Article data embedded for JS (avoid extra AJAX) ──
const articleData = {
    @foreach($allArticles as $art)
    {{ $art->id }}: {
        id:        {{ $art->id }},
        title:     {{ json_encode($art->title) }},
        category:  {{ json_encode($art->category ?? '') }},
        thumbnail: {{ json_encode($art->thumbnail ? asset($art->thumbnail) : '') }},
        excerpt:   {{ json_encode(Str::limit(strip_tags($art->content), 80)) }},
    },
    @endforeach
};

const MAX_SLOTS = 3;

function openModal(id){ document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id){ document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
document.querySelectorAll('.modal-overlay').forEach(el=>{
    el.addEventListener('click',e=>{ if(e.target===el) closeModal(el.id); });
});

/* ── Filter article picker ── */
function filterArticlePicker(q) {
    const cat = document.querySelector('.article-cat-filter.active')?.dataset.cat ?? '';
    document.querySelectorAll('.article-picker-row').forEach(row => {
        const matchTitle = row.dataset.title.includes(q.toLowerCase());
        const matchCat   = !cat || row.dataset.cat === cat;
        row.style.display = (matchTitle && matchCat) ? '' : 'none';
    });
}

function filterByCat(btn, cat) {
    document.querySelectorAll('.article-cat-filter').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    filterArticlePicker(document.querySelector('input[placeholder="Search article title..."]')?.value ?? '');
}

/* ── Add selected article to list ── */
function addSelectedArticle() {
    const radio = document.querySelector('input[name="picker_article"]:checked');
    if (!radio) { alert('Pilih artikel terlebih dahulu.'); return; }

    const id = parseInt(radio.value);
    if (document.getElementById(`articleRow_${id}`)) {
        alert('Artikel ini sudah ada di daftar.'); return;
    }

    const currentCount = document.querySelectorAll('input[name="article_ids[]"]').length;
    if (currentCount >= MAX_SLOTS) { alert('Maksimal 3 artikel.'); return; }

    const art = articleData[id];
    if (!art) return;

    const list = document.getElementById('selectedArticlesList');
    const div  = document.createElement('div');
    div.className = 'lp-flora-card-item';
    div.id        = `articleRow_${id}`;
    div.style.cssText = 'padding:14px 0;border-bottom:1px solid #f0f4ee;';

    const thumbHtml = art.thumbnail
        ? `<img src="${art.thumbnail}" alt="${art.title}" style="width:80px;height:60px;border-radius:8px;object-fit:cover;">`
        : `<div style="width:80px;height:60px;border-radius:8px;background:#e8ede8;flex-shrink:0;"></div>`;

    div.innerHTML = `
        <div style="flex-shrink:0;">${thumbHtml}</div>
        <div class="lp-flora-text">
            <div style="font-size:10px;font-weight:700;color:#d97706;letter-spacing:.6px;text-transform:uppercase;margin-bottom:3px;">${art.category}</div>
            <div class="lp-flora-title" style="font-size:13px;">${art.title}</div>
            <div class="lp-flora-desc">${art.excerpt}</div>
        </div>
        <button type="button" class="lp-remove-btn" style="flex-shrink:0;white-space:nowrap;"
                onclick="removeArticle(${id})">Remove from Homepage</button>
        <input type="hidden" name="article_ids[]" value="${id}" id="hArticle_${id}">`;

    list.appendChild(div);
    updateSlotsCount();
    closeModal('articlePickerModal');
    radio.checked = false;
}

/* ── Remove article ── */
function removeArticle(id) {
    document.getElementById(`articleRow_${id}`)?.remove();
    updateSlotsCount();
}

function updateSlotsCount() {
    const count = document.querySelectorAll('input[name="article_ids[]"]').length;
    document.getElementById('slotsUsedCount').textContent = count;
    const btn = document.getElementById('addArticleBtn');
    if (btn) { btn.disabled = count >= MAX_SLOTS; btn.style.opacity = count >= MAX_SLOTS ? '0.4' : '1'; }
}
</script>