<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table    = 'general_settings';
    protected $fillable = ['section', 'data', 'updated_by'];
    protected $casts    = ['data' => 'array'];

    public const DEFAULTS = [
        'hostel_info' => [
            'hostel_name'       => 'AloSore Eco Hostel',
            'default_language'  => 'en',
            'currency'          => 'IDR',
            'timezone'          => 'Asia/Makassar',
            'site_title'        => 'AloSore Eco Hostel | Sanctuary in Nature',
            'meta_description'  => 'Experience ecological mindfulness…',
            'languages'         => ['English (EN)', 'Indonesian (ID)'],
            'main_logo'         => null,
            'favicon'           => null,
        ],

        'operational_policies' => [
            'checkin_time'    => '14:00',
            'checkout_time'   => '12:00',
            'late_policy'     => 'Subject to availability',
            'tax_included'    => true,
            'government_tax'  => 11,
            'service_charge'  => 5,
            'house_rules'     => "No smoking inside rooms\nQuiet hours after 22:00\nGuests must register at reception",
        ],
    ];

    public static function getSection(string $section): self
    {
        return static::firstOrNew(
            ['section' => $section],
            ['data' => static::DEFAULTS[$section] ?? []]
        );
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
