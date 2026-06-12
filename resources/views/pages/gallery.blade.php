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
 
    {{-- ═══════ DATA ═══════ --}}
    @php
        $gallerySettings = \App\Models\LandingPageSetting::getSection('gallery');
        $g = array_merge(
            \App\Models\LandingPageSetting::DEFAULTS['gallery'],
            $gallerySettings->data ?? []
        );
    @endphp

    {{-- ═══════ HERO ═══════ --}}
    <header class="gallery-header"
            style="--hero-bg: url('{{ asset('images/gallery/hero-gallery.png') }}')">
        <div class="hero-content">
            <h1>
                <span data-en="{{ $g['hero_title_line_1'] }}"
                      data-id="{{ $g['hero_title_line_1_id'] }}"
                >{{ $g['hero_title_line_1'] }}</span><br>
                <span data-en="{{ $g['hero_title_line_2'] }}"
                      data-id="{{ $g['hero_title_line_2_id'] }}"
                >{{ $g['hero_title_line_2'] }}</span>
            </h1>
            <p>
                <span data-en="{{ $g['hero_description'] }}"
                      data-id="{{ $g['hero_description_id'] }}"
                >{{ $g['hero_description'] }}</span>
            </p>
        </div>
    </header>

 
    {{-- ═══════ FILTER ═══════ --}}
    {{-- Label filter ditranslate via data-en / data-id, sama seperti elemen lain --}}
    <section class="gallery-filter-wrap">
        <div class="gallery-filters">
            <button class="filter-btn active" data-filter="all"
                    data-en="All" data-id="Semua">All</button>
            <button class="filter-btn" data-filter="spaces"
                    data-en="Spaces" data-id="Ruangan">Spaces</button>
            <button class="filter-btn" data-filter="nature"
                    data-en="Nature" data-id="Alam">Nature</button>
            <button class="filter-btn" data-filter="dining"
                    data-en="Dining" data-id="Makan">Dining</button>
            <button class="filter-btn" data-filter="wellness"
                    data-en="Wellness" data-id="Kesehatan">Wellness</button>
            <button class="filter-btn" data-filter="people"
                    data-en="People" data-id="Orang">People</button>
        </div>
    </section>
 
    {{-- ═══════ INTRO ═══════ --}}
    <section class="gallery-intro">
        <p class="gallery-intro-label reveal"
           data-en="{{ $g['intro_label'] }}"
           data-id="{{ $g['intro_label_id'] }}"
        >{{ $g['intro_label'] }}</p>

        <h2 class="gallery-intro-title reveal"
            data-en="{{ $g['intro_title'] }}"
            data-id="{{ $g['intro_title_id'] }}"
        >{{ $g['intro_title'] }}</h2>

        <p class="gallery-intro-desc reveal"
           data-en="{{ $g['intro_description'] }}"
           data-id="{{ $g['intro_description_id'] }}"
        >{{ $g['intro_description'] }}</p>
    </section>

 
    {{-- ═══════ GALLERY GRID ═══════ --}}
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
                @endforelse
            </div>
 
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
                @endforelse
            </div>
 
        </div>
 
        {{-- VIEW MORE --}}
        @php $hasExtra = ($leftPhotos->count() > 4) || ($rightPhotos->count() > 4); @endphp
 
        @if($hasExtra)
        <div class="view-more-wrap">
            <button class="view-more-btn" id="viewMoreBtn"
                    data-en="View More" data-id="Lihat Lebih">
                <span data-en="View More" data-id="Lihat Lebih">View More</span>
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

    <h2 class="reveal"
        data-en="{{ $g['story_title'] }}"
        data-id="{{ $g['story_title_id'] }}"
    >{{ $g['story_title'] }}</h2>

    <div class="story-body">
        <p class="reveal"
           data-en="{{ $g['story_paragraph_1'] }}"
           data-id="{{ $g['story_paragraph_1_id'] }}"
        >{{ $g['story_paragraph_1'] }}</p>

        <p class="reveal"
           data-en="{{ $g['story_paragraph_2'] }}"
           data-id="{{ $g['story_paragraph_2_id'] }}"
        >{{ $g['story_paragraph_2'] }}</p>

        <div class="signature-wrap reveal">
            <span class="signature-name"
                  data-en="{{ $g['story_signature_line'] }}"
                  data-id="{{ $g['story_signature_line_id'] }}"
            >{{ $g['story_signature_line'] }}</span>

            <span class="signature-title"
                  data-en="{{ $g['story_signature_title'] }}"
                  data-id="{{ $g['story_signature_title_id'] }}"
            >{{ $g['story_signature_title'] }}</span>
        </div>
    </div>
</section>

 
@include('components.footer')
 
<x-whatsapp_floating />
 
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