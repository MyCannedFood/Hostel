<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-en="Journal & Story - AlaSare" data-id="Jurnal & Cerita - AlaSare">Journal & Story - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: var(--color-bg-light); color: #111;">

@include('components.navbar')

<main class="journal-container">
    <div class="journal-header">
        <h1 data-en="Journal & Story" data-id="Jurnal & Cerita">Journal & Story</h1>
        <div class="journal-categories">
            <a href="{{ route('journal.index') }}" class="category-link {{ !$selectedCategory || $selectedCategory === 'All' ? 'active' : '' }}" data-en="All" data-id="Semua">All</a>
            @foreach($categories as $cat)
                <a href="{{ route('journal.index', ['category' => $cat]) }}" class="category-link {{ $selectedCategory === $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>
    </div>

    <div class="journal-grid">
        @forelse($articles as $art)
            <article class="journal-card">
                <div class="journal-card-image">
                    @if($art->thumbnail)
                        <img src="{{ asset($art->thumbnail) }}" alt="{{ $art->title }}">
                    @else
                        <img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="{{ $art->title }}">
                    @endif
                </div>
                <div class="journal-card-category">{{ $art->category }}</div>
                <h3 data-en="{{ $art->title_en ?? $art->title }}" data-id="{{ $art->title_id ?? $art->title }}">{{ $art->title }}</h3>
                <p class="journal-card-excerpt" data-en="{{ Str::limit(strip_tags($art->content_en ?? $art->content), 120) }}" data-id="{{ Str::limit(strip_tags($art->content_id ?? $art->content), 120) }}">{{ Str::limit(strip_tags($art->content), 120) }}</p>
                <a href="{{ route('journal.show', $art->id) }}" class="discover-more" data-en="Discover More" data-id="Selengkapnya">
                    Discover More
                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1L17 6L12 11M1 6H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </article>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 48px; color: rgba(26,61,10,0.6);">
                <p style="font-size: 18px; font-weight: 500;" data-en="No articles found." data-id="Tidak ada artikel ditemukan.">No articles found.</p>
            </div>
        @endforelse
    </div>

    <!-- Subscription Section -->
    <section class="journal-subscription">
        <div class="subscription-icon">
            <img src="{{ asset('images/journal/Icon.png') }}" alt="AlaSare Leaf" style="width: 30px; height: auto;">
        </div>
        <h2 data-en="Get your AlaSare inspiration." data-id="Dapatkan inspirasi AlaSare Anda.">Get your AlaSare inspiration.</h2>
        <p data-en="Subscribe to our latest updates on natural serenity, local wisdom, and exclusive offers delivered straight to your inbox." data-id="Berlangganan untuk mendapatkan pembaruan tentang ketenangan alam, kearifan lokal, dan penawaran eksklusif langsung ke kotak masuk Anda.">Subscribe to our latest updates on natural serenity, local wisdom, and exclusive offers delivered straight to your inbox.</p>
        <form class="subscription-form">
            <input type="email" placeholder="Your email address" required>
            <button type="submit" data-en="Subscribe" data-id="Berlangganan">Subscribe</button>
        </form>
    </section>
</main>

@include('components.footer')

<x-whatsapp_floating />

</body>
</html>
