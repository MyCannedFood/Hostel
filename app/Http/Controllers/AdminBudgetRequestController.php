<?php

namespace App\Http\Controllers;

use App\Models\BudgetRequest;
use App\Models\BudgetRequestItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class AdminBudgetRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'                      => 'required|string|max:255',
            'type'                       => 'required|string|max:255',
            'category'                   => 'required|string|max:255',
            'requested_by'               => 'nullable|string|max:255',
            'notes'                      => 'nullable|string',
            'items'                      => 'required|array|min:1',
            'items.*.title'              => 'required|string|max:255',
            'items.*.estimated_amount'   => 'required|numeric|min:0',
            'items.*.notes'              => 'nullable|string',
            'items.*.payment_method'     => 'nullable|string|max:255',
            'items.*.invoice'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $code = 'BKD-' . strtoupper(Str::random(10));

        $budgetRequest = BudgetRequest::create([
            'request_code'           => $code,
            'title'                  => $validated['title'],
            'type'                   => $validated['type'],
            'category'               => $validated['category'],
            'requested_by'           => $validated['requested_by'] ?? 'AlaSare Admin',
            'notes'                  => $validated['notes'] ?? null,
            'estimated_total_amount' => 0,
            'status'                 => 'Pending',
        ]);

        $total = 0;

        foreach ($validated['items'] as $idx => $item) {
            $invoicePath = null;
            if ($request->hasFile("items.$idx.invoice")) {
                $invoicePath = $request->file("items.$idx.invoice")
                    ->store('public/budgeting/invoices');
            }

            $amount = (int) round((float) $item['estimated_amount']);
            $total += $amount;

            $budgetRequest->items()->create([
                'title'            => $item['title'],
                'estimated_amount' => $amount,
                'notes'            => $item['notes'] ?? null,
                'payment_method'   => $item['payment_method'] ?? null,
                'invoice_path'     => $invoicePath,
            ]);
        }

        $budgetRequest->update(['estimated_total_amount' => $total]);

        return back()->with('success', 'Budget request submitted: ' . $budgetRequest->request_code);
    }
}