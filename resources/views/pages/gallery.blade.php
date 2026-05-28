<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gallery — AlaSare</title>
 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
 
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
        Foto dari DB dibagi dua kolom berdasarkan column_placement (left / right).
        4 item pertama tiap kolom langsung tampil, sisanya jadi extra-item (View More).
        Urutan ditentukan oleh order_number ASC (diatur di admin gallery settings).
    --}}
    <section class="gallery-section">
 
        <div class="gallery-grid" id="galleryGrid">
 
            {{-- ── KOLOM KIRI ── --}}
            <div class="gallery-col" id="colLeft">
                @forelse ($leftPhotos as $photo)
                    <div class="gi reveal {{ $loop->index >= 4 ? 'extra-item' : '' }}"
                         data-category="{{ $photo->category }}"
                         data-label="{{ $photo->title }}">
                        <img src="{{ asset('storage/' . $photo->image_path) }}"
                             alt="{{ $photo->alt_text ?? $photo->title }}"
                             loading="lazy">
                        <span class="gi-label">{{ $photo->title }}</span>
                    </div>
                @empty
                    {{-- Kolom kiri kosong: tidak tampilkan apa-apa --}}
                @endforelse
            </div>{{-- /colLeft --}}
 
            {{-- ── KOLOM KANAN ── --}}
            <div class="gallery-col" id="colRight">
                @forelse ($rightPhotos as $photo)
                    <div class="gi reveal {{ $loop->index >= 4 ? 'extra-item' : '' }}"
                         data-category="{{ $photo->category }}"
                         data-label="{{ $photo->title }}">
                        <img src="{{ asset('storage/' . $photo->image_path) }}"
                             alt="{{ $photo->alt_text ?? $photo->title }}"
                             loading="lazy">
                        <span class="gi-label">{{ $photo->title }}</span>
                    </div>
                @empty
                    {{-- Kolom kanan kosong --}}
                @endforelse
            </div>{{-- /colRight --}}
 
        </div>{{-- /galleryGrid --}}
 
        {{-- VIEW MORE: hanya tampil kalau ada extra-item --}}
        @php
            $hasExtra = ($leftPhotos->count() > 4) || ($rightPhotos->count() > 4);
        @endphp
 
        @if($hasExtra)
        <div class="view-more-wrap">
            <button class="view-more-btn" id="viewMoreBtn">
                <span>View More</span>
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 1v12M1 7l6 6 6-6"
                          stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        @endif
 
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
            if (item.classList.contains('extra-hidden')) return;
            const match = cat === 'all' || item.dataset.category === cat;
            item.classList.toggle('hidden', !match);
        });
    });
});
 
 
/* ══════════════════════════════════════════════════
   2. VIEW MORE
══════════════════════════════════════════════════ */
const extraItems  = document.querySelectorAll('.gi.extra-item');
const viewMoreBtn = document.getElementById('viewMoreBtn');
 
extraItems.forEach(el => el.classList.add('extra-hidden'));
 
if (viewMoreBtn) {
    viewMoreBtn.addEventListener('click', () => {
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
 
        extraItems.forEach(el => {
            el.classList.remove('extra-hidden');
 
            if (activeFilter !== 'all' && el.dataset.category !== activeFilter) {
                el.classList.add('hidden');
            } else {
                el.classList.remove('hidden');
            }
 
            requestAnimationFrame(() => io.observe(el));
        });
 
        viewMoreBtn.classList.add('all-loaded');
    });
}
 
 
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
        .filter(el => !el.classList.contains('hidden') &&
                      !el.classList.contains('extra-hidden'));
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
lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
 
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