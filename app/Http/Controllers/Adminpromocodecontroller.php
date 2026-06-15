<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;

class AdminPromoCodeController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'code'           => 'required|string|max:50|unique:promo_codes,code',
            'discount_value' => 'required|numeric|min:0',
            'discount_type'  => 'required|in:percentage,flat',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'quota'          => 'required|integer|min:0',
            'status'         => 'required|in:active,non-active',
        ]);

        // Percentage tidak boleh > 100
        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Percentage discount cannot exceed 100%.',
            ], 422);
        }

        $promo = PromoCode::create($validated);

        return response()->json(['success' => true, 'promo' => $promo]);
    }

    public function update(Request $request, PromoCode $promo): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'code'           => 'required|string|max:50|unique:promo_codes,code,' . $promo->id,
            'discount_value' => 'required|numeric|min:0',
            'discount_type'  => 'required|in:percentage,flat',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'quota'          => 'required|integer|min:0',
            'status'         => 'required|in:active,non-active',
        ]);

        if ($validated['discount_type'] === 'percentage' && $validated['discount_value'] > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Percentage discount cannot exceed 100%.',
            ], 422);
        }

        $promo->update($validated);

        return response()->json(['success' => true, 'promo' => $promo]);
    }

    public function destroy(PromoCode $promo): \Illuminate\Http\JsonResponse
    {
        $promo->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Public endpoint — dipakai di experience-payment-method.blade.php
     * POST /experience/promo/apply
     */
    public function apply(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'code'     => 'required|string',
            'subtotal' => 'required|integer|min:0',
        ]);

        $promo = PromoCode::where('code', strtoupper(trim($request->code)))->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Promo code not found.'], 404);
        }

        $result = $promo->apply((int) $request->subtotal);

        if (!$result['valid']) {
            return response()->json(['success' => false, 'message' => $result['message']], 422);
        }

        return response()->json([
            'success'        => true,
            'discount'       => $result['discount'],
            'discount_type'  => $promo->discount_type,
            'discount_value' => $promo->discount_value,
            'code'           => $promo->code,
        ]);
    }
}