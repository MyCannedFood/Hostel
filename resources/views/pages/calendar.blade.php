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
                <span>Check-in: <strong>15/05/2026</strong></span>
            </div>
            <div class="divider"></div>
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>Check-out: <strong>20/05/2026</strong></span>
            </div>
            <div class="divider"></div>
            <div class="summary-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><strong>1 Male Guest</strong></span>
            </div>
        </div>
        
        <div class="promo-section">
            <div class="promo-input-wrapper">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D37D4F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <input type="text" placeholder="Apply Promo Code">
            </div>
            <a href="#" class="apply-btn">Apply</a>
        </div>
    </div>

    {{-- Controls --}}
    <div class="calendar-controls">
        <div class="filter-tabs">
            <button class="filter-tab active">All Rooms</button>
            <button class="filter-tab">Female Only Dorm</button>
            <button class="filter-tab">Male Only Dorm</button>
        </div>
        <div class="nights-indicator">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            4 Nights
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

            <div class="month-view">
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
                    
                    {{-- Empty slots for start of month --}}
                    @for($i = 0; $i < $startOffset; $i++)
                        <div class="day empty"></div>
                    @endfor

                    {{-- Days of month --}}
                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $date = $month->copy()->day($d);
                            $isPast = $date->isPast() && !$date->isToday();
                            $isToday = $date->isToday();
                            $isSelected = $index === 0 && ($d >= 15 && $d <= 19); // Keep some visual selection for demo
                            
                            $class = 'available';
                            if ($isPast) $class = 'unavailable';
                            if ($isSelected) $class = 'selected';
                        @endphp
                        <div class="day {{ $class }}">{{ $d }}</div>
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
        <a href="/room-selection" class="btn-choose" style="text-decoration: none; display: inline-block;">Choose these dates</a>
    </div>
</main>

<a href="https://wa.me/..." class="whatsapp-float">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

</body>
</html>
