<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - UMKMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-emerald-50/40 font-sans text-slate-800 antialiased">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="text-3xl font-black tracking-tight text-emerald-700 hover:text-emerald-800 transition-colors">
                    {{ $gStoreName ?? 'UMKMart' }}<span class="text-emerald-500">.</span>
                </a>
                <p class="text-emerald-800/60 text-sm font-medium mt-1.5">Mini Marketplace untuk UMKM Indonesia</p>
            </div>

            <div class="bg-white rounded-2xl border border-emerald-100/80 shadow-sm p-8">
                <h2 class="text-xl font-bold text-slate-800 mb-6 tracking-tight">Buat Akun Baru</h2>

                @if ($errors->any())
                    <div class="mb-5 p-4 bg-rose-50 border border-rose-100 rounded-xl">
                        <ul class="list-inside list-disc text-xs font-semibold text-rose-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all @error('name') border-rose-300 bg-rose-50/30 focus:ring-rose-500/20 focus:border-rose-500 @enderror">
                        @error('name')
                            <p class="text-rose-600 text-xs font-medium mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all @error('email') border-rose-300 bg-rose-50/30 focus:ring-rose-500/20 focus:border-rose-500 @enderror">
                        @error('email')
                            <p class="text-rose-600 text-xs font-medium mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all @error('password') border-rose-300 bg-rose-50/30 focus:ring-rose-500/20 focus:border-rose-500 @enderror">
                        @error('password')
                            <p class="text-rose-600 text-xs font-medium mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all @error('password_confirmation') border-rose-300 bg-rose-50/30 focus:ring-rose-500/20 focus:border-rose-500 @enderror">
                        @error('password_confirmation')
                            <p class="text-rose-600 text-xs font-medium mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100 text-xs text-slate-500 space-y-1">
                        <p class="font-bold text-slate-600">Syarat kata sandi:</p>
                        <ul class="list-disc list-inside space-y-0.5 pl-0.5">
                            <li>Minimal 8 karakter</li>
                            <li>Kombinasi huruf dan angka</li>
                        </ul>
                    </div>

                    <div class="flex items-start pt-1">
                        <input type="checkbox" id="agree" name="agree" required 
                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500/30 border-slate-200 rounded mt-0.5 transition-all cursor-pointer">
                        <label for="agree" class="ml-2 block text-xs font-medium text-slate-500 leading-relaxed select-none cursor-pointer">
                            Saya setuju dengan <a href="#" class="text-emerald-600 font-bold hover:text-emerald-700 transition-colors">Syarat & Ketentuan</a> dan <a href="#" class="text-emerald-600 font-bold hover:text-emerald-700 transition-colors">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 text-white py-2.5 rounded-xl font-bold text-sm shadow-sm shadow-emerald-600/10 hover:bg-emerald-700 hover:shadow-md transition-all duration-200 mt-2 cursor-pointer">
                        Buat Akun
                    </button>
                </form>

                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white text-slate-400 font-medium">atau</span>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-500 font-medium">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:text-emerald-700 transition-colors ml-1">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <div class="mt-6 bg-emerald-50/80 rounded-2xl p-4 border border-emerald-100/60 shadow-sm">
                <p class="text-xs leading-relaxed text-emerald-800">
                    <strong class="font-bold uppercase tracking-wider text-[10px] text-emerald-900 block mb-2">✓ Keuntungan berbelanja di {{ $gStoreName ?? 'UMKMart' }}:</strong>
                    <span class="block mb-0.5">• Harga terbaik langsung dari UMKM Indonesia</span>
                    <span class="block mb-0.5">• Pengiriman cepat dan aman (1-3 hari kerja)</span>
                    <span class="block">• Layanan garansi perlindungan uang kembali 100%</span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>