<?php

namespace App\Http\Controllers;

use App\Models\BudgetRequest;
use App\Models\LjpReport;
use App\Models\GeneralLedger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class AdminLpjController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'budget_request_id'        => 'required|integer|exists:budget_requests,id',
            'items'                    => 'required|array|min:1',
            'items.*.estimated_amount' => 'required|numeric|min:0',
            'items.*.actual_amount'    => 'required|numeric|min:0',
            'items.*.notes'            => 'nullable|string',
            'invoice'                  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $budgetRequest = BudgetRequest::with('items')
            ->findOrFail($validated['budget_request_id']);

        $totalEstimated = collect($validated['items'])
            ->sum(fn($i) => (int) round((float) $i['estimated_amount']));

        $totalActual = collect($validated['items'])
            ->sum(fn($i) => (int) round((float) $i['actual_amount']));

        $invoicePath = null;
        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('public/budgeting/lpj');
        }

        // Simpan LPJ
        $report = LjpReport::create([
            'budget_request_id'      => $budgetRequest->id,
            'request_code'           => $budgetRequest->request_code,
            'total_estimated_amount' => $totalEstimated,
            'total_actual_amount'    => $totalActual,
            'status'                 => 'Submitted',
            'invoice_path'           => $invoicePath,
        ]);

        // Otomatis masuk General Ledger sebagai Out
        GeneralLedger::create([
            'trans_code'    => 'TR-' . strtoupper(Str::random(6)),
            'lpj_report_id' => $report->id,
            'description'   => $budgetRequest->title,
            'category'      => $budgetRequest->category,
            'type'          => 'Out',
            'amount'        => $totalActual,
        ]);

        return back()->with('success', 'LPJ submitted for ' . $report->request_code);
    }
}