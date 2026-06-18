@extends('layouts.app')

@section('title', 'Pesanan Saya - UMKMart')

@section('content')
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
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Pesanan Saya</h1>
        <p class="text-sm text-emerald-100 font-light mt-2">Lihat riwayat dan status pesanan Anda</p>
    </div>
</section>

    <!-- Orders Content -->
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($orders->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h2>
                    <p class="text-gray-500 mb-6">Anda belum melakukan pembelian. Mari mulai berbelanja sekarang!</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors duration-200 font-medium">
                        Belanja Sekarang
                    </a>
                </div>
            @else
                <!-- Orders List -->
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                            <!-- Header -->
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">
                                        Order ID: <span class="text-gray-900">#{{ $order->id }}</span>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>

                                <!-- Status Badge -->
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                        @if($order->status === 'pending') bg-orange-100 text-orange-800
                                        @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'shipped') bg-cyan-100 text-cyan-800
                                        @elseif($order->status === 'delivered') bg-emerald-100 text-emerald-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                    ">
                                        @switch($order->status)
                                            @case('pending') Menunggu Konfirmasi @break
                                            @case('confirmed') Dikonfirmasi @break
                                            @case('shipped') Sedang Dikirim @break
                                            @case('delivered') Terkirim @break
                                            @case('cancelled') Dibatalkan @break
                                            @default {{ ucfirst($order->status) }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>

                            <!-- Items Preview -->
                            <div class="px-6 py-4 border-b border-gray-100">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Produk</p>
                                <div class="space-y-2">
                                    @foreach($order->items->take(2) as $item)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-700">{{ $item->product->name }}</span>
                                            <span class="text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 2)
                                        <p class="text-sm text-emerald-600 font-medium">+{{ $order->items->count() - 2 }} produk lainnya</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Total Pembayaran</p>
                                    <p class="text-lg font-extrabold text-emerald-600">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('orders.show', $order) }}" class="px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 font-medium text-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
