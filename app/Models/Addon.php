<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_auto_include' => 'boolean',
        'is_active' => 'boolean',
        'include_days' => 'array', // Otomatis convert JSON ke Array
    ];
}