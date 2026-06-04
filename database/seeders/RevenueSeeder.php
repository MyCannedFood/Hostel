<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueSeeder extends Seeder
{
    public function run(): void
    {
        $now   = Carbon::now();
        $today = Carbon::today();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payments')->truncate();
        DB::table('general_ledger')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $paidBookings = DB::table('bookings')
            ->whereIn('status', ['COMPLETED', 'CONFIRMED'])
            ->orderBy('id')
            ->get();

        $payments   = [];
        $glEntries  = [];
        $transCode  = 1;

        foreach ($paidBookings as $i => $booking) {
            $paidAt = $today->copy()->subDays(6 - min($i, 6));

            $channel = match ($booking->payment_method) {
                'QRIS'              => 'QRIS',
                'Bank Transfer'     => 'BCA',
                'Credit/Debit Card' => 'Mandiri',
                'E-Wallet'          => 'GoPay',
                default             => 'BCA',
            };

            $payments[] = [
                'booking_id'             => $booking->id,
                'midtrans_order_id'      => 'MID-' . $booking->booking_code,
                'midtrans_transaction_id' => 'TRX-' . $booking->booking_code,
                'payment_method'         => $booking->payment_method,
                'payment_channel'        => $channel,
                'amount'                 => $booking->total_price,
                'status'                 => 'settlement',
                'paid_at'                => $paidAt,
                'expired_at'             => $paidAt->copy()->addDays(1),
                'created_at'             => $paidAt,
                'updated_at'             => $paidAt,
            ];

            $glEntries[] = [
                'trans_code'  => 'TR-' . str_pad($transCode++, 4, '0', STR_PAD_LEFT),
                'description' => 'Payment ' . $booking->booking_code,
                'category'    => 'Accommodation',
                'type'        => 'In',
                'amount'      => (int) $booking->total_price,
                'created_at'  => $paidAt,
                'updated_at'  => $paidAt,
            ];
        }

        $expenses = [
            ['Cleaning Supplies Purchase',    'Operational',  400000],
            ['Electricity Bill - June 2026',  'Operational',  350000],
            ['Water Bill - June 2026',        'Operational',  120000],
            ['WiFi Subscription - June 2026', 'Operational',  250000],
            ['AC Maintenance',                 'Maintenance',  300000],
            ['Bed Frame Repair',               'Maintenance',  150000],
            ['Laundry Service',                'Service',      180000],
            ['Staff Salary - June 2026',       'Operational',  800000],
        ];

        foreach ($expenses as $j => $exp) {
            $glEntries[] = [
                'trans_code'  => 'TR-' . str_pad($transCode++, 4, '0', STR_PAD_LEFT),
                'description' => $exp[0],
                'category'    => $exp[1],
                'type'        => 'Out',
                'amount'      => $exp[2],
                'created_at'  => $today->copy()->subDays(min($j, 6)),
                'updated_at'  => $today->copy()->subDays(min($j, 6)),
            ];
        }

        DB::table('payments')->insert($payments);
        DB::table('general_ledger')->insert($glEntries);
    }
}
