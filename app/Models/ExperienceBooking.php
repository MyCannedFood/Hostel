<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceBooking extends Model
{
    protected $fillable = [
        'experience_id',
        'user_id',
        'ticket_id',
        'guest_name',
        'guest_email',
        'guest_whatsapp',
        'scheduled_date',
        'time_slot',
        'guest_count',
        'special_notes',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}