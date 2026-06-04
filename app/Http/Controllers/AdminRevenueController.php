<?php

namespace App\Http\Controllers;

use App\Models\GeneralLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminRevenueController extends Controller
{
    public function index()
    {
        $now   = Carbon::now();
        $today = Carbon::today();

        $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd   = $now->copy()->endOfWeek(Carbon::SUNDAY);

        $monthStart = $now->copy()->startOfMonth();
        $monthEnd   = $now->copy()->endOfMonth();

        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd   = $now->copy()->subMonth()->endOfMonth();

        // ── Revenue ──
        $totalRevenue = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->sum('amount');

        $revenueThisWeek = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->whereBetween('paid_at', [$weekStart, $weekEnd])
            ->sum('amount');

        $revenueThisMonth = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->sum('amount');

        $revenueLastMonth = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->whereBetween('paid_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');

        $growthPercent = $revenueLastMonth > 0
            ? round(($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth * 100, 1)
            : 0;

        // ── Expenses ──
        $totalExpenses = (int) GeneralLedger::where('type', 'Out')->sum('amount');

        $expensesOperational = (int) GeneralLedger::where('type', 'Out')
            ->where('category', 'Operational')
            ->sum('amount');

        $expensesMaintenance = (int) GeneralLedger::where('type', 'Out')
            ->where('category', 'Maintenance')
            ->sum('amount');

        if ($expensesOperational === 0 && $expensesMaintenance === 0 && $totalExpenses > 0) {
            $expensesOperational = (int) ($totalExpenses * 0.8);
            $expensesMaintenance = $totalExpenses - $expensesOperational;
        }

        $expenseRatio = $totalRevenue > 0 ? round($totalExpenses / $totalRevenue * 100) : 0;

        // ── Net Profit ──
        $netProfit    = $totalRevenue - $totalExpenses;
        $profitMargin = $totalRevenue > 0 ? round($netProfit / $totalRevenue * 100) : 0;

        // ── 7-day revenue bar chart ──
        $revenueLabels = [];
        $revenueData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $revenueLabels[] = $day->format('D');
            $revenueData[]   = (int) DB::table('payments')
                ->where('status', 'settlement')
                ->whereDate('paid_at', $day)
                ->sum('amount');
        }
        $revenueMax = max($revenueData) ?: 1;

        // ── Weekly trend ──
        $trendRevenue = $revenueData;
        $avgRevenue   = array_sum($trendRevenue) / max(count($trendRevenue), 1);
        $trendTarget  = array_map(fn ($v) => max($v, (int) ($avgRevenue * 1.1)), $trendRevenue);
        $trendMax     = max(max($trendRevenue), max($trendTarget)) ?: 1;

        // Generate SVG paths for trend chart
        $count       = count($trendRevenue);
        $svgWidth    = 400;
        $svgHeight   = 160;
        $padding     = 20;
        $chartWidth  = $svgWidth - 2 * $padding;
        $chartHeight = $svgHeight - 2 * $padding;
        $maxIdx      = max($count - 1, 1);

        $targetPts = [];
        $revenuePts = [];
        foreach ($trendTarget as $i => $val) {
            $x = $padding + ($i / $maxIdx) * $chartWidth;
            $y = $svgHeight - $padding - ($val / $trendMax) * $chartHeight;
            $targetPts[] = round($x, 1) . ',' . round($y, 1);
        }
        foreach ($trendRevenue as $i => $val) {
            $x = $padding + ($i / $maxIdx) * $chartWidth;
            $y = $svgHeight - $padding - ($val / $trendMax) * $chartHeight;
            $revenuePts[] = round($x, 1) . ',' . round($y, 1);
        }

        $pathTarget = '';
        foreach ($targetPts as $i => $pt) {
            $pathTarget .= ($i === 0 ? 'M' : 'L') . $pt;
        }
        $pathRevenue = '';
        foreach ($revenuePts as $i => $pt) {
            $pathRevenue .= ($i === 0 ? 'M' : 'L') . $pt;
        }

        $lastTarget = end($targetPts);
        $firstTarget = reset($targetPts);
        $pathTargetArea = $pathTarget . 'L' . $lastTarget . ',' . $svgHeight . 'L' . $firstTarget . ',' . $svgHeight . 'Z';

        $lastRevenue = end($revenuePts);
        $firstRevenue = reset($revenuePts);
        $pathRevenueArea = $pathRevenue . 'L' . $lastRevenue . ',' . $svgHeight . 'L' . $firstRevenue . ',' . $svgHeight . 'Z';

        // ── Growth metrics ──
        $lastWeekRevenue = (int) DB::table('payments')
            ->where('status', 'settlement')
            ->whereBetween('paid_at', [
                $weekStart->copy()->subWeek(),
                $weekEnd->copy()->subWeek(),
            ])
            ->sum('amount');

        $dailyGrowth = $revenueThisWeek > 0 && $lastWeekRevenue > 0
            ? round(($revenueThisWeek / 7 - $lastWeekRevenue / 7) / ($lastWeekRevenue / 7) * 100, 1)
            : 0;

        $weeklyGrowth = $revenueLastMonth > 0
            ? round(($revenueThisMonth / 4 - $revenueLastMonth / 4) / ($revenueLastMonth / 4) * 100, 1)
            : 0;

        // ── Recent transactions ──
        $transactions = GeneralLedger::orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(fn ($item) => [
                'id'          => $item->trans_code,
                'description' => $item->description,
                'category'    => $item->category,
                'type'        => $item->type === 'In' ? 'Income' : 'Expense',
                'amount'      => (int) $item->amount,
            ]);

        if ($transactions->isEmpty()) {
            $transactions = DB::table('payments')
                ->where('status', 'settlement')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get()
                ->map(fn ($item) => [
                    'id'          => 'PAY-' . $item->id,
                    'description' => 'Payment for Booking #' . $item->booking_id,
                    'category'    => 'Accommodation',
                    'type'        => 'Income',
                    'amount'      => (int) $item->amount,
                ]);
        }

        return view('admin.manage_revenue', compact(
            'totalRevenue',
            'revenueThisWeek',
            'revenueThisMonth',
            'revenueLastMonth',
            'growthPercent',
            'totalExpenses',
            'expensesOperational',
            'expensesMaintenance',
            'expenseRatio',
            'netProfit',
            'profitMargin',
            'revenueLabels',
            'revenueData',
            'revenueMax',
            'pathTarget',
            'pathRevenue',
            'pathTargetArea',
            'pathRevenueArea',
            'dailyGrowth',
            'weeklyGrowth',
            'growthPercent',
            'transactions',
        ));
    }
}
