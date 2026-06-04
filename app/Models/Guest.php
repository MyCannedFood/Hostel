<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'booking_code',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'age',
        'occupation',
        'country',
        'city',
        'address',
        'id_number',
        'profile_picture',
        'id_card_photo',
        'self_description',
        'check_in_date',
        'check_out_date',
    ];

    /**
     * Relasi ke data Booking (One-to-Many)
     * 1 Tamu bisa memiliki banyak riwayat pesanan/booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}