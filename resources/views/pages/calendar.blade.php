<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Select Your Dates - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="calendar-page">
    <header class="calendar-header">
        <h1>Select Your Dates</h1>
        <p>Find serenity in the heart of Java.</p>
    </header>

    {{-- Summary Bar --}}
    <div class="calendar-summary-bar">
        <div class="summary-inputs">
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>Check-in: <strong id="checkinDate">--/--/----</strong></span>
            </div>
            <div class="divider"></div>
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>Check-out: <strong id="checkoutDate">--/--/----</strong></span>
            </div>
            <div class="divider"></div>
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <select id="guestSelect" style="border: none; outline: none; background: transparent; font-weight: 600; color: inherit; font-size: 14px; cursor: pointer; max-width: 200px;">
                    <option value="1a0c" selected>1 Male Adult, 0 Children</option>
                    <option value="1f0c">1 Female Adult, 0 Children</option>
                    <option value="2a1c">2 Male Adults, 1 Child</option>
                    <option value="2f1c">2 Female Adults, 1 Child</option>
                    <option value="2a2c">2 Male Adults, 2 Children</option>
                    <option value="2f2c">2 Female Adults, 2 Children</option>
                </select>
            </div>
        </div>
        
        <div class="promo-section">
            <div class="promo-input-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D37D4F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <input type="text" id="promoCode" placeholder="Apply Promo Code">
            </div>
            <a href="#" id="btnApplyPromo" class="apply-btn">Apply</a>
        </div>
    </div>

    {{-- Controls --}}
    <div class="calendar-controls">
        <div class="filter-tabs" style="display:none;">
            <button class="filter-tab active">All Rooms</button>
            <button class="filter-tab">Female Only Dorm</button>
            <button class="filter-tab">Male Only Dorm</button>
        </div>
        <div class="nights-indicator">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <span id="totalNights">0 Nights</span>
        </div>
    </div>

    @php
        use Carbon\Carbon;
        $monthParam = request('month');
        try {
            $baseMonth = $monthParam ? Carbon::parse($monthParam)->startOfMonth() : Carbon::now()->startOfMonth();
        } catch (\Exception $e) {
            $baseMonth = Carbon::now()->startOfMonth();
        }

        $months = [
            $baseMonth->copy(),
            $baseMonth->copy()->addMonth()
        ];

        // Simpan hari ini untuk perbandingan
        $today = Carbon::today();

        $prevMonthUrl = url()->current() . '?month=' . $baseMonth->copy()->subMonth()->format('Y-m');
        $nextMonthUrl = url()->current() . '?month=' . $baseMonth->copy()->addMonth()->format('Y-m');
    @endphp

    {{-- Calendar --}}
    <div class="calendar-container">
        @foreach($months as $index => $month)
            @php
                $daysInMonth = $month->daysInMonth;
                $startOffset = $month->dayOfWeek;
            @endphp

            <div class="month-view" data-month="{{ $month->format('Y-m') }}">
                <div class="month-header">
                    @if($index === 0)
                        <a href="{{ $prevMonthUrl }}" class="nav-arrow prev" style="text-decoration: none;">&lt;</a>
                    @endif
                    <h2>{{ $month->format('F Y') }}</h2>
                    @if($index === 1)
                        <a href="{{ $nextMonthUrl }}" class="nav-arrow next" style="text-decoration: none;">&gt;</a>
                    @endif
                </div>
                <div class="calendar-grid">
                    <div class="day-name">S</div><div class="day-name">M</div><div class="day-name">T</div><div class="day-name">W</div><div class="day-name">T</div><div class="day-name">F</div><div class="day-name">S</div>
                    
                    @for($i = 0; $i < $startOffset; $i++)
                        <div class="day empty"></div>
                    @endfor

                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $date = $month->copy()->day($d);
                            // Cek apakah hari sudah lewat
                            $isPast = $date->lt($today);
                            $class = $isPast ? 'past' : 'available';
                            $fullDate = $date->format('Y-m-d');
                        @endphp
                        <div class="day {{ $class }}"
                            data-date="{{ $fullDate }}"
                            @if($isPast) aria-disabled="true" @endif>{{ $d }}</div>
                    @endfor
                </div>
            </div>

            @if($index === 0)
                <div class="calendar-v-divider"></div>
            @endif
        @endforeach

        {{-- Legend --}}
        <div style="grid-column: 1 / span 3;">
            <div class="calendar-legend">
                <div class="legend-item"><span class="dot available"></span> Tersedia</div>
                <div class="legend-item"><span class="dot unavailable"></span> Tidak Tersedia</div>
                <div class="legend-item"><span class="dot selected"></span> Terpilih</div>
            </div>
        </div>
    </div>

    <div class="calendar-footer">
        <button id="btnNext" type="button" class="btn-choose" style="border: none; cursor: pointer; width: 100%; text-align: center; font-family: inherit; font-size: 16px;">Choose these dates</button>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkinEl = document.getElementById('checkinDate');
    const checkoutEl = document.getElementById('checkoutDate');
    const totalNightsEl = document.getElementById('totalNights');
    const btnNext = document.getElementById('btnNext');
    const btnApplyPromo = document.getElementById('btnApplyPromo');
    const guestSelect = document.getElementById('guestSelect');
    const promoCode = document.getElementById('promoCode');

    // ✅ PERBAIKAN: hanya pilih hari yang available (bukan past/unavailable)
    const allDays = document.querySelectorAll('.calendar-grid .day.available');

    let checkinDate = null;
    let checkoutDate = null;
    let nightsCount = 0;
    let appliedPromoCode = '';

    // Ambil data dari URL jika ada (fungsi Back)
    try {
        const cleanSearch = window.location.search.replace(/&amp;/g, '&');
        const urlParams = new URLSearchParams(cleanSearch);
        
        if (urlParams.get('check_in')) checkinDate = urlParams.get('check_in');
        if (urlParams.get('check_out')) checkoutDate = urlParams.get('check_out');
        if (urlParams.get('guests') && guestSelect) guestSelect.value = urlParams.get('guests');
        if (urlParams.get('promo') && promoCode) promoCode.value = urlParams.get('promo');
    } catch (e) {
        console.error("Gagal membaca URL:", e);
    }

    // Format tanggal untuk tampilan
    function formatDisplayDate(dateString) {
        if (!dateString) return '--/--/----';
        const [year, month, day] = dateString.split('-');
        return `${day}/${month}/${year}`;
    }

    // Hitung selisih hari (malam)
    function calculateNights(start, end) {
        if (!start || !end) return 0;
        const startDate = new Date(start);
        const endDate = new Date(end);
        const diffTime = Math.abs(endDate - startDate);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    }
    
    function updateUI() {
        checkinEl.textContent = formatDisplayDate(checkinDate);
        checkoutEl.textContent = formatDisplayDate(checkoutDate);

        if (checkinDate) checkinEl.classList.add('selected-date');
        else checkinEl.classList.remove('selected-date');

        if (checkoutDate) checkoutEl.classList.add('selected-date');
        else checkoutEl.classList.remove('selected-date');

        nightsCount = calculateNights(checkinDate, checkoutDate);
        totalNightsEl.textContent = nightsCount + (nightsCount > 1 ? ' Nights' : ' Night');

        // Update warna kalender
        allDays.forEach(day => {
            const d = day.getAttribute('data-date');
            if (!d) return;

            day.classList.remove('selected');

            if (checkinDate && !checkoutDate) {
                if (d === checkinDate) day.classList.add('selected');
            } else if (checkinDate && checkoutDate) {
                if (d >= checkinDate && d <= checkoutDate) {
                    day.classList.add('selected');
                }
            }
        });

        if (checkinDate && checkoutDate) {
            btnNext.style.opacity = '1';
            btnNext.style.pointerEvents = 'auto';
            btnNext.style.cursor = 'pointer';
            btnNext.textContent = 'Choose these dates';
        } else {
            btnNext.style.opacity = '0.5';
            btnNext.style.pointerEvents = 'none';
            btnNext.style.cursor = 'not-allowed';
        }
    }

    // ✅ Dapatkan tanggal hari ini (format YYYY-MM-DD, timezone lokal)
    function getTodayString() {
        const now = new Date();
        const y = now.getFullYear();
        const m = String(now.getMonth() + 1).padStart(2, '0');
        const d = String(now.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    // Klik Kalender
    allDays.forEach(day => {
        day.addEventListener('click', function () {
            const clickedDate = this.getAttribute('data-date');

            // ✅ GUARD: tolak tanggal masa lalu (double protection di JS)
            const todayStr = getTodayString();
            if (clickedDate < todayStr) return;

            if (!checkinDate || (checkinDate && checkoutDate)) {
                checkinDate = clickedDate;
                checkoutDate = null;
            } else if (checkinDate && !checkoutDate) {
                if (clickedDate < checkinDate) {
                    checkinDate = clickedDate;
                } else if (clickedDate === checkinDate) {
                    // ✅ Klik tanggal yang sama → reset
                    checkinDate = null;
                } else {
                    checkoutDate = clickedDate;
                }
            }
            updateUI();
        });
    });

    // Apply Promo
    if (btnApplyPromo) {
        btnApplyPromo.addEventListener('click', function (e) {
            e.preventDefault();
            const rawValue = promoCode.value.trim();

            if (rawValue !== '') {
                appliedPromoCode = rawValue;
                btnApplyPromo.textContent = 'Applied';
                btnApplyPromo.style.color = '#D37D4F';
                alert(`Promo Code "${appliedPromoCode}" has been applied!`);
            } else {
                appliedPromoCode = '';
                btnApplyPromo.textContent = 'Apply';
                btnApplyPromo.style.color = '';
            }
        });
    }

    // Tombol "Choose these dates"
    if (btnNext) {
        btnNext.addEventListener('click', function (e) {
            e.preventDefault();
            
            if (!checkinDate || !checkoutDate) {
                alert("Silakan pilih tanggal Check-in dan Check-out terlebih dahulu.");
                return;
            }

            btnNext.textContent = "Processing...";
            btnNext.style.opacity = '0.7';
            btnNext.style.pointerEvents = 'none';

            try {
                const guestVal = guestSelect ? guestSelect.value : '1a0c';
                const promoVal = promoCode ? promoCode.value : '';
                const targetMonth = checkinDate.substring(0, 7);

                const targetUrl = `/room-selection?check_in=${checkinDate}&check_out=${checkoutDate}&nights=${nightsCount}&guests=${guestVal}&promo=${promoVal}&month=${targetMonth}`;
                window.location.href = targetUrl;
            } catch (error) {
                console.error("Terjadi kesalahan:", error);
                alert("Gagal memproses, silakan coba lagi.");
                btnNext.textContent = "Choose these dates";
                btnNext.style.opacity = '1';
                btnNext.style.pointerEvents = 'auto';
            }
        });
    }

    updateUI();
});
</script>
</body>
</html>