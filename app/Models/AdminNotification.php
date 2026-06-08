<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $table = 'admin_notifications';

    protected $fillable = [
        'type',
        'reference_id',
        'is_read',
        'is_dismissed',
    ];

    protected $casts = [
        'is_read'      => 'boolean',
        'is_dismissed' => 'boolean',
    ];

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    /** Hanya notif yang belum di-dismiss */
    public function scopeActive($query)
    {
        return $query->where('is_dismissed', false);
    }

    /** Hanya notif yang belum dibaca */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // ──────────────────────────────────────────
    // Relasi Dinamis
    // ──────────────────────────────────────────

    /**
     * Ambil data booking atau experience booking
     * berdasarkan kolom 'type'.
     */
    public function reference()
    {
        return match($this->type) {
            'booking'    => $this->belongsTo(Booking::class, 'reference_id')
                                 ->with(['guest', 'room', 'bed']),
            'experience' => $this->belongsTo(ExperienceBooking::class, 'reference_id')
                                 ->with('experience'),
            default      => null,
        };
    }

    /**
     * Shortcut getter — pakai $notif->data untuk akses
     * langsung ke objek Booking / ExperienceBooking-nya.
     */
    public function getDataAttribute()
    {
        return match($this->type) {
            'booking'    => Booking::with(['guest', 'room', 'bed'])->find($this->reference_id),
            'experience' => ExperienceBooking::with('experience')->find($this->reference_id),
            default      => null,
        };
    }
}