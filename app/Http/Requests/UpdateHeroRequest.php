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
            // English Validation
            'headline'       => ['required', 'string', 'max:150'],
            'subheadline'    => ['required', 'string', 'max:200'],

            // Indonesian Validation (Tambahan baru)
            'headline_id'    => ['required', 'string', 'max:150'],
            'subheadline_id' => ['required', 'string', 'max:200'],

            // Image Validation (Optional)
            'bg_image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            // English Messages
            'headline.required'       => 'Headline (EN) wajib diisi.',
            'headline.max'            => 'Headline (EN) maksimal 150 karakter.',
            'subheadline.required'    => 'Sub-headline (EN) wajib diisi.',
            'subheadline.max'         => 'Sub-headline (EN) maksimal 200 karakter.',

            // Indonesian Messages
            'headline_id.required'    => 'Headline (ID) wajib diisi.',
            'headline_id.max'         => 'Headline (ID) maksimal 150 karakter.',
            'subheadline_id.required' => 'Sub-headline (ID) wajib diisi.',
            'subheadline_id.max'      => 'Sub-headline (ID) maksimal 200 karakter.',

            // Image Messages
            'bg_image.image'          => 'File harus berupa gambar.',
            'bg_image.max'            => 'Ukuran gambar maksimal 2MB.',
            'bg_image.mimes'          => 'Format gambar harus JPG, PNG, atau WEBP.',
        ];
    }
}