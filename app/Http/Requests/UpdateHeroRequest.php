<?php
// FILE: app/Http/Requests/UpdateHeroRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'headline'    => ['required', 'string', 'max:150'],
            'subheadline' => ['required', 'string', 'max:200'],
            // bg_image opsional — kalau tidak diisi, gambar lama dipertahankan
            'bg_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'headline.required'    => 'Headline wajib diisi.',
            'headline.max'         => 'Headline maksimal 150 karakter.',
            'subheadline.required' => 'Sub-headline wajib diisi.',
            'subheadline.max'      => 'Sub-headline maksimal 200 karakter.',
            'bg_image.image'       => 'File harus berupa gambar.',
            'bg_image.max'         => 'Ukuran gambar maksimal 2MB.',
            'bg_image.mimes'       => 'Format gambar harus JPG, PNG, atau WEBP.',
        ];
    }
}