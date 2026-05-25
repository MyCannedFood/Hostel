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
            ->get(['id', 'booking_code', 'first_name', 'last_name', 'country']);

        // --- Stats ---
        $now   = Carbon::now();
        $today = Carbon::today();

        $guestStats = [
            'today' => Guest::whereDate('created_at', $today)->count(),
            'week'  => Guest::whereBetween('created_at', [
                $now->copy()->startOfWeek(Carbon::MONDAY),
                $now->copy()->endOfWeek(Carbon::SUNDAY),
            ])->count(),
            'month' => Guest::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count(),
        ];

        // --- Breakdown per period (Foreigner vs Local) ---
        // "Local" = Indonesia, "Foreigner" = everything else
        // Today
        $guestStats['today_breakdown'] = $this->getBreakdown(
            Guest::whereDate('created_at', $today)->get(['country'])
        );

        // This week
        $guestStats['week_breakdown'] = $this->getBreakdown(
            Guest::whereBetween('created_at', [
                $now->copy()->startOfWeek(Carbon::MONDAY),
                $now->copy()->endOfWeek(Carbon::SUNDAY),
            ])->get(['country'])
        );

        // This month
        $guestStats['month_breakdown'] = $this->getBreakdown(
            Guest::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->get(['country'])
        );

        // --- Guest Trend (rolling 7 days) ---
        $trendLabels = [];
        $trendData   = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $trendLabels[] = $day->format('D'); // Mon, Tue, ...
            $trendData[]   = Guest::whereDate('created_at', $day)->count();
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
            'booking_code' => ['required', 'string', 'max:255', 'unique:guests,booking_code'],
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'country'      => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Guest::create([
            'booking_code' => $request->input('booking_code'),
            'first_name'   => $request->input('first_name'),
            'last_name'    => $request->input('last_name'),
            'country'      => $request->input('country'),
        ]);

        return redirect()->route('admin.manage_guests')
            ->with('success', 'Guest added successfully.');
    }

    // ---------------------------------------------------------------
    // Helper
    // ---------------------------------------------------------------

    /**
     * Given a collection of Guest rows (with 'country'),
     * returns an array with foreigner / local counts & percentages,
     * plus sub-region breakdown for foreigners.
     */
    private function getBreakdown($guests): array
    {
        $total = $guests->count();

        $localCountries = ['indonesia'];

        // Sub-regions for foreigners
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

        $localCount    = 0;
        $foreignCount  = 0;
        $asiaCount     = 0;
        $usEuOcCount   = 0;
        $afCount       = 0;
        $otherForeign  = 0;

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