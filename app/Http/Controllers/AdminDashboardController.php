<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Bed;
use App\Models\Booking;
use App\Models\GeneralLedger;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $now   = Carbon::now();
        $today = Carbon::today();

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

        $bookingStats = [
            'day'     => ['labels' => [], 'data' => []],
            'week'    => ['labels' => [], 'data' => []],
            'month'   => ['labels' => [], 'data' => []],
            'revenue' => ['labels' => [], 'data' => []],
        ];

        $totalRevenue = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->sum('amount');

        $revenueThisWeek = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->whereBetween('paid_at', [
                $now->copy()->startOfWeek(Carbon::MONDAY),
                $now->copy()->endOfWeek(Carbon::SUNDAY),
            ])
            ->sum('amount');

        $revenueThisMonth = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->whereBetween('paid_at', [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth(),
            ])
            ->sum('amount');

        $revenueLastMonth = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->whereBetween('paid_at', [
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth(),
            ])
            ->sum('amount');

        $revenueGrowth = $revenueLastMonth > 0
            ? round(($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth * 100)
            : 0;

        $totalBeds = Bed::count();

        $activeGuestIds = Guest::whereNull('check_out_date')->pluck('id');
        $activeBookings = Booking::with('guest')->whereIn('guest_id', $activeGuestIds)
            ->whereIn('status', ['CONFIRMED', 'PENDING'])
            ->get();
        $occupiedBedIds = $activeBookings->pluck('bed_id')->filter()->unique();

        $occupancyToday = $totalBeds > 0 ? round($occupiedBedIds->count() / $totalBeds * 100) : 0;

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

        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $bookingStats['day']['labels'][] = $day->format('D');
            $bookingStats['day']['data'][]   = Guest::whereDate('check_in_date', $day)->count();
        }

        for ($i = 3; $i >= 0; $i--) {
            $weekStart = $now->copy()->subWeeks($i)->startOfWeek(Carbon::MONDAY);
            $weekEnd   = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);
            $bookingStats['week']['labels'][] = 'Week ' . $weekStart->format('W');
            $bookingStats['week']['data'][]   = Guest::whereBetween('check_in_date', [$weekStart, $weekEnd])->count();
        }

        for ($i = 3; $i >= 0; $i--) {
            $weekStart = $now->copy()->subWeeks($i)->startOfWeek(Carbon::MONDAY);
            $weekEnd   = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);
            $bookingStats['revenue']['labels'][] = 'Week ' . $weekStart->format('W');
            $bookingStats['revenue']['data'][]   = (int) DB::table('payments')
                ->where('status', 'settlement')
                ->whereBetween('paid_at', [$weekStart, $weekEnd])
                ->sum('amount');
        }

        return view('admin.dashboard', compact(
            'guestStats', 'bookingStats',
            'totalRevenue', 'revenueThisWeek', 'revenueThisMonth', 'revenueGrowth',
            'occupancyToday', 'occupancyWeek', 'occupancyMonth'
        ));
    }
}