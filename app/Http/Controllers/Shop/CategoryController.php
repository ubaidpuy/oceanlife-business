<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::active()->withCount('products')->orderBy('name')->paginate(12);

        return view('shop.categories.index', compact('categories'));
    }

    public function show(Category $category, Request $request): View
    {
        abort_unless($category->status, 404);

        $products = Product::active()
            ->where('category_id', $category->id)
            ->with(['images', 'category'])
            ->when($request->search, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.categories.show', compact('category', 'products'));
    }
}
