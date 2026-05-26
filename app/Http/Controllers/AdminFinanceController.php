<?php

namespace App\Http\Controllers;

use App\Models\BudgetRequest;
use App\Models\GeneralLedger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminFinanceController extends Controller
{
    public function index()
    {
        // Pending approvals
        $pendingRequests = BudgetRequest::where('status', 'Pending')
            ->with('items')
            ->orderByDesc('created_at')
            ->get();

        // Approved requests
        $approvedRequests = BudgetRequest::where('status', 'Approved')
            ->orderByDesc('approved_at')
            ->get();

        // Rejected requests
        $rejectedRequests = BudgetRequest::where('status', 'Rejected')
            ->orderByDesc('rejected_at')
            ->get();

        // General Ledger
        $ledgerEntries = GeneralLedger::orderByDesc('created_at')
            ->get();

        return view('admin.finance-accounting', compact(
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'ledgerEntries'
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

            $budget->status = 'Approved';
            $budget->approved_at = now();

        } else {

            $budget->status = 'Rejected';
            $budget->rejected_at = now();
            $budget->rejection_reason = $validated['notes'] ?? '';
        }

        $budget->save();

        return response()->json([
            'success' => true,
            'message' => $validated['action'] === 'approve'
                ? 'Budget approved'
                : 'Budget rejected',
            'data' => $budget,
        ]);
    }
}