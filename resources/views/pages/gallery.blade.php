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

    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
</head>

<body>

@include('components.navbar')

<main>

    {{-- ═══════ HERO ═══════ --}}
    
    <header class="gallery-header"
            style="--hero-bg: url('{{ asset('images/gallery/hero-gallery.png') }}')">
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

    {{-- ═══════ FILTER ═══════ --}}
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

    {{-- ═══════ INTRO ═══════ --}}
    <section class="gallery-intro">
        <p class="gallery-intro-label reveal">VISUAL SANCTUARY</p>

        <h2 class="gallery-intro-title reveal">
            Moments of Zen, Woven in Nature.
        </h2>

        <p class="gallery-intro-desc reveal">
            Explore the textures, scents, and rhythms of our sanctuary through a
            curated lens of tropical elegance and Javanese heritage.
        </p>
    </section>

    {{-- ═══════ GALLERY ═══════ --}}
    {{--
        STRUKTUR: 2 kolom eksplisit (.col-left & .col-right)
        supaya urutan atas-bawah bisa dikontrol manual.
        CSS columns dihindari karena urutan item tidak bisa diprediksi
        saat sebagian item disembunyikan (View More).

        PANDUAN TAMBAH GAMBAR:
        - Tambah .gi baru ke kolom yang diinginkan
        - data-category: "spaces" | "nature" | "dining" | "wellness" | "people"
        - data-label   : teks hover & caption lightbox
        - Tambahkan class "extra-item" kalau ingin tersembunyi di awal

        KOLOM KIRI  (tampil awal): pavilium, flower, tree, room, talking-people, gardening-together, eat-at-backyard
        KOLOM KANAN (tampil awal): meditasi, javanese-spices, forest-pathway, pijat, tradisional-food, drinking, blankon
        — masing-masing 4 item awal, 3 extra
    --}}
    <section class="gallery-section">

        <div class="gallery-grid" id="galleryGrid">

            {{-- ── KOLOM KIRI ── --}}
            <div class="gallery-col" id="colLeft">

                {{-- L1 --}}
                <div class="gi reveal" data-category="spaces" data-label="The Pavilion">
                    <img src="{{ asset('images/gallery/pavilium.png') }}" alt="The Pavilion" loading="lazy">
                    <span class="gi-label">The Pavilion</span>
                </div>

                {{-- L2 --}}
                <div class="gi reveal" data-category="nature" data-label="White Orchid">
                    <img src="{{ asset('images/gallery/flower.png') }}" alt="White Orchid" loading="lazy">
                    <span class="gi-label">White Orchid</span>
                </div>

                {{-- L3 --}}
                <div class="gi reveal" data-category="nature" data-label="Ancient Tree">
                    <img src="{{ asset('images/gallery/tree.png') }}" alt="Ancient Tree" loading="lazy">
                    <span class="gi-label">Ancient Tree</span>
                </div>

                {{-- L4 --}}
                <div class="gi reveal" data-category="spaces" data-label="Room">
                    <img src="{{ asset('images/gallery/room.png') }}" alt="Room" loading="lazy">
                    <span class="gi-label">Room</span>
                </div>

                {{-- L5 — extra --}}
                <div class="gi reveal extra-item" data-category="people" data-label="Outdoor Gathering">
                    <img src="{{ asset('images/gallery/talking-people.png') }}" alt="Outdoor Gathering" loading="lazy">
                    <span class="gi-label">Outdoor Gathering</span>
                </div>

                {{-- L6 — extra --}}
                <div class="gi reveal extra-item" data-category="people" data-label="Garden Together">
                    <img src="{{ asset('images/gallery/gardening-together.png') }}" alt="Garden Together" loading="lazy">
                    <span class="gi-label">Garden Together</span>
                </div>

                {{-- L7 — extra --}}
                <div class="gi reveal extra-item" data-category="dining" data-label="Eat Traditional Food">
                    <img src="{{ asset('images/gallery/eat-at-backyard.png') }}" alt="Eat Traditional Food" loading="lazy">
                    <span class="gi-label">Eat Traditional Food</span>
                </div>
                {{-- L8 — extra --}}
                <div class="gi reveal extra-item" data-category="people" data-label="Blankon">
                    <img src="{{ asset('images/gallery/blankon-hd.png') }}" alt="Blankon" loading="lazy">
                    <span class="gi-label">Gathering</span>
                </div>

            </div>{{-- /col-left --}}

            {{-- ── KOLOM KANAN ── --}}
            <div class="gallery-col" id="colRight">

                {{-- R1 --}}
                <div class="gi reveal" data-category="wellness" data-label="Morning Meditation">
                    <img src="{{ asset('images/gallery/meditasi.png') }}" alt="Morning Meditation" loading="lazy">
                    <span class="gi-label">Morning Meditation</span>
                </div>

                {{-- R2 --}}
                <div class="gi reveal" data-category="dining" data-label="Javanese Spices">
                    <img src="{{ asset('images/gallery/javanese-spices.png') }}" alt="Javanese Spices" loading="lazy">
                    <span class="gi-label">Javanese Spices</span>
                </div>

                {{-- R3 --}}
                <div class="gi reveal" data-category="nature" data-label="Forest Pathway">
                    <img src="{{ asset('images/gallery/forest-pathway.png') }}" alt="Forest Pathway" loading="lazy">
                    <span class="gi-label">Forest Pathway</span>
                </div>

                {{-- R4 --}}
                <div class="gi reveal extra-item" data-category="wellness" data-label="SPA">
                    <img src="{{ asset('images/gallery/pijat.png') }}" alt="SPA" loading="lazy">
                    <span class="gi-label">SPA</span>
                </div>

                {{-- R5 — extra --}}
                <div class="gi reveal extra-item" data-category="dining" data-label="Traditional Food">
                    <img src="{{ asset('images/gallery/tradisional-food.png') }}" alt="Traditional Food" loading="lazy">
                    <span class="gi-label">Traditional Food</span>
                </div>

                {{-- R6 — extra --}}
                <div class="gi reveal extra-item" data-category="people" data-label="Morning Drinks">
                    <img src="{{ asset('images/gallery/drinking.png') }}" alt="Morning Drinks" loading="lazy">
                    <span class="gi-label">Morning Drinks</span>
                </div>


                

            </div>{{-- /col-right --}}

        </div>{{-- /gallery-grid --}}

        {{-- VIEW MORE --}}
        <div class="view-more-wrap">
            <button class="view-more-btn" id="viewMoreBtn">
                <span>View More</span>
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 1v12M1 7l6 6 6-6"
                          stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

    </section>

