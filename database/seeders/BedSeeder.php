<?php

namespace Database\Seeders;

use App\Models\Bed;
use App\Models\Room;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    public function run(): void
    {
        $theHeritage = Room::where('name', 'The Heritage')->first();
        $sereneHaven = Room::where('name', 'Serene Haven')->first();
        $botanica = Room::where('name', 'Botanica')->first();

        if ($theHeritage) {
            Bed::updateOrCreate(['name' => 'TH - 1T'], [
                'room_id' => $theHeritage->id,
                'position' => '1 - Top Bed',
                'status' => 'Available',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'TH - 1B'], [
                'room_id' => $theHeritage->id,
                'position' => '1 - Bottom Bed',
                'status' => 'Available',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'TH - 2T'], [
                'room_id' => $theHeritage->id,
                'position' => '2 - Top Bed',
                'status' => 'Maintenance',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'TH - 2B'], [
                'room_id' => $theHeritage->id,
                'position' => '2 - Botom Bed',
                'status' => 'Maintenance',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'TH - 3T'], [
                'room_id' => $theHeritage->id,
                'position' => '3 - Top Bed',
                'status' => 'Available',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);
             Bed::updateOrCreate(['name' => 'TH - 3B'], [
                'room_id' => $theHeritage->id,
                'position' => '3 - Bottom Bed',
                'status' => 'Available',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);

             Bed::updateOrCreate(['name' => 'TH - 4T'], [
                'room_id' => $theHeritage->id,
                'position' => '4 - Top Bed',
                'status' => 'Available',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);
             Bed::updateOrCreate(['name' => 'TH - 4B'], [
                'room_id' => $theHeritage->id,
                'position' => '4 - Bottom Bed',
                'status' => 'Available',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);
        }

        if ($sereneHaven) {
            Bed::updateOrCreate(['name' => 'SH - 1T'], [
                'room_id' => $sereneHaven->id,
                'position' => '1 - Top Bed',
                'status' => 'Available',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'SH - 1B'], [
                'room_id' => $sereneHaven->id,
                'position' => '1 - Bottom Bed',
                'status' => 'Available',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'SH - 2T'], [
                'room_id' => $sereneHaven->id,
                'position' => '2 - Top Bed',
                'status' => 'Maintenance',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'SH - 2B'], [
                'room_id' => $sereneHaven->id,
                'position' => '2 - Botom Bed',
                'status' => 'Occupied',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);

            Bed::updateOrCreate(['name' => 'SH - 3T'], [
                'room_id' => $sereneHaven->id,
                'position' => '3 - Top Bed',
                'status' => 'Available',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);
                Bed::updateOrCreate(['name' => 'SH - 3B'], [
                    'room_id' => $sereneHaven->id,
                    'position' => '3 - Bottom Bed',
                    'status' => 'Available',
                    'base_price' => 125000.00,
                    'is_active' => true,
                ]);
    
                Bed::updateOrCreate(['name' => 'SH - 4T'], [
                    'room_id' => $sereneHaven->id,
                    'position' => '4 - Top Bed',
                    'status' => 'Available',
                    'base_price' => 117500.00,
                    'is_active' => true,
                ]);
                Bed::updateOrCreate(['name' => 'SH - 4B'], [
                    'room_id' => $sereneHaven->id,
                    'position' => '4 - Bottom Bed',
                    'status' => 'Available',
                    'base_price' => 125000.00,
                    'is_active' => true,
                ]);

                
        }
        if ($botanica) {
            Bed::updateOrCreate(['name' => 'BT - 1T'], [
                'room_id' => $botanica->id,
                'position' => '1 - Top Bed',
                'status' => 'Available',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);
            Bed::updateOrCreate(['name' => 'BT - 1B'], [
                'room_id' => $botanica->id,
                'position' => '1 - Bottom Bed',
                'status' => 'Available',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);
            Bed::updateOrCreate(['name' => 'BT - 2T'], [
                'room_id' => $botanica->id,
                'position' => '2 - Top Bed',
                'status' => 'Available',
                'base_price' => 117500.00,
                'is_active' => true,
            ]);
            Bed::updateOrCreate(['name' => 'BT - 2B'], [
                'room_id' => $botanica->id,
                'position' => '2 - Bottom Bed',
                'status' => 'Available',
                'base_price' => 125000.00,
                'is_active' => true,
            ]);
                Bed::updateOrCreate(['name' => 'BT - 3T'], [
                    'room_id' => $botanica->id,
                    'position' => '3 - Top Bed',
                    'status' => 'Available',
                    'base_price' => 117500.00,
                    'is_active' => true,
                ]);
                Bed::updateOrCreate(['name' => 'BT - 3B'], [
                    'room_id' => $botanica->id,
                    'position' => '3 - Bottom Bed',
                    'status' => 'Available',
                    'base_price' => 125000.00,
                    'is_active' => true,
                ]);
            


                    
        }
    }
}
