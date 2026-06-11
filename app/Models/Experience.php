<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'name_id',
        'short_description',
        'short_description_en',
        'short_description_id',
        'category',
        'price',
        'inclusions',
        'time_slots',
        'cover_image',
        'status',
    ];

    protected $casts = [
        'inclusions' => 'array',
        'time_slots' => 'array',
    ];

    public function getNameAttribute($value)
    {
        $locale = app()->getLocale();
        $localized = $this->{"name_{$locale}"};
        return $localized ?? $value;
    }

    public function getShortDescriptionAttribute($value)
    {
        $locale = app()->getLocale();
        $localized = $this->{"short_description_{$locale}"};
        return $localized ?? $value;
    }

    public function bookings()
    {
        return $this->hasMany(ExperienceBooking::class);
    }
}