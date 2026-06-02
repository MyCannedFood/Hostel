<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedPin extends Model
{
    // Properti fillable agar bisa di-input secara massal oleh controller
    protected $fillable = [
        'room_id',
        'bed_id',
        'point_label',
        'position_top',
        'position_left',
    ];

    /**
     * Pin ini berada di dalam kamar mana (BelongsTo)
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Kasur mana yang terhubung ke pin ini (BelongsTo)
     * Ditulis nullable di database, jadi relasi ini bisa mengembalikan null jika belum di-assign
     */
    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}