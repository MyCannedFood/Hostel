<style>
        .addon-row-wrapper {
            cursor: pointer; 
            display: flex; 
            gap: 12px; 
            align-items: flex-start; 
            margin-bottom: 12px;
        }
        
        /* Ganti nama class agar tidak bentrok dengan CSS bawaan */
        .alasare-box {
            width: 20px !important; 
            height: 20px !important; 
            border-radius: 4px !important; 
            display: inline-flex !important; 
            align-items: center !important; 
            justify-content: center !important;
            flex-shrink: 0 !important; 
            transition: all 0.2s ease-in-out !important;
        }
        
        /* 1. Saat TIDAK dicentang: Border Hijau Gelap, Background Putih */
        .alasare-box.is-off {
            border: 2px solid #1A3D0A !important;
            background-color: #FFFFFF !important;
        }
        
        /* 2. Saat DICENTANG: Border Oren, Background Oren */
        .alasare-box.is-on {
            border: 2px solid #D37D4F !important;
            background-color: #D37D4F !important;
        }

        /* Paksa icon centang berwarna putih tegas */
        .alasare-box svg.check-icon {
            stroke: #FFFFFF !important;
            color: #FFFFFF !important;
        }
    </style>

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
        <span class="{{ $isTotalAvailable ? 'badge-selected' : 'badge-occupied' }}" data-state="{{ $isTotalAvailable ? 'select' : 'occupied' }}">
            {{ $isTotalAvailable ? 'SELECT' : 'OCCUPIED' }}
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
        <span class="badge-selected" data-state="select">SELECT</span>
    </div>

    {{-- Addons List (Hanya dirender jika array tidak kosong) --}}
    @if(count($addons) > 0)
        <div class="addons-container">
            @foreach($addons as $addon)
                @php
                    // Default checkbox tercentang jika tidak ada parameter 'checked'
                    $isChecked = $addon['checked'] ?? true; 
                @endphp
                
                {{-- Baris yang bisa diklik --}}
                <div class="addon-row-wrapper" onclick="toggleAddon(this)">
                    
                    {{-- Kotak Checkbox dengan Class Baru --}}
                    <div class="alasare-box {{ $isChecked ? 'is-on' : 'is-off' }}">
                        {{-- Icon Check SVG (Warna Putih) --}}
                        <svg class="check-icon" style="display: {{ $isChecked ? 'block' : 'none' }}; width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    
                    <div class="addon-info">
                        <span class="addon-name">
                            {{ $addon['name'] }} 
                            @if(isset($addon['note'])) <span class="addon-note">{{ $addon['note'] }}</span> @endif
                        </span>
                        <div style="display: flex; gap: 8px;">
                            <span class="addon-price {{ isset($addon['discount']) ? 'has-discount' : '' }}">{{ $addon['price'] }} /pack</span>
                            @if(isset($addon['discount']))
                                <span class="addon-discount">{{ $addon['discount'] }} /pack</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

   

    {{-- Script Interaksi --}}
    <script>
       function toggleAddon(rowElement) {
            const checkbox = rowElement.querySelector('.alasare-box');
            const icon = rowElement.querySelector('.check-icon');
            
            if (!checkbox || !icon) return;

            if (checkbox.classList.contains('is-on')) {
                // Matikan (Ubah ke style hijau/putih)
                checkbox.classList.replace('is-on', 'is-off');
                icon.style.display = 'none';
            } else {
                // Nyalakan (Ubah ke style oren/oren solid)
                checkbox.classList.replace('is-off', 'is-on');
                icon.style.display = 'block';
            }
        }
    </script>