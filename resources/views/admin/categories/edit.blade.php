@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-emerald-600 inline-flex items-center gap-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Ubah Kategori</h2>
        <p class="text-sm text-gray-500 mt-0.5">Mengubah data kategori: <span class="font-semibold text-gray-700">{{ $category->name }}</span></p>
    </div>

    <div class="max-w-xl bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="w-full px-4 py-2 border @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-20" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 text-sm font-medium transition-colors">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
@endsection