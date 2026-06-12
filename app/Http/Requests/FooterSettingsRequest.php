<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FooterSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'brand_desc'         => ['nullable', 'string', 'max:500'],
            'brand_desc_id'      => ['nullable', 'string', 'max:500'],
            'newsletter_text'    => ['nullable', 'string', 'max:200'],
            'newsletter_text_id' => ['nullable', 'string', 'max:200'],
            'instagram_url'      => ['nullable', 'url', 'max:255'],
            'facebook_url'       => ['nullable', 'url', 'max:255'],
            'pinterest_url'      => ['nullable', 'url', 'max:255'],
            'copyright_text'     => ['nullable', 'string', 'max:200'],
            'copyright_text_id'  => ['nullable', 'string', 'max:200'],
            'privacy_url'        => ['nullable', 'string', 'max:255'],
            'terms_url'          => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'instagram_url.url' => 'Instagram URL tidak valid.',
            'facebook_url.url'  => 'Facebook URL tidak valid.',
            'pinterest_url.url' => 'Pinterest URL tidak valid.',
        ];
    }
}