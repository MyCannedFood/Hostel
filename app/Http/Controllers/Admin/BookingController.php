<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Guest;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman utama Reservations Management (booking.blade.php)
     */
    public function index(Request $request)
    {
        // 1. Ambil data untuk statistik di bagian atas halaman
        $today = Carbon::today();
        
        $dailyArrivals = Booking::whereDate('check_in_date', $today)->where('status', 'CONFIRMED')->count();
        $pendingPayments = Booking::where('status', 'PENDING')->count();
        $checkoutToday = Booking::whereDate('check_out_date', $today)->count();
        $checkinToday = Booking::whereDate('check_in_date', $today)->count();

        // 2. Logika Pencarian dan Filter
        $query = Booking::with(['guest', 'room', 'bed'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('guest', function($g) use ($search) {
                      $g->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('phone', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('guest_code', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('room', function($room) use ($search) {
                      $room->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // Filter berdasarkan status jika dipilih
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('check_in_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('check_in_date', '<=', $request->date_to);
        }

        // Paginate data tabel (menampilkan 10 data per halaman)
        $bookings = $query->paginate(10)->withQueryString();
        $rooms = Room::all();

        return view('admin.booking', compact(
            'bookings', 
            'rooms',
            'dailyArrivals', 
            'pendingPayments', 
            'checkoutToday', 
            'checkinToday'
        ));
    }

    /**
     * Menampilkan form reservasi baru di dalam iframe (new-reservation.blade.php)
     */
    public function create()
    {
        // Mengambil hanya kamar dan kasur yang berstatus aktif/tersedia untuk dropdown form
        $rooms = Room::with(['beds' => function ($query) {
            $query->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)->orderBy('name')->get();
        $beds = Bed::where('is_active', true)->orderBy('name')->get();
        $guests = Guest::orderByDesc('id')->get([
            'id',
            'guest_code',
            'status',
            'first_name',
            'last_name',
            'email',
            'phone',
            'age',
            'occupation',
            'country',
            'city',
            'address',
            'id_number',
            'profile_picture',
            'id_card_photo',
            'deposit_amount',
            'deposit_notes',
            'self_description',
        ]);

        return view('admin.new-reservation', compact('rooms', 'beds', 'guests'));
    }

    /**
     * Menampilkan modal edit reservasi dengan data dari database.
     */
    public function edit(Booking $booking)
    {
        $booking->loadMissing(['guest', 'room', 'bed']);

        $rooms = Room::with(['beds' => function ($query) {
            $query->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)->orderBy('name')->get();

        $beds = Bed::where('is_active', true)->orderBy('name')->get();
        $guests = Guest::orderByDesc('id')->get([
            'id',
            'guest_code',
            'status',
            'first_name',
            'last_name',
            'email',
            'phone',
            'age',
            'occupation',
            'country',
            'city',
            'address',
            'id_number',
            'profile_picture',
            'id_card_photo',
            'self_description',
            'deposit_amount',
            'deposit_notes',
        ]);

        return view('admin.edit-new-reservation', compact('booking', 'rooms', 'beds', 'guests'));
    }

    /**
     * Menyimpan data reservasi baru (Proses pecah data ke tabel Guests & Bookings)
     */
    public function store(Request $request)
    {
        if ($request->has('deposit_amount')) {
            $cleaned = preg_replace('/[^\d]/', '', $request->input('deposit_amount'));
            $request->merge(['deposit_amount' => $cleaned !== '' ? (float) $cleaned : null]);
        }

        // Validasi semua field input dari form New Reservation
        $request->validate([
            // Validasi Tamu (Guests)
            'first_name'         => 'required_without:guest_id|string|max:255',
            'last_name'          => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:255',
            'age'                => 'nullable|integer|min:0',
            'occupation'         => 'nullable|string|max:255',
            'country'            => 'nullable|string|max:255',
            'city'               => 'nullable|string|max:255',
            'address'            => 'nullable|string|max:255',
            'id_number'          => 'nullable|string|max:255',
            'profile_picture'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_card_photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'self_description'   => 'nullable|string',
            'guest_id'           => 'nullable|exists:guests,id',
            'guest_status'       => 'nullable|in:save,block',
            'deposit_amount'     => 'nullable|numeric|min:0',
            'deposit_notes'      => 'nullable|string',

            // Validasi Transaksi (Bookings)
            'room_id'            => 'required|exists:rooms,id',
            'bed_id'             => 'nullable|exists:beds,id',
            'check_in_date'      => 'required|date',
            'check_out_date'     => 'required|date|after:check_in_date',
            'personal_notes'     => 'nullable|string',
            'special_requests'   => 'nullable|string',
            'arrival_time'       => 'nullable|string',
            'arrival_location'   => 'nullable|string',
            'departure_time'     => 'nullable|string',
            'departure_location' => 'nullable|string',
            'payment_method'     => 'required|string',
            'policy_accepted'    => 'accepted',
        ]);

        // Menggunakan Database Transaction untuk mencegah partial-save jika salah satu tabel error
        DB::beginTransaction();

        try {
            // 2. Generate Kode Booking Unik Otomatis (Format: BK-2026-XXXX)
            $bookingCode = $this->generateBookingCode();

            if ($request->filled('guest_id')) {
                $guest = Guest::findOrFail($request->guest_id);
                if (($guest->status ?? 'save') === 'block') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Guest ini diblokir dan tidak bisa dipakai untuk reservasi baru.',
                    ], 422);
                }

                // Handle File Uploads (Foto Profil & Foto KTP) untuk update tamu lama jika ada file baru
                $profilePath = $guest->profile_picture;
                $idCardPath = $guest->id_card_photo;

                if ($request->hasFile('profile_picture')) {
                    if ($profilePath) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($profilePath);
                    }
                    $profilePath = $request->file('profile_picture')->store('guests/profiles', 'public');
                }
                if ($request->hasFile('id_card_photo')) {
                    if ($idCardPath) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($idCardPath);
                    }
                    $idCardPath = $request->file('id_card_photo')->store('guests/id_cards', 'public');
                }

                $guest->update([
                    'first_name'       => $request->first_name ?? $guest->first_name,
                    'last_name'        => $request->last_name ?? $guest->last_name,
                    'email'            => $request->email ?? $guest->email,
                    'phone'            => $request->phone ?? $guest->phone,
                    'age'              => $request->age ?? $guest->age,
                    'occupation'       => $request->occupation ?? $guest->occupation,
                    'country'          => $request->country ?? $guest->country,
                    'city'             => $request->city ?? $guest->city,
                    'address'          => $request->address ?? $guest->address,
                    'id_number'        => $request->id_number ?? $guest->id_number,
                    'profile_picture'  => $profilePath,
                    'id_card_photo'    => $idCardPath,
                    'self_description' => $request->self_description ?? $guest->self_description,
                    'check_in_date'    => $request->check_in_date ?? $guest->check_in_date,
                    'check_out_date'   => $request->check_out_date ?? $guest->check_out_date,
                    'deposit_amount'   => $request->deposit_amount ?? $guest->deposit_amount,
                    'deposit_notes'    => $request->deposit_notes ?? $guest->deposit_notes,
                ]);
            } else {
                // 1. Handle File Uploads (Foto Profil & Foto KTP) untuk tamu baru
                $profilePath = null;
                $idCardPath = null;

                if ($request->hasFile('profile_picture')) {
                    $profilePath = $request->file('profile_picture')->store('guests/profiles', 'public');
                }
                if ($request->hasFile('id_card_photo')) {
                    $idCardPath = $request->file('id_card_photo')->store('guests/id_cards', 'public');
                }

                // Generate guest_code unik dengan format GST-YYYY-XXXXXX
                $year = Carbon::now()->format('Y');
                do {
                    $randomDigits = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $guestCode = 'GST-' . $year . '-' . $randomDigits;
                } while (Guest::where('guest_code', $guestCode)->exists());

                $guest = Guest::create([
                    'guest_code'       => $guestCode,
                    'status'           => 'save',
                    'booking_place'    => 'Walk-in',
                    'first_name'       => $request->first_name,
                    'last_name'        => $request->last_name,
                    'email'            => $request->email,
                    'phone'            => $request->phone,
                    'age'              => $request->age,
                    'occupation'       => $request->occupation,
                    'country'          => $request->country,
                    'city'             => $request->city,
                    'address'          => $request->address,
                    'id_number'        => $request->id_number,
                    'profile_picture'  => $profilePath,
                    'id_card_photo'    => $idCardPath,
                    'self_description' => $request->self_description,
                    'check_in_date'    => $request->check_in_date,
                    'check_out_date'   => $request->check_out_date,
                    'deposit_amount'   => $request->deposit_amount,
                    'deposit_notes'    => $request->deposit_notes,
                ]);
            }

            // 3. Kalkulasi total malam & harga sewa
            $checkIn = Carbon::parse($request->check_in_date);
            $checkOut = Carbon::parse($request->check_out_date);
            $totalNights = $checkIn->diffInDays($checkOut);

            // Ambil kasur yang dipilih, atau fallback ke kasur aktif pertama pada room yang dipilih.
            $selectedBed = null;
            if ($request->filled('bed_id')) {
                $selectedBed = Bed::where('id', $request->bed_id)
                    ->where('room_id', $request->room_id)
                    ->firstOrFail();
            } else {
                $selectedBed = Bed::where('room_id', $request->room_id)
                    ->where('is_active', true)
                    ->orderBy('id')
                    ->first();
            }

            $totalPrice = $selectedBed ? ($selectedBed->base_price * $totalNights) : 0;

            // 4. Simpan transaksi utama ke tabel bookings
            $booking = Booking::create([
                'booking_code'       => $bookingCode,
                'guest_id'           => $guest->id,
                'room_id'            => $request->room_id,
                'bed_id'             => $selectedBed?->id,
                'check_in_date'      => $request->check_in_date,
                'check_out_date'     => $request->check_out_date,
                'total_nights'       => $totalNights,
                'personal_notes'     => $request->personal_notes,
                'special_requests'   => $request->special_requests,
                'arrival_time'       => $request->arrival_time,
                'arrival_location'   => $request->arrival_location,
                'departure_time'     => $request->departure_time,
                'departure_location' => $request->departure_location,
                'total_price'        => $totalPrice,
                'payment_method'     => $request->payment_method,
                'policy_accepted'    => $request->has('policy_accepted'),
                'status'             => 'PENDING',
            ]);

            if ($selectedBed) {
                DB::table('booking_beds')->insert([
                    'booking_id' => $booking->id,
                    'bed_id' => $selectedBed->id,
                    'price_at_booking' => $selectedBed->base_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            // Berikan respon sukses untuk menutup modal dari dalam iframe
            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat dengan Kode: ' . $bookingCode
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Memperbarui data reservasi dan snapshot guest yang terhubung.
     */
    public function update(Request $request, Booking $booking)
    {
        if ($request->has('deposit_amount')) {
            $cleaned = preg_replace('/[^\d]/', '', $request->input('deposit_amount'));
            $request->merge(['deposit_amount' => $cleaned !== '' ? (float) $cleaned : null]);
        }

        $request->validate([
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:255',
            'age'                => 'nullable|integer|min:0',
            'occupation'         => 'nullable|string|max:255',
            'country'            => 'nullable|string|max:255',
            'city'               => 'nullable|string|max:255',
            'address'            => 'nullable|string|max:255',
            'id_number'          => 'nullable|string|max:255',
            'profile_picture'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_card_photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'self_description'   => 'nullable|string',
            'deposit_amount'     => 'nullable|numeric|min:0',
            'deposit_notes'      => 'nullable|string',
            'room_id'            => 'required|exists:rooms,id',
            'bed_id'             => 'nullable|exists:beds,id',
            'check_in_date'      => 'required|date',
            'check_out_date'     => 'required|date|after:check_in_date',
            'personal_notes'     => 'nullable|string',
            'special_requests'   => 'nullable|string',
            'arrival_time'       => 'nullable|string',
            'arrival_location'   => 'nullable|string',
            'departure_time'     => 'nullable|string',
            'departure_location' => 'nullable|string',
            'payment_method'     => 'required|string',
            'policy_accepted'    => 'accepted',
        ]);

        DB::beginTransaction();

        try {
            $guest = $booking->guest;

            if (!$guest) {
                $guest = Guest::create([
                    'guest_code' => $booking->booking_code,
                    'status' => 'save',
                ]);
                $booking->guest_id = $guest->id;
            }

            $profilePath = $guest->profile_picture;
            $idCardPath = $guest->id_card_photo;

            if ($request->hasFile('profile_picture')) {
                if ($profilePath) {
                    Storage::disk('public')->delete($profilePath);
                }
                $profilePath = $request->file('profile_picture')->store('guests/profiles', 'public');
            }

            if ($request->hasFile('id_card_photo')) {
                if ($idCardPath) {
                    Storage::disk('public')->delete($idCardPath);
                }
                $idCardPath = $request->file('id_card_photo')->store('guests/id_cards', 'public');
            }

            $guest->update([
                'status'           => 'save',
                'first_name'       => $request->first_name,
                'last_name'        => $request->last_name,
                'email'            => $request->email,
                'phone'            => $request->phone,
                'age'              => $request->age,
                'occupation'       => $request->occupation,
                'country'          => $request->country,
                'city'             => $request->city,
                'address'          => $request->address,
                'id_number'        => $request->id_number,
                'profile_picture'  => $profilePath,
                'id_card_photo'    => $idCardPath,
                'self_description' => $request->self_description,
                'check_in_date'    => $request->check_in_date,
                'check_out_date'   => $request->check_out_date,
                'deposit_amount'   => $request->deposit_amount,
                'deposit_notes'    => $request->deposit_notes,
            ]);

            $checkIn = Carbon::parse($request->check_in_date);
            $checkOut = Carbon::parse($request->check_out_date);
            $totalNights = $checkIn->diffInDays($checkOut);

            $selectedBed = null;
            if ($request->filled('bed_id')) {
                $selectedBed = Bed::where('id', $request->bed_id)
                    ->where('room_id', $request->room_id)
                    ->firstOrFail();
            } else {
                $selectedBed = Bed::where('room_id', $request->room_id)
                    ->where('is_active', true)
                    ->orderBy('id')
                    ->first();
            }

            $totalPrice = $selectedBed ? ($selectedBed->base_price * $totalNights) : 0;

            $booking->update([
                'room_id'            => $request->room_id,
                'bed_id'             => $selectedBed?->id,
                'check_in_date'      => $request->check_in_date,
                'check_out_date'     => $request->check_out_date,
                'total_nights'       => $totalNights,
                'personal_notes'     => $request->personal_notes,
                'special_requests'   => $request->special_requests,
                'arrival_time'       => $request->arrival_time,
                'arrival_location'   => $request->arrival_location,
                'departure_time'     => $request->departure_time,
                'departure_location' => $request->departure_location,
                'total_price'        => $totalPrice,
                'payment_method'     => $request->payment_method,
                'policy_accepted'    => $request->has('policy_accepted'),
            ]);

            DB::table('booking_beds')->where('booking_id', $booking->id)->delete();

            if ($selectedBed) {
                DB::table('booking_beds')->insert([
                    'booking_id' => $booking->id,
                    'bed_id' => $selectedBed->id,
                    'price_at_booking' => $selectedBed->base_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Menghapus reservasi.
     */
    public function destroy(Booking $booking)
    {
        try {
            DB::table('booking_beds')->where('booking_id', $booking->id)->delete();
            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mengubah status pesanan secara instan (Konfirmasi / Batalkan)
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate(['status' => 'required|in:PENDING,CONFIRMED,CANCELLED,COMPLETED']);
        
        $booking->update(['status' => $request->status]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status reservasi berhasil diperbarui.',
                'data' => [
                    'id' => $booking->id,
                    'status' => $booking->status,
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    private function generateBookingCode(): string
    {
        $year = Carbon::now()->format('Y');
        $prefix = 'BK-' . $year . '-';

        $lastGuestCode = Guest::where('guest_code', 'like', $prefix . '%')
            ->orderByDesc('guest_code')
            ->value('guest_code');

        $lastBookingCode = Booking::where('booking_code', 'like', $prefix . '%')
            ->orderByDesc('booking_code')
            ->value('booking_code');

        $lastCode = null;

        if ($lastGuestCode && $lastBookingCode) {
            $lastCode = strcmp($lastGuestCode, $lastBookingCode) >= 0 ? $lastGuestCode : $lastBookingCode;
        } elseif ($lastGuestCode) {
            $lastCode = $lastGuestCode;
        } elseif ($lastBookingCode) {
            $lastCode = $lastBookingCode;
        }

        $nextIncrement = 1001;
        if ($lastCode) {
            $nextIncrement = ((int) substr($lastCode, -4)) + 1;
        }

        do {
            $bookingCode = $prefix . $nextIncrement;
            $nextIncrement++;
        } while (
            Guest::where('guest_code', $bookingCode)->exists() ||
            Booking::where('booking_code', $bookingCode)->exists()
        );

        return $bookingCode;
    }
    
    public function selectRoom(Request $request)
    {
        // Mengambil kamar yang tersedia beserta relasi kasurnya
        $rooms = Room::with('beds')
            ->where('status', 'Available')
            ->get();

        return view('booking.select-room', compact('rooms'));
    }
}