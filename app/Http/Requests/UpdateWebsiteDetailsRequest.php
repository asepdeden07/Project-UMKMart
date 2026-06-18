<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebsiteDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'header_description' => 'nullable|string|max:255',
            'footer_description' => 'nullable|string|max:500',
            'store_name'         => 'required|string|max:255',
        'footer_address'     => 'nullable|string',
        'footer_email'       => 'nullable|email|max:255',
        'footer_phone'       => 'nullable|string|max:50',
        'footer_open_hours'  => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'header_description.max' => 'Deskripsi header maksimal 255 karakter',
            'footer_description.max' => 'Deskripsi footer maksimal 500 karakter',
        ];
    }
}