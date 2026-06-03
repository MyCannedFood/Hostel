<?php
// FILE: database/seeders/LandingPageSeeder.php

namespace Database\Seeders;

use App\Models\LandingPageSetting;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (LandingPageSetting::SECTIONS as $section) {
            LandingPageSetting::updateOrCreate(
                ['section' => $section],
                ['data' => LandingPageSetting::DEFAULTS[$section] ?? []]
            );
        }
    }
}