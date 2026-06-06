<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Bed;
use Illuminate\Support\Carbon;

class AdminOccupationController extends Controller
{
    public function index()
    {
        $today     = Carbon::today();
        $now       = Carbon::now();

        $totalBeds = Bed::count();

        // --- Active guests (currently checked in) ---
        $activeGuestIds = Guest::whereNull('check_out_date')->pluck('id');
        $activeBookings = Booking::with('guest')->whereIn('guest_id', $activeGuestIds)
            ->whereIn('status', ['CONFIRMED', 'PENDING'])
            ->get();
        $occupiedBedIds = $activeBookings->pluck('bed_id')->filter()->unique();

        $occupiedToday  = $occupiedBedIds->count();
        $occupancyToday = $totalBeds > 0 ? round($occupiedToday / $totalBeds * 100) : 0;

        // --- This Week occupancy (average of daily occupancy) ---
        $weekDays = 0;
        $weekSum  = 0;
        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $dayBookings = Booking::whereIn('status', ['CONFIRMED', 'PENDING'])
                ->whereDate('check_in_date', '<=', $day)
                ->whereDate('check_out_date', '>=', $day)
                ->count();
            $weekSum  += $dayBookings;
            $weekDays++;
        }
        $occupancyWeek = $totalBeds > 0 ? round($weekSum / $weekDays / $totalBeds * 100) : 0;

        // --- This Month occupancy ---
        $daysInMonth = $now->daysInMonth;
        $monthSum    = 0;
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $day = Carbon::create($now->year, $now->month, $d);
            if ($day->gt($today)) break;
            $dayBookings = Booking::whereIn('status', ['CONFIRMED', 'PENDING'])
                ->whereDate('check_in_date', '<=', $day)
                ->whereDate('check_out_date', '>=', $day)
                ->count();
            $monthSum += $dayBookings;
        }
        $occupancyMonth = $totalBeds > 0 ? round($monthSum / max($d - 1, 1) / $totalBeds * 100) : 0;

        // --- Avg Stay ---
        $avgStay = Guest::whereNotNull('check_in_date')
            ->whereNotNull('check_out_date')
            ->get()
            ->avg(fn($g) => $g->check_in_date->diffInDays($g->check_out_date));
        $avgStay = $avgStay ? round($avgStay, 1) : 0;

        // --- Room occupation this month ---
        $rooms = Room::with('beds')->get()->map(function ($room) use ($today, $now, $activeGuestIds, $activeBookings) {
            $totalBedsInRoom = $room->beds->count();

            // Currently occupied beds in this room
            $roomBookings = $activeBookings->where('room_id', $room->id);
            $occupied     = $roomBookings->count();
            $pct          = $totalBedsInRoom > 0 ? round($occupied / $totalBedsInRoom * 100) : 0;

            // Booking place breakdown from active guests
            $guests            = $roomBookings->pluck('guest')->filter();
            $totalGuests       = $guests->count();
            $webCount          = $guests->where('booking_place', 'Website')->count();
            $appCount          = $guests->where('booking_place', 'App')->count();
            $walkinCount       = $guests->where('booking_place', 'Walk-in')->count();
            $webPct            = $totalGuests > 0 ? round($webCount / $totalGuests * 100) : 0;
            $appPct            = $totalGuests > 0 ? round($appCount / $totalGuests * 100) : 0;
            $walkinPct         = $totalGuests > 0 ? round($walkinCount / $totalGuests * 100) : 0;

            // Bars: occupied/available/warning (if occupancy < 50% show warning)
            $barClass = $pct >= 60 ? 'occupied' : ($pct >= 20 ? 'warning' : 'available');
            $bars     = collect();
            for ($i = 0; $i < $totalBedsInRoom; $i++) {
                $bars->push($i < $occupied ? $barClass : 'available');
            }

            return (object) [
                'name'        => $room->name,
                'pct'         => $pct,
                'bars'        => $bars,
                'web_pct'     => $webPct,
                'app_pct'     => $appPct,
                'walkin_pct'  => $walkinPct,
            ];
        });

        // --- Bed occupation today ---
        $upcomingBookings = Booking::with('guest')
            ->whereDate('check_in_date', '>', $today)
            ->where('status', 'CONFIRMED')
            ->get();

        $bedOccupation = Room::with('beds')->get()->map(function ($room) use ($activeBookings, $upcomingBookings, $today) {
            $bedsData = $room->beds->map(function ($bed) use ($activeBookings, $upcomingBookings, $today) {
                $activeBooking  = $activeBookings->where('bed_id', $bed->id)->first();
                $upcomingBooking = $upcomingBookings->where('bed_id', $bed->id)->first();

                if ($activeBooking) {
                    $guest = $activeBooking->guest;
                    return (object) [
                        'name'       => $bed->name,
                        'status'     => 'occupied',
                        'guest_name' => $guest ? $guest->first_name . ' ' . $guest->last_name : '',
                    ];
                }

                if ($upcomingBooking) {
                    $guest = $upcomingBooking->guest;
                    return (object) [
                        'name'       => $bed->name,
                        'status'     => 'upcoming',
                        'guest_name' => $guest ? $guest->first_name . ' ' . $guest->last_name : '',
                    ];
                }

                return (object) [
                    'name'       => $bed->name,
                    'status'     => 'empty',
                    'guest_name' => '',
                ];
            });

            // Divider color based on room index
            $colors = ['green', 'orange', 'teal'];
            $dividerColor = $colors[$room->id % count($colors)];

            return (object) [
                'name'          => $room->name,
                'beds'          => $bedsData,
                'divider_color' => $dividerColor,
            ];
        });

        return view('admin.manage_occupation', compact(
            'occupancyToday',
            'occupancyWeek',
            'occupancyMonth',
            'avgStay',
            'rooms',
            'bedOccupation',
        ));
    }
}
