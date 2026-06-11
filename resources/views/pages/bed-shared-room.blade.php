<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bed & Shared Room - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* STYLE KHUSUS POP-UP & ADDON */
        .custom-bed-popup { background: #FFFFFF; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); width: 320px; overflow: hidden; text-align: left; border: 1px solid #E5E5E5; }
        .addon-row-wrapper { cursor: pointer; display: flex; align-items: flex-start; margin-bottom: 12px; user-select: none; }
        .alasare-box { width: 20px !important; height: 20px !important; border-radius: 4px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; flex-shrink: 0 !important; transition: all 0.2s ease-in-out !important; }
        .alasare-box.is-off { border: 2px solid #1A3D0A !important; background-color: #FFFFFF !important; }
        .alasare-box.is-on { border: 2px solid #D37D4F !important; background-color: #D37D4F !important; }
        .alasare-box svg.check-icon { stroke: #FFFFFF !important; color: #FFFFFF !important; }
        
        .bed-select-btn { border: none; padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: bold; transition: 0.2s; }
        .bed-select-btn.state-select { background: #E5E5E5; color: #1A3D0A; cursor: pointer; }
        .bed-select-btn.state-select:hover { background: #D1DCD1; }
        .bed-select-btn.state-selected { background: #D9864A; color: #FFFFFF; cursor: pointer; }
        .bed-select-btn.state-occupied { background: #E5E5E5; color: #7D8A74; cursor: not-allowed; }
        .bed-select-btn.state-maintenance { background: #dc3545; color: #FFFFFF; cursor: not-allowed; }

        /* STYLE ROOMMATES SECTION */
        .roommates-section { margin-top: 40px; margin-bottom: 40px; }
        .roommates-section .section-title { font-size: 20px; color: #1A3D0A; margin-bottom: 20px; font-weight: 700; }
        .roommate-card { display: flex; background: #FFFFFF; border: 1px solid #E5E5E5; border-radius: 12px; overflow: hidden; margin-bottom: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .roommate-photo { width: 150px; object-fit: cover; }
        .roommate-info { padding: 20px; flex: 1; }
        .roommate-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px; }
        .roommate-name { font-size: 18px; color: #1A3D0A; font-weight: bold; margin: 0; }
        .roommate-bed-tag { background: #F2F5EB; color: #1A3D0A; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; border: 1px solid #C3C9BA; }
        .roommate-role { font-size: 13px; color: #6CA16C; margin: 0 0 12px 0; font-weight: 500; }
        .roommate-desc { font-size: 13px; color: #43493E; line-height: 1.5; margin: 0 0 16px 0; }
        .roommate-tags { display: flex; gap: 8px; flex-wrap: wrap; }
        .roommate-tag { background: #F6F6F1; color: #43493E; padding: 4px 10px; border-radius: 100px; font-size: 11px; border: 1px solid #E5E5E5; }

        /* CUSTOM LIVE FOOTER */
        .custom-live-footer { position: fixed; bottom: 0; left: 0; width: 100%; background: #FFFFFF; border-top: 1px solid #E5E5E5; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); z-index: 999; display: flex; flex-direction: column; align-items: center; padding: 20px; }
        .footer-breakdown { width: 100%; max-width: 600px; display: none; flex-direction: column; gap: 8px; margin-bottom: 16px; border-bottom: 2px solid #1A3D0A; padding-bottom: 16px; }
        .breakdown-row { display: flex; justify-content: space-between; font-size: 14px; color: #43493E; }
        .breakdown-row.total-row { font-weight: bold; color: #1A3D0A; font-size: 16px; margin-top: 8px; }
        .footer-actions { display: flex; gap: 12px; justify-content: center; }
        .btn-footer { padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 15px; cursor: pointer; transition: 0.2s; border: none; }
        .btn-footer.back { background: #6CA16C; color: white; }
        .btn-footer.continue { background: #D9864A; color: white; }
        .btn-footer.continue:disabled { background: #C3C9BA; cursor: not-allowed; }
        body { padding-bottom: 180px; } 
    </style>
</head>
<body>

@include('components.navbar')

<main class="bed-room-page">
    <div class="bed-room-container">
        
        {{-- Booking Stepper --}}
        <x-booking-stepper :currentStep="3" />

        {{--
            data-en / data-id dipakai oleh AlasLang (engine di navbar).
            Atribut ini cukup ditambahkan ke elemen teks — AlasLang akan
            mengganti textContent secara otomatis saat bahasa berubah.
        --}}
        <x-booking-header 
            title="Choose Your Private Space" 
            subtitle="We provide beds/rooms with the best facilities for your comfort." 
            data-en-title="Choose Your Private Space"
            data-id-title="Pilih Ruang Pribadimu"
            data-en-subtitle="We provide beds/rooms with the best facilities for your comfort."
            data-id-subtitle="Kami menyediakan kasur/kamar dengan fasilitas terbaik untuk kenyamananmu."
        />

        @php
            use Carbon\Carbon;
            
            // 1. Tangkap parameter dari URL
            $checkInParam = request()->query('check_in');
            $checkOutParam = request()->query('check_out');
            $nightsParam = request()->query('nights', 0);
            $guestsParam = request()->query('guests', '1a0c');
            $promoParam = request()->query('promo', '');
            $monthParam = request()->query('month', '');
            $bedIdParam = request()->query('bed_id', ''); // Tangkap bed_id jika user kembali dari halaman guest-details

            $displayCheckIn = $checkInParam ? Carbon::parse($checkInParam)->format('d/m/Y') : '--/--/----';
            $displayCheckOut = $checkOutParam ? Carbon::parse($checkOutParam)->format('d/m/Y') : '--/--/----';

            $queryParams = http_build_query(request()->except(['bed_id', 'addons'])); // Hapus addons/bed untuk tombol Back ke Room
            $backToRoomUrl = url('/room-selection') . '?' . $queryParams;

            // ==========================================
            // LOGIKA ADDON OTOMATIS BERDASARKAN CHECK-IN
            // ==========================================
            $checkInDateObj = $checkInParam ? Carbon::parse($checkInParam) : Carbon::now();
            $checkInDayName = $checkInDateObj->format('l'); 
            
            // Tangkap Addon dari URL jika user menekan tombol "Back"
            $hasAddonsInUrl = request()->has('addons');
            $addonsFromUrl = $hasAddonsInUrl ? array_filter(explode(',', request()->query('addons'))) : [];

            $availableAddons = \App\Models\Addon::where('is_active', true)->get();
            $formattedAddons = [];

            foreach($availableAddons as $addon) {
                $isFreeToday = false;
                $hasSpecificDays = !empty($addon->include_days) && is_array($addon->include_days);

                if ($addon->is_auto_include && $hasSpecificDays) {
                    if (in_array($checkInDayName, $addon->include_days)) {
                        $isFreeToday = true;
                    } else {
                        continue; // Lewati jika addon ini khusus hari tertentu, tapi bukan hari ini
                    }
                }

                // Cek status Checked: Prioritaskan dari URL jika ada, jika tidak ikuti auto_include hari ini
                if ($hasAddonsInUrl) {
                    $isChecked = in_array($addon->id, $addonsFromUrl);
                } else {
                    $isChecked = $isFreeToday;
                }

                $formattedAddons[] = [
                    'id' => $addon->id,
                    'name' => $addon->name,
                    'note' => $isFreeToday ? ($addon->note ?? '(for free)') : $addon->note,
                    'note_id' => $isFreeToday ? ($addon->note_id ?? '(gratis)') : $addon->note_id,
                    'price' => $addon->price, 
                    'display_price' => 'IDR ' . number_format($addon->price, 0, ',', '.'),
                    'discount' => $isFreeToday ? '- IDR ' . number_format($addon->discount ?? $addon->price, 0, ',', '.') : null,
                    'actual_cost' => $isFreeToday ? 0 : $addon->price, 
                    'checked' => $isChecked, 
                ];
            }

            // ==========================================
            // LOGIKA PENGECEKAN KASUR TERISI (ROOMMATES)
            // ==========================================
            $occupiedBeds = [];
            $roommatesData = [];

            if ($checkInParam && $checkOutParam) {
                $overlappingBookings = \App\Models\Booking::where('room_id', $room->id)
                    ->whereIn('status', ['CONFIRMED', 'PENDING'])
                    ->where(function($query) use ($checkInParam, $checkOutParam) {
                        $query->where('check_in_date', '<', $checkOutParam)
                              ->where('check_out_date', '>', $checkInParam);
                    })
                    ->get();

                foreach($overlappingBookings as $booking) {
                    if ($booking->bed_id) {
                        $guest = \App\Models\Guest::where('booking_code', $booking->booking_code)->first();
                        $bedInfo = \App\Models\Bed::find($booking->bed_id);
                        
                        if ($guest && $bedInfo) {
                            $occupiedBeds[$booking->bed_id] = $guest;
                            $roommatesData[] = [
                                'name' => $guest->first_name . ' ' . $guest->last_name,
                                'age' => $guest->age,
                                'occupation' => $guest->occupation,
                                'desc' => $guest->self_description,
                                'bed_name' => $bedInfo->name,
                                'avatar' => asset('images/sharedroom/' . ($guest->id % 2 == 0 ? 'liam.png' : 'julian.png')),
                                'tags' => explode(',', 'Traveler,Backpacker')
                            ];
                        }
                    }
                }
            }

            // ==========================================
            // LOGIKA GROUPING KASUR BERDASARKAN PIN
            // ==========================================
            $groupedPoints = [];
            foreach($room->beds as $bed) {
                $pin = $bed->bedPin;
                if($pin && $pin->position_top && $pin->position_left) {
                    $label = $pin->point_label ?: 'Unknown';
                    if(!isset($groupedPoints[$label])) {
                        $groupedPoints[$label] = [
                            'top' => $pin->position_top,
                            'left' => $pin->position_left,
                            'beds' => []
                        ];
                    }
                    $groupedPoints[$label]['beds'][] = $bed;
                }
            }
        @endphp

        {{-- SUMMARY BAR INTERAKTIF --}}
        <div class="calendar-summary-bar" style="margin-bottom: 40px;">
            <div class="summary-inputs">
                <div class="summary-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span data-en="Check-in:" data-id="Tgl Masuk:">Check-in:</span>
                        <input type="date" id="checkinInput" value="{{ $checkInParam }}" style="border: none; outline: none; background: transparent; font-weight: 600; color: inherit; font-family: inherit; font-size: 14px; cursor: pointer;">
                    </span>
                </div>
                <div class="divider"></div>
                <div class="summary-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span data-en="Check-out:" data-id="Tgl Keluar:">Check-out:</span>
                        <input type="date" id="checkoutInput" value="{{ $checkOutParam }}" style="border: none; outline: none; background: transparent; font-weight: 600; color: inherit; font-family: inherit; font-size: 14px; cursor: pointer;">
                    </span>
                </div>
                <div class="divider"></div>
                <div class="summary-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <select id="guestSelect" style="border: none; outline: none; background: transparent; font-weight: 600; color: inherit; font-size: 14px; cursor: pointer; max-width: 200px;">
                        {{-- Teks option diterjemahkan via JS (lihat bagian <script> di bawah) --}}
                        <option value="1a0c" {{ $guestsParam == '1a0c' ? 'selected' : '' }}
                            data-en="1 Male Adult, 0 Children" data-id="1 Dewasa Pria, 0 Anak">1 Male Adult, 0 Children</option>
                        <option value="1f0c" {{ $guestsParam == '1f0c' ? 'selected' : '' }}
                            data-en="1 Female Adult, 0 Children" data-id="1 Dewasa Wanita, 0 Anak">1 Female Adult, 0 Children</option>
                        <option value="2a1c" {{ $guestsParam == '2a1c' ? 'selected' : '' }}
                            data-en="2 Male Adults, 1 Child" data-id="2 Dewasa Pria, 1 Anak">2 Male Adults, 1 Child</option>
                        <option value="2f1c" {{ $guestsParam == '2f1c' ? 'selected' : '' }}
                            data-en="2 Female Adults, 1 Child" data-id="2 Dewasa Wanita, 1 Anak">2 Female Adults, 1 Child</option>
                        <option value="2a2c" {{ $guestsParam == '2a2c' ? 'selected' : '' }}
                            data-en="2 Male Adults, 2 Children" data-id="2 Dewasa Pria, 2 Anak">2 Male Adults, 2 Children</option>
                        <option value="2f2c" {{ $guestsParam == '2f2c' ? 'selected' : '' }}
                            data-en="2 Female Adults, 2 Children" data-id="2 Dewasa Wanita, 2 Anak">2 Female Adults, 2 Children</option>
                    </select>
                </div>
            </div>
            
            <div class="promo-section">
                <div class="promo-input-wrapper">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D37D4F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    <input type="text" id="promoCode" placeholder="Apply Promo Code" data-placeholder-en="Apply Promo Code" data-placeholder-id="Masukkan Kode Promo" value="{{ $promoParam }}">
                </div>
                <a href="#" id="btnApplyPromo" class="apply-btn" style="{{ $promoParam ? 'color: #D37D4F;' : '' }}"
                   data-en="{{ $promoParam ? 'Applied' : 'Apply' }}"
                   data-id="{{ $promoParam ? 'Diterapkan' : 'Terapkan' }}">
                    {{ $promoParam ? 'Applied' : 'Apply' }}
                </a>
            </div>
        </div>

        {{-- Room Detail Card --}}
        <div class="room-section-header">
            <h2 class="room-section-title">
                <span data-en="Room" data-id="Kamar">Room</span>&nbsp;{{ $room->name }}
            </h2>
            <span class="room-type-tag">
                <span data-en="Room Type:" data-id="Tipe Kamar:">Room Type:</span>
                {{ $room->gender_type == 'Mixed' ? 'Mixed Dorm' : $room->gender_type . ' Only' }}
            </span>
        </div>

        <div class="room-detail-card">
            <div class="room-detail-image-wrap">
                <img src="{{ $room->photo ? asset('storage/' . $room->photo) : asset('images/default-room.png') }}" alt="{{ $room->name }}" class="room-detail-image">
                @if(strtolower($room->gender_type) != 'mixed')
                    <span class="male-only-badge" @if($room->gender_type == 'Female') style="background: rgba(192, 124, 77, 0.9);" @endif>
                        {{ strtoupper($room->gender_type) }} ONLY
                    </span>
                @endif
            </div>
            <div class="room-detail-info">
                <h3 class="room-detail-title">{{ $room->name }}</h3>
                <p class="room-detail-desc">{{ $room->description }}</p>
                <div class="room-detail-features">
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span>
                            {{ $room->capacity }}
                            <span data-en="Person Capacity" data-id="Kapasitas Orang">Person Capacity</span>
                        </span>
                    </div>
                    @php $facilities = $room->main_facilities ? explode(',', $room->main_facilities) : []; @endphp
                    @foreach($facilities as $facility)
                        <div class="feature-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                            <span>{{ trim($facility) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Floor Plan Section --}}
        <div class="floor-plan-section">
            <div class="floor-plan-interactive-wrapper" style="position: relative; display: inline-block; width: 100%; max-width: 100%;">
                <img src="{{ $room->layout_photo ? asset('storage/' . $room->layout_photo) : asset('images/sharedroom/serene-haven-floorplan.png') }}" alt="Floor Plan" class="floor-plan-image" style="display: block; width: 100%; height: auto;">
                
                {{-- Looping Berdasarkan Titik Pin --}}
                @foreach($groupedPoints as $label => $point)
                    @php
                        $isAnyAvailable = false;
                        foreach($point['beds'] as $bed) {
                            $isMaintenance = strtolower($bed->status) !== 'available';
                            $isBooked = isset($occupiedBeds[$bed->id]);
                            if (!$isMaintenance && !$isBooked) {
                                $isAnyAvailable = true;
                                break;
                            }
                        }
                    @endphp

                    <div class="bed-hotspot bed-selectable-wrapper" style="position: absolute; top: {{ $point['top'] }}; left: {{ $point['left'] }}; transform: translate(-50%, -50%); width: 30px; height: 30px; z-index: 10;">
                        <div class="hotspot-indicator" style="width: 100%; height: 100%; border-radius: 50%; background-color: {{ $isAnyAvailable ? '#D9864A' : '#dc3545' }}; border: 2px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.4);"></div>
                        
                        <div class="hotspot-popup-container popup-right">
                            <div class="custom-bed-popup">
                                <div style="background: #F2F5EB; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E5E5E5;">
                                    <h3 style="margin:0; font-size:16px; color:#1A3D0A;">
                                        <span data-en="BED UNIT" data-id="UNIT KASUR">BED UNIT</span> {{ $label }}
                                    </h3>
                                    <span style="background: {{ $isAnyAvailable ? '#1A3D0A' : '#C3C9BA' }}; color: white; padding: 4px 8px; font-size: 10px; font-weight: bold; border-radius: 4px;"
                                          data-en="{{ $isAnyAvailable ? 'AVAILABLE' : 'FULL' }}"
                                          data-id="{{ $isAnyAvailable ? 'TERSEDIA' : 'PENUH' }}">
                                        {{ $isAnyAvailable ? 'AVAILABLE' : 'FULL' }}
                                    </span>
                                </div>

                                <div style="padding: 16px;">
                                    @foreach($point['beds'] as $bed)
                                        @php
                                            $isMaintenance = strtolower($bed->status) !== 'available';
                                            $isBooked = isset($occupiedBeds[$bed->id]);
                                            $isAvailToBook = !$isMaintenance && !$isBooked;

                                            $price = $bed->base_price > 0 ? $bed->base_price : ($room->base_price ?? 125000);
                                            $formattedPrice = 'IDR ' . number_format($price, 0, ',', '.');
                                            $iconDir = stripos($bed->position, 'top') !== false ? '↑' : '↓';
                                        @endphp
                                        <div style="display:flex; align-items:flex-start; margin-bottom: 16px;">
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #F2F5EB; color: #1A3D0A; display:flex; align-items:center; justify-content:center; margin-right:12px; font-weight:bold;">{{ $iconDir }}</div>
                                            <div style="flex: 1;">
                                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                                    <span style="font-weight:bold; color:#1A3D0A; font-size:15px;">{{ $bed->name }}</span>
                                                    
                                                    @if($isMaintenance)
                                                        <button type="button" class="bed-select-btn state-maintenance" disabled
                                                                data-en="MAINTENANCE" data-id="PERBAIKAN">MAINTENANCE</button>
                                                    @elseif($isBooked)
                                                        <button type="button" class="bed-select-btn state-occupied" disabled
                                                                data-en="OCCUPIED" data-id="TERISI">OCCUPIED</button>
                                                    @else
                                                        <button type="button" 
                                                                class="bed-select-btn state-select" 
                                                                data-bed-id="{{ $bed->id }}" 
                                                                data-bed-name="{{ $bed->name }}" 
                                                                data-bed-price="{{ $price }}"
                                                                data-en="SELECT" data-id="PILIH">
                                                            SELECT
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                @if($isMaintenance)
                                                    <div style="font-size:12px; color:#dc3545; margin-top:4px;"
                                                         data-en="Currently unavailable" data-id="Saat ini tidak tersedia">Currently unavailable</div>
                                                @elseif($isAvailToBook)
                                                    <div style="font-size:12px; color:#43493E; margin-top:4px;">
                                                        {{ $formattedPrice }} <span data-en="/nights" data-id="/malam">/nights</span>
                                                    </div>
                                                @elseif($isBooked)
                                                    @php $guest = $occupiedBeds[$bed->id]; @endphp
                                                    <div style="display:flex; align-items:center; margin-top:8px;">
                                                        <img src="{{ asset('images/sharedroom/' . ($guest->id % 2 == 0 ? 'liam.png' : 'julian.png')) }}" style="width:36px; height:36px; border-radius:50%; margin-right:10px; object-fit:cover;">
                                                        <div>
                                                            <div style="font-size:14px; font-weight:bold; color:#1A3D0A;">{{ $guest->first_name . ' ' . $guest->last_name }}</div>
                                                            <div style="font-size:12px; color:#6CA16C;"
                                                                 data-en="Occupied" data-id="Terisi">Occupied</div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if(count($formattedAddons) > 0)
                                    <hr style="border:none; border-top:1px solid #E5E5E5; margin:0;">
                                    <div style="padding: 16px;">
                                        @foreach($formattedAddons as $addon)
                                            <div class="addon-row-wrapper" 
                                                 data-addon-id="{{ $addon['id'] }}" 
                                                 data-addon-name="{{ $addon['name'] }}" 
                                                 data-addon-cost="{{ $addon['actual_cost'] }}" 
                                                 data-addon-note="{{ $addon['note'] }}"
                                                 data-addon-note-id="{{ $addon['note_id'] ?? $addon['note'] }}">
                                                <div class="alasare-box {{ $addon['checked'] ? 'is-on' : 'is-off' }}" style="margin-right:12px;">
                                                    <svg class="check-icon" style="display: {{ $addon['checked'] ? 'block' : 'none' }}; width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                </div>
                                                <div>
                                                    <div style="font-weight:bold; color:#1A3D0A; font-size:14px;">
                                                        {{ $addon['name'] }}
                                                        <span class="addon-note-text" style="font-weight:normal; color:#B8D9A0;"
                                                              data-en="{{ $addon['note'] }}"
                                                              data-id="{{ $addon['note_id'] ?? $addon['note'] }}">{{ $addon['note'] }}</span>
                                                    </div>
                                                    <div style="font-size:12px; color:#43493E; margin-top:2px;">
                                                        {{ $addon['display_price'] }} <span data-en="/pack" data-id="/paket">/pack</span>
                                                        @if(isset($addon['discount']))
                                                            <br><span style="color:#D9864A;">{{ $addon['discount'] }} <span data-en="/pack" data-id="/paket">/pack</span></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Room Rules Section --}}
        <div class="room-rules-section">
            <div class="rules-banner-wrap">
                <img src="{{ asset('images/sharedroom/locker.png') }}" alt="Secure storage locker" class="rules-banner">
                <span class="rules-secure-badge" data-en="Secure Storage" data-id="Penyimpanan Aman">Secure Storage</span>
            </div>
            <div class="rules-content">
                <h3 class="rules-title" data-en="Room Rules" data-id="Peraturan Kamar">Room Rules</h3>
                <ul class="rules-list">
                    <li class="rule-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>
                        <span data-en="Quiet hours (22:00 - 07:00)" data-id="Jam tenang (22:00 - 07:00)">Quiet hours (22:00 - 07:00)</span>
                    </li>
                    <li class="rule-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                        <span data-en="Strictly no smoking" data-id="Dilarang keras merokok">Strictly no smoking</span>
                    </li>
                    <li class="rule-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span data-en="One person per bed" data-id="Satu orang per kasur">One person per bed</span>
                    </li>
                </ul>
            </div>
        </div>
        
        {{-- ROOMMATES SECTION --}}
        @if(count($roommatesData) > 0)
            <div class="roommates-section">
                <h3 class="section-title" data-en="Meet Your Future Roommates" data-id="Kenali Calon Teman Sekamar">Meet Your Future Roommates</h3>
                <div class="roommates-row-container">
                    @foreach($roommatesData as $mate)
                        <div class="roommate-card">
                            <img src="{{ $mate['avatar'] }}" alt="{{ $mate['name'] }}" class="roommate-photo">
                            <div class="roommate-info">
                                <div class="roommate-header-row">
                                    <h4 class="roommate-name">{{ $mate['name'] }}</h4>
                                    <span class="roommate-bed-tag">
                                        <span data-en="Bed:" data-id="Kasur:">Bed:</span> {{ $mate['bed_name'] }}
                                    </span>
                                </div>
                                <p class="roommate-role">
                                    {{ $mate['age'] }} <span data-en="years old" data-id="tahun">years old</span> &bull; {{ $mate['occupation'] }}
                                </p>
                                <p class="roommate-desc">{{ $mate['desc'] }}</p>
                                <div class="roommate-tags">
                                    @foreach($mate['tags'] as $tag)
                                        <span class="roommate-tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</main>

{{-- CUSTOM LIVE FOOTER CALCULATOR --}}
<div class="custom-live-footer">
    <div class="footer-breakdown" id="footerBreakdown">
        <!-- JS Mengisi Rincian Harga Disini -->
    </div>
    <div class="footer-actions">
        <a href="{!! $backToRoomUrl !!}" class="btn-footer back" id="btnBackFooter"
           data-en="Back To Calendar" data-id="Kembali ke Kalender">Back To Calendar</a>
        <a href="#" class="btn-footer continue" id="btnContinueFooter" disabled
           data-en="Continue To Details" data-id="Lanjut ke Detail">Continue To Details</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkinInput = document.getElementById('checkinInput');
    const checkoutInput = document.getElementById('checkoutInput');
    const guestSelect = document.getElementById('guestSelect');
    const promoCode = document.getElementById('promoCode');
    const btnApplyPromo = document.getElementById('btnApplyPromo');
    const footerBreakdown = document.getElementById('footerBreakdown');
    const btnBackFooter = document.getElementById('btnBackFooter');
    const btnContinueFooter = document.getElementById('btnContinueFooter');

    let currentCheckIn = "{{ $checkInParam }}";
    let currentCheckOut = "{{ $checkOutParam }}";
    let currentNights = parseInt("{{ $nightsParam }}") || 0;
    let appliedPromoCode = "{{ $promoParam }}";
    const month = "{{ $monthParam }}";
    const roomId = "{{ $room->id }}";
    const roomName = "{{ $room->name }}";
    
    // TANGKAP STATE DARI URL (Jika User Kembali)
    let selectedBedId = "{{ $bedIdParam }}";
    let selectedBedName = "";
    let selectedBedPrice = 0;
    
    let activeAddons = {!! json_encode($formattedAddons) !!}; 
    let selectedAddonsList = activeAddons.filter(a => a.checked).map(a => a.id);

    const formatRp = (angka) => 'IDR ' + new Intl.NumberFormat('id-ID').format(angka);

    // ─── Helper: teks berdasarkan bahasa aktif ────────────────────────────
    function t(en, id) {
        return (window.AlasLang && window.AlasLang.current() === 'id') ? id : en;
    }

    // ─── Terjemahan teks tombol kasur berdasarkan state ──────────────────
    const BED_BTN_TEXT = {
        select:   { en: 'SELECT',      id: 'PILIH' },
        selected: { en: 'SELECTED',    id: 'DIPILIH' },
    };

    // ─── Terjemahan teks footer breakdown ────────────────────────────────
    const FOOTER_TEXT = {
        estTotal: { en: 'EST.TOTAL', id: 'ESTIMASI TOTAL' },
        nights:   { en: '/night',    id: '/malam' },
    };

    // ─── Terjemahan alert ────────────────────────────────────────────────
    const ALERTS = {
        selectBedFirst:    { en: 'Please select a bed (SELECT) from the floor plan first!',          id: 'Silakan pilih salah satu kasur (PILIH) terlebih dahulu dari denah kamar!' },
        checkoutBeforeIn:  { en: 'Oops! Check-out date must be after Check-in!',                     id: 'Ups! Tanggal Check-out harus lebih besar dari Check-in!' },
        promoApplied:      { en: `Promo Code "${appliedPromoCode}" has been applied!`,               id: `Kode Promo "${appliedPromoCode}" telah diterapkan!` },
        promoRemoved:      { en: 'Promo Code removed.',                                              id: 'Kode Promo dihapus.' },
        promoAppliedBtn:   { en: 'Applied',   id: 'Diterapkan' },
        promoApplyBtn:     { en: 'Apply',     id: 'Terapkan' },
    };

    // ─── Sinkronkan placeholder input promo ──────────────────────────────
    function syncPromoPlaceholder() {
        if (promoCode) {
            promoCode.placeholder = t(
                promoCode.getAttribute('data-placeholder-en') || 'Apply Promo Code',
                promoCode.getAttribute('data-placeholder-id') || 'Masukkan Kode Promo'
            );
        }
    }
    syncPromoPlaceholder();

    // ─── Dengarkan perubahan bahasa dari AlasLang ─────────────────────────
    document.addEventListener('alas:langchange', function(e) {
        syncPromoPlaceholder();
        // Re-render footer breakdown agar teks "EST.TOTAL" ikut berubah
        renderFooter();
        // Update teks tombol kasur yang sudah dipilih
        document.querySelectorAll('.bed-select-btn.state-selected').forEach(btn => {
            btn.textContent = t(BED_BTN_TEXT.selected.en, BED_BTN_TEXT.selected.id);
        });
        document.querySelectorAll('.bed-select-btn.state-select').forEach(btn => {
            btn.textContent = t(BED_BTN_TEXT.select.en, BED_BTN_TEXT.select.id);
        });
    });

    // KUNCI PERBAIKAN: AUTO-SELECT Kasur berdasarkan parameter URL
    if (selectedBedId) {
        const preSelectedBtn = document.querySelector(`.bed-select-btn[data-bed-id="${selectedBedId}"]`);
        if (preSelectedBtn && !preSelectedBtn.classList.contains('state-occupied') && !preSelectedBtn.classList.contains('state-maintenance')) {
            preSelectedBtn.classList.remove('state-select');
            preSelectedBtn.classList.add('state-selected');
            preSelectedBtn.textContent = t(BED_BTN_TEXT.selected.en, BED_BTN_TEXT.selected.id);
            selectedBedName = preSelectedBtn.getAttribute('data-bed-name');
            selectedBedPrice = parseFloat(preSelectedBtn.getAttribute('data-bed-price'));
        } else {
            selectedBedId = null; // Reset jika tidak valid atau sudah dibooking orang lain
        }
    }

    function renderFooter() {
        if (!selectedBedId) {
            footerBreakdown.style.display = 'none';
            btnContinueFooter.setAttribute('disabled', 'true');
            btnContinueFooter.style.cursor = 'not-allowed';
            btnContinueFooter.style.background = '#C3C9BA';
            return;
        }

        let totalBedCost = selectedBedPrice * currentNights;
        let grandTotal = totalBedCost;

        let html = `
            <div class="breakdown-row">
                <span style="text-transform: uppercase; font-weight: 500;">${roomName} - ${selectedBedName}</span>
                <span>${formatRp(totalBedCost)}</span>
            </div>
        `;

        selectedAddonsList.forEach(id => {
            let addonObj = activeAddons.find(a => a.id === id);
            if(addonObj) {
                let actualCostNumber = parseFloat(addonObj.actual_cost) || 0;
                grandTotal += actualCostNumber;
                
                // Gunakan note_id jika bahasa Indonesia
                let noteText = (window.AlasLang && window.AlasLang.current() === 'id')
                    ? (addonObj.note_id || addonObj.note || '')
                    : (addonObj.note || '');

                let priceText = actualCostNumber > 0 ? formatRp(actualCostNumber) : '';
                html += `
                    <div class="breakdown-row">
                        <span style="text-transform: uppercase; font-weight: 500;">
                            ${addonObj.name} 
                            <span style="color:#B8D9A0; font-size:12px; font-weight: bold; text-transform: lowercase;">${noteText}</span>
                        </span>
                        <span>${priceText}</span>
                    </div>
                `;
            }
        });

        html += `
            <div class="breakdown-row total-row">
                <span style="text-transform: uppercase;">${t(FOOTER_TEXT.estTotal.en, FOOTER_TEXT.estTotal.id)}</span>
                <span>${formatRp(grandTotal)}</span>
            </div>
        `;

        footerBreakdown.innerHTML = html;
        footerBreakdown.style.display = 'flex';
        
        btnContinueFooter.removeAttribute('disabled');
        btnContinueFooter.style.cursor = 'pointer';
        btnContinueFooter.style.background = '#D9864A';
    }

    function syncLinks() {
        const currentGuestVal = guestSelect ? guestSelect.value : "{{ $guestsParam }}";
        const addonsQuery = selectedAddonsList.join(','); 
        
        const queryParams = `?check_in=${currentCheckIn}&check_out=${currentCheckOut}&nights=${currentNights}&guests=${currentGuestVal}&promo=${appliedPromoCode}&month=${month}&addons=${addonsQuery}`;

        // Jangan kirim bed_id dan addons ke halaman sebelumnya (kalender/room selection)
        const baseBackUrl = btnBackFooter.getAttribute('href').split('?')[0];
        btnBackFooter.setAttribute('href', baseBackUrl + queryParams);

        // KUNCI PERBAIKAN: Masukkan state addons dan bed ke URL Continue
        let finalUrl = `/guest-details${queryParams}&room_id=${roomId}`;
        if (selectedBedId) {
            finalUrl += `&bed_id=${selectedBedId}`;
        }
        btnContinueFooter.setAttribute('href', finalUrl);
        
        renderFooter();
    }
    syncLinks(); 

    function updateNights() {
        if(checkinInput.value && checkoutInput.value) {
            const start = new Date(checkinInput.value);
            const end = new Date(checkoutInput.value);
            if(end > start) {
                currentCheckIn = checkinInput.value;
                currentCheckOut = checkoutInput.value;
                currentNights = Math.ceil(Math.abs(end - start) / (1000 * 60 * 60 * 24));
                
                // Reload dan Bawa semua state (termasuk bed & addons) agar tidak hilang
                const addonsQuery = selectedAddonsList.join(','); 
                window.location.href = window.location.pathname + `?check_in=${currentCheckIn}&check_out=${currentCheckOut}&nights=${currentNights}&guests=${guestSelect.value}&promo=${appliedPromoCode}&month=${month}&room_id=${roomId}&bed_id=${selectedBedId || ''}&addons=${addonsQuery}`;
            } else {
                alert(t(ALERTS.checkoutBeforeIn.en, ALERTS.checkoutBeforeIn.id));
                checkoutInput.value = currentCheckOut;
            }
        }
    }

    if(checkinInput) checkinInput.addEventListener('change', updateNights);
    if(checkoutInput) checkoutInput.addEventListener('change', updateNights);
    if(guestSelect) guestSelect.addEventListener('change', syncLinks);

    if (btnApplyPromo) {
        btnApplyPromo.addEventListener('click', function(e) {
            e.preventDefault();
            const rawValue = promoCode.value.trim();
            if (rawValue !== '') {
                appliedPromoCode = rawValue;
                btnApplyPromo.textContent = t(ALERTS.promoAppliedBtn.en, ALERTS.promoAppliedBtn.id);
                btnApplyPromo.style.color = '#D37D4F';
                // Sinkronkan atribut data agar AlasLang bisa menggantinya nanti
                btnApplyPromo.setAttribute('data-en', ALERTS.promoAppliedBtn.en);
                btnApplyPromo.setAttribute('data-id', ALERTS.promoAppliedBtn.id);
                syncLinks(); 
                alert(t(
                    `Promo Code "${appliedPromoCode}" has been applied!`,
                    `Kode Promo "${appliedPromoCode}" telah diterapkan!`
                ));
            } else {
                appliedPromoCode = '';
                btnApplyPromo.textContent = t(ALERTS.promoApplyBtn.en, ALERTS.promoApplyBtn.id);
                btnApplyPromo.style.color = '';
                btnApplyPromo.setAttribute('data-en', ALERTS.promoApplyBtn.en);
                btnApplyPromo.setAttribute('data-id', ALERTS.promoApplyBtn.id);
                syncLinks(); 
                alert(t(ALERTS.promoRemoved.en, ALERTS.promoRemoved.id));
            }
        });
    }

    document.querySelectorAll('.bed-hotspot').forEach(function(hotspot){
        var popup = hotspot.querySelector('.hotspot-popup-container');
        if(!popup) return;
        var hideTimer = null;

        function show() { popup.classList.add('visible'); clearTimeout(hideTimer); }
        function scheduleHide() {
            clearTimeout(hideTimer);
            hideTimer = setTimeout(function(){
                if(!hotspot.matches(':hover') && !popup.matches(':hover')){
                    popup.classList.remove('visible');
                }
            }, 180);
        }

        hotspot.addEventListener('mouseenter', show);
        hotspot.addEventListener('mouseleave', scheduleHide);
        popup.addEventListener('mouseenter', function(){ clearTimeout(hideTimer); popup.classList.add('visible'); });
        popup.addEventListener('mouseleave', scheduleHide);

        popup.querySelectorAll('.bed-select-btn').forEach(function(btn){
            btn.addEventListener('click', function(){
                if(btn.classList.contains('state-occupied') || btn.classList.contains('state-maintenance')) return;

                if(btn.classList.contains('state-select')){
                    // Deselect semua tombol lain
                    document.querySelectorAll('.bed-select-btn.state-selected').forEach(b => {
                        b.classList.remove('state-selected');
                        b.classList.add('state-select');
                        b.textContent = t(BED_BTN_TEXT.select.en, BED_BTN_TEXT.select.id);
                    });

                    btn.classList.remove('state-select');
                    btn.classList.add('state-selected');
                    btn.textContent = t(BED_BTN_TEXT.selected.en, BED_BTN_TEXT.selected.id);
                    
                    selectedBedId = btn.getAttribute('data-bed-id');
                    selectedBedName = btn.getAttribute('data-bed-name');
                    selectedBedPrice = parseFloat(btn.getAttribute('data-bed-price'));

                } else {
                    btn.classList.remove('state-selected');
                    btn.classList.add('state-select');
                    btn.textContent = t(BED_BTN_TEXT.select.en, BED_BTN_TEXT.select.id);
                    
                    selectedBedId = null; 
                    selectedBedName = "";
                    selectedBedPrice = 0;
                }
                syncLinks(); 
            });
        });

        popup.querySelectorAll('.addon-row-wrapper').forEach(function(row){
            row.addEventListener('click', function(e){
                e.stopPropagation();
                const addonId = parseInt(this.getAttribute('data-addon-id'));
                const checkbox = this.querySelector('.alasare-box');
                const isCurrentlyOn = checkbox.classList.contains('is-on');

                if (isCurrentlyOn) {
                    selectedAddonsList = selectedAddonsList.filter(id => id !== addonId);
                } else {
                    if (!selectedAddonsList.includes(addonId)) selectedAddonsList.push(addonId);
                }

                document.querySelectorAll(`.addon-row-wrapper[data-addon-id="${addonId}"]`).forEach(el => {
                    const box = el.querySelector('.alasare-box');
                    const icon = el.querySelector('.check-icon');
                    if(isCurrentlyOn) {
                        box.classList.replace('is-on', 'is-off');
                        icon.style.display = 'none';
                    } else {
                        box.classList.replace('is-off', 'is-on');
                        icon.style.display = 'block';
                    }
                });

                syncLinks(); 
            });
        });
    });

    btnContinueFooter.addEventListener('click', function(e) {
        if (!selectedBedId) {
            e.preventDefault(); 
            alert(t(ALERTS.selectBedFirst.en, ALERTS.selectBedFirst.id));
        }
    });
});
</script>

</body>
</html>