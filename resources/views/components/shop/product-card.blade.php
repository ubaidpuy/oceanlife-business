@props(['product'])

@php
    $image = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
@endphp

<div class="card group overflow-hidden">
    <a href="{{ route('shop.products.show', $product) }}" class="block">
        <div class="relative aspect-square overflow-hidden bg-gray-100">
            @if($image)
                <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <div class="flex h-full items-center justify-center bg-gradient-to-br from-ocean-primary/10 to-ocean-secondary/10">
                    <svg class="h-16 w-16 text-ocean-primary/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
                </div>
            @endif
            @if($product->has_discount)
                <span class="badge absolute left-3 top-3 bg-red-500 text-white">Sale</span>
            @endif
            @if($product->featured)
                <span class="badge absolute right-3 top-3 bg-ocean-secondary text-white">Featured</span>
            @endif
        </div>
        <div class="p-4">
            <p class="mb-1 text-xs font-medium text-ocean-primary">{{ $product->category->name }}</p>
            <h3 class="mb-2 font-semibold text-gray-900 transition group-hover:text-ocean-primary dark:text-white">{{ $product->name }}</h3>
            <div class="flex items-center gap-2">
                @if($product->has_discount)
                    <span class="text-lg font-bold text-ocean-primary">${{ number_format($product->discount_price, 2) }}</span>
                    <span class="text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-lg font-bold text-ocean-primary">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            @if($product->stock <= 0)
                <span class="mt-2 inline-block text-xs font-medium text-red-500">Out of Stock</span>
            @endif
        </div>
    </a>
</div>
