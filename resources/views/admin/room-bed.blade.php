@php
    $admin = auth('admin')->user();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Rooms & Beds</title>
    @vite(['resources/css/app.css', 'resources/css/admin-add-additional.css', 'resources/js/admin/add-additional.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=EB+Garamond:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    
    <style>
        :root {
            --dark-green: #1A3D0A;
            --light-green: #B8D9A0;
            --medium-green: #4B9960;
            --orange: #D9864A;
            --bg-color: #FAFAF5;
            --white: #FFFFFF;
            --border-color: #E3E3DE;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Times New Roman', Times, serif; /* Liberation Serif fallback */
            color: var(--dark-green);
        }

        .sans-serif {
            font-family: 'DM Sans', sans-serif;
        }

        /* BUNGKUSAN UTAMA */
        .main-content-wrapper {
            margin-left: 260px; /* <--- KECILKAN ANGKA INI SAMPAI NEMPEL PAS */
            width: calc(100% - 260px); /* <--- SAMAKAN JUGA ANGKANYA DI SINI */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar Dummy (for visual completeness) */
        .top-navbar {
            background-color: var(--dark-green);
            height: 60px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 40px;
            gap: 20px;
            color: var(--white);
        }

        /* Layout Container */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 40px;
            width: 100%;
        }

        /* Header Section */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 400;
        }

        .btn {
            background-color: var(--orange);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-full {
            width: 100%;
            justify-content: center;
            padding: 12px;
        }

            .btn-outline-green {
                background-color: var(--white);
                color: var(--dark-green);
                border: 1px solid var(--dark-green);
                justify-content: center;
            }

            .btn-with-icon {
                position: relative;
                padding-left: 44px;
            }

            .btn-with-icon .btn-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                width: 18px;
                height: 18px;
                display: block;
            }

            .floor-plan-btn {
                width: 100%;
                background-color: var(--white);
                color: var(--dark-green);
                border: 1px solid var(--dark-green);
                justify-content: center;
                position: relative;
                padding-left: 44px;
            }

            .floor-plan-btn .btn-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                width: 18px;
                height: 18px;
                display: block;
            }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--dark-green);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .card-image-wrapper {
            position: relative;
            height: 390px; /* Sekarang tingginya jadi 390px */
            background-color: var(--border-color);
        }

        .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-tags {
            position: absolute;
            top: 16px;
            left: 16px;
            display: flex;
            gap: 8px;
            max-width: calc(100% - 32px);
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            scrollbar-width: thin;
            scrollbar-color: rgba(26, 61, 10, 0.5) transparent;
            -ms-overflow-style: none;
        }

        .card-tags::-webkit-scrollbar {
            display: none;
        }

        .tag {
            padding: 4px 12px;
            font-size: 11px;
            font-family: 'EB Garamond', serif;
            letter-spacing: 1px;
            border-radius: 2px;
            text-transform: uppercase;
            flex: 0 0 auto;
        }

        .tag-dark { background: var(--dark-green); color: var(--white); }
        .tag-orange { background: var(--orange); color: var(--white); }
        .tag-green { background: var(--medium-green); color: var(--white); }
        .tag-white { background: var(--white); color: var(--dark-green); }

        .card-content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            flex-grow: 1;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 24px;
            font-weight: 400;
        }

        .bed-count {
            background: var(--light-green);
            padding: 4px 8px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .card-desc {
            font-size: 15px;
            color: #333;
            line-height: 1.5;
            flex-grow: 1;
        }

        .amenities {
            background: var(--light-green);
            padding: 16px;
            border-radius: 4px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-bottom: 8px;
        }

        .amenity-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: bold;
        }

        .amenity-item svg {
            width: 20px;
            height: 20px;
            fill: var(--dark-green);
        }

        /* Table Section */
        .table-section {
            background: var(--white);
            border: 1px solid var(--dark-green);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 60px;
        }

        .table-header-bar {
            background: var(--dark-green);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--white);
        }

        .table-header-title {
            font-size: 22px;
            font-weight: 400;
        }

        .table-controls {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .dropdown {
            background-color: var(--white);
            
            /* Menghapus panah bawaan browser */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            
            /* Memasang ikon panah kustom */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%231A3D0A' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            /* Mengatur posisi ikon: 12px dari kanan, di tengah secara vertikal */
            background-position: right 12px center; 
            
            color: var(--dark-green);
            height: 36px;
            padding-left: 16px;
            padding-right: 40px; /* Kasih jarak ekstra biar teks gak nabrak ikon panah */
            border: 1px solid var(--medium-green);
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            outline: none;
            cursor: pointer;
            box-sizing: border-box;
            font-family: 'Liberation Serif', serif;
        }

       /* ===== CSS TABEL RAPI ===== */
        /* ===== CSS TABEL RATA KIRI RAPI ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Paksa semua header rata kiri dengan padding seragam */
        th {
            padding: 18px 24px; 
            font-size: 16px;
            font-weight: bold;
            color: var(--dark-green);
            background: var(--light-green);
            border-bottom: 1px solid var(--dark-green);
            text-align: left !important; 
        }

        /* Paksa semua isi cell rata kiri dengan padding seragam */
        td {
            padding: 16px 24px;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
            color: var(--dark-green);
            vertical-align: middle;
            text-align: left !important; 
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Padding ekstra untuk kolom pertama (ID) supaya tidak terlalu mepet tepi layar */
        th:first-child, td:first-child {
            padding-left: 32px;
            width: 15%;
            font-weight: bold;
        }

        /* Atur proporsi lebar kolom */
        th:nth-child(2), td:nth-child(2) { width: 25%; }
        th:nth-child(3), td:nth-child(3) { width: 25%; }
        th:nth-child(4), td:nth-child(4) { width: 20%; }
        th:nth-child(5), td:nth-child(5) { width: 15%; }

        /* Merapikan posisi mata uang & nominal agar merapat ke kiri */
        .price-wrapper {
            display: inline-flex;
            justify-content: flex-start; /* Kunci rata kiri */
            align-items: center;
            gap: 16px; /* Jarak pas antara IDR dan nominal */
        }
        
        .price-wrapper strong {
            font-weight: bold;
        }

        /* Kolom 5: Action (Dibuat Rata Tengah) */
        th:nth-child(5), td:nth-child(5) { 
            width: 15%; 
            text-align: center !important; /* Memaksa khusus kolom ini ke tengah */
        }


        /* Merapikan posisi tombol edit & toggle di tengah */
        .actions {
            display: flex;
            align-items: center;
            justify-content: center; /* Ubah kembali jadi center */
            gap: 16px;
        }
        /* Toggles */
        .toggle {
            width: 36px;
            height: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 2px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease; /* Tambahan animasi */
            box-sizing: border-box;
            border: 1px solid transparent; /* Biar ukurannya konsisten saat off ada border */
        }

        .toggle.on { 
            background: var(--orange); 
        }
        .toggle.on .knob {
            background: var(--white);
            transform: translateX(16px);
        }
        .status-maintenance {
            background: var(--orange);
            color: var(--white);
            border: 1px solid var(--orange);
        }

        .room-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.6);
            z-index: 99999 !important;
            pointer-events: auto;
        }

        .room-modal.is-open {
            display: flex;
        }

        .room-modal__panel {
            width: 100%;
            max-width: 600px;
            background-color: var(--bg-main);
            border-radius: 8px;
            outline: 1px solid var(--primary-dark);
            box-shadow: 0px 4px 24px rgba(26, 61, 10, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            max-height: 90vh;
            position: relative;
            z-index: 100000;
        }

        .room-modal__header {
            background-color: var(--primary-light);
            padding: 16px 24px;
            border-bottom: 1px solid var(--primary-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .room-modal__title {
            color: var(--primary-dark);
            font-size: 30px;
            font-weight: 500;
        }

        .room-modal__close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.2s;
        }

        .room-modal__close:hover {
            color: var(--primary-dark);
        }

        .room-modal__body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .room-modal .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .room-modal .form-label {
            color: var(--primary-dark);
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        .room-modal .form-control {
            width: 100%;
            padding: 10px 12px;
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 2px;
            font-family: inherit;
            font-size: 14px;
            color: var(--primary-dark);
            outline: none;
        }

        .room-modal .form-control:focus {
            border-color: var(--primary-dark);
        }

        .room-modal .form-control::placeholder {
            color: rgba(26, 61, 10, 0.5);
        }

        .room-modal select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231A3D0A%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 12px top 50%;
            background-size: 10px auto;
        }

        .room-modal textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .room-modal .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .room-modal .input-group {
            display: flex;
            align-items: center;
        }

        .room-modal .input-group input {
            border-right: none;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .room-modal .input-btn {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            padding: 10px 12px;
            border-top-right-radius: 2px;
            border-bottom-right-radius: 2px;
            color: var(--primary-dark);
            cursor: pointer;
        }

        .room-modal .facilities-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .room-modal .facility-chip {
            background-color: var(--primary-light);
            border: 1px solid var(--primary-dark);
            border-radius: 2px;
            padding: 6px 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .room-modal .facility-chip input[type="checkbox"] {
            display: none;
        }

        .room-modal .custom-checkbox {
            width: 14px;
            height: 14px;
            background-color: var(--white);
            border: 1px solid var(--primary-dark);
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .room-modal .facility-chip input[type="checkbox"]:checked + .custom-checkbox {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
        }

        .room-modal .facility-chip input[type="checkbox"]:checked + .custom-checkbox::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--white);
            font-size: 10px;
        }

        .room-modal .facility-text {
            color: var(--primary-dark);
            font-size: 14px;
            font-weight: 500;
        }

        .room-modal__footer {
            background-color: var(--primary-light);
            padding: 16px 24px;
            border-top: 1px solid var(--primary-dark);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .room-modal .btn-outline {
            background-color: var(--white);
            color: var(--primary-dark);
            border: 1px solid var(--primary-dark);
        }

        .room-modal .btn-outline:hover {
            background-color: #f0f0f0;
        }

        .room-modal .btn-orange {
            background-color: var(--accent-orange);
            color: var(--white);
            border: 1px solid transparent;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
        }

        .room-modal .btn-orange:hover {
            background-color: #c4763e;
        }

        body.modal-open {
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .room-modal .grid-3 {
                grid-template-columns: 1fr;
            }

            .room-modal__panel {
                max-width: 100%;
            }
        }

        .toggle.off .knob {
            background: var(--dark-green);
            transform: translateX(0);
        }

        .toggle .knob {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            transition: transform 0.3s ease, background-color 0.3s ease; /* Animasi geser halus */
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 11px;
            text-transform: uppercase;
            border: 1px solid;
            font-weight: normal;
        }

        .status-tersedia {
            background: rgba(75, 153, 96, 0.1);
            color: var(--dark-green);
            border-color: var(--medium-green);
        }

        .status-tersedia::before {
            content: '';
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--dark-green);
        }

        .status-maintenance {
            background: var(--orange);
            color: var(--white);
            border-color: var(--orange);
        }
        
        .status-maintenance::before {
            content: '';
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--white);
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
            fill: var(--dark-green);
        }

        /* Toggles */
        .toggle {
            width: 36px;
            height: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 2px;
            cursor: pointer;
        }

        .toggle.on { background: var(--orange); }
        .toggle.on .knob {
            background: var(--white);
            transform: translateX(16px);
        }

        .toggle.off { 
            background: var(--light-green); 
            border: 1px solid var(--dark-green);
        }
        .toggle.off .knob {
            background: var(--dark-green);
            transform: translateX(0);
        }

        .toggle .knob {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            transition: 0.2s;
        }

        /* ═══════════════════════════════════════════
           PROMO CODE — Additional Styles
        ═══════════════════════════════════════════ */

        .promo-table td {
            padding: 16px 18px;
            vertical-align: middle;
        }
        .promo-code-cell {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.06em;
            color: var(--dark-green);
        }
        .promo-discount-cell {
            font-size: 13px;
            font-weight: 600;
            color: var(--dark-green);
        }
        .promo-validity-cell {
            font-size: 12px;
            color: rgba(26, 61, 10, 0.75);
            line-height: 1.55;
        }
        .promo-validity-meta {
            font-size: 11px;
            font-weight: 600;
            margin-top: 3px;
        }
        .promo-validity-meta.remaining { color: #3a7d2f; }
        .promo-validity-meta.upcoming  { color: #9a6b1a; }
        .promo-validity-meta.expired   { color: #b03020; }
        .promo-quota-cell {
            font-size: 13px;
            color: rgba(26, 61, 10, 0.8);
        }

        .promo-status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 2px;
            font-size: 12px;
            font-weight: 700;
        }
        .promo-status-badge.active {
            background: #d6f0d8;
            color: #2a6e32;
        }
        .promo-status-badge.non-active {
            background: #fde8e5;
            color: #b03020;
        }

        .promo-table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0 0;
            margin-top: 8px;
            border-top: 1px solid rgba(26, 61, 10, 0.08);
        }
        .promo-count-label {
            font-size: 12px;
            color: rgba(26, 61, 10, 0.55);
        }
        .promo-pagination {
            display: flex;
            gap: 6px;
        }
        .promo-page-btn {
            width: 30px;
            height: 30px;
            border-radius: 2px;
            border: 1.5px solid rgba(26, 61, 10, 0.2);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(26, 61, 10, 0.6);
            transition: border-color 0.15s, background 0.15s;
        }
        .promo-page-btn:hover {
            border-color: var(--dark-green);
            background: rgba(26, 61, 10, 0.05);
        }

        .promo-date-wrap {
            position: relative;
        }
        .promo-date-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: rgba(26, 61, 10, 0.4);
        }
        .promo-date-input {
            padding-left: 36px !important;
        }

        .promo-code-input {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .promo-status-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 14px;
            background: rgba(26, 61, 10, 0.04);
            border: 1px solid rgba(26, 61, 10, 0.1);
            border-radius: 2px;
            margin-top: 2px;
        }
        .promo-status-main {
            font-size: 13px;
            font-weight: 600;
            color: var(--dark-green);
            margin: 0;
            line-height: 1.3;
        }
        .promo-status-hint {
            font-size: 11px;
            color: rgba(26, 61, 10, 0.5);
            margin: 2px 0 0;
        }

        .exp-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 99999;
        }
        .exp-modal-overlay.open {
            display: flex;
        }
        .exp-modal {
            width: 100%;
            max-width: 600px;
            background: var(--white);
            border-radius: 2px;
            outline: 1px solid var(--dark-green);
            box-shadow: 0px 4px 24px rgba(26, 61, 10, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            max-height: 90vh;
        }
        .exp-modal-header {
            background: var(--light-green);
            padding: 16px 24px;
            border-bottom: 1px solid var(--dark-green);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .exp-modal-title {
            color: var(--dark-green);
            font-size: 24px;
            font-weight: 500;
            margin: 0;
        }
        .exp-modal-subtitle {
            font-size: 13px;
            color: rgba(26, 61, 10, 0.6);
            margin: 2px 0 0;
        }
        .exp-modal-close {
            background: none;
            border: none;
            font-size: 20px;
            color: rgba(26, 61, 10, 0.5);
            cursor: pointer;
            transition: 0.2s;
        }
        .exp-modal-close:hover {
            color: var(--dark-green);
        }
        .exp-modal-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            overflow-y: auto;
            max-height: 70vh;
        }
        .exp-modal-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }
        .exp-field-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--dark-green);
        }
        .exp-modal-input {
            width: 100%;
            padding: 10px 12px;
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 2px;
            font-family: inherit;
            font-size: 14px;
            color: var(--dark-green);
            outline: none;
            box-sizing: border-box;
        }
        .exp-modal-input:focus {
            border-color: var(--dark-green);
        }
        .exp-modal-select {
            width: 100%;
            padding: 10px 12px;
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 2px;
            font-family: inherit;
            font-size: 14px;
            color: var(--dark-green);
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231A3D0A%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 12px top 50%;
            background-size: 10px auto;
            box-sizing: border-box;
        }
        .exp-modal-row {
            display: flex;
            gap: 16px;
        }
        .exp-modal-footer {
            background: var(--light-green);
            padding: 16px 24px;
            border-top: 1px solid var(--dark-green);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .exp-btn-cancel {
            background: var(--white);
            color: var(--dark-green);
            border: 1px solid var(--dark-green);
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
        }
        .exp-btn-cancel:hover {
            background: #f0f0f0;
        }
        .exp-btn-primary-form {
            background: var(--orange);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
        }
        .exp-btn-primary-form:hover {
            opacity: 0.9;
        }
        .exp-toggle {
            position: relative;
            display: inline-block;
            width: 36px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .exp-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .exp-toggle-slider {
            position: absolute;
            inset: 0;
            background: var(--light-green);
            border: 1px solid var(--dark-green);
            border-radius: 20px;
            transition: 0.2s;
        }
        .exp-toggle-slider::before {
            content: '';
            position: absolute;
            width: 14px;
            height: 14px;
            left: 2px;
            bottom: 2px;
            background: var(--dark-green);
            border-radius: 50%;
            transition: 0.2s;
        }
        .exp-toggle input:checked + .exp-toggle-slider {
            background: var(--orange);
            border-color: var(--orange);
        }
        .exp-toggle input:checked + .exp-toggle-slider::before {
            transform: translateX(16px);
            background: var(--white);
        }
        .exp-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .exp-action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: rgba(26, 61, 10, 0.5);
            transition: color 0.15s;
        }
        .exp-action-btn.edit:hover { color: var(--dark-green); }
        .exp-action-btn.delete:hover { color: #b03020; }

        .exp-btn-outline-promo {
            padding: 12px 24px;
            border-radius: 2px;
            border: 1px solid transparent;
            background: var(--orange);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            white-space: nowrap;
            transition: opacity 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .exp-btn-outline-promo:hover {
            opacity: 0.9;
        }

        .exp-card {
            background: var(--white);
            border: 1px solid var(--dark-green);
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .exp-card-title {
            font-size: 22px;
            font-weight: 400;
            color: var(--dark-green);
            margin: 0;
        }
        .exp-registry-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .notification-btn{
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
        }

        .notification-btn .material-symbols-outlined{
            font-size: 28px;
        }

        .notification-badge{
            position: absolute;
            top: -4px;
            right: -6px;

            width: 18px;
            height: 18px;

            border-radius: 50%;

            background: #D9864A;
            color: white;

            font-size: 10px;
            font-weight: 600;

            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

    @include('components.admin_sidenavbar')

    <div class="main-content-wrapper">
        
        <div class="top-navbar">
                    <a href="{{ route('admin.notification.index') }}" class="notification-btn">

                        <span class="material-symbols-outlined">
                            notifications
                        </span>

                        @if(($unreadCount ?? 0) > 0)
                            <span class="notification-badge">
                                {{ $unreadCount }}
                            </span>
                        @endif

                    </a>
                    <a href="{{ route('admin.settings', [
                        'section' => 'general',
                        'sub' => 'profile'
                    ]) }}">
                        <img src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) : asset('images/admin/profile.png') }}"
                            alt="User profile"
                            width="40"
                            height="40">
                    </a>        
                </div>

        <div class="main-container">
            
           <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 30px;">
    
                <h1 style="margin: 0; font-size: 32px; font-weight: 400; color: #1A3D0A; font-family: 'Times New Roman', serif;">
                    Manage Rooms & Beds
                </h1>
                
                <div style="display: flex; gap: 16px;">
                    <button class="exp-btn-outline-promo" onclick="openPromoModal()">+ Promo Code</button>
                    <button id="openRoomModal" type="button" style="display: inline-flex; align-items: center; gap: 8px; background-color: #D9864A; color: white; border: none; padding: 12px 24px; font-size: 16px; font-weight: bold; font-family: 'DM Sans', sans-serif; border-radius: 4px; cursor: pointer;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add a New Room
                    </button>
                    <button id="openAddAdditionalModal" type="button" style="display: inline-flex; align-items: center; gap: 8px; background-color: #D9864A; color: white; border: none; padding: 12px 24px; font-size: 16px; font-weight: bold; font-family: 'DM Sans', sans-serif; border-radius: 4px; cursor: pointer;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Additional
                    </button>
                </div>
                
            </div>

            <div class="cards-grid">
                @php
                    $rooms = $rooms ?? collect();
                @endphp

                @if ($rooms->count())
                    @foreach ($rooms as $room)
                        @php
                            $roomPhoto = $room->photo ? asset('storage/' . $room->photo) : asset('images/Background.png');
                            $roomGender = $room->gender_type ?: 'Male';
                            $genderLabel = $roomGender === 'Female' ? 'FEMALE ONLY' : ($roomGender === 'Mixed' ? 'MIXED' : 'MALE ONLY');
                            $genderTagClass = $roomGender === 'Female' ? 'tag-orange' : ($roomGender === 'Mixed' ? 'tag-white' : 'tag-dark');
                            $status = strtolower((string) $room->status);
                            $statusLabel = $room->status ?: 'Active';
                            $statusTagClass = $status === 'available' || $status === 'active' ? 'tag-green' : 'tag-white';
                            $statusText = $status === 'available' || $status === 'active' ? 'ACTIVE' : strtoupper($statusLabel);
                            $amenities = array_values(array_filter(array_map('trim', explode(',', (string) $room->main_facilities))));
                            $attributes = array_values(array_filter(array_map('trim', explode(',', (string) $room->attributes))));
                        @endphp

                        <div class="card">
                            <div class="card-image-wrapper">
                                <img src="{{ $roomPhoto }}" alt="{{ $room->name }}">
                                <div class="card-tags">
                                    <span class="tag {{ $genderTagClass }}">{{ $genderLabel }}</span>
                                    <span class="tag {{ $statusTagClass }}">{{ $statusText }}</span>
                                    @foreach ($attributes as $attribute)
                                        <span class="tag tag-white">{{ strtoupper($attribute) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-header">
                                    <h2 class="card-title">{{ $room->name }}</h2>
                                    <div class="bed-count">
                                        <svg width="16" height="16" viewBox="0 0 24 24"><path d="M20 10V7A2 2 0 0 0 18 5H6A2 2 0 0 0 4 7V10A2 2 0 0 0 2 12V20H4V17H20V20H22V12A2 2 0 0 0 20 10ZM14 7H18V10H14V7ZM6 7H10V10H6V7ZM4 12H20V15H4V12Z"/></svg>
                                        {{ $room->capacity }} Beds
                                    </div>
                                </div>
                                <p class="card-desc sans-serif">{{ \Illuminate\Support\Str::limit($room->description ?? 'No description provided.', 80) }}</p>

                                <div class="amenities sans-serif">
                                    @if (count($amenities))
                                        @foreach ($amenities as $amenity)
                                            @php
                                                $amenityKey = strtolower(trim($amenity));
                                            @endphp
                                            <div class="amenity-item">
                                                @if ($amenityKey === 'wifi' || $amenityKey === 'wi-fi')
                                                    <svg viewBox="0 0 24 24"><path d="M12 21L15.6 16.2C14.6 15.4 13.4 15 12 15C10.6 15 9.4 15.4 8.4 16.2L12 21ZM12 11C9.3 11 6.8 12.1 5 13.9L6.4 15.3C7.9 13.8 9.9 13 12 13C14.1 13 16.1 13.8 17.6 15.3L19 13.9C17.2 12.1 14.7 11 12 11ZM12 7C8.2 7 4.7 8.5 2.1 11L3.5 12.4C5.7 10.3 8.7 9 12 9C15.3 9 18.3 10.3 20.5 12.4L21.9 11C19.3 8.5 15.8 7 12 7ZM12 3C6.9 3 2.3 5 0 8.3L1.4 9.7C3.3 6.8 7.4 5 12 5C16.6 5 20.7 6.8 22.6 9.7L24 8.3C21.7 5 17.1 3 12 3Z"/></svg>
                                                @elseif ($amenityKey === 'ac')
                                                    <img src="{{ asset('images/AC.svg') }}" alt="AC Icon" style="width: 20px; height: 20px;">
                                                @elseif ($amenityKey === 'loker' || $amenityKey === 'locker' || $amenityKey === 'lockers')
                                                    <svg viewBox="0 0 24 24"><path d="M18 8H17V6C17 3.24 14.76 1 12 1C9.24 1 7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM9 6C9 4.34 10.34 3 12 3C13.66 3 15 4.34 15 6V8H9V6ZM12 17C10.9 17 10 16.1 10 15C10 13.9 10.9 13 12 13C13.1 13 14 13.9 14 15C14 16.1 13.1 17 12 17Z"/></svg>
                                                @elseif ($amenityKey === 'shared' || $amenityKey === 'shower' || $amenityKey === 'en-suite bath' || $amenityKey === 'ensuite bath' || $amenityKey === 'en suite bath')
                                                    <img src="{{ asset('images/shower.svg') }}" alt="Shared Icon" style="width: 20px; height: 20px;">
                                                @else
                                                    <span>{{ strtoupper($amenity) }}</span>
                                                @endif
                                                <span>{{ strtoupper($amenity) }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="amenity-item">
                                            <span>No facilities</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <button class="btn btn-full edit-room-btn" type="button" data-room-id="{{ $room->id }}">Edit Room Profile</button>
                                <button class="btn btn-full btn-outline-green btn-with-icon floor-plan-btn" type="button" data-open-floor-modal data-room-id="{{ $room->id }}">
                                    <img src="{{ asset('images/peta.svg') }}" alt="Map" class="btn-icon">
                                    <span>Manage Floor Plans</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="grid-column: 1 / -1; padding: 24px; border: 1px dashed var(--dark-green); border-radius: 8px; text-align: center; background: rgba(184, 217, 160, 0.15);">
                        No rooms available. Please add a new room to get started.
                    </div>
                @endif
            </div>

            <div class="table-section">
                <div class="table-header-bar">
                    <h2 class="table-header-title">Price & Status Bed Management</h2>
                    <div class="table-controls">
                    <select id="bedRoomSelect" class="dropdown">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" @selected((int) ($selectedRoomId ?? 0) === (int) $room->id)>
                                {{ $room->name }} - {{ $room->capacity }} Beds
                            </option>
                        @endforeach
                    </select>
                    
                    <button id="openBedModal" class="btn sans-serif" type="button" style="height: 36px; padding: 0 16px; font-size: 14px; border: 1px solid var(--orange); box-sizing: border-box;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Bed
                    </button>
                </div>
                </div>
                
               <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Position</th>
            <th>Price / Night</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($selectedRoom?->beds ?? collect() as $bed)
            @php
                $bedStatus = strtolower((string) $bed->status);
                // Cek jika statusnya occupied, maintenance, atau maintance, gunakan class status-maintenance
                $bedStatusClass = ($bedStatus === 'occupied' || $bedStatus === 'maintenance' || $bedStatus === 'maintance') 
                    ? 'status-maintenance' 
                    : 'status-tersedia';
                $bedStatusLabel = strtoupper($bed->status ?: 'Available');
            @endphp
            <tr>
                <td>{{ $bed->name }}</td>
                <td>{{ $bed->position }}</td>
                <td>
                    <div class="price-wrapper">
                        <strong>IDR</strong> <span>{{ number_format((float) $bed->base_price, 0, ',', '.') }}</span>
                    </div>
                </td>
                <td><span class="status-badge {{ $bedStatusClass }}">{{ $bedStatusLabel }}</span></td>
                <td>
                    <div class="actions">
                        <button class="icon-btn" type="button" data-bed-edit-id="{{ $bed->id }}" aria-label="Edit bed">
                            <svg viewBox="0 0 24 24"><path d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z"/></svg>
                        </button>
                        <button class="icon-btn" type="button" data-bed-delete-id="{{ $bed->id }}" aria-label="Delete bed">
                            <img src="{{ asset('images/delete.svg') }}" alt="Delete bed" style="width:18px;height:18px;display:block;">
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center; padding: 24px; color: var(--dark-green);">
                    No beds found for this room.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
            </div>

            {{-- Promo Codes --}}
            <div class="exp-card">
                <div class="exp-registry-header">
                    <h2 class="exp-card-title">Promo Codes</h2>
                    <button type="button" class="exp-btn-outline-promo" onclick="openPromoModal()">+ Promo Code</button>
                </div>

                <table class="promo-table" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="padding:12px 18px;font-size:14px;font-weight:700;color:var(--dark-green);background:var(--light-green);border-bottom:1px solid var(--dark-green);text-align:left;">Promo Code</th>
                            <th style="padding:12px 18px;font-size:14px;font-weight:700;color:var(--dark-green);background:var(--light-green);border-bottom:1px solid var(--dark-green);text-align:left;">Discount</th>
                            <th style="padding:12px 18px;font-size:14px;font-weight:700;color:var(--dark-green);background:var(--light-green);border-bottom:1px solid var(--dark-green);text-align:left;">Validity Period</th>
                            <th style="padding:12px 18px;font-size:14px;font-weight:700;color:var(--dark-green);background:var(--light-green);border-bottom:1px solid var(--dark-green);text-align:left;">Quota</th>
                            <th style="padding:12px 18px;font-size:14px;font-weight:700;color:var(--dark-green);background:var(--light-green);border-bottom:1px solid var(--dark-green);text-align:left;">Status</th>
                            <th style="padding:12px 18px;font-size:14px;font-weight:700;color:var(--dark-green);background:var(--light-green);border-bottom:1px solid var(--dark-green);text-align:left;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="promoTableBody">
                        {{-- Rendered by JS --}}
                    </tbody>
                </table>

                <div class="promo-table-footer">
                    <span class="promo-count-label" id="promoCountLabel">Showing 0 promo codes</span>
                    <div class="promo-pagination">
                        <button class="promo-page-btn" onclick="promoChangePage(-1)">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                        </button>
                        <button class="promo-page-btn" onclick="promoChangePage(1)">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Add / Edit Promo Code --}}
    <div class="exp-modal-overlay" id="promoModal">
        <div class="exp-modal" style="max-width:480px;">
            <div class="exp-modal-header">
                <div>
                    <h2 class="exp-modal-title" id="promoModalTitle">Add Promo Code</h2>
                    <p class="exp-modal-subtitle">Set up a discount code for your guests.</p>
                </div>
                <button class="exp-modal-close" onclick="closePromoModal()">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <div class="exp-modal-body" style="gap:20px;">

                {{-- Promo Code --}}
                <div class="exp-modal-field">
                    <label class="exp-field-label">PROMO CODE</label>
                    <input type="text" class="exp-modal-input promo-code-input" id="promoCode"
                        placeholder="e.g., ALASAREZEN">
                </div>

                {{-- Date Row --}}
                <div class="exp-modal-row">
                    <div class="exp-modal-field">
                        <label class="exp-field-label">START DATE</label>
                        <div class="promo-date-wrap">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="promo-date-icon">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <input type="date" class="exp-modal-input promo-date-input" id="promoStartDate">
                        </div>
                    </div>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">END DATE</label>
                        <div class="promo-date-wrap">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="promo-date-icon">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <input type="date" class="exp-modal-input promo-date-input" id="promoEndDate">
                        </div>
                    </div>
                </div>

                {{-- Discount Row --}}
                <div class="exp-modal-row">
                    <div class="exp-modal-field">
                        <label class="exp-field-label">DISCOUNT VALUE</label>
                        <input type="number" class="exp-modal-input" id="promoDiscountValue" placeholder="e.g, 10" min="0">
                    </div>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">DISCOUNT TYPE</label>
                        <select class="exp-modal-select" id="promoDiscountType">
                            <option value="percentage">percentage %</option>
                            <option value="flat">flat IDR</option>
                        </select>
                    </div>
                </div>

                {{-- Quota + Status --}}
                <div class="exp-modal-row" style="align-items:flex-start;">
                    <div class="exp-modal-field">
                        <label class="exp-field-label">QUOTA</label>
                        <input type="number" class="exp-modal-input" id="promoQuota" placeholder="0" min="0" value="0">
                    </div>
                    <div class="exp-modal-field">
                        <label class="exp-field-label">STATUS</label>
                        <div class="promo-status-box">
                            <label class="exp-toggle">
                                <input type="checkbox" id="promoStatusToggle" checked>
                                <span class="exp-toggle-slider"></span>
                            </label>
                            <div>
                                <p class="promo-status-main" id="promoStatusLabel">Enable</p>
                                <p class="promo-status-hint">Enable or disable this code instantly</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="exp-modal-footer">
                <button class="exp-btn-cancel" onclick="closePromoModal()">Cancel</button>
                <button class="exp-btn-primary-form" onclick="savePromoCode()">Save</button>
            </div>
        </div>
    </div>

    <script>
(function(){
    // Fungsi untuk menutup semua tipe modal
    function closeInjectedModal() {
        ['addNewRoomContainer', 'editNewRoomContainer', 'addNewBedContainer', 'addNewFloorContainer', 'addAdditionalContainer'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.remove();
        });
        document.body.classList.remove('modal-open');
    }

    // FUNGSI INTI (DRY - Don't Repeat Yourself)
    // Menangani semua fetch AJAX dan eksekusi ulang script di dalam modal
    async function fetchAndInjectModal(url, containerId, modalId) {
        try {
            const res = await fetch(url, { credentials: 'same-origin' });
            if (!res.ok) throw new Error(res.status + ' ' + res.statusText);
            const html = await res.text();

            // Hapus container lama jika ada
            const existing = document.getElementById(containerId);
            if (existing) existing.remove();

            // Buat container baru
            const container = document.createElement('div');
            container.id = containerId;
            container.innerHTML = html;
            document.body.appendChild(container);

            // Eksekusi ulang tag <script> yang terbawa dari file blade modal
            const scripts = container.querySelectorAll('script');
            scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                newScript.textContent = oldScript.textContent;
                newScript.async = false;
                oldScript.parentNode.replaceChild(newScript, oldScript);
            });

            // Tampilkan modalnya
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.hidden = false;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
            }

            // Pasang fungsi close ke tombol 'X' atau 'Cancel'
            const closeSelector = `[data-${modalId.replace('Modal', '')}-modal-close], .floor-modal__close`;
            document.querySelectorAll(closeSelector).forEach(btn => {
                btn.addEventListener('click', closeInjectedModal);
            });

            // Klik overlay hitam untuk close
            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeInjectedModal();
                });
            }
        } catch (err) {
            console.error(`Error loading modal from ${url}:`, err);
        }
    }

    // BUNGKUSAN FUNGSI PEMANGGIL
    window.openAddNewRoom = () => fetchAndInjectModal('/admin/add-new-room-popup', 'addNewRoomContainer', 'roomModal');

    window.openAddAdditional = () => fetchAndInjectModal('/admin/add-additional-popup', 'addAdditionalContainer', 'additionalModal');
    
    window.openEditRoom = (roomId) => fetchAndInjectModal(`/admin/rooms/${roomId}/edit-popup`, 'editNewRoomContainer', 'roomModal');
    
    // Perbaikan: Bawa roomId ke modal map
    window.openAddNewFloor = (roomId) => {
        const cacheBuster = `_t=${Date.now()}`;
        const url = roomId 
            ? `/admin/add-new-floor-popup?room_id=${roomId}&${cacheBuster}` 
            : `/admin/add-new-floor-popup?${cacheBuster}`;
        fetchAndInjectModal(url, 'addNewFloorContainer', 'floorModal');
    };

    window.openAddNewBed = () => {
        const roomSelect = document.getElementById('bedRoomSelect');
        const roomId = roomSelect ? roomSelect.value : '';
        const url = roomId ? `/admin/add-new-bed-popup?room_id=${encodeURIComponent(roomId)}` : '/admin/add-new-bed-popup';
        fetchAndInjectModal(url, 'addNewBedContainer', 'bedModal');
    };

    window.openEditBed = (bedId) => {
        const roomSelect = document.getElementById('bedRoomSelect');
        const roomId = roomSelect ? roomSelect.value : '';
        const url = roomId
            ? `/admin/beds/${bedId}/edit-popup?room_id=${encodeURIComponent(roomId)}`
            : `/admin/beds/${bedId}/edit-popup`;
        fetchAndInjectModal(url, 'editNewBedContainer', 'bedModal');
    };

    // TRIGGER TOMBOL DI HALAMAN UTAMA
    document.getElementById('openRoomModal')?.addEventListener('click', window.openAddNewRoom);
    document.getElementById('openAddAdditionalModal')?.addEventListener('click', window.openAddAdditional);
    document.getElementById('openBedModal')?.addEventListener('click', window.openAddNewBed);

    document.querySelectorAll('.edit-room-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const roomId = this.getAttribute('data-room-id');
            if (roomId) window.openEditRoom(roomId);
        });
    });

    document.querySelectorAll('[data-open-floor-modal]').forEach(btn => {
        btn.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            window.openAddNewFloor(roomId);
        });
    });

    document.querySelectorAll('[data-bed-edit-id]').forEach(btn => {
        btn.addEventListener('click', function () {
            const bedId = this.getAttribute('data-bed-edit-id');
            if (bedId) window.openEditBed(bedId);
        });
    });

    // TRIGGER DROPDOWN SELECT ROOM
    const bedRoomSelect = document.getElementById('bedRoomSelect');
    if (bedRoomSelect) {
        bedRoomSelect.addEventListener('change', function () {
            const url = new URL(window.location.href);
            url.searchParams.set('room_id', this.value);
            window.location.href = url.toString();
        });
    }

    // CSRF TOKEN SETUP
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

    // AJAX DELETE BED
    document.querySelectorAll('[data-bed-delete-id]').forEach(btn => {
        btn.addEventListener('click', async function () {
            const bedId = this.getAttribute('data-bed-delete-id');
            if (!bedId || !window.confirm('Hapus bed ini?')) return;

            const fd = new FormData();
            fd.append('_method', 'DELETE');
            if (csrfToken) fd.append('_token', csrfToken);

            try {
                const response = await fetch(`/admin/beds/${bedId}`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: fd,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        ...(csrfToken && {'X-CSRF-TOKEN': csrfToken})
                    },
                });

                const rawText = await response.text();
                let json = {};

                try {
                    json = rawText ? JSON.parse(rawText) : {};
                } catch (parseError) {
                    json = { message: rawText || 'Gagal menghapus bed' };
                }

                if (response.ok && json.success) {
                    window.location.reload();
                } else {
                    alert(json.message || 'Gagal menghapus bed');
                }
            } catch (err) {
                console.error('Delete bed error', err);
                alert('Delete bed failed: ' + err.message);
            }
        });
    });

    // EVENT DELEGATION UNTUK SUBMIT FORM (Solusi agar form AJAX tetap terbaca)
    document.addEventListener('submit', async function(e) {
        // Cek kalau form yang di-submit punya ID 'addRoomForm' (Sesuaikan kalau ID form bed beda)
        if (e.target && e.target.id === 'addRoomForm') {
            e.preventDefault();
            const form = e.target;
            const fd = new FormData(form);
            
            try {
                const res = await fetch('/admin/rooms', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: fd
                });
                
                const json = await res.json();
                if (json.success) {
                    closeInjectedModal();
                    window.location.reload();
                } else {
                    alert('Gagal: ' + (json.message || 'Silakan cek kembali inputan Anda.'));
                }
            } catch (err) {
                console.error('Submit form error:', err);
                alert('Terjadi kesalahan pada server.');
            }
        }
    });

    window.closeInjectedModal = closeInjectedModal;
})();
</script>

