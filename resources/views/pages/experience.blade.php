<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-en="Experiences - AlaSare" data-id="Pengalaman - AlaSare">{{ __('experience.page_title') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="experience-page">

@include('components.navbar')

<main>
    {{-- Hero Section --}}
    <section class="experience-hero" style="background-image: url('{{ asset('images/heroex.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="experience-hero-content">
            <h1 class="experience-hero-title" data-en="Find Meaning at AlaSare" data-id="Temukan Makna di AlaSare">{{ __('experience.hero_title') }}</h1>
            <p class="experience-hero-subtitle" data-en="Absorb the essence of the place, discover new passions, grow step by step." data-id="Serap esensi tempat, temukan gairah baru, tumbuh langkah demi langkah.">{{ __('experience.hero_subtitle') }}</p>
        </div>
    </section>

    {{-- Content Container --}}
    <section class="experience-container">

        {{-- Filters --}}
        <div class="experience-filters">
            <button class="filter-btn active" data-filter="all" data-en="All" data-id="Semua">{{ strtoupper(__('experience.filter_all')) }}</button>
            <button class="filter-btn" data-filter="Wellness" data-en="Wellness" data-id="Wellness">{{ strtoupper(__('experience.filter_wellness')) }}</button>
            <button class="filter-btn" data-filter="Culture" data-en="Cultural" data-id="Budaya">{{ strtoupper(__('experience.filter_culture')) }}</button>
            <button class="filter-btn" data-filter="Nature" data-en="Nature" data-id="Alam">{{ strtoupper(__('experience.filter_nature')) }}</button>
        </div>

        {{-- Grid --}}
        <div class="experience-grid">
            @forelse($experiences as $exp)
            @php
                $catEn = $exp->category;
                $catId = match($exp->category) {
                    'Wellness' => 'Wellness',
                    'Culture'  => 'Budaya',
                    'Nature'   => 'Alam',
                    default    => $exp->category,
                };
                $nameEn = $exp->name_en ?? $exp->name;
                $nameId = $exp->name_id ?? $exp->name;
                $descEn = $exp->short_description_en;
                $descId = $exp->short_description_id;
                if (!$descEn) {
                    if ($exp->inclusions && count($exp->inclusions) > 0) {
                        $descEn = implode(', ', $exp->inclusions);
                    } else {
                        $descEn = $nameEn . ' Experience at AlaSare.';
                    }
                }
                if (!$descId) {
                    if ($exp->inclusions && count($exp->inclusions) > 0) {
                        $descId = implode(', ', $exp->inclusions);
                    } else {
                        $descId = $nameId . ' Pengalaman di AlaSare.';
                    }
                }
            @endphp
            <div class="experience-card" data-category="{{ $exp->category }}">
                <div class="card-image-wrapper">
                    <span class="card-tag" data-en="{{ $catEn }}" data-id="{{ $catId }}">{{ strtoupper($exp->category) }}</span>
                    @if($exp->cover_image)
                        <img src="{{ asset($exp->cover_image) }}" alt="{{ $exp->name }}" class="card-image">
                    @else
                        <img src="https://images.unsplash.com/photo-1596431976070-13f59049a4f4?auto=format&fit=crop&q=80&w=800"
                             alt="{{ $exp->name }}" class="card-image">
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-meta">{{ __('experience.price_per_person', ['price' => number_format($exp->price, 0, ',', '.')]) }}</div>
                    <h3 class="card-title" data-en="{{ $nameEn }}" data-id="{{ $nameId }}">{{ $exp->name }}</h3>
                    <p class="card-desc" data-en="{{ $descEn }}" data-id="{{ $descId }}">
                        {{ $exp->short_description ?: (($exp->inclusions && count($exp->inclusions) > 0) ? implode(', ', $exp->inclusions) : $exp->name . ' ' . __('experience.experience_label') . ' di AlaSare.') }}
                    </p>
                    {{-- Book Now → ke booking detail experience ini --}}
                    <a href="{{ route('experience.booking-detail', $exp->id) }}" class="card-btn" data-en="Book Now" data-id="Pesan Sekarang">{{ __('experience.book_now') }}</a>
                </div>
            </div>
            @empty
            <p style="color:rgba(0,0,0,0.4);font-size:14px;" data-en="No experiences available at the moment." data-id="Belum ada pengalaman yang tersedia.">{{ __('experience.no_experiences') }}</p>
            @endforelse
        </div>

        {{-- Discover More --}}
        <div class="discover-more">
            <a href="#" class="discover-btn" data-en="Discover More Experiences" data-id="Temukan Pengalaman Lainnya">{{ __('experience.discover_more') }}</a>
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