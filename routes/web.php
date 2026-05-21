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
    Route::get('/Admin/Dashboard', [PageController::class, 'showAdmin'])->defaults('page', 'Admin/Dashboard');
    Route::get('/Admin/Rooms-Management', [PageController::class, 'showAdmin'])->defaults('page', 'Rooms Management');
    Route::get('/Admin/Manage-Bookings', [PageController::class, 'showAdmin'])->defaults('page', 'Manage Bookings');
    Route::get('/Admin/Price-Management', [PageController::class, 'showAdmin'])->defaults('page', 'Price Management');
    Route::get('/Admin/Finance', [PageController::class, 'showAdmin'])->defaults('page', 'Finance');
});



