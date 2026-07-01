<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Models\ExperienceBooking;
use App\Observers\BookingObserver;
use App\Observers\ExperienceBookingObserver;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Booking::observe(BookingObserver::class);
        ExperienceBooking::observe(ExperienceBookingObserver::class);

        if (Schema::hasTable('admin_notifications')) {
            View::share(
                'unreadCount',
                AdminNotification::active()
                    ->where('is_read', false)
                    ->count()
            );
        } else {
            View::share('unreadCount', 0);
        }
    }
}