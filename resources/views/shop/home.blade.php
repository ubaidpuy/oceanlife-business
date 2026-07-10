@extends('layouts.shop')

@section('title', $shopSettings->shop_name ?? 'Ocean Life')

@section('content')
    @php
        $heroProduct = $featuredProducts
            ->concat($latestProducts)
            ->first(fn ($product) => $product->category?->slug === 'fish-care' && $product->images->isNotEmpty())
            ?? $featuredProducts->firstWhere('images.0')
            ?? $latestProducts->firstWhere('images.0');
        $heroImage = $heroProduct?->images->firstWhere('is_primary', true)?->url ?? $heroProduct?->images->first()?->url;
        $heroSlides = $featuredProducts
            ->concat($latestProducts)
            ->filter(fn ($product) => $product->images->isNotEmpty())
            ->sortByDesc(fn ($product) => $product->category?->slug === 'fish-care')
            ->unique('id')
            ->take(4)
            ->values();
        $showAddress = $shopSettings->address && ! str_contains(strtolower($shopSettings->address), '123 ocean avenue');
    @endphp

    {{-- Hero --}}
    <section
        class="relative min-h-[520px] overflow-hidden bg-black sm:min-h-[600px]"
        x-data="{
            active: 0,
            total: {{ max($heroSlides->count(), 1) }},
            next() { this.active = (this.active + 1) % this.total },
            previous() { this.active = (this.active - 1 + this.total) % this.total },
            go(index) { this.active = index }
        }"
        x-init="setInterval(() => next(), 5200)"
    >
        @forelse($heroSlides as $index => $slide)
            @php
                $slideImage = $slide->images->firstWhere('is_primary', true)?->url ?? $slide->images->first()?->url;
            @endphp
            <div
                class="absolute inset-0 transition-all duration-700 ease-out"
                x-cloak
                x-show="active === {{ $index }}"
                x-transition:enter="transition duration-700 ease-out"
                x-transition:enter-start="opacity-0 scale-105"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition duration-700 ease-in"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <img src="{{ $slideImage }}" alt="{{ $slide->name }}" class="h-full w-full object-cover object-center opacity-90 lg:object-right">
            </div>
        @empty
            @if($heroImage)
                <img src="{{ $heroImage }}" alt="{{ $heroProduct->name }}" class="absolute inset-0 h-full w-full object-cover object-center opacity-90 lg:object-right">
            @endif
        @endforelse

        <div class="absolute inset-0 z-10 bg-[radial-gradient(circle_at_72%_42%,transparent_0,rgba(0,0,0,0.08)_24%,rgba(0,0,0,0.62)_50%,rgba(0,0,0,0.96)_78%)]"></div>
        <div class="absolute inset-0 z-10 bg-gradient-to-r from-black via-black/78 to-black/12"></div>
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-black/35 via-transparent to-black/18"></div>

        <button type="button" aria-label="Previous slide" class="absolute bottom-16 left-3 z-30 flex h-10 w-10 items-center justify-center rounded-full bg-white text-gray-700 shadow-lg transition hover:bg-gray-100 sm:left-5 sm:top-1/2 sm:bottom-auto sm:h-12 sm:w-12 sm:-translate-y-1/2" @click="previous()">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button type="button" aria-label="Next slide" class="absolute bottom-16 right-3 z-30 flex h-10 w-10 items-center justify-center rounded-full bg-white text-gray-700 shadow-lg transition hover:bg-gray-100 sm:right-5 sm:top-1/2 sm:bottom-auto sm:h-12 sm:w-12 sm:-translate-y-1/2" @click="next()">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <div class="relative z-20 mx-auto flex min-h-[520px] max-w-7xl items-center px-4 py-20 sm:min-h-[600px] sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    {{ $shopSettings->shop_name }} - The Aquarium Fish Store
                </h1>
                <p class="mt-5 max-w-xl text-base leading-7 text-gray-200 sm:text-lg">
                    Premium fish care, aquarium accessories, tanks, food, lights, filters, and supplies for healthier aquariums.
                </p>
                <div class="mt-8">
                    <a href="{{ route('shop.products.index') }}" class="inline-flex items-center justify-center rounded bg-white px-6 py-3 text-base font-bold text-ocean-dark shadow-xl transition hover:bg-gray-100">
                        Shop Now
                    </a>
                </div>
            </div>

            <div class="absolute bottom-6 left-1/2 z-20 flex -translate-x-1/2 gap-2">
                @forelse($heroSlides as $index => $slide)
                    <button type="button" class="h-2.5 w-2.5 rounded-full transition" :class="active === {{ $index }} ? 'bg-white scale-110' : 'bg-white/30'" aria-label="Go to slide {{ $index + 1 }}" @click="go({{ $index }})"></button>
                @empty
                    <span class="h-2.5 w-2.5 rounded-full bg-white"></span>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white py-8 dark:bg-gray-900">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-ocean-primary/10 text-ocean-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white">Fastest Shipping</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Quick and reliable delivery for daily aquarium essentials.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-ocean-primary/10 text-ocean-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white">100% Safe Payments</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Secure checkout with clear PKR pricing on every product.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-ocean-primary/10 text-ocean-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white">Careful Packing</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Accessories and supplies packed neatly for your aquarium.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-ocean-primary/10 text-ocean-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636A9 9 0 105.636 18.364 9 9 0 0018.364 5.636zM9.172 9.172a4 4 0 015.656 5.656M15 9l-6 6"/></svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white">24/7 Online Support</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Always here to assist you with fish care shopping.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Categories --}}
    @if($featuredCategories->isNotEmpty())
    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">Explore</p>
                    <h2 class="section-title">Shop by Aquarium Need</h2>
                </div>
                <a href="{{ route('shop.categories.index') }}" class="text-sm font-semibold text-ocean-primary hover:text-ocean-dark">
                    View All &rarr;
                </a>
            </div>
            <div class="grid grid-cols-2 gap-x-3 gap-y-5 sm:grid-cols-4 lg:grid-cols-8">
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
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">Handpicked care picks</p>
                    <h2 class="section-title">Featured Accessories & Supplies</h2>
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
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-ocean-secondary">Freshly stocked</p>
                    <h2 class="section-title">More Aquarium Essentials</h2>
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
                    <h2 class="section-title mb-6">Built for Everyday Fish Care</h2>
                    <div class="prose prose-lg max-w-none text-gray-600 dark:text-gray-300">
                        Ocean Life brings together practical aquarium accessories, food, filters, lighting, plants, and setup essentials so pet fish owners can keep tanks clean, healthy, and easy to maintain.
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
                            @if($heroImage)
                                <img src="{{ $heroImage }}" alt="{{ $heroProduct->name }}" class="h-full w-full rounded-[1.35rem] object-cover">
                            @elseif($shopSettings->logo_url)
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
                @if($showAddress)
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
