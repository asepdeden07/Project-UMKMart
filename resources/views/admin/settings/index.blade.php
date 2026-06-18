@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengaturan Tampilan Website</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola branding visual template toko online Anda di sini.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-2">Logo Website</h2>
                <p class="text-xs text-gray-500 mb-6">Akan muncul otomatis pada bagian Navbar dan Footer aplikasi.</p>
                
                <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex flex-col items-center justify-center min-h-[150px]">
                    @if($websiteLogo)
                        <img src="{{ asset('storage/' . $websiteLogo) }}" alt="Logo Website" class="max-h-20 w-auto object-contain mb-3">
                        <form action="{{ route('admin.settings.logo.destroy') }}" method="POST" onsubmit="return confirm('Hapus logo saat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-semibold underline">Hapus Logo</button>
                        </form>
                    @else
                        <div class="text-center">
                            <span class="text-xs text-gray-400 block mb-1">Belum ada logo dikonfigurasi</span>
                            <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-mono">DEFAULT: Teks Nama Aplikasi</span>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <input type="file" name="website_logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 file:cursor-pointer hover:file:bg-emerald-100">
                    @error('website_logo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-emerald-600 text-white text-sm font-semibold py-2.5 rounded-xl hover:bg-emerald-700 transition">Perbarui Logo</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-2">Hero Banner Utama</h2>
                <p class="text-xs text-gray-500 mb-6">Banner besar berukuran lebar yang tampil di beranda depan.</p>
                
                <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex flex-col items-center justify-center min-h-[150px]">
                    @if($heroBanner)
                        <img src="{{ asset('storage/' . $heroBanner) }}" alt="Hero Banner" class="max-h-24 w-full object-cover rounded-lg mb-3 shadow-sm">
                        <form action="{{ route('admin.settings.banner.destroy') }}" method="POST" onsubmit="return confirm('Hapus banner saat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-semibold underline">Hapus Banner</button>
                        </form>
                    @else
                        <div class="text-center">
                            <span class="text-xs text-gray-400 block mb-1">Belum ada banner dikonfigurasi</span>
                            <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-mono">DEFAULT: Solid Background / Sliders</span>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('admin.settings.banner.update') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <input type="file" name="hero_banner" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 file:cursor-pointer hover:file:bg-emerald-100">
                    @error('hero_banner')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-emerald-600 text-white text-sm font-semibold py-2.5 rounded-xl hover:bg-emerald-700 transition">Perbarui Banner</button>
            </form>

            <form action="{{ route('admin.settings.updateHeroBackground') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
        <label class="block text-xs font-bold uppercase text-gray-700">Upload Background Hero</label>
        <input type="file" name="hero_background" class="w-full p-2 border rounded-xl">
    </div>
    <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-xl text-sm font-bold">
        Simpan Background
    </button>
</form>
        </div>

    </div>

    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Pengaturan Informasi Teks</h2>
        <p class="text-xs text-gray-500 mb-6">Kelola deskripsi teks singkat yang muncul di area Header (atas) dan Footer (bawah) website.</p>

        <form action="{{ route('admin.settings.details.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('POST') 
    <div>
        <label for="header_description" class="block text-xs font-bold uppercase text-gray-700 mb-1">Deskripsi Header</label>
        <textarea name="header_description" id="header_description" class="w-full border p-2 rounded-xl">{{ old('header_description', $headerDescription) }}</textarea>
    </div>

    <div>
        <label for="footer_description" class="block text-xs font-bold uppercase text-gray-700 mb-1">Deskripsi Footer</label>
        <textarea name="footer_description" id="footer_description" class="w-full border p-2 rounded-xl">{{ old('footer_description', $footerDescription) }}</textarea>
    </div>


    <div class="pt-6 border-t border-gray-100">
        <h3 class="text-sm font-bold text-emerald-700 uppercase tracking-wider mb-4">Identitas & Kontak Toko</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label for="store_name" class="block text-xs font-bold uppercase text-gray-700 mb-1">Nama Toko / Perusahaan</label>
                <input type="text" name="store_name" id="store_name" 
                       value="{{ old('store_name', $storeName) }}" 
                       class="w-full border border-gray-200 p-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 transition" placeholder="Contoh: UMKMart">
                @error('store_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="footer_open_hours" class="block text-xs font-bold uppercase text-gray-700 mb-1">Jam Operasional</label>
                <input type="text" name="footer_open_hours" id="footer_open_hours" 
                       value="{{ old('footer_open_hours', $footerOpenHours) }}" 
                       class="w-full border border-gray-200 p-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 transition" placeholder="Senin - Sabtu (08:00 - 17:00 WIB)">
                @error('footer_open_hours') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="footer_phone" class="block text-xs font-bold uppercase text-gray-700 mb-1">No. WhatsApp / Telepon</label>
                <input type="text" name="footer_phone" id="footer_phone" 
                       value="{{ old('footer_phone', $footerPhone) }}" 
                       class="w-full border border-gray-200 p-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 transition" placeholder="+62 812-xxxx-xxxx">
                @error('footer_phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="footer_email" class="block text-xs font-bold uppercase text-gray-700 mb-1">Email Support</label>
                <input type="email" name="footer_email" id="footer_email" 
                       value="{{ old('footer_email', $footerEmail) }}" 
                       class="w-full border border-gray-200 p-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 transition" placeholder="support@umkmart.com">
                @error('footer_email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="footer_address" class="block text-xs font-bold uppercase text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="footer_address" id="footer_address" rows="3" 
                          class="w-full border border-gray-200 p-2.5 rounded-xl text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 transition" placeholder="Jl. Anggrek No. 12, Kecamatan... ">{{ old('footer_address', $footerAddress) }}</textarea>
                @error('footer_address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <button type="submit" class="bg-emerald-600 text-white font-bold text-sm px-6 py-2.5 rounded-xl hover:bg-emerald-700 transition">
            Simpan Perubahan
        </button>
    </div>
</form>
    </div>

</div>
@endsection