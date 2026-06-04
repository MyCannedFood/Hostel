<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoomSeeder::class,
            BedSeeder::class,
            GuestSeeder::class,
            AdminSeeder::class,
            BookingSeeder::class,
            RevenueSeeder::class,
            AddonSeeder::class,
        ]);
    }
}