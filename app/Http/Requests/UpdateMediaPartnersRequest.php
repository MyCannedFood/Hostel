<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaPartnersRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'                => ['required', 'string', 'max:100'],
            
            // Partners array
            'partners'             => ['nullable', 'array'],
            'partners.*.name'      => ['required_with:partners', 'string', 'max:150'],
            'partners.*.url'       => ['nullable', 'url', 'max:255'],
            'partners.*.style'     => ['nullable', 'string', 'max:500'],
            'partners.*.logo'      => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'partners.*.logo_path' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'                => 'Judul section wajib diisi.',
            'partners.*.name.required_with' => 'Nama partner wajib diisi.',
            'partners.*.url.url'            => 'URL harus format yang valid.',
            'partners.*.logo.max'           => 'Ukuran logo maksimal 2MB.',
        ];
    }
}
