<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'show'])->defaults('page', 'Home');
Route::get('/rooms', fn () => view('pages.rooms'));
Route::get('/gallery', fn () => view('pages.gallery'));
Route::get('/experience', fn () => view('pages.experience'));
Route::get('/experience/booking-detail', fn () => view('pages.experience-booking-detail'));
Route::get('/experience/payment-method', fn () => view('pages.experience-payment-method'));
Route::get('/profile', fn () => view('pages.profile'));
Route::get('/journal', fn () => view('pages.journal'));
Route::get('/journal/detail', fn () => view('pages.journal-detail'));

// Book now routes
Route::get('/calendar', fn () => view('pages.calendar'));
Route::get('/room-selection', fn () => view('pages.room-selection'));
Route::get('/bed-shared-room', fn () => view('pages.bed-shared-room'));
Route::get('/guest-details', fn () => view('pages.guest-details'));
Route::get('/confirm-payment', fn () => view('pages.confirm-payment'));


// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (Protected)
Route::middleware(['is_admin'])->group(function () {

    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/admin/manage-guests', fn () => view('admin.manage_guests'))->name('admin.manage_guests');
    Route::get('/admin/manage-occupation', fn () => view('admin.manage_occupation'))->name('admin.manage_occupation');

    Route::get('/Admin/Rooms-Management', function () {
        return view('admin.dashboard-layout', ['page' => 'Room & Bed']);
    })->name('admin.rooms');

    Route::get('/Admin/Manage-Bookings', function () {
        return view('admin.dashboard-layout', ['page' => 'Booking']);
    })->name('admin.bookings');

    Route::get('/Admin/Price-Management', function () {
        return view('admin.dashboard-layout', ['page' => 'Article']);
    })->name('admin.article');

    Route::get('/Admin/Finance', function () {
        return view('admin.dashboard-layout', ['page' => 'Budgetin & Report']);
    })->name('admin.finance');

    Route::get('/Admin/Settings', function () {
        return view('admin.dashboard-layout', ['page' => 'Settings']);
    })->name('admin.settings');

    Route::get('/Admin/Finance-Accounting', function () {
        return view('admin.dashboard-layout', ['page' => 'Finance Accounting']);
    })->name('admin.finance-accounting');

});


// Serve dashboard CSS directly from resources during development
Route::get('/css/dashboard.css', function () {
    $path = resource_path('css/dashboard.css');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, ['Content-Type' => 'text/css']);
});

Route::get('/css/manage_guests.css', function () {
    $path = resource_path('css/manage_guests.css');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, ['Content-Type' => 'text/css']);
});

Route::get('/css/manage_occupation.css', function () {
    $path = resource_path('css/manage_occupation.css');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, ['Content-Type' => 'text/css']);
});
