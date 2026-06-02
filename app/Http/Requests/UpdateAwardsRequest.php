<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAwardsRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'section_title'              => ['nullable', 'string', 'max:150'],
            'items'                      => ['nullable', 'array'],
            'items.*.title'              => ['required_with:items', 'string', 'max:150'],
            'items.*.sub'                => ['nullable', 'string', 'max:150'],
            'items.*.is_visible'         => ['nullable', 'boolean'],
            'items.*.icon'               => ['nullable', 'image', 'mimes:png,jpg,svg,webp', 'max:1024'],
            'items.*.icon_path'          => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.*.title.required_with' => 'Judul award wajib diisi.',
            'items.*.icon.max'            => 'Ukuran ikon maksimal 1MB.',
        ];
    }

    /**
     * Pastikan maksimal 4 item yang is_visible = true.
     * Kalau lebih, ambil 4 pertama saja.
     */
    protected function passedValidation(): void
    {
        $items   = $this->input('items', []);
        $visible = 0;
        foreach ($items as $k => $item) {
            if ($visible >= 4) {
                $items[$k]['is_visible'] = false;
            } elseif (!empty($item['is_visible'])) {
                $visible++;
            }
        }
        $this->merge(['items' => $items]);
    }
}