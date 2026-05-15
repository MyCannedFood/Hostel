@props(['currentStep' => 1])

@php
    $steps = [
        1 => 'Calendar',
        2 => 'Room Selection',
        3 => 'Bed & Shared Room',
        4 => 'Guest Details',
        5 => 'Confirm & Payment'
    ];
@endphp

<nav class="booking-stepper">
    @foreach($steps as $num => $label)
        <div class="step {{ $num < $currentStep ? 'completed' : ($num == $currentStep ? 'active' : '') }}">
            <span class="step-icon">
                @if($num < $currentStep)
                    ✓
                @else
                    {{ $num }}
                @endif
            </span>
            <span>{{ $label }}</span>
        </div>
        
        @if(!$loop->last)
            <div class="step-divider"></div>
        @endif
    @endforeach
</nav>
