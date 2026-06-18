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

        // ── Revenue / Cash In (samakan dengan finance-accounting: general_ledger type=In) ──
        $totalRevenue = (int) GeneralLedger::where('type', 'In')->sum('amount');

        $revenueThisWeek = (int) GeneralLedger::where('type', 'In')
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->sum('amount');

        $revenueThisMonth = (int) GeneralLedger::where('type', 'In')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('amount');

        $revenueLastMonth = (int) GeneralLedger::where('type', 'In')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
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

        // ── Revenue Statistics (cash in) 7 hari terakhir: general_ledger type=In ──
        $revenueLabels = [];
        $revenueData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $revenueLabels[] = $day->format('D'); // Mon, Tue, ...
            $revenueData[] = (int) DB::table('general_ledger')
                ->where('type', 'In')
                ->whereDate('created_at', $day)
                ->sum('amount');
        }

        $revenueMax = max($revenueData) ?: 1;

        // ── Financial Trend (weekly): cash in vs cash out dari general_ledger ──
        $trendLabels  = [];
        $trendCashIn  = [];
        $trendCashOut = [];

        for ($i = 3; $i >= 0; $i--) {
            $weekStart = $now->copy()->subWeeks($i)->startOfWeek(Carbon::MONDAY);
            $weekEnd   = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);

            $trendLabels[] = 'Week ' . $weekStart->format('W');

            $weekCashIn = DB::table('general_ledger')
                ->where('type', 'In')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            $weekCashOut = DB::table('general_ledger')
                ->where('type', 'Out')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            $trendCashIn[]  = (int) $weekCashIn;
            $trendCashOut[] = (int) $weekCashOut;
        }


        // ── Growth metrics (samakan dengan cash-in dari general_ledger) ──
        $lastWeekRevenue = (int) DB::table('general_ledger')
            ->where('type', 'In')
            ->whereBetween('created_at', [
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
        // Ambil data lebih banyak supaya pagination JS tidak “menghilangkan” entri ke-11 dst.
        $pageSize = 5;
        $maxPagesForTable = 5; // tampilkan sampai ~25 baris kandidat
        $transactionsLimit = $pageSize * $maxPagesForTable;

        $transactions = GeneralLedger::orderByDesc('created_at')
            ->limit($transactionsLimit)
            ->get()
            ->map(fn ($item) => [
                'id'          => $item->trans_code,
                'date'        => $item->created_at?->format('d-m-y') ?? null,
                'description' => $item->description,
                'category'    => $item->category,
                'type'        => $item->type === 'In' ? 'In' : 'Out',
                'amount'      => (int) $item->amount,
            ]);




        // Alias supaya manage_revenue bisa disamakan dengan finance-accounting
        $totalCashIn  = $totalRevenue;
        $totalCashOut = $totalExpenses;

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

            // chart trend (Chart.js)
            'trendLabels',
            'trendCashIn',
            'trendCashOut',

            'dailyGrowth',
            'weeklyGrowth',
            'growthPercent',
            'transactions',


            // finance-accounting aliases
            'totalCashIn',
            'totalCashOut',

        ));
    }
}
