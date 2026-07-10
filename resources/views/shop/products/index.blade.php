@extends('layouts.shop')

@section('title', 'Products - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 lg:py-6">
        <div x-data="{
            filtersOpen: false,
            validationMessage: '',
            applied: {
                category: @js(request('category', '')),
                min_price: @js(request('min_price', '')),
                max_price: @js(request('max_price', '')),
                sort: @js(request('sort', '')),
            },
            draft: {
                category: @js(request('category', '')),
                min_price: @js(request('min_price', '')),
                max_price: @js(request('max_price', '')),
                sort: @js(request('sort', '')),
            },
            openFilters() {
                this.restoreDraft();
                this.validationMessage = '';
                this.filtersOpen = true;
            },
            restoreDraft() {
                this.draft = { ...this.applied };
            },
            resetDraft() {
                this.draft = { category: '', min_price: '', max_price: '', sort: '' };
                this.validationMessage = '';
            },
            cancelFilters() {
                this.restoreDraft();
                this.validationMessage = '';
                this.filtersOpen = false;
            },
            hasSelectedFilter() {
                return Boolean(this.draft.category || this.draft.min_price || this.draft.max_price || this.draft.sort);
            },
            applyFilters(form) {
                if (! this.hasSelectedFilter()) {
                    this.validationMessage = 'Please select at least one filter before applying.';
                    return;
                }
                this.validationMessage = '';
                this.filtersOpen = false;
                form.submit();
            }
        }">
        <div class="mb-4 md:hidden">
            <div class="flex items-center gap-2">
                <form action="{{ route('shop.products.index') }}" method="GET" class="min-w-0 flex-1">
                    @foreach(['category', 'min_price', 'max_price', 'sort'] as $field)
                        @if(request($field))
                            <input type="hidden" name="{{ $field }}" value="{{ request($field) }}">
                        @endif
                    @endforeach
                    <label class="relative block">
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search Products"
                            class="h-12 w-full rounded-full border border-gray-200 bg-white py-3 pl-4 pr-12 text-sm text-gray-900 shadow-sm focus:border-ocean-primary focus:outline-none focus:ring-2 focus:ring-ocean-primary/15 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        >
                        <button type="submit" aria-label="Search products" class="absolute inset-y-0 right-1.5 my-auto flex h-9 w-9 items-center justify-center rounded-full text-gray-500 transition hover:bg-gray-100 hover:text-ocean-primary dark:hover:bg-gray-800">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                            </svg>
                        </button>
                    </label>
                </form>
                <button type="button" aria-label="Open filters" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-ocean-primary text-white shadow-lg shadow-ocean-primary/25 transition active:scale-95" @click="openFilters()">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M6 12h12M10 19h4"/>
                    </svg>
                </button>
            </div>
            <p class="mt-2 text-sm text-gray-500">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
        </div>

        <div
            class="fixed inset-0 z-50 md:hidden"
            x-show="filtersOpen"
            x-cloak
            aria-modal="true"
            role="dialog"
        >
            <div class="absolute inset-0 bg-black/40" x-show="filtersOpen" x-transition.opacity></div>
            <form
                action="{{ route('shop.products.index') }}"
                method="GET"
                class="absolute inset-x-0 bottom-0 max-h-[88vh] overflow-y-auto rounded-t-2xl bg-white p-4 shadow-2xl dark:bg-gray-900"
                x-show="filtersOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-y-full"
                x-transition:enter-end="translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-y-0"
                x-transition:leave-end="translate-y-full"
                @submit.prevent="applyFilters($event.target)"
            >
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-950 dark:text-white">Filters</h2>
                        <p class="text-sm text-gray-500">Refine your product list</p>
                    </div>
                    <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-200" aria-label="Cancel filters" @click="cancelFilters()">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <p class="mb-4 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 dark:bg-red-900/20 dark:text-red-300" x-show="validationMessage" x-text="validationMessage" x-cloak></p>

                <div class="space-y-5">
                    <div>
                        <label for="mobile-category" class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white">Category</label>
                        <select id="mobile-category" name="category" class="input-field" x-model="draft.category">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <p class="mb-2 text-sm font-semibold text-gray-900 dark:text-white">Price Range</p>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="block">
                                <span class="mb-1 block text-xs font-medium text-gray-500">Min</span>
                                <input type="number" name="min_price" min="0" step="1" value="{{ request('min_price') }}" placeholder="Rs 0" class="input-field" x-model="draft.min_price">
                            </label>
                            <label class="block">
                                <span class="mb-1 block text-xs font-medium text-gray-500">Max</span>
                                <input type="number" name="max_price" min="0" step="1" value="{{ request('max_price') }}" placeholder="Rs 5000" class="input-field" x-model="draft.max_price">
                            </label>
                        </div>
                    </div>

                    <div>
                        <p class="mb-2 text-sm font-semibold text-gray-900 dark:text-white">Sort By</p>
                        <div class="grid gap-2">
                            @foreach([
                                '' => 'Latest',
                                'price_low' => 'Price: Low to High',
                                'price_high' => 'Price: High to Low',
                                'popularity' => 'Popularity',
                            ] as $value => $label)
                                <label class="flex items-center justify-between rounded-lg border border-gray-200 p-3 text-sm font-medium text-gray-700 dark:border-gray-700 dark:text-gray-200">
                                    <span>{{ $label }}</span>
                                    <input type="radio" name="sort" value="{{ $value }}" class="h-4 w-4 text-ocean-primary focus:ring-ocean-primary" x-model="draft.sort">
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="sticky bottom-0 mt-6 grid grid-cols-3 gap-3 bg-white pt-3 dark:bg-gray-900">
                    <button type="button" class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 dark:border-gray-700 dark:text-gray-200" @click="cancelFilters()">
                        Cancel
                    </button>
                    <button type="button" class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 dark:border-gray-700 dark:text-gray-200" @click="resetDraft()">
                        Reset Filters
                    </button>
                    <button type="submit" class="btn-primary h-12">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <div class="mb-5 hidden rounded-lg border border-gray-100 bg-white p-3 shadow-sm dark:border-gray-800 dark:bg-gray-900 md:block">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center">
                <div class="min-w-0 lg:w-56">
                    <h1 class="text-2xl font-bold text-gray-950 dark:text-white">All Products</h1>
                    <p class="mt-0.5 text-sm text-gray-500">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
                </div>

                <form action="{{ route('shop.products.index') }}" method="GET" class="flex flex-1 gap-2">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @foreach(['min_price', 'max_price', 'sort'] as $field)
                        @if(request($field))
                            <input type="hidden" name="{{ $field }}" value="{{ request($field) }}">
                        @endif
                    @endforeach
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="input-field min-w-0"
                    >
                    <button type="submit" class="btn-primary shrink-0 px-5">Search</button>
                </form>

                <select
                    onchange="window.location.href = this.value"
                    class="input-field lg:w-56"
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

            <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                <a
                    href="{{ route('shop.products.index', request()->only('search')) }}"
                    class="shrink-0 rounded-full px-3 py-1.5 text-sm transition {{ !request('category') ? 'bg-ocean-primary font-semibold text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                >
                    All
                </a>
                @foreach($categories as $cat)
                    <a
                        href="{{ route('shop.products.index', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
                        class="shrink-0 rounded-full px-3 py-1.5 text-sm transition {{ request('category') === $cat->slug ? 'bg-ocean-primary font-semibold text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}"
                    >
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
        </div>

                @if(request('category') || request('search') || request('min_price') || request('max_price') || request('sort'))
                    <div class="mb-4 flex flex-wrap items-center gap-2">
                        <span class="text-sm text-gray-500">Active filters:</span>
                        @if(request('category'))
                            @php $activeCategory = $categories->firstWhere('slug', request('category')); @endphp
                            @if($activeCategory)
                                <span class="badge bg-ocean-primary/10 text-ocean-primary">
                                    {{ $activeCategory->name }}
                                    <a href="{{ route('shop.products.index', request()->except('category')) }}" class="ml-1 hover:text-ocean-dark">&times;</a>
                                </span>
                            @endif
                        @endif
                        @if(request('search'))
                            <span class="badge bg-ocean-secondary/10 text-ocean-secondary">
                                "{{ request('search') }}"
                                <a href="{{ route('shop.products.index', request()->except('search')) }}" class="ml-1 hover:opacity-70">&times;</a>
                            </span>
                        @endif
                        @if(request('min_price') || request('max_price'))
                            <span class="badge bg-ocean-primary/10 text-ocean-primary">
                                Rs {{ request('min_price', 0) }} - {{ request('max_price') ?: 'Any' }}
                                <a href="{{ route('shop.products.index', request()->except(['min_price', 'max_price'])) }}" class="ml-1 hover:text-ocean-dark">&times;</a>
                            </span>
                        @endif
                        @if(request('sort'))
                            <span class="badge bg-ocean-secondary/10 text-ocean-secondary">
                                {{ [
                                    'price_low' => 'Price: Low to High',
                                    'price_high' => 'Price: High to Low',
                                    'popularity' => 'Popularity',
                                ][request('sort')] ?? 'Latest' }}
                                <a href="{{ route('shop.products.index', request()->except('sort')) }}" class="ml-1 hover:opacity-70">&times;</a>
                            </span>
                        @endif
                    </div>
                @endif

                @if($products->isNotEmpty())
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($products as $product)
                            @include('components.shop.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="card p-8 text-center">
                        <svg class="mx-auto mb-4 h-16 w-16 text-ocean-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">No products found</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Try adjusting your search or filter criteria.</p>
                        <a href="{{ route('shop.products.index') }}" class="btn-primary mt-6 inline-flex">View All Products</a>
                    </div>
                @endif
    </div>
@endsection
