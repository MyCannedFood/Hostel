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

</body>
</html>