<script>
// ══════════════════════════════════════════
// PROMO CODE
// ══════════════════════════════════════════
const PROMO_TYPE = 'room';
const PROMO_PER_PAGE = 3;
let promoPage        = 1;
let editingPromoId   = null;
let promoCodes = [];

const csrfMeta = document.querySelector('meta[name="csrf-token"]');
const ROOM_CSRF = csrfMeta ? csrfMeta.getAttribute('content') : '';

async function fetchPromoCodes() {
    try {
        const res = await fetch(`/admin/promo-codes?type=${PROMO_TYPE}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) promoCodes = data.promoCodes;
    } catch (err) {
        console.error('Fetch promo codes error:', err);
    }
    renderPromoTable();
}

function formatPromoDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
}

function getValidityMeta(startDate, endDate, status) {
    if (status === 'non-active') return { label: 'Expired', cls: 'expired' };
    const now   = new Date(); now.setHours(0,0,0,0);
    const start = new Date(startDate);
    const end   = new Date(endDate);
    if (now < start) {
        const days = Math.ceil((start - now) / 86400000);
        return { label: `Starts in ${days} day${days !== 1 ? 's' : ''}`, cls: 'upcoming' };
    }
    if (now > end) return { label: 'Expired', cls: 'expired' };
    const remaining = Math.ceil((end - now) / 86400000);
    return { label: `${remaining} Day${remaining !== 1 ? 's' : ''} remaining`, cls: 'remaining' };
}

function renderPromoTable() {
    const tbody  = document.getElementById('promoTableBody');
    const total  = promoCodes.length;
    const start  = (promoPage - 1) * PROMO_PER_PAGE;
    const paged  = promoCodes.slice(start, start + PROMO_PER_PAGE);

    if (paged.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:28px;color:rgba(26,61,10,0.4);font-size:13px;">No promo codes yet.</td></tr>`;
    } else {
        tbody.innerHTML = paged.map(p => {
            const discountVal = parseFloat(p.discount_value ?? p.discountValue);
            const discountLabel = (p.discount_type ?? p.discountType) === 'percentage'
                ? `${discountVal}%`
                : `IDR ${discountVal.toLocaleString('id-ID')}`;
            const meta = getValidityMeta(p.start_date ?? p.startDate, p.end_date ?? p.endDate, p.status);
            const statusBadge = p.status === 'active'
                ? `<span class="promo-status-badge active">Active</span>`
                : `<span class="promo-status-badge non-active">Non-active</span>`;
            return `
            <tr>
                <td class="promo-code-cell">${p.code}</td>
                <td class="promo-discount-cell">${discountLabel}</td>
                <td class="promo-validity-cell">
                    <span>${formatPromoDate(p.start_date ?? p.startDate)} –</span><br>
                    <span>${formatPromoDate(p.end_date ?? p.endDate)}</span>
                    <div class="promo-validity-meta ${meta.cls}">${meta.label}</div>
                </td>
                <td class="promo-quota-cell">${p.used} / ${p.quota}</td>
                <td>${statusBadge}</td>
                <td>
                    <div class="exp-actions">
                        <button class="exp-action-btn edit" onclick="openEditPromoModal(${p.id})">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                        <button class="exp-action-btn delete" onclick="deletePromoCode(${p.id})">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6M14 11v6"/>
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    const activeCount = promoCodes.filter(p => p.status === 'active').length;
    document.getElementById('promoCountLabel').textContent =
        `Showing ${Math.min(paged.length, PROMO_PER_PAGE)} of ${total} promo codes (${activeCount} active)`;
}

function promoChangePage(delta) {
    const maxPage = Math.max(1, Math.ceil(promoCodes.length / PROMO_PER_PAGE));
    promoPage = Math.max(1, Math.min(promoPage + delta, maxPage));
    renderPromoTable();
}

function openPromoModal() {
    editingPromoId = null;
    document.getElementById('promoModalTitle').textContent    = 'Add Promo Code';
    document.getElementById('promoCode').value                = '';
    document.getElementById('promoStartDate').value           = '';
    document.getElementById('promoEndDate').value             = '';
    document.getElementById('promoDiscountValue').value       = '';
    document.getElementById('promoDiscountType').value        = 'percentage';
    document.getElementById('promoQuota').value               = '0';
    document.getElementById('promoStatusToggle').checked      = true;
    document.getElementById('promoStatusLabel').textContent   = 'Enable';
    document.getElementById('promoModal').classList.add('open');
}
function closePromoModal() { document.getElementById('promoModal').classList.remove('open'); }
document.getElementById('promoModal').addEventListener('click', e => { if (e.target === e.currentTarget) closePromoModal(); });

document.getElementById('promoStatusToggle').addEventListener('change', function () {
    document.getElementById('promoStatusLabel').textContent = this.checked ? 'Enable' : 'Disable';
});
document.getElementById('promoCode').addEventListener('input', function () {
    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
});

function openEditPromoModal(id) {
    const p = promoCodes.find(x => x.id === id);
    if (!p) return;
    editingPromoId = id;
    document.getElementById('promoModalTitle').textContent   = 'Edit Promo Code';
    document.getElementById('promoCode').value               = p.code;
    document.getElementById('promoStartDate').value          = p.start_date ?? p.startDate;
    document.getElementById('promoEndDate').value            = p.end_date ?? p.endDate;
    document.getElementById('promoDiscountValue').value      = p.discount_value ?? p.discountValue;
    document.getElementById('promoDiscountType').value       = p.discount_type ?? p.discountType;
    document.getElementById('promoQuota').value              = p.quota;
    document.getElementById('promoStatusToggle').checked     = p.status === 'active';
    document.getElementById('promoStatusLabel').textContent  = p.status === 'active' ? 'Enable' : 'Disable';
    document.getElementById('promoModal').classList.add('open');
}

async function savePromoCode() {
    const code   = document.getElementById('promoCode').value.trim();
    const start  = document.getElementById('promoStartDate').value;
    const end    = document.getElementById('promoEndDate').value;
    const value  = document.getElementById('promoDiscountValue').value;
    const type   = document.getElementById('promoDiscountType').value;
    const quota  = parseInt(document.getElementById('promoQuota').value) || 0;
    const status = document.getElementById('promoStatusToggle').checked ? 'active' : 'non-active';

    if (!code || !start || !end || !value) {
        alert('Please fill in all required fields.');
        return;
    }
    if (new Date(end) < new Date(start)) {
        alert('End date must be after start date.');
        return;
    }

    const body = { code, start_date: start, end_date: end, discount_value: value, discount_type: type, quota, status, _token: ROOM_CSRF };
    const url = editingPromoId !== null
        ? `/admin/promo-codes/${editingPromoId}/update`
        : '/admin/promo-codes/store';
    if (editingPromoId === null) body.type = PROMO_TYPE;

    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': ROOM_CSRF },
            body: JSON.stringify(body),
        });
        const data = await res.json();
        if (data.success) {
            closePromoModal();
            await fetchPromoCodes();
        } else {
            alert(data.message || 'Failed to save promo code.');
        }
    } catch (err) {
        alert('Error saving promo code: ' + err.message);
    }
}

async function deletePromoCode(id) {
    if (!confirm('Delete this promo code? This cannot be undone.')) return;
    try {
        const res = await fetch(`/admin/promo-codes/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': ROOM_CSRF, 'Accept': 'application/json' },
        });
        const data = await res.json();
        if (data.success) await fetchPromoCodes();
    } catch (err) {
        alert('Error deleting promo code: ' + err.message);
    }
}

// Init
fetchPromoCodes();
</script>
</body>
</html>