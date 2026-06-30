@extends('layouts.shop')

@section('title', $shopSettings->shop_name ?? 'Ocean Life')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-ocean-primary via-ocean-dark to-ocean-secondary">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 1200 600" preserveAspectRatio="none">
                <path fill="currentColor" class="text-white" d="M0,300 C300,400 600,200 900,300 C1050,350 1150,250 1200,300 L1200,600 L0,600 Z"/>
            </svg>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Welcome to {{ $shopSettings->shop_name }}
                </h1>
                <p class="mt-6 text-lg text-blue-100 sm:text-xl">
                    Premium aquarium supplies, fish, and accessories for your underwater paradise.
                </p>

                <form action="{{ route('shop.products.index') }}" method="GET" class="mx-auto mt-10 max-w-xl">
                    <div class="flex gap-2 rounded-2xl bg-white/10 p-2 backdrop-blur-sm">
                        <input
                            type="search"
                            name="search"
                            placeholder="Search products..."
                            value="{{ request('search') }}"
                            class="input-field flex-1 border-0 bg-white/90 focus:ring-ocean-secondary"
                        >
                        <button type="submit" class="btn-secondary shrink-0 px-8">
                            Search
                        </button>
                    </div>
                </form>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('shop.products.index') }}" class="btn-primary bg-white text-ocean-primary shadow-white/25 hover:bg-blue-50 hover:text-ocean-dark">
                        Shop Now
                    </a>
                    <a href="{{ route('shop.categories.index') }}" class="btn-outline border-white text-white hover:bg-white hover:text-ocean-primary">
                        Browse Categories
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Categories --}}
    @if($featuredCategories->isNotEmpty())
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">Explore</p>
                    <h2 class="section-title">Featured Categories</h2>
                </div>
                <a href="{{ route('shop.categories.index') }}" class="text-sm font-semibold text-ocean-primary hover:text-ocean-dark">
                    View All &rarr;
                </a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredCategories as $category)
                    @include('components.shop.category-card', ['category' => $category])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Featured Products --}}
    @if($featuredProducts->isNotEmpty())
    <section class="bg-white py-16 dark:bg-gray-800 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">Handpicked</p>
                    <h2 class="section-title">Featured Products</h2>
                </div>
                <a href="{{ route('shop.products.index') }}" class="text-sm font-semibold text-ocean-primary hover:text-ocean-dark">
                    View All &rarr;
                </a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredProducts as $product)
                    @include('components.shop.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Latest Products --}}
    @if($latestProducts->isNotEmpty())
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">New Arrivals</p>
                    <h2 class="section-title">Latest Products</h2>
                </div>
                <a href="{{ route('shop.products.index') }}" class="text-sm font-semibold text-ocean-primary hover:text-ocean-dark">
                    View All &rarr;
                </a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($latestProducts as $product)
                    @include('components.shop.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- About --}}
    <section id="about" class="scroll-mt-20 bg-gradient-to-br from-ocean-primary/5 to-ocean-secondary/5 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">About Us</p>
                    <h2 class="section-title mb-6">Your Trusted Aquarium Partner</h2>
                    <div class="prose prose-lg max-w-none text-gray-600 dark:text-gray-300">
                        {!! nl2br(e($shopSettings->about_us ?? 'Ocean Life is your one-stop shop for premium aquarium supplies, healthy fish, and expert advice. We are passionate about helping you create and maintain a thriving underwater ecosystem.')) !!}
                    </div>
                    @if($shopSettings->shipping_policy)
                        <div class="mt-8 rounded-2xl border border-ocean-primary/20 bg-white p-6 dark:bg-gray-800">
                            <h3 class="mb-3 font-semibold text-ocean-primary">Shipping Policy</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $shopSettings->shipping_policy }}</p>
                        </div>
                    @endif
                </div>
                <div class="relative">
                    <div class="aspect-square overflow-hidden rounded-3xl bg-gradient-to-br from-ocean-primary to-ocean-secondary p-1">
                        <div class="flex h-full items-center justify-center rounded-[1.35rem] bg-white dark:bg-gray-800">
                            @if($shopSettings->logo_url)
                                <img src="{{ $shopSettings->logo_url }}" alt="{{ $shopSettings->shop_name }}" class="max-h-48 w-auto">
                            @else
                                <svg class="h-32 w-32 text-ocean-primary/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="scroll-mt-20 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">Get in Touch</p>
                <h2 class="section-title">Contact Us</h2>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                @if($shopSettings->address)
                <div class="card p-8 text-center">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-ocean-primary/10">
                        <svg class="h-7 w-7 text-ocean-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">Address</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $shopSettings->address }}</p>
                </div>
                @endif

                @if($shopSettings->phone)
                <div class="card p-8 text-center">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-ocean-secondary/10">
                        <svg class="h-7 w-7 text-ocean-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">Phone</h3>
                    <a href="tel:{{ $shopSettings->phone }}" class="text-sm text-ocean-primary hover:text-ocean-dark">{{ $shopSettings->phone }}</a>
                </div>
                @endif

                @if($shopSettings->email)
                <div class="card p-8 text-center">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-ocean-primary/10">
                        <svg class="h-7 w-7 text-ocean-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">Email</h3>
                    <a href="mailto:{{ $shopSettings->email }}" class="text-sm text-ocean-primary hover:text-ocean-dark">{{ $shopSettings->email }}</a>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
