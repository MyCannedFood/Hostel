<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Gallery — AlaSare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        :root{
            --green-dark:#1A3D0A;
            --green-mid:#4B9960;
            --green-light:#B8D9A0;
            --white-soft:#F6F6F1;
            --terracotta:#D9864A;
            --ink:#1A1A18;
            --muted:#7A7A72;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            margin:0;
            padding:0;
            background:var(--white-soft);
            color:var(--ink);
            font-family:'Jost',sans-serif;
        }

        main{
            background:#fff;
        }

        /* ───────────────── HERO ───────────────── */
        .gallery-header{
            position:relative;
            overflow:hidden;

            min-height:720px;

            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;

            text-align:center;

            padding:140px 24px 120px;

            color:#fff;
        }

        .gallery-header::before{
            content:'';
            position:absolute;
            inset:0;

            background-image:url("{{ asset('images/gallery/hero-gallery.png') }}");
            background-size:cover;
            background-position:center;

            transform:scale(1.04);

            animation:heroZoom 14s ease-out forwards;
        }

        .gallery-header::after{
            content:'';
            position:absolute;
            inset:0;

            background:
                linear-gradient(
                    to bottom,
                    rgba(10,22,8,0.16) 0%,
                    rgba(10,22,8,0.45) 45%,
                    rgba(10,22,8,0.72) 100%
                );
        }

        @keyframes heroZoom{
            from{
                transform:scale(1.04);
            }
            to{
                transform:scale(1);
            }
        }

        .hero-content{
            position:relative;
            z-index:2;
            max-width:900px;
        }

        .gallery-header h1{
            font-family:'Cormorant Garamond',serif;
            font-weight:300;
            font-size:76.8px;
            line-height:1.08;
            letter-spacing:-0.02em;

            margin-bottom:28px;

            color:#fff;
        }

        .gallery-header p{
            max-width:760px;

            margin:0 auto;

            font-size:18.75px;
            line-height:1.8;
            font-weight:300;

            color:rgba(255,255,255,.88);
        }

        /* ───────────────── FILTER ───────────────── */
        .gallery-filter-wrap{
            position:relative;
            z-index:20;

            margin-top:-42px;

            padding:0 24px;
        }

        .gallery-filters{
            width:fit-content;

            margin:0 auto;

            background:#fff;

            padding:14px;

            border-radius:999px;

            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;

            flex-wrap:wrap;

            box-shadow:
                0 10px 40px rgba(0,0,0,.10);
        }

        .filter-btn{
            border:none;

            background:transparent;

            color:#666;

            font-size:14px;
            font-weight:500;
            letter-spacing:.08em;

            padding:12px 22px;

            border-radius:999px;

            cursor:pointer;

            transition:all .25s ease;
        }

        .filter-btn:hover{
            background:#f3f3ef;
            color:#111;
        }

        .filter-btn.active{
            background:var(--green-dark);
            color:#fff;
        }

        /* ───────────────── INTRO TEXT ───────────────── */
        .gallery-intro{
            text-align:center;
            padding:110px 24px 60px;
        }

        .gallery-intro-label{
            color:var(--terracotta);

            font-size:18.75px;
            font-weight:500;
            letter-spacing:.18em;
            text-transform:uppercase;

            margin-bottom:20px;
        }

        .gallery-intro-title{
            font-family:'Cormorant Garamond',serif;

            font-size:48px;
            line-height:1.15;
            font-weight:300;

            color:var(--green-dark);

            margin-bottom:26px;
        }

        .gallery-intro-desc{
            max-width:760px;

            margin:0 auto;

            color:var(--green-dark);

            font-size:18.75px;
            line-height:1.9;
            font-weight:300;
        }

        /* ───────────────── GALLERY ───────────────── */
        .gallery-section{
            padding:20px 18px 100px;
            max-width:1150px;
            margin:0 auto;
        }

        .gallery-grid{
            columns:2;
            column-gap:12px;
        }

        .gi{
            break-inside:avoid;
            margin-bottom:12px;

            position:relative;
            overflow:hidden;

            cursor:pointer;

            border-radius:4px;

            background:#d8dfd0;
        }

        .gi img{
            width:100%;
            display:block;

            transition:transform .65s cubic-bezier(.25,.46,.45,.94);
        }

        .gi:hover img{
            transform:scale(1.04);
        }

        .gi::after{
            content:'';
            position:absolute;
            inset:0;

            background:
                linear-gradient(
                    to top,
                    rgba(10,22,8,.55) 0%,
                    transparent 55%
                );

            opacity:0;

            transition:opacity .3s;
        }

        .gi:hover::after{
            opacity:1;
        }

        .gi-label{
            position:absolute;
            bottom:18px;
            left:18px;

            z-index:2;

            font-size:12px;
            letter-spacing:.12em;
            text-transform:uppercase;

            color:rgba(255,255,255,.94);

            opacity:0;

            transition:opacity .3s;
        }

        .gi:hover .gi-label{
            opacity:1;
        }

        .gi.hidden{
            display:none;
        }

        /* ───────────────── STORY ───────────────── */
        .our-story{
            background:var(--white-soft);

            padding:110px 24px 120px;

            text-align:center;
        }

        .story-eyebrow{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;

            margin-bottom:22px;
        }

        .story-eyebrow img{
            width:18px;
            height:18px;
            object-fit:contain;
        }

        .story-eyebrow span{
            font-size:18.75px;
            font-weight:500;
            color:var(--green-mid);
            letter-spacing:.14em;
            text-transform:uppercase;
        }

        .our-story h2{
            font-family:'Cormorant Garamond',serif;

            font-weight:300;
            font-size:48px;
            line-height:1.15;

            margin-bottom:42px;

            color:var(--green-dark);
        }

        .story-body{
            max-width:760px;
            margin:0 auto;
        }

        .story-body p{
            font-size:18.75px;
            line-height:1.9;
            font-weight:300;

            color:var(--green-dark);

            margin-bottom:24px;
        }

        .signature-wrap{
            display:flex;
            flex-direction:column;
            gap:8px;

            align-items:center;

            margin-top:30px;
        }

        .signature-name{
            font-family:'Cormorant Garamond',serif;
            font-style:italic;
            font-size:30px;
            color:var(--green-dark);
        }

        .signature-title{
            font-size:18.75px;
            font-weight:500;

            letter-spacing:.12em;
            text-transform:uppercase;

            color:var(--terracotta);
        }

        /* ───────────────── REVEAL ───────────────── */
        .reveal{
            opacity:0;
            transform:translateY(24px);

            transition:
                opacity .7s ease,
                transform .7s ease;
        }

        .reveal.visible{
            opacity:1;
            transform:translateY(0);
        }

        /* ───────────────── MOBILE ───────────────── */
        @media (max-width:768px){

            .gallery-header{
                min-height:580px;
                padding:120px 20px 100px;
            }

            .gallery-header h1{
                font-size:52px;
            }

            .gallery-header p{
                font-size:16px;
            }

            .gallery-filter-wrap{
                margin-top:-34px;
            }

            .gallery-filters{
                width:100%;
                border-radius:28px;
            }

            .filter-btn{
                flex:1 1 auto;
                font-size:12px;
                padding:10px 14px;
            }

            .gallery-intro{
                padding:90px 20px 50px;
            }

            .gallery-intro-title{
                font-size:38px;
            }

            .gallery-intro-desc{
                font-size:16px;
            }

            .gallery-grid{
                columns:1;
            }

            .our-story{
                padding:90px 20px;
            }

            .our-story h2{
                font-size:38px;
            }

            .story-body p{
                font-size:16px;
            }

            .signature-title{
                font-size:15px;
            }
        }
    </style>
