<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Admin;
use App\Models\LandingPageSetting;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel artikel terlebih dahulu
        Article::truncate();

        // Ambil admin ID
        $admin = Admin::first();
        $adminId = $admin ? $admin->id : 1;

        // 1. Artikel 1: Culture & Serenity
        $art1 = Article::create([
            'admin_id'         => $adminId,
            'title'            => 'The Harmony of Islamic Values and Javanese Wisdom',
            'title_en'         => 'The Harmony of Islamic Values and Javanese Wisdom',
            'title_id'         => 'Harmoni Nilai-Nilai Islam dan Kearifan Jawa',
            'content'          => 'Tracing the connection between Javanese philosophy and Islamic values at AlaSare. Discovering tafakkur (contemplation of nature) as a path to spiritual restoration, surrounded by reclaimed teakwood pavilions and lush tropical foliage. Finding peace where heritage meets mindfulness.',
            'content_en'       => 'Tracing the connection between Javanese philosophy and Islamic values at AlaSare. Discovering tafakkur (contemplation of nature) as a path to spiritual restoration, surrounded by reclaimed teakwood pavilions and lush tropical foliage. Finding peace where heritage meets mindfulness.',
            'content_id'       => 'Menelusuri hubungan erat antara filosofi Jawa dan nilai-nilai Islam di AlaSare. Menemukan tafakur (perenungan alam) sebagai jalan pemulihan spiritual, dikelilingi oleh paviliun kayu jati daur ulang dan dedaunan tropis yang rimbun. Temukan kedamaian di mana warisan budaya berpadu dengan kesadaran jiwa.',
            'thumbnail'        => 'images/journal/harmony_islamic_javanese.png',
            'status'           => 'Published',
            'category'         => 'Culture & Serenity',
            'meta_description' => 'Finding a moment to breathe through tafakkur (nature reflection), where the whispers of Javanese heritage and Islamic values meet.',
            'views_count'      => 120,
            'publish_at'       => now(),
        ]);

        // 2. Artikel 2: Taste of AlaSare
        $art2 = Article::create([
            'admin_id'         => $adminId,
            'title'            => 'The Healing Power of Archipelago Rhizomes',
            'title_en'         => 'The Healing Power of Archipelago Rhizomes',
            'title_id'         => 'Khasiat Penyembuhan Rimpang Nusantara',
            'content'          => 'Archipelago rhizomes like ginger, turmeric, and galangal have long been revered for their restorative properties. At AlaSare, we serve these traditional herbal remedies (Jamu) freshly prepared from our organic garden, warming the body, soothing the mind, and restoring internal balance.',
            'content_en'       => 'Archipelago rhizomes like ginger, turmeric, and galangal have long been revered for their restorative properties. At AlaSare, we serve these traditional herbal remedies (Jamu) freshly prepared from our organic garden, warming the body, soothing the mind, and restoring internal balance.',
            'content_id'       => 'Rimpang Nusantara seperti jahe, kunyit, dan kencur telah lama dihormati karena khasiat penyembuhannya. Di AlaSare, kami menyajikan ramuan herbal tradisional (Jamu) yang disiapkan segar langsung dari kebun organik kami, menghangatkan tubuh, menenangkan pikiran, dan memulihkan keseimbangan batin.',
            'thumbnail'        => 'images/journal/healing_rhizomes.png',
            'status'           => 'Published',
            'category'         => 'Taste of AlaSare',
            'meta_description' => 'Tracing the history of traditional herbal remedies passed down through generations, warming the body and soul...',
            'views_count'      => 95,
            'publish_at'       => now(),
        ]);

        // 3. Artikel 3: Travel Tips
        $art3 = Article::create([
            'admin_id'         => $adminId,
            'title'            => 'Connecting Through Handcrafted Art',
            'title_en'         => 'Connecting Through Handcrafted Art',
            'title_id'         => 'Terhubung Melalui Seni Kerajinan Tangan',
            'content'          => 'Engaging with handcrafted art allows travelers to connect deeply with the Javanese local community. At AlaSare, we invite you to participate in hands-on workshops, weaving leaves and carving wood, experiencing first-hand the warm hospitality that transforms you from a guest into a family member.',
            'content_en'       => 'Engaging with handcrafted art allows travelers to connect deeply with the Javanese local community. At AlaSare, we invite you to participate in hands-on workshops, weaving leaves and carving wood, experiencing first-hand the warm hospitality that transforms you from a guest into a family member.',
            'content_id'       => 'Terlibat dalam seni kerajinan tangan memungkinkan pelancong untuk terhubung secara mendalam dengan komunitas lokal Jawa. Di AlaSare, kami mengundang Anda untuk berpartisipasi dalam lokakarya langsung, menganyam dedaunan dan memahat kayu, merasakan langsung keramahtamahan hangat yang mengubah Anda dari seorang tamu menjadi bagian dari keluarga.',
            'thumbnail'        => 'images/journal/handcrafted_art.png',
            'status'           => 'Published',
            'category'         => 'Travel Tips',
            'meta_description' => 'A guide to deep interaction with the local community, where you are not merely a guest but a part of the family...',
            'views_count'      => 80,
            'publish_at'       => now(),
        ]);

        // Update setting Landing Page Featured Articles agar otomatis memilih 3 artikel ini
        $setting = LandingPageSetting::firstOrNew(['section' => 'featured_articles']);
        $setting->data = [
            'section_title'          => 'Journal & Stories',
            'section_title_id'       => 'Jurnal & Cerita',
            'section_description'    => 'Our Journal',
            'section_description_id' => 'Jurnal Kami',
            'article_ids'            => [$art1->id, $art2->id, $art3->id]
        ];
        $setting->updated_by = $adminId;
        $setting->save();
    }
}
