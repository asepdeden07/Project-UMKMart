@extends('layouts.app')

@section('title', 'Checkout - UMKMart')

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
        <h1 class="text-4xl font-extrabold tracking-tight mb-2">Checkout</h1>
        <p class="text-emerald-100 font-light max-w-xl">
            Lengkapi data pengiriman untuk menyelesaikan pesanan Anda
        </p>
    </div>
</section>

    <!-- Checkout Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('checkout.store') }}" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Form Section -->
                    <div class="lg:col-span-2">
                        <!-- Shipping Information -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Pengiriman</h2>

                            <div class="space-y-5">
                                <!-- Name (Read-only) -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap
                                    </label>
                                    <input type="text" id="name" value="{{ $user->name }}" disabled
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>

                                <!-- Email (Read-only) -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email
                                    </label>
                                    <input type="email" id="email" value="{{ $user->email }}" disabled
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 @error('phone') border-red-500 @enderror"
                                           placeholder="08xxxxxxxxxx" required>
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="address" name="address" rows="4"
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200 @error('address') border-red-500 @enderror"
                                              placeholder="Jalan, Nomor, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos"
                                              required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Catatan Tambahan (Opsional)
                                    </label>
                                    <textarea id="notes" name="notes" rows="3"
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition duration-200"
                                              placeholder="Contoh: Hubungi saya sebelum pengiriman...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-6">Metode Pengiriman</h2>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-emerald-50 transition-colors duration-150 checked:border-emerald-500">
                                    <input type="radio" name="shipping_method" value="regular" checked class="w-4 h-4 text-emerald-600">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-900">Regular Shipping</p>
                                        <p class="text-sm text-gray-500">3-5 hari kerja</p>
                                    </div>
                                    <span class="font-bold text-gray-900">Rp 0</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Sticky -->
                    <div class="lg:sticky lg:top-24 h-fit">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                            <h2 class="text-lg font-bold text-gray-900">Ringkasan Pesanan</h2>

                            <!-- Items -->
                            <div class="space-y-3 max-h-64 overflow-y-auto border-b border-gray-100 pb-4">
                                @foreach($cartItems as $item)
                                    <div class="flex justify-between text-sm">
                                        <div>
                                            <p class="text-gray-700">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="font-medium text-gray-900">Rp {{ number_format($item->getSubtotal(), 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Summary -->
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ongkir</span>
                                    <span class="font-medium text-gray-900">Rp 0</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex justify-between items-center mb-6">
                                    <span class="font-bold text-gray-900">Total Pembayaran</span>
                                    <span class="text-2xl font-extrabold text-emerald-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full px-4 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors duration-200 font-bold shadow-lg shadow-emerald-200">
                                    Buat Pesanan
                                </button>

                                <!-- Back Button -->
                                <a href="{{ route('cart.index') }}" class="block text-center mt-3 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                                    Kembali ke Keranjang
                                </a>
                            </div>

                            <!-- Security Info -->
                            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-xs text-emerald-800">
                                <p class="flex items-start space-x-2">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Data Anda aman dan terlindungi dengan enkripsi tingkat enterprise</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
