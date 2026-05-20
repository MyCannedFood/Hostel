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
            <button class="filter-btn active">ALL</button>
            <button class="filter-btn">WELLNESS</button>
            <button class="filter-btn">CULTURAL</button>
            <button class="filter-btn">NATURE</button>
        </div>

        {{-- Grid --}}
        <div class="experience-grid">
            
            {{-- Card 1 --}}
            <div class="experience-card">
                <div class="card-image-wrapper">
                    <span class="card-tag">WELLNESS</span>
                    <img src="{{ asset('images/experience/Traditional Jamu Ritual.png') }}" alt="Traditional Jamu Ritual" class="card-image" onerror="this.src='https://images.unsplash.com/photo-1596431976070-13f59049a4f4?auto=format&fit=crop&q=80&w=800'">
                </div>
                <div class="card-content">
                    <div class="card-meta">IDR 250.000 | 1 PERSON</div>
                    <h3 class="card-title">Traditional Jamu Ritual</h3>
                    <p class="card-desc">Learn the art of crafting jamu from a choice of hand-picked medicinal herbs grown in AlaSare's organic garden for ancestral balance.</p>
                    <a href="#" class="card-btn">Book Now</a>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="experience-card">
                <div class="card-image-wrapper">
                    <span class="card-tag">CULTURAL</span>
                    <img src="{{ asset('images/experience/Batik Canting Ritual.png') }}" alt="Batik Canting Ritual" class="card-image" onerror="this.src='https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&q=80&w=800'">
                </div>
                <div class="card-content">
                    <div class="card-meta">IDR 350.000 | 1 PERSON</div>
                    <h3 class="card-title">Batik Canting Ritual</h3>
                    <p class="card-desc">Beyond art, Batik is a meditation of patience. Pour your story onto cloth through the intricate technique of hand-drawn batik tulis, rich in philosophy.</p>
                    <a href="#" class="card-btn">Book Now</a>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="experience-card">
                <div class="card-image-wrapper">
                    <span class="card-tag">NATURE</span>
                    <img src="{{ asset('images/experience/Nurture the Earth - Tree Planting.png') }}" alt="Nurture the Earth" class="card-image" onerror="this.src='https://images.unsplash.com/photo-1611080911579-2cd1ab8b50e4?auto=format&fit=crop&q=80&w=800'">
                </div>
                <div class="card-content">
                    <div class="card-meta">IDR 200.000 | 1 PERSON</div>
                    <h3 class="card-title">Nurture the Earth</h3>
                    <p class="card-desc">Join our earthling journey. Plant a native tree sapling in the AlaSare forest, leaving a living legacy of growth and renewal for the Javanese soil.</p>
                    <a href="#" class="card-btn">Book Now</a>
                </div>
            </div>

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
</html>