</head>

<body>

@include('components.navbar')

<main>

    {{-- HERO --}}
    <header class="gallery-header">

        <div class="hero-content">

            <h1>
                A Javanese Sanctuary,<br>
                Woven by Nature
            </h1>

            <p>
                Explore the textures, scents, and rhythms
                of our sanctuary through a curated lens
                of tropical elegance and Javanese heritage.
            </p>

        </div>

    </header>

    {{-- FILTER --}}
    <section class="gallery-filter-wrap">

        <div class="gallery-filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="spaces">Spaces</button>
            <button class="filter-btn" data-filter="nature">Nature</button>
            <button class="filter-btn" data-filter="dining">Dining</button>
            <button class="filter-btn" data-filter="wellness">Wellness</button>
            <button class="filter-btn" data-filter="people">People</button>
        </div>

    </section>

    {{-- INTRO --}}
    <section class="gallery-intro">

        <p class="gallery-intro-label reveal">
            VISUAL SANCTUARY
        </p>

        <h2 class="gallery-intro-title reveal">
            Moments of Zen, Woven in Nature.
        </h2>

        <p class="gallery-intro-desc reveal">
            Explore the textures, scents, and rhythms of our sanctuary through a
            curated lens of tropical elegance and Javanese heritage.
        </p>

    </section>

    {{-- GALLERY --}}
    <section class="gallery-section">

        <div class="gallery-grid" id="galleryGrid">

            {{-- KOLOM KIRI --}}
            <div class="gi reveal" data-category="spaces">
                <img src="{{ asset('images/gallery/pavilium.png') }}" alt="">
                <span class="gi-label">The Pavilion</span>
            </div>

            <div class="gi reveal" data-category="nature">
                <img src="{{ asset('images/gallery/flower.png') }}" alt="">
                <span class="gi-label">White Orchid</span>
            </div>

            <div class="gi reveal" data-category="nature">
                <img src="{{ asset('images/gallery/tree.png') }}" alt="">
                <span class="gi-label">Ancient Tree</span>
            </div>

            <div class="gi reveal" data-category="spaces">
                <img src="{{ asset('images/gallery/room.png') }}" alt="">
                <span class="gi-label">Room</span>
            </div>

            <div class="gi reveal" data-category="people">
                <img src="{{ asset('images/gallery/talking-people.png') }}" alt="">
                <span class="gi-label">Outdoor Gathering</span>
            </div>

            <div class="gi reveal" data-category="people">
                <img src="{{ asset('images/gallery/gardening.png') }}" alt="">
                <span class="gi-label">Garden Together</span>
            </div>

            <div class="gi reveal" data-category="dining">
                <img src="{{ asset('images/gallery/eating.png') }}" alt="">
                <span class="gi-label">Eat Tradisional Food</span>
            </div>

            <div class="gi reveal" data-category="people">
                <img src="{{ asset('images\gallery\Learing-culture.jpg') }}" alt="">
                <span class="gi-label">Outdoor Gathering</span>
            </div>
            

            {{-- KOLOM KANAN --}}
            <div class="gi reveal" data-category="wellness">
                <img src="{{ asset('images/gallery/meditasi.png') }}" alt="">
                <span class="gi-label">Morning Meditation</span>
            </div>

            <div class="gi reveal" data-category="dining">
                <img src="{{ asset('images/gallery/javanese-spices.png') }}" alt="">
                <span class="gi-label">Javanese Spices</span>
            </div>

            <div class="gi reveal" data-category="nature">
                <img src="{{ asset('images/gallery/forest-pathway.png') }}" alt="">
                <span class="gi-label">Forest Pathway</span>
            </div>

            <div class="gi reveal" data-category="wellness">
                <img src="{{ asset('images/gallery/pijat.png') }}" alt="">
                <span class="gi-label">SPA</span>
            </div>

            <div class="gi reveal" data-category="dining">
                <img src="{{ asset('images/gallery/tradisional-food.png') }}" alt="">
                <span class="gi-label">Tradisional Food</span>
            </div>

            <div class="gi reveal" data-category="people">
                <img src="{{ asset('images/gallery/drinking.png') }}" alt="">
                <span class="gi-label">Morning Drinks</span>
            </div>

        </div>

    </section>

