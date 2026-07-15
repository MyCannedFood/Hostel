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

    <div id="bookingHeaderWp">
        <x-booking-header 
            title="Select Your Rooms"
            title-id="Pilih Kamar Anda"
            subtitle="Each retreat space is uniquely designed for your comfort."
            subtitle-id="Setiap ruang peristirahatan dirancang unik untuk kenyamanan Anda."
        />
    </div>

    @php
        use Carbon\Carbon;
        
        $checkInParam = request()->query('check_in');
        $checkOutParam = request()->query('check_out');
        $nightsParam = request()->query('nights', 0);
        $guestsParam = request()->query('guests', '1f0c');
        $promoParam = request()->query('promo', '');
        $monthParam = request()->query('month', '');

        $displayCheckIn = $checkInParam ? Carbon::parse($checkInParam)->format('d/m/Y') : '--/--/----';
        $displayCheckOut = $checkOutParam ? Carbon::parse($checkOutParam)->format('d/m/Y') : '--/--/----';
        
        $backToCalendarUrl = url('/calendar') . '?' . http_build_query(request()->query());

        // Mapping label fasilitas EN/ID — main_facilities di DB cuma simpan
        // string EN (AC, Wifi, En-suite Bath, Lockers), jadi label ID
        // di-mapping statis di sini.
        $facilityLabels = [
            'AC'            => ['en' => 'AC', 'id' => 'AC'],
            'Wifi'          => ['en' => 'Wifi', 'id' => 'Wifi'],
            'En-suite Bath' => ['en' => 'En-suite Bath', 'id' => 'Kamar Mandi Dalam'],
            'Lockers'       => ['en' => 'Lockers', 'id' => 'Loker'],
        ];
    @endphp

    {{-- SUMMARY BAR INTERAKTIF --}}
    <div class="calendar-summary-bar">
        <div class="summary-inputs">
            <a href="{!! $backToCalendarUrl !!}" class="summary-item calendar-link" style="text-decoration: none; color: inherit; cursor: pointer;" 
               data-en-title="Change Dates" data-id-title="Ubah Tanggal" title="Change Dates">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span><span data-en="Check-in: " data-id="Tgl Masuk: ">Check-in: </span><strong class="date-confirmed">{{ $displayCheckIn }}</strong></span>
            </a>
            
            <div class="divider"></div>
            
            <a href="{!! $backToCalendarUrl !!}" class="summary-item calendar-link" style="text-decoration: none; color: inherit; cursor: pointer;" 
               data-en-title="Change Dates" data-id-title="Ubah Tanggal" title="Change Dates">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span><span data-en="Check-out: " data-id="Tgl Keluar: ">Check-out: </span><strong class="date-confirmed">{{ $displayCheckOut }}</strong></span>
            </a>
            
            <div class="divider"></div>
            
        </div>
        
        <div class="promo-section">
            <div class="promo-input-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D37D4F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <input type="text" id="promoCode" 
                       placeholder="Apply Promo Code" 
                       data-en-placeholder="Apply Promo Code" 
                       data-id-placeholder="Gunakan Kode Promo" 
                       value="{{ $promoParam }}">
            </div>
            <a href="#" id="btnApplyPromo" class="apply-btn" 
               data-en="Apply" data-id="Terapkan"
               data-en-applied="Applied" data-id-applied="Diterapkan"
               style="{{ $promoParam ? 'color: #D37D4F;' : '' }}">
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
            <span id="nightsText" 
                  data-nights="{{ $nightsParam }}"
                  data-en-singular="Night" data-en-plural="Nights"
                  data-id-singular="Malam" data-id-plural="Malam">
                {{ $nightsParam }} {{ $nightsParam > 1 ? 'Nights' : 'Night' }}
            </span>
        </div>
    </div>

    {{-- Room Selection Container --}}
    <div class="selection-container">
        
        @foreach($rooms as $room)
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
                <p class="room-sel-desc" 
                   data-en="{{ $room->description }}" 
                   data-id="{{ $room->description_id ?: $room->description }}">{{ $room->description }}</p>
                
                <div class="room-sel-features">
                    <div class="sel-feature">
                        <img src="{{ asset('images/icon/walk-svgrepo-com.svg') }}" alt="" class="sel-feature-icon" style="width:16px;height:16px;">
                        <span data-en="{{ $room->capacity }} Person Capacity" data-id="Kapasitas {{ $room->capacity }} Orang">{{ $room->capacity }} Person Capacity</span>
                    </div>
                    @php
                        $facilities = $room->main_facilities ? explode(',', $room->main_facilities) : [];
                    @endphp
                    
                    @foreach($facilities as $facility)
                        @php
                            $facilityKey = trim($facility);
                            $label = $facilityLabels[$facilityKey] ?? ['en' => $facilityKey, 'id' => $facilityKey];

                            // Mapping icon fasilitas — disamakan dengan halaman Rooms (rooms.blade.php)
                            $facilityNameLower = strtolower($facilityKey);
                            $iconFile = 'images/icon/walk-svgrepo-com.svg';
                            if (str_contains($facilityNameLower, 'wi-fi') || str_contains($facilityNameLower, 'wifi')) {
                                $iconFile = 'images/icon/wifi-svgrepo-com-1.svg';
                            } elseif (str_contains($facilityNameLower, 'ac') || str_contains($facilityNameLower, 'air')) {
                                $iconFile = 'images/icon/snow-svgrepo-com.svg';
                            } elseif (str_contains($facilityNameLower, 'locker') || str_contains($facilityNameLower, 'lock')) {
                                $iconFile = 'images/icon/lock-svgrepo-com.svg';
                            } elseif (str_contains($facilityNameLower, 'en-suite bath') || str_contains($facilityNameLower, 'bath') || str_contains($facilityNameLower, 'shower')) {
                                $iconFile = 'images/icon/shower-svgrepo-com.svg';
                            }
                        @endphp
                        <div class="sel-feature">
                            <img src="{{ asset($iconFile) }}" alt="{{ $label['en'] }}" class="sel-feature-icon" style="width:16px;height:16px;">
                            <span data-en="{{ $label['en'] }}" data-id="{{ $label['id'] }}">{{ $label['en'] }}</span>
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

                <a class="btn-select-room" href="{{ url('/bed-shared-room/' . $room->id) }}" style="text-decoration: none; display: inline-block;" data-en="SELECT" data-id="PILIH">
                    SELECT
                </a>
            </div>
        </div>
        @endforeach

    </div>

    <div id="bookingBottomBarWp">
        <x-booking-bottom-bar 
            title="Select Your Room"
            title-id="Pilih Kamar Anda"
            label="EST.Total"
            label-id="Estimasi Total"
            value="IDR 0"
            backUrl="{!! $backToCalendarUrl !!}"
            backText="Back To Calendar"
            back-text-id="Kembali Ke Kalender"
            continueUrl="#"
            continueText="Continue To Bed"
            continue-text-id="Lanjut Ke Kasur"
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
    
    const bookingHeaderWp = document.getElementById('bookingHeaderWp');
    const bookingBottomBarWp = document.getElementById('bookingBottomBarWp');
    
    const calendarLinks = document.querySelectorAll('a[href*="/calendar"]'); 

    const filterBtns = document.querySelectorAll('.filter-tab');
    const roomCards = document.querySelectorAll('.room-selection-card');

    const checkIn = "{{ $checkInParam }}";
    const checkOut = "{{ $checkOutParam }}";
    const nights = parseInt("{{ $nightsParam }}") || 0;
    const month = "{{ $monthParam }}";
    
    let appliedPromoCode = "{{ $promoParam }}";
    let currentLang = localStorage.getItem('alas_lang') || 'en';

    function updateDynamicLanguage() {
        // 1. Update jumlah malam — baca dari data-* atribut
        if (nightsTextEl) {
            const singular = nightsTextEl.getAttribute(`data-${currentLang}-singular`);
            const plural   = nightsTextEl.getAttribute(`data-${currentLang}-plural`);
            nightsTextEl.textContent = `${nights} ${nights > 1 ? plural : singular}`;
        }

        // 2. Update placeholder kode promo
        if (promoCode) {
            promoCode.placeholder = promoCode.getAttribute(`data-${currentLang}-placeholder`);
        }

        // 3. Update teks tombol promo — baca dari data-* atribut
        if (btnApplyPromo) {
            if (appliedPromoCode !== '') {
                btnApplyPromo.textContent = btnApplyPromo.getAttribute(`data-${currentLang}-applied`);
            } else {
                btnApplyPromo.textContent = btnApplyPromo.getAttribute(`data-${currentLang}`);
            }
        }

        // 4. Update title attribute pada calendar links — baca dari data-* atribut
        calendarLinks.forEach(link => {
            link.title = link.getAttribute(`data-${currentLang}-title`);
        });

        // 5. Update guest select options
        if (guestSelect) {
            Array.from(guestSelect.options).forEach(opt => {
                opt.textContent = opt.getAttribute(`data-${currentLang}`);
            });
        }

        // 6. TRANSLASI KOMPONEN BLADE: x-booking-header
        if (bookingHeaderWp) {
            const hTitle    = bookingHeaderWp.querySelector('h1, h2, .title');
            const hSubtitle = bookingHeaderWp.querySelector('p, .subtitle');
            
            if (currentLang === 'id') {
                if (hTitle)    hTitle.textContent    = 'Pilih Kamar Anda';
                if (hSubtitle) hSubtitle.textContent = 'Setiap ruang peristirahatan dirancang unik untuk kenyamanan Anda.';
            } else {
                if (hTitle)    hTitle.textContent    = 'Select Your Rooms';
                if (hSubtitle) hSubtitle.textContent = 'Each retreat space is uniquely designed for your comfort.';
            }
        }

        // 7. TRANSLASI KOMPONEN BLADE: x-booking-bottom-bar
        if (bookingBottomBarWp) {
            const bTitle       = bookingBottomBarWp.querySelector('.title, h3, h4');
            const bLabel       = bookingBottomBarWp.querySelector('.label, span:not(.value)');
            const bBackBtn     = bookingBottomBarWp.querySelector('a[href*="/calendar"], .btn-back');
            const bContinueBtn = bookingBottomBarWp.querySelector('a:not([href*="/calendar"]), .btn-continue');

            if (currentLang === 'id') {
                if (bTitle)       bTitle.textContent       = 'Pilih Kamar Anda';
                if (bLabel)       bLabel.textContent       = 'Estimasi Total';
                if (bBackBtn)     bBackBtn.textContent     = 'Kembali Ke Kalender';
                if (bContinueBtn) bContinueBtn.textContent = 'Lanjut Ke Kasur';
            } else {
                if (bTitle)       bTitle.textContent       = 'Select Your Room';
                if (bLabel)       bLabel.textContent       = 'EST.Total';
                if (bBackBtn)     bBackBtn.textContent     = 'Back To Calendar';
                if (bContinueBtn) bContinueBtn.textContent = 'Continue To Bed';
            }
        }


        document.querySelectorAll('[data-en][data-id]').forEach(el => {
            if (el === nightsTextEl || el === promoCode || el === btnApplyPromo) return;
            if (el.tagName === 'OPTION') return;
        
            
            const text = el.getAttribute(`data-${currentLang}`);
            if (text !== null) el.textContent = text;

                });
            }

    document.addEventListener('alas:langchange', function(e) {
        currentLang = e.detail.lang;
        updateDynamicLanguage();
    });

    updateDynamicLanguage();

    function syncLinks() {
        const currentGuestVal = guestSelect ? guestSelect.value : '1a0c';
        const currentPromoVal = appliedPromoCode;
        
        const queryParams = `?check_in=${checkIn}&check_out=${checkOut}&nights=${nights}&guests=${currentGuestVal}&promo=${currentPromoVal}&month=${month}`;

        selectButtons.forEach(btn => {
            const baseUrl = btn.getAttribute('href').split('?')[0]; 
            btn.setAttribute('href', baseUrl + queryParams);
        });

        calendarLinks.forEach(link => {
            const baseUrl = link.getAttribute('href').split('?')[0];
            link.setAttribute('href', baseUrl + queryParams);
        });
    }

    syncLinks();

    if (guestSelect) {
        guestSelect.addEventListener('change', function() {
            syncLinks();
        });
    }

    if (btnApplyPromo) {
        btnApplyPromo.addEventListener('click', function(e) {
            e.preventDefault();
            const rawValue = promoCode.value.trim();

            if (rawValue !== '') {
                appliedPromoCode = rawValue;
                btnApplyPromo.textContent = btnApplyPromo.getAttribute(`data-${currentLang}-applied`);
                btnApplyPromo.style.color = '#D37D4F';
                
                syncLinks();
                
                const alertMsg = currentLang === 'id' 
                    ? `Kode Promo "${appliedPromoCode}" telah diterapkan!` 
                    : `Promo Code "${appliedPromoCode}" has been applied!`;
                alert(alertMsg);
            } else {
                appliedPromoCode = '';
                btnApplyPromo.textContent = btnApplyPromo.getAttribute(`data-${currentLang}`);
                btnApplyPromo.style.color = '';
                
                syncLinks();
                
                const removeMsg = currentLang === 'id' ? "Kode promo dihapus." : "Promo Code removed.";
                alert(removeMsg);
            }
        });
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

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