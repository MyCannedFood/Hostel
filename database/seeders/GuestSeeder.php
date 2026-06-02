<?php

namespace Database\Seeders;

use App\Models\Guest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1001'],
            [
                'status' => 'save',
                'first_name' => 'Muhammad',
                'last_name' => 'Farhan',
                'email' => 'muhammadfarhan21004@gmail.com',
                'phone' => '085211888621',
                'age' => 21,
                'occupation' => 'Mahasiswa',
                'country' => 'Indonesia',
                'city' => 'Bandung',
                'address' => 'Jawa Barat',
                'id_number' => '342434324324',
                'self_description' => 'Returning guest',
                'check_in_date' => $today->copy()->subDays(6),
                'check_out_date' => $today->copy()->subDays(4),
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1002'],
            [
                'status' => 'save',
                'first_name' => 'Aditya',
                'last_name' => 'Pratama',
                'email' => 'aditya.p@email.com',
                'phone' => '081298765432',
                'age' => 27,
                'occupation' => 'Designer',
                'country' => 'Indonesia',
                'city' => 'Jakarta',
                'address' => 'Jakarta Selatan',
                'id_number' => '3174012345670001',
                'self_description' => 'Prefers quiet room',
                'check_in_date' => $today->copy()->subDays(2),
                'check_out_date' => $today->copy()->subDay(),
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1003'],
            [
                'status' => 'block',
                'first_name' => 'Siti',
                'last_name' => 'Aminah',
                'email' => 'siti.aminah@email.com',
                'phone' => '081377223344',
                'age' => 29,
                'occupation' => 'Teacher',
                'country' => 'Indonesia',
                'city' => 'Yogyakarta',
                'address' => 'Sleman',
                'id_number' => '3404012300000002',
                'self_description' => 'Flagged guest profile',
                'check_in_date' => $today->copy()->subDays(10),
                'check_out_date' => $today->copy()->subDays(8),
            ]
        );
    }
}
