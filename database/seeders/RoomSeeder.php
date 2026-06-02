<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::updateOrCreate(
            ['name' => 'Serene Haven'],
            [
                'photo' => 'rooms/eBcHA6oJkCdMMQtgfKbYlE9vS8kWH2x8icX3HV1y.png',
                'layout_photo' => 'room_layouts/ThpwYn0ZtlvgjMv3Hc28fFiFR8VuCXhigIB3JBJb.png',
                'gender_type' => 'Male',
                'capacity' => 8,
                'description' => 'A functional and minimalist space designed for maximum comfort and simplicity.',
                'attributes' => 'Simple & Functional',
                'main_facilities' => 'AC,Wifi,En-suite Bath,Lockers',
                'status' => 'Available',
                'is_active' => true,
            ]
        );

        Room::updateOrCreate(
            ['name' => 'Botanica'],
            [
                'photo' => 'rooms/BT3cmB6Nta7VHhJ3VzBABp5kIn3a4DoXy8NSogK3.svg',
                'layout_photo' => null,
                'gender_type' => 'Male',
                'capacity' => 6,
                'description' => 'A refreshing tropical theme adorned with beautiful Brazilian Fern and bamboo interior decorations.',
                'attributes' => 'Simple & Functional,Eco-Friendly',
                'main_facilities' => 'AC,Wifi,En-suite Bath,Lockers',
                'status' => 'Available',
                'is_active' => true,
            ]
        );

        Room::updateOrCreate(
            ['name' => 'The Heritage'],
            [
                'photo' => 'rooms/Z2RHCx5dHKcwBtAAGsRVgPmRnPSBolO4X8rw6WRG.png',
                'layout_photo' => 'room_layouts/egm8gZpWuRUTXMbp7K7RzR1Gtw7wmxjUPnPTJUIq.png',
                'gender_type' => 'Male',
                'capacity' => 8,
                'description' => 'A serene tropical theme identical to The Teak Nest, featuring lush Brazilian Fern and bamboo decorations.',
                'attributes' => '',
                'main_facilities' => 'AC,Wifi,En-suite Bath,Lockers',
                'status' => 'Available',
                'is_active' => true,
            ]
        );
    }
}
