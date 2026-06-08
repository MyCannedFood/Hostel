<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\AdminNotification;

class BookingObserver
{
    /**
     * Otomatis buat notifikasi admin setiap kali
     * ada booking baru masuk dari user.
     */
    public function created(Booking $booking): void
    {
        AdminNotification::create([
            'type'         => 'booking',
            'reference_id' => $booking->id,
            'is_read'      => false,
            'is_dismissed' => false,
        ]);
    }

    // Tidak butuh hook lain untuk saat ini.
    // updated(), deleted(), dll bisa ditambah nanti.
}