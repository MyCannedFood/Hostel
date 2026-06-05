<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\PaymentMethod;
use App\Models\PaymentSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
 
class PaymentSettingsController extends Controller
{
    // ── GET: tampilkan halaman settings ─────────────────────────────────
    public function index(): View
    {
        return view('admin.settings.partials.General.payment-methods', [
            'settings' => PaymentSetting::instance(),
            'banks'    => BankAccount::ordered()->get(),
            'methods'  => PaymentMethod::ordered()->get(),
        ]);
    }
 
    // ── POST: simpan settings (cash, qris, midtrans) ─────────────────────
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cash_instruction'    => ['nullable', 'string', 'max:1000'],
            'qris_merchant_id'    => ['nullable', 'string', 'max:100'],
            'qris_image'          => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'midtrans_client_key' => ['nullable', 'string', 'max:255'],
            'midtrans_server_key' => ['nullable', 'string', 'max:255'],
        ]);
 
        $settings = PaymentSetting::instance();
 
        $data = [
            'cash_enabled'        => $request->boolean('cash_enabled'),
            'cash_instruction'    => $request->input('cash_instruction'),
            'qris_enabled'        => $request->boolean('qris_enabled'),
            'qris_merchant_id'    => $request->input('qris_merchant_id'),
            'midtrans_enabled'    => $request->boolean('midtrans_enabled'),
            'midtrans_client_key' => $request->input('midtrans_client_key'),
            'midtrans_production' => $request->boolean('midtrans_production'),
        ];
 
        // Hanya update server key jika diisi (biar tidak overwrite enkripsi lama)
        if ($request->filled('midtrans_server_key')) {
            $data['midtrans_server_key'] = $request->input('midtrans_server_key');
        }
 
        // Handle QRIS QR image upload
        if ($request->hasFile('qris_image')) {
            if ($settings->qris_image_path) {
                Storage::disk('public')->delete($settings->qris_image_path);
            }
            $data['qris_image_path'] = $request->file('qris_image')
                ->store('qris', 'public');
        }
 
        $settings->update($data);
 
        return redirect()->back()->with('success', 'Payment settings saved successfully.');
    }
}