{{-- resources/views/home/sections/journal_preview.blade.php --}}

@php
$featuredArticlesData ??= \App\Models\LandingPageSetting::DEFAULTS['featured_articles'];

$featuredArticlesData = array_merge(
    \App\Models\LandingPageSetting::DEFAULTS['featured_articles'],
    $featuredArticlesData
);

// English (dari DB)
$sectionTitle       = $featuredArticlesData['section_title']       ?? 'Journal & Stories';
$sectionDescription = $featuredArticlesData['section_description'] ?? '';

// Indonesian (dari DB, fallback ke hardcode)
$sectionTitleId       = $featuredArticlesData['section_title_id']       ?? 'Jurnal & Cerita';
$sectionDescriptionId = $featuredArticlesData['section_description_id'] ?? $sectionDescription;

$featuredArticles ??= collect();
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=DM+Sans:wght@100..1000&display=swap" rel="stylesheet">

<section class="home-journal-section">
    <div class="home-journal-inner">

        {{-- Header --}}
        <div class="home-journal-header">
            <span class="home-journal-label"
                  data-en="{{ $sectionTitle }}"
                  data-id="{{ $sectionTitleId }}">{{ $sectionTitle }}</span>

            @if($sectionDescription)
            <h2 class="home-journal-title"
                data-en="{{ $sectionDescription }}"
                data-id="{{ $sectionDescriptionId }}">{{ $sectionDescription }}</h2>
            @endif
        </div>

        {{-- Cards Grid --}}
        <div class="home-journal-grid">

            @if($featuredArticles->count())

                @foreach($featuredArticles as $article)
                    <article class="home-journal-card">

                        <a href="{{ route('journal.show', $article->id) }}"
                           class="home-journal-card-img-wrap">
                            @if($article->thumbnail)
                                <img src="{{ asset($article->thumbnail) }}"
                                     alt="{{ $article->title }}">
                            @else
                                <img src="{{ asset('images/journal/The harmony islamic.png') }}"
                                     alt="{{ $article->title }}">
                            @endif
                        </a>

                        <div class="home-journal-card-body">

                            @if($article->category)
                            <span class="home-journal-card-cat">
                                {{ $article->category }}
                            </span>
                            @endif

                            <h3 class="home-journal-card-title">
                                {{ $article->title }}
                            </h3>

                            <p class="home-journal-card-excerpt">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>

                            <a href="{{ route('journal.show', $article->id) }}"
                               class="home-journal-card-link"
                               data-en="Discover More"
                               data-id="Selengkapnya">
                                Discover More
                                <svg width="18" height="12" viewBox="0 0 18 12" fill="none">
                                    <path d="M12 1L17 6L12 11M1 6H17"
                                          stroke="currentColor" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                        </div>
                    </article>
                @endforeach

            @else

                <div class="home-journal-empty"
                     data-en="No featured articles available yet."
                     data-id="Belum ada artikel unggulan yang tersedia.">
                    No featured articles available yet.
                </div>

            @endif

        </div>

        {{-- CTA --}}
        <div class="home-journal-cta">
            <a href="{{ route('journal.index') }}"
               class="home-journal-cta-btn"
               data-en="Visit Full Journal"
               data-id="Kunjungi Jurnal Lengkap">
                Visit Full Journal
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none">
                    <path d="M12 1L17 6L12 11M1 6H17"
                          stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

    </div>
</section>

<script>
document.addEventListener('alas:langchange', function (e) {
    applyJournalLang(e.detail.lang);
});

function applyJournalLang(lang) {
    document.querySelectorAll('.home-journal-section [data-en][data-id]').forEach(function (el) {
        // Simpan innerHTML asli (ada SVG di dalam link) sebelum di-overwrite
        if (!el.dataset.initDone) {
            el.dataset.enHtml = el.dataset.en;
            el.dataset.idHtml = el.dataset.id;
            el.dataset.initDone = '1';
        }

        // Elemen yang punya child SVG: ganti hanya text node, bukan seluruh innerHTML
        var svg = el.querySelector('svg');
        if (svg) {
            // Cari atau buat text node pertama
            var textNode = null;
            el.childNodes.forEach(function (node) {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim()) {
                    textNode = node;
                }
            });
            if (textNode) {
                textNode.textContent = (lang === 'id' ? el.dataset.id : el.dataset.en) + ' ';
            }
        } else {
            el.textContent = lang === 'id' ? el.dataset.id : el.dataset.en;
        }
    });
}

(function () {
    var lang = (window.AlasLang ? window.AlasLang.current() : null)
               || localStorage.getItem('alas_lang')
               || 'en';
    applyJournalLang(lang);
})();
</script>