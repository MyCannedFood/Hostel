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
            'headline'    => 'A Javanese Sanctuary, Woven by Nature',
            'subheadline' => 'Immerse yourself in the deep tranquility of Nusantara culture, where architecture breathes with the forest.',
            'bg_image'    => null,
        ],

        'philosophy' => [
            'tagline'     => 'OUR PHILOSOPHY',
            'heading'     => 'Breathing with the Earth',
            'body_1'      => 'At AlasAre, we believe true luxury is space. From our 500 sqm land, only 100 sqm is used for buildings. The remaining 400 sqm is intentionally returned to nature as a private, breathing forest.',
            'body_2'      => 'This mindful 4:1 ratio ensures that our traditional Javanese structures do not dominate the landscape, but rather nestle within it, allowing the ancient rhythms of the jungle to remain undisturbed.',
            'features'    => [
                ['icon_path' => null, 'icon_label' => 'Footprint', 'title' => 'Minimal Footprint', 'description' => 'Elevated structures preserving the natural topography and soil integrity.'],
                ['icon_path' => null, 'icon_label' => 'Rewilding', 'title' => 'Rewilding Project',  'description' => 'Over 200 native species planted to restore the local ecosystem.'],
            ],
            'side_image'  => null,
            'badge_label' => 'Conservation',
            'badge_value' => '80% Forest Cover',
        ],

        'flora' => [
            'eyebrow'     => 'Living Ecosystem',
            'title'       => 'The Flora Concept',
            'description' => 'Every plant at AlaSare serves a purpose, from culinary delights to therapeutic aromas, creating a multi-sensory journey through Java.',
            'cards'       => [
                ['image_path' => null, 'eyebrow' => 'Nourishment',  'title' => 'Edible Garden',       'description' => 'Discover our collection of rare Nusantara vegetables and medicinal herbs, harvested daily for our kitchen.'],
                ['image_path' => null, 'eyebrow' => 'Aromatherapy', 'title' => 'The Scent of Java',   'description' => 'Breathe in the calming essence of Melati (Jasmine) and Ylang-Ylang strategically planted to catch the evening breeze.'],
                ['image_path' => null, 'eyebrow' => 'Architecture', 'title' => 'Tropical Wilderness', 'description' => 'Lush Brazilian ferns and native creepers designed to blur the boundaries between your room and the jungle.'],
            ],
        ],

        'map' => [
            'subtitle'        => 'Explore the Ground',
            'title'           => 'AlaSare Map',
            'map_image'       => null,
            'updated_by_name' => null,
        ],

        'featured_rooms' => [
            'title'       => 'Sanctuaries',
            'description' => 'Each villa possesses a unique soul, crafted from reclaimed teak and designed to frame the forest.',
            'room_ids'    => [],
        ],

        'guest_stories' => [
            'title'   => 'Guest Stories',
            'stories' => [
                ['image_path' => null, 'name' => 'Edward & Claire', 'origin' => 'United Kingdom', 'quote' => 'A profound experience. The way the villa integrates with the jungle made us feel like we were sleeping in the canopy.'],
                ['image_path' => null, 'name' => 'Hiroshi & Yuki',  'origin' => 'Japan',          'quote' => 'Waking up to birdsong and the rustling of leaves, completely surrounded by green. AlasAre gave us a new definition of what luxury truly means.'],
                ['image_path' => null, 'name' => 'Sophie & Marc',   'origin' => 'France',         'quote' => 'The most restorative stay we have ever had. Every detail, from the herbs in our meals to the sound of rain on the jungle canopy, was deeply intentional.'],
            ],
        ],

        'awards' => [
            'section_title' => 'Awards and Recognition',
            'items'         => [
                ['icon_path' => null, 'title' => 'EarthCheck',        'sub' => 'Gold Certified',   'is_visible' => true],
                ['icon_path' => null, 'title' => "Traveler's Choice", 'sub' => 'TripAdvisor 2025', 'is_visible' => true],
                ['icon_path' => null, 'title' => 'Local Heritage',    'sub' => 'Preservation',     'is_visible' => true],
                ['icon_path' => null, 'title' => 'Zero Waste',        'sub' => 'Initiative',       'is_visible' => true],
            ],
        ],

        'featured_articles' => [
            'section_title'       => 'Journal & Stories',
            'section_description' => 'Curated stories on nature, slow living, and our architectural journey in the urban jungle.',
            'article_ids'         => [],   // max 3 integer IDs dari tabel articles
        ],

        'media_partners' => [
            'title'   => 'As Seen In',
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