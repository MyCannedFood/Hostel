<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'bank_name'       => ['required', 'string', 'max:100'],
            'account_holder'  => ['required', 'string', 'max:150'],
            'account_number'  => ['required', 'string', 'max:30'],
            'is_active'       => ['boolean'],
            'is_default'      => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'bank_name.required'      => 'Please select a bank.',
            'account_holder.required' => 'Account holder name is required.',
            'account_number.required' => 'Account number is required.',
        ];
    }

    protected function prepareForValidation(): void
    {
        foreach (['is_active', 'is_default'] as $field) {
            if ($this->has($field)) {
                $this->merge([$field => filter_var($this->input($field), FILTER_VALIDATE_BOOLEAN)]);
            }
        }
    }
}