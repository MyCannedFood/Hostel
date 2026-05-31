<?php
// FILE: app/Http/Requests/UpdateFloraRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFloraRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'eyebrow'               => ['nullable', 'string', 'max:100'],
            'title'                 => ['required', 'string', 'max:200'],
            'description'           => ['required', 'string', 'max:500'],

            'cards'                 => ['nullable', 'array', 'max:6'],
            'cards.*.eyebrow'       => ['nullable', 'string', 'max:100'],
            'cards.*.title'         => ['required_with:cards', 'string', 'max:200'],
            'cards.*.description'   => ['nullable', 'string', 'max:400'],
            'cards.*.image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'cards.*.image_path'    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'                  => 'Section title wajib diisi.',
            'description.required'            => 'Section description wajib diisi.',
            'cards.*.title.required_with'     => 'Judul card wajib diisi.',
            'cards.*.image.max'               => 'Ukuran gambar card maksimal 3MB.',
        ];
    }
}