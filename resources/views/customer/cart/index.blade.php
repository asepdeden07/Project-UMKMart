@extends('layouts.app')

@section('title', 'Keranjang Belanja - UMKMart')

@section('content')
    <section class="relative py-16 overflow-hidden text-white">
    @if(!empty($gHeroBackground))
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('{{ asset('storage/' . $gHeroBackground) }}');">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800"></div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-4xl font-extrabold tracking-tight mb-2">Keranjang Belanja</h1>
        <p class="text-emerald-100 font-light max-w-xl">
            Periksa dan kelola produk yang Anda ingin beli
        </p>
    </div>
</section>

    <section class="py-12 bg-emerald-50/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($cartItems->isEmpty())
                <div class="bg-white rounded-2xl border border-emerald-100/50 shadow-sm p-12 text-center max-w-lg mx-auto">
                    <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800 mb-1.5 tracking-tight">Keranjang Kosong</h2>
                    <p class="text-slate-400 text-sm mb-6">Anda belum memiliki produk apa pun di dalam keranjang belanja.</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-6 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 shadow-sm shadow-emerald-600/10 hover:shadow-md transition-all font-bold text-sm">
                        Lanjut Belanja
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-white rounded-2xl border border-emerald-100/30 shadow-sm p-4 hover:shadow-md hover:border-emerald-100 transition-all duration-300">
                                <div class="flex gap-4">
                                    <div class="w-24 h-24 bg-slate-50 border border-slate-100 rounded-xl flex-shrink-0 overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>

                                    <div class="flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-800 tracking-tight line-clamp-1">{{ $item->product->name }}</h3>
                                            <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $item->product->category->name }}</p>
                                        </div>
                                        <p class="text-sm font-bold text-emerald-600">
                                            Rp {{ number_format($item->price, 0, ',', '.') }} <span class="text-slate-400 font-normal text-xs">/ item</span>
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-end justify-between">
                                        <div class="flex items-center bg-slate-50 border border-slate-200/80 rounded-xl p-0.5">
                                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                                <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:shadow-sm disabled:opacity-30 disabled:hover:bg-transparent transition-all" @if($item->quantity <= 1) disabled @endif>
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <span class="px-2 text-xs font-bold text-slate-800 min-w-8 text-center select-none">{{ $item->quantity }}</span>
                                            
                                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-500 hover:bg-white hover:shadow-sm transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="text-right space-y-1">
                                            <p class="text-sm font-black text-slate-800 tracking-tight">
                                                Rp {{ number_format($item->getSubtotal(), 0, ',', '.') }}
                                            </p>
                                            <form method="POST" action="{{ route('cart.destroy', $item) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[11px] text-rose-500 hover:text-rose-600 font-bold tracking-wide uppercase transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="text-left pt-2">
                            <a href="{{ route('products.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center space-x-1 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                <span>Kembali Belanja</span>
                            </a>
                        </div>
                    </div>

                    <div class="lg:sticky lg:top-24 h-fit">
                        <div class="bg-white rounded-2xl border border-emerald-100/40 shadow-sm p-6">
                            <h2 class="text-base font-bold text-slate-800 mb-4 tracking-tight">Ringkasan Pesanan</h2>

                            <div class="space-y-3 border-b border-slate-100 pb-4 mb-4">
                                <div class="flex justify-between text-xs font-medium">
                                    <span class="text-slate-400">Jumlah Item</span>
                                    <span class="font-bold text-slate-700">{{ $itemCount }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-medium">
                                    <span class="text-slate-400">Subtotal Produk</span>
                                    <span class="font-bold text-slate-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-medium">
                                    <span class="text-slate-400">Biaya Pengiriman</span>
                                    <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md text-[10px]">Gratis</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mb-6 py-1">
                                <span class="text-sm font-bold text-slate-800">Total Harga</span>
                                <span class="text-xl font-black text-emerald-600 tracking-tight">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.show') }}" class="w-full block px-4 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-all text-center font-bold text-sm shadow-sm shadow-emerald-600/10 hover:shadow-md">
                                Lanjut ke Checkout
                            </a>

                            <p class="text-[11px] text-slate-400 text-center mt-4 leading-relaxed">
                                Alamat pengiriman dan opsi pembayaran tersedia di tahap selanjutnya.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection