{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/featured-rooms.blade.php --}}

@php
    $featuredRoomsData = $featuredRoomsData ?? [
        'title' => 'Sanctuaries',
        'title_id' => '',
        'description' => 'Each villa possesses a unique soul, crafted from reclaimed teak and designed to frame the forest.',
        'description_id' => '',
        'room_ids' => [],
    ];
    $selectedRooms = collect($selectedRooms ?? []);
    $allRooms = collect($allRooms ?? []);
    $selectedRoomIds = collect($selectedRoomIds ?? $featuredRoomsData['room_ids'] ?? [])->map(fn ($id) => (int) $id)->all();

    $roomPhoto = function ($room) {
        if (!$room->photo) return null;
        return str_starts_with($room->photo, 'images/')
            ? asset($room->photo)
            : asset('storage/' . $room->photo);
    };

    $genderLabel = fn ($room) => strtoupper($room->gender_type ?? 'Mixed') . ' ONLY';
@endphp

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:24px;">Edit Featured Rooms</h2>

@if(session('success'))
    <div class="lp-card" style="border-color:#c7e3c0;background:#f6fbf4;color:#1a3d0a;">
        {{ session('success') }}
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div class="lp-card" style="border-color:#f2c8c8;background:#fff7f7;color:#9f2f2f;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('admin.landing.featured-rooms.update') }}">
    @csrf
    @method('PUT')
    <div id="selectedRoomInputs">
        @foreach($selectedRoomIds as $roomId)
            <input type="hidden" name="room_ids[]" value="{{ $roomId }}">
        @endforeach
    </div>

    {{-- ── Section Info (Bilingual) ── --}}
    <div class="lp-card">
        <div class="lp-field">
            <label class="lp-field-label">Section Title (EN)</label>
            <input type="text" class="lp-input lp-heading-input" name="title"
                   value="{{ old('title', $featuredRoomsData['title'] ?? '') }}" required>
        </div>
        
        <div class="lp-field">
            <label class="lp-field-label">Section Title (ID)</label>
            <input type="text" class="lp-input lp-heading-input" name="title_id"
                   value="{{ old('title_id', $featuredRoomsData['title_id'] ?? '') }}">
        </div>

        <div class="lp-field" style="margin-top: 16px;">
            <label class="lp-field-label">Section Description (EN)</label>
            <input type="text" class="lp-input" name="description"
                   value="{{ old('description', $featuredRoomsData['description'] ?? '') }}">
        </div>

        <div class="lp-field">
            <label class="lp-field-label">Section Description (ID)</label>
            <input type="text" class="lp-input" name="description_id"
                   value="{{ old('description_id', $featuredRoomsData['description_id'] ?? '') }}">
        </div>
    </div>

    {{-- ── Selected Rooms ── --}}
    <div class="lp-card">
        <p class="lp-card-label" style="margin-bottom:16px;">
            Selected Rooms (<span id="selectedRoomCount">{{ count($selectedRoomIds) }}</span>)
        </p>

        <div id="selectedRoomsList">
            <div id="emptySelectedRooms" style="{{ count($selectedRoomIds) ? 'display:none;' : '' }}padding:18px 0;color:#7a857f;font-size:13px;">
                No rooms selected yet.
            </div>

            @forelse($allRooms as $room)
                <div class="selected-room-row" data-room-id="{{ $room->id }}"
                     style="{{ in_array($room->id, $selectedRoomIds, true) ? 'display:flex;' : 'display:none;' }}align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid #f0f4ee;">
                    @if($roomPhoto($room))
                        <img src="{{ $roomPhoto($room) }}" alt="{{ $room->name }}"
                             style="width:80px;height:64px;border-radius:8px;object-fit:cover;flex-shrink:0;">
                    @else
                        <div style="width:80px;height:64px;border-radius:8px;background:#e8ede8;flex-shrink:0;"></div>
                    @endif
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px;">
                            <span style="font-size:14px;font-weight:700;color:#1a3d0a;">{{ $room->name }}</span>
                            <span style="font-size:10px;font-weight:700;letter-spacing:.5px;padding:2px 8px;border-radius:4px;
                                {{ $room->gender_type === 'Male' ? 'background:#dbeafe;color:#1e40af;' : 'background:#fce7f3;color:#9d174d;' }}">
                                [{{ $genderLabel($room) }}]
                            </span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;color:#7a857f;font-size:12px;">
                            @if($room->main_facilities)
                                @php $facilities = explode(',', $room->main_facilities); @endphp
                                @foreach($facilities as $facility)
                                    @php
                                        $facilityName = strtolower(trim($facility));
                                        $iconFile = 'images/icon/walk-svgrepo-com.svg';
                                        if(str_contains($facilityName, 'wi-fi') || str_contains($facilityName, 'wifi')) {
                                            $iconFile = 'images/icon/wifi-svgrepo-com-1.svg';
                                        } elseif(str_contains($facilityName, 'ac') || str_contains($facilityName, 'air')) {
                                            $iconFile = 'images/icon/snow-svgrepo-com.svg';
                                        } elseif(str_contains($facilityName, 'locker') || str_contains($facilityName, 'lock')) {
                                            $iconFile = 'images/icon/lock-svgrepo-com.svg';
                                        } elseif(str_contains($facilityName, 'en-suite bath') || str_contains($facilityName, 'bath') || str_contains($facilityName, 'shower')) {
                                            $iconFile = 'images/icon/shower-svgrepo-com.svg';
                                        }
                                    @endphp
                                    <div style="display:flex;align-items:center;gap:4px;">
                                        <img src="{{ asset($iconFile) }}" alt="{{ trim($facility) }}" style="width:14px;height:14px;object-fit:contain;">
                                        <span title="{{ trim($facility) }}">{{ strtolower(trim($facility)) }}</span>
                                    </div>
                                @endforeach
                            @endif
                            <span title="Beds">{{ $room->beds_count ?: $room->capacity }} beds</span>
                        </div>
                        <div style="font-size:12px;color:#7a857f;line-height:1.5;">
                            {{ $room->description ?: 'No room description yet.' }}
                        </div>
                    </div>
                    <button type="button" class="lp-remove-btn" style="flex-shrink:0;white-space:nowrap;"
                            onclick="unselectFeaturedRoom({{ $room->id }})">
                        Remove from Homepage
                    </button>
                </div>
            @empty
            @endforelse
        </div>

        <button type="button" class="lp-dashed-btn" style="margin-top:16px;"
                onclick="openRoomPickerModal()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
            </svg>
            Select Room from Database
        </button>
    </div>

    {{-- ── FORM ACTIONS (Tombol Save Baru) ── --}}
    <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
        <button type="submit" class="btn btn-dark" style="padding: 12px 32px; font-weight: 600; font-size: 14px; border-radius: 8px; cursor: pointer;">
            Save Changes
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
                @forelse($allRooms as $room)
                    <label class="room-picker-row"
                           data-room-name="{{ strtolower($room->name) }}"
                           style="display:flex;align-items:center;gap:12px;padding:12px;border-radius:10px;
                                  cursor:pointer;transition:background .15s;margin-bottom:4px;border:1.5px solid #f0f4ee;"
                           onmouseover="this.style.background='#f6f9f5'"
                           onmouseout="this.style.background='transparent'">
                        @if($roomPhoto($room))
                            <img src="{{ $roomPhoto($room) }}" alt="{{ $room->name }}"
                                 style="width:60px;height:50px;border-radius:7px;object-fit:cover;flex-shrink:0;">
                        @else
                            <div style="width:60px;height:50px;border-radius:7px;background:#e8ede8;flex-shrink:0;"></div>
                        @endif
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:3px;">
                                <span style="font-size:13px;font-weight:700;color:#1a3d0a;">{{ $room->name }}</span>
                                <span style="font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;
                                    {{ $room->gender_type === 'Male' ? 'background:#dbeafe;color:#1e40af;' : 'background:#fce7f3;color:#9d174d;' }}">
                                    [{{ $genderLabel($room) }}]
                                </span>
                            </div>
                            <div style="font-size:11px;color:#7a857f;">Capacity: {{ $room->beds_count ?: $room->capacity }} Beds</div>
                            <div style="font-size:11px;color:#9aaa96;margin-top:2px;">wi-fi ac locker sharing</div>
                        </div>
                        <input type="checkbox" name="selected_room" value="{{ $room->id }}"
                               class="circular-checkbox"
                               style="width:18px;height:18px;accent-color:#2d4a1e;flex-shrink:0;">
                    </label>
                @empty
                    <div style="padding:18px;color:#7a857f;font-size:13px;">No rooms found.</div>
                @endforelse
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-orange-outline" onclick="closeModal('roomPickerModal')">Cancel</button>
                <button type="button" class="btn btn-dark" onclick="addSelectedRoomAndSubmit()">Add to Homepage</button>
            </div>
        </div>
    </div>
