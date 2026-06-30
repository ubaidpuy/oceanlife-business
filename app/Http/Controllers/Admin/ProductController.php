<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ImageUploadService $imageUpload) {}

    public function index(): View
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['images'], $data['remove_images'], $data['primary_image_id']);

        $product = Product::create($data);
        $this->syncImages($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $product->load('images');
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        unset($data['images'], $data['remove_images'], $data['primary_image_id']);

        $product->update($data);
        $this->syncImages($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            $this->imageUpload->delete($image->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update(['status' => ! $product->status]);

        return back()->with('success', 'Product status updated.');
    }

    private function syncImages(Product $product, ProductRequest $request): void
    {
        if ($request->filled('remove_images')) {
            $imagesToRemove = ProductImage::where('product_id', $product->id)
                ->whereIn('id', $request->input('remove_images'))
                ->get();

            foreach ($imagesToRemove as $image) {
                $this->imageUpload->delete($image->path);
                $image->delete();
            }
        }

        if ($request->hasFile('images')) {
            $sortOrder = $product->images()->max('sort_order') ?? 0;

            foreach ($request->file('images') as $file) {
                $sortOrder++;
                $path = $this->imageUpload->upload($file, 'products');

                $product->images()->create([
                    'path' => $path,
                    'is_primary' => $product->images()->count() === 0,
                    'sort_order' => $sortOrder,
                ]);
            }
        }

        if ($request->filled('primary_image_id')) {
            $product->images()->update(['is_primary' => false]);
            $product->images()
                ->where('id', $request->input('primary_image_id'))
                ->update(['is_primary' => true]);
        }

        if ($product->images()->where('is_primary', true)->doesntExist() && $product->images()->exists()) {
            $product->images()->orderBy('sort_order')->first()?->update(['is_primary' => true]);
        }
    }
}
