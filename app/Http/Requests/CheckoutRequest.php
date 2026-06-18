<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'address' => ['required', 'string', 'min:10', 'max:500'],
            
            // Diubah menjadi array agar karakter '|' di dalam regex aman dari parsing Laravel
            'phone'   => ['required', 'regex:/^(\+62|0)[0-9]{9,12}$/'], 
            
            'notes'   => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => 'Alamat pengiriman wajib diisi',
            'address.min'      => 'Alamat minimal 10 karakter',
            'address.max'      => 'Alamat maksimal 500 karakter',
            'phone.required'   => 'Nomor telepon wajib diisi',
            'phone.regex'      => 'Format nomor telepon tidak valid (contoh: 081234567890 atau +6281234567890)',
            'notes.max'        => 'Catatan maksimal 500 karakter',
        ];
    }
}