<footer class="bg-gray-950 text-gray-400 pt-16 pb-8 border-t border-emerald-950">
    <div class="max-w-7xl mx-auto px-4 sm:gg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            
            <div class="space-y-4">
                @if(!empty($gWebsiteLogo))
                    <img 
                src="{{ asset('storage/' . $gWebsiteLogo) }}" 
                alt="Logo Website" 
                class="h-10 sm:h-11 md:h-12 w-auto object-contain transform group-hover:scale-105 transition-transform duration-200"
            >
                @else
                    <span class="text-2xl font-black tracking-tight text-white">{{ $gStoreName ?? 'UMKMart' }}</span>
                @endif
                
                <p class="text-sm text-gray-400 leading-relaxed">
                    {{ $gFooterDesc ?? 'UMKMart membantu memajukan usaha mikro kecil dan menengah secara digital dengan jaminan kualitas terbaik langsung dari pelaku usaha.' }}
                </p>
            </div>

            <div class="space-y-3">
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="leading-relaxed">{{ $gFooterAddress ?? 'Alamat belum diatur' }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L22 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ $gFooterEmail ?? '#' }}" class="hover:text-emerald-400 transition-colors break-all">{{ $gFooterEmail ?? 'Email belum diatur' }}</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span class="hover:text-emerald-400 transition-colors">{{ $gFooterPhone ?? 'No. Telp belum diatur' }}</span>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">Navigasi Toko</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#categories" class="hover:text-emerald-400 transition-colors duration-200 block">Kategori Pilihan</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-emerald-400 transition-colors duration-200 block">Semua Produk</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">Jam Operasional</h4>
                <p class="text-sm leading-relaxed text-gray-400 mb-3">Kami siap melayani transaksi dan pertanyaan Anda.</p>
                <div class="bg-gray-900/60 border border-emerald-950 rounded-xl p-3 text-xs space-y-1.5 text-gray-300">
                    <p class="flex justify-between"><span>Jadwal:</span> <span class="text-emerald-400 font-medium">{{ $gFooterOpenHours ?? 'Belum diatur' }}</span></p>
                    <p class="flex justify-between"><span>Minggu / Libur:</span> <span class="text-red-400 font-medium">Tutup</span></p>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-900 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
            <p class="text-center sm:text-left">&copy; {{ date('Y') }} {{ $gStoreName ?? 'UMKMart' }}. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white transition-colors duration-200">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition-colors duration-200">Kebijakan Privasi</a>
            </div>
        </div>

    </div>
</footer>