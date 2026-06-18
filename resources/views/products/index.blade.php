@extends('layouts.app')

@section('title', 'Semua Produk - UMKMart')

@section('content')
    <!-- HERO SECTION -->
    <section class="relative py-12 sm:py-16 overflow-hidden text-white">
        @if(!empty($gHeroBackground))
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                 style="background-image: url('{{ asset('storage/' . $gHeroBackground) }}');">
                <div class="absolute inset-0 bg-black/60"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800"></div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Menyesuaikan ukuran text header di mobile (text-3xl) agar tidak terlalu besar -->
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-2">Semua Produk</h1>
            <p class="text-sm text-emerald-100 font-light max-w-xl">
                Temukan berbagai produk dan layanan terpercaya dari pelaku usaha dan UMKM di seluruh Indonesia.
            </p>
        </div>
    </section>

    <!-- KATALOG PRODUK -->
    <section class="py-10 sm:py-16 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- FILTER BANNER -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-10">
                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <label for="sort" class="text-sm font-bold text-gray-700 whitespace-nowrap">Urutkan :</label>
                    
                    <!-- Menambahkan w-full di mobile agar dropdown select lebih mudah ditekan -->
                    <select id="sort" onchange="location = this.value;" class="w-full sm:w-auto px-4 py-2.5 text-sm bg-gray-50 text-gray-700 border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 cursor-pointer font-medium">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => '']) }}" {{ request('sort') == '' ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-low']) }}" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-high']) }}" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer</option>
                    </select>
                </div>
                <!-- Mengoreksi typo 'inline-self-start' menjadi 'self-start' agar rapi di mobile -->
                <p class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg self-start sm:self-auto">
                    Menampilkan <span class="text-emerald-600 font-bold">{{ $products->total() }}</span> produk pilihan
                </p>
            </div>

            <!-- GRID PRODUK (1 Kolom di HP, otomatis naik sesuai ukuran layar) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full">
                        <div class="relative overflow-hidden bg-gray-100 h-48">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 text-xs">Tidak ada gambar</div>
                            @endif
                            
                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm text-gray-900 px-2.5 py-1 rounded-xl text-xs font-bold shadow-sm border border-white/20">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            @if($product->stock <= 5)
                                <div class="absolute top-3 left-3 bg-red-500 text-white px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wide uppercase shadow-sm">
                                    Stok Terbatas ({{ $product->stock }})
                                </div>
                            @else
                                <div class="absolute top-3 left-3 bg-emerald-500 text-white px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wide uppercase shadow-sm">
                                    Tersedia
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <span class="text-[11px] text-emerald-600 font-bold uppercase tracking-wider mb-1 block">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                            <h3 class="text-sm font-bold text-gray-800 mb-1.5 line-clamp-2 group-hover:text-emerald-600 transition-colors duration-150">{{ $product->name }}</h3>
                            <!-- Deskripsi tetap ada dan utuh -->
                            <p class="text-gray-400 text-xs mb-4 line-clamp-2 font-light">{{ $product->description }}</p>

                            <div class="mt-auto pt-2">
                                @if(auth()->check())
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('cart.add') }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-emerald-600 text-white py-2.5 px-3 rounded-xl hover:bg-emerald-700 shadow-sm shadow-emerald-200 hover:shadow-md transition-all duration-200 font-semibold text-xs flex items-center justify-center space-x-1 cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                <span>Keranjang</span>
                                            </button>
                                        </form>
                                        <button class="p-2.5 border border-gray-200 text-gray-400 hover:text-red-500 hover:bg-red-50 hover:border-red-100 rounded-xl transition-all duration-200 focus:outline-none cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full bg-gray-100 hover:bg-emerald-50 text-gray-500 hover:text-emerald-700 py-2.5 px-4 rounded-xl text-center font-semibold text-xs transition-all duration-200">
                                        Masuk untuk Pesan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                        <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-800 mb-1">Produk Tidak Ditemukan</h3>
                        <p class="text-xs text-gray-400 max-w-xs mx-auto">Maaf, saat ini produk yang Anda cari belum tersedia. Silakan coba sesuaikan kata kunci atau filter katalog.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-16 flex justify-center custom-pagination">
                {{ $products->links() }}
            </div>
        </div>
    </section>

    <!-- SECTION CALL TO ACTION -->
    <section class="py-12 sm:py-16 bg-gradient-to-br from-emerald-600 to-teal-800 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-4">
            <!-- Ukuran judul disesuaikan di mobile agar pas -->
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Tidak Menemukan yang Anda Cari?</h2>
            <p class="text-emerald-100 text-sm max-w-md mx-auto font-light">Hubungi pusat bantuan tim dukungan kami untuk membantu merekomendasikan komoditas produk terbaik.</p>
            <div class="pt-2">
                <a href="#" class="inline-block w-full sm:w-auto text-center px-8 py-3.5 bg-white text-emerald-700 rounded-xl font-bold hover:bg-emerald-50 shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                    Hubungi Dukungan Kami
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection