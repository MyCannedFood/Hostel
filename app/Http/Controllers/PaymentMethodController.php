<?php

namespace App\Http\Controllers;
 
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
 
class PaymentMethodController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type'           => ['required', 'string', 'max:50'],
            'provider_name'  => ['required', 'string', 'max:150'],
            'account_number' => ['nullable', 'string', 'max:60'],
            'email_username' => ['nullable', 'string', 'max:150'],
            'is_default'     => ['boolean'],
            'is_active'      => ['boolean'],
        ]);
 
        if (!empty($data['is_default'])) {
            PaymentMethod::query()->update(['is_default' => false]);
        }
 
        $data['sort_order'] = (PaymentMethod::max('sort_order') ?? 0) + 1;
        $method = PaymentMethod::create($data);
 
        return response()->json(['success' => true, 'method' => $method]);
    }
 
    public function update(Request $request, PaymentMethod $paymentMethod): JsonResponse
    {
        $data = $request->validate([
            'type'           => ['required', 'string', 'max:50'],
            'provider_name'  => ['required', 'string', 'max:150'],
            'account_number' => ['nullable', 'string', 'max:60'],
            'email_username' => ['nullable', 'string', 'max:150'],
            'is_default'     => ['boolean'],
            'is_active'      => ['boolean'],
        ]);
 
        if (!empty($data['is_default'])) {
            PaymentMethod::where('id', '!=', $paymentMethod->id)
                ->update(['is_default' => false]);
        }
 
        $paymentMethod->update($data);
 
        return response()->json(['success' => true, 'method' => $paymentMethod->fresh()]);
    }
 
    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->delete();
        return response()->json(['success' => true]);
    }
 
    public function toggle(PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);
        return response()->json(['success' => true, 'is_active' => $paymentMethod->is_active]);
    }
}
 
