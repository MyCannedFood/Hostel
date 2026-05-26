<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Support\Carbon;

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
            $bookingStats['revenue']['labels'][] = 'Week ' . $weekStart->format('W');
            $bookingStats['revenue']['data'][]   = 0;
        }

        return view('admin.dashboard', compact('guestStats', 'bookingStats'));
    }
}