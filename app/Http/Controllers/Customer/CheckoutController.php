<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout form
     */
    public function show()
    {
        $user = auth()->user();
        $cart = $user->carts()->first();

        // Check jika cart kosong
        if (!$cart || $cart->isEmpty()) {
            return redirect()->route('products.index')
                ->with('error', 'Keranjang belanja kosong');
        }

        $cartItems = $cart->items()->with('product')->get();
        $total = $cart->getTotal();

        return view('customer.checkout.show', compact('cartItems', 'total', 'user'));
    }

    /**
     * Process checkout - Create order dan order items
     */
    public function store(CheckoutRequest $request)
    {
        $user = auth()->user();
        $cart = $user->carts()->first();

        // Validate cart tidak kosong
        if (!$cart || $cart->isEmpty()) {
            return redirect()->route('products.index')
                ->with('error', 'Keranjang belanja kosong');
        }

        try {
            // Use database transaction untuk ensure data consistency
            $order = DB::transaction(function () use ($user, $cart, $request) {
                $cartItems = $cart->items()->with('product')->get();
                $totalPrice = 0;

                // Loop setiap cart item
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;

                    // Validate stock tersedia (using row lock to prevent race condition)
                    $lockedProduct = DB::table('products')
                        ->where('id', $product->id)
                        ->lockForUpdate()
                        ->first();

                    if ($lockedProduct->stock < $cartItem->quantity) {
                        throw new \Exception('Stok untuk produk ' . $product->name . ' tidak cukup');
                    }

                    // Calculate total
                    $subtotal = $cartItem->price * $cartItem->quantity;
                    $totalPrice += $subtotal;

                    // Deduct stock dari product
                    $product->decrement('stock', $cartItem->quantity);
                }

                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'notes' => $request->notes ?? null,
                ]);

                // Create order items dari cart items
                foreach ($cartItems as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price, // Snapshot price
                        'subtotal' => $cartItem->price * $cartItem->quantity,
                    ]);
                }

                // Clear cart
                $cart->clear();

                return $order;
            });

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Order ID: ' . $order->id);

        } catch (\Exception $e) {
            // Transaction will rollback automatically jika ada exception
            return back()
                ->with('error', 'Checkout gagal: ' . $e->getMessage())
                ->withInput();
        }
    }
}

