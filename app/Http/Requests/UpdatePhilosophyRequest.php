<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhilosophyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // English Fields
            'tagline'               => ['required', 'string', 'max:100'],
            'heading'               => ['required', 'string', 'max:200'],
            'body_1'                => ['required', 'string', 'max:600'],
            'body_2'                => ['nullable', 'string', 'max:600'],

            // Indonesian Fields (Bilingual)
            'tagline_id'            => ['required', 'string', 'max:100'],
            'heading_id'            => ['required', 'string', 'max:200'],
            'body_1_id'             => ['required', 'string', 'max:600'],
            'body_2_id'             => ['nullable', 'string', 'max:600'],

            // Features array
            'features'              => ['nullable', 'array', 'max:6'],
            'features.*.title'      => ['required_with:features', 'string', 'max:100'],
            'features.*.title_id'   => ['required_with:features', 'string', 'max:100'], // ← Tambah ini
            'features.*.description'=> ['nullable', 'string', 'max:300'],
            'features.*.description_id'=> ['nullable', 'string', 'max:300'], // ← Tambah ini
            'features.*.icon'       => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:1024'],
            'features.*.icon_path'  => ['nullable', 'string'],

            // Side image
            'side_image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_side_image'     => ['nullable', 'boolean'],

            // Badge
            'badge_label'           => ['nullable', 'string', 'max:80'],
            'badge_label_id'        => ['nullable', 'string', 'max:80'], // ← Tambah ini
            'badge_value'           => ['nullable', 'string', 'max:80'],
            'badge_value_id'        => ['nullable', 'string', 'max:80'], // ← Tambah ini
        ];
    }

    public function messages(): array
    {
        return [
            'tagline.required'               => 'Tagline (EN) wajib diisi.',
            'tagline_id.required'            => 'Tagline (ID) wajib diisi.',
            'heading.required'               => 'Heading (EN) wajib diisi.',
            'heading_id.required'            => 'Heading (ID) wajib diisi.',
            'body_1.required'                => 'Paragraf pertama (EN) wajib diisi.',
            'body_1_id.required'             => 'Paragraf pertama (ID) wajib diisi.',
            'features.*.title.required_with' => 'Judul fitur (EN) wajib diisi.',
            'features.*.title_id.required_with' => 'Judul fitur (ID) wajib diisi.',
            'side_image.max'                 => 'Ukuran gambar maksimal 3MB.',
        ];
    }
}