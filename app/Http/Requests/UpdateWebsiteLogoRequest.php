<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebsiteLogoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'website_logo.image' => 'File harus berupa gambar',
            'website_logo.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'website_logo.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
