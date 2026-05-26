<?php

namespace App\Http\Controllers;

use App\Models\BudgetRequest;
use App\Models\LjpReport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminBudgetingController extends Controller
{
    public function index()
    {
        return view('admin.budgeting');
    }

    public function requests(Request $request): JsonResponse
    {
        // Mode 1: detail by id (dipakai JS untuk modal LPJ)
        if ($request->filled('id')) {
            $id = $request->integer('id');

            $budget = BudgetRequest::with(['items'])
                ->where('id', $id)
                ->first();

            if (!$budget) {
                return response()->json([
                    'data' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page'    => 1,
                        'per_page'     => 1,
                        'total'        => 0,
                    ],
                ], 404);
            }

            return response()->json([
                'data' => [$budget],
                'pagination' => [
                    'current_page' => 1,
                    'last_page'    => 1,
                    'per_page'     => 1,
                    'total'        => 1,
                ],
            ]);
        }

        // Mode 2: list/search/pagination
        $query = BudgetRequest::query();

        if ($request->filled('q_title')) {
            $q = $request->string('q_title')->toString();
            $query->where('title', 'like', '%' . $q . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }
        if ($request->filled('category')) {
            $query->where('category', $request->string('category')->toString());
        }

        $perPage   = (int) $request->input('per_page', 10);
        $perPage   = max(1, min(50, $perPage));
        $paginator = $query->orderByDesc('created_at')->paginate($perPage);

        return response()->json([
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ]);
    }

    public function stats(): JsonResponse
    {
        // Ambil semua approved requests sekali
        $approvedRequests = BudgetRequest::where('status', 'Approved')->get();

        $approvedBudget = (int) $approvedRequests->sum('estimated_total_amount');

        // Total actual spent dari LPJ yang submitted/approved
        $totalSpent = (int) $approvedRequests->sum(function (BudgetRequest $r) {
            return (int) $r->lpjReports()
                ->whereIn('status', ['Submitted', 'Approved'])
                ->sum('total_actual_amount');
        });

        $spentPct     = $approvedBudget > 0 ? (int) round(($totalSpent / $approvedBudget) * 100) : 0;
        $remaining    = max(0, $approvedBudget - $totalSpent);
        $remainingPct = $approvedBudget > 0 ? (int) round(($remaining / $approvedBudget) * 100) : 0;

        $dist = BudgetRequest::where('status', 'Approved')
            ->select('category', DB::raw('SUM(estimated_total_amount) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $totalDist    = (int) $dist->sum('total');
        $distribution = $dist->map(function ($row) use ($totalDist) {
            $pct = $totalDist > 0 ? round(((int) $row->total / $totalDist) * 100) : 0;
            return ['label' => $row->category, 'pct' => $pct];
        })->values();

        $top = BudgetRequest::where('status', 'Approved')
            ->select('requested_by', DB::raw('COUNT(*) as cnt'))
            ->groupBy('requested_by')
            ->orderByDesc('cnt')
            ->limit(4)
            ->get();

        return response()->json([
            'stats' => [
                'approved_budget'   => $approvedBudget,
                'total_spent'       => $totalSpent,
                'spent_pct'         => $spentPct,
                'remaining_balance' => $remaining,
                'remaining_pct'     => $remainingPct,
                'total_savings'     => $remaining,
            ],
            'distribution' => $distribution,
            'requestors'   => $top->map(function ($row) {
                $name     = $row->requested_by ?: 'Unknown';
                $initials = collect(explode(' ', $name))
                    ->filter()
                    ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
                    ->take(2)
                    ->implode('');
                return [
                    'initials' => $initials ?: '??',
                    'name'     => $name,
                    'role'     => '—',
                    'count'    => (int) $row->cnt,
                ];
            })->values(),
        ]);
    }
}