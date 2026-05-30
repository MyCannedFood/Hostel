<?php
// FILE: app/Http/Requests/UpdatePhilosophyRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhilosophyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'tagline'               => ['required', 'string', 'max:100'],
            'heading'               => ['required', 'string', 'max:200'],
            'body_1'                => ['required', 'string', 'max:600'],
            'body_2'                => ['nullable', 'string', 'max:600'],

            // Features array
            'features'              => ['nullable', 'array', 'max:6'],
            'features.*.title'      => ['required_with:features', 'string', 'max:100'],
            'features.*.description'=> ['nullable', 'string', 'max:300'],
            'features.*.icon'       => ['nullable', 'image', 'mimes:png,jpg,svg', 'max:1024'],
            // icon_path existing — digunakan kalau tidak ada file upload baru
            'features.*.icon_path'  => ['nullable', 'string'],

            // Side image
            'side_image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_side_image'     => ['nullable', 'boolean'],

            // Badge
            'badge_label'           => ['nullable', 'string', 'max:80'],
            'badge_value'           => ['nullable', 'string', 'max:80'],
        ];
    }

    public function messages(): array
    {
        return [
            'tagline.required'          => 'Tagline wajib diisi.',
            'heading.required'          => 'Heading wajib diisi.',
            'body_1.required'           => 'Paragraf pertama wajib diisi.',
            'features.*.title.required_with' => 'Judul fitur wajib diisi.',
            'side_image.max'            => 'Ukuran gambar maksimal 3MB.',
        ];
    }
}