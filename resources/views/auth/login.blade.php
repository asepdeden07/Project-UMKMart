<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - UMKMart</title>
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
                <h2 class="text-xl font-bold text-slate-800 mb-6 tracking-tight">Masuk ke Akun Anda</h2>

                @if ($errors->any())
                    <div class="mb-5 p-4 bg-rose-50 border border-rose-100 rounded-xl">
                        <ul class="list-inside list-disc text-xs font-semibold text-rose-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
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

                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500/30 border-slate-200 rounded transition-all cursor-pointer">
                            <label for="remember" class="ml-2 block text-xs font-bold text-slate-500 select-none cursor-pointer">Ingat saya</label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 text-white py-2.5 rounded-xl font-bold text-sm shadow-sm shadow-emerald-600/10 hover:bg-emerald-700 hover:shadow-md transition-all duration-200 mt-2 cursor-pointer">
                        Masuk
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
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:text-emerald-700 transition-colors ml-1">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>