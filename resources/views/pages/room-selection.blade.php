<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-en="Select Your Bed - AlaSare" data-id="Pilih Tempat Tidur - AlaSare">Select Your Bed - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="selection-page">
    
    <x-booking-stepper :currentStep="2" />

    {{-- BUNGKUS DENGAN ID AGAR BISA DIKONTROL VIA JS --}}
    <div id="bookingHeaderWp">
        <x-booking-header 
            title="Select Your Rooms" 
            subtitle="Each retreat space is uniquely designed for your comfort." 
        />
    </div>

    @php
        use Carbon\Carbon;
        
        // 1. Tangkap semua parameter dari URL
        $checkInParam = request()->query('check_in');
        $checkOutParam = request()->query('check_out');
        $nightsParam = request()->query('nights', 0);
        $guestsParam = request()->query('guests', '1a0c');
        $promoParam = request()->query('promo', '');
        $monthParam = request()->query('month', '');

        // 2. Format tanggal untuk ditampilkan
        $displayCheckIn = $checkInParam ? Carbon::parse($checkInParam)->format('d/m/Y') : '--/--/----';
        $displayCheckOut = $checkOutParam ? Carbon::parse($checkOutParam)->format('d/m/Y') : '--/--/----';
        
        // 3. Link untuk kembali ke kalender (membawa semua data)
        $backToCalendarUrl = url('/calendar') . '?' . http_build_query(request()->query());
    @endphp

    {{-- SUMMARY BAR INTERAKTIF --}}
    <div class="calendar-summary-bar">
        <div class="summary-inputs">
            {{-- Klik Check-in untuk kembali ke kalender --}}
            <a href="{!! $backToCalendarUrl !!}" class="summary-item calendar-link" style="text-decoration: none; color: inherit; cursor: pointer;" title="Change Dates">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span><span data-en="Check-in: " data-id="Check-in: ">Check-in: </span><strong>{{ $displayCheckIn }}</strong></span>
            </a>
            
            <div class="divider"></div>
            
            {{-- Klik Check-out untuk kembali ke kalender --}}
            <a href="{!! $backToCalendarUrl !!}" class="summary-item calendar-link" style="text-decoration: none; color: inherit; cursor: pointer;" title="Change Dates">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span><span data-en="Check-out: " data-id="Check-out: ">Check-out: </span><strong>{{ $displayCheckOut }}</strong></span>
            </a>
            
            <div class="divider"></div>
            
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                {{-- Dropdown Tamu Dinamis --}}
                <select id="guestSelect" style="border: none; outline: none; background: transparent; font-weight: 600; color: inherit; font-size: 14px; cursor: pointer; max-width: 200px;">
                    <option value="1a0c" data-en="1 Male Adult, 0 Children" data-id="1 Dewasa Pria, 0 Anak" {{ $guestsParam == '1a0c' ? 'selected' : '' }}>1 Male Adult, 0 Children</option>
                    <option value="1f0c" data-en="1 Female Adult, 0 Children" data-id="1 Dewasa Wanita, 0 Anak" {{ $guestsParam == '1f0c' ? 'selected' : '' }}>1 Female Adult, 0 Children</option>
                    <option value="2a1c" data-en="2 Male Adults, 1 Child" data-id="2 Dewasa Pria, 1 Anak" {{ $guestsParam == '2a1c' ? 'selected' : '' }}>2 Male Adults, 1 Child</option>
                    <option value="2f1c" data-en="2 Female Adults, 1 Child" data-id="2 Dewasa Wanita, 1 Anak" {{ $guestsParam == '2f1c' ? 'selected' : '' }}>2 Female Adults, 1 Child</option>
                    <option value="2a2c" data-en="2 Male Adults, 2 Children" data-id="2 Dewasa Pria, 2 Anak" {{ $guestsParam == '2a2c' ? 'selected' : '' }}>2 Male Adults, 2 Children</option>
                    <option value="2f2c" data-en="2 Female Adults, 2 Children" data-id="2 Dewasa Wanita, 2 Anak" {{ $guestsParam == '2f2c' ? 'selected' : '' }}>2 Female Adults, 2 Children</option>
                </select>
            </div>
        </div>
        
        <div class="promo-section">
            <div class="promo-input-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D37D4F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <input type="text" id="promoCode" placeholder="Apply Promo Code" data-en-placeholder="Apply Promo Code" data-id-placeholder="Gunakan Kode Promo" value="{{ $promoParam }}">
            </div>
            {{-- Tombol Apply Dinamis (Teks dihandle via JS) --}}
            <a href="#" id="btnApplyPromo" class="apply-btn" style="{{ $promoParam ? 'color: #D37D4F;' : '' }}">
                {{ $promoParam ? 'Applied' : 'Apply' }}
            </a>
        </div>
    </div>
    {{-- END SUMMARY BAR INTERAKTIF --}}

    {{-- Filter Tabs --}}
    <div class="calendar-controls" style="margin-bottom: 24px;">
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all" data-en="All Rooms" data-id="Semua Kamar">All Rooms</button>
            <button class="filter-tab" data-filter="female" data-en="Female Only Dorm" data-id="Asrama Khusus Wanita">Female Only Dorm</button>
            <button class="filter-tab" data-filter="male" data-en="Male Only Dorm" data-id="Asrama Khusus Pria">Male Only Dorm</button>
        </div>
        <div class="nights-indicator">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <span id="nightsText">{{ $nightsParam }} {{ $nightsParam > 1 ? 'Nights' : 'Night' }}</span>
        </div>
    </div>

    {{-- Room Selection Container --}}
    <div class="selection-container">
        
        @foreach($rooms as $room)
        {{-- KUNCI FILTER: Pasang data-gender dari database --}}
        <div class="room-selection-card" data-gender="{{ strtolower($room->gender_type) }}">
            <div class="room-sel-image">
                <img src="{{ $room->photo ? asset('storage/' . $room->photo) : asset('images/default-room.png') }}" alt="{{ $room->name }}"> 
                
                @php
                    $enTag = $room->gender_type == 'Mixed' ? 'Mixed Dorm' : $room->gender_type . ' Only';
                    $idTag = $room->gender_type == 'Mixed' ? 'Asrama Campuran' : ($room->gender_type == 'Female' ? 'Khusus Wanita' : 'Khusus Pria');
                @endphp
                <span class="room-sel-tag" 
                    @if($room->gender_type == 'Female') style="background: rgba(192, 124, 77, 0.8);" @endif
                    data-en="{{ $enTag }}" data-id="{{ $idTag }}">
                    {{ $enTag }}
                </span>
            </div>
            
            <div class="room-sel-content">
                <h2>{{ $room->name }}</h2>
                <p class="room-sel-desc">{{ $room->description }}</p>
                
                <div class="room-sel-features">
                    <div class="sel-feature">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span data-en="{{ $room->capacity }} Person Capacity" data-id="Kapasitas {{ $room->capacity }} Orang">{{ $room->capacity }} Person Capacity</span>
                    </div>
                    
                    @php
                        $facilities = $room->main_facilities ? explode(',', $room->main_facilities) : [];
                    @endphp
                    
                    @foreach($facilities as $facility)
                        <div class="sel-feature">
                            <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                            {{ trim($facility) }}
                        </div>
                    @endforeach
                </div>

                <div class="bed-availability-section">
                    <h4 data-en="Bed Availability" data-id="Ketersediaan Tempat Tidur">Bed Availability</h4>
                    <div class="bed-grid">
                        @if($room->beds->count() > 0)
                            @foreach($room->beds as $bed)
                                <span class="bed-badge {{ $bed->status == 'Available' ? 'available' : 'unavailable' }}">
                                    {{ $bed->name ?? 'Bed' }}
                                </span>
                            @endforeach
                        @else
                            <span style="font-size: 12px; color: #888;" data-en="No beds configured yet." data-id="Belum ada tempat tidur yang diatur.">No beds configured yet.</span>
                        @endif
                    </div>
                </div>

                {{-- Tombol select kosongan parameter URL-nya, Javascript yang akan mengisinya --}}
                <a class="btn-select-room" href="{{ url('/bed-shared-room/' . $room->id) }}" style="text-decoration: none; display: inline-block;" data-en="SELECT" data-id="PILIH">
                    SELECT
                </a>
            </div>
        </div>
        @endforeach

    </div>

    {{-- BUNGKUS DENGAN ID AGAR BISA DIKONTROL VIA JS --}}
    <div id="bookingBottomBarWp">
        <x-booking-bottom-bar 
            title="Select Your Room"
            label="EST.Total"
            value="IDR 0"
            backUrl="{!! $backToCalendarUrl !!}"
            backText="Back To Calendar"
            continueUrl="#"
            continueText="Continue To Bed"
        />
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const guestSelect = document.getElementById('guestSelect');
    const promoCode = document.getElementById('promoCode');
    const btnApplyPromo = document.getElementById('btnApplyPromo');
    const selectButtons = document.querySelectorAll('.btn-select-room');
    const nightsTextEl = document.getElementById('nightsText');
    
    // Tangkap kontainer komponen Blade
    const bookingHeaderWp = document.getElementById('bookingHeaderWp');
    const bookingBottomBarWp = document.getElementById('bookingBottomBarWp');
    
    // Tangkap semua link yang mengarah kembali ke kalender
    const calendarLinks = document.querySelectorAll('a[href*="/calendar"]'); 

    // Elemen untuk Filter Kamar
    const filterBtns = document.querySelectorAll('.filter-tab');
    const roomCards = document.querySelectorAll('.room-selection-card');

    // Data Bawaan dari Server (PHP)
    const checkIn = "{{ $checkInParam }}";
    const checkOut = "{{ $checkOutParam }}";
    const nights = parseInt("{{ $nightsParam }}") || 0;
    const month = "{{ $monthParam }}";
    
    // State Promo Saat Ini & Bahasa Saat Ini
    let appliedPromoCode = "{{ $promoParam }}";
    let currentLang = localStorage.getItem('alas_lang') || 'en';

    // FUNGSI: Mengupdate teks bahasa dinamis (Nights, Tombol, Placeholder, Komponen Blade)
    function updateDynamicLanguage() {
        // 1. Update jumlah malam
        if (nightsTextEl) {
            if (currentLang === 'id') {
                nightsTextEl.textContent = `${nights} Malam`;
            } else {
                nightsTextEl.textContent = `${nights} Night${nights > 1 ? 's' : ''}`;
            }
        }

        // 2. Update placeholder kode promo
        if (promoCode) {
            promoCode.placeholder = currentLang === 'id' ? promoCode.getAttribute('data-id-placeholder') : promoCode.getAttribute('data-en-placeholder');
        }

        // 3. Update teks tombol promo
        if (btnApplyPromo) {
            if (appliedPromoCode !== '') {
                btnApplyPromo.textContent = currentLang === 'id' ? 'Diterapkan' : 'Applied';
            } else {
                btnApplyPromo.textContent = currentLang === 'id' ? 'Terapkan' : 'Apply';
            }
        }

        // 4. Update atribut title pada tautan summary bar
        calendarLinks.forEach(link => {
            link.title = currentLang === 'id' ? 'Ubah Tanggal' : 'Change Dates';
        });

        // 5. TRANSLASI KOMPONEN BLADE: x-booking-header
        if (bookingHeaderWp) {
            const hTitle = bookingHeaderWp.querySelector('h1, h2, .title');
            const hSubtitle = bookingHeaderWp.querySelector('p, .subtitle');
            
            if (currentLang === 'id') {
                if (hTitle) hTitle.textContent = 'Pilih Kamar Anda';
                if (hSubtitle) hSubtitle.textContent = 'Setiap ruang peristirahatan dirancang unik untuk kenyamanan Anda.';
            } else {
                if (hTitle) hTitle.textContent = 'Select Your Rooms';
                if (hSubtitle) hSubtitle.textContent = 'Each retreat space is uniquely designed for your comfort.';
            }
        }

        // 6. TRANSLASI KOMPONEN BLADE: x-booking-bottom-bar (Menyesuaikan dengan class default bar Anda)
        if (bookingBottomBarWp) {
            const bTitle = bookingBottomBarWp.querySelector('.title, h3, h4');
            const bLabel = bookingBottomBarWp.querySelector('.label, span:not(.value)');
            const bBackBtn = bookingBottomBarWp.querySelector('a[href*="/calendar"], .btn-back');
            const bContinueBtn = bookingBottomBarWp.querySelector('a:not([href*="/calendar"]), .btn-continue');

            if (currentLang === 'id') {
                if (bTitle) bTitle.textContent = 'Pilih Kamar Anda';
                if (bLabel) bLabel.textContent = 'Estimasi Total';
                if (bBackBtn) bBackBtn.textContent = 'Kembali Ke Kalender';
                if (bContinueBtn) bContinueBtn.textContent = 'Lanjut Ke Kasur';
            } else {
                if (bTitle) bTitle.textContent = 'Select Your Room';
                if (bLabel) bLabel.textContent = 'EST.Total';
                if (bBackBtn) bBackBtn.textContent = 'Back To Calendar';
                if (bContinueBtn) bContinueBtn.textContent = 'Continue To Bed';
            }
        }
    }

    // Dengarkan event perubahan bahasa dari navbar
    document.addEventListener('alas:langchange', function(e) {
        currentLang = e.detail.lang;
        updateDynamicLanguage();
    });

    // Jalankan update bahasa di awal
    updateDynamicLanguage();

    // FUNGSI: Merakit ulang & menyuntikkan URL baru ke semua tombol
    function syncLinks() {
        const currentGuestVal = guestSelect ? guestSelect.value : '1a0c';
        const currentPromoVal = appliedPromoCode;
        
        // Rakit parameter query baru
        const queryParams = `?check_in=${checkIn}&check_out=${checkOut}&nights=${nights}&guests=${currentGuestVal}&promo=${currentPromoVal}&month=${month}`;

        // Update semua tombol SELECT Kamar
        selectButtons.forEach(btn => {
            const baseUrl = btn.getAttribute('href').split('?')[0]; 
            btn.setAttribute('href', baseUrl + queryParams);
        });

        // Update tombol Check-in, Check-out, dan Back To Calendar
        calendarLinks.forEach(link => {
            const baseUrl = link.getAttribute('href').split('?')[0];
            link.setAttribute('href', baseUrl + queryParams);
        });
    }

    // Jalankan sync saat halaman pertama kali dibuka
    syncLinks();

    // AKSI 1: Jika user mengganti dropdown Guest
    if (guestSelect) {
        guestSelect.addEventListener('change', function() {
            syncLinks();
        });
    }

    // AKSI 2: Klik Tombol Apply Promo
    if (btnApplyPromo) {
        btnApplyPromo.addEventListener('click', function(e) {
            e.preventDefault();
            const rawValue = promoCode.value.trim();

            if (rawValue !== '') {
                appliedPromoCode = rawValue;
                btnApplyPromo.textContent = currentLang === 'id' ? 'Diterapkan' : 'Applied';
                btnApplyPromo.style.color = '#D37D4F';
                
                syncLinks();
                
                const alertMsg = currentLang === 'id' 
                    ? `Kode Promo "${appliedPromoCode}" telah diterapkan!` 
                    : `Promo Code "${appliedPromoCode}" has been applied!`;
                alert(alertMsg);
            } else {
                appliedPromoCode = '';
                btnApplyPromo.textContent = currentLang === 'id' ? 'Terapkan' : 'Apply';
                btnApplyPromo.style.color = '';
                
                syncLinks();
                
                const removeMsg = currentLang === 'id' ? "Kode promo dihapus." : "Promo Code removed.";
                alert(removeMsg);
            }
        });
    }

    // AKSI 3: Filter Kamar
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Ubah class active
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Ambil filter yg dipilih
            const filterValue = this.getAttribute('data-filter');

            // Tampilkan atau sembunyikan kartu kamar
            roomCards.forEach(card => {
                const roomGender = card.getAttribute('data-gender'); 
                
                if (filterValue === 'all') {
                    card.style.display = ''; 
                } else if (filterValue === roomGender) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

});
</script>

</body>
</html>