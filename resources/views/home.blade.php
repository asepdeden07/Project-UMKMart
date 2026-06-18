@extends('layouts.app')

@section('title', 'Beranda - UMKMart')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="bg-emerald-800 text-emerald-50 border-b border-emerald-700/50 transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 text-center text-[11px] sm:text-xs md:text-sm font-medium tracking-wide leading-relaxed">
            <span class="inline-flex items-center justify-center flex-wrap gap-2">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                </span>
                <span>{{ $gHeaderDesc ?? 'Selamat Datang di UMKMart! Temukan produk lokal terbaik langsung dari tangan pertama.' }}</span>
            </span>
        </div>
    </div>

    <section x-data="{ mouseX: 0, mouseY: 0 }" 
         @mousemove="mouseX = $event.clientX; mouseY = $event.clientY"
         class="relative py-16 md:py-24 overflow-hidden text-white">
    
    <!-- Background Foto Dinamis -->
    @if($gHeroBackground)
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('{{ asset('storage/' . $gHeroBackground) }}');">
            <!-- Overlay Gelap (Penting agar teks terbaca) -->
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
    @else
        <!-- Fallback ke warna jika tidak ada foto -->
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800"></div>
    @endif

    <!-- Konten tetap sama (posisi di atas background) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <!-- Teks -->
            <div class="space-y-6 text-center md:text-left">
                <span class="inline-block px-3 py-1 bg-emerald-500/40 text-emerald-100 text-xs font-bold tracking-widest uppercase rounded-full border border-emerald-400/30 backdrop-blur-sm mb-2">
                    ✨ Tumbuh Bersama UMKM Indonesia
                </span>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mt-2 drop-shadow-md">
                    {!! $gHeroTitle ?? 'Belanja Produk Terbaik Di<br><span class="text-emerald-300">' . ($gStoreName ?? 'UMKMart') . '</span>' !!}
                </h1>
                <p class="text-base sm:text-xl text-white/90 max-w-lg mx-auto md:mx-0 font-light leading-relaxed mt-4">
                    {{ $gHeroSubTitle ?? 'Temukan ribuan produk berkualitas dari pelaku UMKM Indonesia dengan harga terbaik, langsung dari sumber terpercaya.' }}
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 pt-6">
                    <a href="{{ route('products.index') }}" class="px-6 py-3.5 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition shadow-lg">
                        Belanja Sekarang
                    </a>
                </div>
            </div>

            <!-- Image Banner (Samping teks) -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                @if($gHeroBanner)
                    <img src="{{ asset('storage/' . $gHeroBanner) }}" alt="Promo Banner" class="w-full h-[300px] sm:h-[400px] object-cover">
                @else
                    <div class="w-full h-[300px] sm:h-[400px] bg-white/10 flex items-center justify-center backdrop-blur-sm">
                        <span class="text-white/50">Banner Promo</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

    <section id="categories" class="py-16 md:py-24 bg-gray-50 overflow-hidden relative">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-emerald-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-12 md:mb-16 reveal-up">
                <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">Kategori Pilihan</h2>
                <p class="text-gray-500 text-sm md:text-lg">Pilih dan jelajahi berbagai rumpun kategori produk terbaik sesuai kebutuhan Anda</p>
                <div class="w-12 h-1 bg-emerald-500 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-8 stagger-grid">
                @forelse($categories as $category)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 p-5 md:p-6 text-center cursor-pointer group transform hover:-translate-y-1.5">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50 group-hover:bg-emerald-500 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 shadow-inner">
                            <svg class="w-6 h-6 md:w-8 md:h-8 text-emerald-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-1 group-hover:text-emerald-600 transition-colors duration-200 truncate">{{ $category->name }}</h3>
                        <p class="text-[10px] md:text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full inline-block">{{ $category->products_count }} Produk</p>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-8">Belum ada kategori tersedia.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 reveal-up">
                <div class="text-center md:text-left max-w-2xl">
                    <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">Produk Unggulan</h2>
                    <p class="text-gray-500 text-sm md:text-lg">Produk-produk kurasi pilihan dengan jaminan mutu dan kualitas terbaik</p>
                    <div class="w-12 h-1 bg-emerald-500 rounded-full mt-4 mx-auto md:mx-0"></div>
                </div>
                <div class="hidden md:block">
                     <a href="{{ route('products.index') }}" class="text-emerald-600 font-bold hover:text-emerald-800 transition-colors flex items-center group">
                        Lihat Semua 
                        <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                     </a>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 stagger-grid">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full hover:-translate-y-1">
                        
                        <div class="relative overflow-hidden bg-gray-50 aspect-square">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-in-out">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 p-4">
                                    <svg class="w-8 h-8 sm:w-12 sm:h-12 mb-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-[10px] sm:text-xs text-center">Tidak ada gambar</span>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <div class="absolute bottom-2 left-2 sm:bottom-3 sm:left-3 bg-white/95 backdrop-blur-sm text-gray-900 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg text-xs sm:text-sm font-black shadow-md border border-white/40">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="p-3 sm:p-4 flex flex-col flex-grow">
                            <span class="text-[9px] sm:text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1 block truncate">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            <h3 class="text-xs sm:text-base font-bold text-gray-800 line-clamp-2 group-hover:text-emerald-600 transition-colors duration-200 min-h-[32px] sm:min-h-[44px] leading-snug">
                                {{ $product->name }}
                            </h3>
                            
                            <p class="text-gray-500 text-xs mt-1 mb-4 line-clamp-2 leading-relaxed hidden sm:block">
                                {{ $product->description }}
                            </p>

                            <div class="mt-auto pt-3 border-t border-gray-50">
                                @if(auth()->check())
                                    <form method="POST" action="{{ route('cart.add') }}" class="w-full">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white py-2 sm:py-2.5 px-2 rounded-xl shadow-sm transition-all duration-300 font-bold text-xs flex items-center justify-center space-x-1 sm:space-x-2 group/btn">
                                            <svg class="w-4 h-4 transform group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            <span class="truncate">+ Keranjang</span>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full bg-gray-50 hover:bg-emerald-50 text-gray-600 hover:text-emerald-700 py-2 sm:py-2.5 px-2 rounded-xl text-center font-bold text-xs transition-all duration-300 border border-gray-200 hover:border-emerald-200 truncate">
                                        Masuk / Beli
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada produk unggulan yang tersedia.
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-8 md:hidden">
                <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-emerald-50 text-emerald-700 rounded-xl font-bold text-sm border border-emerald-100 shadow-sm active:scale-95 transition-transform">
                    <span>Lihat Semua Produk</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-emerald-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 24px 24px;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-12 md:mb-16 reveal-up">
                <h2 class="text-2xl md:text-4xl font-extrabold tracking-tight mb-3">
                    {{ $gWhyChooseTitle ?? 'Mengapa Memilih ' . ($gStoreName ?? 'UMKMart') . '?' }}
                </h2>
                <div class="w-12 h-1 bg-emerald-400 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-12 stagger-grid">
                <div class="bg-emerald-800/50 backdrop-blur-md p-6 md:p-8 rounded-2xl md:rounded-3xl border border-emerald-700/50 text-center hover:-translate-y-1.5 transition-transform duration-300">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500 text-white rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-900/50">
                        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold mb-2 text-white">{{ $gFeature1Title ?? 'Pengiriman Cepat' }}</h3>
                    <p class="text-emerald-100/80 text-xs md:text-sm leading-relaxed">{{ $gFeature1Desc ?? 'Pengiriman terjadwal dan kilat dalam 1-3 hari kerja aman sampai ke seluruh pelosok Indonesia.' }}</p>
                </div>

                <div class="bg-emerald-800/50 backdrop-blur-md p-6 md:p-8 rounded-2xl md:rounded-3xl border border-emerald-700/50 text-center hover:-translate-y-1.5 transition-transform duration-300 md:-translate-y-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500 text-white rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-900/50">
                        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold mb-2 text-white">{{ $gFeature2Title ?? 'Harga Terbaik' }}</h3>
                    <p class="text-emerald-100/80 text-xs md:text-sm leading-relaxed">{{ $gFeature2Desc ?? 'Potongan harga kompetitif tangan pertama dengan jaminan kualitas komoditas yang bermutu tinggi.' }}</p>
                </div>

                <div class="bg-emerald-800/50 backdrop-blur-md p-6 md:p-8 rounded-2xl md:rounded-3xl border border-emerald-700/50 text-center hover:-translate-y-1.5 transition-transform duration-300">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-500 text-white rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-900/50">
                        <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold mb-2 text-white">{{ $gFeature3Title ?? 'Aman & Terpercaya' }}</h3>
                    <p class="text-emerald-100/80 text-xs md:text-sm leading-relaxed">{{ $gFeature3Desc ?? 'Ekosistem transaksi transparan, terlindungi secara mutakhir demi jaminan kenyamanan belanja 100%.' }}</p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <style>
        .reveal-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal-up.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        .stagger-grid > div {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        .stagger-grid.active > div {
            opacity: 1;
            transform: translateY(0);
        }
        .stagger-grid > div:nth-child(1) { transition-delay: 0.1s; }
        .stagger-grid > div:nth-child(2) { transition-delay: 0.2s; }
        .stagger-grid > div:nth-child(3) { transition-delay: 0.3s; }
        .stagger-grid > div:nth-child(4) { transition-delay: 0.4s; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-up, .stagger-grid').forEach((element) => {
                observer.observe(element);
            });
        });
    </script>
@endsection