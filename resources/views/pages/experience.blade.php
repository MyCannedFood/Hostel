<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Experiences - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="experience-page">

@include('components.navbar')

<main>
    {{-- Hero Section --}}
    <section class="experience-hero">
        <div class="experience-hero-content">
            <h1 class="experience-hero-title">Find Meaning at AlaSare</h1>
            <p class="experience-hero-subtitle">Absorb the essence of the place, discover new passions, grow step by step.</p>
        </div>
    </section>

    {{-- Content Container --}}
    <section class="experience-container">

        {{-- Filters --}}
        <div class="experience-filters">
            <button class="filter-btn active" data-filter="all">ALL</button>
            <button class="filter-btn" data-filter="Wellness">WELLNESS</button>
            <button class="filter-btn" data-filter="Culture">CULTURAL</button>
            <button class="filter-btn" data-filter="Nature">NATURE</button>
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
                        <img src="https://images.unsplash.com/photo-1596431976070-13f59049a4f4?auto=format&fit=crop&q=80&w=800" alt="{{ $exp->name }}" class="card-image">
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-meta">IDR {{ number_format($exp->price, 0, ',', '.') }} / person</div>
                    <h3 class="card-title">{{ $exp->name }}</h3>
                    <p class="card-desc">
                        @if($exp->inclusions && count($exp->inclusions) > 0)
                            {{ implode(', ', $exp->inclusions) }}
                        @else
                            {{ $exp->name }} experience at AlaSare.
                        @endif
                    </p>
                    <a href="#" class="card-btn">Book Now</a>
                </div>
            </div>
            @empty
            <p style="color:rgba(0,0,0,0.4);font-size:14px;">No experiences available at the moment.</p>
            @endforelse
        </div>

        {{-- Discover More --}}
        <div class="discover-more">
            <a href="#" class="discover-btn">Discover More Experiences</a>
        </div>

    </section>
</main>

@include('components.footer')
<x-whatsapp_floating />

</body>
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
</html>
