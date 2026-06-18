<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'hero_banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'hero_banner.image' => 'File harus berupa gambar',
            'hero_banner.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'hero_banner.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
