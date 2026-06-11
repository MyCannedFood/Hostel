<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('experience.payment_successful') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="success-page">

@include('components.navbar')

<main>
    {{-- Breadcrumb Steps --}}
    <section class="success-steps">
        <div class="steps-container">
            <div class="step step--done">
                <span class="step-link">{{ __('experience.step_detail') }}</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <span class="step-link">{{ __('experience.step_payment_method') }}</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <span class="step-link">{{ __('experience.step_payment') }}</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--active">
                <span class="step-label">4. {{ __('experience.step_success') }}</span>
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
        <h1 class="success-title">{{ __('experience.payment_successful') }}</h1>
        <p class="success-subtitle">{{ __('experience.thank_you_guest', ['name' => $expBooking->guest_name]) }}</p>
        <p class="success-note">{{ __('experience.present_eticket') }}</p>
    </div>

    {{-- Ticket Card --}}
    <div class="ticket-wrapper">
        <div class="ticket-card" id="ticket-print">

            {{-- Ticket Top: Booking ID + Status --}}
            <div class="ticket-top">
                <div class="ticket-id-block">
                    <span class="ticket-meta-label">{{ __('experience.booking_id') }}</span>
                    <span class="ticket-id">{{ $expBooking->ticket_id }}</span>
                </div>
                <div class="ticket-status-block">
                    <span class="ticket-meta-label">{{ __('experience.status') }}</span>
                    <span class="ticket-status">{{ $expBooking->status }}</span>
                </div>
            </div>

            <hr class="ticket-divider">

            {{-- Experience Info --}}
            <div class="ticket-experience">
                <h2 class="ticket-exp-name">{{ $expBooking->experience->name }}</h2>
                <p class="ticket-exp-subtitle">
                    {{ $expBooking->experience->short_description }}
                </p>
            </div>

            {{-- Detail Grid --}}
            <div class="ticket-grid">
                <div class="ticket-field">
                    <span class="ticket-field-label">{{ __('experience.date') }}</span>
                    <span class="ticket-field-value">
                        {{ $expBooking->scheduled_date->format('F d, Y') }}
                    </span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">{{ __('experience.session_time_label') }}</span>
                    <span class="ticket-field-value">{{ $expBooking->time_slot }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">{{ __('experience.guests') }}</span>
                    <span class="ticket-field-value">
                        {{ $expBooking->guest_count }} {{ $expBooking->guest_count > 1 ? __('experience.adults') : __('experience.adult') }}
                    </span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">{{ __('experience.guest_name') }}</span>
                    <span class="ticket-field-value">{{ $expBooking->guest_name }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">{{ __('experience.whatsapp') }}</span>
                    <span class="ticket-field-value">{{ $expBooking->guest_whatsapp }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label">{{ __('experience.payment') }}</span>
                    <span class="ticket-field-value">
                        IDR {{ number_format($expBooking->total_amount, 0, ',', '.') }}
                        via {{ $expBooking->payment_method }}
                    </span>
                </div>
            </div>

            @if($expBooking->special_notes)
            <p class="ticket-address" style="margin-top:8px;">
                <em>{{ __('experience.notes') }}: {{ $expBooking->special_notes }}</em>
            </p>
            @endif

            <hr class="ticket-divider ticket-divider--dashed">

            {{-- QR Code --}}
            <div class="ticket-qr">
                <div class="ticket-qr-frame">
                    <img src="{{ $qrCodeUrl }}"
                         alt="{{ __('experience.booking_id') }} {{ $expBooking->ticket_id }}"
                         class="ticket-qr-img">
                </div>
                <p class="ticket-qr-note">
                    {{ __('experience.present_at_entrance', ['name' => $expBooking->experience->name]) }}
                </p>
                <p style="font-size:11px;color:rgba(26,61,10,0.4);margin-top:4px;">
                    {{ $expBooking->ticket_id }}
                </p>
            </div>

        </div>

        {{-- Actions --}}
        <div class="ticket-actions no-print">
            <button class="btn-download" onclick="printTicket()">
                {{ __('experience.download_eticket') }}
            </button>
            <a href="{{ route('experience') }}" class="btn-home">
                {{ __('experience.back_to_experiences') }}
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