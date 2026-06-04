<?php

use Illuminate\Support\Facades\Route;
use App\Models\Room; 
use App\Models\Guest;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminExperienceController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\BedController;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceiptMail;
use App\Http\Controllers\ContactLocationController;
use App\Http\Controllers\Admin\AdminContactLocationSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'show'])->defaults('page', 'Home');
Route::get('/rooms', [RoomController::class, 'index']);

// USER GALLERY
Route::get('/gallery', [\App\Http\Controllers\PublicGalleryController::class, 'index']);

Route::get('/contact', [ContactLocationController::class, 'index'])
    ->name('contact');

Route::post('/contact', [ContactLocationController::class, 'store'])
    ->name('contact.store');

Route::get('/location', function () {
    return redirect('/contact');
});

Route::get('/contact-location', function () {
    return redirect('/contact');
});

// Experience
Route::get('/experience', [ExperienceController::class, 'index'])
    ->name('experience');
Route::get('/experience/booking-detail', fn () => view('pages.experience-booking-detail'));
Route::get('/experience/payment-method', fn () => view('pages.experience-payment-method'));
Route::get('/experience/payment', fn () => view('pages.experience-payment'));
Route::get('/experience/success', fn () => view('pages.experience-success'));

Route::get('/profile', fn () => view('pages.profile'));
Route::get('/journal', [\App\Http\Controllers\JournalController::class, 'index'])->name('journal.index');
Route::get('/journal/{article}', [\App\Http\Controllers\JournalController::class, 'show'])->name('journal.show');

// Book now routes
Route::get('/calendar', fn () => view('pages.calendar'));
Route::get('/room-selection', function (Request $request) {
    // Ambil data kamar dari database
    $rooms = Room::with('beds')->where('status', 'Available')->get();
    
    // Ambil parameter tanggal dari URL
    $checkIn = $request->query('check_in');
    $checkOut = $request->query('check_out');
    
    // Kirim data ke view
    return view('pages.room-selection', compact('rooms', 'checkIn', 'checkOut'));
})->name('booking.select-room');

Route::get('/bed-shared-room/{id}', function ($id) {
    // Panggil relasi beds DAN bedPin-nya
    $room = \App\Models\Room::with('beds.bedPin')->findOrFail($id);
    return view('pages.bed-shared-room', compact('room'));
});

Route::get('/guest-details', function () {
    $policies = \App\Models\GeneralSetting::getSection('operational_policies');
    return view('pages.guest-details', ['policies' => $policies->data]);
});
Route::get('/confirm-payment', fn () => view('pages.confirm-payment'));

Route::post('/api/create-booking', function (Request $request) {
    // 1. Simpan Data Tamu
    $guest = Guest::create([
        'booking_code' => 'BK-' . date('Y') . '-' . rand(1000, 9999),
        'status' => 'save',
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'age' => $request->age,
        'occupation' => $request->occupation,
        'country' => $request->country,
        'self_description' => $request->self_description,
    ]);

    // 2. Simpan Data Booking dengan Status PENDING
    $booking = Booking::create([
        'booking_code' => $guest->booking_code,
        'guest_id' => $guest->id,
        'room_id' => $request->room_id,
        'bed_id' => $request->bed_id,
        'check_in_date' => $request->check_in,
        'check_out_date' => $request->check_out,
        'total_nights' => $request->nights,
        'total_price' => $request->grand_total,
        'payment_method' => $request->payment_method,
        'status' => 'PENDING', 
    ]);

    return response()->json([
        'success' => true,
        'booking_code' => $booking->booking_code,
        'booking_id' => $booking->id
    ]);
});

