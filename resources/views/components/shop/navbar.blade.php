@php
    $cartCount = app(\App\Services\CartService::class)->count();
@endphp

<nav class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/95">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('shop.home') }}" class="flex items-center gap-2">
                @if($shopSettings->logo_url)
                    <img src="{{ $shopSettings->logo_url }}" alt="{{ $shopSettings->shop_name }}" class="h-10 w-auto">
                @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-ocean-primary to-ocean-secondary">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2zm0 3c1.5 0 2.8.8 3.5 2-.7 1.2-2 2-3.5 2s-2.8-.8-3.5-2c.7-1.2 2-2 3.5-2z"/></svg>
                    </div>
                @endif
                <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $shopSettings->shop_name }}</span>
            </a>

            <div class="hidden items-center gap-8 md:flex">
                <a href="{{ route('shop.home') }}" class="text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">Home</a>
                <a href="{{ route('shop.categories.index') }}" class="text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">Categories</a>
                <a href="{{ route('shop.products.index') }}" class="text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">Products</a>
                <a href="{{ route('shop.home') }}#about" class="text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">About</a>
                <a href="{{ route('shop.home') }}#contact" class="text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">Contact</a>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('shop.products.index') }}" method="GET" class="hidden lg:block">
                    <div class="relative">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-56 rounded-full border border-gray-200 bg-gray-50 py-2 pl-10 pr-4 text-sm focus:border-ocean-primary focus:outline-none focus:ring-2 focus:ring-ocean-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </form>

                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="darkMode" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                <a href="{{ route('shop.cart.index') }}" class="relative rounded-lg p-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @if($cartCount > 0)
                        <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-ocean-primary text-xs font-bold text-white">{{ $cartCount }}</span>
                    @endif
                </a>

                <button @click="mobileMenu = !mobileMenu" class="rounded-lg p-2 text-gray-700 md:hidden dark:text-gray-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenu" x-transition class="border-t border-gray-100 bg-white px-4 py-4 md:hidden dark:border-gray-800 dark:bg-gray-900" x-cloak>
        <div class="flex flex-col gap-3">
            <a href="{{ route('shop.home') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">Home</a>
            <a href="{{ route('shop.categories.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">Categories</a>
            <a href="{{ route('shop.products.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">Products</a>
            <a href="{{ route('shop.home') }}#about" class="text-sm font-medium text-gray-700 dark:text-gray-300">About</a>
            <a href="{{ route('shop.home') }}#contact" class="text-sm font-medium text-gray-700 dark:text-gray-300">Contact</a>
            <form action="{{ route('shop.products.index') }}" method="GET">
                <input type="search" name="search" placeholder="Search products..." class="input-field">
            </form>
        </div>
    </div>
</nav>
