<?php
namespace App\Http\Controllers;
 
use App\Models\BankAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
 
class BankAccountController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_holder' => ['required', 'string', 'max:150'],
            'account_number' => ['required', 'string', 'max:30'],
            'is_active'      => ['boolean'],
            'is_default'     => ['boolean'],
        ]);
 
        if (!empty($data['is_default'])) {
            BankAccount::query()->update(['is_default' => false]);
        }
 
        $data['sort_order'] = (BankAccount::max('sort_order') ?? 0) + 1;
        $bank = BankAccount::create($data);
 
        return response()->json(['success' => true, 'bank' => $bank]);
    }
 
    public function update(Request $request, BankAccount $bankAccount): JsonResponse
    {
        $data = $request->validate([
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_holder' => ['required', 'string', 'max:150'],
            'account_number' => ['required', 'string', 'max:30'],
            'is_active'      => ['boolean'],
            'is_default'     => ['boolean'],
        ]);
 
        if (!empty($data['is_default'])) {
            BankAccount::where('id', '!=', $bankAccount->id)
                ->update(['is_default' => false]);
        }
 
        $bankAccount->update($data);
 
        return response()->json(['success' => true, 'bank' => $bankAccount->fresh()]);
    }
 
    public function destroy(BankAccount $bankAccount): JsonResponse
    {
        $bankAccount->delete();
        return response()->json(['success' => true]);
    }
 
    public function toggle(BankAccount $bankAccount): JsonResponse
    {
        $bankAccount->update(['is_active' => !$bankAccount->is_active]);
        return response()->json(['success' => true, 'is_active' => $bankAccount->is_active]);
    }
}