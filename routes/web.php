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

// USER GALLERY
Route::get('/gallery', [\App\Http\Controllers\PublicGalleryController::class, 'index']);

Route::get('/experience', fn () => view('pages.experience'));
Route::get('/contact', fn () => view('pages.contact-location'));
Route::get('/location', fn () => view('pages.contact-location'));
Route::get('/contact-location', fn () => view('pages.contact-location'));

// Experience
Route::get('/experience/booking-detail', fn () => view('pages.experience-booking-detail'));
Route::get('/experience/payment-method', fn () => view('pages.experience-payment-method'));
Route::get('/experience/payment', fn () => view('pages.experience-payment'));
Route::get('/experience/success', fn () => view('pages.experience-success'));

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

    // Dashboard
    Route::get('/admin/dashboard',
        [\App\Http\Controllers\AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Manage Guests
    Route::get('/admin/manage-guests',
        [\App\Http\Controllers\AdminGuestController::class, 'index'])
        ->name('admin.manage_guests');

    Route::post('/admin/manage-guests',
        [\App\Http\Controllers\AdminGuestController::class, 'store'])
        ->name('admin.manage_guests.store');

    Route::post('/admin/manage-guests/checkout',
        [\App\Http\Controllers\AdminGuestController::class, 'checkout'])
        ->name('admin.manage_guests.checkout');

    Route::get('/admin/manage-occupation',
        fn () => view('admin.manage_occupation'))
        ->name('admin.manage_occupation');

    Route::get('/admin/manage-revenue',
        fn () => view('admin.manage_revenue'))
        ->name('admin.manage_revenue');

    Route::get('/Admin/Rooms-Management', function () {
        return view('admin.room-bed');
    })->name('admin.rooms');

    Route::get('/Admin/Manage-Bookings', function () {
        return view('admin.dashboard-layout', ['page' => 'Booking']);
    })->name('admin.bookings');

    Route::get('/admin/management-article', function () {
        return view('admin.article');
    })->name('admin.article');

    Route::get('/admin/management-article/create', function () {
        return view('admin.article-create');
    })->name('admin.article.create');

    Route::get('/Admin/Finance', function () {
        return view('admin.dashboard-layout', ['page' => 'Budgetin & Report']);
    })->name('admin.finance');

    // SETTINGS
    Route::get('/Admin/Settings',
        [\App\Http\Controllers\SettingsController::class, 'index'])
        ->name('admin.settings');

    // GALLERY CRUD
    Route::post('/admin/gallery',
        [\App\Http\Controllers\GalleryController::class, 'store'])
        ->name('admin.gallery.store');

    Route::put('/admin/gallery/{gallery}',
        [\App\Http\Controllers\GalleryController::class, 'update'])
        ->name('admin.gallery.update');

    Route::delete('/admin/gallery/{gallery}',
        [\App\Http\Controllers\GalleryController::class, 'destroy'])
        ->name('admin.gallery.destroy');

    // Finance Accounting
    Route::get('/admin/finance-accounting',
        [\App\Http\Controllers\AdminFinanceController::class, 'index'])
        ->name('admin.finance-accounting');

    Route::post('/admin/finance-accounting/approve-reject',
        [\App\Http\Controllers\AdminFinanceController::class, 'approveReject'])
        ->name('admin.finance.approve-reject');

    // Budgeting
    Route::get('/admin/budgeting',
        [\App\Http\Controllers\AdminBudgetingController::class, 'index'])
        ->name('admin.budgeting');

    Route::get('/admin/budgeting/requests',
        [\App\Http\Controllers\AdminBudgetingController::class, 'requests'])
        ->name('admin.budgeting.requests');

    Route::get('/admin/budgeting/stats',
        [\App\Http\Controllers\AdminBudgetingController::class, 'stats'])
        ->name('admin.budgeting.stats');

    Route::post('/admin/budgeting/requests',
        [\App\Http\Controllers\AdminBudgetRequestController::class, 'store'])
        ->name('admin.budgeting.requests.store');

    Route::post('/admin/budgeting/lpj',
        [\App\Http\Controllers\AdminLpjController::class, 'store'])
        ->name('admin.budgeting.lpj.store');

});