</main>

{{-- STORY --}}
<section class="our-story">

    <div class="story-eyebrow reveal">
        <img src="{{ asset('images/gallery/Icon.png') }}" alt="">
    </div>

    <h2 class="reveal">
        Our Story, Hand-Crafted.
    </h2>

    <div class="story-body">

        <p class="reveal">
            At AlasAre, we don't just build; we restore.
            This sanctuary stands as a living witness
            to our vision: to reunite the human spirit
            with the natural rhythms of the earth.
        </p>

        <p class="reveal">
            Every guest is part of an intimate circle—
            just 24 souls sharing the stillness and
            rediscovering wellness through the forgotten
            riches of Javanese flora.
        </p>

        <div class="signature-wrap reveal">
            <span class="signature-name">In Serenity,</span>

            <span class="signature-title">
                The AlaSare Guardians
            </span>
        </div>

    </div>

</section>

@include('components.footer')

<script>
    /* FILTER */
    const filterBtns = document.querySelectorAll('.filter-btn');

    filterBtns.forEach(btn => {

        btn.addEventListener('click', () => {

            filterBtns.forEach(b =>
                b.classList.remove('active')
            );

            btn.classList.add('active');

            const cat = btn.dataset.filter;

            document.querySelectorAll('.gi').forEach(item => {

                const match =
                    cat === 'all' ||
                    item.dataset.category === cat;

                item.classList.toggle('hidden', !match);

            });

        });

    });

    /* REVEAL */
    const reveals = document.querySelectorAll('.reveal');

    const io = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if(entry.isIntersecting){

                entry.target.classList.add('visible');
                io.unobserve(entry.target);

            }

        });

    },{
        threshold:0.06
    });

    reveals.forEach((el,i) => {

        el.style.transitionDelay =
            (i % 3) * 80 + 'ms';

        io.observe(el);

    });
</script>

</body>
</html>