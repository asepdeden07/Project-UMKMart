@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Edit Produk</h2>
            <p class="text-gray-500 mt-1">Perbarui informasi produk</p>
        </div>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-5">
            @csrf
            @method('PATCH')

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Produk *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama produk">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori *</label>
                <select id="category_id" name="category_id" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 @error('category_id') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi *</label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 @error('description') border-red-500 @enderror"
                          placeholder="Deskripsi produk">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp) *</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 @error('price') border-red-500 @enderror"
                           placeholder="0">
                    @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">Stok *</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 @error('stock') border-red-500 @enderror"
                           placeholder="0">
                    @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Foto Produk -->
            <div>
                <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Foto Produk</label>
                
                @if($product->image)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 rounded-lg">
                    </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-emerald-500 transition-colors duration-200 @error('image') border-red-500 @enderror"
                     onclick="document.getElementById('image').click()">
                    <input type="file" id="image" name="image" accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                    
                    <div id="imagePreview" class="hidden mb-4">
                        <img id="previewImg" src="" alt="Preview" class="h-32 mx-auto rounded-lg">
                    </div>

                    <div id="uploadPrompt">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium">Klik atau drag foto baru di sini</p>
                        <p class="text-gray-400 text-sm">PNG, JPG, GIF up to 10MB (opsional)</p>
                    </div>
                </div>
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 font-medium">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.products.index') }}" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    document.getElementById('uploadPrompt').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
