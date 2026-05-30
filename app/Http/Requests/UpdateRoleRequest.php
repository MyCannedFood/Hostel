<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
 
class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool { return true; }
 
    public function rules(): array
    {
        $roleParam = $this->route('role');
        $roleId = is_object($roleParam) ? ($roleParam->getKey() ?? null) : $roleParam;

 
        return [
            'role_name'        => ['required', 'string', 'max:100', "unique:roles,name,{$roleId}"],
            'role_description' => ['nullable', 'string', 'max:500'],
            'permissions'      => ['nullable', 'array'],
            'permissions.*'    => ['string', 'in:' . implode(',', array_keys(\App\Models\Role::PERMISSIONS))],
        ];
    }
 
    public function messages(): array
    {
        return [
            'role_name.required' => 'Nama role wajib diisi.',
            'role_name.unique'   => 'Nama role sudah digunakan.',
        ];
    }
}