</main>

@include('home.sections.map')

{{-- ═══════ OUR STORY ═══════ --}}
<section class="our-story">

    <div class="story-eyebrow reveal">
        <img src="{{ asset('images/gallery/Icon.png') }}" alt="">
    </div>

    <h2 class="reveal">Our Story, Hand-Crafted.</h2>

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
            <span class="signature-title">The AlaSare Guardians</span>
        </div>
    </div>

</section>

@include('components.footer')


{{-- ═══════ LIGHTBOX ═══════ --}}
<div class="lightbox-overlay" id="lightbox" role="dialog" aria-modal="true">
    <div class="lightbox-inner">
        <button class="lightbox-close" id="lbClose" aria-label="Tutup">&times;</button>
        <button class="lightbox-arrow prev" id="lbPrev" aria-label="Sebelumnya">&#8592;</button>
        <img class="lightbox-img" id="lbImg" src="" alt="">
        <p class="lightbox-caption" id="lbCaption"></p>
        <button class="lightbox-arrow next" id="lbNext" aria-label="Berikutnya">&#8594;</button>
    </div>
</div>


<script>
/* ══════════════════════════════════════════════════
   1. FILTER
══════════════════════════════════════════════════ */
const filterBtns = document.querySelectorAll('.filter-btn');

filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const cat = btn.dataset.filter;

        document.querySelectorAll('.gi').forEach(item => {
            // Skip extra-item yang masih belum di-reveal
            if (item.classList.contains('extra-hidden')) return;

            const match = cat === 'all' || item.dataset.category === cat;
            item.classList.toggle('hidden', !match);
        });
    });
});


