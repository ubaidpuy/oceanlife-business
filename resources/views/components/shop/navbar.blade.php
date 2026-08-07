@php
    $cartCount = app(\App\Services\CartService::class)->count();
    $navbarCategories = \App\Models\Category::active()->orderBy('name')->get();
@endphp

<nav class="relative z-40 border-b border-gray-100 bg-white/95 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/95">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-2 lg:grid lg:h-24 lg:grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] lg:gap-0">
            <a href="{{ route('shop.home') }}" class="flex min-w-0 shrink-0 items-center gap-3 lg:justify-self-start" aria-label="{{ $shopSettings->shop_name }} home">
                @if($shopSettings->logo_url)
                    <img src="{{ $shopSettings->logo_url }}" alt="{{ $shopSettings->shop_name }}" class="h-14 w-auto max-w-[11rem] object-contain sm:h-16 sm:max-w-[14rem] lg:h-20 lg:max-w-[9rem] xl:max-w-[17rem]">
                @else
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-ocean-primary to-ocean-secondary sm:h-16 sm:w-16">
                        <svg class="h-8 w-8 text-white sm:h-9 sm:w-9" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2zm0 3c1.5 0 2.8.8 3.5 2-.7 1.2-2 2-3.5 2s-2.8-.8-3.5-2c.7-1.2 2-2 3.5-2z"/></svg>
                    </div>
                @endif
            </a>

            <div class="hidden max-w-[45vw] items-center gap-5 overflow-x-auto md:flex lg:justify-self-center xl:gap-8">
                @foreach($navbarCategories as $category)
                    <a href="{{ route('shop.categories.show', $category) }}" class="shrink-0 whitespace-nowrap text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="flex min-w-0 flex-1 items-center gap-2 sm:gap-3 md:flex-none lg:justify-self-end">
                <form action="{{ request()->getBaseUrl() }}/products" method="GET" class="relative min-w-0 flex-1 md:flex-none lg:hidden" data-unified-search data-search-url="{{ request()->getBaseUrl() }}/api/search" data-products-url="{{ request()->getBaseUrl() }}/products" data-categories-url="{{ request()->getBaseUrl() }}/categories">
                    <div class="relative">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search for product & categories" autocomplete="off" aria-label="Search products and categories" aria-autocomplete="list" aria-expanded="false" class="w-full rounded-full border border-gray-200 bg-gray-50 py-2 pl-9 pr-3 text-sm focus:border-ocean-primary focus:outline-none focus:ring-2 focus:ring-ocean-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white md:w-40">
                        <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span data-search-hint class="pointer-events-none absolute inset-y-0 right-9 hidden items-center whitespace-nowrap text-[10px] font-medium text-gray-950 dark:text-white" aria-live="polite"></span>
                    </div>
                    <div data-search-results role="listbox" class="fixed z-[100] hidden max-h-[60vh] overflow-y-auto overscroll-contain rounded-2xl border border-gray-100 bg-white p-2 shadow-2xl dark:border-gray-700 dark:bg-gray-800"></div>
                </form>

                <form action="{{ request()->getBaseUrl() }}/products" method="GET" class="relative hidden lg:block" data-unified-search data-search-url="{{ request()->getBaseUrl() }}/api/search" data-products-url="{{ request()->getBaseUrl() }}/products" data-categories-url="{{ request()->getBaseUrl() }}/categories">
                    <div class="relative">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search products & categories..." autocomplete="off" aria-label="Search products and categories" aria-autocomplete="list" aria-expanded="false" class="w-48 rounded-full border border-gray-200 bg-gray-50 py-2 pl-10 pr-4 text-sm focus:border-ocean-primary focus:outline-none focus:ring-2 focus:ring-ocean-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white xl:w-64">
                        <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span data-search-hint class="pointer-events-none absolute inset-y-0 right-9 hidden items-center whitespace-nowrap text-[10px] font-medium text-gray-950 dark:text-white" aria-live="polite"></span>
                    </div>
                    <div data-search-results role="listbox" class="fixed z-[100] hidden max-h-[65vh] overflow-y-auto overscroll-contain rounded-2xl border border-gray-100 bg-white p-2 shadow-2xl dark:border-gray-700 dark:bg-gray-800"></div>
                </form>



                <a href="{{ route('shop.cart.index') }}" class="relative rounded-lg p-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @if($cartCount > 0)
                        <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-ocean-primary text-xs font-bold text-white">{{ $cartCount }}</span>
                    @endif
                </a>

                <button @click="mobileMenu = !mobileMenu" type="button" aria-label="Toggle navigation menu" class="rounded-lg p-2 text-gray-700 md:hidden dark:text-gray-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenu" x-transition class="border-t border-gray-100 bg-white px-4 py-4 md:hidden dark:border-gray-800 dark:bg-gray-900" x-cloak>
        <div class="flex flex-col gap-3">
            @foreach($navbarCategories as $category)
                <a href="{{ route('shop.categories.show', $category) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
