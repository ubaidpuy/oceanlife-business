@extends('layouts.shop')

@section('title', 'Page Not Found - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto flex min-h-[60vh] max-w-2xl flex-col items-center justify-center px-4 py-16 text-center sm:px-6 lg:px-8">
        <div class="relative mb-8">
            <span class="text-[10rem] font-bold leading-none text-ocean-primary/10">404</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="h-24 w-24 text-ocean-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">Page Not Found</h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
            Sorry, the page you're looking for has drifted away. It may have been moved or no longer exists.
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('shop.home') }}" class="btn-primary">Back to Home</a>
            <a href="{{ route('shop.products.index') }}" class="btn-outline">Browse Products</a>
        </div>

        <div class="mt-16 grid w-full gap-4 sm:grid-cols-3">
            <a href="{{ route('shop.categories.index') }}" class="card p-4 text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">
                Categories
            </a>
            <a href="{{ route('shop.cart.index') }}" class="card p-4 text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">
                Shopping Cart
            </a>
            <a href="{{ route('shop.home') }}#contact" class="card p-4 text-sm font-medium text-gray-700 transition hover:text-ocean-primary dark:text-gray-300">
                Contact Us
            </a>
        </div>
    </div>
@endsection
