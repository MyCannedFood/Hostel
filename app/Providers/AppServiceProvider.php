<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Models\ExperienceBooking;
use App\Observers\BookingObserver;
use App\Observers\ExperienceBookingObserver;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan observer — ini yang bikin notifikasi
        // muncul otomatis tanpa sentuh BookingController atau ExperienceController
        Booking::observe(BookingObserver::class);
        ExperienceBooking::observe(ExperienceBookingObserver::class);

        // Share jumlah unread notification ke semua view
        View::share(
            'unreadCount',
            AdminNotification::active()
                ->where('is_read', false)
                ->count()
        );
    }
}