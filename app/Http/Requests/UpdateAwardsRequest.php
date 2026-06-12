<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAwardsRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'section_title'        => ['nullable', 'string', 'max:150'],
            'section_title_id'     => ['nullable', 'string', 'max:150'], // 👈 Tambah ID
            'items'                => ['nullable', 'array'],
            'items.*.title'        => ['required_with:items', 'string', 'max:150'],
            'items.*.title_id'     => ['required_with:items', 'string', 'max:150'], // 👈 Tambah ID
            'items.*.sub'          => ['nullable', 'string', 'max:150'],
            'items.*.sub_id'       => ['nullable', 'string', 'max:150'], // 👈 Tambah ID
            'items.*.is_visible'   => ['nullable'],
            'items.*.icon'         => ['nullable', 'image', 'mimes:png,jpg,svg,webp', 'max:1024'],
            'items.*.icon_path'    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.*.title.required_with'    => 'Judul award (EN) wajib diisi.',
            'items.*.title_id.required_with' => 'Judul award (ID) wajib diisi.',
            'items.*.icon.max'               => 'Ukuran ikon maksimal 1MB.',
        ];
    }

    protected function passedValidation(): void
    {
        $items = $this->input('items', []);
        $visibleCount = 0;

        foreach ($items as $k => $item) {
            $hasVisibleFlag = isset($item['is_visible']) && ($item['is_visible'] == '1' || $item['is_visible'] == true);

            if ($hasVisibleFlag && $visibleCount < 4) {
                $items[$k]['is_visible'] = true;
                $visibleCount++;
            } else {
                $items[$k]['is_visible'] = false;
            }
        }
        
        $this->merge(['items' => $items]);
    }
}