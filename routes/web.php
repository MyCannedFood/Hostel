<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Polosan stub routing untuk kebutuhan development.
| (Semua halaman ditampilkan tanpa login/role khusus untuk sementara)
*/

// Landing page
Route::get('/', fn () => view('landing'));

// -------------------------
// PUBLIC (tanpa login)
// -------------------------
Route::get('/rooms', fn () => view('pages.stub', ['page' => 'page daftar kamar public'])) ;
Route::get('/rooms/{id}', fn (int $id) => view('pages.stub', ['page' => "page detail kamar (id: $id)"]));
Route::get('/rooms/{id}/beds/{bedId}', fn (int $id, int $bedId) => view('pages.stub', ['page' => "page detail bed & harga (room: $id, bed: $bedId)"]));

Route::get('/register', fn () => view('pages.stub', ['page' => 'page register user']));
Route::post('/register', fn () => view('pages.stub', ['page' => 'page proses register user']));

Route::get('/login', fn () => view('pages.stub', ['page' => 'page login user']));
Route::post('/login', fn () => view('pages.stub', ['page' => 'page proses login user']));

Route::post('/logout', fn () => view('pages.stub', ['page' => 'page logout user (stub)']));

Route::get('/forgot-password', fn () => view('pages.stub', ['page' => 'page lupa password user']));
Route::post('/reset-password', fn () => view('pages.stub', ['page' => 'page reset password user']));

// -------------------------
// AUTH (sementara bisa diakses tanpa login untuk testing)
// -------------------------
Route::get('/dashboard', fn () => view('pages.stub', ['page' => 'page dashboard user']));
Route::get('/profile', fn () => view('pages.stub', ['page' => 'page edit profil user']));
Route::post('/profile/change-password', fn () => view('pages.stub', ['page' => 'page ganti password user']));

Route::get('/booking/create/{bedId}', fn (int $bedId) => view('pages.stub', ['page' => "page form booking user (bedId: $bedId)"]));
Route::post('/booking/{id}/confirm', fn (int $id) => view('pages.stub', ['page' => "page konfirmasi booking user (bookingId: $id)"]));
Route::get('/booking/{id}/payment', fn (int $id) => view('pages.stub', ['page' => "page halaman bayar user (bookingId: $id)"]));
Route::get('/booking/{id}/success', fn (int $id) => view('pages.stub', ['page' => "page bayar berhasil booking user (bookingId: $id)"]));
Route::get('/booking/{id}/failed', fn (int $id) => view('pages.stub', ['page' => "page bayar gagal booking user (bookingId: $id)"]));

Route::get('/my-bookings', fn () => view('pages.stub', ['page' => 'page riwayat booking user']));
Route::get('/my-bookings/{id}', fn (int $id) => view('pages.stub', ['page' => "page detail booking user (bookingId: $id)"]));

Route::get('/notifications', fn () => view('pages.stub', ['page' => 'page semua notifikasi user']));

// -------------------------
// ADMIN (sementara bisa diakses tanpa role khusus untuk testing)
// -------------------------
Route::get('/admin/login', fn () => view('pages.stub', ['page' => 'page login admin']));
Route::post('/admin/logout', fn () => view('pages.stub', ['page' => 'page logout admin']));

Route::get('/admin/dashboard', fn () => view('pages.stub', ['page' => 'page dashboard admin']));

Route::get('/admin/rooms', fn () => view('pages.stub', ['page' => 'page daftar kamar admin']));
Route::get('/admin/rooms/create', fn () => view('pages.stub', ['page' => 'page tambah kamar admin']));
Route::get('/admin/rooms/{id}/edit', fn (int $id) => view('pages.stub', ['page' => "page edit kamar admin (id: $id)"]));

Route::get('/admin/rooms/{id}/beds', fn (int $id) => view('pages.stub', ['page' => "page kelola bed admin (roomId: $id)"]));
Route::get('/admin/rooms/{id}/beds/create', fn (int $id) => view('pages.stub', ['page' => "page tambah bed admin (roomId: $id)"]));
Route::get('/admin/beds/{id}/edit', fn (int $id) => view('pages.stub', ['page' => "page edit bed admin (bedId: $id)"]));
Route::get('/admin/beds/{id}/pricing', fn (int $id) => view('pages.stub', ['page' => "page atur harga bed admin (bedId: $id)"]));

Route::get('/admin/facilities', fn () => view('pages.stub', ['page' => 'page master fasilitas admin']));
Route::get('/admin/facilities/create', fn () => view('pages.stub', ['page' => 'page tambah fasilitas admin']));
Route::get('/admin/beds/{id}/facilities', fn (int $id) => view('pages.stub', ['page' => "page fasilitas per bed admin (bedId: $id)"]));

Route::get('/admin/bookings', fn () => view('pages.stub', ['page' => 'page semua booking admin']));
Route::get('/admin/bookings/{id}', fn (int $id) => view('pages.stub', ['page' => "page detail booking admin (id: $id)"]));
Route::post('/admin/bookings/{id}/approve', fn (int $id) => view('pages.stub', ['page' => "page approve booking admin (id: $id)"]));
Route::post('/admin/bookings/{id}/checkin', fn (int $id) => view('pages.stub', ['page' => "page check-in tamu admin (id: $id)"]));
Route::post('/admin/bookings/{id}/checkout', fn (int $id) => view('pages.stub', ['page' => "page check-out tamu admin (id: $id)"]));

Route::get('/admin/payments', fn () => view('pages.stub', ['page' => 'page semua pembayaran admin']));
Route::get('/admin/payments/{id}', fn (int $id) => view('pages.stub', ['page' => "page detail pembayaran admin (id: $id)"]));

Route::get('/admin/refunds', fn () => view('pages.stub', ['page' => 'page daftar refund admin']));

Route::get('/admin/users', fn () => view('pages.stub', ['page' => 'page daftar user admin']));
Route::get('/admin/users/{id}', fn (int $id) => view('pages.stub', ['page' => "page detail user admin (id: $id)"]));

Route::get('/admin/reports/revenue', fn () => view('pages.stub', ['page' => 'page laporan pendapatan admin']));
Route::get('/admin/reports/occupancy', fn () => view('pages.stub', ['page' => 'page laporan hunian admin']));

Route::get('/admin/reviews', fn () => view('pages.stub', ['page' => 'page kelola ulasan admin']));
Route::get('/admin/logs', fn () => view('pages.stub', ['page' => 'page audit log admin']));

// -------------------------
// WEBHOOK (backend only)
// -------------------------
Route::post('/webhook/midtrans', fn () => view('pages.stub', ['page' => 'page webhook midtrans']));

