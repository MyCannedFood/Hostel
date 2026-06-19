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
        $guests = Guest::query()
            ->orderByDesc('id')
            ->paginate(10, ['id', 'booking_code', 'first_name', 'last_name', 'country',
                   'gender', 'age', 'booking_place', 'status',
                   'check_in_date', 'check_out_date']);

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

        return view('admin.manage_guests', compact(
            'guests',
            'guestStats',
            'trendLabels',
            'trendData',
            'roomsWithGuests'
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

        // 3. Ambil booking_code dari request form JS, atau generate baru kalau kosong
        $bookingCode = $request->input('booking_code') ?? $this->generateBookingCode();

        // 4. Simpan semua data ke database tabel 'guests'
        Guest::create([
            'booking_code'     => $bookingCode,
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

    public function search($bookingCode)
    {
        $guest = Guest::where('booking_code', $bookingCode)->first();

        if (!$guest) {
            return response()->json(['found' => false, 'message' => 'Booking ID tidak ditemukan.']);
        }

        if ($guest->checkout_charges !== null) {
            return response()->json(['found' => false, 'message' => 'Tamu ini sudah checkout.']);
        }

        $booking = $guest->bookings()->orderByDesc('id')->first();

        return response()->json([
            'found' => true,
            'guest' => [
                // Data ringkas untuk checkout
                'name'            => $guest->first_name . ' ' . $guest->last_name,
                'country'         => $guest->country,
                'total_price'     => (int) ($booking?->total_price ?? 0),

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
                'already_checked_in' => !is_null($guest->check_in_date),
                'check_in_date'   => $guest->check_in_date?->format('d M Y'),
            ]
        ]);
    }

    public function checkin(Request $request)
    {
        if ($request->has('deposit_amount')) {
            $cleaned = preg_replace('/[^\d]/', '', $request->input('deposit_amount'));
            $request->merge(['deposit_amount' => $cleaned !== '' ? (float) $cleaned : null]);
        }

        $validator = Validator::make($request->all(), [
            'booking_code'     => ['required', 'string', 'exists:guests,booking_code'],
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

        $guest = Guest::where('booking_code', $request->input('booking_code'))->firstOrFail();

        // Update file uploads jika diunggah saat check-in
        $profilePicturePath = $guest->profile_picture;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('guests/profiles', 'public');
        }

        $idCardPhotoPath = $guest->id_card_photo;
        if ($request->hasFile('card_photo')) {
            $idCardPhotoPath = $request->file('card_photo')->store('guests/id_cards', 'public');
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

        return response()->json([
            'success' => true,
            'message' => 'Guest ' . $guest->first_name . ' ' . $guest->last_name . ' berhasil check-in.',
        ]);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_code'     => ['required', 'string', 'exists:guests,booking_code'],
            'status'           => ['required', 'in:safe,blacklist'],
            'checkout_charges' => ['nullable', 'array'],
            'checkout_notes'   => ['nullable', 'string'],
            'duration'         => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $guest = Guest::where('booking_code', $request->input('booking_code'))->firstOrFail();

        if ($guest->checkout_charges !== null) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tamu ini sudah checkout.'
                ], 422);
            }
            return back()->withErrors(['booking_code' => 'Tamu ini sudah checkout.']);
        }

        // Hitung durasi jika tidak dikirim
        $duration = $request->input('duration');
        if (!$duration && $guest->check_in_date) {
            $duration = (int) Carbon::today()->diffInDays($guest->check_in_date);
        }

        $guest->update([
            'check_out_date'   => Carbon::today(),
            'status'           => $request->input('status') === 'blacklist' ? 'block' : 'save',
            'checkout_charges' => $request->input('checkout_charges') ?? [],
            'checkout_notes'   => $request->input('checkout_notes'),
            'duration'         => $duration,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Guest ' . $guest->first_name . ' ' . $guest->last_name . ' berhasil checkout.',
            ]);
        }

        return redirect()->route('admin.manage_guests')
            ->with('success', 'Guest ' . $guest->first_name . ' ' . $guest->last_name . ' berhasil checkout.');
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

    private function generateBookingCode(): string
    {
        $prefix = 'BK-' . Carbon::now()->format('Y') . '-';
        $lastBookingCode = Guest::where('booking_code', 'like', $prefix . '%')
            ->orderByDesc('booking_code')
            ->value('booking_code');

        $nextNumber = 1001;

        if ($lastBookingCode) {
            $suffix = (int) substr($lastBookingCode, -4);
            if ($suffix >= 1001) {
                $nextNumber = $suffix + 1;
            }
        }

        do {
            $bookingCode = $prefix . $nextNumber;
            $nextNumber++;
        } while (Guest::where('booking_code', $bookingCode)->exists());

        return $bookingCode;
    }
}