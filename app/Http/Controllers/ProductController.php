<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai sort dari query string URL (?sort=...)
        $sort = $request->get('sort');

        // Buat base query dasar
        $query = Product::with('category');

        // Logika Pengurutan (Sorting)
        if ($sort === 'price-low') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price-high') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'popular') {
            // Asumsi paling populer dinilai dari produk yang paling sering dimasukkan ke keranjang/dibeli
            // Jika belum ada logikanya, diurutkan berdasarkan sisa stok terbanyak atau field views jika ada.
            // Sementara diurutkan berdasarkan id terbesar/acak jika belum memiliki kolom view_count
            $query->orderBy('id', 'desc'); 
        } else {
            // Default sorting: Terbaru
            $query->latest();
        }

        // Ambil data dengan pagination (Otomatis memotong data jika lebih dari 12)
        // appends() berfungsi agar ketika pindah halaman pagination, filter sortirnya tidak hilang
        $products = $query->paginate(12)->appends(['sort' => $sort]);

        return view('products.index', compact('products'));
    }
}