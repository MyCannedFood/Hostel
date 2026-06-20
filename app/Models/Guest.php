<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_code',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'age',
        'gender',
        'occupation',
        'country',
        'booking_place',
        'city',
        'address',
        'id_number',
        'profile_picture',
        'id_card_photo',
        // Deposit (diisi saat check-in)
        'deposit_amount',
        'deposit_notes',
        // Deskripsi tambahan
        'self_description',
        'personal_notes',
        // Check-in / Check-out
        'check_in_date',
        'check_out_date',
        'duration',
        // Checkout data
        'checkout_charges',
        'checkout_notes',
    ];

    protected $casts = [
        'check_in_date'    => 'date',
        'check_out_date'   => 'date',
        'checkout_charges' => 'array',
        'deposit_amount'   => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}