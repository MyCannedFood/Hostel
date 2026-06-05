<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\TransportationInfo;
use Illuminate\Database\Seeder;

class LocationSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Site settings defaults ─────────────────────────────────────────
        $defaults = [
            'address' => 'Jalan Raya Ubud No. 1, Gianyar, Bali, Indonesia',
            'phone' => '+62 821 1990 0452',
            'public_email' => 'alasare@gmail.com',
            'maps_link' => 'https://maps.google.com/?q=Jalan+Raya+Ubud+No.+1,+Gianyar,+Bali,+Indonesia',
            'contact_form_email' => 'alasare@gmail.com',
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // ── Sample transportation entries ──────────────────────────────────
        $transports = [
            [
                'icon'        => 'car',
                'title'       => 'Online Taxi',
                'description' => 'Approximately 20 minutes from Bandung city center.',
                'routes'      => ['Trans Studio Bandung', 'Bandung Station', 'Husein Sastranegara Airport'],
                'sort_order'  => 1,
            ],
            [
                'icon'        => 'motorcycle',
                'title'       => 'Motorcycle',
                'description' => 'Faster through small alleys.',
                'routes'      => ['Alun-Alun Bandung', 'Pasar Baru'],
                'sort_order'  => 2,
            ],
        ];

        foreach ($transports as $data) {
            TransportationInfo::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}