<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// ══════════════════════════════════════════════
// Save all payment settings (main page save)
// ══════════════════════════════════════════════
class SavePaymentSettingsRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Cash
            'cash_enabled'              => ['boolean'],
            'cash_instruction'          => ['nullable', 'string', 'max:1000'],

            // QRIS
            'qris_enabled'              => ['boolean'],
            'qris_merchant_id'          => ['nullable', 'string', 'max:100'],
            'qris_image'                => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],

            // Midtrans
            'midtrans_enabled'          => ['boolean'],
            'midtrans_client_key'       => ['nullable', 'string', 'max:255'],
            'midtrans_server_key'       => ['nullable', 'string', 'max:255'],
            'midtrans_production'       => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Checkboxes come as "1"/"0" or missing; normalise to bool
        foreach (['cash_enabled', 'qris_enabled', 'midtrans_enabled', 'midtrans_production'] as $field) {
            if ($this->has($field)) {
                $this->merge([$field => filter_var($this->input($field), FILTER_VALIDATE_BOOLEAN)]);
            }
        }
    }
}