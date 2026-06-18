<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display list of products (with search & filter)
     */
    public function index()
    {
        $products = Product::query()
            ->with('category')
            ->where('stock', '>', 0) // Only show in-stock products
            ->paginate(12);

        return view('customer.products.index', compact('products'));
    }

    /**
     * Display product detail
     */
    public function show(Product $product)
    {
        // Eager load category untuk avoid N+1 query
        $product->load('category');

        // Get related products dari category yang sama
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(5)
            ->get();

        return view('customer.products.show', compact('product', 'relatedProducts'));
    }
}

