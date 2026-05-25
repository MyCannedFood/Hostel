<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Booking Confirmed - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="success-page">

@php
    $experience = (object)[
        'name'              => 'Nature the Earth',
        'short_description' => 'Guided planting & forest immersion',
        'location_name'     => 'Organic Gardens',
        'address'           => 'AlaSare Sanctuary, Gianyar Regency, Bali, Indonesia',
    ];

    $booking = (object)[
        'booking_code' => 'ALS-2026-NTE-01',
        'date'         => '2026-11-24',
        'time'         => '07:00',
        'guests'       => 1,
        'id'           => 1,
    ];
@endphp

@include('components.navbar')

<main>
    {{-- Breadcrumb Steps --}}
    <section class="success-steps">
        <div class="steps-container">
            <div class="step step--done">
                <a href="/experience/booking-detail" class="step-link">Detail</a>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <a href="/experience/payment-method" class="step-link">Payment Method</a>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <a href="/experience/payment" class="step-link">Payment</a>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--active">
                <span class="step-label">4.Success</span>
            </div>
        </div>
    </section>

    {{-- Success Header --}}
    <div class="success-header">
        <div class="success-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D9864A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <h1 class="success-title">Payment Successful</h1>
        <p class="success-subtitle">Thank you. Your connection with nature is confirmed.</p>
        <p class="success-note">Please present the e-ticket below upon arrival.</p>
    </div>

    {{-- Ticket Card --}}
    <div class="ticket-wrapper">
        <div class="ticket-card" id="ticket-print">

            {{-- Ticket Top: Booking ID + Status --}}
            <div class="ticket-top">
                <div class="ticket-id-block">
                    <span class="ticket-meta-label">Booking ID</span>
                    <span class="ticket-id">{{ $booking->booking_code }}</span>
                </div>
                <div class="ticket-status-block">
                    <span class="ticket-meta-label">Status</span>
                    <span class="ticket-status">Confirmed</span>
                </div>
            </div>

            <hr class="ticket-divider">

            {{-- Experience Info --}}
            <div class="ticket-experience">
                <h2 class="ticket-exp-name">{{ $experience->name }}</h2>
                <p class="ticket-exp-subtitle">{{ $experience->short_description }}</p>
            </div>

            {{-- Detail Grid --}}
            <div class="ticket-grid">
                <div class="ticket-field">
                    <span class="ticket-field-label">Date</span>
                    <span class="ticket-field-value">{{ \Carbon\Carbon::parse($booking->date)->format('F d, Y') }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">Session Time</span>
                    <span class="ticket-field-value">{{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">Guests</span>
                    <span class="ticket-field-value">{{ $booking->guests }} Adult{{ $booking->guests > 1 ? 's' : '' }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">Location</span>
                    <span class="ticket-field-value">{{ $experience->location_name }}</span>
                </div>
            </div>

            {{-- Address --}}
            <p class="ticket-address">{{ $experience->address }}</p>

            <hr class="ticket-divider ticket-divider--dashed">

            {{-- QR Code --}}
            <div class="ticket-qr">
                <div class="ticket-qr-frame">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=ALS-2026-NTE-01"
                         alt="QR Code"
                         class="ticket-qr-img">
                </div>
                <p class="ticket-qr-note">Present at the {{ $experience->name }} entrance</p>
            </div>

        </div>

        {{-- Actions --}}
        <div class="ticket-actions">
            <a href="#" class="btn-download">
                Download E-Ticket (PDF)
            </a>
            <a href="/" class="btn-home">
                ← Back to Home
            </a>
        </div>
    </div>

</main>

<x-whatsapp_floating />

</body>
</html>