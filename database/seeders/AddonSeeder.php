<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Addon;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Breakfast (Gratis kalau Check-in hari Senin)
        Addon::create([
            'name' => 'Breakfast AlaSare',
            'price' => 35000,
            'discount' => 35000, // Diskon full (gratis)
            'note' => '(for free on Monday!)',
            'is_auto_include' => true,
            'include_days' => ['Monday'], // Hanya aktif hari Senin
            'is_active' => true,
        ]);

        // 2. Dinner (Opsional, tidak auto include)
        Addon::create([
            'name' => 'Dinner Feast AlaSare',
            'price' => 35000,
            'discount' => null,
            'note' => '',
            'is_auto_include' => false,
            'include_days' => null, // Berlaku tiap hari tapi bayar
            'is_active' => true,
        ]);
    }
}