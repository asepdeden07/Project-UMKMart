<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan model Product di-import
use App\Models\Category; // Pastikan model Category di-import
use App\Models\WebsiteSetting; // BARU: Jangan lupa import model WebsiteSetting kamu
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil 6 produk terbaru asli dari database beserta data kategorinya
        $products = Product::with('category')
            ->latest()
            ->take(6)
            ->get();

        // 2. Ambil semua kategori asli dari database dan hitung jumlah produk di dalamnya
        $categories = Category::withCount('products')->get();

        // 3. BARU: Ambil semua data teks & gambar dari sistem Key-Value WebsiteSetting
        $gStoreName = WebsiteSetting::get('store_name', 'UMKMart'); // 'UMKMart' adalah cadangan jika database kosong
        $gFooterAddress = WebsiteSetting::get('footer_address');
        $gFooterEmail = WebsiteSetting::get('footer_email');
        $gFooterPhone = WebsiteSetting::get('footer_phone');
        $gFooterOpenHours = WebsiteSetting::get('footer_open_hours');
        $gHeaderDesc = WebsiteSetting::get('header_description');
        $gFooterDesc = WebsiteSetting::get('footer_description');
        $gWebsiteLogo = WebsiteSetting::get('website_logo');
        $gHeroBanner = WebsiteSetting::get('hero_banner');

        // 4. Kirim semua data asli dan variabel global baru ke view 'home' menggunakan compact()
        return view('home', compact(
            'products', 
            'categories',
            'gStoreName',
            'gFooterAddress',
            'gFooterEmail',
            'gFooterPhone',
            'gFooterOpenHours',
            'gHeaderDesc',
            'gFooterDesc',
            'gWebsiteLogo',
            'gHeroBanner'
        ));
    }
}