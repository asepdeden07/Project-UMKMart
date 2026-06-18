<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:999',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID wajib ada',
            'product_id.exists' => 'Produk tidak ditemukan',
            'quantity.required' => 'Jumlah wajib diisi',
            'quantity.min' => 'Jumlah minimal 1',
            'quantity.max' => 'Jumlah maksimal 999',
        ];
    }
}
