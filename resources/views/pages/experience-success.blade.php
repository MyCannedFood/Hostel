<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Booking Confirmed - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="success-page">

@include('components.navbar')

<main>
    {{-- Breadcrumb Steps --}}
    <section class="success-steps">
        <div class="steps-container">
            <div class="step step--done">
                <span class="step-link">Detail</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <span class="step-link">Payment Method</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <span class="step-link">Payment</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--active">
                <span class="step-label">4. Success</span>
            </div>
        </div>
    </section>

    {{-- Success Header --}}
    <div class="success-header">
        <div class="success-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D9864A"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <h1 class="success-title">Payment Successful</h1>
        <p class="success-subtitle">Thank you, {{ $expBooking->guest_name }}. Your connection with nature is confirmed.</p>
        <p class="success-note">Please present the e-ticket below upon arrival.</p>
    </div>

    {{-- Ticket Card --}}
    <div class="ticket-wrapper">
        <div class="ticket-card" id="ticket-print">

            {{-- Ticket Top: Booking ID + Status --}}
            <div class="ticket-top">
                <div class="ticket-id-block">
                    <span class="ticket-meta-label">Booking ID</span>
                    <span class="ticket-id">{{ $expBooking->ticket_id }}</span>
                </div>
                <div class="ticket-status-block">
                    <span class="ticket-meta-label">Status</span>
                    <span class="ticket-status">{{ $expBooking->status }}</span>
                </div>
            </div>

            <hr class="ticket-divider">

            {{-- Experience Info --}}
            <div class="ticket-experience">
                <h2 class="ticket-exp-name">{{ $expBooking->experience->name }}</h2>
                <p class="ticket-exp-subtitle">
                    {{ $expBooking->experience->short_description ?? 'Guided experience at AlaSare Sanctuary.' }}
                </p>
            </div>

            {{-- Detail Grid --}}
            <div class="ticket-grid">
                <div class="ticket-field">
                    <span class="ticket-field-label">Date</span>
                    <span class="ticket-field-value">
                        {{ $expBooking->scheduled_date->format('F d, Y') }}
                    </span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">Session Time</span>
                    <span class="ticket-field-value">{{ $expBooking->time_slot }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">Guests</span>
                    <span class="ticket-field-value">
                        {{ $expBooking->guest_count }} Adult{{ $expBooking->guest_count > 1 ? 's' : '' }}
                    </span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">Guest Name</span>
                    <span class="ticket-field-value">{{ $expBooking->guest_name }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">WhatsApp</span>
                    <span class="ticket-field-value">{{ $expBooking->guest_whatsapp }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">Payment</span>
                    <span class="ticket-field-value">
                        IDR {{ number_format($expBooking->total_amount, 0, ',', '.') }}
                        via {{ $expBooking->payment_method }}
                    </span>
                </div>
            </div>

            @if($expBooking->special_notes)
            <p class="ticket-address" style="margin-top:8px;">
                <em>Notes: {{ $expBooking->special_notes }}</em>
            </p>
            @endif

            <hr class="ticket-divider ticket-divider--dashed">

            {{-- QR Code --}}
            <div class="ticket-qr">
                <div class="ticket-qr-frame">
                    <img src="{{ $qrCodeUrl }}"
                         alt="QR Code Tiket {{ $expBooking->ticket_id }}"
                         class="ticket-qr-img">
                </div>
                <p class="ticket-qr-note">
                    Present at the {{ $expBooking->experience->name }} entrance
                </p>
                <p style="font-size:11px;color:rgba(26,61,10,0.4);margin-top:4px;">
                    {{ $expBooking->ticket_id }}
                </p>
            </div>

        </div>

        {{-- Actions --}}
        <div class="ticket-actions no-print">
            <button class="btn-download" onclick="printTicket()">
                Download E-Ticket (PDF)
            </button>
            <a href="{{ route('experience') }}" class="btn-home">
                ← Back to Experiences
            </a>
        </div>
    </div>

</main>

<x-whatsapp_floating />

<style>
    @media print {
        /* Sembunyikan semua kecuali ticket-card */
        body * { visibility: hidden; }
        #ticket-print,
        #ticket-print * { visibility: visible; }

        /* Posisikan ticket di tengah halaman */
        #ticket-print {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 420px;
            box-shadow: none !important;
            border: 1px solid #e0e0e0;
        }

        /* Sembunyikan elemen non-tiket */
        .no-print,
        nav,
        footer,
        .whatsapp-float,
        .success-steps,
        .success-header {
            display: none !important;
        }

        @page {
            size: A5 portrait;
            margin: 0;
        }
    }
</style>

<script>
    function printTicket() {
        window.print();
    }
</script>

</body>
</html>