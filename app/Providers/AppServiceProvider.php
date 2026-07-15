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

        // Share jumlah unread notification ke semua view secara lazy menggunakan View Composer
        View::composer('*', function ($view) {
            try {
                if (\Schema::hasTable('admin_notifications')) {
                    $unreadCount = AdminNotification::active()
                        ->where('is_read', false)
                        ->count();
                } else {
                    $unreadCount = 0;
                }
            } catch (\Exception $e) {
                $unreadCount = 0;
            }
            $view->with('unreadCount', $unreadCount);
        });
    }
}