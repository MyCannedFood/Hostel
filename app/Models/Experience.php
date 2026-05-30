<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'name',
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

    public function bookings()
    {
        return $this->hasMany(ExperienceBooking::class);
    }
}