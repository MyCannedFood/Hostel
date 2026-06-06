<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        $adminId = Auth::guard('admin')->id();

        return [
            // Profile
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                'unique:admins,email,' . $adminId,
            ],

'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d+$/',
            ],

            'avatar_data' => [
                'nullable',
                'string',
            ],

            // Password
            'current_password' => [
                'nullable',
                'string',
                'required_with:new_password',
            ],

            'new_password' => [
                'nullable',
                'string',
                'confirmed',
                Password::min(8)->numbers(),
            ],

            'new_password_confirmation' => [
                'nullable',
                'string',
                'required_with:new_password',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',

            'phone.required' => 'Nomor telepon wajib diisi.',

            'current_password.required_with' =>
                'Password lama wajib diisi untuk mengganti password.',

            'new_password.confirmed' =>
                'Konfirmasi password tidak cocok.',

            'new_password_confirmation.required_with' =>
                'Konfirmasi password wajib diisi.',
        ];
    }
}