<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bed & Shared Room - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/css/bed-shared-room.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="selection-page">
    {{-- Booking Stepper --}}
    <nav class="booking-stepper">
        <div class="step completed">
            <span class="step-icon">✓</span>
            <span>Calendar</span>
        </div>
        <div class="step-divider"></div>
        <div class="step completed">
            <span class="step-icon">✓</span>
            <span>Room Selection</span>
        </div>
        <div class="step-divider"></div>
        <div class="step active">
            <span class="step-icon">3</span>
            <span>Bed & Shared Room</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">4</span>
            <span>Guest Details</span>
        </div>
        <div class="step-divider"></div>
        <div class="step">
            <span class="step-icon">5</span>
            <span>Confirm & Payment</span>
        </div>
    </nav>

    {{-- Wizard Header --}}
    <header class="selection-header">
        <h1>Bed & Shared Room</h1>
        <p>Setiap ruang peristirahatan dirancang unik untuk kenyamanan Anda.</p>
    </header>

    {{-- Summary Bar (same as room-selection page) --}}
    <div class="calendar-summary-bar" style="margin-bottom: 40px;">
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

    {{-- Minimal wizard content for Step 3 (checkbox + checkin/checkout boxes) --}}
    <div class="wizard-step-container">
        {{-- Guest / Bed options (checkbox row) --}}
        <div class="wizard-card">
            <h3 class="wizard-card-title">Guest & Bed Options</h3>

            <div class="wizard-checkbox-grid">
                {{-- Use same “calendar-style” checkbox look: label wrapping input + custom span bullet is handled by CSS import --}}
                <label class="wizard-checkbox">
                    <input type="checkbox" checked>
                    <span>1 Bed</span>
                </label>

                <label class="wizard-checkbox">
                    <input type="checkbox" checked>
                    <span>Room Selection</span>
                </label>

            </div>
        </div>

        {{-- Check-in / Check-out boxes --}}
        <div class="wizard-card">
            <h3 class="wizard-card-title">Stay Dates</h3>

            <div class="wizard-dates-grid">
                <div class="wizard-date-field">
                    <label>Check-in</label>
                    <div class="wizard-input-box">
                        <input type="date" value="2026-05-15">
                    </div>
                </div>

                <div class="wizard-date-field">
                    <label>Check-out</label>
                    <div class="wizard-input-box">
                        <input type="date" value="2026-05-20">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="selection-bottom-bar">
        <div class="bottom-bar-content">
            <div class="selection-info">
                <span>Selected: <strong>Arunika Bed</strong></span>
                <span>Total: <strong>IDR 0</strong></span>
            </div>
            <a class="btn-continue" href="#" style="text-decoration: none; display: inline-block;">CONTINUE TO GUEST DETAILS</a>
        </div>
    </div>

</main>

<a href="https://wa.me/..." class="whatsapp-float">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

</body>
</html>

