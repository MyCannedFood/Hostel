<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    protected $fillable = [
        'name',
        'photo',
        'layout_photo', // Menyimpan foto denah
        'gender_type',
        'capacity',
        'description',
        'attributes',
        'main_facilities',
        'status',
        'is_active',
    ];

    /**
     * Relasi ke data kasur (One-to-Many)
     * 1 Kamar memiliki banyak Kasur
     */
    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

    /**
     * Relasi ke titik pin denah (One-to-Many)
     * 1 Kamar memiliki banyak Titik Pin pada denah layout-nya
     */
    public function bedPins()
    {
        return $this->hasMany(BedPin::class);
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}