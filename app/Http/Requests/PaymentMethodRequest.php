<?php

namespace App\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;
 
class PaymentMethodRequest extends FormRequest
{
    public function authorize(): bool { return true; }
 
    public function rules(): array
    {
        return [
            'type'           => ['required', 'string', 'max:50'],
            'provider_name'  => ['required', 'string', 'max:150'],
            'account_number' => ['nullable', 'string', 'max:60'],
            'email_username' => ['nullable', 'string', 'max:150'],
            'is_default'     => ['boolean'],
            'is_active'      => ['boolean'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'type.required'          => 'Payment type is required.',
            'provider_name.required' => 'Provider name is required.',
        ];
    }
 
    protected function prepareForValidation(): void
    {
        foreach (['is_default', 'is_active'] as $field) {
            if ($this->has($field)) {
                $this->merge([$field => filter_var($this->input($field), FILTER_VALIDATE_BOOLEAN)]);
            }
        }
    }
}
 
