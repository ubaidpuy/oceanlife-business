@extends('layouts.shop')

@section('title', ($category->meta_title ?: $category->name) . ' - ' . ($shopSettings->shop_name ?? 'Ocean Life'))
@section('meta_description', $category->meta_description ?: 'Browse ' . $category->name . ' products at ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @include('components.shop.breadcrumb', [
            'items' => [
                'Categories' => route('shop.categories.index'),
                $category->name => null,
            ],
        ])

        <div class="mb-10 flex flex-wrap items-end justify-between gap-6">
            <div>
                <h1 class="section-title">{{ $category->name }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    {{ $products->total() }} {{ Str::plural('product', $products->total()) }} in this category
                </p>
            </div>

            <form action="{{ route('shop.categories.show', $category) }}" method="GET" class="w-full max-w-md">
                <div class="flex gap-2">
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search in {{ $category->name }}..."
                        class="input-field"
                    >
                    <button type="submit" class="btn-primary shrink-0 px-6">Search</button>
                </div>
            </form>
        </div>

        @if($products->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($products as $product)
                    @include('components.shop.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="card p-12 text-center">
                <svg class="mx-auto mb-4 h-16 w-16 text-ocean-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">No products found</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    @if(request('search'))
                        No products match your search. Try a different term.
                    @else
                        This category doesn't have any products yet.
                    @endif
                </p>
                <div class="mt-6 flex flex-wrap justify-center gap-4">
                    @if(request('search'))
                        <a href="{{ route('shop.categories.show', $category) }}" class="btn-outline">Clear Search</a>
                    @endif
                    <a href="{{ route('shop.products.index') }}" class="btn-primary">Browse All Products</a>
                </div>
            </div>
        @endif
    </div>
@endsection
