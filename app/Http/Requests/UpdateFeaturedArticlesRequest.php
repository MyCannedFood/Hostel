<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeaturedArticlesRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'section_title'       => ['nullable', 'string', 'max:200'],
            'section_description' => ['nullable', 'string', 'max:500'],
            'article_ids'         => ['nullable', 'array', 'max:3'],
            'article_ids.*'       => ['integer', 'exists:articles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'article_ids.max'   => 'Maksimal 3 artikel yang bisa ditampilkan di homepage.',
            'article_ids.*.exists' => 'Salah satu artikel tidak ditemukan.',
        ];
    }
}