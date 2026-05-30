<?php
// FILE: app/Models/LandingPageSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    protected $table    = 'landing_page_settings';
    protected $fillable = ['section', 'data', 'updated_by'];
    protected $casts    = ['data' => 'array'];

    /* ── Sections yang tersedia ── */
    public const SECTIONS = [
        'hero', 'philosophy', 'flora', 'map', 'guest_stories',
    ];

    /* ── Default values per section ── */
    public const DEFAULTS = [
        'hero' => [
            'headline'    => 'A Javanese Sanctuary, Woven by Nature',
            'subheadline' => 'Immerse yourself in the deep tranquility of Nusantara culture, where architecture breathes with the forest.',
            'bg_image'    => null,
        ],
        'philosophy' => [
            'tagline'     => 'OUR PHILOSOPHY',
            'heading'     => 'Breathing with the Earth',
            'description' => 'Our architecture follows a strict 4:1 land ratio, ensuring that for every square meter of built space, four remain wild.',
            'features'    => [
                ['icon' => '🌿', 'label' => 'Minimal Footprint'],
                ['icon' => '🌱', 'label' => 'Rewilding Project'],
            ],
            'side_image'  => null,
        ],
        'flora' => [
            'title'       => 'The Flora Concept',
            'description' => 'Our commitment to Indonesian biodiversity is reflected in every corner of AlaSare.',
            'cards'       => [],
        ],
        'map' => [
            'map_image' => null,
        ],
        'guest_stories' => [
            'stories' => [],
        ],
    ];

    /* ──────────────────────────────────────────────
       Helpers
    ────────────────────────────────────────────── */

    /**
     * Ambil record section. Kalau belum ada di DB, kembalikan default.
     */
    public static function getSection(string $section): self
    {
        return static::firstOrNew(
            ['section' => $section],
            ['data'    => static::DEFAULTS[$section] ?? []]
        );
    }

    /**
     * Ambil satu nilai dari data section, dengan fallback ke default.
     */
    public static function getValue(string $section, string $key, mixed $default = null): mixed
    {
        $setting = static::where('section', $section)->first();
        return $setting?->data[$key] ?? static::DEFAULTS[$section][$key] ?? $default;
    }

    /**
     * Gabungkan data lama dengan data baru (partial update).
     */
    public function mergeData(array $newData): void
    {
        $this->data = array_merge($this->data ?? [], $newData);
    }

    /* ── Relasi ── */
    public function editor()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}