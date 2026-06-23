<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'payment_method',
        'payment_channel',
        'amount',
        'status',
        'va_number',
        'qr_code_url',
        'paid_at',
        'expired_at',
        'midtrans_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'midtrans_response' => 'json',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
