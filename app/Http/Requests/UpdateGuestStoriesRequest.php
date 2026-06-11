<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuestStoriesRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Section Titles
            'title'                      => ['nullable', 'string', 'max:100'],
            'title_id'                   => ['nullable', 'string', 'max:100'],

            // Array Stories Validation
            'stories'                    => ['nullable', 'array'],
            'stories.*.name'             => ['required_with:stories', 'string', 'max:150'],
            
            // English Content
            'stories.*.origin'           => ['nullable', 'string', 'max:150'],
            'stories.*.quote'            => ['nullable', 'string', 'max:400'],
            
            // Indonesian Content
            'stories.*.origin_id'        => ['nullable', 'string', 'max:150'],
            'stories.*.quote_id'         => ['nullable', 'string', 'max:400'],
            
            // Media
            'stories.*.image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'stories.*.image_path'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'stories.*.name.required_with' => 'Nama guest wajib diisi.',
            'stories.*.image.max'          => 'Ukuran foto maksimal 5MB.',
            'stories.*.image.mimes'        => 'Format foto harus JPG, PNG, atau WEBP.',
        ];
    }
}