<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guests';

    protected $fillable = [
        'booking_code',
        'first_name',
        'last_name',
        'country',
    ];
}

