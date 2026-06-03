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
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'room_ids'    => ['nullable', 'array', 'max:6'],
            'room_ids.*'  => ['integer', 'distinct', 'exists:rooms,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul Featured Rooms wajib diisi.',
            'room_ids.max'  => 'Maksimal 6 room bisa ditampilkan di homepage.',
        ];
    }
}
