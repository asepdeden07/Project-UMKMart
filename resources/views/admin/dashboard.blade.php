@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard</h2>
        <p class="text-sm text-slate-400 font-medium mt-0.5">Ringkasan performa toko dan aktivitas terbaru Anda</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-emerald-100/60 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-emerald-700/60 uppercase tracking-wider truncate">Total Produk</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 tracking-tight truncate">{{ $totalProducts }}</p>
                </div>
                <div class="w-11 h-11 sm:w-12 sm:h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 border border-emerald-100/30 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4m0 0L4 7m16 0l-8 4m0 0l-8-4m0 0v10l8 4m0-4l8-4m-8 4v10l-8-4m0-4l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-emerald-100/60 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-emerald-700/60 uppercase tracking-wider truncate">Total Pesanan</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 tracking-tight truncate">{{ $totalOrders }}</p>
                </div>
                <div class="w-11 h-11 sm:w-12 sm:h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-500 border border-slate-100 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-emerald-100/60 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-emerald-700/60 uppercase tracking-wider truncate">Total Pendapatan</p>
                    <p class="text-xl sm:text-2xl font-black text-slate-800 mt-1.5 tracking-tight truncate">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-11 h-11 sm:w-12 sm:h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-700 border border-emerald-100/30 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-emerald-100/60 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-emerald-700/60 uppercase tracking-wider truncate">Pesanan Tertunda</p>
                    <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 tracking-tight truncate">{{ $pendingOrders }}</p>
                </div>
                <div class="w-11 h-11 sm:w-12 sm:h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 border border-amber-100/30 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-emerald-100/60 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4.5 border-b border-emerald-100/60 flex items-center justify-between bg-white">
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">Pesanan Terbaru</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold transition-colors">
                        Lihat Semua
                    </a>
                </div>

                @if($recentOrders->isEmpty())
                    <div class="px-6 py-12 text-center text-slate-400 text-sm font-medium">
                        Belum ada pesanan masuk
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/70 border-b border-slate-100">
                                    <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Order ID</th>
                                    <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                                    <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Total</th>
                                    <th class="px-6 py-3.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach($recentOrders as $order)
                                    <tr class="hover:bg-slate-50/30 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-emerald-600 hover:text-emerald-700 font-bold text-sm">
                                                #{{ $order->id }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-700 whitespace-nowrap">
                                            {{ $order->user->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-black text-slate-800 whitespace-nowrap">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-full border
                                                {{ $order->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200/60' : '' }}
                                                {{ $order->status === 'confirmed' ? 'bg-sky-50 text-sky-700 border-sky-200/60' : '' }}
                                                {{ $order->status === 'shipped' ? 'bg-indigo-50 text-indigo-700 border-indigo-200/60' : '' }}
                                                {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-700 border-emerald-200/60' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-rose-50 text-rose-700 border-rose-200/60' : '' }}
                                            ">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-emerald-100/60 shadow-sm overflow-hidden">
                <div class="px-6 py-4.5 border-b border-emerald-100/60 bg-white">
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">Produk Terlaris</h2>
                </div>

                @if($topProducts->isEmpty())
                    <div class="px-6 py-8 text-center text-slate-400 text-sm font-medium">
                        Belum ada data penjualan
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($topProducts as $product)
                            <div class="px-6 py-4 hover:bg-slate-50/30 transition-colors duration-150">
                                <p class="text-sm font-semibold text-slate-800 truncate" title="{{ $product->name }}">{{ $product->name }}</p>
                                <div class="mt-1 flex items-center justify-between gap-2">
                                    <span class="text-xs text-slate-400 font-medium">{{ $product->total_sold ?? 0 }} terjual</span>
                                    <span class="text-sm font-bold text-emerald-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-emerald-100/60 shadow-sm overflow-hidden">
                <div class="px-6 py-4.5 border-b border-emerald-100/60 bg-white">
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">Stok Rendah</h2>
                </div>

                @if($lowStockProducts->isEmpty())
                    <div class="px-6 py-8 text-center text-slate-400 text-sm font-medium">
                        Semua stok aman dan terpenuhi
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($lowStockProducts as $product)
                            <div class="px-6 py-4 hover:bg-slate-50/30 transition-colors duration-150">
                                <p class="text-sm font-semibold text-slate-800 truncate" title="{{ $product->name }}">{{ $product->name }}</p>
                                <div class="mt-2 flex items-center justify-between gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                        Sisa {{ $product->stock }} stok
                                    </span>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold transition-colors">
                                        Restok →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection