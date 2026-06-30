@extends('layouts.shop')

@section('title', ($product->meta_title ?: $product->name) . ' - ' . ($shopSettings->shop_name ?? 'Ocean Life'))
@section('meta_description', $product->meta_description ?: Str::limit(strip_tags($product->description), 160))

@section('content')
    @php
        $images = $product->images;
        $imageUrls = $images->map(fn ($img) => $img->url)->values();
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @include('components.shop.breadcrumb', [
            'items' => [
                'Products' => route('shop.products.index'),
                $product->category->name => route('shop.categories.show', $product->category),
                $product->name => null,
            ],
        ])

        <div class="grid gap-12 lg:grid-cols-2">
            {{-- Image Gallery --}}
            <div
                x-data="{
                    activeIndex: 0,
                    images: @js($imageUrls),
                    prev() { this.activeIndex = this.activeIndex > 0 ? this.activeIndex - 1 : this.images.length - 1 },
                    next() { this.activeIndex = this.activeIndex < this.images.length - 1 ? this.activeIndex + 1 : 0 }
                }"
            >
                <div class="card relative aspect-square overflow-hidden bg-gray-100">
                    <template x-if="images.length > 0">
                        <img
                            :src="images[activeIndex]"
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover"
                        >
                    </template>
                    <template x-if="images.length === 0">
                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-ocean-primary/10 to-ocean-secondary/10">
                            <svg class="h-24 w-24 text-ocean-primary/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
                        </div>
                    </template>

                    @if($product->has_discount)
                        <span class="badge absolute left-4 top-4 bg-red-500 text-white">Sale</span>
                    @endif

                    <template x-if="images.length > 1">
                        <div>
                            <button
                                @click="prev()"
                                type="button"
                                class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-2 shadow-lg transition hover:bg-white"
                            >
                                <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button
                                @click="next()"
                                type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-2 shadow-lg transition hover:bg-white"
                            >
                                <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                @if($images->count() > 1)
                    <div class="mt-4 flex gap-3 overflow-x-auto pb-2">
                        @foreach($images as $index => $image)
                            <button
                                type="button"
                                @click="activeIndex = {{ $index }}"
                                :class="activeIndex === {{ $index }} ? 'ring-2 ring-ocean-primary' : 'opacity-70 hover:opacity-100'"
                                class="h-20 w-20 shrink-0 overflow-hidden rounded-xl transition"
                            >
                                <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Details --}}
            <div>
                <a href="{{ route('shop.categories.show', $product->category) }}" class="text-sm font-semibold text-ocean-primary hover:text-ocean-dark">
                    {{ $product->category->name }}
                </a>
                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white lg:text-4xl">{{ $product->name }}</h1>

                <div class="mt-6 flex flex-wrap items-center gap-4">
                    @if($product->has_discount)
                        <span class="text-3xl font-bold text-ocean-primary">${{ number_format($product->discount_price, 2) }}</span>
                        <span class="text-xl text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                        @php $savings = $product->price - $product->discount_price; @endphp
                        <span class="badge bg-red-100 text-red-600">Save ${{ number_format($savings, 2) }}</span>
                    @else
                        <span class="text-3xl font-bold text-ocean-primary">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <div class="mt-6 space-y-3 rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Shipping</span>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            @if($product->shipping_charge > 0)
                                ${{ number_format($product->shipping_charge, 2) }}
                            @else
                                <span class="text-ocean-secondary">Free</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Availability</span>
                        @if($product->stock > 0)
                            <span class="font-semibold text-ocean-secondary">In Stock ({{ $product->stock }} available)</span>
                        @else
                            <span class="font-semibold text-red-500">Out of Stock</span>
                        @endif
                    </div>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('shop.cart.add', $product) }}" method="POST" class="mt-8">
                        @csrf
                        <div class="flex flex-wrap items-end gap-4">
                            <div>
                                <label for="quantity" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    value="{{ old('quantity', 1) }}"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    class="input-field w-24"
                                >
                            </div>
                            <button type="submit" class="btn-primary flex-1 sm:flex-none">
                                <svg class="mr-2 inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Add to Cart
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mt-8 rounded-xl bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/20 dark:text-red-300">
                        This product is currently out of stock. Please check back later.
                    </div>
                @endif

                @if($product->description)
                    <div class="mt-10 border-t border-gray-200 pt-10 dark:border-gray-700">
                        <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Description</h2>
                        <div class="prose max-w-none text-gray-600 dark:text-gray-300">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->isNotEmpty())
            <section class="mt-20 border-t border-gray-200 pt-16 dark:border-gray-700">
                <h2 class="section-title mb-10">Related Products</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedProducts as $relatedProduct)
                        @include('components.shop.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
