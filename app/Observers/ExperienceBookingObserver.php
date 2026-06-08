<?php

namespace App\Observers;

use App\Models\ExperienceBooking;
use App\Models\AdminNotification;

class ExperienceBookingObserver
{
    /**
     * Otomatis buat notifikasi admin setiap kali
     * ada experience booking baru dari user.
     * Dipicu setelah confirmPayment() di ExperienceController berhasil.
     */
    public function created(ExperienceBooking $expBooking): void
    {
        AdminNotification::create([
            'type'         => 'experience',
            'reference_id' => $expBooking->id,
            'is_read'      => false,
            'is_dismissed' => false,
        ]);
    }
}