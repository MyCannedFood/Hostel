<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Kosongkan tabel sebelum diisi agar tidak error duplikat
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('bookings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $bookings = [
            // ==========================================
            // GUEST 1: MUHAMMAD FARHAN (Sering Menginap)
            // ==========================================
            [
                'booking_code' => 'BK-2026-1001', 'guest_id' => 1, 'room_id' => 1, 'bed_id' => 9, 
                'check_in_date' => '2026-04-10', 'check_out_date' => '2026-04-12', 'total_nights' => 2, 
                'total_price' => 235000, 'payment_method' => 'QRIS', 'status' => 'COMPLETED',
                'personal_notes' => 'Kunjungan pertama', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1002', 'guest_id' => 1, 'room_id' => 1, 'bed_id' => 12, 
                'check_in_date' => '2026-05-28', 'check_out_date' => '2026-05-31', 'total_nights' => 3, 
                'total_price' => 375000, 'payment_method' => 'QRIS', 'status' => 'CONFIRMED', // Sedang menginap (In-House)
                'personal_notes' => 'Returning guest, minta kasur bawah.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1003', 'guest_id' => 1, 'room_id' => 2, 'bed_id' => 17, 
                'check_in_date' => '2026-06-15', 'check_out_date' => '2026-06-18', 'total_nights' => 3, 
                'total_price' => 352500, 'payment_method' => 'Bank Transfer', 'status' => 'PENDING', // Booking masa depan
                'personal_notes' => 'Mau coba kamar Botanica.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],

            // ==========================================
            // GUEST 2: ADITYA PRATAMA (Tamu Bisnis)
            // ==========================================
            [
                'booking_code' => 'BK-2026-1004', 'guest_id' => 2, 'room_id' => 2, 'bed_id' => 18, 
                'check_in_date' => '2026-05-05', 'check_out_date' => '2026-05-07', 'total_nights' => 2, 
                'total_price' => 250000, 'payment_method' => 'Credit/Debit Card', 'status' => 'CANCELLED',
                'personal_notes' => 'Batal karena jadwal meeting berubah.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1005', 'guest_id' => 2, 'room_id' => 2, 'bed_id' => 20, 
                'check_in_date' => '2026-05-25', 'check_out_date' => '2026-05-30', 'total_nights' => 5, 
                'total_price' => 625000, 'payment_method' => 'Bank Transfer', 'status' => 'CONFIRMED', // Check-out hari ini
                'personal_notes' => 'Tamu bisnis.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1006', 'guest_id' => 2, 'room_id' => 3, 'bed_id' => 5, 
                'check_in_date' => '2026-07-01', 'check_out_date' => '2026-07-05', 'total_nights' => 4, 
                'total_price' => 470000, 'payment_method' => 'E-Wallet', 'status' => 'CONFIRMED',
                'personal_notes' => 'Booking untuk bulan Juli.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1007', 'guest_id' => 2, 'room_id' => 1, 'bed_id' => 15, 
                'check_in_date' => '2026-05-30', 'check_out_date' => '2026-06-01', 'total_nights' => 2, 
                'total_price' => 235000, 'payment_method' => 'QRIS', 'status' => 'PENDING', // Check-in hari ini tapi belum bayar
                'personal_notes' => 'Tunggu konfirmasi pembayaran.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],

            // ==========================================
            // GUEST 3: SITI AMINAH (Tamu Bermasalah/Block)
            // ==========================================
            [
                'booking_code' => 'BK-2026-1008', 'guest_id' => 3, 'room_id' => 3, 'bed_id' => 1, 
                'check_in_date' => '2026-04-20', 'check_out_date' => '2026-04-25', 'total_nights' => 5, 
                'total_price' => 587500, 'payment_method' => 'Bank Transfer', 'status' => 'COMPLETED',
                'personal_notes' => 'Sering berisik saat malam hari.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1009', 'guest_id' => 3, 'room_id' => 3, 'bed_id' => 2, 
                'check_in_date' => '2026-05-20', 'check_out_date' => '2026-05-22', 'total_nights' => 2, 
                'total_price' => 250000, 'payment_method' => 'E-Wallet', 'status' => 'CANCELLED', // Dibatalkan oleh admin
                'personal_notes' => 'Flagged guest profile. Reservasi ditolak.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1010', 'guest_id' => 3, 'room_id' => 1, 'bed_id' => 10, 
                'check_in_date' => '2026-06-05', 'check_out_date' => '2026-06-07', 'total_nights' => 2, 
                'total_price' => 250000, 'payment_method' => 'QRIS', 'status' => 'CANCELLED', // Dibatalkan lagi oleh sistem
                'personal_notes' => 'Guest berstatus BLOCK. Otomatis batal.', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
        ];

        DB::table('bookings')->insert($bookings);
    }
}