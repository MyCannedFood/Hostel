<?php
// Data dari LandingPageSetting — di-pass oleh PageController
// $guestStoriesData sudah berupa array hasil merge DEFAULTS + DB

$perPage     = 6;
$currentPage = max(1, (int) request()->get('page', 1));
$allStories  = $guestStoriesData['stories'] ?? [];
$total       = count($allStories);
$lastPage    = max(1, (int) ceil($total / $perPage));
$currentPage = min($currentPage, $lastPage);
$offset      = ($currentPage - 1) * $perPage;
$stories     = array_slice($allStories, $offset, $perPage);
$hasPages    = $lastPage > 1;
$baseUrl     = request()->url();
$pageUrl     = fn($p) => $baseUrl . '?page=' . $p;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $guestStoriesData['title'] ?? 'Guest Stories' }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/guest-stories.css', 'resources/js/app.js'])
</head>
<body class="gs-page" style="margin: 0; padding: 0;">

@include('components.navbar')

<main>

    {{-- ===== HERO ===== --}}
    <section class="gs-hero">
        <h1 class="gs-hero__title">{{ $guestStoriesData['title'] ?? 'Guest Stories' }}</h1>
        <p class="gs-hero__sub">
            Discover the meaningful connections and restorative moments shared by<br>
            those who have walked our botanical trails and rested in our forest sanctuary.
        </p>
    </section>

    {{-- ===== TESTIMONIALS ===== --}}
    <section class="gs-list">

        @forelse ($stories as $index => $story)
            <article class="gs-card {{ $index % 2 !== 0 ? 'gs-card--right' : '' }}">
                <div class="gs-card__img">
                    @if (!empty($story['image_path']))
                        <img src="{{ asset('storage/' . $story['image_path']) }}" alt="{{ $story['name'] ?? '' }}">
                    @else
                        <div class="gs-card__img-placeholder">
                            {{ strtoupper(substr($story['name'] ?? 'G', 0, 1)) }}
                        </div>
                    @endif
                    <span class="gs-card__badge">
                        <span class="gs-card__badge-check">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6L12 2z"/>
                                <polyline points="9 12 11 14 15 10"/>
                            </svg>
                        </span>
                        Verified Guest
                    </span>
                </div>
                <div class="gs-card__body">
                    <span class="gs-card__ql">"</span>
                    <blockquote class="gs-card__quote">
                        "{{ $story['quote'] ?? '' }}"
                    </blockquote>
                    <div class="gs-card__meta">
                        <div class="gs-card__bar"></div>
                        <p class="gs-card__name">{{ $story['name'] ?? '' }}</p>
                        <p class="gs-card__detail">{{ $story['origin'] ?? '' }}</p>
                    </div>
                </div>
            </article>
        @empty
            <p style="text-align:center; color:#8a9b8c; font-family:'Georgia',serif; padding: 60px 0;">
                No guest stories yet.
            </p>
        @endforelse

    </section>

    {{-- ===== PAGINATION ===== --}}
    @if ($hasPages)
        <nav class="gs-pagination" aria-label="Guest Stories Pagination">

            {{-- Prev --}}
            @if ($currentPage <= 1)
                <span class="gs-pagination__btn gs-pagination__btn--disabled" aria-disabled="true">&larr;</span>
            @else
                <a href="{{ $pageUrl($currentPage - 1) }}" class="gs-pagination__btn" aria-label="Previous page">&larr;</a>
            @endif

            {{-- Page Numbers --}}
            @for ($p = 1; $p <= $lastPage; $p++)
                @if ($p === $currentPage)
                    <span class="gs-pagination__num gs-pagination__num--active" aria-current="page">{{ $p }}</span>
                @else
                    <a href="{{ $pageUrl($p) }}" class="gs-pagination__num">{{ $p }}</a>
                @endif
            @endfor

            {{-- Next --}}
            @if ($currentPage >= $lastPage)
                <span class="gs-pagination__btn gs-pagination__btn--disabled" aria-disabled="true">&rarr;</span>
            @else
                <a href="{{ $pageUrl($currentPage + 1) }}" class="gs-pagination__btn" aria-label="Next page">&rarr;</a>
            @endif

        </nav>
    @endif

</main>

@include('components.footer')

</body>
</html>