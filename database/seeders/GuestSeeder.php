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

        // ── Existing guests (backfill gender & booking_place) ──

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1001'],
            [
                'status'        => 'save',
                'first_name'    => 'Muhammad',
                'last_name'     => 'Farhan',
                'email'         => 'muhammadfarhan21004@gmail.com',
                'phone'         => '085211888621',
                'age'           => 21,
                'occupation'    => 'Mahasiswa',
                'country'       => 'Indonesia',
                'gender'        => 'Male',
                'booking_place' => 'Website',
                'city'          => 'Bandung',
                'address'       => 'Jawa Barat',
                'id_number'     => '342434324324',
                'self_description' => 'Returning guest',
                'check_in_date' => $today->copy()->subDays(6),
                'check_out_date' => $today->copy()->subDays(4),
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1002'],
            [
                'status'        => 'save',
                'first_name'    => 'Aditya',
                'last_name'     => 'Pratama',
                'email'         => 'aditya.p@email.com',
                'phone'         => '081298765432',
                'age'           => 27,
                'occupation'    => 'Designer',
                'country'       => 'Indonesia',
                'gender'        => 'Male',
                'booking_place' => 'Walk-in',
                'city'          => 'Jakarta',
                'address'       => 'Jakarta Selatan',
                'id_number'     => '3174012345670001',
                'self_description' => 'Prefers quiet room',
                'check_in_date' => $today->copy()->subDays(2),
                'check_out_date' => $today->copy()->subDay(),
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1003'],
            [
                'status'        => 'block',
                'first_name'    => 'Siti',
                'last_name'     => 'Aminah',
                'email'         => 'siti.aminah@email.com',
                'phone'         => '081377223344',
                'age'           => 29,
                'occupation'    => 'Teacher',
                'country'       => 'Indonesia',
                'gender'        => 'Female',
                'booking_place' => 'App',
                'city'          => 'Yogyakarta',
                'address'       => 'Sleman',
                'id_number'     => '3404012300000002',
                'self_description' => 'Flagged guest profile',
                'check_in_date' => $today->copy()->subDays(10),
                'check_out_date' => $today->copy()->subDays(8),
            ]
        );

        // ── New guests ──

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1004'],
            [
                'status'        => 'save',
                'first_name'    => 'Emma',
                'last_name'     => 'Johnson',
                'email'         => 'emma.j@email.com',
                'phone'         => '+61412345678',
                'age'           => 34,
                'occupation'    => 'Photographer',
                'country'       => 'Australia',
                'gender'        => 'Female',
                'booking_place' => 'Website',
                'city'          => 'Sydney',
                'address'       => 'Surry Hills',
                'id_number'     => 'AUS123456789',
                'self_description' => 'Traveling solo for photography project',
                'check_in_date' => $today->copy()->subDays(3),
                'check_out_date' => $today->copy()->subDay(),
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1005'],
            [
                'status'        => 'save',
                'first_name'    => 'Takeshi',
                'last_name'     => 'Tanaka',
                'email'         => 'takeshi.t@email.com',
                'phone'         => '+819012345678',
                'age'           => 41,
                'occupation'    => 'Engineer',
                'country'       => 'Japan',
                'gender'        => 'Male',
                'booking_place' => 'App',
                'city'          => 'Tokyo',
                'address'       => 'Shibuya',
                'id_number'     => 'JP987654321',
                'self_description' => 'Business trip',
                'check_in_date' => $today->copy()->subDays(5),
                'check_out_date' => $today->copy()->subDays(3),
            ]
        );

        // ── Currently checked-in (no check_out_date) ──

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1006'],
            [
                'status'        => 'save',
                'first_name'    => 'Rina',
                'last_name'     => 'Wijaya',
                'email'         => 'rina.w@email.com',
                'phone'         => '087812345678',
                'age'           => 25,
                'occupation'    => 'Freelancer',
                'country'       => 'Indonesia',
                'gender'        => 'Female',
                'booking_place' => 'Walk-in',
                'city'          => 'Denpasar',
                'address'       => 'Bali',
                'id_number'     => '5101234567890001',
                'self_description' => 'Vacation',
                'check_in_date' => $today->copy()->subDays(1),
                'check_out_date' => null,
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1007'],
            [
                'status'        => 'save',
                'first_name'    => 'Liam',
                'last_name'     => 'O\'Brien',
                'email'         => 'liam.o@email.com',
                'phone'         => '+353871234567',
                'age'           => 30,
                'occupation'    => 'Writer',
                'country'       => 'Ireland',
                'gender'        => 'Male',
                'booking_place' => 'Website',
                'city'          => 'Dublin',
                'address'       => 'Temple Bar',
                'id_number'     => 'IRL789012345',
                'self_description' => 'Writing retreat',
                'check_in_date' => $today,
                'check_out_date' => null,
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1008'],
            [
                'status'        => 'save',
                'first_name'    => 'Aisha',
                'last_name'     => 'Mohamed',
                'email'         => 'aisha.m@email.com',
                'phone'         => '+254712345678',
                'age'           => 28,
                'occupation'    => 'Researcher',
                'country'       => 'Kenya',
                'gender'        => 'Female',
                'booking_place' => 'App',
                'city'          => 'Nairobi',
                'address'       => 'Karen',
                'id_number'     => 'KEN456789012',
                'self_description' => 'Conference attendee',
                'check_in_date' => $today,
                'check_out_date' => null,
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1009'],
            [
                'status'        => 'save',
                'first_name'    => 'Carlos',
                'last_name'     => 'Mendoza',
                'email'         => 'carlos.m@email.com',
                'phone'         => '+525512345678',
                'age'           => 36,
                'occupation'    => 'Chef',
                'country'       => 'Mexico',
                'gender'        => 'Male',
                'booking_place' => 'Walk-in',
                'city'          => 'Mexico City',
                'address'       => 'Condesa',
                'id_number'     => 'MEX123456789',
                'self_description' => 'Culinary tour',
                'check_in_date' => $today->copy()->subDays(2),
                'check_out_date' => null,
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1010'],
            [
                'status'        => 'save',
                'first_name'    => 'Putu',
                'last_name'     => 'Darmayasa',
                'email'         => 'putu.d@email.com',
                'phone'         => '081234567890',
                'age'           => 32,
                'occupation'    => 'Tour Guide',
                'country'       => 'Indonesia',
                'gender'        => 'Male',
                'booking_place' => 'Walk-in',
                'city'          => 'Ubud',
                'address'       => 'Gianyar, Bali',
                'id_number'     => '5104123456780001',
                'self_description' => 'Local guide taking a break',
                'check_in_date' => $today->copy()->subDays(4),
                'check_out_date' => null,
            ]
        );

        // ── Checked-in today for dashboard stats ──

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1011'],
            [
                'status'        => 'save',
                'first_name'    => 'Sarah',
                'last_name'     => 'Chen',
                'email'         => 'sarah.c@email.com',
                'phone'         => '+886912345678',
                'age'           => 26,
                'occupation'    => 'Student',
                'country'       => 'Taiwan',
                'gender'        => 'Female',
                'booking_place' => 'Website',
                'city'          => 'Taipei',
                'address'       => 'Da\'an District',
                'id_number'     => 'TWN567890123',
                'self_description' => 'Backpacking trip',
                'check_in_date' => $today,
                'check_out_date' => null,
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1012'],
            [
                'status'        => 'save',
                'first_name'    => 'David',
                'last_name'     => 'Müller',
                'email'         => 'david.m@email.com',
                'phone'         => '+4915123456789',
                'age'           => 45,
                'occupation'    => 'Architect',
                'country'       => 'Germany',
                'gender'        => 'Male',
                'booking_place' => 'App',
                'city'          => 'Berlin',
                'address'       => 'Mitte',
                'id_number'     => 'GER345678901',
                'self_description' => 'Vacation with family',
                'check_in_date' => $today,
                'check_out_date' => null,
            ]
        );

        // ── Recently checked-out (today) ──

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1013'],
            [
                'status'        => 'save',
                'first_name'    => 'Marie',
                'last_name'     => 'Dubois',
                'email'         => 'marie.d@email.com',
                'phone'         => '+33612345678',
                'age'           => 33,
                'occupation'    => 'Artist',
                'country'       => 'France',
                'gender'        => 'Female',
                'booking_place' => 'Website',
                'city'          => 'Paris',
                'address'       => 'Le Marais',
                'id_number'     => 'FRA234567890',
                'self_description' => 'Art residency',
                'check_in_date' => $today->copy()->subDays(7),
                'check_out_date' => $today,
            ]
        );

        Guest::updateOrCreate(
            ['booking_code' => 'BK-2026-1014'],
            [
                'status'        => 'save',
                'first_name'    => 'Budi',
                'last_name'     => 'Santoso',
                'email'         => 'budi.s@email.com',
                'phone'         => '085612345678',
                'age'           => 38,
                'occupation'    => 'Entrepreneur',
                'country'       => 'Indonesia',
                'gender'        => 'Male',
                'booking_place' => 'Walk-in',
                'city'          => 'Surabaya',
                'address'       => 'Jawa Timur',
                'id_number'     => '3512345678900001',
                'self_description' => 'Business meeting',
                'check_in_date' => $today->copy()->subDays(3),
                'check_out_date' => $today,
            ]
        );
    }
}
