@extends('layouts.admin')

@section('title', 'Daftar Pesanan Masuk')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Pesanan Masuk</h2>
    <p class="text-sm text-slate-400 font-medium mt-0.5">Pantau dan kelola seluruh transaksi pelanggan</p>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-sm font-medium shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-5 rounded-2xl border border-emerald-100/60 shadow-sm mb-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 px-3 py-2.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                <option value="">Semua Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 px-3 py-2 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 px-3 py-2 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
        </div>
        <div class="flex gap-2 pt-2 sm:pt-0">
            <button type="submit" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 shadow-sm shadow-emerald-600/10 transition-all text-center cursor-pointer">
                Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all text-center">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl border border-emerald-100/60 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">ID Order</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Total Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-slate-800 whitespace-nowrap">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-700 whitespace-nowrap">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 text-xs font-medium text-slate-400 whitespace-nowrap">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-sm font-black text-slate-800 whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl hover:bg-emerald-100 transition-all">
                                    Lihat Detail
                                </a>

                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan #{{ $order->id }} ini? Data yang dihapus tidak bisa dikembalikan.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 text-xs font-bold rounded-xl hover:bg-rose-100 transition-all cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm font-medium text-slate-400">
                            Tidak ada data pesanan yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection