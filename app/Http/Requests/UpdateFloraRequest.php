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
            // Section Header (English)
            'eyebrow'                 => ['nullable', 'string', 'max:100'],
            'title'                   => ['required', 'string', 'max:200'],
            'description'             => ['required', 'string', 'max:500'],

            // Section Header (Indonesian)
            'eyebrow_id'              => ['nullable', 'string', 'max:100'],
            'title_id'                => ['required', 'string', 'max:200'],
            'description_id'          => ['required', 'string', 'max:500'],

            // Flora Detail Cards
            'cards'                   => ['nullable', 'array', 'max:6'],
            
            // Cards (English)
            'cards.*.eyebrow'         => ['nullable', 'string', 'max:100'],
            'cards.*.title'           => ['required_with:cards', 'string', 'max:200'],
            'cards.*.description'     => ['nullable', 'string', 'max:400'],
            
            // Cards (Indonesian)
            'cards.*.eyebrow_id'      => ['nullable', 'string', 'max:100'],
            'cards.*.title_id'        => ['required_with:cards', 'string', 'max:200'],
            'cards.*.description_id'  => ['nullable', 'string', 'max:400'],
            
            // Card Media
            'cards.*.image'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'cards.*.image_path'      => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'                  => 'Section title (EN) wajib diisi.',
            'title_id.required'               => 'Section title (ID) wajib diisi.',
            'description.required'            => 'Section description (EN) wajib diisi.',
            'description_id.required'         => 'Section description (ID) wajib diisi.',
            'cards.*.title.required_with'     => 'Judul card (EN) wajib diisi jika card ditambahkan.',
            'cards.*.title_id.required_with'  => 'Judul card (ID) wajib diisi jika card ditambahkan.',
            'cards.*.image.max'               => 'Ukuran gambar card maksimal 3MB.',
            'cards.*.image.mimes'             => 'Format gambar harus JPG, PNG, atau WEBP.',
        ];
    }
}