<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bed extends Model
{
    use SoftDeletes; // Mengaktifkan deleted_at

    protected $fillable = [
        'room_id',
        'name',
        'position',
        'status',
        'base_price',
        'is_active'
    ];

    /**
     * Relasi balik ke Kamar (BelongsTo)
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Relasi ke titik koordinat denah (One-to-One)
     * 1 Kasur hanya dipetakan ke 1 Titik Pin denah
     */
    public function bedPin()
    {
        return $this->hasOne(BedPin::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}