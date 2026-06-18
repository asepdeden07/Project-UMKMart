@extends('layouts.admin') {{-- Sesuaikan dengan nama layout sidebar admin kamu --}}

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
            &larr; Kembali ke Daftar Pesanan
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Pesanan #{{ $order->id }}</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-800">Daftar Produk</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    {{-- Sesuaikan path foto produk kamu jika ada --}}
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $item->product->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <span class="font-semibold text-sm text-gray-900">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                    <span class="font-bold text-gray-700">Total Pembayaran:</span>
                    <span class="text-xl font-extrabold text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Kelola Status</h3>
                <div class="mb-4">
                    <span class="text-xs text-gray-400 uppercase font-semibold">Status Saat Ini:</span>
                    <div class="mt-1">
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>

                {{-- FORM UPDATE STATUS --}}
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Ubah Status Ke:</label>
                        <select name="status" required class="w-full rounded-lg border-gray-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="" disabled selected>-- Pilih Status Baru --</option>
                            @if($order->status === 'pending')
                                <option value="confirmed">Confirm (Konfirmasi)</option>
                                <option value="cancelled">Cancel (Batalkan)</option>
                            @elseif($order->status === 'confirmed')
                                <option value="shipped">Ship (Kirim Barang)</option>
                                <option value="cancelled">Cancel (Batalkan)</option>
                            @elseif($order->status === 'shipped')
                                <option value="delivered">Deliver (Sudah Sampai)</option>
                            @else
                                <option value="" disabled>Status sudah final</option>
                            @endif
                        </select>
                    </div>

                    @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                        <button type="submit" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition shadow-sm">
                            Perbarui Status
                        </button>
                    @endif
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2">Informasi Pengiriman</h3>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Nama Pelanggan</span>
                    <p class="text-sm font-medium text-gray-800">{{ $order->user->name }}</p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Nomor Telepon</span>
                    <p class="text-sm font-medium text-gray-800">{{ $order->phone }}</p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Alamat Lengkap</span>
                    <p class="text-sm font-medium text-gray-700 mt-1 bg-gray-50 p-3 rounded-lg border border-gray-100 leading-relaxed">{{ $order->address }}</p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Catatan Pembeli</span>
                    <p class="text-sm font-medium text-gray-700 mt-1 {{ $order->notes ? 'bg-amber-50/50 border-amber-100 text-amber-800' : 'text-gray-400 italic' }} p-3 rounded-lg border border-dashed text-xs">
                        {{ $order->notes ?? 'Tidak ada catatan tambahan.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection