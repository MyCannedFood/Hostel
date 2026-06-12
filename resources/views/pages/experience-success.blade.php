<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-en="Payment Successful - AlaSare" data-id="Pembayaran Berhasil - AlaSare">{{ __('experience.payment_successful') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="success-page">

@include('components.navbar')

<main>
    {{-- Breadcrumb Steps --}}
    <section class="success-steps">
        <div class="steps-container">
            <div class="step step--done">
                <span class="step-link" data-en="Detail" data-id="Detail">{{ __('experience.step_detail') }}</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <span class="step-link" data-en="Payment Method" data-id="Metode Pembayaran">{{ __('experience.step_payment_method') }}</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--done">
                <span class="step-link" data-en="Payment" data-id="Pembayaran">{{ __('experience.step_payment') }}</span>
                <span class="step-arrow">›</span>
            </div>
            <div class="step step--active">
                <span class="step-label">4. <span data-en="Success" data-id="Sukses">{{ __('experience.step_success') }}</span></span>
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
        <h1 class="success-title" data-en="Payment Successful" data-id="Pembayaran Berhasil">{{ __('experience.payment_successful') }}</h1>
        <p class="success-subtitle">
            <span data-en="Thank you, " data-id="Terima kasih, "></span>
            {{ $expBooking->guest_name }}
            <span data-en=". Your connection with nature is confirmed." data-id=". Koneksi Anda dengan alam telah dikonfirmasi."></span>
        </p>
        <p class="success-note" data-en="Please present the e-ticket below upon arrival." data-id="Tunjukkan e-tiket di bawah saat kedatangan.">{{ __('experience.present_eticket') }}</p>
    </div>

    {{-- Ticket Card --}}
    <div class="ticket-wrapper">
        <div class="ticket-card" id="ticket-print">

            {{-- Ticket Top: Booking ID + Status --}}
            <div class="ticket-top">
                <div class="ticket-id-block">
                    <span class="ticket-meta-label" data-en="Booking ID" data-id="ID Pemesanan">{{ __('experience.booking_id') }}</span>
                    <span class="ticket-id">{{ $expBooking->ticket_id }}</span>
                </div>
                <div class="ticket-status-block">
                    <span class="ticket-meta-label" data-en="Status" data-id="Status">{{ __('experience.status') }}</span>
                    <span class="ticket-status">{{ $expBooking->status }}</span>
                </div>
            </div>

            <hr class="ticket-divider">

            {{-- Experience Info --}}
            <div class="ticket-experience">
                <h2 class="ticket-exp-name">{{ $expBooking->experience->name }}</h2>
                <p class="ticket-exp-subtitle">{{ $expBooking->experience->short_description }}</p>
            </div>

            {{-- Detail Grid --}}
            <div class="ticket-grid">
                <div class="ticket-field">
                    <span class="ticket-field-label" data-en="Date" data-id="Tanggal">{{ __('experience.date') }}</span>
                    <span class="ticket-field-value">
                        {{ $expBooking->scheduled_date->format('F d, Y') }}
                    </span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label" data-en="Session Time" data-id="Waktu Sesi">{{ __('experience.session_time_label') }}</span>
                    <span class="ticket-field-value">{{ $expBooking->time_slot }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label" data-en="Guests" data-id="Tamu">{{ __('experience.guests') }}</span>
                    <span class="ticket-field-value">
                        {{ $expBooking->guest_count }} {{ $expBooking->guest_count > 1 ? __('experience.adults') : __('experience.adult') }}
                    </span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label" data-en="Guest Name" data-id="Nama Tamu">{{ __('experience.guest_name') }}</span>
                    <span class="ticket-field-value">{{ $expBooking->guest_name }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label" data-en="WhatsApp" data-id="WhatsApp">{{ __('experience.whatsapp') }}</span>
                    <span class="ticket-field-value">{{ $expBooking->guest_whatsapp }}</span>
                </div>
                <div class="ticket-field">
                    <span class="ticket-field-label" data-en="Payment" data-id="Pembayaran">{{ __('experience.payment') }}</span>
                    <span class="ticket-field-value">
                        IDR {{ number_format($expBooking->total_amount, 0, ',', '.') }}
                        via {{ $expBooking->payment_method }}
                    </span>
                </div>
            </div>

            @if($expBooking->special_notes)
            <p class="ticket-address" style="margin-top:8px;">
                <em><span data-en="Notes" data-id="Catatan">{{ __('experience.notes') }}</span>: {{ $expBooking->special_notes }}</em>
            </p>
            @endif

            <hr class="ticket-divider ticket-divider--dashed">

            {{-- QR Code --}}
            <div class="ticket-qr">
                <div class="ticket-qr-frame">
                    <img src="{{ $qrCodeUrl }}"
                         alt="QR Code"
                         class="ticket-qr-img">
                </div>
                <p class="ticket-qr-note">
                    <span data-en="Present at the " data-id="Tunjukkan di pintu masuk "></span>
                    {{ $expBooking->experience->name }}
                    <span data-en=" entrance" data-id=""></span>
                </p>
                <p style="font-size:11px;color:rgba(26,61,10,0.4);margin-top:4px;">
                    {{ $expBooking->ticket_id }}
                </p>
            </div>

        </div>

        {{-- Actions --}}
        <div class="ticket-actions no-print">
            <button class="btn-download" onclick="printTicket()" data-en="Download E-Ticket (PDF)" data-id="Unduh E-Tiket (PDF)">
                {{ __('experience.download_eticket') }}
            </button>
            <a href="{{ route('experience') }}" class="btn-home" data-en="← Back to Experiences" data-id="← Kembali ke Pengalaman">
                {{ __('experience.back_to_experiences') }}
            </a>
        </div>
    </div>

</main>

<x-whatsapp_floating />

<style>
    @media print {
        body * { visibility: hidden; }
        #ticket-print,
        #ticket-print * { visibility: visible; }
        #ticket-print {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 420px;
            box-shadow: none !important;
            border: 1px solid #e0e0e0;
        }
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
