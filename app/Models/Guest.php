<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    // HAPUS $guarded, pakai $fillable saja
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
        'gender',
        'booking_place',  // ← sudah ada, tidak duplikat
        'city',
        'address',
        'id_number',
        'profile_picture',
        'id_card_photo',
        'self_description',
        'check_in_date',
        'check_out_date',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}