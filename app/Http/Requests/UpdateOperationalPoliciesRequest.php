<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperationalPoliciesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'checkin_time'     => 'required|string|max:5',
            'checkout_time'    => 'required|string|max:5',
            'late_policy'      => 'nullable|string|max:500',
            'tax_included'     => 'sometimes|boolean',
            'government_tax'   => 'required|numeric|min:0|max:100',
            'service_charge'   => 'required|numeric|min:0|max:100',
            'house_rules'      => 'nullable|string|max:5000',
        ];
    }
}
