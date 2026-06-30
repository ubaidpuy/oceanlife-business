@extends('layouts.shop')

@section('title', 'Products - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @include('components.shop.breadcrumb', [
            'items' => ['Products' => null],
        ])

        <div class="mb-10">
            <h1 class="section-title">All Products</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Discover our full range of aquarium supplies.</p>
        </div>

        <div class="flex flex-col gap-8 lg:flex-row">
            {{-- Sidebar filter (desktop) --}}
            <aside class="hidden w-64 shrink-0 lg:block">
                <div class="card sticky top-24 p-6">
                    <h2 class="mb-4 font-semibold text-gray-900 dark:text-white">Categories</h2>
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="{{ route('shop.products.index', request()->only('search')) }}"
                                class="block rounded-lg px-3 py-2 text-sm transition {{ !request('category') ? 'bg-ocean-primary/10 font-semibold text-ocean-primary' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                            >
                                All Products
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a
                                    href="{{ route('shop.products.index', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
                                    class="block rounded-lg px-3 py-2 text-sm transition {{ request('category') === $cat->slug ? 'bg-ocean-primary/10 font-semibold text-ocean-primary' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                                >
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <div class="flex-1">
                {{-- Mobile filter + search --}}
                <div class="mb-8 flex flex-col gap-4 sm:flex-row">
                    <form action="{{ route('shop.products.index') }}" method="GET" class="flex flex-1 gap-2">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="input-field"
                        >
                        <button type="submit" class="btn-primary shrink-0 px-6">Search</button>
                    </form>

                    <div class="lg:hidden">
                        <select
                            onchange="window.location.href = this.value"
                            class="input-field"
                        >
                            <option value="{{ route('shop.products.index', request()->only('search')) }}" {{ !request('category') ? 'selected' : '' }}>
                                All Categories
                            </option>
                            @foreach($categories as $cat)
                                <option
                                    value="{{ route('shop.products.index', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
                                    {{ request('category') === $cat->slug ? 'selected' : '' }}
                                >
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if(request('category') || request('search'))
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <span class="text-sm text-gray-500">Active filters:</span>
                        @if(request('category'))
                            @php $activeCategory = $categories->firstWhere('slug', request('category')); @endphp
                            @if($activeCategory)
                                <span class="badge bg-ocean-primary/10 text-ocean-primary">
                                    {{ $activeCategory->name }}
                                    <a href="{{ route('shop.products.index', request()->only('search')) }}" class="ml-1 hover:text-ocean-dark">&times;</a>
                                </span>
                            @endif
                        @endif
                        @if(request('search'))
                            <span class="badge bg-ocean-secondary/10 text-ocean-secondary">
                                "{{ request('search') }}"
                                <a href="{{ route('shop.products.index', request()->only('category')) }}" class="ml-1 hover:opacity-70">&times;</a>
                            </span>
                        @endif
                    </div>
                @endif

                @if($products->isNotEmpty())
                    <p class="mb-6 text-sm text-gray-500">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>

                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
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
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Try adjusting your search or filter criteria.</p>
                        <a href="{{ route('shop.products.index') }}" class="btn-primary mt-6 inline-flex">View All Products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
