<?php

namespace App\Http\Controllers;

use App\Models\BudgetRequest;
use App\Models\GeneralLedger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminFinanceController extends Controller
{
    public function index()
    {
        $now   = Carbon::now();
        $today = Carbon::today();

        // Pending approvals
        $pendingRequests = BudgetRequest::where('status', 'Pending')
            ->with('items')
            ->orderByDesc('created_at')
            ->get();

        // Approved & Rejected requests
        $approvedRequests = BudgetRequest::where('status', 'Approved')
            ->orderByDesc('approved_at')->get();
        $rejectedRequests = BudgetRequest::where('status', 'Rejected')
            ->orderByDesc('rejected_at')->get();

        // General Ledger
        $ledgerEntries = GeneralLedger::orderByDesc('created_at')->get();

        // KPI
        $totalCashIn  = (int) $ledgerEntries->where('type', 'In')->sum('amount');
        $totalCashOut = (int) $ledgerEntries->where('type', 'Out')->sum('amount');
        $netProfit    = $totalCashIn - $totalCashOut;

        // ── Revenue Statistics: paid_at per hari 7 hari terakhir ──
        $revenueLabels = [];
        $revenueData   = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $revenueLabels[] = $day->format('D'); // Mon, Tue, ...

            $dayTotal = DB::table('payments')
                ->where('status', 'settlement')
                ->whereDate('paid_at', $day)
                ->sum('amount');

            $revenueData[] = (int) $dayTotal;
        }

        // ── Financial Trend: Cash In vs Cash Out per minggu (4 minggu) ──
        $trendLabels  = [];
        $trendCashIn  = [];
        $trendCashOut = [];

        for ($i = 3; $i >= 0; $i--) {
            $weekStart = $now->copy()->subWeeks($i)->startOfWeek(Carbon::MONDAY);
            $weekEnd   = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);

            $trendLabels[] = 'Week ' . $weekStart->format('W');

            // Cash In minggu ini dari payments
            $weekCashIn = DB::table('payments')
                ->where('status', 'settlement')
                ->whereBetween('paid_at', [$weekStart, $weekEnd])
                ->sum('amount');

            // Cash Out minggu ini dari general_ledger
            $weekCashOut = DB::table('general_ledger')
                ->where('type', 'Out')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            $trendCashIn[]  = (int) $weekCashIn;
            $trendCashOut[] = (int) $weekCashOut;
        }

        return view('admin.finance-accounting', compact(
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'ledgerEntries',
            'totalCashIn',
            'totalCashOut',
            'netProfit',
            'revenueLabels',
            'revenueData',
            'trendLabels',
            'trendCashIn',
            'trendCashOut'
        ));
    }

    public function approveReject(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id'     => 'required|integer|exists:budget_requests,id',
            'action' => 'required|in:approve,reject',
            'notes'  => 'nullable|string|max:500',
        ]);

        $budget = BudgetRequest::findOrFail($validated['id']);

        if ($validated['action'] === 'approve') {
            $budget->status      = 'Approved';
            $budget->approved_at = now();
        } else {
            $budget->status           = 'Rejected';
            $budget->rejected_at      = now();
            $budget->rejection_reason = $validated['notes'] ?? '';
        }

        $budget->save();

        return response()->json([
            'success' => true,
            'message' => $validated['action'] === 'approve' ? 'Budget approved' : 'Budget rejected',
            'data'    => $budget,
        ]);
    }
}