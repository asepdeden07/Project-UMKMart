<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display cart items
     */
    public function index()
    {
        $cart = auth()->user()->carts()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        // Load cart items with product details
        $cartItems = $cart->items()->with('product')->get();
        $total = $cart->getTotal();
        $itemCount = $cart->getItemCount();

        return view('customer.cart.index', compact('cartItems', 'cart', 'total', 'itemCount'));
    }

    /**
     * Add product to cart
     */
    public function add(AddToCartRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Validate stock tersedia
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak cukup. Stok tersedia: ' . $product->stock);
        }

        // Get atau create cart untuk user
        $cart = auth()->user()->carts()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        // Check jika produk sudah ada di cart
        $existingItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            // Update quantity jika sudah ada
            $newQuantity = $existingItem->quantity + $request->quantity;

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok produk tidak cukup.');
            }

            $existingItem->update(['quantity' => $newQuantity]);
            $message = 'Jumlah produk di cart diperbarui';
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price, // Snapshot price
            ]);

            $message = 'Produk berhasil ditambahkan ke cart';
        }

        return back()->with('success', $message);
    }

    /**
     * Update cart item quantity
     */
    public function update(CartItem $cartItem)
    {
        $quantity = request()->input('quantity');

        if (!is_numeric($quantity) || $quantity < 1) {
            return back()->with('error', 'Jumlah tidak valid');
        }

        $product = $cartItem->product;

        // Check stock tersedia
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok produk tidak cukup. Stok tersedia: ' . $product->stock);
        }

        $cartItem->update(['quantity' => $quantity]);

        return back()->with('success', 'Jumlah produk diperbarui');
    }

    /**
     * Remove item from cart
     */
    public function destroy(CartItem $cartItem)
    {
        $product = $cartItem->product;
        $cartItem->delete();

        return back()->with('success', $product->name . ' dihapus dari cart');
    }
}

