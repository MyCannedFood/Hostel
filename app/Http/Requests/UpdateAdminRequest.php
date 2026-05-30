<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
 
class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool { return true; }
 
    public function rules(): array
    {
        $adminParam = $this->route('admin'); // dari route /admin/staff/{admin}
        $adminId = is_object($adminParam) ? ($adminParam->getKey() ?? null) : $adminParam;


 
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', "unique:admins,email,{$adminId}"],
            'role_id'  => ['required', 'exists:roles,id'],
            // Password opsional — kalau diisi minimal 8 karakter
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'name.required'    => 'Nama wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.unique'     => 'Email sudah digunakan akun lain.',
            'role_id.required' => 'Role wajib dipilih.',
            'password.min'     => 'Password minimal 8 karakter.',
        ];
    }
}