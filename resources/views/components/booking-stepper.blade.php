@props(['currentStep' => 1])

@php
    $steps = [
        1 => ['en' => 'Calendar',          'id' => 'Kalender'],
        2 => ['en' => 'Room Selection',    'id' => 'Pilih Kamar'],
        3 => ['en' => 'Bed & Shared Room', 'id' => 'Kasur & Kamar Bersama'],
        4 => ['en' => 'Guest Details',     'id' => 'Data Tamu'],
        5 => ['en' => 'Confirm & Payment', 'id' => 'Konfirmasi & Pembayaran'],
    ];
@endphp

<nav class="booking-stepper">
    @foreach($steps as $num => $step)
        <div class="step {{ $num < $currentStep ? 'completed' : ($num == $currentStep ? 'active' : '') }}">
            <span class="step-icon">
                @if($num < $currentStep)
                    ✓
                @else
                    {{ $num }}
                @endif
            </span>
            <span data-en="{{ $step['en'] }}" data-id="{{ $step['id'] }}">{{ $step['en'] }}</span>
        </div>
        
        @if(!$loop->last)
            <div class="step-divider"></div>
        @endif
    @endforeach
</nav>