{{-- resources/views/home/sections/living_ecosystem.blade.php --}}

@php
    $floraData   ??= \App\Models\LandingPageSetting::DEFAULTS['flora'];
    $floraData   = array_merge(\App\Models\LandingPageSetting::DEFAULTS['flora'], $floraData);

    // English (dari DB)
    $eyebrow     = $floraData['eyebrow']     ?? 'Living Ecosystem';
    $title       = $floraData['title']       ?? 'The Flora Concept';
    $description = $floraData['description'] ?? 'Every plant, tree, and herb at AlaSare is chosen with intention — to nourish, to heal, and to shelter the life that surrounds us.';
    $cards       = $floraData['cards']       ?? [];

    // Indonesian (dari DB, fallback ke hardcode)
    $eyebrowId     = $floraData['eyebrow_id']     ?? 'Ekosistem Hidup';
    $titleId       = $floraData['title_id']       ?? 'Konsep Flora';
    $descriptionId = $floraData['description_id'] ?? 'Setiap tanaman, pohon, dan herba di AlaSare dipilih dengan penuh kesadaran — untuk memberi nutrisi, menyembuhkan, dan melindungi kehidupan di sekitar kita.';

    // Default fallback images per card-index
    $defaultImages = [
        'images/flora-nourishment.png',
        'images/flora-aromatherapy.png',
        'images/flora-architecture.png',
    ];

    // Default cards jika DB kosong
    if (empty($cards)) {
        $cards = [
            [
                'eyebrow'         => 'Nourishment',
                'eyebrow_id'      => 'Nutrisi',
                'title'           => 'Edible Gardens',
                'title_id'        => 'Kebun Edibel',
                'description'     => 'Herbs, vegetables, and fruits grown on-site feed our kitchen and guests directly from the soil.',
                'description_id'  => 'Rempah, sayuran, dan buah-buahan yang ditanam di lokasi langsung memasok dapur dan tamu kami dari tanah.',
                'image_path'      => '',
            ],
            [
                'eyebrow'         => 'Aromatherapy',
                'eyebrow_id'      => 'Aromaterapi',
                'title'           => 'Scented Pathways',
                'title_id'        => 'Jalur Beraroma',
                'description'     => 'Lavender, lemongrass, and ylang-ylang line every walkway, turning each stroll into a sensory journey.',
                'description_id'  => 'Lavender, serai, dan kenanga menghiasi setiap jalur, mengubah setiap langkah menjadi perjalanan indrawi.',
                'image_path'      => '',
            ],
            [
                'eyebrow'         => 'Architecture',
                'eyebrow_id'      => 'Arsitektur',
                'title'           => 'Living Walls',
                'title_id'        => 'Dinding Hidup',
                'description'     => 'Vertical gardens integrated into villa structures provide natural insulation and a living canvas.',
                'description_id'  => 'Taman vertikal yang terintegrasi ke dalam struktur vila memberikan insulasi alami dan kanvas yang hidup.',
                'image_path'      => '',
            ],
        ];
    }
@endphp

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

    .eco-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 72px;
        box-sizing: border-box;
    }

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

    .eco-card:hover .eco-card-img img { transform: scale(1.04); }

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

    @media (max-width: 768px) {
        #home-ecosystem { padding: 60px 0 72px; }
        .eco-header      { margin-bottom: 40px; }
        .eco-grid        { grid-template-columns: 1fr; gap: 48px; padding: 0 24px; }
        .eco-card-img    { aspect-ratio: 4 / 3; }
    }
</style>

<section id="home-ecosystem">

    {{-- ── HEADER ── --}}
    <div class="eco-header">
        @if($eyebrow)
            <p class="eco-eyebrow"
               data-en="{{ $eyebrow }}"
               data-id="{{ $eyebrowId }}">{{ $eyebrow }}</p>
        @endif

        <h2 class="eco-heading"
            data-en="{{ $title }}"
            data-id="{{ $titleId }}">{{ $title }}</h2>

        @if($description)
            <p class="eco-subheading"
               data-en="{{ $description }}"
               data-id="{{ $descriptionId }}">{{ $description }}</p>
        @endif
    </div>

    {{-- ── GRID ── --}}
    @if(count($cards) > 0)
    <div class="eco-grid">
        @foreach($cards as $i => $card)
        <div class="eco-card">
            <div class="eco-card-img">
                @if(!empty($card['image_path']))
                    <img src="{{ asset('storage/' . $card['image_path']) }}"
                         alt="{{ $card['title'] ?? '' }}"
                         loading="lazy">
                @else
                    <img src="{{ asset($defaultImages[$i] ?? 'images/flora-nourishment.png') }}"
                         alt="{{ $card['title'] ?? '' }}"
                         loading="lazy">
                @endif
            </div>

            @if(!empty($card['eyebrow']))
                <p class="eco-card-eyebrow"
                   data-en="{{ $card['eyebrow'] }}"
                   data-id="{{ $card['eyebrow_id'] ?? $card['eyebrow'] }}">
                    {{ $card['eyebrow'] }}
                </p>
            @endif

            @if(!empty($card['title']))
                <h3 class="eco-card-title"
                    data-en="{{ $card['title'] }}"
                    data-id="{{ $card['title_id'] ?? $card['title'] }}">
                    {{ $card['title'] }}
                </h3>
            @endif

            @if(!empty($card['description']))
                <p class="eco-card-body"
                   data-en="{{ $card['description'] }}"
                   data-id="{{ $card['description_id'] ?? $card['description'] }}">
                    {{ $card['description'] }}
                </p>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</section>


