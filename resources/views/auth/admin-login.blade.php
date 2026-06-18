<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Admin - UMKMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-950 to-emerald-950 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="#" class="text-3xl font-black tracking-tight text-emerald-400 drop-shadow-sm">{{ $gStoreName ?? 'UMKMart' }}</a>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Panel Administrator</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl shadow-emerald-950/40 p-8 border border-slate-100">
            <h2 class="text-base font-bold text-slate-800 mb-6 border-b border-slate-100 pb-3 tracking-tight">Autentikasi Admin</h2>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-rose-50 border border-rose-100 rounded-xl">
                    <ul class="list-inside text-xs font-medium text-rose-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Email Admin</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all @error('email') border-rose-300 bg-rose-50/30 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
                    @error('email')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all @error('password') border-rose-300 bg-rose-50/30 focus:ring-rose-500/10 focus:border-rose-500 @enderror">
                    @error('password')
                        <p class="text-rose-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500/20 border-slate-300 rounded-lg transition-all cursor-pointer">
                    <label for="remember" class="ml-2 block text-xs font-bold text-slate-500 select-none cursor-pointer">Ingat sesi saya</label>
                </div>

                <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold text-sm tracking-wide hover:bg-emerald-700 shadow-sm shadow-emerald-600/10 hover:shadow-md transition-all mt-6">
                    Masuk Sistem Admin
                </button>
            </form>

            <div class="mt-6 text-center pt-2">
                <a href="{{ route('home') }}" class="text-xs font-bold text-slate-400 hover:text-emerald-600 inline-flex items-center gap-1 transition-colors">
                    &larr; Kembali ke Beranda Utama
                </a>
            </div>
        </div>
    </div>
</body>
</html>