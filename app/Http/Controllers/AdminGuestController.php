<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AdminGuestController extends Controller
{
    public function index()
    {
        $guests = Guest::with(['bookings' => function ($q) {
                $q->orderByDesc('id')->limit(1)->select('id', 'guest_id');
            }])
            ->orderByDesc('id')
            ->paginate(10, [
                'id', 'guest_code', 'first_name', 'last_name', 'country',
                'gender', 'age', 'booking_place', 'status',
                'check_in_date', 'check_out_date',
                // Kolom untuk modal edit guest
                'email', 'phone', 'occupation', 'id_number', 'city',
                'self_description', 'profile_picture', 'id_card_photo',
            ]);

        $now   = Carbon::now();
        $today = Carbon::today();

        // --- Stats berdasarkan check_in_date ---
        $guestStats = [
            'today' => Guest::whereDate('check_in_date', $today)->count(),
            'week'  => Guest::whereBetween('check_in_date', [
                $now->copy()->startOfWeek(Carbon::MONDAY),
                $now->copy()->endOfWeek(Carbon::SUNDAY),
            ])->count(),
            'month' => Guest::whereYear('check_in_date', $now->year)
                ->whereMonth('check_in_date', $now->month)
                ->count(),
        ];

        // --- Breakdown per period ---
        $guestStats['today_breakdown'] = $this->getBreakdown(
            Guest::whereDate('check_in_date', $today)->get(['country'])
        );

        $guestStats['week_breakdown'] = $this->getBreakdown(
            Guest::whereBetween('check_in_date', [
                $now->copy()->startOfWeek(Carbon::MONDAY),
                $now->copy()->endOfWeek(Carbon::SUNDAY),
            ])->get(['country'])
        );

        $guestStats['month_breakdown'] = $this->getBreakdown(
            Guest::whereYear('check_in_date', $now->year)
                ->whereMonth('check_in_date', $now->month)
                ->get(['country'])
        );

        // --- Check-in / Check-out hari ini (untuk card split) ---
        $guestStats['checkin_today']  = Guest::whereDate('check_in_date', $today)->count();
        $guestStats['checkout_today'] = Guest::whereDate('check_out_date', $today)->count();

        // --- Guest Trend (rolling 7 hari berdasarkan check_in_date) ---
        $trendLabels = [];
        $trendData   = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $trendLabels[] = $day->format('D');
            $trendData[]   = Guest::whereDate('check_in_date', $day)->count();
        }

        // --- Guests per Room ---
        $activeGuestIds = Guest::whereNull('check_out_date')->pluck('id');

        $roomsWithGuests = Room::with('beds')->get()->map(function ($room) use ($activeGuestIds) {
            $bookings = Booking::whereIn('room_id', [$room->id])
                ->whereIn('guest_id', $activeGuestIds)
                ->get();

            $bedsByPosition = $room->beds->map(function ($bed) use ($bookings) {
                $normalized = str_contains($bed->position, 'Bottom') ? 'Bottom' : 'Top';
                $occupied = $bookings->where('bed_id', $bed->id)->count();
                return [
                    'position' => $normalized,
                    'occupied' => $occupied,
                ];
            })->groupBy('position')->map(function ($beds, $position) {
                return [
                    'position' => $position,
                    'total'    => $beds->count(),
                    'occupied' => $beds->sum('occupied'),
                ];
            })->values();

            return [
                'name'          => $room->name,
                'beds'          => $bedsByPosition,
                'total_guests'  => $bookings->count(),
            ];
        });

        // --- Checked-in bookings for checkout dropdown ---
        $checkedInBookings = Booking::with('guest')
            ->where('checkin_status', 1)
            ->where('checkout_status', 0)
            ->orderByDesc('id')
            ->get()
            ->map(function ($b) {
                $g = $b->guest;
                $name = $g ? ($g->first_name . ' ' . $g->last_name) : 'Unknown';
                $ciDate = $b->check_in_date ? $b->check_in_date->format('d M Y') : '-';
                $coDate = $b->check_out_date ? $b->check_out_date->format('d M Y') : '-';
                return [
                    'booking_code' => $b->booking_code,
                    'guest_code'   => $g->guest_code ?? '-',
                    'label'        => $b->booking_code . ' - ' . $name . ' (' . $ciDate . ' s/d ' . $coDate . ')',
                ];
            });

        return view('admin.manage_guests', compact(
            'guests',
            'guestStats',
            'trendLabels',
            'trendData',
            'roomsWithGuests',
            'checkedInBookings'
        ));
    }

    public function store(Request $request)
    {
        // 1. Validasi semua input dari form
        $validator = Validator::make($request->all(), [
            'first_name'       => ['required', 'string', 'max:255'],
            'last_name'        => ['nullable', 'string', 'max:255'],
            'gender'           => ['required', 'string', 'in:Male,Female'],
            'age'              => ['nullable', 'integer', 'min:0'],
            'email'            => ['nullable', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:50'],
            'occupation'       => ['nullable', 'string', 'max:255'],
            'id_number'        => ['nullable', 'string', 'max:255'],
            'city'             => ['nullable', 'string', 'max:255'],
            'country'          => ['nullable', 'string', 'max:255'],
            'self_description' => ['nullable', 'string'],
            'profile_picture'  => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Maksimal 2MB
            'id_card_photo'    => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Jika validasi gagal, kembali ke form beserta pesan error
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 2. Handle File Upload (Jika tamu mengupload foto)
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            // Disimpan ke folder: storage/app/public/guests/profiles
            $profilePicturePath = $request->file('profile_picture')->store('guests/profiles', 'public');
        }

        $idCardPhotoPath = null;
        if ($request->hasFile('id_card_photo')) {
            // Disimpan ke folder: storage/app/public/guests/id_cards
            $idCardPhotoPath = $request->file('id_card_photo')->store('guests/id_cards', 'public');
        }

        // 3. Ambil guest_code dari request form JS
        $guestCode = $request->input('guest_code');

        // 4. Simpan semua data ke database tabel 'guests'
        Guest::create([
            'guest_code'       => $guestCode,
            'status'           => 'save',
            'first_name'       => $request->input('first_name'),
            'last_name'        => $request->input('last_name'),
            'gender'           => $request->input('gender'),
            'age'              => $request->input('age'),
            'email'            => $request->input('email'),
            'phone'            => $request->input('phone'),
            'occupation'       => $request->input('occupation'),
            'id_number'        => $request->input('id_number'),
            'city'             => $request->input('city'),
            'country'          => $request->input('country'),
            'self_description' => $request->input('self_description'),
            'profile_picture'  => $profilePicturePath,
            'id_card_photo'    => $idCardPhotoPath,
            'duration'          => null,                    // ← diisi nanti saat check-in
            'check_in_date'    => null,                    // ← diisi nanti saat check-in
            'check_out_date'   => null,                    // ← diisi nanti saat checkout
        ]);

        // 5. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.manage_guests') // Pastikan nama route ini sudah benar di web.php
            ->with('success', 'Guest added successfully.');
    }

    public function update(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);

        if ($request->has('deposit_amount')) {
            $cleaned = preg_replace('/[^\d]/', '', $request->input('deposit_amount'));
            $request->merge(['deposit_amount' => $cleaned !== '' ? (float) $cleaned : null]);
        }

        $validator = Validator::make($request->all(), [
            'first_name'       => ['required', 'string', 'max:255'],
            'last_name'        => ['nullable', 'string', 'max:255'],
            'gender'           => ['nullable', 'string', 'in:Male,Female'],
            'age'              => ['nullable', 'integer', 'min:0'],
            'email'            => ['nullable', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:50'],
            'occupation'       => ['nullable', 'string', 'max:255'],
            'id_number'        => ['nullable', 'string', 'max:255'],
            'city'             => ['nullable', 'string', 'max:255'],
            'country'          => ['nullable', 'string', 'max:255'],
            'self_description' => ['nullable', 'string'],
            'profile_picture'  => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'id_card_photo'    => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'deposit_amount'   => ['nullable', 'numeric', 'min:0'],
            'deposit_notes'    => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Handle foto upload — ganti hanya jika file baru dikirim
        $profilePicturePath = $guest->profile_picture;
        if ($request->hasFile('profile_picture')) {
            if ($profilePicturePath) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profilePicturePath);
            }
            $profilePicturePath = $request->file('profile_picture')->store('guests/profiles', 'public');
        }

        $idCardPhotoPath = $guest->id_card_photo;
        if ($request->hasFile('id_card_photo')) {
            if ($idCardPhotoPath) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($idCardPhotoPath);
            }
            $idCardPhotoPath = $request->file('id_card_photo')->store('guests/id_cards', 'public');
        }

        $guest->update([
            'first_name'       => $request->input('first_name'),
            'last_name'        => $request->input('last_name'),
            'gender'           => $request->input('gender') ?? $guest->gender,
            'age'              => $request->input('age'),
            'email'            => $request->input('email'),
            'phone'            => $request->input('phone'),
            'occupation'       => $request->input('occupation'),
            'id_number'        => $request->input('id_number'),
            'city'             => $request->input('city'),
            'country'          => $request->input('country'),
            'self_description' => $request->input('self_description'),
            'profile_picture'  => $profilePicturePath,
            'id_card_photo'    => $idCardPhotoPath,
            'deposit_amount'   => $request->input('deposit_amount'),
            'deposit_notes'    => $request->input('deposit_notes'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data guest ' . $guest->first_name . ' ' . $guest->last_name . ' berhasil diperbarui.',
        ]);
    }

    public function search($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)->first();
        if ($booking) {
            $guest = $booking->guest;
        } else {
            $guest = Guest::where('guest_code', $bookingCode)->first();
            if ($guest) {
                $booking = $guest->bookings()->orderByDesc('id')->first();
            }
        }

        if (!$guest) {
            return response()->json(['found' => false, 'message' => 'Booking ID atau Guest Code tidak ditemukan.']);
        }

        if ($guest->checkout_charges !== null) {
            return response()->json(['found' => false, 'message' => 'Tamu ini sudah checkout.']);
        }

        return response()->json([
            'found' => true,
            'guest' => [
                // Data ringkas untuk checkout
                'name'            => $guest->first_name . ' ' . $guest->last_name,
                'country'         => $guest->country,
                'total_price'     => (int) ($booking?->total_price ?? 0),
                'guest_code'      => $guest->guest_code,
                'booking_code'    => $booking?->booking_code ?? '-',

                // Data lengkap untuk prefill form check-in
                'first_name'      => $guest->first_name,
                'last_name'       => $guest->last_name,
                'email'           => $guest->email,
                'phone'           => $guest->phone,
                'age'             => $guest->age,
                'occupation'      => $guest->occupation,
                'city'            => $guest->city,
                'self_description'=> $guest->self_description,
                'personal_notes'  => $guest->personal_notes,
                'id_number'       => $guest->id_number,
                'address'         => $guest->address ?? '',
                'deposit_amount'  => $guest->deposit_amount ?? 0,
                'deposit_notes'   => $guest->deposit_notes ?? '',
                'profile_picture' => $guest->profile_picture ? asset('storage/' . $guest->profile_picture) : null,
                'id_card_photo'   => $guest->id_card_photo ? asset('storage/' . $guest->id_card_photo) : null,

                // Status check-in
                'already_checked_in' => $booking ? ((int) $booking->checkin_status === 1) : !is_null($guest->check_in_date),
                'check_in_date'   => $booking && $booking->actual_check_in 
                                        ? Carbon::parse($booking->actual_check_in)->format('d M Y') 
                                        : ($guest->check_in_date ? $guest->check_in_date->format('d M Y') : null),
            ]
        ]);
    }

    public function searchDynamic(Request $request)
    {
        $keyword = $request->query('keyword');
        $actionType = $request->query('action_type', 'checkin');

        $query = Booking::with('guest');

        if ($actionType === 'checkin') {
            $query->where('checkin_status', '!=', 1);
        } elseif ($actionType === 'checkout') {
            $query->where('checkin_status', 1)->where('checkout_status', 0);
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('booking_code', 'LIKE', '%' . $keyword . '%')
                  ->orWhereHas('guest', function ($q2) use ($keyword) {
                      $q2->where('first_name', 'LIKE', '%' . $keyword . '%')
                         ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
                         ->orWhere('guest_code', 'LIKE', '%' . $keyword . '%');
                  });
            });
        }

        $bookings = $query->orderByDesc('id')
            ->limit(20)
            ->get()
            ->map(function ($b) {
                $g = $b->guest;
                $name = $g ? ($g->first_name . ' ' . $g->last_name) : 'Unknown';
                $ciDate = $b->check_in_date ? Carbon::parse($b->check_in_date)->format('d M Y') : '-';
                $coDate = $b->check_out_date ? Carbon::parse($b->check_out_date)->format('d M Y') : '-';
                return [
                    'booking_code' => $b->booking_code,
                    'guest_code'   => $g->guest_code ?? '-',
                    'label'        => $b->booking_code . ' - ' . $name . ' (' . $ciDate . ' s/d ' . $coDate . ')',
                ];
            });

        return response()->json($bookings);
    }

    public function checkin(Request $request)
    {
        if ($request->has('deposit_amount')) {
            $cleaned = preg_replace('/[^\d]/', '', $request->input('deposit_amount'));
            $request->merge(['deposit_amount' => $cleaned !== '' ? (float) $cleaned : null]);
        }

        $validator = Validator::make($request->all(), [
            'booking_code'     => ['required', 'string'],
            'first_name'       => ['required', 'string', 'max:255'],
            'last_name'        => ['nullable', 'string', 'max:255'],
            'email'            => ['nullable', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:50'],
            'age'              => ['nullable', 'integer', 'min:0'],
            'occupation'       => ['nullable', 'string', 'max:255'],
            'country'          => ['nullable', 'string', 'max:255'],
            'city'             => ['nullable', 'string', 'max:255'],
            'self_description' => ['nullable', 'string'],
            'personal_notes'   => ['nullable', 'string'],
            'id_number'        => ['nullable', 'string', 'max:255'],
            'address'          => ['nullable', 'string', 'max:255'],
            'deposit_amount'   => ['nullable', 'numeric', 'min:0'],
            'deposit_notes'    => ['nullable', 'string'],
            'profile_picture'  => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'card_photo'       => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $bookingCode = $request->input('booking_code');
        $booking = Booking::where('booking_code', $bookingCode)->first();
        if ($booking) {
            $guest = $booking->guest;
        } else {
            $guest = Guest::where('guest_code', $bookingCode)->first();
            if ($guest) {
                $booking = $guest->bookings()->orderByDesc('id')->first();
            }
        }

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ID atau Guest Code tidak ditemukan.'
            ], 422);
        }

        // Update file uploads jika diunggah saat check-in
        $profilePicturePath = $guest->profile_picture;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('guests/profiles', 'public');
        }

        $idCardPhotoPath = $guest->id_card_photo;
        if ($request->hasFile('card_photo')) {
            $idCardPhotoPath = $request->file('id_card_photo')->store('guests/id_cards', 'public');
        }

        $guest->update([
            'first_name'       => $request->input('first_name'),
            'last_name'        => $request->input('last_name'),
            'email'            => $request->input('email'),
            'phone'            => $request->input('phone'),
            'age'              => $request->input('age'),
            'occupation'       => $request->input('occupation'),
            'country'          => $request->input('country'),
            'city'             => $request->input('city'),
            'self_description' => $request->input('self_description'),
            'personal_notes'   => $request->input('personal_notes'),
            'id_number'        => $request->input('id_number'),
            'address'          => $request->input('address'),
            'deposit_amount'   => $request->input('deposit_amount') ?? 0,
            'deposit_notes'    => $request->input('deposit_notes'),
            'profile_picture'  => $profilePicturePath,
            'id_card_photo'    => $idCardPhotoPath,
            'check_in_date'    => Carbon::today(), // Set check_in_date hari ini saat check-in
        ]);
        if ($booking) {
            $booking->update([
                'checkin_status' => 1,
                'actual_check_in' => Carbon::now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Guest ' . $guest->first_name . ' ' . $guest->last_name . ' berhasil check-in.',
        ]);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_code'     => ['required', 'string'],
            'status'           => ['required', 'in:safe,blacklist'],
            'extra_charges'    => ['nullable', 'array'],
            'checkout_notes'   => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari booking, lalu guest-nya
        $bookingCode = $request->input('booking_code');
        $booking = Booking::where('booking_code', $bookingCode)->first();
        if ($booking) {
            $guest = $booking->guest;
        } else {
            $guest = Guest::where('guest_code', $bookingCode)->first();
            if ($guest) {
                $booking = $guest->bookings()->orderByDesc('id')->first();
            }
        }

        if (!$guest || !$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan.'
            ], 422);
        }

        if ((int) $booking->checkout_status === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ini sudah checkout.'
            ], 422);
        }

        // Hitung durasi
        $duration = 0;
        if ($guest->check_in_date) {
            $duration = (int) Carbon::today()->diffInDays($guest->check_in_date);
        }

        // 1. Update BOOKING: checkout status, waktu, extra charges
        $booking->update([
            'checkout_status'  => 1,
            'actual_check_out' => Carbon::now(),
            'extra_charges'    => $request->input('extra_charges') ?? [],
        ]);

        // 2. Update GUEST: reset deposit, kosongkan notes, set check_out_date & status
        $guest->update([
            'check_out_date'   => Carbon::today(),
            'status'           => $request->input('status') === 'blacklist' ? 'block' : 'save',
            'checkout_notes'   => $request->input('checkout_notes'),
            'duration'         => $duration,
            'deposit_amount'   => 0,
            'deposit_notes'    => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guest ' . $guest->first_name . ' ' . $guest->last_name . ' berhasil checkout.',
        ]);
    }

    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);

        // Hapus semua booking yang terkait dengan guest ini
        $guest->bookings()->delete();

        // Hapus file foto jika ada
        if ($guest->profile_picture) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($guest->profile_picture);
        }
        if ($guest->id_card_photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($guest->id_card_photo);
        }

        $guestName = $guest->first_name . ' ' . $guest->last_name;
        $guest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Guest ' . $guestName . ' dan semua booking terkait berhasil dihapus.',
        ]);
    }

    // ---------------------------------------------------------------
    // Helper
    // ---------------------------------------------------------------

    private function getBreakdown($guests): array
    {
        $total = $guests->count();

        $localCountries = ['indonesia'];

        $asiaCountries   = ['malaysia', 'singapore', 'thailand', 'philippines', 'vietnam',
                            'myanmar', 'cambodia', 'laos', 'brunei', 'timor-leste',
                            'china', 'japan', 'south korea', 'india', 'bangladesh',
                            'pakistan', 'sri lanka', 'nepal', 'bhutan', 'maldives',
                            'mongolia', 'taiwan', 'hong kong', 'macau'];
        $usEuOcCountries = ['united states', 'usa', 'canada', 'united kingdom', 'germany',
                            'france', 'italy', 'spain', 'netherlands', 'belgium',
                            'switzerland', 'austria', 'sweden', 'norway', 'denmark',
                            'finland', 'portugal', 'greece', 'poland', 'australia',
                            'new zealand', 'ireland', 'czech republic', 'hungary',
                            'romania', 'slovakia', 'croatia', 'ukraine', 'russia'];
        $afCountries     = ['nigeria', 'south africa', 'kenya', 'ghana', 'ethiopia',
                            'tanzania', 'uganda', 'mozambique', 'zambia', 'zimbabwe',
                            'senegal', 'cameroon', 'egypt', 'morocco', 'tunisia',
                            'algeria', 'angola', 'ivory coast', 'rwanda', 'mali'];

        $localCount   = 0;
        $foreignCount = 0;
        $asiaCount    = 0;
        $usEuOcCount  = 0;
        $afCount      = 0;
        $otherForeign = 0;

        foreach ($guests as $g) {
            $c = strtolower(trim($g->country ?? ''));
            if (in_array($c, $localCountries)) {
                $localCount++;
            } else {
                $foreignCount++;
                if (in_array($c, $asiaCountries)) {
                    $asiaCount++;
                } elseif (in_array($c, $usEuOcCountries)) {
                    $usEuOcCount++;
                } elseif (in_array($c, $afCountries)) {
                    $afCount++;
                } else {
                    $otherForeign++;
                }
            }
        }

        $pct = fn ($n) => $total > 0 ? round($n / $total * 100, 1) : 0.0;

        return [
            'total'        => $total,
            'local'        => $localCount,
            'local_pct'    => $pct($localCount),
            'foreign'      => $foreignCount,
            'foreign_pct'  => $pct($foreignCount),
            'asia'         => $asiaCount,
            'asia_pct'     => $pct($asiaCount),
            'us_eu_oc'     => $usEuOcCount,
            'us_eu_oc_pct' => $pct($usEuOcCount),
            'af'           => $afCount,
            'af_pct'       => $pct($afCount),
            'other'        => $otherForeign,
            'other_pct'    => $pct($otherForeign),
        ];
    }

}