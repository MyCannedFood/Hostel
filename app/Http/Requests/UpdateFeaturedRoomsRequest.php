<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeaturedRoomsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:150'],
            'title_id'       => ['nullable', 'string', 'max:150'], // 👈 Tambahkan ini
            'description'    => ['nullable', 'string', 'max:500'],
            'description_id' => ['nullable', 'string', 'max:500'], // 👈 Tambahkan ini
            'room_ids'       => ['nullable', 'array', 'max:6'],
            'room_ids.*'     => ['integer', 'distinct', 'exists:rooms,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul Featured Rooms (EN) wajib diisi.',
            'room_ids.max'   => 'Maksimal 6 room bisa ditampilkan di homepage.',
        ];
    }
}