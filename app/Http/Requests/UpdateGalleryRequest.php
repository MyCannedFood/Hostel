<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // HERO (EN)
            'hero_title_line_1'   => ['required', 'string', 'max:120'],
            'hero_title_line_2'   => ['required', 'string', 'max:120'],
            'hero_description'    => ['required', 'string', 'max:600'],

            // INTRO (EN)
            'intro_label'         => ['required', 'string', 'max:100'],
            'intro_title'         => ['required', 'string', 'max:200'],
            'intro_description'   => ['required', 'string', 'max:600'],

            // OUR STORY (EN)
            'story_title'         => ['required', 'string', 'max:200'],
            'story_paragraph_1'   => ['required', 'string', 'max:800'],
            'story_paragraph_2'   => ['required', 'string', 'max:800'],
            'story_signature_line' => ['required', 'string', 'max:120'],
            'story_signature_title'=> ['required', 'string', 'max:200'],

            // HERO (ID)
            'hero_title_line_1_id'   => ['required', 'string', 'max:200'],
            'hero_title_line_2_id'   => ['required', 'string', 'max:200'],
            'hero_description_id'    => ['required', 'string', 'max:800'],

            // INTRO (ID)
            'intro_label_id'         => ['required', 'string', 'max:200'],
            'intro_title_id'         => ['required', 'string', 'max:250'],
            'intro_description_id'   => ['required', 'string', 'max:800'],

            // OUR STORY (ID)
            'story_title_id'         => ['required', 'string', 'max:250'],
            'story_paragraph_1_id'   => ['required', 'string', 'max:1000'],
            'story_paragraph_2_id'   => ['required', 'string', 'max:1000'],
            'story_signature_line_id' => ['required', 'string', 'max:200'],
            'story_signature_title_id'=> ['required', 'string', 'max:250'],
        ];
    }

    public function messages(): array
    {
        return [
            'hero_title_line_1.required' => 'Hero title (EN) wajib diisi.',
            'hero_title_line_2.required' => 'Hero title (EN) line 2 wajib diisi.',
            'hero_description.required'  => 'Hero description (EN) wajib diisi.',
        ];
    }
}

