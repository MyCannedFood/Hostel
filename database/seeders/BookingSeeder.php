<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $now   = Carbon::now();
        $today = Carbon::today();

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

            // ==========================================
            // NEW GUESTS (Active - Currently Checked In)
            // ==========================================

            [
                'booking_code' => 'BK-2026-1011', 'guest_id' => 6, 'room_id' => 1, 'bed_id' => 9,
                'check_in_date' => $today->copy()->subDay()->toDateString(), 'check_out_date' => $today->copy()->addDays(2)->toDateString(), 'total_nights' => 3,
                'total_price' => 352500, 'payment_method' => 'QRIS', 'status' => 'CONFIRMED',
                'personal_notes' => 'Vacation', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1012', 'guest_id' => 7, 'room_id' => 2, 'bed_id' => 17,
                'check_in_date' => $today->toDateString(), 'check_out_date' => $today->copy()->addDays(4)->toDateString(), 'total_nights' => 4,
                'total_price' => 470000, 'payment_method' => 'Credit/Debit Card', 'status' => 'CONFIRMED',
                'personal_notes' => 'Writing retreat', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1013', 'guest_id' => 8, 'room_id' => 1, 'bed_id' => 10,
                'check_in_date' => $today->toDateString(), 'check_out_date' => $today->copy()->addDays(3)->toDateString(), 'total_nights' => 3,
                'total_price' => 375000, 'payment_method' => 'E-Wallet', 'status' => 'CONFIRMED',
                'personal_notes' => 'Conference attendee', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1014', 'guest_id' => 9, 'room_id' => 3, 'bed_id' => 1,
                'check_in_date' => $today->copy()->subDays(2)->toDateString(), 'check_out_date' => $today->copy()->addDays(2)->toDateString(), 'total_nights' => 4,
                'total_price' => 470000, 'payment_method' => 'Bank Transfer', 'status' => 'CONFIRMED',
                'personal_notes' => 'Culinary tour', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1015', 'guest_id' => 10, 'room_id' => 3, 'bed_id' => 2,
                'check_in_date' => $today->copy()->subDays(4)->toDateString(), 'check_out_date' => $today->copy()->addDays(1)->toDateString(), 'total_nights' => 5,
                'total_price' => 625000, 'payment_method' => 'QRIS', 'status' => 'CONFIRMED',
                'personal_notes' => 'Local guide taking a break', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1016', 'guest_id' => 11, 'room_id' => 2, 'bed_id' => 18,
                'check_in_date' => $today->toDateString(), 'check_out_date' => $today->copy()->addDays(5)->toDateString(), 'total_nights' => 5,
                'total_price' => 625000, 'payment_method' => 'Credit/Debit Card', 'status' => 'CONFIRMED',
                'personal_notes' => 'Backpacking trip', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1017', 'guest_id' => 12, 'room_id' => 1, 'bed_id' => 11,
                'check_in_date' => $today->toDateString(), 'check_out_date' => $today->copy()->addDays(3)->toDateString(), 'total_nights' => 3,
                'total_price' => 352500, 'payment_method' => 'E-Wallet', 'status' => 'CONFIRMED',
                'personal_notes' => 'Vacation with family', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],

            // Recently checked out (today)
            [
                'booking_code' => 'BK-2026-1018', 'guest_id' => 13, 'room_id' => 2, 'bed_id' => 19,
                'check_in_date' => $today->copy()->subDays(7)->toDateString(), 'check_out_date' => $today->toDateString(), 'total_nights' => 7,
                'total_price' => 822500, 'payment_method' => 'Bank Transfer', 'status' => 'COMPLETED',
                'personal_notes' => 'Art residency', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'booking_code' => 'BK-2026-1019', 'guest_id' => 14, 'room_id' => 3, 'bed_id' => 3,
                'check_in_date' => $today->copy()->subDays(3)->toDateString(), 'check_out_date' => $today->toDateString(), 'total_nights' => 3,
                'total_price' => 352500, 'payment_method' => 'QRIS', 'status' => 'COMPLETED',
                'personal_notes' => 'Business meeting', 'policy_accepted' => 1, 'created_at' => $now, 'updated_at' => $now
            ],
        ];

        DB::table('bookings')->insert($bookings);
    }
}