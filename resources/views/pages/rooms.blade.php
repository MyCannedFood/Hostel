<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rooms - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: var(--color-bg-light); color: #111;">

@include('components.navbar')

<main>
<section id="home-sanctuaries" class="sanctuaries-section">

    <style>
        .filter-btn{display:flex;align-items:center;gap:8px;border:1.5px solid #2d4a3e;background:transparent;color:#2d4a3e;font-weight:500;font-size:15px;cursor:pointer;padding:10px 22px;border-radius:999px;}
        .filter-btn:focus{outline:none;}
        .filter-dropdown{position:absolute;top:calc(100% + 8px);right:0;background:#fff;border:1px solid #ddd;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,0.10);z-index:99;min-width:180px;overflow:hidden;}
        .filter-dropdown button{display:block;width:100%;text-align:left;background:none;border:none;padding:12px 20px;font-size:14px;cursor:pointer;color:#2d4a3e;}
        .filter-dropdown button:hover{background:#f5f0eb;}
        .filter-dropdown button.active{font-weight:600;color:#D9864A;}
        .filter-wrapper{position:relative;display:inline-block;}
    </style>

    <!-- Intro Banner -->
    <div class="sanctuaries-intro">
        <div class="sanctuaries-intro-content">
            <div class="sanctuaries-logo">
                <img src="{{ asset('images/logo_only.png') }}" alt="AlaSare Logo" style="object-fit: contain;">
            </div>
            <div class="sanctuaries-intro-text">
                <h2 data-en="Our Rooms" data-id="Kamar Kami">Our Rooms</h2>
                <p data-en="Embrace the warmth of Nusantara in our nature-inspired shared rooms. Limited to just 24 guests, we offer an intimate tropical escape to rest, recharge, and connect with fellow travelers."
                   data-id="Rasakan kehangatan Nusantara di kamar bersama kami yang terinspirasi alam. Terbatas hanya 24 tamu, kami menawarkan pelarian tropis yang intim untuk beristirahat, mengisi energi, dan terhubung bersama sesama pelancong.">
                    Embrace the warmth of Nusantara in our nature-inspired shared rooms. Limited to just 24 guests, we offer an intimate tropical escape to rest, recharge, and connect with fellow travelers.
                </p>
            </div>
        </div>
        <div class="sanctuaries-stats">
            <div class="stat-item">
                <h3>{{ $totalCapacity ?? 24 }}</h3>
                <p data-en="Capacity" data-id="Kapasitas">Capacity</p>
            </div>
            <div class="stat-item">
                <h3>{{ $roomTypeLabel ?? 'Shared' }}</h3>
                <p data-en="Social Spaces" data-id="Ruang Sosial">Social Spaces</p>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="sanctuaries-header">
        <div class="sanctuaries-header-title">
            <h3 data-en="Available Rooms" data-id="Kamar Tersedia">Available Rooms</h3>
            <p data-en="Find your peaceful corner among the ferns and teakwood."
               data-id="Temukan sudut tenangmu di antara pakis dan kayu jati.">
                Find your peaceful corner among the ferns and teakwood.
            </p>
        </div>

        <div class="filter-wrapper">
            <button class="filter-btn" id="filterToggle" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                    <line x1="11" y1="18" x2="13" y2="18"/>
                </svg>
                <span data-en="Filter" data-id="Filter">Filter</span>
            </button>
            <div class="filter-dropdown" id="filterDropdown" style="display:none;">
                <button data-filter="all"    data-en="All"              data-id="Semua"                class="active" type="button">All</button>
                <button data-filter="female" data-en="Female Only Dorm" data-id="Asrama Khusus Wanita" type="button">Female Only Dorm</button>
                <button data-filter="male"   data-en="Male Only Dorm"   data-id="Asrama Khusus Pria"   type="button">Male Only Dorm</button>
            </div>
        </div>
    </div>

    <!-- Grid -->
    <div class="rooms-grid">
        @forelse($rooms as $room)
            <div class="room-card" data-gender="{{ strtolower($room['gender_type']) }}">
                <div class="room-image">
                    @if($room['photo'])
                        <img src="{{ $room['photo'] }}" alt="{{ $room['name'] }}">
                    @else
                        <img src="{{ asset('images/rooms/room_1.png') }}" alt="{{ $room['name'] }}">
                    @endif
                    <div class="room-tags">
                        <span class="room-tag {{ $room['gender_type'] === 'Male' ? 'tag-male' : ($room['gender_type'] === 'Female' ? 'tag-female' : 'tag-mixed') }}"
                              data-en="{{ $room['gender_label'] }}"
                              data-id="{{ $room['gender_label_id'] }}">
                            {{ $room['gender_label'] }}
                        </span>
                        @if(!empty($room['attributes']))
                            @foreach($room['attributes'] as $i => $attr)
                                <span class="room-tag tag-info"
                                      data-en="{{ trim($attr) }}"
                                      data-id="{{ trim($room['attributes_id'][$i] ?? $attr) }}">
                                    {{ trim($attr) }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="room-content">
                    <div class="room-title-price">
                        <h4>{{ $room['name'] }}</h4>
                        <div class="room-price">
                            <span class="room-price-val">Rp 125k</span>
                            <span class="room-price-unit" data-en="/ bed / night" data-id="/ kasur / malam">/ bed / night</span>
                        </div>
                    </div>

                    <div class="room-features">
                        @if(!empty($room['attributes']))
                            @foreach($room['attributes'] as $i => $attr)
                                <div class="room-feature">
                                    <svg viewBox="0 0 24 24"><path d="M19 19V4h-4V3H5v16H3v2h18v-2h-2zm-6-6h-2v-2h2v2z"/></svg>
                                    <span data-en="{{ trim($attr) }}"
                                          data-id="{{ trim($room['attributes_id'][$i] ?? $attr) }}">
                                        {{ trim($attr) }}
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <p class="room-desc"
                       data-en="{{ $room['description'] ?: 'No description available.' }}"
                       data-id="{{ $room['description_id'] ?: 'Deskripsi belum tersedia.' }}">
                        {{ $room['description'] ?: 'No description available.' }}
                    </p>

                    <div class="room-availability">
                        <div class="room-availability-header {{ $room['is_sold_out'] ? 'low' : '' }}">
                            <span data-en="Availability" data-id="Ketersediaan">Availability</span>
                            <span data-en="{{ $room['available_beds'] }}/{{ $room['total_beds'] }} Beds Available"
                                  data-id="{{ $room['available_beds'] }}/{{ $room['total_beds'] }} Kasur Tersedia">
                                {{ $room['available_beds'] }}/{{ $room['total_beds'] }} Beds Available
                            </span>
                        </div>
                        <div class="availability-bar">
                            <div class="availability-fill {{ $room['is_sold_out'] ? 'low' : '' }}"
                                 style="width: {{ $room['availability_percentage'] }}%;"></div>
                        </div>
                    </div>

                    <div class="room-actions">
                        <div class="room-icons">
                            @if(!empty($room['main_facilities']))
                                @foreach($room['main_facilities'] as $i => $facility)
                                    @php
                                        $facilityName = strtolower(trim($facility));
                                        $iconFile = 'images/icon/walk-svgrepo-com.svg';
                                        if(str_contains($facilityName, 'wi-fi') || str_contains($facilityName, 'wifi')) {
                                            $iconFile = 'images/icon/wifi-svgrepo-com-1.svg';
                                        } elseif(str_contains($facilityName, 'ac') || str_contains($facilityName, 'air')) {
                                            $iconFile = 'images/icon/snow-svgrepo-com.svg';
                                        } elseif(str_contains($facilityName, 'locker') || str_contains($facilityName, 'lock')) {
                                            $iconFile = 'images/icon/lock-svgrepo-com.svg';
                                        } elseif(str_contains($facilityName, 'en-suite bath') || str_contains($facilityName, 'bath') || str_contains($facilityName, 'shower')) {
                                            $iconFile = 'images/icon/shower-svgrepo-com.svg';
                                        }
                                    @endphp
                                    {{-- Tidak pakai data-en/data-id, icon tidak perlu ditranslate --}}
                                    <button class="icon-btn" title="{{ trim($facility) }}">
                                        <img src="{{ asset($iconFile) }}" alt="{{ trim($facility) }}" class="icon-btn-img">
                                    </button>
                                @endforeach
                            @endif
                        </div>

                        @if($room['is_sold_out'])
                            <button class="btn-select"
                                    style="background:#B0B0B0;cursor:not-allowed;"
                                    data-en="Sold Out"
                                    data-id="Habis"
                                    disabled>Sold Out</button>
                        @else
                            <a class="btn-select"
                               href="{{ url('/calendar') }}"
                               data-en="Select Bed"
                               data-id="Pilih Kasur"
                               style="text-decoration:none; display:inline-block;">
                                Select Bed
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #7a857f;">
                <p data-en="No rooms available at the moment."
                   data-id="Tidak ada kamar yang tersedia saat ini.">
                    No rooms available at the moment.
                </p>
            </div>
        @endforelse
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle   = document.getElementById('filterToggle');
    const dropdown = document.getElementById('filterDropdown');
    const cards    = document.querySelectorAll('.room-card');

    // ── Filter ──────────────────────────────────────────────
    toggle.addEventListener('click', () => {
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    });

    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    dropdown.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
            dropdown.querySelectorAll('button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.getAttribute('data-filter');
            cards.forEach(card => {
                const gender = card.getAttribute('data-gender') || 'mixed';
                card.style.display = (filter === 'all' || filter === gender) ? '' : 'none';
            });
            dropdown.style.display = 'none';
        });
    });

    // ── Language switcher ────────────────────────────────────
    function applyLang(lang) {
        document.querySelectorAll('[data-en][data-id]').forEach(el => {
            el.textContent = lang === 'id' ? el.dataset.id : el.dataset.en;
        });
        localStorage.setItem('alas_lang', lang);
    }

    applyLang(localStorage.getItem('alas_lang') || 'en');

    window.addEventListener('alas:langchange', (e) => {
        applyLang(e.detail?.lang || 'en');
    });
});
</script>
</main>

@include('components.footer')

</body>
</html>