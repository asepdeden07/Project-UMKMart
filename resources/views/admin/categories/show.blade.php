@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-emerald-600 inline-flex items-center gap-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Kategori
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">Slug: <span class="font-mono text-xs bg-gray-100 px-1.5 py-0.5 rounded text-gray-700">{{ $category->slug }}</span></p>
            </div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-sm font-medium transition-colors">
                Edit Kategori
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Produk Berdasarkan Kategori Ini</h3>
        
        @if($category->products->isEmpty())
            <p class="text-gray-500 text-sm bg-gray-50 p-4 text-center rounded-lg border border-dashed border-gray-200">
                Belum ada produk yang terdaftar di kategori ini.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3 text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                        @foreach($category->products as $product)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-4 py-3 text-emerald-600 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">{{ $product->stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection