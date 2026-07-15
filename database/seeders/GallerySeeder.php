<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel kosong dulu sebelum di-seed
        Gallery::truncate();

        // Ambil ID admin pertama
        $admin = Admin::first();
        $adminId = $admin ? $admin->id : 1;

        // Data 13 Foto (7 di kolom Kiri, 6 di kolom Kanan)
        $items = [
            // --- KOLOM KIRI (7 FOTO) ---
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/left_1.png',
                'title'            => 'Yoga Shala Wooden Interior',
                'category'         => 'spaces',
                'column_placement' => 'left',
                'order_number'     => 1,
                'status'           => 'active',
                'alt_text'         => 'Yoga shala interior showing beautiful wooden roof structure',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/left_2.png',
                'title'            => 'Orchid Flowers Close-Up',
                'category'         => 'nature',
                'column_placement' => 'left',
                'order_number'     => 2,
                'status'           => 'active',
                'alt_text'         => 'White orchid flowers in the tropical garden',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/left_3.png',
                'title'            => 'Dinner Table Under Banyan Tree',
                'category'         => 'dining',
                'column_placement' => 'left',
                'order_number'     => 3,
                'status'           => 'active',
                'alt_text'         => 'Cozy outdoor dining table set up under a massive banyan tree',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/left_4.png',
                'title'            => 'Bunk Bed in Shared Room',
                'category'         => 'spaces',
                'column_placement' => 'left',
                'order_number'     => 4,
                'status'           => 'active',
                'alt_text'         => 'Wooden bunk bed in the cozy shared dorm room',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/left_5.png',
                'title'            => 'Couple on Balcony Deck',
                'category'         => 'people',
                'column_placement' => 'left',
                'order_number'     => 5,
                'status'           => 'active',
                'alt_text'         => 'A couple sitting and chatting on the balcony deck surrounded by forest',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/left_6.png',
                'title'            => 'Family Planting a Tree',
                'category'         => 'people',
                'column_placement' => 'left',
                'order_number'     => 6,
                'status'           => 'active',
                'alt_text'         => 'Family gathering and planting a tree in the resort organic garden',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/left_7.png',
                'title'         => 'Dinner Gathering Outside',
                'category'         => 'dining',
                'column_placement' => 'left',
                'order_number'     => 7,
                'status'           => 'active',
                'alt_text'         => 'Friends enjoying dinner and drinks at the outdoor table',
            ],

            // --- KOLOM KANAN (6 FOTO) ---
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/right_1.png',
                'title'            => 'Person Meditating in Garden',
                'category'         => 'wellness',
                'column_placement' => 'right',
                'order_number'     => 1,
                'status'           => 'active',
                'alt_text'         => 'A guest doing meditation in the morning green garden',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/right_2.png',
                'title'            => 'Spices and Flowers in Basket',
                'category'         => 'wellness',
                'column_placement' => 'right',
                'order_number'     => 2,
                'status'           => 'active',
                'alt_text'         => 'Woven basket filled with fresh spices, cinnamon, and frangipani flowers',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/right_3.png',
                'title'            => 'Walkway in Organic Garden',
                'category'         => 'nature',
                'column_placement' => 'right',
                'order_number'     => 3,
                'status'           => 'active',
                'alt_text'         => 'Wooden walkway path running through rows of organic herbal plants',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/right_4.png',
                'title'            => 'Spa Gazebo next to River',
                'category'         => 'wellness',
                'column_placement' => 'right',
                'order_number'     => 4,
                'status'           => 'active',
                'alt_text'         => 'Massage spa bed setup under gazebo next to a peaceful forest river',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/right_5.png',
                'title'            => 'Traditional Roasted Chicken',
                'category'         => 'dining',
                'column_placement' => 'right',
                'order_number'     => 5,
                'status'           => 'active',
                'alt_text'         => 'Delicious traditional Indonesian roasted chicken served on table',
            ],
            [
                'admin_id'         => $adminId,
                'image_path'       => 'gallery/right_6.png',
                'title'            => 'Woman Drinking Tea',
                'category'         => 'people',
                'column_placement' => 'right',
                'order_number'     => 6,
                'status'           => 'active',
                'alt_text'         => 'A woman sitting cross-legged and sipping tea in the lush organic garden',
            ],
        ];

        foreach ($items as $item) {
            Gallery::create($item);
        }
    }
}
