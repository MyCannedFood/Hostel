<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        Experience::updateOrCreate(
            ['name' => 'Traditional Jamu Ritual'],
            [
                'name_en'              => 'Traditional Jamu Ritual',
                'name_id'              => 'Ritual Jamu Tradisional',
                'short_description'    => "Learn the art of crafting Jamu from a choice of hand-picked medicinal herbs grown in AlaSare's organic garden for ancestral balance.",
                'short_description_en' => "Learn the art of crafting Jamu from a choice of hand-picked medicinal herbs grown in AlaSare's organic garden for ancestral balance.",
                'short_description_id' => "Pelajari seni meracik Jamu dari pilihan tanaman obat herbal pilihan yang ditanam di kebun organik AlaSare untuk keseimbangan leluhur.",
                'category'             => 'Wellness',
                'price'                => 350000.00,
                'inclusions'           => [
                    'Welcome herbal drink',
                    'Jamu ingredients & recipe handbook',
                    'Custom handmade bottle to take home',
                    'Experienced wellness guide'
                ],
                'time_slots'           => ['09:00 - 11:00', '15:00 - 17:00'],
                'cover_image'          => null,
                'status'               => 'Active',
            ]
        );

        Experience::updateOrCreate(
            ['name' => 'Batik Canting Ritual'],
            [
                'name_en'              => 'Batik Canting Ritual',
                'name_id'              => 'Ritual Canting Batik',
                'short_description'    => "Beyond art, Batik is a meditation of patience. Pour your story onto cloth through the intricate technique of hand-drawn Batik Tulis, rich in philosophy.",
                'short_description_en' => "Beyond art, Batik is a meditation of patience. Pour your story onto cloth through the intricate technique of hand-drawn Batik Tulis, rich in philosophy.",
                'short_description_id' => "Lebih dari sekadar seni, Batik adalah meditasi kesabaran. Tuangkan kisah Anda ke atas kain melalui teknik rumit Batik Tulis lukis tangan yang kaya filosofi.",
                'category'             => 'Cultural',
                'price'                => 450000.00,
                'inclusions'           => [
                    'Premium cotton fabric (mori)',
                    'Traditional canting, wax, & copper stove',
                    'Natural dyes color baths',
                    'Batik master instructor guidance'
                ],
                'time_slots'           => ['10:00 - 13:00', '14:00 - 17:00'],
                'cover_image'          => null,
                'status'               => 'Active',
            ]
        );

        Experience::updateOrCreate(
            ['name' => 'Nurture the Earth'],
            [
                'name_en'              => 'Nurture the Earth',
                'name_id'              => 'Merawat Bumi',
                'short_description'    => "Join our rewilding journey. Plant a native teak sapling in the AlaSare forest, leaving a living legacy of growth and renewal for the Javanese soil.",
                'short_description_en' => "Join our rewilding journey. Plant a native teak sapling in the AlaSare forest, leaving a living legacy of growth and renewal for the Javanese soil.",
                'short_description_id' => "Bergabunglah dalam perjalanan rewilding kami. Tanam bibit pohon jati asli di hutan AlaSare, tinggalkan warisan hidup pertumbuhan dan pembaruan untuk tanah Jawa.",
                'category'             => 'Nature',
                'price'                => 350000.00,
                'inclusions'           => [
                    'Teak tree sapling (labelled with your name)',
                    'Planting tools & organic fertilizer',
                    'Digital coordinates certificate of your tree',
                    'Local forest ranger guide'
                ],
                'time_slots'           => ['08:00 - 10:00', '16:00 - 18:00'],
                'cover_image'          => null,
                'status'               => 'Active',
            ]
        );
    }
}
