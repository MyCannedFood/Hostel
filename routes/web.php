<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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

// Admin Routes
Route::get('/Admin/Dashboard', [PageController::class, 'showAdmin'])->defaults('page', 'Admin/Dashboard');

Route::get('/Admin/Rooms-Management', [PageController::class, 'showAdmin'])->defaults('page', 'Rooms Management');

Route::get('/Admin/Manage-Bookings', [PageController::class, 'showAdmin'])->defaults('page', 'Manage Bookings');

Route::get('/Admin/Price-Management', [PageController::class, 'showAdmin'])->defaults('page', 'Price Management');

Route::get('/Admin/Finance', [PageController::class, 'showAdmin'])->defaults('page', 'Finance');



