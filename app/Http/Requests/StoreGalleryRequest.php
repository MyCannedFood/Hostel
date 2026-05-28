<?php
// FILE: app/Http/Requests/StoreGalleryRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sudah dilindungi middleware is_admin di route
    }

    public function rules(): array
    {
        return [
            'image'            => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // max 5MB
            'title'            => ['required', 'string', 'max:255'],
            'category'         => ['required', 'string', 'in:spaces,nature,dining,wellness,people'],
            'column_placement' => ['required', 'in:left,right'],
            'order_number'     => ['required', 'integer', 'min:1', 'max:999'],
            'alt_text'         => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required'   => 'Foto wajib diupload.',
            'image.max'        => 'Ukuran foto maksimal 5MB.',
            'image.mimes'      => 'Format foto harus JPG, PNG, atau WEBP.',
            'title.required'   => 'Judul foto wajib diisi.',
            'category.required'=> 'Kategori wajib dipilih.',
            'category.in'      => 'Kategori tidak valid.',
            'column_placement.required' => 'Column placement wajib dipilih.',
            'column_placement.in'       => 'Column placement harus Left atau Right.',
            'order_number.required'     => 'Order number wajib diisi.',
            'order_number.integer'      => 'Order number harus angka.',
        ];
    }
}