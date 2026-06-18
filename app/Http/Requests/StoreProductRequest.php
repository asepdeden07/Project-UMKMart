<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|decimal:0,2',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'name.required' => 'Nama produk wajib diisi',
            'description.required' => 'Deskripsi produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal 0',
            'stock.required' => 'Stok produk wajib diisi',
            'stock.integer' => 'Stok harus berupa angka bulat',
            'stock.min' => 'Stok minimal 0',
            'image.required' => 'Gambar produk wajib diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
