<!-- Wrapper menggunakan x-data agar state menu mobile sinkron dengan overlay -->
<div x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50">
    
    <!-- OVERLAY BACKGROUND (Meredupkan layar belakang saat menu HP terbuka) -->
    <!-- Ketika area redup ini diklik, menu otomatis menutup kembali -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm md:hidden" 
         style="display: none;">
    </div>

    <!-- NAVBAR UTAMA -->
    <nav class="bg-white/95 backdrop-blur-md border-b border-emerald-100/60 relative z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo Website -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="block group">
                        @if($gWebsiteLogo)
                            <img src="{{ asset('storage/' . $gWebsiteLogo) }}" alt="Logo Website" class="h-10 sm:h-11 md:h-12 w-auto object-contain transform group-hover:scale-105 transition-transform duration-200">
                        @else
                            <img src="{{ asset('images/umkmart_logo.png') }}" alt="Logo Default" class="h-12 sm:h-16 md:h-32 w-auto object-contain transform group-hover:scale-105 transition-transform duration-200">
                        @endif
                    </a>
                </div>

                <!-- Menu Desktop (Hidden di HP) -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-bold {{ request()->routeIs('home') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }} transition-colors duration-200">Beranda</a>
                    <a href="{{ route('products.index') }}" class="text-sm font-bold {{ request()->routeIs('products.*') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }} transition-colors duration-200">Produk</a>
                </div>

                <!-- Menu Kanan (Keranjang & Akun) -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    @guest
                        <!-- Tombol Masuk/Daftar Desktop -->
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-colors duration-200">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm shadow-emerald-600/10 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                                Daftar
                            </a>
                        </div>
                    @else
                        @php
                            $userCart = auth()->user()->carts()->first();
                            $cartItemCount = $userCart ? $userCart->getItemCount() : 0;
                        @endphp
                        <!-- Keranjang Belanja (Tetap tampil di HP/Desktop demi kenyamanan) -->
                        <a href="{{ route('cart.index') }}" class="relative p-2.5 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @if($cartItemCount > 0)
                                <span class="absolute top-1.5 right-1.5 inline-flex items-center justify-center min-w-4 h-4 px-1 text-[10px] font-bold text-white bg-rose-500 rounded-full ring-2 ring-white">{{ min($cartItemCount, 99) }}</span>
                            @endif
                        </a>

                        <!-- Dropdown Akun Desktop -->
                        <div class="hidden md:block relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center space-x-2 p-1.5 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-200 focus:outline-none cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm font-bold hidden sm:inline">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 w-52 mt-2 bg-white rounded-xl shadow-xl border border-emerald-100/50 origin-top-right p-1.5 z-50"
                                 style="display: none;">
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                    Pesanan Saya
                                </a>
                                <div class="my-1 border-t border-slate-100"></div>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-medium text-rose-600 hover:bg-rose-50 rounded-lg transition-colors duration-150 cursor-pointer">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest

                    <!-- IKON HAMBURGER (Hanya muncul di HP) -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            :class="mobileMenuOpen ? 'bg-emerald-50 text-emerald-600 ring-2 ring-emerald-100' : 'text-slate-600 hover:text-emerald-600 hover:bg-emerald-50'"
                            class="md:hidden p-2.5 rounded-xl transition-all duration-200 focus:outline-none cursor-pointer flex items-center justify-center">
                        <!-- Garis Tiga (Muncul saat menu tutup) -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" :class="mobileMenuOpen ? 'hidden' : 'block'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <!-- Tanda Silang X (Muncul saat menu buka) -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" :class="mobileMenuOpen ? 'block' : 'hidden'" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- MENU DROPDOWN MOBILE (Muncul dari atas ke bawah) -->
        <div x-show="mobileMenuOpen" 
             @click.outside="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-emerald-100/50 bg-white shadow-xl max-h-[calc(100vh-4rem)] overflow-y-auto" 
             style="display: none;">
            <div class="px-4 pt-3 pb-5 space-y-1.5">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-bold {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-50' }} transition-all">Beranda</a>
                <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold {{ request()->routeIs('products.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-50' }} transition-all">Produk</a>
                
                <div class="my-2 border-t border-slate-100"></div>
                
                @guest
                    <!-- Menu Autentikasi HP -->
                    <div class="grid grid-cols-2 gap-3 p-1">
                        <a href="{{ route('login') }}" class="flex items-center justify-center py-3 text-sm font-bold text-emerald-600 hover:bg-emerald-50 rounded-xl border border-emerald-200 transition-all">Masuk</a>
                        <a href="{{ route('register') }}" class="flex items-center justify-center py-3 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition-all">Daftar</a>
                    </div>
                @else
                    <!-- Detail Informasi Pengguna Login di HP -->
                    <div class="px-4 py-2 bg-slate-50 rounded-xl mb-2 flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-600 text-white font-bold rounded-full flex items-center justify-center uppercase text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Akun Saya</p>
                            <p class="text-sm font-black text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('orders.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold {{ request()->routeIs('orders.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-50' }} transition-all">Pesanan Saya</a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="block pt-1">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-bold text-rose-600 hover:bg-rose-50 transition-all cursor-pointer flex items-center justify-between">
                            <span>Keluar</span>
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 01-3-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
</div>