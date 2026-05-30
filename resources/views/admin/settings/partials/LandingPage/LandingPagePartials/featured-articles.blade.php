{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/featured-articles.blade.php --}}

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Journal &amp; Stories</h2>

@php
$maxSlots = 3;
$selectedArticles = [
    ['id'=>1,'image'=>null,'category'=>'CULTURE & SERENITY',
     'title'=>'The Harmony of Islamic Values and Javanese Wisdom',
     'excerpt'=>'Finding a moment to breathe through tafakkur (nature reflection), where the whispers of mountain breezes meet...'],
    ['id'=>2,'image'=>null,'category'=>'TASTE OF ALASARE',
     'title'=>'The Healing Power of Archipelago Rhizomes',
     'excerpt'=>'Tracing the history of traditional herbal remedies passed down through generations, warming the body and soul...'],
];
$slotsUsed = count($selectedArticles);
@endphp

{{-- ── Section Info ── --}}
<div class="lp-card">
    <div class="lp-field">
        <label class="lp-field-label">Section Title</label>
        <input type="text" class="lp-input lp-heading-input" name="title"
               value="Journal &amp; Stories">
    </div>
    <div class="lp-field">
        <label class="lp-field-label">Section Description</label>
        <input type="text" class="lp-input" name="description"
               value="Curated stories on nature, slow living, and our architectural journey in the urban jungle.">
    </div>
</div>

{{-- ── Selected Articles ── --}}
<div class="lp-card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <p class="lp-card-label" style="margin:0;">Selected Articles</p>
        <span style="font-size:12px;color:#9aaa96;font-weight:600;">
            {{ $slotsUsed }} of {{ $maxSlots }} slots used
        </span>
    </div>

    <div id="articlesList">
        @foreach($selectedArticles as $article)
        <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid #f0f4ee;">
            @if($article['image'])
                <img src="{{ asset('storage/'.$article['image']) }}" alt="{{ $article['title'] }}"
                     style="width:80px;height:60px;border-radius:8px;object-fit:cover;flex-shrink:0;">
            @else
                <div style="width:80px;height:60px;border-radius:8px;background:#e8ede8;flex-shrink:0;"></div>
            @endif
            <div style="flex:1;min-width:0;">
                <div style="font-size:10px;font-weight:700;color:#d97706;letter-spacing:.6px;
                            text-transform:uppercase;margin-bottom:4px;">
                    {{ $article['category'] }}
                </div>
                <div style="font-size:14px;font-weight:600;color:#1a3d0a;margin-bottom:4px;line-height:1.4;">
                    {{ $article['title'] }}
                </div>
                <div style="font-size:12px;color:#9aaa96;line-height:1.5;">
                    {{ $article['excerpt'] }}
                </div>
            </div>
            <button type="button" class="lp-remove-btn" style="flex-shrink:0;white-space:nowrap;">
                Remove from Homepage
            </button>
        </div>
        @endforeach
    </div>

    {{-- Add slot --}}
    @if($slotsUsed < $maxSlots)
    <button type="button" class="lp-dashed-btn" style="margin-top:16px;"
            onclick="openArticlePickerModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
        </svg>
        Select Article from Database
    </button>
    @endif
</div>


{{-- ════ MODAL: Select Article ════ --}}
<div class="modal-overlay" id="articlePickerModal">
    <div class="modal-box" style="max-width:560px;">
        <div class="modal-header">
            <h3 class="modal-title">Select Article to Feature</h3>
            <button type="button" class="modal-close" onclick="closeModal('articlePickerModal')">✕</button>
        </div>

        {{-- Search + Filter --}}
        <div style="margin-bottom:16px;">
            <div class="search-wrap" style="width:100%;margin-bottom:12px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="position:absolute;left:10px;color:#a0a8a0;">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" class="search-input" placeholder="Search article title..."
                       style="width:100%;padding-left:34px;" oninput="filterArticles(this.value)">
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:12px;color:#7a857f;">Filter by:</span>
                <button type="button" class="sort-btn" style="font-size:12px;">All Categories ▾</button>
            </div>
        </div>

        {{-- Article list --}}
        <div style="max-height:320px;overflow-y:auto;" id="articlePickerList">
            @php
            $allArticles = [
                ['id'=>1,'image'=>null,'category'=>'CULTURE & SERENITY',
                 'title'=>'The Harmony of Islamic Values and Javanese Wisdom',
                 'excerpt'=>'Finding a moment to breathe through tafakkur (nature reflection), where the whispers of mountain breezes meet ...'],
                ['id'=>3,'image'=>null,'category'=>'TRAVEL TIPS',
                 'title'=>'Connecting Through Handcrafted Art',
                 'excerpt'=>'A guide to deep interaction with the local community, where you are not merely a guest but a part of the family...'],
            ];
            @endphp

            @foreach($allArticles as $a)
            <label style="display:flex;align-items:flex-start;gap:14px;padding:14px;border-radius:10px;
                          cursor:pointer;transition:background .15s;margin-bottom:4px;"
                   class="article-picker-row"
                   onmouseover="this.style.background='#f6f9f5'"
                   onmouseout="this.style.background='transparent'">
                @if($a['image'])
                    <img src="{{ asset('storage/'.$a['image']) }}" alt="{{ $a['title'] }}"
                         style="width:68px;height:52px;border-radius:7px;object-fit:cover;flex-shrink:0;">
                @else
                    <div style="width:68px;height:52px;border-radius:7px;background:#e8ede8;flex-shrink:0;"></div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-size:10px;font-weight:700;color:#d97706;letter-spacing:.6px;
                                text-transform:uppercase;margin-bottom:3px;">
                        {{ $a['category'] }}
                    </div>
                    <div style="font-size:13px;font-weight:600;color:#1a3d0a;margin-bottom:3px;line-height:1.4;">
                        {{ $a['title'] }}
                    </div>
                    <div style="font-size:11px;color:#9aaa96;line-height:1.5;">
                        {{ $a['excerpt'] }}
                    </div>
                </div>
                <input type="radio" name="selected_article" value="{{ $a['id'] }}"
                       style="width:18px;height:18px;accent-color:#2d4a1e;flex-shrink:0;margin-top:4px;">
            </label>
            @endforeach
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-orange-outline" onclick="closeModal('articlePickerModal')">Cancel</button>
            <button type="button" class="btn btn-dark">Add to Homepage</button>
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
.lp-dashed-btn:hover { border-color:#4a7c3f;background:#f4f9f4; }
</style>

<script>
/* ── Modal helpers (defined here because partials load independently) ── */
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', e => { if (e.target === el) closeModal(el.id); });
    });
});

function openArticlePickerModal() { openModal('articlePickerModal'); }
function filterArticles(q) {
    document.querySelectorAll('.article-picker-row').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(q.toLowerCase()) ? '' : 'none';
    });
}
</script>