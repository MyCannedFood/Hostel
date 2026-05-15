@props([
    'checkIn' => '15/05/2026',
    'checkOut' => '20/05/2026',
    'guests' => '1 Male Guest'
])

<div class="calendar-summary-bar">
    <div class="summary-inputs">
        <div class="summary-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span>Check-in: <strong>{{ $checkIn }}</strong></span>
        </div>
        <div class="divider"></div>
        <div class="summary-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span>Check-out: <strong>{{ $checkOut }}</strong></span>
        </div>
        <div class="divider"></div>
        <div class="summary-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span><strong>{{ $guests }}</strong></span>
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
