<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationInfo extends Model
{
    protected $fillable = ['icon', 'title', 'description', 'routes', 'sort_order'];

    protected $casts = [
        'routes' => 'array',
    ];
}