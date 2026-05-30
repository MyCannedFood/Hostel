{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/featured-rooms.blade.php --}}

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Featured Rooms</h2>

@php
$selectedRooms = [
    ['id'=>1,'image'=>null,'name'=>'Serene Haven','gender'=>'MALE ONLY',
     'beds'=>8,'desc'=>'A functional and minimalist space designed for maximum comfort and simplicity.'],
    ['id'=>2,'image'=>null,'name'=>'Botanica','gender'=>'MALE ONLY',
     'beds'=>6,'desc'=>'A refreshing tropical theme adorned with beautiful Brazilian Fern and bamboo interior decorations.'],
    ['id'=>3,'image'=>null,'name'=>'The Heritage','gender'=>'FEMALE ONLY',
     'beds'=>8,'desc'=>'A serene tropical theme identical to The Teak Nest, featuring lush Brazilian Fern and bamboo decorations.'],
];
@endphp

{{-- ── Section Info ── --}}
<div class="lp-card">
    <div class="lp-field">
        <label class="lp-field-label">Section Title</label>
        <input type="text" class="lp-input lp-heading-input" name="title" value="Sanctuaries">
    </div>
    <div class="lp-field">
        <label class="lp-field-label">Section Description</label>
        <input type="text" class="lp-input" name="description"
               value="Each villa possesses a unique soul, crafted from reclaimed teak and designed to frame the forest.">
    </div>
</div>

{{-- ── Selected Rooms ── --}}
<div class="lp-card">
    <p class="lp-card-label" style="margin-bottom:16px;">
        Selected Rooms ({{ count($selectedRooms) }})
    </p>

    @foreach($selectedRooms as $room)
    <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid #f0f4ee;">
        @if($room['image'])
            <img src="{{ asset('storage/'.$room['image']) }}" alt="{{ $room['name'] }}"
                 style="width:80px;height:64px;border-radius:8px;object-fit:cover;flex-shrink:0;">
        @else
            <div style="width:80px;height:64px;border-radius:8px;background:#e8ede8;flex-shrink:0;"></div>
        @endif
        <div style="flex:1;min-width:0;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px;">
                <span style="font-size:14px;font-weight:700;color:#1a3d0a;">{{ $room['name'] }}</span>
                <span style="font-size:10px;font-weight:700;letter-spacing:.5px;padding:2px 8px;border-radius:4px;
                    {{ $room['gender']==='MALE ONLY' ? 'background:#dbeafe;color:#1e40af;' : 'background:#fce7f3;color:#9d174d;' }}">
                    [{{ $room['gender'] }}]
                </span>
            </div>
            {{-- Amenity icons --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;color:#7a857f;font-size:12px;">
                <span title="Wi-Fi">📶 wi-fi</span>
                <span title="AC">❄ ac</span>
                <span title="Locker">🔒 locker</span>
                <span title="Sharing">🤝 Sharing</span>
                <span title="Beds">🛏 {{ $room['beds'] }} beds</span>
            </div>
            <div style="font-size:12px;color:#7a857f;line-height:1.5;">{{ $room['desc'] }}</div>
        </div>
        <button type="button" class="lp-remove-btn" style="flex-shrink:0;white-space:nowrap;">
            Remove from Homepage
        </button>
    </div>
    @endforeach

    <button type="button" class="lp-dashed-btn" style="margin-top:16px;"
            onclick="openRoomPickerModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
        </svg>
        Select Room from Database
    </button>
</div>


{{-- ════ MODAL: Select Room ════ --}}
<div class="modal-overlay" id="roomPickerModal">
    <div class="modal-box" style="max-width:520px;">
        <div class="modal-header">
            <h3 class="modal-title">Select Room to Feature</h3>
            <button type="button" class="modal-close" onclick="closeModal('roomPickerModal')">✕</button>
        </div>

        <div class="search-wrap" style="width:100%;margin-bottom:16px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 style="position:absolute;left:10px;color:#a0a8a0;">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" class="search-input" placeholder="Search room name..."
                   style="width:100%;padding-left:34px;" oninput="filterRooms(this.value)">
        </div>

        <div style="max-height:340px;overflow-y:auto;" id="roomPickerList">
            @php
            $allRooms = [
                ['id'=>1,'image'=>null,'name'=>'Serene Haven','gender'=>'MALE ONLY',  'beds'=>8],
                ['id'=>2,'image'=>null,'name'=>'Botanica',    'gender'=>'MALE ONLY',  'beds'=>6],
                ['id'=>3,'image'=>null,'name'=>'The Heritage','gender'=>'FEMALE ONLY','beds'=>8],
            ];
            @endphp

            @foreach($allRooms as $room)
            <label class="room-picker-row"
                   style="display:flex;align-items:center;gap:12px;padding:12px;border-radius:10px;
                          cursor:pointer;transition:background .15s;margin-bottom:4px;border:1.5px solid #f0f4ee;"
                   onmouseover="this.style.background='#f6f9f5'"
                   onmouseout="this.style.background='transparent'">
                @if($room['image'])
                    <img src="{{ asset('storage/'.$room['image']) }}" alt="{{ $room['name'] }}"
                         style="width:60px;height:50px;border-radius:7px;object-fit:cover;flex-shrink:0;">
                @else
                    <div style="width:60px;height:50px;border-radius:7px;background:#e8ede8;flex-shrink:0;"></div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:7px;margin-bottom:3px;">
                        <span style="font-size:13px;font-weight:700;color:#1a3d0a;">{{ $room['name'] }}</span>
                        <span style="font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;
                            {{ $room['gender']==='MALE ONLY' ? 'background:#dbeafe;color:#1e40af;' : 'background:#fce7f3;color:#9d174d;' }}">
                            [{{ $room['gender'] }}]
                        </span>
                    </div>
                    <div style="font-size:11px;color:#7a857f;">Capacity: {{ $room['beds'] }} Beds</div>
                    <div style="font-size:11px;color:#9aaa96;margin-top:2px;">
                        📶 ❄ 🔒 🤝
                    </div>
                </div>
                <input type="radio" name="selected_room" value="{{ $room['id'] }}"
                       style="width:18px;height:18px;accent-color:#2d4a1e;flex-shrink:0;">
            </label>
            @endforeach
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-orange-outline" onclick="closeModal('roomPickerModal')">Cancel</button>
            <button type="button" class="btn btn-dark">Add to Homepage</button>
        </div>
    </div>
</div>

<style>
.lp-dashed-btn {
    width:100%;padding:16px;border:1.5px dashed #c4d0c0;border-radius:10px;
    background:#fafcfa;font-size:13px;font-weight:600;color:#4a7c3f;
    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;
    transition:border-color .15s,background .15s;
}
.lp-dashed-btn:hover { border-color:#4a7c3f;background:#f4f9f4; }
</style>

<script>
function openRoomPickerModal() { openModal('roomPickerModal'); }
function filterRooms(q) {
    document.querySelectorAll('.room-picker-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
}
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) closeModal(el.id); });
});
</script>