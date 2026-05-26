<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'booking_code',
        'first_name',
        'last_name',
        'country',
        'check_in_date',
        'check_out_date',
    ];

    protected $casts = [
        'check_in_date'  => 'date',
        'check_out_date' => 'date',
    ];
}