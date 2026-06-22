<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>New Reservation Modal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-dark: #1A3D0A;
            --primary-light: #1A3D0A ;
            --accent-orange: #D9864A;
            --bg-white: #FFFFFF;
            --bg-light: #F6F6F1;
            --border-color: rgba(75, 153, 96, 0.3);
            --text-white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Liberation Sans', sans-serif;
            background: transparent;
            display: flex;
            justify-content: stretch;
            align-items: stretch;
            min-height: 100vh;
            padding: 0;
            overflow: hidden;
        }

        .serif-text { font-family: 'EB Garamond', serif; }

        .modal {
            width: 100%; height: 100%; max-width: none; max-height: none;
            background-color: rgba(26, 61, 10, 0.96);
            border-radius: 0; overflow: hidden; box-shadow: none;
            display: flex; flex-direction: column;
        }

        html, body { background: transparent; width: 100%; height: 100%; }

        .modal-header {
            background-color: var(--bg-white);
            padding: 20px 24px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid var(--primary-dark);
        }

        .modal-header h2 { color: var(--primary-dark); font-size: 24px; font-weight: 400; }
        .btn-close { background: none; border: none; font-size: 20px; color: var(--primary-light); cursor: pointer; }

        .modal-body {
            padding: 24px; overflow-y: auto;
            display: flex; flex-direction: column; gap: 24px;
        }

        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group label { color: var(--text-white); font-size: 16px; font-weight: 700; }

        .form-control {
            width: 100%; padding: 12px 16px; background-color: var(--bg-white);
            border: 1px solid var(--primary-dark); border-radius: 4px;
            font-family: inherit; color: var(--primary-dark); font-size: 14px; outline: none;
        }

        .form-control::placeholder { color: var(--primary-light); opacity: 0.7; }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231A3D0A%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat; background-position: right 16px top 50%; background-size: 12px auto;
        }

        textarea.form-control { resize: vertical; min-height: 80px; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }

        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .section-header h3 { color: var(--text-white); font-size: 18px; font-weight: 700; }

        .btn { padding: 10px 24px; font-size: 14px; font-weight: 700; border-radius: 4px; cursor: pointer; border: none; text-align: center; transition: all 0.2s; }
        .btn-orange { background-color: var(--accent-orange); color: var(--text-white); }
        .btn-orange:hover { background-color: #c4763e; }
        .btn-outline { background-color: transparent; color: var(--primary-light); border: 1px solid var(--primary-dark); }
        .btn-outline:hover { background-color: rgba(0, 0, 0, 0.05); }
        .btn:disabled { opacity: 0.7; cursor: not-allowed; }

        .orange-header { background-color: var(--accent-orange); color: var(--text-white); padding: 16px; border-radius: 4px; text-align: center; font-size: 24px; font-weight: 700; }

        .accordion-header { background-color: var(--accent-orange); color: var(--text-white); padding: 16px 20px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; font-weight: 700; cursor: pointer; }
        .policies-header { border-radius: 2px 2px 0 0; }
        details.dropdown-section { display: block; }
        details.dropdown-section > summary { list-style: none; }
        details.dropdown-section > summary::-webkit-details-marker { display: none; }
        details.dropdown-section[open] > summary .chevron { transform: rotate(180deg); }
        .dropdown-content { padding-top: 12px; }

        /* UPLOAD BOX STYLES */
        .upload-box {
            background-color: var(--bg-white); border: 1px solid var(--primary-dark); border-radius: 8px;
            height: 150px; display: flex; justify-content: center; align-items: center; cursor: pointer;
            overflow: hidden; position: relative;
        }
        .upload-box i { font-size: 40px; color: var(--accent-orange); background-color: rgba(217, 134, 74, 0.2); padding: 15px; border-radius: 8px; border: 1px solid var(--primary-dark); z-index: 1; }
        .upload-box img.img-preview { position: absolute; width: 100%; height: 100%; object-fit: cover; display: none; z-index: 2; }
        .upload-box:hover i { transform: scale(1.1); transition: 0.2s; }

        .transport-box { background-color: var(--bg-light); padding: 16px; border-radius: 4px; display: flex; flex-direction: column; gap: 12px; flex: 1; }
        .transport-box h4 { color: var(--primary-dark); font-size: 18px; }
        .text-right { text-align: right; }
        .link-orange { color: var(--accent-orange); text-decoration: none; font-size: 14px; }

        .policies-box { background-color: var(--bg-white); padding: 20px; border-radius: 0 0 2px 2px; display: flex; flex-direction: column; gap: 16px; }
        .policy-times { display: flex; justify-content: space-between; font-weight: 700; color: var(--primary-dark); }
        .policy-times span { font-weight: 400; }
        .house-rules { background-color: var(--primary-dark); color: var(--text-white); padding: 20px 30px; border-radius: 2px; font-size: 14px; line-height: 1.6; }
        .house-rules h4 { font-size: 18px; margin-bottom: 10px; }
        
        .checkbox-label { display: flex; align-items: center; justify-content: flex-end; gap: 10px; color: var(--accent-orange); font-weight: 700; cursor: pointer; }
        .checkbox-label input { accent-color: var(--accent-orange); width: 16px; height: 16px; }

        .payment-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .payment-card { background-color: var(--bg-white); padding: 16px; border-radius: 4px; border: 1px solid var(--primary-dark); display: flex; align-items: center; gap: 12px; cursor: pointer; color: var(--primary-dark); font-weight: 700; transition: background 0.2s; }
        .payment-card:hover { background-color: var(--bg-light); }
        .payment-card input[type="radio"] { accent-color: var(--primary-dark); transform: scale(1.2); }
        .payment-card i,
        .payment-card {
            color: var(--primary-dark) !important;
        }
        .guest-search-panel {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 6px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 15px;
        }

        .guest-search-row {
            position: relative;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .guest-search-row input {
            flex: 1;
            min-width: 260px;
            padding-right: 42px;
        }

        .guest-search-results {
            display: none;
            flex-direction: column;
            gap: 8px;
            max-height: 180px;
            overflow-y: auto;
        }

        .guest-search-results.is-visible {
            display: flex;
        }

        .guest-search-item {
            background: var(--bg-white);
            border: 1px solid var(--primary-dark);
            border-radius: 4px;
            padding: 10px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .guest-search-item:hover {
            background: var(--bg-light);
        }

        .guest-search-item strong {
            display: block;
            color: var(--primary-dark);
            font-family: 'EB Garamond', serif;
            font-size: 16px;
        }

        .guest-search-item span {
            color: var(--text-muted);
            font-size: 12px;
        }

        .guest-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .guest-status-save {
            background: rgba(75, 153, 96, 0.15);
            color: #1A3D0A;
            border: 1px solid rgba(75, 153, 96, 0.45);
        }

        .guest-status-block {
            background: rgba(217, 74, 74, 0.14);
            color: #8A1F1F;
            border: 1px solid rgba(217, 74, 74, 0.45);
        }

        .guest-selected-card {
            background: var(--bg-white);
            border: 1px solid var(--primary-dark);
            border-radius: 6px;
            padding: 12px 14px;
            display: none;
            flex-direction: column;
            gap: 8px;
        }

        .guest-selected-card.is-visible {
            display: flex;
        }

        .guest-selected-card__top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
        }

        .guest-selected-card__name {
            color: var(--primary-dark);
            font-family: 'EB Garamond', serif;
            font-size: 20px;
            font-weight: 700;
        }

        .guest-selected-card__meta {
            color: var(--primary-dark);
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px 16px;
        }

        .guest-search-empty {
            color: rgba(255,255,255,0.8);
            font-size: 13px;
            padding: 8px 2px 0;
        }

        .modal-footer { background-color: var(--bg-white); padding: 20px 24px; display: flex; justify-content: flex-end; gap: 16px; border-top: 1px solid var(--primary-dark); }

        @media (max-width: 768px) { .grid-2, .grid-4, .payment-grid { grid-template-columns: 1fr; } }

        /* ── Tab ID Card / Deposit ─────────────────────────────── */
        .admin-guest-id-deposit-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .admin-guest-tab-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .admin-guest-tab,
        .admin-guest-tab:hover,
        .admin-guest-tab:focus,
        .admin-guest-tab.active,
        .admin-guest-tab[aria-selected="true"] {
            background: #D9864A !important;
            color: #FFFFFF !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            opacity: 1 !important;

            font-family: 'EB Garamond', serif;
            font-size: 16px;
            font-weight: 700;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            transition: none !important;
        }

        .admin-guest-tab-panel {
            display: none;
            padding-top: 16px;
        }

        .admin-guest-tab-panel.active {
            display: block;
        }

        .admin-guest-tab-fields,
        .always-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
    </style>
</head>
<body>
    @php $guest = null; @endphp
    <div class="modal">
        <header class="modal-header">
            <h2 class="serif-text">New Reservation</h2>
            <button class="btn-close" type="button" aria-label="Close modal" data-close-reservation><i class="fa-solid fa-xmark"></i></button>
        </header>

        <form id="reservationForm" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; overflow: hidden; height: 100%;">
            <input type="hidden" name="guest_id" id="selected_guest_id" value="">
            <input type="hidden" name="guest_status" id="guestStatusField" value="save">
            
            <div class="modal-body">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="serif-text">Check-In</label>
                        <input type="date" name="check_in_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="serif-text">Check-Out</label>
                        <input type="date" name="check_out_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="serif-text">Select Room</label>
                        <select class="form-control" name="room_id" id="roomSelect" required>
                            <option value="">Select Room...</option>
                            @foreach($rooms ?? [] as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="serif-text">Select Bed</label>
                        <select class="form-control" name="bed_id" id="bedSelect">
                            <option value="">Select Bed...</option>
                            @foreach($beds ?? [] as $bed)
                                <option value="{{ $bed->id }}" data-room-id="{{ $bed->room_id }}">
                                    {{ $bed->name }} ({{ $bed->position }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <div class="section-header">
                        <h3 class="serif-text">Who is Checking in?</h3>
                    </div>

                    <div class="guest-search-panel">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="serif-text">Search Existing Guest</label>
                            <div class="guest-search-row">
                                <input type="text" id="guestSearchInput" class="form-control" placeholder="Search by name, booking code, phone, or email">
                            </div>
                        </div>
                        <div id="guestSearchResults" class="guest-search-results" aria-live="polite"></div>
                        <div id="guestSelectedCard" class="guest-selected-card">
                            <div class="guest-selected-card__top">
                                <div>
                                    <div class="guest-selected-card__name" id="guestSelectedName">-</div>
                                    <div class="guest-selected-card__meta" id="guestSelectedMeta"></div>
                                </div>
                                <span id="guestSelectedStatus" class="guest-status-badge guest-status-save">SAVE</span>
                            </div>
                        </div>
                        <div id="guestSearchEmpty" class="guest-search-empty" hidden>No matching guest found.</div>
                    </div>

                    <div class="grid-4" style="margin-bottom: 12px;">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone" required>
                        <input type="number" name="age" class="form-control" placeholder="Age">
                        <input type="text" name="occupation" class="form-control" placeholder="Occupation">
                        <input type="text" name="country" class="form-control" placeholder="Country">
                        <input type="text" name="city" class="form-control" placeholder="City">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <textarea class="form-control" name="self_description" placeholder="Self Description"></textarea>
                        <textarea class="form-control" name="personal_notes" placeholder="Personal Notes (Internal)"></textarea>
                    </div>
                </div>

                {{-- ── Tab: ID Card & Deposit ─────────────────────────── --}}
                <div class="admin-guest-id-deposit-section" style="margin-top: 15px;">
                    <div class="admin-guest-tab-row" role="tablist" aria-label="ID Card or Deposit">
                        <button type="button" class="admin-guest-tab active" role="tab" aria-selected="true" aria-controls="adminTabIdCard" id="adminTabBtnIdCard" data-tab="id-card">ID Card</button>
                        <button type="button" class="admin-guest-tab" role="tab" aria-selected="false" aria-controls="adminTabDeposit" id="adminTabBtnDeposit" data-tab="deposit">Deposit</button>
                    </div>

                    {{-- Panel 1: ID Card --}}
                    <div class="admin-guest-tab-panel active" id="adminTabIdCard" role="tabpanel" aria-labelledby="adminTabBtnIdCard">
                        <div class="admin-guest-tab-fields">
                            <div class="form-group">
                                <label class="serif-text">ID Number</label>
                                <input type="text" name="id_number" class="form-control"
                                    placeholder="e.g. 3201xxxxxx"
                                    value="{{ $guest->id_number ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="serif-text">Address</label>
                                <input type="text" name="address" class="form-control"
                                    placeholder="Address Detail"
                                    value="{{ $guest->address ?? '' }}">
                            </div>
                        </div>
                    </div>

                    {{-- Panel 2: Deposit --}}
                    <div class="admin-guest-tab-panel" id="adminTabDeposit" role="tabpanel" aria-labelledby="adminTabBtnDeposit">
                        <div class="admin-guest-tab-fields">
                            <div class="form-group">
                                <label class="serif-text">Deposit Amount</label>
                                <input type="text" name="deposit_amount" class="form-control"
                                    placeholder="e.g. IDR 100.000"
                                    value="{{ $guest->deposit_amount ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="serif-text">Deposit Notes</label>
                                <input type="text" name="deposit_notes" class="form-control"
                                    placeholder="Optional notes"
                                    value="{{ $guest->deposit_notes ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Profile & KTP Upload (Always visible, outside tabs) --}}
                <div class="always-grid-2" style="margin-top: 15px; margin-bottom: 10px;">
                    {{-- Profile Picture --}}
                    <div class="form-group">
                        <label class="serif-text">Profile Picture</label>
                        <input type="file" name="profile_picture" id="profileInput" accept="image/*" hidden>
                        <div class="upload-box" id="profileBox">
                            <i class="fa-solid fa-camera"></i>
                            <img class="img-preview" id="profilePreview"
                                src="{{ $guest && $guest->profile_picture ? asset('storage/' . $guest->profile_picture) : '' }}"
                                alt="Profile Preview" style="{{ $guest && $guest->profile_picture ? 'display: block;' : '' }}">
                        </div>
                    </div>

                    {{-- ID Card Photo --}}
                    <div class="form-group">
                        <label class="serif-text">Card Photo (KTP / Passport)</label>
                        <input type="file" name="id_card_photo" id="cardInput" accept="image/*" hidden>
                        <div class="upload-box" id="cardBox">
                            <i class="fa-solid fa-camera"></i>
                            <img class="img-preview" id="cardPreview"
                                src="{{ $guest && $guest->id_card_photo ? asset('storage/' . $guest->id_card_photo) : '' }}"
                                alt="ID Card Preview" style="{{ $guest && $guest->id_card_photo ? 'display: block;' : '' }}">
                        </div>
                    </div>
                </div>


                <details class="dropdown-section">
                    <summary class="accordion-header">
                        Special Requests <i class="fa-solid fa-chevron-down chevron"></i>
                    </summary>
                    <div class="dropdown-content">
                        <textarea name="special_requests" class="form-control serif-text" placeholder="e.g. Dietary restrictions, room preference, late check-in..." style="background-color: var(--bg-light);"></textarea>
                    </div>
                </details>

                <details class="dropdown-section">
                    <summary class="accordion-header">
                        Transportation <i class="fa-solid fa-chevron-down chevron"></i>
                    </summary>
                    <div class="grid-2 dropdown-content">
                        <div class="transport-box">
                            <h4 class="serif-text">Arrival</h4>
                            <input type="time" name="arrival_time" class="form-control serif-text" placeholder="Estimated Arrival Time">
                            <input type="text" name="arrival_location" class="form-control serif-text" placeholder="Arriving Location (e.g. Airport, Train Station)">
                            <div class="text-right"><a href="#" class="link-orange serif-text clear-btn">Clear</a></div>
                        </div>
                        <div class="transport-box">
                            <h4 class="serif-text">Departure</h4>
                            <input type="time" name="departure_time" class="form-control serif-text" placeholder="Estimated Departure Time">
                            <input type="text" name="departure_location" class="form-control serif-text" placeholder="Arriving Location (e.g. Airport, Train Station)">
                            <div class="text-right"><a href="#" class="link-orange serif-text clear-btn">Clear</a></div>
                        </div>
                    </div>
                </details>

                <details class="dropdown-section">
                    <summary class="accordion-header policies-header">
                        Policies <i class="fa-solid fa-chevron-down chevron"></i>
                    </summary>
                    <div class="policies-box dropdown-content">
                        <div class="policy-times">
                            <div>Check-in: <span>14:00 PM</span></div>
                            <div>Check-out: <span>12:00 PM</span></div>
                        </div>
                        <div class="house-rules serif-text">
                            <h4>House Rules</h4>
                            <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                                <li>Quiet hours are observed from 22:00 to 07:00 to maintain a peaceful and comfortable environment for all guests.</li>
                                <li>Smoking is strictly prohibited inside rooms and all indoor common areas.</li>
                                <li>Please keep shared spaces clean and tidy after use.</li>
                                <li>Any form of criminal activity, violence, harassment, illegal substances, or behavior that may endanger others is strictly prohibited.</li>
                                <li>Guests are expected to respect fellow guests, staff, and property at all times.</li>
                                <li>All guests are required to provide valid identification and accurate personal information during check-in for security and registration purposes.</li>
                            </ul>
                        </div>
                        <label class="checkbox-label">
                            <input type="checkbox" name="policy_accepted" value="1" required> I ACCEPT
                        </label>
                    </div>
                </details>

                <div class="form-group">
                    <label class="serif-text">Payment Method</label>
                    <div class="payment-grid">
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="QRIS" checked>
                            <i class="fa-solid fa-qrcode"></i> QRIS (Recommended)
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="E-Wallet">
                            <i class="fa-solid fa-wallet"></i> E-Wallet
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="Bank Transfer">
                            <i class="fa-solid fa-building-columns"></i> Bank Transfer
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="Credit/Debit Card">
                            <i class="fa-regular fa-credit-card"></i> Credit/Debit Card
                        </label>
                    </div>
                </div>
            </div>

            <footer class="modal-footer">
                <button class="btn btn-outline" type="button" data-close-reservation style="background-color: var(--bg-white); color: #888; display: inline-flex; align-items: center; justify-content: center;">Cancel</button>
                <button class="btn btn-orange" type="submit" id="btnSubmit">Create Reservation</button>
            </footer>
        </form>
    </div>

    <script>
        const existingGuests = @json($guests ?? []);

        // === 1. Logika Close Modal ===
        function closeReservationModal() {
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({ type: 'close-reservation-modal' }, window.location.origin);
                return;
            }
            window.location.href = "{{ route('admin.booking') }}";
        }

        document.querySelectorAll('[data-close-reservation]').forEach(function (button) {
            button.addEventListener('click', closeReservationModal);
        });

        // === 2. Logika Upload Image & Preview ===
        function getStorageUrl(path) {
            if (!path) return '';
            if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('data:')) {
                return path;
            }
            if (path.startsWith('/storage/')) {
                return path;
            }
            if (path.startsWith('storage/')) {
                return '/' + path;
            }
            return '/storage/' + path;
        }

        function setupImagePreview(boxId, inputId) {
            const box = document.getElementById(boxId);
            if (!box) return;
            const input = document.getElementById(inputId);
            const imgPreview = box.querySelector('.img-preview');
            const icon = box.querySelector('i');

            if (input) {
                // Saat kotak diklik, trigger input file
                box.addEventListener('click', () => input.click());

                // Saat file dipilih, ganti icon dengan gambar
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (imgPreview) {
                                imgPreview.src = e.target.result;
                                imgPreview.style.display = 'block';
                            }
                            if (icon) icon.style.display = 'none';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Tampilkan gambar jika ada
            const srcAttr = imgPreview ? imgPreview.getAttribute('src') : '';
            if (imgPreview && srcAttr && srcAttr.trim() !== '' && (srcAttr.includes('/storage/') || srcAttr.includes('storage/'))) {
                imgPreview.style.display = 'block';
                if (icon) icon.style.display = 'none';
            } else {
                if (imgPreview) imgPreview.style.display = 'none';
                if (icon) icon.style.display = 'block';
            }
        }
        setupImagePreview('profileBox', 'profileInput');
        setupImagePreview('cardBox', 'cardInput');

        // === 2. Guest Search & Autofill ===
        const guestSearchInput  = document.getElementById('guestSearchInput');
        const guestSearchResults = document.getElementById('guestSearchResults');
        const guestSearchEmpty  = document.getElementById('guestSearchEmpty');
        const guestSelectedCard = document.getElementById('guestSelectedCard');
        const guestSelectedName = document.getElementById('guestSelectedName');
        const guestSelectedMeta = document.getElementById('guestSelectedMeta');
        const guestSelectedStatus = document.getElementById('guestSelectedStatus');
        const guestIdField = document.getElementById('selected_guest_id');
        const guestStatusField = document.getElementById('guestStatusField');
        const submitBtn = document.getElementById('btnSubmit');

        const fieldMap = {
            first_name: document.querySelector('input[name="first_name"]'),
            last_name: document.querySelector('input[name="last_name"]'),
            email: document.querySelector('input[name="email"]'),
            phone: document.querySelector('input[name="phone"]'),
            age: document.querySelector('input[name="age"]'),
            occupation: document.querySelector('input[name="occupation"]'),
            country: document.querySelector('input[name="country"]'),
            city: document.querySelector('input[name="city"]'),
            id_number: document.querySelector('input[name="id_number"]'),
            address: document.querySelector('input[name="address"]'),
            self_description: document.querySelector('textarea[name="self_description"]'),
            personal_notes: document.querySelector('textarea[name="personal_notes"]'),
            deposit_amount: document.querySelector('input[name="deposit_amount"]'),
            deposit_notes: document.querySelector('input[name="deposit_notes"]'),
        };

        function formatGuestLabel(guest) {
            const fullName = [guest.first_name, guest.last_name].filter(Boolean).join(' ').trim() || 'Guest';
            const parts = [guest.guest_code, fullName].filter(Boolean);
            return parts.join(' - ');
        }

        function getGuestStatusBadgeClass(status) {
            return (status || 'save').toLowerCase() === 'block' ? 'guest-status-block' : 'guest-status-save';
        }

        function renderGuestSearchResults(list) {
            if (!guestSearchResults) return;

            guestSearchResults.innerHTML = '';

            if (!list.length) {
                guestSearchResults.classList.remove('is-visible');
                if (guestSearchEmpty) guestSearchEmpty.hidden = false;
                return;
            }

            if (guestSearchEmpty) guestSearchEmpty.hidden = true;
            guestSearchResults.classList.add('is-visible');

            list.forEach((guest) => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'guest-search-item';
                item.innerHTML = `
                    <div>
                        <strong>${formatGuestLabel(guest)}</strong>
                        <span>${[guest.phone, guest.email, guest.country].filter(Boolean).join(' · ') || 'No extra detail'}</span>
                    </div>
                    <span class="guest-status-badge ${getGuestStatusBadgeClass(guest.status)}">${(guest.status || 'save').toUpperCase()}</span>
                `;

                item.addEventListener('click', () => selectGuest(guest));
                guestSearchResults.appendChild(item);
            });
        }

        function selectGuest(guest) {
            if (!guest) return;

            const status = (guest.status || 'save').toLowerCase();
            if (guestIdField) guestIdField.value = guest.id || '';
            if (guestStatusField) guestStatusField.value = status;

            Object.entries(fieldMap).forEach(([key, input]) => {
                if (!input) return;
                input.value = guest[key] ?? '';
            });

            if (guestSelectedCard) guestSelectedCard.classList.add('is-visible');
            if (guestSelectedName) guestSelectedName.textContent = [guest.first_name, guest.last_name].filter(Boolean).join(' ') || 'Guest';
            if (guestSelectedMeta) {
                guestSelectedMeta.innerHTML = `
                    <span>Guest ID: ${guest.guest_code || '-'}</span>
                    <span>Phone: ${guest.phone || '-'}</span>
                    <span>Email: ${guest.email || '-'}</span>
                `;
            }
            if (guestSelectedStatus) {
                guestSelectedStatus.textContent = status.toUpperCase();
                guestSelectedStatus.className = `guest-status-badge ${getGuestStatusBadgeClass(status)}`;
            }

            if (submitBtn) {
                submitBtn.disabled = status === 'block';
                submitBtn.innerText = status === 'block' ? 'Guest Blocked' : 'Create Reservation';
            }

            if (guestSearchInput) {
                guestSearchInput.value = formatGuestLabel(guest);
            }

            if (guestSearchResults) {
                guestSearchResults.classList.remove('is-visible');
            }
            if (guestSearchEmpty) {
                guestSearchEmpty.hidden = true;
            }

            // Update profile picture preview
            const profilePreview = document.getElementById('profilePreview');
            const profileIcon = document.getElementById('profileBox')?.querySelector('i');
            if (profilePreview) {
                const url = getStorageUrl(guest.profile_picture);
                if (url) {
                    profilePreview.src = url;
                    profilePreview.style.display = 'block';
                    if (profileIcon) profileIcon.style.display = 'none';
                } else {
                    profilePreview.src = '';
                    profilePreview.style.display = 'none';
                    if (profileIcon) profileIcon.style.display = 'block';
                }
            }

            // Update ID card photo preview
            const cardPreview = document.getElementById('cardPreview');
            const cardIcon = document.getElementById('cardBox')?.querySelector('i');
            if (cardPreview) {
                const url = getStorageUrl(guest.id_card_photo);
                if (url) {
                    cardPreview.src = url;
                    cardPreview.style.display = 'block';
                    if (cardIcon) cardIcon.style.display = 'none';
                } else {
                    cardPreview.src = '';
                    cardPreview.style.display = 'none';
                    if (cardIcon) cardIcon.style.display = 'block';
                }
            }
        }

        function clearSelectedGuestState() {
            if (guestIdField) guestIdField.value = '';
            if (guestStatusField) guestStatusField.value = 'save';
            if (guestSelectedCard) guestSelectedCard.classList.remove('is-visible');
            if (guestSelectedName) guestSelectedName.textContent = '-';
            if (guestSelectedMeta) guestSelectedMeta.innerHTML = '';
            if (guestSelectedStatus) {
                guestSelectedStatus.textContent = 'SAVE';
                guestSelectedStatus.className = 'guest-status-badge guest-status-save';
            }
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Create Reservation';
            }

            // Clear image previews
            const profilePreview = document.getElementById('profilePreview');
            const profileIcon = document.getElementById('profileBox')?.querySelector('i');
            if (profilePreview) {
                profilePreview.src = '';
                profilePreview.style.display = 'none';
                if (profileIcon) profileIcon.style.display = 'block';
            }

            const cardPreview = document.getElementById('cardPreview');
            const cardIcon = document.getElementById('cardBox')?.querySelector('i');
            if (cardPreview) {
                cardPreview.src = '';
                cardPreview.style.display = 'none';
                if (cardIcon) cardIcon.style.display = 'block';
            }
        }

        function searchGuests(query) {
            const term = (query || '').trim().toLowerCase();
            if (!term) {
                if (guestSearchResults) guestSearchResults.classList.remove('is-visible');
                if (guestSearchEmpty) guestSearchEmpty.hidden = true;
                return [];
            }

            return existingGuests.filter((guest) => {
                const searchable = [
                    guest.guest_code,
                    guest.first_name,
                    guest.last_name,
                    guest.email,
                    guest.phone,
                    guest.country,
                    guest.city,
                    guest.id_number,
                ].filter(Boolean).join(' ').toLowerCase();

                return searchable.includes(term);
            });
        }

        guestSearchInput?.addEventListener('input', function () {
            clearSelectedGuestState();
            const matches = searchGuests(this.value);
            renderGuestSearchResults(matches);
        });

        document.addEventListener('click', function (event) {
            if (!guestSearchResults || !guestSearchInput) return;
            if (!guestSearchResults.contains(event.target) && event.target !== guestSearchInput) {
                guestSearchResults.classList.remove('is-visible');
            }
        });

        if (guestSearchInput) {
            guestSearchInput.addEventListener('focus', function () {
                const matches = searchGuests(this.value);
                renderGuestSearchResults(matches);
            });
        }

        // === 3. Filter Bed berdasarkan Kamar (Dynamic Select) ===
        const roomSelect = document.getElementById('roomSelect');
        const bedSelect = document.getElementById('bedSelect');
        const allBeds = Array.from(bedSelect.options).slice(1); // Simpan semua opsi kasur kecuali 'Select Bed...'

        roomSelect.addEventListener('change', function() {
            const roomId = this.value;
            // Kosongkan opsi kasur
            bedSelect.innerHTML = '<option value="">Select Bed...</option>';
            
            // Masukkan kembali kasur yang room_id-nya sama
            allBeds.forEach(bed => {
                if (bed.getAttribute('data-room-id') === roomId) {
                    bedSelect.appendChild(bed);
                }
            });
        });

        // === 4. Clear Form Button untuk Transportasi ===
        document.querySelectorAll('.clear-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.closest('.transport-box');
                parent.querySelectorAll('input').forEach(input => input.value = '');
            });
        });

        // === 5. AJAX Submit Form (Menyimpan data ke Controller) ===
        const form = document.getElementById('reservationForm');
        form.addEventListener('submit', async function(e) {
            e.preventDefault(); // Cegah reload halaman

            if ((guestStatusField?.value || 'save') === 'block') {
                alert('Guest ini berstatus BLOCK dan tidak bisa dipakai untuk reservasi baru.');
                return;
            }

            const submitBtn = document.getElementById('btnSubmit');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving Data...';

            try {
                const formData = new FormData(this);
                
                // Gunakan route store yang sudah dibuat di web.php (BookingController@store)
                const response = await fetch("{{ route('admin.booking.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Beri tahu halaman utama untuk menutup iframe dan tampilkan pesan sukses
                    if (window.parent && window.parent !== window) {
                        window.parent.postMessage({ type: 'close-reservation-modal', success: true, message: result.message || 'Reservasi berhasil dibuat.' }, window.location.origin);
                    } else {
                        alert(result.message || 'Reservasi berhasil dibuat.');
                        window.location.href = "{{ route('admin.booking') }}";
                    }
                } else {
                    alert('Gagal: ' + (result.message || 'Harap periksa kembali isian form Anda.'));
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan pada koneksi server.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Create Reservation';
            }
        });

        // === TAB: ID Card / Deposit ===
        const adminGuestTabs  = document.querySelectorAll('.admin-guest-tab');
        const adminTabIdCard  = document.getElementById('adminTabIdCard');
        const adminTabDeposit = document.getElementById('adminTabDeposit');

        function setAdminGuestTab(tabName) {
            const isDeposit = tabName === 'deposit';
            adminGuestTabs.forEach(tab => {
                const active = tab.dataset.tab === tabName;
                tab.classList.toggle('active', active);
                tab.setAttribute('aria-selected', String(active));
            });
            if (isDeposit) {
                adminTabIdCard?.classList.remove('active');
                adminTabDeposit?.classList.add('active');
            } else {
                adminTabIdCard?.classList.add('active');
                adminTabDeposit?.classList.remove('active');
            }
        }

        adminGuestTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                setAdminGuestTab(this.dataset.tab);
            });
        });
    </script>
</body>
</html>