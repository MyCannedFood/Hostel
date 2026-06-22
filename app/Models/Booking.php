<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'booking_code',
        'guest_id',
        'room_id',
        'bed_id',
        'check_in_date',
        'check_out_date',
        'total_nights',
        'personal_notes',
        'special_requests',
        'arrival_time',
        'arrival_location',
        'departure_time',
        'departure_location',
        'total_price',
        'payment_method',
        'policy_accepted',
        'status',
        'checkin_status',
        'actual_check_in',
        'checkout_status',
        'actual_check_out',
        'extra_charges',
    ];

    /**
     * Cast tanggal agar otomatis menjadi objek Carbon 
     * (mempermudah manipulasi format tanggal di Blade nanti)
     */
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'policy_accepted' => 'boolean',
        'extra_charges' => 'array',
    ];

    /**
     * Booking ini milik dari 1 Tamu tertentu (BelongsTo)
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * Booking ini memesan 1 Kamar tertentu (BelongsTo)
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Booking ini memesan 1 Kasur spesifik (BelongsTo - Nullable)
     */
    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}