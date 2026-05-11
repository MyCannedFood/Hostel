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

Route::get('/Hostel/Admin', [PageController::class, 'show'])->defaults('page', 'Hostel/Admin');


