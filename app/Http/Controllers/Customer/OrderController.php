<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display list of user's orders
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('items.product')
            ->latest('created_at')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display order detail
     */
    public function show(Order $order)
    {
        // Authorize: only user yang punya order bisa lihat
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Eager load items dan products
        $order->load('items.product');

        return view('customer.orders.show', compact('order'));
    }
}

