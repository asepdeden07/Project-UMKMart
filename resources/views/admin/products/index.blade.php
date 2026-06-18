@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Produk</h2>
            <p class="text-sm text-slate-400 font-medium mt-0.5">Kelola semua produk di toko Anda</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto justify-center px-4 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 shadow-sm shadow-emerald-600/10 transition-all font-bold text-sm inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Tambah Produk</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-emerald-100/60 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
            <button type="submit" class="px-5 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl text-sm font-bold transition-all">Cari</button>
        </form>
    </div>

    @if($products->isEmpty())
        <div class="bg-white rounded-2xl border border-emerald-100/60 shadow-sm p-12 text-center max-w-md mx-auto">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-base font-bold text-slate-800 mb-1.5 tracking-tight">Belum ada produk</h3>
            <p class="text-slate-400 text-xs font-medium mb-6">Mulai tambahkan produk untuk toko Anda</p>
            <a href="{{ route('admin.products.create') }}" class="inline-block px-5 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-bold text-sm shadow-sm transition-all">
                Tambah Produk Pertama
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-emerald-100/60 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-44 sm:h-48 bg-slate-50 overflow-hidden relative border-b border-slate-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-4.5">
                            <span class="block text-[10px] font-bold text-emerald-700/60 uppercase tracking-wider mb-1.5">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base line-clamp-2 min-h-[2.5rem] tracking-tight leading-snug">{{ $product->name }}</h3>
                            
                            <div class="flex items-center justify-between gap-2 my-3">
                                <span class="text-sm sm:text-base font-black text-emerald-600 tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-[10px] font-bold bg-slate-50 text-slate-400 border border-slate-100 px-2 py-1 rounded-md">Stok: {{ $product->stock }}</span>
                            </div>

                            <p class="text-xs text-slate-400 line-clamp-2 min-h-[2rem] leading-relaxed mb-1">{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="p-4.5 pt-0">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 text-center py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl text-xs sm:text-sm font-bold transition-all">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="flex-1" onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    @endif
@endsection