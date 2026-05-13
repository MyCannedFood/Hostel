{{-- Home - Living Ecosystem --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap');

    #home-ecosystem {
        background: #FFFFFF;
        padding: 80px 0 100px;
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        box-sizing: border-box;
    }

    /* ── HEADER ── */
    .eco-header {
        text-align: center;
        margin-bottom: 64px;
        padding: 0 24px;
    }

    .eco-eyebrow {
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #4b9960;
        margin: 0 0 14px;
    }

    .eco-heading {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 400;
        font-size: clamp(36px, 4vw, 52px);
        line-height: 1.1;
        color: #1a3d0a;
        margin: 0 0 20px;
        letter-spacing: -0.01em;
    }

    .eco-subheading {
        font-family: 'Jost', sans-serif;
        font-weight: 300;
        font-size: 14px;
        line-height: 1.8;
        color: #555;
        max-width: 560px;
        margin: 0 auto;
    }

    /* ── GRID ── */
    .eco-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 72px;
        box-sizing: border-box;
    }

    /* ── CARD ── */
    .eco-card {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .eco-card-img {
        width: 100%;
        aspect-ratio: 3 / 3.5;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .eco-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform 0.6s ease;
    }

    .eco-card:hover .eco-card-img img {
        transform: scale(1.04);
    }

    .eco-card-eyebrow {
        font-family: 'Jost', sans-serif;
        font-size: 9.5px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #4b9960;
        margin: 0 0 10px;
        text-align: center;
    }

    .eco-card-title {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 400;
        font-size: clamp(24px, 2.2vw, 32px);
        line-height: 1.15;
        color: #1a3d0a;
        margin: 0 0 14px;
        text-align: center;
        letter-spacing: -0.01em;
    }

    .eco-card-body {
        font-family: 'Jost', sans-serif;
        font-weight: 300;
        font-size: 12.5px;
        line-height: 1.75;
        color: #666;
        text-align: center;
        max-width: 300px;
        margin: 0 auto;
    }

    /* ── Mobile ── */
    @media (max-width: 768px) {
        #home-ecosystem {
            padding: 60px 0 72px;
        }

        .eco-header {
            margin-bottom: 40px;
        }

        .eco-grid {
            grid-template-columns: 1fr;
            gap: 48px;
            padding: 0 24px;
        }

        .eco-card-img {
            aspect-ratio: 4 / 3;
        }
    }
</style>

<section id="home-ecosystem">

    {{-- HEADER --}}
    <div class="eco-header">
        <p class="eco-eyebrow">Living Ecosystem</p>
        <h2 class="eco-heading">The Flora Concept</h2>
        <p class="eco-subheading">Every plant at AlaSare serves a purpose, from culinary delights to therapeutic aromas, creating a multi-sensory journey through Java.</p>
    </div>

    {{-- GRID --}}
    <div class="eco-grid">

        {{-- Card 1 --}}
        <div class="eco-card">
            <div class="eco-card-img">
                <img src="{{ asset('images/flora-nourishment.png') }}" alt="Edible Garden">
            </div>
            <p class="eco-card-eyebrow">Nourishment</p>
            <h3 class="eco-card-title">Edible Garden</h3>
            <p class="eco-card-body">Discover our collection of rare Nusantara vegetables and medicinal herbs, harvested daily for our kitchen.</p>
        </div>

        {{-- Card 2 --}}
        <div class="eco-card">
            <div class="eco-card-img">
                <img src="{{ asset('images/flora-aromatherapy.png') }}" alt="The Scent of Java">
            </div>
            <p class="eco-card-eyebrow">Aromatherapy</p>
            <h3 class="eco-card-title">The Scent of Java</h3>
            <p class="eco-card-body">Breathe in the calming essence of Melati (Jasmine) and Ylang-Ylang strategically planted to catch the evening breeze.</p>
        </div>

        {{-- Card 3 --}}
        <div class="eco-card">
            <div class="eco-card-img">
                <img src="{{ asset('images/flora-architecture.png') }}" alt="Tropical Wilderness">
            </div>
            <p class="eco-card-eyebrow">Architecture</p>
            <h3 class="eco-card-title">Tropical Wilderness</h3>
            <p class="eco-card-body">Lush Brazilian ferns and native creepers designed to blur the boundaries between your room and the jungle.</p>
        </div>

    </div>

</section>