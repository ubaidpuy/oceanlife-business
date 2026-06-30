@extends('layouts.shop')

@section('title', 'Categories - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @include('components.shop.breadcrumb', [
            'items' => ['Categories' => null],
        ])

        <div class="mb-10">
            <h1 class="section-title">All Categories</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Browse our collection of aquarium categories.</p>
        </div>

        @if($categories->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($categories as $category)
                    @include('components.shop.category-card', ['category' => $category])
                @endforeach
            </div>

            <div class="mt-12">
                {{ $categories->links() }}
            </div>
        @else
            <div class="card p-12 text-center">
                <svg class="mx-auto mb-4 h-16 w-16 text-ocean-primary/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">No categories found</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Check back soon for new categories.</p>
                <a href="{{ route('shop.home') }}" class="btn-primary mt-6 inline-flex">Back to Home</a>
            </div>
        @endif
    </div>
@endsection
