<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminPromoCodeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate(['type' => 'required|in:experience,room']);

        $promoCodes = PromoCode::byType($request->type)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'promoCodes' => $promoCodes]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type'           => 'required|in:experience,room',
            'code'           => 'required|string|max:50|unique:promo_codes,code',
            'discount_value' => 'required|numeric|min:0',
            'discount_type'  => 'required|in:percentage,flat',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'quota'          => 'required|integer|min:0',
            'status'         => 'required|in:active,non-active',
        ]);

        $promoCode = PromoCode::create($validated);

        return response()->json(['success' => true, 'promoCode' => $promoCode]);
    }

    public function update(Request $request, PromoCode $promoCode): JsonResponse
    {
        $validated = $request->validate([
            'code'           => 'required|string|max:50|unique:promo_codes,code,' . $promoCode->id,
            'discount_value' => 'required|numeric|min:0',
            'discount_type'  => 'required|in:percentage,flat',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'quota'          => 'required|integer|min:0',
            'status'         => 'required|in:active,non-active',
        ]);

        $promoCode->update($validated);

        return response()->json(['success' => true, 'promoCode' => $promoCode]);
    }

    public function toggleStatus(PromoCode $promoCode): JsonResponse
    {
        $promoCode->update([
            'status' => $promoCode->status === 'active' ? 'non-active' : 'active',
        ]);

        return response()->json(['success' => true, 'status' => $promoCode->status]);
    }

    public function destroy(PromoCode $promoCode): JsonResponse
    {
        $promoCode->delete();

        return response()->json(['success' => true]);
    }
}
