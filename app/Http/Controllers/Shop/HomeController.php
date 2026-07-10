<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::active()->featured()->with(['images', 'category'])->take(8)->get();

        return view('shop.home', [
            'featuredCategories' => Category::active()
                ->with(['products' => fn ($query) => $query->active()->with('images')->latest()->take(1)])
                ->withCount('products')
                ->take(8)
                ->get(),
            'featuredProducts' => $featuredProducts,
            'latestProducts' => Product::active()
                ->whereNotIn('id', $featuredProducts->pluck('id'))
                ->with(['images', 'category'])
                ->latest()
                ->take(8)
                ->get(),
        ]);
    }
}
