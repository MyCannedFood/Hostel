<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('experience.page_title') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="experience-page">

@include('components.navbar')

<main>
    {{-- Hero Section --}}
    <section class="experience-hero" style="background-image: url('{{ asset('images/heroex.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="experience-hero-content">
            <h1 class="experience-hero-title">{{ __('experience.hero_title') }}</h1>
            <p class="experience-hero-subtitle">{{ __('experience.hero_subtitle') }}</p>
        </div>
    </section>

    {{-- Content Container --}}
    <section class="experience-container">

        {{-- Filters --}}
        <div class="experience-filters">
            <button class="filter-btn active" data-filter="all">{{ strtoupper(__('experience.filter_all')) }}</button>
            <button class="filter-btn" data-filter="Wellness">{{ strtoupper(__('experience.filter_wellness')) }}</button>
            <button class="filter-btn" data-filter="Culture">{{ strtoupper(__('experience.filter_culture')) }}</button>
            <button class="filter-btn" data-filter="Nature">{{ strtoupper(__('experience.filter_nature')) }}</button>
        </div>

        {{-- Grid --}}
        <div class="experience-grid">
            @forelse($experiences as $exp)
            <div class="experience-card" data-category="{{ $exp->category }}">
                <div class="card-image-wrapper">
                    <span class="card-tag">{{ strtoupper($exp->category) }}</span>
                    @if($exp->cover_image)
                        <img src="{{ asset($exp->cover_image) }}" alt="{{ $exp->name }}" class="card-image">
                    @else
                        <img src="https://images.unsplash.com/photo-1596431976070-13f59049a4f4?auto=format&fit=crop&q=80&w=800"
                             alt="{{ $exp->name }}" class="card-image">
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-meta">{{ __('experience.price_per_person', ['price' => number_format($exp->price, 0, ',', '.')]) }}</div>
                    <h3 class="card-title">{{ $exp->name }}</h3>
                    <p class="card-desc">
                        @if($exp->short_description)
                            {{ $exp->short_description }}
                        @elseif($exp->inclusions && count($exp->inclusions) > 0)
                            {{ implode(', ', $exp->inclusions) }}
                        @else
                            {{ $exp->name }} {{ __('experience.experience_label') }} di AlaSare.
                        @endif
                    </p>
                    {{-- Book Now → ke booking detail experience ini --}}
                    <a href="{{ route('experience.booking-detail', $exp->id) }}" class="card-btn">{{ __('experience.book_now') }}</a>
                </div>
            </div>
            @empty
            <p style="color:rgba(0,0,0,0.4);font-size:14px;">{{ __('experience.no_experiences') }}</p>
            @endforelse
        </div>

        {{-- Discover More --}}
        <div class="discover-more">
            <a href="#" class="discover-btn">{{ __('experience.discover_more') }}</a>
        </div>

    </section>
</main>

@include('components.footer')
<x-whatsapp_floating />

<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const filter = this.dataset.filter;
        document.querySelectorAll('.experience-card').forEach(card => {
            if (filter === 'all' || card.dataset.category === filter) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

</body>
</html>