<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard dengan statistik
     */
    public function index()
    {
        // Total statistics
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total_price');
        $pendingOrders = Order::pending()->count();

        // Recent orders
        $recentOrders = Order::with('user', 'items.product')
            ->latest('created_at')
            ->limit(5)
            ->get();

        // Top selling products
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'recentOrders',
            'topProducts',
            'lowStockProducts'
        ));
    }
}

