<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status harus salah satu dari: pending, confirmed, shipped, delivered, cancelled',
        ];
    }
}
