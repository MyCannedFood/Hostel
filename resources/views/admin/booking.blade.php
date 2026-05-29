<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlaSare Management - Reservations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;700&family=Liberation+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        /* === Variabel Warna === */
        :root {
            --primary-dark: #1A3D0A;
            --accent-orange: #D9864A;
            --light-bg: #F6F6F1;
            --table-header: #B8D9A0;
            --text-dark: #1A1C19;
            --text-muted: #43493E;
            --success-green: #4B9960;
            --border-color: rgba(195, 201, 186, 0.5);
            --white: #FFFFFF;
        }

        /* === Reset & Base Styles === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        .serif { font-family: 'EB Garamond', serif; }


        /* === Main Content === */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: var(--light-bg);
            overflow-y: auto;
            margin-left: 260px;
            width: calc(100% - 260px);
            position: relative;
            z-index: 1;
        }

        @media (max-width: 1023.98px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(26, 61, 10, 0.35);
            z-index: 999;
        }

        /* Header */
        .header {
            background-color: #1a3d0a;
            padding: 20px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        @media (min-width: 768px) {
            .header {
                padding: 20px 44px;
                justify-content: flex-end;
            }
        }

        .header .hamburger {
            display: inline-flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 5px;
            padding: 10px;
            margin-right: auto;
            border: 0;
            background: transparent;
            cursor: pointer;
            border-radius: 10px;
        }

        .header .hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            border-radius: 999px;
            background: #ffffff;
        }

        @media (min-width: 1024px) {
            .header .hamburger {
                display: none;
            }
        }

        .header-actions {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .header-actions img {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .header-actions img:hover {
            transform: scale(1.1);
        }

        /* === Dashboard Content === */
        .content-wrapper {
            padding: 24px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
        }
        .page-header h2 {
            font-family: 'Times New Roman', serif;
            font-size: 28px;
            color: var(--primary-dark);
            font-weight: 400;
        }
        .btn-add {
            background-color: var(--accent-orange);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            z-index: 3;
            pointer-events: auto;
        }

        /* === Stats Grid === */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: var(--white);
            border: 1px solid var(--primary-dark);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .stat-card.active-border { border-color: var(--primary-dark); }
        .stat-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-dark);
            text-transform: uppercase;
        }
        .stat-icon {
            background-color: var(--table-header);
            padding: 8px;
            border-radius: 4px;
            color: var(--primary-dark);
        }
        .stat-icon.orange { background-color: rgba(217, 134, 74, 0.2); color: var(--accent-orange); }
        .stat-body {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }
        .stat-number {
            font-family: 'Times New Roman', serif;
            font-size: 48px;
            color: var(--primary-dark);
        }
        .stat-number.orange { color: var(--accent-orange); }
        .stat-label { color: var(--text-dark); font-size: 16px; }

        /* === Filters === */
        .filters {
            display: flex;
            gap: 15px;
            background-color: var(--primary-dark);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .search-box {
            flex: 1;
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid var(--primary-dark);
            border-radius: 4px;
            font-size: 14px;
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-dark);
        }
        .filter-select {
            padding: 12px 15px;
            border: 1px solid var(--primary-dark);
            border-radius: 4px;
            background-color: var(--white);
            color: var(--text-muted);
            min-width: 150px;
            cursor: pointer;
        }
        
        /* === Table === */
        .table-container {
            background: var(--white);
            border: 1px solid var(--table-header);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.03);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th {
            background-color: var(--table-header);
            color: var(--primary-dark);
            padding: 15px 20px;
            font-size: 12px;
            text-transform: uppercase;
        }
        td {
            padding: 20px;
            border-bottom: 1px solid var(--table-header);
            vertical-align: middle;
        }
        .booking-id { font-weight: bold; color: var(--primary-dark); }
        .guest-name, .room-name { font-weight: bold; margin-bottom: 4px; }
        .text-sub { color: var(--success-green); font-size: 14px; }
        .text-muted { color: var(--text-muted); font-size: 14px; }
        .cancelled-text { text-decoration: line-through; opacity: 0.6; }
        
        .badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .badge.confirmed { background-color: var(--table-header); color: var(--primary-dark); border: 1px solid var(--primary-dark); }
        .badge.pending { background-color: var(--accent-orange); color: var(--white); }
        .badge.cancelled { background-color: var(--table-header); color: var(--primary-dark); border: 1px solid var(--primary-dark); }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            background: var(--white);
            border: 1px solid var(--primary-dark);
            border-radius: 4px;
            color: var(--primary-dark);
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .action-btn:hover { background: var(--table-header); }

        /* === Pagination === */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: var(--table-header);
            border-top: 1px solid var(--primary-dark);
        }
        .page-info {
            font-size: 14px;
            color: var(--primary-dark);
        }
        .page-numbers {
            display: flex;
            gap: 5px;
        }
        .page-btn {
            padding: 6px 12px;
            border: 1px solid var(--primary-dark);
            background: var(--white);
            color: var(--primary-dark);
            border-radius: 4px;
            cursor: pointer;
        }
        .page-btn.active {
            background: var(--primary-dark);
            color: var(--white);
        }

        .reservation-modal {
            position: fixed;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: transparent;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 2000;
        }

        .reservation-modal[hidden] {
            display: none;
            pointer-events: none;
        }

        .reservation-modal__frame {
            width: min(100%, 1100px);
            height: min(90vh, 920px);
            border: 0;
            border-radius: 12px;
            overflow: hidden;
            display: block;
            background: transparent;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.28);
        }

        body.modal-open {
            overflow: hidden;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <x-admin_sidenavbar />
        <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>

        <main class="main-content">
            <header class="header">
                    <button type="button" class="hamburger mobile-only" id="sidebarToggle" aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div class="header-actions">
                        <img src="{{ asset('images/admin/img_button_trailing.svg') }}" alt="Menu" width="34" height="28">
                        <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                        <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                    </div>
            </header>

            <div class="content-wrapper">
                
                <div class="page-header">
                    <h2>Reservations Management</h2>
                    <button class="btn-add" type="button" id="openReservationModal">+ Add New Reservation</button>
                </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fa-solid fa-user-plus stat-icon"></i> DAILY ARRIVALS
                    </div>
                    <div class="stat-body">
                        <span class="stat-number">12</span> <span class="stat-label">guests</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fa-solid fa-wallet stat-icon orange"></i> PENDING PAYMENTS
                    </div>
                    <div class="stat-body">
                        <span class="stat-number orange">3</span> <span class="stat-label">bookings</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fa-solid fa-arrow-right-from-bracket stat-icon"></i> CHECK-OUT TODAY
                    </div>
                    <div class="stat-body">
                        <span class="stat-number">8</span> <span class="stat-label">guests</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fa-solid fa-arrow-right-to-bracket stat-icon"></i> CHECK-IN TODAY
                    </div>
                    <div class="stat-body">
                        <span class="stat-number">12</span> <span class="stat-label">guests</span>
                    </div>
                </div>
            </div>

            <div class="filters">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search Booking ID, Guest, or Contact...">
                </div>
                <select class="filter-select">
                    <option>All Room Types</option>
                </select>
                <select class="filter-select">
                    <option>All Statuses</option>
                </select>
                <select class="filter-select">
                    <option>Date Range</option>
                </select>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Guest Info</th>
                            <th>Room & Bed</th>
                            <th>Dates & Stay</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="booking-id">#BK-2025-<br>1042</td>
                            <td>
                                <div class="guest-name">Julian</div>
                                <div class="text-muted">+62 812-9876-xxxx</div>
                            </td>
                            <td>
                                <div class="room-name">Serene Haven</div>
                                <div class="text-sub">SH-B1 | Bottom Bed</div>
                            </td>
                            <td>
                                <div>11 May - 30<br>May 2025</div>
                                <div class="text-sub">19 Nights</div>
                            </td>
                            <td>
                                <div>IDR 643,500</div>
                                <div class="text-sub">QRIS / E-Wallet</div>
                            </td>
                            <td><span class="badge confirmed">CONFIRMED</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn"><i class="fa-solid fa-check"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-pen"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="booking-id">#BK-2025-<br>1043</td>
                            <td>
                                <div class="guest-name">Aditya Pratama</div>
                                <div class="text-muted">aditya.p@email.com</div>
                            </td>
                            <td>
                                <div class="room-name">Botanika</div>
                                <div class="text-sub">BT-T1 | Top Bed</div>
                            </td>
                            <td>
                                <div>12 May - 15<br>May 2025</div>
                                <div class="text-sub">3 Nights</div>
                            </td>
                            <td>
                                <div>IDR 120,000</div>
                                <div class="text-sub">Bank Transfer</div>
                            </td>
                            <td><span class="badge pending">PENDING</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn"><i class="fa-solid fa-check"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-pen"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="booking-id cancelled-text">#BK-2025-<br>1040</td>
                            <td style="opacity: 0.6;">
                                <div class="guest-name">Siti Aminah</div>
                                <div class="text-muted">+62 813-1122-xxxx</div>
                            </td>
                            <td style="opacity: 0.6;">
                                <div class="room-name">Lotus Dorm</div>
                                <div class="text-muted">-</div>
                            </td>
                            <td style="opacity: 0.6;">
                                <div>05 May - 07<br>May 2025</div>
                                <div class="text-muted">2 Nights</div>
                            </td>
                            <td style="opacity: 0.6;">
                                <div>IDR 85,000</div>
                                <div class="text-muted">Refunded</div>
                            </td>
                            <td><span class="badge cancelled">CANCELLED</span></td>
                            <td>
                                <div class="actions">
                                   <button class="action-btn"><i class="fa-solid fa-check"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-pen"></i></button>
                                    <button class="action-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="pagination">
                    <div class="page-info">Showing 1 to 3 of 42 entries</div>
                    <div class="page-numbers">
                        <button class="page-btn"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">...</button>
                        <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

            </div>
        </main>
    </div>

    <div class="reservation-modal" id="reservationModal" hidden aria-hidden="true">
        <iframe class="reservation-modal__frame" src="{{ route('admin.booking.create') }}" title="New Reservation Form"></iframe>
    </div>



    <script>
        const openReservationModal = document.getElementById('openReservationModal');
        const reservationModal = document.getElementById('reservationModal');

        function setReservationModalOpen(isOpen) {
            if (!reservationModal) {
                return;
            }

            reservationModal.hidden = !isOpen;
            reservationModal.setAttribute('aria-hidden', String(!isOpen));
            document.body.classList.toggle('modal-open', isOpen);
        }

        if (openReservationModal && reservationModal) {
            openReservationModal.addEventListener('click', function () {
                setReservationModalOpen(true);
            });

            reservationModal.addEventListener('click', function (event) {
                if (event.target === reservationModal) {
                    setReservationModalOpen(false);
                }
            });

            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setReservationModalOpen(false);
                }
            });

            window.addEventListener('message', function (event) {
                if (event.origin !== window.location.origin) {
                    return;
                }

                if (event.data && event.data.type === 'close-reservation-modal') {
                    setReservationModalOpen(false);
                }
            });
        }
    </script>

</body>
</html>