<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display list of all orders
     */
    public function index()
    {
        $query = Order::with('user', 'items.product');

        // Filter by status jika ada
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filter by date range jika ada
        if (request('from_date') && request('to_date')) {
            $query->whereBetween('created_at', [
                request('from_date') . ' 00:00:00',
                request('to_date') . ' 23:59:59',
            ]);
        }

        $orders = $query->latest('created_at')->paginate(15);

        // Get available statuses untuk filter dropdown
        $statuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Show order detail
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        // Validate transitions (hanya status tertentu yang boleh berubah)
        $validTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['shipped', 'cancelled'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => [],
        ];

        $newStatus = $request->status;
        $currentStatus = $order->status;

        // Check jika transisi valid
        if (!in_array($newStatus, $validTransitions[$currentStatus] ?? [])) {
            return back()->with('error', 'Perubahan status tidak diizinkan. Dari ' . $currentStatus . ' ke ' . $newStatus);
        }

        $order->update(['status' => $newStatus]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui menjadi: ' . $newStatus);
    }

    /**
 * Remove the specified order from storage.
 */
public function destroy(Order $order)
{
    // 1. Hapus dulu item produk di dalam pesanan tersebut (relasi items)
    $order->items()->delete();

    // 2. Hapus pesanan induknya
    $order->delete();

    return redirect()->route('admin.orders.index')
        ->with('success', 'Pesanan #' . $order->id . ' berhasil dihapus dari sistem.');
}
}

