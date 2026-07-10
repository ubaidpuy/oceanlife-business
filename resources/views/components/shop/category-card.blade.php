@props(['category'])

@php
    $product = $category->relationLoaded('products') ? $category->products->first() : null;
    $productImage = $product?->images?->firstWhere('is_primary', true) ?? $product?->images?->first();
    $imageUrl = $productImage?->url ?? $category->image_url;
@endphp

<a href="{{ route('shop.categories.show', $category) }}" class="group flex flex-col items-center rounded-lg p-2 text-center transition-all duration-300 hover:-translate-y-1 hover:bg-white/75 hover:shadow-lg hover:shadow-cyan-100/60 dark:hover:bg-white/10">
    <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-gradient-to-br from-cyan-50 to-blue-50 ring-1 ring-cyan-100/80 transition duration-300 group-hover:scale-105 group-hover:ring-ocean-secondary/30 dark:from-cyan-950/60 dark:to-blue-950/60 dark:ring-white/10">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" alt="{{ $category->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
        @else
            <svg class="h-8 w-8 text-ocean-primary transition duration-300 group-hover:scale-110 group-hover:text-ocean-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 12h3l2-3 3 6 2-3h6M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/></svg>
        @endif
    </div>
    <div class="mt-3 min-w-0">
        <h3 class="truncate text-sm font-semibold text-gray-950 transition group-hover:text-ocean-primary dark:text-white">{{ $category->name }}</h3>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ $category->products_count ?? 0 }} products</p>
    </div>
</a>
