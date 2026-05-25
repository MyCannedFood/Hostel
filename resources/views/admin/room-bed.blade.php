<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms & Beds</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=EB+Garamond:wght@400;500;600&display=swap" rel="stylesheet">
    
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
        }

        .tag {
            padding: 4px 12px;
            font-size: 11px;
            font-family: 'EB Garamond', serif;
            letter-spacing: 1px;
            border-radius: 2px;
            text-transform: uppercase;
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

    </style>
</head>
<body>

    @include('components.admin_sidenavbar')

    <div class="main-content-wrapper">
        
        <div class="top-navbar">
             <img src="{{ asset('images/admin/img_button_trailing.svg') }}" alt="Menu" width="34" height="28">
                    <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
        </div>

        <div class="main-container">
            
           <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 30px;">
    
                <h1 style="margin: 0; font-size: 32px; font-weight: 400; color: #1A3D0A; font-family: 'Times New Roman', serif;">
                    Manage Rooms & Beds
                </h1>
                
                <button style="display: inline-flex; align-items: center; gap: 8px; background-color: #D9864A; color: white; border: none; padding: 12px 24px; font-size: 16px; font-weight: bold; font-family: 'DM Sans', sans-serif; border-radius: 4px; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add a New Room
                </button>
                
            </div>

            <div class="cards-grid">
                
                <div class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/Background.png') }}" alt="Serene Haven">
                        <div class="card-tags">
                            <span class="tag tag-dark">MALE ONLY</span>
                            <span class="tag tag-green">ACTIVE</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-header">
                            <h2 class="card-title">Serene Haven</h2>
                            <div class="bed-count">
                                <svg width="16" height="16" viewBox="0 0 24 24"><path d="M20 10V7A2 2 0 0 0 18 5H6A2 2 0 0 0 4 7V10A2 2 0 0 0 2 12V20H4V17H20V20H22V12A2 2 0 0 0 20 10ZM14 7H18V10H14V7ZM6 7H10V10H6V7ZM4 12H20V15H4V12Z"/></svg>
                                8 Beds
                            </div>
                        </div>
                        <p class="card-desc sans-serif">A functional and minimalist space designed for maximum...</p>
                        
                        <div class="amenities sans-serif">
                            <div class="amenity-item">
                                <svg viewBox="0 0 24 24"><path d="M12 21L15.6 16.2C14.6 15.4 13.4 15 12 15C10.6 15 9.4 15.4 8.4 16.2L12 21ZM12 11C9.3 11 6.8 12.1 5 13.9L6.4 15.3C7.9 13.8 9.9 13 12 13C14.1 13 16.1 13.8 17.6 15.3L19 13.9C17.2 12.1 14.7 11 12 11ZM12 7C8.2 7 4.7 8.5 2.1 11L3.5 12.4C5.7 10.3 8.7 9 12 9C15.3 9 18.3 10.3 20.5 12.4L21.9 11C19.3 8.5 15.8 7 12 7ZM12 3C6.9 3 2.3 5 0 8.3L1.4 9.7C3.3 6.8 7.4 5 12 5C16.6 5 20.7 6.8 22.6 9.7L24 8.3C21.7 5 17.1 3 12 3Z"/></svg>
                                WI-FI
                            </div>
                            <div class="amenity-item">
                                    <img src="{{ asset('images/AC.svg') }}" alt="AC Icon" style="width: 20px; height: 20px;">
                                    AC
                                </div>
                            <div class="amenity-item">
                                <svg viewBox="0 0 24 24"><path d="M18 8H17V6C17 3.24 14.76 1 12 1C9.24 1 7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM9 6C9 4.34 10.34 3 12 3C13.66 3 15 4.34 15 6V8H9V6ZM12 17C10.9 17 10 16.1 10 15C10 13.9 10.9 13 12 13C13.1 13 14 13.9 14 15C14 16.1 13.1 17 12 17Z"/></svg>
                                LOKER
                            </div>
                            <div class="amenity-item">
                                    <img src="{{ asset('images/shower.svg') }}" alt="Shared Icon" style="width: 20px; height: 20px;">
                                    SHARED
                            </div>
                        </div>
                        <button class="btn btn-full">Edit Room Profile</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/rooms/room_2.png') }}" alt="Botanika">
                        <div class="card-tags">
                            <span class="tag tag-dark">MALE ONLY</span>
                            <span class="tag tag-green">ACTIVE</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-header">
                            <h2 class="card-title">Botanika</h2>
                            <div class="bed-count">
                                <svg width="16" height="16" viewBox="0 0 24 24"><path d="M20 10V7A2 2 0 0 0 18 5H6A2 2 0 0 0 4 7V10A2 2 0 0 0 2 12V20H4V17H20V20H22V12A2 2 0 0 0 20 10ZM14 7H18V10H14V7ZM6 7H10V10H6V7ZM4 12H20V15H4V12Z"/></svg>
                                6 Beds
                            </div>
                        </div>
                        <p class="card-desc sans-serif">Tropical atmosphere with natural lighting and extra...</p>
                        
                        <div class="amenities sans-serif">
                            <div class="amenity-item">
                                <svg viewBox="0 0 24 24"><path d="M12 21L15.6 16.2C14.6 15.4 13.4 15 12 15C10.6 15 9.4 15.4 8.4 16.2L12 21ZM12 11C9.3 11 6.8 12.1 5 13.9L6.4 15.3C7.9 13.8 9.9 13 12 13C14.1 13 16.1 13.8 17.6 15.3L19 13.9C17.2 12.1 14.7 11 12 11ZM12 7C8.2 7 4.7 8.5 2.1 11L3.5 12.4C5.7 10.3 8.7 9 12 9C15.3 9 18.3 10.3 20.5 12.4L21.9 11C19.3 8.5 15.8 7 12 7ZM12 3C6.9 3 2.3 5 0 8.3L1.4 9.7C3.3 6.8 7.4 5 12 5C16.6 5 20.7 6.8 22.6 9.7L24 8.3C21.7 5 17.1 3 12 3Z"/></svg>
                                WI-FI
                            </div>
                            <div class="amenity-item">
                                <img src="{{ asset('images/AC.svg') }}" alt="AC Icon" style="width: 20px; height: 20px;">
                                AC
                            </div>
                            <div class="amenity-item">
                                <svg viewBox="0 0 24 24"><path d="M18 8H17V6C17 3.24 14.76 1 12 1C9.24 1 7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM9 6C9 4.34 10.34 3 12 3C13.66 3 15 4.34 15 6V8H9V6ZM12 17C10.9 17 10 16.1 10 15C10 13.9 10.9 13 12 13C13.1 13 14 13.9 14 15C14 16.1 13.1 17 12 17Z"/></svg>
                                LOKER
                            </div>
                            <div class="amenity-item">
                                <img src="{{ asset('images/shower.svg') }}" alt="Shower Icon" style="width: 20px; height: 20px;">
                                SHARED
                            </div>
                        </div>
                        <button class="btn btn-full">Edit Room Profile</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/The Heritage Room.png') }}" alt="The Heritage">
                        <div class="card-tags">
                            <span class="tag tag-orange">FEMALE ONLY</span>
                            <span class="tag tag-white">NOT ACTIVE</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-header">
                            <h2 class="card-title">The Heritage</h2>
                            <div class="bed-count">
                                <svg width="16" height="16" viewBox="0 0 24 24"><path d="M20 10V7A2 2 0 0 0 18 5H6A2 2 0 0 0 4 7V10A2 2 0 0 0 2 12V20H4V17H20V20H22V12A2 2 0 0 0 20 10ZM14 7H18V10H14V7ZM6 7H10V10H6V7ZM4 12H20V15H4V12Z"/></svg>
                                8 Beds
                            </div>
                        </div>
                        <p class="card-desc sans-serif">Classic Javanese royal aesthetic for couples or friends.</p>
                        
                        <div class="amenities sans-serif">
                            <div class="amenity-item">
                                <svg viewBox="0 0 24 24"><path d="M12 21L15.6 16.2C14.6 15.4 13.4 15 12 15C10.6 15 9.4 15.4 8.4 16.2L12 21ZM12 11C9.3 11 6.8 12.1 5 13.9L6.4 15.3C7.9 13.8 9.9 13 12 13C14.1 13 16.1 13.8 17.6 15.3L19 13.9C17.2 12.1 14.7 11 12 11ZM12 7C8.2 7 4.7 8.5 2.1 11L3.5 12.4C5.7 10.3 8.7 9 12 9C15.3 9 18.3 10.3 20.5 12.4L21.9 11C19.3 8.5 15.8 7 12 7ZM12 3C6.9 3 2.3 5 0 8.3L1.4 9.7C3.3 6.8 7.4 5 12 5C16.6 5 20.7 6.8 22.6 9.7L24 8.3C21.7 5 17.1 3 12 3Z"/></svg>
                                WI-FI
                            </div>
                            <div class="amenity-item">
                                <img src="{{ asset('images/AC.svg') }}" alt="AC Icon" style="width: 20px; height: 20px;">
                                AC
                            </div>
                            <div class="amenity-item">
                                <svg viewBox="0 0 24 24"><path d="M18 8H17V6C17 3.24 14.76 1 12 1C9.24 1 7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM9 6C9 4.34 10.34 3 12 3C13.66 3 15 4.34 15 6V8H9V6ZM12 17C10.9 17 10 16.1 10 15C10 13.9 10.9 13 12 13C13.1 13 14 13.9 14 15C14 16.1 13.1 17 12 17Z"/></svg>
                                LOKER
                            </div>
                            <div class="amenity-item">
                                <img src="{{ asset('images/shower.svg') }}" alt="Shower Icon" style="width: 20px; height: 20px;">
                                SHARED
                            </div>
                        </div>
                        <button class="btn btn-full">Edit Room Profile</button>
                    </div>
                </div>
                
            </div>

            <div class="table-section">
                <div class="table-header-bar">
                    <h2 class="table-header-title">Price & Status Bed Management</h2>
                    <div class="table-controls">
                    <select class="dropdown">
                        <option>Serene Haven - 8 Beds</option>
                    </select>
                    
                    <button class="btn sans-serif" style="height: 36px; padding: 0 16px; font-size: 14px; border: 1px solid var(--orange); box-sizing: border-box;">
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
        <tr>
            <td>SH-1T</td>
            <td>1 - Top Bed</td>
            <td>
                <div class="price-wrapper">
                    <strong>IDR</strong> <span>117.500</span>
                </div>
            </td>
            <td><span class="status-badge status-tersedia">TERSEDIA</span></td>
            <td>
                <div class="actions">
                    <button class="icon-btn">
                        <svg viewBox="0 0 24 24"><path d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z"/></svg>
                    </button>
                    <div class="toggle on">
                        <div class="knob"></div>
                    </div>
                </div>
            </td>
        </tr>
        
        <tr>
            <td>SH-1B</td>
            <td>1 - Bottom Bed</td>
            <td>
                <div class="price-wrapper">
                    <strong>IDR</strong> <span>125.000</span>
                </div>
            </td>
            <td><span class="status-badge status-tersedia">TERSEDIA</span></td>
            <td>
                <div class="actions">
                    <button class="icon-btn">
                        <svg viewBox="0 0 24 24"><path d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z"/></svg>
                    </button>
                    <div class="toggle on">
                        <div class="knob"></div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td>SH-2B</td>
            <td>2- Bottom Bed</td>
            <td>
                <div class="price-wrapper">
                    <strong>IDR</strong> <span>125.000</span>
                </div>
            </td>
            <td><span class="status-badge status-maintenance">MAINTENANCE</span></td>
            <td>
                <div class="actions">
                    <button class="icon-btn">
                        <svg viewBox="0 0 24 24"><path d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z"/></svg>
                    </button>
                    <div class="toggle off">
                        <div class="knob"></div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td>SH-2T</td>
            <td>2 - Top Bed</td>
            <td>
                <div class="price-wrapper">
                    <strong>IDR</strong> <span>117.500</span>
                </div>
            </td>
            <td><span class="status-badge status-tersedia">TERSEDIA</span></td>
            <td>
                <div class="actions">
                    <button class="icon-btn">
                        <svg viewBox="0 0 24 24"><path d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z"/></svg>
                    </button>
                    <div class="toggle on">
                        <div class="knob"></div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
            </div>

        </div>
    </div>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen yang punya class 'toggle'
            const toggles = document.querySelectorAll('.toggle');
            
            toggles.forEach(function(toggle) {
                // Tambahkan aksi ketika di-klik
                toggle.addEventListener('click', function() {
                    // Kalau saat ini 'on', ubah jadi 'off'
                    if (this.classList.contains('on')) {
                        this.classList.remove('on');
                        this.classList.add('off');
                    } 
                    // Kalau saat ini 'off', ubah jadi 'on'
                    else {
                        this.classList.remove('off');
                        this.classList.add('on');
                    }
                });
            });
        });
    </script>
</body>

</html>

