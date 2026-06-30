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
        return view('shop.home', [
            'featuredCategories' => Category::active()->withCount('products')->take(8)->get(),
            'featuredProducts' => Product::active()->featured()->with(['images', 'category'])->take(8)->get(),
            'latestProducts' => Product::active()->with(['images', 'category'])->latest()->take(8)->get(),
        ]);
    }
}
