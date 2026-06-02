<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AdminGuestController extends Controller
{
    public function index()
    {
        $guests = Guest::query()
            ->orderByDesc('id')
            ->get(['id', 'booking_code', 'first_name', 'last_name', 'country',
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

        return view('admin.manage_guests', compact(
            'guests',
            'guestStats',
            'trendLabels',
            'trendData'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'country'      => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $bookingCode = $this->generateBookingCode();

        Guest::create([
            'booking_code'   => $bookingCode,
            'status'         => 'save',
            'first_name'     => $request->input('first_name'),
            'last_name'      => $request->input('last_name'),
            'country'        => $request->input('country'),
            'check_in_date'  => Carbon::today(), // ← otomatis hari ini
            'check_out_date' => null,             // ← diisi nanti saat checkout
        ]);

        return redirect()->route('admin.manage_guests')
            ->with('success', 'Guest added successfully.');
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_code' => ['required', 'string', 'exists:guests,booking_code'],
            'status'       => ['required', 'in:safe,blacklist'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $guest = Guest::where('booking_code', $request->input('booking_code'))->firstOrFail();

        if ($guest->check_out_date) {
            return back()->withErrors(['booking_code' => 'Tamu ini sudah checkout.']);
        }

        $guest->update([
            'check_out_date' => Carbon::today(),
            'status'         => $request->input('status') === 'blacklist' ? 'block' : 'save',
        ]);

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