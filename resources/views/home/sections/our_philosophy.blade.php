{{-- resources/views/home/sections/our_philosophy.blade.php --}}

@php
    $philosophyData ??= \App\Models\LandingPageSetting::DEFAULTS['philosophy'];

    // English (dari DB)
    $tagline     = $philosophyData['tagline']     ?? 'OUR PHILOSOPHY';
    $heading     = $philosophyData['heading']     ?? 'Breathing with the Earth';
    $body1       = $philosophyData['body_1']      ?? 'At AlaSare, we believe a retreat should leave the land better than it found it. Every structure, every path, every choice is guided by one question: does this serve the forest?';
    $body2       = $philosophyData['body_2']      ?? 'We work alongside local Javanese craftsmen, use materials harvested within 40 km, and return 30% of revenue to active reforestation. Staying here is an act of care.';
    $features    = $philosophyData['features']    ?? [];
    $badgeLabel  = $philosophyData['badge_label'] ?? 'Conservation';
    $badgeValue  = $philosophyData['badge_value'] ?? '80% Forest Cover';

    // Indonesian (dari DB, fallback ke hardcode)
    $taglineId    = $philosophyData['tagline_id']     ?? 'FILOSOFI KAMI';
    $headingId    = $philosophyData['heading_id']     ?? 'Bernafas Bersama Bumi';
    $body1Id      = $philosophyData['body_1_id']      ?? 'Di AlaSare, kami percaya bahwa sebuah retreat seharusnya meninggalkan alam dalam kondisi lebih baik dari sebelumnya. Setiap struktur, setiap jalur, setiap keputusan dipandu oleh satu pertanyaan: apakah ini bermanfaat bagi hutan?';
    $body2Id      = $philosophyData['body_2_id']      ?? 'Kami bekerja bersama pengrajin Jawa lokal, menggunakan bahan-bahan yang dipanen dalam radius 40 km, dan mengalokasikan 30% pendapatan untuk penghijauan aktif. Menginap di sini adalah sebuah tindakan kepedulian.';
    $badgeLabelId = $philosophyData['badge_label_id'] ?? 'Konservasi';

    $sideImgUrl  = !empty($philosophyData['side_image'])
                   ? asset('storage/' . $philosophyData['side_image'])
                   : asset('images/Philosophy.png');

    $defaultIcons = ['images/Footprint.png', 'images/Rewilding.png'];

    // Default features jika DB kosong
    if (empty($features)) {
        $features = [
            [
                'title'          => 'Zero Carbon Footprint',
                'title_id'       => 'Nol Jejak Karbon',
                'description'    => 'Solar-powered villas, composting kitchens, and zero single-use plastics across the entire property.',
                'description_id' => 'Vila bertenaga surya, dapur kompos, dan bebas plastik sekali pakai di seluruh properti.',
                'icon_path'      => '',
            ],
            [
                'title'          => 'Active Rewilding',
                'title_id'       => 'Penghijauan Aktif',
                'description'    => 'Each stay funds the planting of native Javanese species, restoring biodiversity one tree at a time.',
                'description_id' => 'Setiap kunjungan mendanai penanaman spesies asli Jawa, memulihkan keanekaragaman hayati satu pohon demi satu pohon.',
                'icon_path'      => '',
            ],
        ];
    }
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Jost:wght@300;400;500;600&display=swap');

    #home-philosophy-transition {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        height: 130px;
        background: linear-gradient(
            to bottom,
            #2c3829 0%,
            #4b5546 24%,
            #b8bfb4 58%,
            #ecece6 84%,
            #f6f6f1 100%
        );
    }

    #home-philosophy {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        background: #f6f6f1;
        padding: 58px 0 100px;
        overflow: hidden;
        box-sizing: border-box;
    }

    #home-philosophy .phil-inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 58px;
        display: grid;
        grid-template-columns: 0.95fr 1.05fr;
        gap: 78px;
        align-items: start;
        box-sizing: border-box;
    }

    .phil-left  { padding-top: 68px; }

    .phil-eyebrow {
        font-family: 'Jost', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #7e9a75;
        margin: 0 0 18px;
    }

    .phil-heading {
        font-family: 'Cormorant Garamond', serif;
        font-size: 56px;
        line-height: 1.02;
        font-weight: 400;
        color: #213c17;
        margin: 0 0 30px;
        letter-spacing: -0.02em;
    }

    .phil-body {
        font-family: 'Jost', sans-serif;
        font-size: 15px;
        line-height: 2;
        font-weight: 300;
        color: #5d645d;
        margin: 0 0 20px;
        max-width: 470px;
    }

    .phil-body:last-of-type { margin-bottom: 42px; }

    .phil-features  { max-width: 500px; }

    .phil-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 18px 0;
        border-bottom: 1px solid rgba(33,60,23,0.10);
    }

    .phil-feature-item:first-child { border-top: 1px solid rgba(33,60,23,0.10); }

    .phil-feature-icon {
        width: 30px;
        height: 30px;
        flex-shrink: 0;
        margin-top: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #edf1e6;
        border-radius: 50%;
    }

    .phil-feature-icon img {
        width: 15px;
        height: 15px;
        object-fit: contain;
        display: block;
    }

    .phil-feature-text h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 400;
        color: #213c17;
        margin: 0 0 4px;
        line-height: 1;
    }

    .phil-feature-text p {
        font-family: 'Jost', sans-serif;
        font-size: 14px;
        line-height: 1.7;
        font-weight: 300;
        color: #737973;
        margin: 0;
        max-width: 420px;
    }

    .phil-right   { position: relative; }

    .phil-img-wrap {
        position: relative;
        overflow: hidden;
        width: 100%;
        line-height: 0;
    }

    .phil-img-wrap img {
        width: 100%;
        height: 760px;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .phil-badge {
        position: absolute;
        left: 18px;
        right: 18px;
        bottom: 18px;
        background: rgba(248,248,244,0.94);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .phil-badge-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .phil-badge-icon img {
        width: 28px;
        height: 28px;
        object-fit: contain;
        display: block;
    }

    .phil-badge-text {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .badge-label {
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #7e9a75;
        line-height: 1;
    }

    .badge-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 400;
        color: #213c17;
        line-height: 1;
    }

    @media (max-width: 768px) {
        #home-philosophy-transition { height: 90px; }
        #home-philosophy { padding: 34px 0 70px; }

        #home-philosophy .phil-inner {
            grid-template-columns: 1fr;
            gap: 0;
            padding: 0;
        }

        .phil-right { order: 1; }
        .phil-left  { order: 2; padding: 40px 24px 0; }

        .phil-heading         { font-size: 42px; }
        .phil-body            { max-width: 100%; font-size: 14px; line-height: 1.9; }
        .phil-feature-text h4 { font-size: 22px; }
        .phil-img-wrap img    { height: 420px; }

        .phil-badge {
            left: 10px;
            right: 10px;
            bottom: 10px;
            padding: 14px 16px;
        }

        .badge-value { font-size: 21px; }
    }
</style>

<div id="home-philosophy-transition"></div>

<section id="home-philosophy">
    <div class="phil-inner">

        {{-- ── LEFT ── --}}
        <div class="phil-left">

            <p class="phil-eyebrow"
               data-en="{{ $tagline }}"
               data-id="{{ $taglineId }}">{{ $tagline }}</p>

            <h2 class="phil-heading"
                data-en="{{ $heading }}"
                data-id="{{ $headingId }}">{{ $heading }}</h2>

            @if($body1)
                <p class="phil-body"
                   data-en="{{ $body1 }}"
                   data-id="{{ $body1Id }}">{{ $body1 }}</p>
            @endif

            @if($body2)
                <p class="phil-body"
                   data-en="{{ $body2 }}"
                   data-id="{{ $body2Id }}">{{ $body2 }}</p>
            @endif

            @if(count($features) > 0)
            <div class="phil-features">
                @foreach($features as $i => $feat)
                <div class="phil-feature-item">
                    <div class="phil-feature-icon">
                        @if(!empty($feat['icon_path']))
                            <img src="{{ asset('storage/' . $feat['icon_path']) }}"
                                 alt="{{ $feat['title'] ?? '' }}">
                        @else
                            <img src="{{ asset($defaultIcons[$i] ?? 'images/Footprint.png') }}"
                                 alt="{{ $feat['title'] ?? '' }}">
                        @endif
                    </div>
                    <div class="phil-feature-text">
                        <h4 data-en="{{ $feat['title'] ?? '' }}"
                            data-id="{{ $feat['title_id'] ?? $feat['title'] ?? '' }}">
                            {{ $feat['title'] ?? '' }}
                        </h4>
                        @if(!empty($feat['description']))
                            <p data-en="{{ $feat['description'] }}"
                               data-id="{{ $feat['description_id'] ?? $feat['description'] }}">
                                {{ $feat['description'] }}
                            </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>

        {{-- ── RIGHT ── --}}
        <div class="phil-right">
            <div class="phil-img-wrap">
                <img src="{{ $sideImgUrl }}" alt="AlaSare Forest View">

                @if($badgeLabel || $badgeValue)
                <div class="phil-badge">
                    <div class="phil-badge-icon">
                        <img src="{{ asset('images/leaf.png') }}" alt="">
                    </div>
                    <div class="phil-badge-text">
                        @if($badgeLabel)
                            <span class="badge-label"
                                  data-en="{{ $badgeLabel }}"
                                  data-id="{{ $badgeLabelId }}">{{ $badgeLabel }}</span>
                        @endif
                        @if($badgeValue)
                            <span class="badge-value">{{ $badgeValue }}</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</section>
