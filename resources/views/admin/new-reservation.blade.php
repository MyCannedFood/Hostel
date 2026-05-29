<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation Modal</title>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;700&family=Liberation+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .serif-text {
            font-family: 'EB Garamond', serif;
        }

        .modal {
            width: 100%;
            height: 100%;
            max-width: none;
            max-height: none;
            background-color: rgba(26, 61, 10, 0.96);
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
            display: flex;
            flex-direction: column;
        }

        html,
        body {
            background: transparent;
            width: 100%;
            height: 100%;
        }

        .modal-header {
            background-color: var(--bg-white);
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--primary-dark);
        }

        .modal-header h2 {
            color: var(--primary-dark);
            font-size: 24px;
            font-weight: 400;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--primary-light);
            cursor: pointer;
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            color: var(--text-white);
            font-size: 16px;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--bg-white);
            border: 1px solid var(--primary-dark);
            border-radius: 4px;
            font-family: inherit;
            color: var(--primary-dark);
            font-size: 14px;
            outline: none;
        }

        .form-control::placeholder {
            color: var(--primary-light);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231A3D0A%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 16px top 50%;
            background-size: 12px auto;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .section-header h3 {
            color: var(--text-white);
            font-size: 18px;
            font-weight: 700;
        }

        .btn {
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            text-align: center;
            transition: all 0.2s;
        }

        .btn-orange {
            background-color: var(--accent-orange);
            color: var(--text-white);
        }

        .btn-orange:hover {
            background-color: #c4763e;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-light);
            border: 1px solid var(--primary-dark);
        }

        .btn-outline:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .orange-header {
            background-color: var(--accent-orange);
            color: var(--text-white);
            padding: 16px;
            border-radius: 4px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
        }

        .accordion-header {
            background-color: var(--accent-orange);
            color: var(--text-white);
            padding: 16px 20px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            cursor: pointer;
        }

        .policies-header {
            border-radius: 2px 2px 0 0;
        }

        details.dropdown-section {
            display: block;
        }

        details.dropdown-section > summary {
            list-style: none;
        }

        details.dropdown-section > summary::-webkit-details-marker {
            display: none;
        }

        details.dropdown-section[open] > summary .chevron {
            transform: rotate(180deg);
        }

        .dropdown-content {
            padding-top: 12px;
        }

        .upload-box {
            background-color: var(--bg-white);
            border: 1px solid var(--primary-dark);
            border-radius: 8px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .upload-box i {
            font-size: 40px;
            color: var(--accent-orange);
            background-color: rgba(217, 134, 74, 0.2);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid var(--primary-dark);
        }

        .transport-box {
            background-color: var(--bg-light);
            padding: 16px;
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
        }

        .transport-box h4 {
            color: var(--primary-dark);
            font-size: 18px;
        }

        .text-right {
            text-align: right;
        }

        .link-orange {
            color: var(--accent-orange);
            text-decoration: none;
            font-size: 14px;
        }

        .policies-box {
            background-color: var(--bg-white);
            padding: 20px;
            border-radius: 0 0 2px 2px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .policy-times {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .policy-times span { font-weight: 400; }

        .house-rules {
            background-color: var(--primary-dark);
            color: var(--text-white);
            padding: 20px 30px;
            border-radius: 2px;
            font-size: 14px;
            line-height: 1.6;
        }

        .house-rules h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            color: var(--accent-orange);
            font-weight: 700;
            cursor: pointer;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .payment-card {
            background-color: var(--bg-white);
            padding: 16px;
            border-radius: 4px;
            border: 1px solid var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            color: var(--primary-dark);
            font-weight: 700;
        }

        .payment-card input[type="radio"] {
            accent-color: var(--primary-dark);
            transform: scale(1.2);
        }

        .modal-footer {
            background-color: var(--bg-white);
            padding: 20px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            border-top: 1px solid var(--primary-dark);
        }

        @media (max-width: 768px) {
            .grid-2,
            .grid-4,
            .payment-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="modal">
        <header class="modal-header">
            <h2 class="serif-text">New Reservation</h2>
            <button class="btn-close" type="button" aria-label="Close modal" data-close-reservation><i class="fa-solid fa-xmark"></i></button>
        </header>

        <div class="modal-body">
            <div class="grid-2">
                <div class="form-group">
                    <label class="serif-text">Check-In</label>
                    <select class="form-control"><option>Select Date...</option></select>
                </div>
                <div class="form-group">
                    <label class="serif-text">Check-Out</label>
                    <select class="form-control"><option>Select Date...</option></select>
                </div>
                <div class="form-group">
                    <label class="serif-text">Select Room</label>
                    <select class="form-control"><option>Select Room...</option></select>
                </div>
                <div class="form-group">
                    <label class="serif-text">Select Bed</label>
                    <select class="form-control"><option>Select Bed...</option></select>
                </div>
            </div>

            <div>
                <div class="section-header">
                    <h3 class="serif-text">Who is Checking in?</h3>
                    <button class="btn btn-orange" type="button">Save</button>
                </div>
                <div class="grid-4" style="margin-bottom: 12px;">
                    <input type="text" class="form-control" placeholder="First Name">
                    <input type="text" class="form-control" placeholder="Last Name">
                    <input type="email" class="form-control" placeholder="Email">
                    <input type="tel" class="form-control" placeholder="Phone">
                    <input type="number" class="form-control" placeholder="Age">
                    <input type="text" class="form-control" placeholder="Occupation">
                    <input type="text" class="form-control" placeholder="Country">
                    <input type="text" class="form-control" placeholder="City">
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <textarea class="form-control" placeholder="Self Description"></textarea>
                    <textarea class="form-control" placeholder="Personal Notes"></textarea>
                </div>
            </div>

            <div class="grid-2">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div class="orange-header serif-text">ID Card</div>
                    <div class="form-group">
                        <label class="serif-text">ID Number</label>
                        <input type="text" class="form-control" placeholder="e.g. 28">
                    </div>
                    <div class="form-group">
                        <label class="serif-text">Profile Picture</label>
                        <div class="upload-box">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div class="orange-header serif-text">Deposit</div>
                    <div class="form-group">
                        <label class="serif-text">Address</label>
                        <input type="text" class="form-control" placeholder="e.g. Freelancer">
                    </div>
                    <div class="form-group">
                        <label class="serif-text">Card Photo</label>
                        <div class="upload-box">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                </div>
            </div>

            <details class="dropdown-section">
                <summary class="accordion-header">
                    Special Requests <i class="fa-solid fa-chevron-down chevron"></i>
                </summary>
                <div class="dropdown-content">
                    <textarea class="form-control serif-text" placeholder="e.g. Dietary restrictions, room preference, late check-in..." style="background-color: var(--bg-light);"></textarea>
                </div>
            </details>

            <details class="dropdown-section">
                <summary class="accordion-header">
                    Transportation <i class="fa-solid fa-chevron-down chevron"></i>
                </summary>
                <div class="grid-2 dropdown-content">
                    <div class="transport-box">
                        <h4 class="serif-text">Arrival</h4>
                        <input type="text" class="form-control serif-text" placeholder="Estimated Arrival Time">
                        <input type="text" class="form-control serif-text" placeholder="Arriving Location (e.g. Airport, Train Station)">
                        <div class="text-right"><a href="#" class="link-orange serif-text">Clear</a></div>
                    </div>
                    <div class="transport-box">
                        <h4 class="serif-text">Departure</h4>
                        <input type="text" class="form-control serif-text" placeholder="Estimated Departure Time">
                        <input type="text" class="form-control serif-text" placeholder="Arriving Location (e.g. Airport, Train Station)">
                        <div class="text-right"><a href="#" class="link-orange serif-text">Clear</a></div>
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
                        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 4px;">
                            <li>Quiet hours are observed from 22:00 to 07:00 to maintain a peaceful and comfortable environment for all guests.</li>
                            <li>Smoking is strictly prohibited inside rooms and all indoor common areas.</li>
                            <li>Please keep shared spaces clean and tidy after use.</li>
                            <li>Any form of criminal activity, violence, harassment, illegal substances, or behavior that may endanger others is strictly prohibited.</li>
                            <li>Guests are expected to respect fellow guests, staff, and property at all times.</li>
                            <li>All guests are required to provide valid identification and accurate personal information during check-in for security and registration purposes.</li>
                        </ul>
                    </div>
                    <label class="checkbox-label">
                        <input type="checkbox"> I ACCEPT
                    </label>
                </div>
            </details>

            <div class="form-group">
                <label class="serif-text">Payment Method</label>
                <div class="payment-grid">
                    <label class="payment-card" style="color: var(--primary-dark);">
                        <input type="radio" name="payment" checked>
                        <i class="fa-solid fa-qrcode"></i> QRIS (Recommended)
                    </label>
                    <label class="payment-card" style="color: var(--primary-dark);">
                        <input type="radio" name="payment">
                        <i class="fa-solid fa-wallet"></i> E-Wallet
                    </label>
                    <label class="payment-card" style="color: var(--primary-dark);">
                        <input type="radio" name="payment">
                        <i class="fa-solid fa-building-columns"></i> Bank Transfer
                    </label>
                    <label class="payment-card" style="color: var(--primary-dark);">
                        <input type="radio" name="payment">
                        <i class="fa-regular fa-credit-card"></i> Credit/Debit Card
                    </label>
                </div>
            </div>
        </div>

        <footer class="modal-footer">
            <button class="btn btn-outline" type="button" data-close-reservation style="background-color: var(--bg-white); color: #888; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Cancel</button>
            <button class="btn btn-orange" type="button">Create Reservation</button>
        </footer>
    </div>

    <script>
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
    </script>
</body>
</html>