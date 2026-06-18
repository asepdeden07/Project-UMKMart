<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800">
    <!-- Inisialisasi State Alpine.js untuk Sidebar -->
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-50/60 relative">
        
        <!-- Backdrop Overlay (Hanya muncul di mobile saat sidebar terbuka) -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/30 z-40 lg:hidden" 
             style="display: none;">
        </div>

        <!-- Sidebar Utama -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 w-64 bg-white border-r border-emerald-100/80 shadow-sm flex flex-col z-50 lg:translate-x-0 transition-transform duration-300 ease-in-out">
            
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-emerald-100/60 bg-white">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 text-xl font-black text-slate-800 tracking-tight">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center shadow-inner border border-emerald-100">
                        <span class="text-base">🌿</span>
                    </div>
                    <span>{{ $gStoreName ?? 'UMKMart' }}</span>
                </a>
                
                <!-- Tombol Tutup Sidebar (Hanya di Mobile) -->
                <button @click="sidebarOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-slate-600 lg:hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigasi Menu -->
            <nav class="mt-6 flex-1 space-y-1 px-4 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/10 font-semibold' : 'text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v8"></path>
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/10 font-semibold' : 'text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4m0 0L4 7m16 0l-8 4m0 0l-8-4m0 0v10l8 4m0-4l8-4m-8 4v10l-8-4m0-4l8 4"></path>
                    </svg>
                    <span class="text-sm">Produk</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/10 font-semibold' : 'text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span class="text-sm">Kategori</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/10 font-semibold' : 'text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-sm">Pesanan</span>
                </a>

                <div class="my-4 border-t border-slate-100"></div>

                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/10 font-semibold' : 'text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm">Pengaturan Web</span>
                </a>

                <a href="{{ route('admin.profile.show') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.profile.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/10 font-semibold' : 'text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-sm">Profil Saya</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="block pt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all duration-200 font-medium text-sm group">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0 text-slate-400 group-hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>

            <!-- Profil User Singkat -->
            <div class="p-4 border-t border-emerald-100/60 bg-emerald-50/30">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-sm font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] font-semibold text-emerald-600 uppercase tracking-wider mt-0.5">Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Konten Utama (Menggunakan ml-0 dan lg:ml-64 agar responsif) -->
        <div class="ml-0 lg:ml-64 transition-all duration-300">
            
            <!-- Topbar / Header Utama -->
            <div class="bg-white/80 backdrop-blur-md border-b border-emerald-100/60 sticky top-0 z-30 px-6 py-4">
                <div class="flex justify-between items-center">
                    
                    <div class="flex items-center gap-4">
                        <!-- Tombol Hamburger (Hanya muncul di Layar Mobile/Tablet) -->
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 -ml-2 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-emerald-600 lg:hidden focus:outline-none transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">@yield('title', 'Dashboard')</h1>
                    </div>
                    
                </div>
            </div>

            <!-- Main Content Container -->
            <main class="p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-100 rounded-xl shadow-sm">
                        <div class="text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm">
                        <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-100 rounded-xl shadow-sm">
                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>