Route::post('/api/confirm-booking/{id}', function ($id) {
    // Ambil data booking beserta data tamunya
    $booking = Booking::find($id);
    
    if($booking) {
        // 1. Ubah status menjadi lunas/terkonfirmasi
        $booking->update(['status' => 'CONFIRMED']);
        
        // 2. Ambil data tamu berdasarkan guest_id
        $guest = Guest::find($booking->guest_id);

        if($guest) {
            // 3. Kirim Email Notanya!
            try {
                Mail::to($guest->email)->send(new BookingReceiptMail($booking, $guest));
            } catch (\Exception $e) {
                // Tangkap error jika email gagal terkirim (misal internet putus / smtp salah)
                // Tapi biarkan transaksi tetap dianggap sukses di mata user
                \Log::error('Email gagal dikirim ke ' . $guest->email . ' Error: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 404);
});

Route::get('/guest-story', [PageController::class, 'guestStory'])->name('guest-story');

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
        [\App\Http\Controllers\AdminRevenueController::class, 'index'])
        ->name('admin.manage_revenue');

    Route::get('/Admin/Rooms-Management', function () {
        $selectedRoomId = (int) request('room_id', 0);
        $rooms = \App\Models\Room::with('beds')->latest()->get();

        if (!$selectedRoomId) {
            $selectedRoomId = (int) $rooms->first()?->id;
        }

        $selectedRoom = $rooms->firstWhere('id', $selectedRoomId) ?? $rooms->first();

        return view('admin.room-bed', compact('rooms', 'selectedRoom', 'selectedRoomId'));
    })->name('admin.rooms');

    // Add new room popup (returns only modal markup)
    Route::get('/admin/add-new-room-popup', function () {
        return view('admin.add-new-room-full');
    })->name('admin.add_new_room_popup');

    Route::get('add-new-room-popup', [AdminRoomController::class, 'addNewRoomPopup']);
    Route::post('rooms', [AdminRoomController::class, 'store']);
    Route::get('/admin/rooms/{room}/edit-popup', [AdminRoomController::class, 'editRoomPopup'])->name('admin.rooms.edit_popup');
    Route::put('rooms/{room}', [AdminRoomController::class, 'update'])->name('admin.rooms.update');
    Route::delete('rooms/{room}', [AdminRoomController::class, 'destroy'])->name('admin.rooms.destroy');

    // Add new bed popup (returns only modal markup)
    Route::get('/admin/add-new-bed-popup', [BedController::class, 'addNewBedPopup'])
        ->name('admin.add_new_bed_popup');

    Route::get('/admin/beds/{bed}/edit-popup', [BedController::class, 'editBedPopup'])
        ->name('admin.beds.edit_popup');

    Route::get('/admin/add-new-floor-popup', function (\Illuminate\Http\Request $request) {
        $selectedRoom = \App\Models\Room::with(['beds.bedPin', 'bedPins.bed'])->find($request->query('room_id'));
        return view('admin.add-new-floor', compact('selectedRoom'));
    })->name('admin.add_new_floor_popup');

    Route::prefix('admin')->group(function () {
        Route::post('rooms/{id}/upload-layout', [AdminRoomController::class, 'uploadLayout'])->name('rooms.upload_layout');

        Route::post('rooms/{room}/bed-pins/sync', [\App\Http\Controllers\Admin\BedPinController::class, 'syncRoomPins'])
            ->name('rooms.bed_pins.sync');

        Route::apiResource('bed-pins', \App\Http\Controllers\Admin\BedPinController::class)->only(['store', 'update', 'destroy']);

        Route::apiResource('beds', BedController::class)->except(['index', 'show']);
    });

    Route::get('/Admin/Manage-Bookings', [BookingController::class, 'index'])
        ->name('admin.bookings');

    Route::get('/admin/booking', [BookingController::class, 'index'])
        ->name('admin.booking');

    Route::get('/admin/booking/create', [BookingController::class, 'create'])
        ->name('admin.booking.create');

    Route::get('/admin/booking/{booking}/edit-popup', [BookingController::class, 'edit'])
        ->name('admin.booking.edit_popup');

    Route::post('/admin/booking', [BookingController::class, 'store'])
        ->name('admin.booking.store');

    Route::put('/admin/booking/{booking}', [BookingController::class, 'update'])
        ->name('admin.booking.update');

    Route::delete('/admin/booking/{booking}', [BookingController::class, 'destroy'])
        ->name('admin.booking.destroy');

    Route::patch('/admin/booking/{id}/status', [BookingController::class, 'updateStatus'])
        ->name('admin.booking.update_status');

    // ARTICLE MANAGEMENT
    Route::get('/admin/management-article', [AdminArticleController::class, 'index'])
        ->name('admin.article');

    Route::get('/admin/management-article/create', [AdminArticleController::class, 'create'])
        ->name('admin.article.create');

    Route::post('/admin/management-article/store', [AdminArticleController::class, 'store'])
        ->name('admin.article.store');

    Route::get('/admin/management-article/{article}/edit', [AdminArticleController::class, 'edit'])
        ->name('admin.article.edit');

    Route::put('/admin/management-article/{article}', [AdminArticleController::class, 'update'])
        ->name('admin.article.update');

    Route::delete('/admin/management-article/{article}', [AdminArticleController::class, 'destroy'])
        ->name('admin.article.destroy');

    Route::post('/admin/upload-image', [AdminArticleController::class, 'uploadImage'])
        ->name('admin.upload.image');

    // Finance
    Route::get('/Admin/Finance', function () {
        return view('admin.dashboard-layout', ['page' => 'Budgetin & Report']);
    })->name('admin.finance');

    // Experience
    Route::get('/admin/experience', [AdminExperienceController::class, 'index'])
        ->name('admin.experience');

    Route::post('/admin/experience/store', [AdminExperienceController::class, 'storeExperience'])
        ->name('admin.experience.store');

    Route::post('/admin/experience/{experience}/update', [AdminExperienceController::class, 'updateExperience'])
        ->name('admin.experience.update');

    Route::post('/admin/experience/{experience}/toggle', [AdminExperienceController::class, 'toggleStatus'])
        ->name('admin.experience.toggle');

    Route::delete('/admin/experience/{experience}', [AdminExperienceController::class, 'destroyExperience'])
        ->name('admin.experience.destroy');

    Route::post('/admin/experience/booking/store', [AdminExperienceController::class, 'storeBooking'])
        ->name('admin.experience.booking.store');

    Route::post('/admin/experience/booking/{booking}/update', [AdminExperienceController::class, 'updateBooking'])
        ->name('admin.experience.booking.update');

    Route::post('/admin/experience/booking/{booking}/checkin', [AdminExperienceController::class, 'checkIn'])
        ->name('admin.experience.booking.checkin');

    Route::post('/admin/experience/verify-ticket', [AdminExperienceController::class, 'verifyTicket'])
        ->name('admin.experience.verify');

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

    /*
    |--------------------------------------------------------------------------
    | STAFF CRUD
    |--------------------------------------------------------------------------
    */

    Route::post('/admin/staff',
        [\App\Http\Controllers\StaffController::class, 'store'])
        ->name('admin.staff.store');

    Route::put('/admin/staff/{admin}',
        [\App\Http\Controllers\StaffController::class, 'update'])
        ->name('admin.staff.update');

    Route::delete('/admin/staff/{admin}',
        [\App\Http\Controllers\StaffController::class, 'destroy'])
        ->name('admin.staff.destroy');

    /*
    |--------------------------------------------------------------------------
    | ROLES CRUD
    |--------------------------------------------------------------------------
    */

    Route::post('/admin/roles',
        [\App\Http\Controllers\RoleController::class, 'store'])
        ->name('admin.roles.store');

    Route::put('/admin/roles/{role}',
        [\App\Http\Controllers\RoleController::class, 'update'])
        ->name('admin.roles.update');

    Route::delete('/admin/roles/{role}',
        [\App\Http\Controllers\RoleController::class, 'destroy'])
        ->name('admin.roles.destroy');

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

    // ── GENERAL SETTINGS ──
    Route::get('/admin/settings/general', function () {
        return redirect()->route('admin.settings', ['section' => 'general']);
    })->name('admin.settings.general');

    Route::put('/admin/settings/hostel-information',
        [\App\Http\Controllers\GeneralSettingsController::class, 'updateHostelInformation'])
        ->name('admin.settings.hostel-information.update');

    Route::put('/admin/settings/operational-policies',
        [\App\Http\Controllers\GeneralSettingsController::class, 'updateOperationalPolicies'])
        ->name('admin.settings.operational-policies.update');

    // ── LANDING PAGE SETTINGS ──
    Route::put('/admin/landing/hero',
        [\App\Http\Controllers\LandingPageController::class, 'updateHero'])
        ->name('admin.landing.hero.update');

    Route::put('/admin/landing/philosophy',
        [\App\Http\Controllers\LandingPageController::class, 'updatePhilosophy'])
        ->name('admin.landing.philosophy.update');

    Route::put('/admin/landing/flora',
        [\App\Http\Controllers\LandingPageController::class, 'updateFlora'])
        ->name('admin.landing.flora.update');

    Route::put('/admin/landing/map',
        [\App\Http\Controllers\LandingPageController::class, 'updateMap'])
        ->name('admin.landing.map.update');

    Route::put('/admin/landing/featured-rooms',
        [\App\Http\Controllers\LandingPageController::class, 'updateFeaturedRooms'])
        ->name('admin.landing.featured-rooms.update');

    Route::put('/admin/landing/featured-articles',
        [\App\Http\Controllers\LandingPageController::class, 'updateFeaturedArticles'])
        ->name('admin.landing.featured-articles.update');

    Route::put('/admin/landing/guest-stories',
        [\App\Http\Controllers\LandingPageController::class, 'updateGuestStories'])
        ->name('admin.landing.guest-stories.update');

    Route::put('/admin/landing/awards',
        [\App\Http\Controllers\LandingPageController::class, 'updateAwards'])
        ->name('admin.landing.awards.update');

    Route::put('/admin/landing/media-partners',
        [\App\Http\Controllers\LandingPageController::class, 'updateMediaPartners'])
        ->name('admin.landing.media-partners.update');

 
    // CONTACT & LOCATION SETTINGS
    Route::get('/admin/settings/location',
        [AdminContactLocationSettingController::class, 'index'])
        ->name('admin.settings.location');

    Route::post('/admin/settings/location',
        [AdminContactLocationSettingController::class, 'update'])
        ->name('admin.settings.location.update');

    Route::post('/admin/settings/location/transportation',
        [AdminContactLocationSettingController::class, 'storeTransport'])
        ->name('admin.settings.location.transport.store');

    Route::put('/admin/settings/location/transportation/{transport}',
        [AdminContactLocationSettingController::class, 'updateTransport'])
        ->name('admin.settings.location.transport.update');

    Route::delete('/admin/settings/location/transportation/{transport}',
        [AdminContactLocationSettingController::class, 'destroyTransport'])
        ->name('admin.settings.location.transport.destroy');

});