</form>

<style>
.lp-dashed-btn {
    width:100%;padding:16px;border:1.5px dashed #c4d0c0;border-radius:10px;
    background:#fafcfa;font-size:13px;font-weight:600;color:#4a7c3f;
    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;
    transition:border-color .15s,background .15s;
}
.lp-dashed-btn:hover { border-color:#4a7c3f;background:#f4f9f4; }
.circular-checkbox {
    border-radius: 50%;
    appearance: none;
    -webkit-appearance: none;
    border: 2px solid #c4d0c0;
    width: 18px;
    height: 18px;
    cursor: pointer;
    position: relative;
}
.circular-checkbox:checked {
    background-color: #2d4a1e;
    border-color: #2d4a1e;
}
.circular-checkbox:checked::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
}
</style>

<script>
function openRoomPickerModal() { openModal('roomPickerModal'); }
function filterRooms(q) {
    const needle = q.toLowerCase();
    document.querySelectorAll('#roomPickerList .room-picker-row').forEach(row => {
        row.style.display = row.dataset.roomName.includes(needle) ? '' : 'none';
    });
}
function syncFeaturedRoomCount() {
    const selected = document.querySelectorAll('#selectedRoomInputs input[name="room_ids[]"]');
    document.getElementById('selectedRoomCount').textContent = selected.length;
    const emptyState = document.getElementById('emptySelectedRooms');
    if (emptyState) emptyState.style.display = selected.length ? 'none' : '';
}
function hasSelectedRoom(roomId) {
    return Boolean(document.querySelector(`#selectedRoomInputs input[name="room_ids[]"][value="${roomId}"]`));
}
function addSelectedRoomInput(roomId) {
    if (hasSelectedRoom(roomId)) return;
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'room_ids[]';
    input.value = roomId;
    document.getElementById('selectedRoomInputs').appendChild(input);
}
function addSelectedRoomAndSubmit() {
    const selected = document.querySelectorAll('input[name="selected_room"]:checked');
    if (selected.length === 0) return;
    selected.forEach(checkbox => {
        addSelectedRoomInput(checkbox.value);
    });
    document.querySelector('form[action="{{ route('admin.landing.featured-rooms.update') }}"]').submit();
}
function unselectFeaturedRoom(roomId) {
    const input = document.querySelector(`#selectedRoomInputs input[name="room_ids[]"][value="${roomId}"]`);
    if (input) input.remove();
    const row = document.querySelector(`.selected-room-row[data-room-id="${roomId}"]`);
    if (row) row.style.display = 'none';
    syncFeaturedRoomCount();
    document.querySelector('form[action="{{ route('admin.landing.featured-rooms.update') }}"]').submit();
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