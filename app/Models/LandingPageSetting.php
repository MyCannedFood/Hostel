<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    protected $table    = 'landing_page_settings';
    protected $fillable = ['section', 'data', 'updated_by'];
    protected $casts    = ['data' => 'array'];

    public const SECTIONS = [
        'hero', 'philosophy', 'flora', 'map',
        'featured_rooms', 'guest_stories', 'awards', 'featured_articles',
        'media_partners',
    ];

    public const DEFAULTS = [
        'hero' => [
            // English (default)
            'headline'    => 'A Javanese Sanctuary, Woven by Nature',
            'subheadline' => 'Immerse yourself in the deep tranquility of Nusantara culture, where architecture breathes with the forest.',

            // Indonesian (default)
            'headline_id'    => 'Surga Jawa, Terjalin oleh Alam',
            'subheadline_id' => 'Benamkan diri Anda dalam ketenangan mendalam budaya Nusantara, di mana arsitektur menyatu dengan hutan.',

            'bg_image'    => null,
        ],


        'philosophy' => [
            // English (default)
            'tagline'     => 'OUR PHILOSOPHY',
            'heading'     => 'Breathing with the Earth',
            'body_1'      => 'At AlasAre, we believe true luxury is space. From our 500 sqm land, only 100 sqm is used for buildings. The remaining 400 sqm is intentionally returned to nature as a private, breathing forest.',
            'body_2'      => 'This mindful 4:1 ratio ensures that our traditional Javanese structures do not dominate the landscape, but rather nestle within it, allowing the ancient rhythms of the jungle to remain undisturbed.',
            'badge_label' => 'Conservation',
            'badge_value' => '80% Forest Cover',

            // Indonesian (default)
            'tagline_id'     => 'FILOSOFI KAMI',
            'heading_id'     => 'Bernafas Bersama Bumi',
            'body_1_id'      => 'Di AlaSare, kami percaya bahwa sebuah retreat seharusnya meninggalkan alam dalam kondisi lebih baik dari sebelumnya. Setiap struktur, setiap jalur, setiap keputusan dipandu oleh satu pertanyaan: apakah ini bermanfaat bagi hutan?',
            'body_2_id'      => 'Kami bekerja bersama pengrajin Jawa lokal, menggunakan bahan-bahan yang dipanen dalam radius 40 km, dan mengalokasikan 30% pendapatan untuk penghijauan aktif. Menginap di sini adalah sebuah tindakan kepedulian.',
            'badge_label_id' => 'Konservasi',

            'features'    => [
                [
                    'icon_path'      => null,
                    'icon_label'     => 'Footprint',
                    'title'          => 'Zero Carbon Footprint',
                    'title_id'       => 'Nol Jejak Karbon',
                    'description'    => 'Solar-powered villas, composting kitchens, and zero single-use plastics across the entire property.',
                    'description_id' => 'Vila bertenaga surya, dapur kompos, dan bebas plastik sekali pakai di seluruh properti.',
                ],
                [
                    'icon_path'      => null,
                    'icon_label'     => 'Rewilding',
                    'title'          => 'Active Rewilding',
                    'title_id'       => 'Penghijauan Aktif',
                    'description'    => 'Each stay funds the planting of native Javanese species, restoring biodiversity one tree at a time.',
                    'description_id' => 'Setiap kunjungan mendanai penanaman spesies asli Jawa, memulihkan keanekaragaman hayati satu pohon demi satu pohon.',
                ],
            ],

            'side_image'  => null,
        ],

        'flora' => [
            // English (default)
            'eyebrow'     => 'Living Ecosystem',
            'title'       => 'The Flora Concept',
            'description' => 'Every plant at AlaSare serves a purpose, from culinary delights to therapeutic aromas, creating a multi-sensory journey through Java.',

            // Indonesian (default)
            'eyebrow_id'     => 'Ekosistem Hidup',
            'title_id'       => 'Konsep Flora',
            'description_id' => 'Setiap tanaman, pohon, dan herba di AlaSare dipilih dengan penuh kesadaran — untuk memberi nutrisi, menyembuhkan, dan melindungi kehidupan di sekitar kita.',

            'cards'       => [
                [
                    'image_path'      => null,
                    'eyebrow'         => 'Nourishment',
                    'eyebrow_id'      => 'Nutrisi',
                    'title'           => 'Edible Gardens',
                    'title_id'        => 'Kebun Edibel',
                    'description'     => 'Herbs, vegetables, and fruits grown on-site feed our kitchen and guests directly from the soil.',
                    'description_id'  => 'Rempah, sayuran, dan buah-buahan yang ditanam di lokasi langsung memasok dapur dan tamu kami dari tanah.',
                ],
                [
                    'image_path'      => null,
                    'eyebrow'         => 'Aromatherapy',
                    'eyebrow_id'      => 'Aromaterapi',
                    'title'           => 'Scented Pathways',
                    'title_id'        => 'Jalur Beraroma',
                    'description'     => 'Lavender, lemongrass, and ylang-ylang line every walkway, turning each stroll into a sensory journey.',
                    'description_id'  => 'Lavender, serai, dan kenanga menghiasi setiap jalur, mengubah setiap langkah menjadi perjalanan indrawi.',
                ],
                [
                    'image_path'      => null,
                    'eyebrow'         => 'Architecture',
                    'eyebrow_id'      => 'Arsitektur',
                    'title'           => 'Living Walls',
                    'title_id'        => 'Dinding Hidup',
                    'description'     => 'Vertical gardens integrated into villa structures provide natural insulation and a living canvas.',
                    'description_id'  => 'Taman vertikal yang terintegrasi ke dalam struktur vila memberikan insulasi alami dan kanvas yang hidup.',
                ],
            ],
        ],

'map' => [
            // English (default)
            'subtitle'        => 'Explore the Ground',
            'title'           => 'AlaSare Map',
            'map_image'       => null,

            // Indonesian (default)
            'subtitle_id'     => 'Jelajahi Kawasan',
            'title_id'        => 'Peta AlaSare',

            'updated_by_name' => null,
        ],

        'featured_rooms' => [
            'title'       => 'Sanctuaries',
            'title_id'    => 'Tempat Peristirahatan',

            'description' => 'Each villa possesses a unique soul, crafted from reclaimed teak and designed to frame the forest.',
            'description_id' => 'Setiap vila memiliki jiwa yang unik, dibuat dari kayu jati daur ulang dan dirancang untuk membingkai hutan.',

            'room_ids'    => [],
        ],

        'guest_stories' => [
            // English (default)
            'title'   => 'Guest Stories',

            // Indonesian (default)
            'title_id' => 'Cerita Tamu',

            'stories' => [
                [
                    'image_path' => null,
                    'name'       => 'Edward & Claire',
                    'origin'     => 'United Kingdom',
                    'origin_id'  => 'Inggris Raya',
                    'quote'      => 'A profound experience. The way the villa integrates with the jungle made us feel like we were sleeping in the canopy.',
                    'quote_id'   => 'Sebuah pengalaman yang mendalam. Cara vila menyatu dengan hutan membuat kami merasa seperti tidur di kanopi.',
                ],
                [
                    'image_path' => null,
                    'name'       => 'Hiroshi & Yuki',
                    'origin'     => 'Japan',
                    'origin_id'  => 'Jepang',
                    'quote'      => 'Waking up to birdsong and the rustling of leaves, completely surrounded by green. AlasAre gave us a new definition of what luxury truly means.',
                    'quote_id'   => 'Bangun dengan kicau burung dan gemerisik daun, benar-benar dikelilingi hijau. AlasAre memberi kami definisi baru tentang apa arti kemewahan.',
                ],
                [
                    'image_path' => null,
                    'name'       => 'Sophie & Marc',
                    'origin'     => 'France',
                    'origin_id'  => 'Prancis',
                    'quote'      => 'The most restorative stay we have ever had. Every detail, from the herbs in our meals to the sound of rain on the jungle canopy, was deeply intentional.',
                    'quote_id'   => 'Menginap yang paling menenangkan yang pernah kami rasakan. Setiap detail—dari rempah dalam makanan hingga suara hujan di kanopi hutan—sangat disengaja.',
                ],
            ],
        ],

        'awards' => [
            // English (default)
            'section_title' => 'Awards and Recognition',

            // Indonesian (default)
            'section_title_id' => 'Penghargaan & Pengakuan',

            'items'         => [
                [
                    'icon_path' => null,
                    'title' => 'EarthCheck',
                    'title_id' => 'EarthCheck',
                    'sub' => 'Gold Certified',
                    'sub_id' => 'Sertifikasi Emas',
                    'is_visible' => true,
                ],
                [
                    'icon_path' => null,
                    'title' => "Traveler's Choice",
                    'title_id' => 'Pilihan Wisatawan',
                    'sub' => 'TripAdvisor 2025',
                    'sub_id' => 'TripAdvisor 2025',
                    'is_visible' => true,
                ],
                [
                    'icon_path' => null,
                    'title' => 'Local Heritage',
                    'title_id' => 'Warisan Lokal',
                    'sub' => 'Preservation',
                    'sub_id' => 'Pelestarian',
                    'is_visible' => true,
                ],
                [
                    'icon_path' => null,
                    'title' => 'Zero Waste',
                    'title_id' => 'Bebas Limbah',
                    'sub' => 'Initiative',
                    'sub_id' => 'Inisiatif',
                    'is_visible' => true,
                ],
            ],
        ],

        'featured_articles' => [
            // English (default)
            'section_title'       => 'Journal & Stories',
            'section_description' => 'Curated stories on nature, slow living, and our architectural journey in the urban jungle.',

            // Indonesian (default)
            'section_title_id'       => 'Jurnal & Cerita',
            'section_description_id' => 'Kurasi cerita tentang alam, hidup yang lebih pelan, dan perjalanan arsitektur kami di dalam urban jungle.',

            'article_ids'         => [],   // max 3 integer IDs dari tabel articles
        ],

        'media_partners' => [
            // English (default)
            'title'   => 'As Seen In',

            // Indonesian (default)
            'title_id'=> 'Diliput Oleh',

            'partners' => [
                ['logo_path' => null, 'name' => 'Condé Nast Traveller', 'url' => '', 'style' => 'font-family:Georgia,serif; font-size:17px; font-weight:400; letter-spacing:0.02em;'],
                ['logo_path' => null, 'name' => 'TRAVEL + LEISURE',     'url' => '', 'style' => 'font-family:Arial,sans-serif; font-size:15px; font-weight:700; letter-spacing:0.12em;'],
                ['logo_path' => null, 'name' => 'Tatler Asia',           'url' => '', 'style' => 'font-family:Georgia,serif; font-size:17px; font-style:italic; font-weight:400;'],
                ['logo_path' => null, 'name' => 'National Geographic',  'url' => '', 'style' => 'font-family:Arial,sans-serif; font-size:17px; font-weight:700; letter-spacing:0.01em; color:#6b8f6b;'],
                ['logo_path' => null, 'name' => 'VOGUE LIVING',          'url' => '', 'style' => 'font-family:Arial,sans-serif; font-size:14px; font-weight:400; letter-spacing:0.18em;'],
                ['logo_path' => null, 'name' => 'the guardian',          'url' => '', 'style' => 'font-family:Georgia,serif; font-size:19px; font-weight:400; font-style:italic; color:#9aaa90;'],
                ['logo_path' => null, 'name' => 'Forbes',                'url' => '', 'style' => 'font-family:Arial,sans-serif; font-size:16px; font-weight:700; letter-spacing:0.06em;'],
                ['logo_path' => null, 'name' => 'The New York Times',    'url' => '', 'style' => 'font-family:Georgia,serif; font-size:17px; font-weight:400; letter-spacing:0.04em; font-style:italic;'],
                ['logo_path' => null, 'name' => 'Lonely Planet',         'url' => '', 'style' => 'font-family:Arial,sans-serif; font-size:13px; font-weight:700; letter-spacing:0.1em;'],
                ['logo_path' => null, 'name' => 'Monocle',               'url' => '', 'style' => 'font-family:Arial,sans-serif; font-size:15px; font-weight:400; letter-spacing:0.08em;'],
                ['logo_path' => null, 'name' => 'Wallpaper*',            'url' => '', 'style' => 'font-family:Georgia,serif; font-size:15px; font-style:italic;'],
                ['logo_path' => null, 'name' => 'BBC Travel',            'url' => '', 'style' => 'font-family:Arial,sans-serif; font-size:15px; font-weight:700; letter-spacing:0.01em; color:#6b8f6b;'],
            ],
        ],
    ];

    /* ── Helpers ── */

    public static function getSection(string $section): self
    {
        return static::firstOrNew(
            ['section' => $section],
            ['data'    => static::DEFAULTS[$section] ?? []]
        );
    }

    public static function getValue(string $section, string $key, mixed $default = null): mixed
    {
        $setting = static::where('section', $section)->first();
        return $setting?->data[$key] ?? static::DEFAULTS[$section][$key] ?? $default;
    }

    public function mergeData(array $newData): void
    {
        $this->data = array_merge($this->data ?? [], $newData);
    }

    public function editor()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}