/* ══════════════════════════════════════════════════
   2. VIEW MORE
   — extra-item tersembunyi dengan class .extra-hidden
     (bukan display:none) supaya tetap di kolom asalnya
══════════════════════════════════════════════════ */
const extraItems  = document.querySelectorAll('.gi.extra-item');
const viewMoreBtn = document.getElementById('viewMoreBtn');

// Sembunyikan semua extra-item saat load
extraItems.forEach(el => el.classList.add('extra-hidden'));

viewMoreBtn.addEventListener('click', () => {
    const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

    extraItems.forEach(el => {
        el.classList.remove('extra-hidden');  // tampilkan di kolom asalnya

        // Terapkan filter aktif
        if (activeFilter !== 'all' && el.dataset.category !== activeFilter) {
            el.classList.add('hidden');
        } else {
            el.classList.remove('hidden');
        }

        // Trigger reveal animation
        requestAnimationFrame(() => {
            io.observe(el);
        });
    });

    viewMoreBtn.classList.add('all-loaded');
});


/* ══════════════════════════════════════════════════
   3. LIGHTBOX
══════════════════════════════════════════════════ */
const lightbox  = document.getElementById('lightbox');
const lbImg     = document.getElementById('lbImg');
const lbCaption = document.getElementById('lbCaption');
const lbClose   = document.getElementById('lbClose');
const lbPrev    = document.getElementById('lbPrev');
const lbNext    = document.getElementById('lbNext');

let currentIdx = 0;

function getVisibleItems() {
    return [...document.querySelectorAll('.gi')]
        .filter(el => !el.classList.contains('hidden') && el.style.display !== 'none');
}

function openLightbox(idx) {
    const items = getVisibleItems();
    if (!items[idx]) return;

    currentIdx = idx;
    const img   = items[idx].querySelector('img');
    const label = items[idx].dataset.label || '';

    lbImg.src             = img.src;
    lbImg.alt             = label;
    lbCaption.textContent = label;

    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
}

function navigate(dir) {
    const items = getVisibleItems();
    currentIdx  = (currentIdx + dir + items.length) % items.length;
    openLightbox(currentIdx);
}

document.getElementById('galleryGrid').addEventListener('click', e => {
    const card = e.target.closest('.gi');
    if (!card) return;
    const items = getVisibleItems();
    const idx   = items.indexOf(card);
    if (idx !== -1) openLightbox(idx);
});

lbClose.addEventListener('click', closeLightbox);
lbPrev.addEventListener('click',  () => navigate(-1));
lbNext.addEventListener('click',  () => navigate(1));

lightbox.addEventListener('click', e => {
    if (e.target === lightbox) closeLightbox();
});

document.addEventListener('keydown', e => {
    if (!lightbox.classList.contains('open')) return;
    if (e.key === 'Escape')     closeLightbox();
    if (e.key === 'ArrowLeft')  navigate(-1);
    if (e.key === 'ArrowRight') navigate(1);
});


/* ══════════════════════════════════════════════════
   4. SCROLL REVEAL
══════════════════════════════════════════════════ */
const reveals = document.querySelectorAll('.reveal');

const io = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            io.unobserve(entry.target);
        }
    });
}, { threshold: 0.06 });

reveals.forEach((el, i) => {
    el.style.transitionDelay = (i % 3) * 80 + 'ms';
    io.observe(el);
});
</script>

</body>
</html>