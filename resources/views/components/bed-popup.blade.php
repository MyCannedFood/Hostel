{{-- resources/views/components/bed-popup.blade.php --}}
@props([
    'unitName', 
    'guestName' => null, 
    'guestAge' => null, 
    'guestRole' => null, 
    'guestImage' => null, 
    'bedPrice',
    'addons' => [],
    'isTotalAvailable' => false {{-- Tambahkan ini untuk kontrol kasur kosong total --}}
])

<div class="custom-bed-popup">
    <div class="popup-header">
        <h3 class="unit-title">{{ $unitName }}</h3>
        <span class="badge-available">AVAILABLE</span>
    </div>

    {{-- ===== TOP BED ===== --}}
    <div class="bed-row">
        <div class="icon-circle {{ $isTotalAvailable ? 'icon-selected' : '' }}">↑</div>
        <div class="bed-info">
            <span class="bed-name">1 - Top Bed</span>
            {{-- Jika kosong total, tampilkan harga di top bed juga --}}
            @if($isTotalAvailable)
                <span class="bed-price">{{ $bedPrice }} /nights</span>
            @endif
        </div>
        {{-- Status dinamis tergantung properti isTotalAvailable --}}
        <span class="{{ $isTotalAvailable ? 'badge-selected' : 'badge-occupied' }}">
            {{ $isTotalAvailable ? 'SELECTED' : 'OCCUPIED' }}
        </span>
    </div>

    {{-- Profil Tamu HANYA muncul jika kasur TIDAK kosong total --}}
    @if(!$isTotalAvailable)
        <div class="guest-profile">
            <img src="{{ $guestImage }}" alt="{{ $guestName }}" class="guest-img">
            <div class="guest-details">
                <h4 class="guest-name">{{ $guestName }}, {{ $guestAge }}y</h4>
                <p class="guest-role">{{ $guestRole }}</p>
            </div>
        </div>
    @endif

    <hr class="popup-divider">

    {{-- ===== BOTTOM BED ===== --}}
    <div class="bed-row">
        <div class="icon-circle icon-selected">↓</div>
        <div class="bed-info">
            <span class="bed-name">1 - Bottom Bed</span>
            <span class="bed-price">{{ $bedPrice }} /nights</span>
        </div>
        <span class="badge-selected">SELECTED</span>
    </div>

    {{-- Addons List (Hanya dirender jika array tidak kosong) --}}
    @if(count($addons) > 0)
        <div class="addons-container">
            @foreach($addons as $addon)
                <div class="addon-row">
                    <div class="checkbox-checked">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div class="addon-info">
                        <span class="addon-name">
                            {{ $addon['name'] }} 
                            @if(isset($addon['note'])) <span class="addon-note">{{ $addon['note'] }}</span> @endif
                        </span>
                        <span class="addon-price {{ isset($addon['discount']) ? 'has-discount' : '' }}">{{ $addon['price'] }} /pack</span>
                        @if(isset($addon['discount']))
                            <span class="addon-discount">{{ $addon['discount'] }} /pack</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>