<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Models\ExperienceBooking;
use App\Observers\BookingObserver;
use App\Observers\ExperienceBookingObserver;

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
    }
}