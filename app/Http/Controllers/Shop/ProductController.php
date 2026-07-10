<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::active()
            ->with(['images', 'category'])
            ->when($request->search, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->when($request->category, fn ($q, $slug) => $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->when($request->filled('min_price'), fn ($q) => $q->whereRaw('COALESCE(discount_price, price) >= ?', [(float) $request->min_price]))
            ->when($request->filled('max_price'), fn ($q) => $q->whereRaw('COALESCE(discount_price, price) <= ?', [(float) $request->max_price]))
            ->when(
                $request->sort === 'price_low',
                fn ($q) => $q->orderByRaw('COALESCE(discount_price, price) asc'),
                fn ($q) => $q->when(
                    $request->sort === 'price_high',
                    fn ($q) => $q->orderByRaw('COALESCE(discount_price, price) desc'),
                    fn ($q) => $q->when(
                        $request->sort === 'popularity',
                        fn ($q) => $q->withSum('orderItems as sold_quantity', 'quantity')->orderByDesc('sold_quantity')->latest(),
                        fn ($q) => $q->latest()
                    )
                )
            )
            ->paginate(12)
            ->withQueryString();

        $categories = Category::active()->orderBy('name')->get();

        return view('shop.products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->status, 404);

        $product->load(['images', 'category']);

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(4)
            ->get();

        return view('shop.products.show', compact('product', 'relatedProducts'));
    }
}
