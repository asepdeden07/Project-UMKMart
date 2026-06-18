@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kategori</h2>
            <p class="text-gray-500 mt-1">Kelola kategori pengelompokan produk Anda</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 font-medium inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Tambah Kategori</span>
        </a>
    </div>

    @if($categories->isEmpty())
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada kategori</h3>
            <p class="text-gray-500 mb-6">Mulai tambahkan kategori baru untuk toko Anda</p>
            <a href="{{ route('admin.categories.create') }}" class="inline-block px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                Tambah Kategori Pertama
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4 text-center">Total Produk</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-600">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                    {{ $category->slug }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                        {{ $category->products_count }} Produk
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="px-3 py-1.5 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-lg text-xs font-medium transition-colors">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-medium transition-colors">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Yakin ingin hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-medium transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($categories->hasPages())
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        @endif
    @endif
@endsection