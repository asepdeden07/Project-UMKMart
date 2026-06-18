@extends('layouts.app')

@section('title', 'Detail Pesanan - UMKMart')

@section('content')
    <!-- Page Header -->
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
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight mb-2">Detail Pesanan</h1>
                <p class="text-emerald-100 font-light">Order #{{ $order->id }}</p>
            </div>
            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-colors duration-200 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</section>

    <!-- Order Details -->
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Order Status Timeline -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Status Pesanan</h2>
                
                <div class="flex items-center justify-between">
                    @php
                        $statuses = [
                            'pending' => ['label' => 'Menunggu', 'icon' => 'clock'],
                            'confirmed' => ['label' => 'Dikonfirmasi', 'icon' => 'check'],
                            'shipped' => ['label' => 'Dikirim', 'icon' => 'truck'],
                            'delivered' => ['label' => 'Terkirim', 'icon' => 'checkCircle'],
                        ];
                        $statusOrder = ['pending', 'confirmed', 'shipped', 'delivered'];
                        $currentStatusIndex = array_search($order->status, $statusOrder);
                    @endphp
                    
                    @foreach(['pending', 'confirmed', 'shipped', 'delivered'] as $index => $status)
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white mb-2
                                @if($currentStatusIndex >= $index) bg-emerald-600 @else bg-gray-300 @endif
                            ">
                                @switch($status)
                                    @case('pending')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @break
                                    @case('confirmed')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        @break
                                    @case('shipped')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                        @break
                                    @case('delivered')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @break
                                @endswitch
                            </div>
                            <p class="text-xs font-medium text-gray-700 text-center">
                                @switch($status)
                                    @case('pending') Menunggu @break
                                    @case('confirmed') Dikonfirmasi @break
                                    @case('shipped') Dikirim @break
                                    @case('delivered') Terkirim @break
                                @endswitch
                            </p>
                        </div>
                        
                        @if($index < 3)
                            <div class="h-1 flex-1 mx-2 mb-8
                                @if($currentStatusIndex > $index) bg-emerald-600 @else bg-gray-300 @endif
                            "></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Order Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Left: Order Items -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Produk Pesanan</h2>

                    <div class="space-y-4 border-b border-gray-100 pb-6 mb-6">
                        @foreach($order->items as $item)
                            <div class="flex gap-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkir</span>
                            <span class="font-medium text-gray-900">Rp 0</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 mt-3 flex justify-between text-base font-bold">
                            <span>Total</span>
                            <span class="text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Shipping Information -->
                <div class="space-y-6">
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Alamat Pengiriman</h3>
                        <div class="space-y-2 text-sm">
                            <div>
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Nama</p>
                                <p class="text-gray-900 font-medium">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Telepon</p>
                                <p class="text-gray-900 font-medium">{{ $order->phone }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Alamat</p>
                                <p class="text-gray-900">{{ $order->address }}</p>
                            </div>
                            @if($order->notes)
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Catatan</p>
                                    <p class="text-gray-900">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Informasi Pesanan</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order ID</span>
                                <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal</span>
                                <span class="font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                    @if($order->status === 'pending') bg-orange-100 text-orange-800
                                    @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'shipped') bg-cyan-100 text-cyan-800
                                    @elseif($order->status === 'delivered') bg-emerald-100 text-emerald-800
                                    @else bg-red-100 text-red-800
                                    @endif
                                ">
                                    @switch($order->status)
                                        @case('pending') Menunggu @break
                                        @case('confirmed') Dikonfirmasi @break
                                        @case('shipped') Dikirim @break
                                        @case('delivered') Terkirim @break
                                        @default {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </section>
@endsection
