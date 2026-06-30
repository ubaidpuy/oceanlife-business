@extends('layouts.shop')

@section('title', 'Shopping Cart - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @include('components.shop.breadcrumb', [
            'items' => ['Cart' => null],
        ])

        <h1 class="section-title mb-10">Shopping Cart</h1>

        @if($lineItems->isNotEmpty())
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    {{-- Desktop table --}}
                    <div class="card hidden overflow-hidden md:block">
                        <table class="w-full">
                            <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Product</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Price</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Quantity</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Subtotal</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($lineItems as $item)
                                    @php
                                        $product = $item['product'];
                                        $image = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-gray-100">
                                                    @if($image)
                                                        <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-ocean-primary/10 to-ocean-secondary/10">
                                                            <svg class="h-8 w-8 text-ocean-primary/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('shop.products.show', $product) }}" class="font-semibold text-gray-900 hover:text-ocean-primary dark:text-white">
                                                        {{ $product->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            ${{ number_format($item['price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('shop.cart.update', $product->id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    value="{{ $item['quantity'] }}"
                                                    min="1"
                                                    max="{{ $product->stock }}"
                                                    class="input-field w-20 py-2 text-center"
                                                >
                                                <button type="submit" class="text-sm font-medium text-ocean-primary hover:text-ocean-dark">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-ocean-primary">
                                            ${{ number_format($item['subtotal'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('shop.cart.remove', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:text-red-700">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile cards --}}
                    <div class="space-y-4 md:hidden">
                        @foreach($lineItems as $item)
                            @php
                                $product = $item['product'];
                                $image = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                            @endphp
                            <div class="card p-4">
                                <div class="flex gap-4">
                                    <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-gray-100">
                                        @if($image)
                                            <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-ocean-primary/10 to-ocean-secondary/10">
                                                <svg class="h-8 w-8 text-ocean-primary/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <a href="{{ route('shop.products.show', $product) }}" class="font-semibold text-gray-900 hover:text-ocean-primary dark:text-white">
                                            {{ $product->name }}
                                        </a>
                                        <p class="mt-1 text-sm font-medium text-ocean-primary">${{ number_format($item['price'], 2) }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <form action="{{ route('shop.cart.update', $product->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item['quantity'] }}"
                                            min="1"
                                            max="{{ $product->stock }}"
                                            class="input-field w-20 py-2 text-center"
                                        >
                                        <button type="submit" class="text-sm font-medium text-ocean-primary">Update</button>
                                    </form>
                                    <form action="{{ route('shop.cart.remove', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500">Remove</button>
                                    </form>
                                </div>
                                <p class="mt-2 text-right text-sm font-semibold text-gray-900 dark:text-white">
                                    Subtotal: ${{ number_format($item['subtotal'], 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('shop.products.index') }}" class="text-sm font-semibold text-ocean-primary hover:text-ocean-dark">
                            &larr; Continue Shopping
                        </a>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="card sticky top-24 p-6">
                        <h2 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Order Summary</h2>
                        <dl class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <dt class="text-gray-600 dark:text-gray-300">Subtotal</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</dd>
                            </div>
                            <div class="flex justify-between text-sm">
                                <dt class="text-gray-600 dark:text-gray-300">Shipping</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($shippingTotal, 2) }}</dd>
                            </div>
                            <div class="border-t border-gray-200 pt-4 dark:border-gray-700">
                                <div class="flex justify-between">
                                    <dt class="text-base font-semibold text-gray-900 dark:text-white">Grand Total</dt>
                                    <dd class="text-xl font-bold text-ocean-primary">${{ number_format($grandTotal, 2) }}</dd>
                                </div>
                            </div>
                        </dl>
                        <a href="{{ route('shop.checkout.index') }}" class="btn-primary mt-6 w-full">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="card p-12 text-center">
                <svg class="mx-auto mb-4 h-20 w-20 text-ocean-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Your cart is empty</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Looks like you haven't added any products yet.</p>
                <a href="{{ route('shop.products.index') }}" class="btn-primary mt-8 inline-flex">Start Shopping</a>
            </div>
        @endif
    </div>
@endsection
