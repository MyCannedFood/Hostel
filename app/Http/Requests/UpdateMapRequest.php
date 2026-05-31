<?php
// FILE: app/Http/Requests/UpdateMapRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMapRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'subtitle'  => ['nullable', 'string', 'max:100'],
            'title'     => ['nullable', 'string', 'max:200'],
            'map_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // max 5MB
            'remove_map_image' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'map_image.max'   => 'Ukuran gambar maksimal 5MB.',
            'map_image.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
        ];
    }
}