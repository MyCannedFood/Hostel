{{-- resources/views/home/sections/journal_preview.blade.php --}}
{{-- Data: $featuredArticles (Collection of Article), $featuredArticlesData (array) --}}

@php
$featuredArticlesData ??= \App\Models\LandingPageSetting::DEFAULTS['featured_articles'];

$featuredArticlesData = array_merge(
    \App\Models\LandingPageSetting::DEFAULTS['featured_articles'],
    $featuredArticlesData
);

$sectionTitle       = $featuredArticlesData['section_title'] ?? 'Journal & Stories';
$sectionDescription = $featuredArticlesData['section_description'] ?? '';

$featuredArticles ??= collect();

@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=DM+Sans:wght@100..1000&display=swap" rel="stylesheet">

<section class="home-journal-section">
    <div class="home-journal-inner">

```
    {{-- Header --}}
    <div class="home-journal-header">
        <span class="home-journal-label">
            {{ $sectionTitle }}
        </span>

        <h2 class="home-journal-title">
            {{ $sectionDescription }}
        </h2>
    </div>

    {{-- Cards Grid --}}
    <div class="home-journal-grid">

        @if($featuredArticles->count())

            @foreach($featuredArticles as $article)

                <article class="home-journal-card">

                    <a href="{{ route('journal.show', $article->id) }}"
                       class="home-journal-card-img-wrap">

                        @if($article->thumbnail)
                            <img
                                src="{{ asset($article->thumbnail) }}"
                                alt="{{ $article->title }}"
                            >
                        @else
                            <img
                                src="{{ asset('images/journal/The harmony islamic.png') }}"
                                alt="{{ $article->title }}"
                            >
                        @endif

                    </a>

                    <div class="home-journal-card-body">

                        <span class="home-journal-card-cat">
                            {{ $article->category ?? '' }}
                        </span>

                        <h3 class="home-journal-card-title">
                            {{ $article->title }}
                        </h3>

                        <p class="home-journal-card-excerpt">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <a href="{{ route('journal.show', $article->id) }}"
                           class="home-journal-card-link">

                            Discover More

                            <svg width="18"
                                 height="12"
                                 viewBox="0 0 18 12"
                                 fill="none">
                                <path
                                    d="M12 1L17 6L12 11M1 6H17"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>

                        </a>

                    </div>

                </article>

            @endforeach

        @else

            <div class="home-journal-empty">
                No featured articles available yet.
            </div>

        @endif

    </div>

    {{-- CTA --}}
    <div class="home-journal-cta">
        <a href="{{ route('journal.index') }}"
           class="home-journal-cta-btn">

            Visit Full Journal

            <svg width="18"
                 height="12"
                 viewBox="0 0 18 12"
                 fill="none">
                <path
                    d="M12 1L17 6L12 11M1 6H17"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

        </a>
    </div>

</div>

</section>
