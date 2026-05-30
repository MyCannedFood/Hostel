<?php
// FILE: app/Models/LandingPageSetting.php  (ganti seluruh isi)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    protected $table    = 'landing_page_settings';
    protected $fillable = ['section', 'data', 'updated_by'];
    protected $casts    = ['data' => 'array'];

    public const SECTIONS = [
        'hero', 'philosophy', 'flora', 'map', 'guest_stories',
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
                [
                    'icon_path'   => null,   // path in storage/app/public/landing/philosophy/icons/
                    'icon_label'  => 'Footprint',
                    'title'       => 'Minimal Footprint',
                    'description' => 'Elevated structures preserving the natural topography and soil integrity.',
                ],
                [
                    'icon_path'   => null,
                    'icon_label'  => 'Rewilding',
                    'title'       => 'Rewilding Project',
                    'description' => 'Over 200 native species planted to restore the local ecosystem.',
                ],
            ],
            'side_image'  => null,   // path in storage/app/public/landing/philosophy/
            'badge_label' => 'Conservation',
            'badge_value' => '80% Forest Cover',
        ],

        'flora' => [
            'title'       => 'The Flora Concept',
            'description' => 'Our commitment to Indonesian biodiversity is reflected in every corner of AlaSare.',
            'cards'       => [],
        ],

        'map' => [
            'map_image'       => null,
            'updated_by_name' => null,
        ],

        'guest_stories' => [
            'title'   => 'Guest Stories',
            'stories' => [],
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