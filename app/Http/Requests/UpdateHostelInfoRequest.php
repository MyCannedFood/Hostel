<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHostelInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'hostel_name'      => 'required|string|max:255',
            'default_language' => 'required|string|max:10',
            'currency'         => 'required|string|max:10',
            'timezone'         => 'required|string|max:50',
            'site_title'       => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'languages'        => 'nullable|string',
            'main_logo'        => 'nullable|image|mimes:png,svg|max:2048',
            'favicon'          => 'nullable|image|mimes:png,ico,svg|max:1024',
        ];
    }
}
