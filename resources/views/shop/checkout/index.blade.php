@extends('layouts.shop')

@section('title', 'Checkout - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @include('components.shop.breadcrumb', [
            'items' => [
                'Cart' => route('shop.cart.index'),
                'Checkout' => null,
            ],
        ])

        <h1 class="section-title mb-10">Checkout</h1>

        <div class="grid gap-8 lg:grid-cols-3">
            {{-- Shipping Form --}}
            <div class="lg:col-span-2">
                <form action="{{ route('shop.checkout.store') }}" method="POST" class="card p-6 lg:p-8">
                    @csrf

                    <h2 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Shipping Information</h2>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="customer_name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                id="customer_name"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                required
                                class="input-field @error('customer_name') border-red-500 @enderror"
                            >
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Phone <span class="text-red-500">*</span></label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                required
                                class="input-field @error('phone') border-red-500 @enderror"
                            >
                            @error('phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-gray-400">(optional)</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="input-field @error('email') border-red-500 @enderror"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Address <span class="text-red-500">*</span></label>
                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                required
                                class="input-field @error('address') border-red-500 @enderror"
                            >{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">City <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="{{ old('city') }}"
                                required
                                class="input-field @error('city') border-red-500 @enderror"
                            >
                            @error('city')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">State / Province <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                id="state"
                                name="state"
                                value="{{ old('state') }}"
                                required
                                class="input-field @error('state') border-red-500 @enderror"
                            >
                            @error('state')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                id="postal_code"
                                name="postal_code"
                                value="{{ old('postal_code') }}"
                                required
                                class="input-field @error('postal_code') border-red-500 @enderror"
                            >
                            @error('postal_code')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Country <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                id="country"
                                name="country"
                                value="{{ old('country') }}"
                                required
                                class="input-field @error('country') border-red-500 @enderror"
                            >
                            @error('country')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="notes" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Order Notes <span class="text-gray-400">(optional)</span></label>
                            <textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                placeholder="Special delivery instructions..."
                                class="input-field @error('notes') border-red-500 @enderror"
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <button type="submit" class="btn-primary">Place Order</button>
                        <a href="{{ route('shop.cart.index') }}" class="btn-outline">Back to Cart</a>
                    </div>
                </form>
            </div>

            {{-- Order Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card sticky top-24 p-6">
                    <h2 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Order Summary</h2>

                    <ul class="mb-6 max-h-64 space-y-4 overflow-y-auto">
                        @foreach($lineItems as $item)
                            @php $product = $item['product']; @endphp
                            <li class="flex items-start justify-between gap-3 text-sm">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</p>
                                    <p class="text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">${{ number_format($item['subtotal'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="space-y-3 border-t border-gray-200 pt-4 dark:border-gray-700">
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600 dark:text-gray-300">Subtotal</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600 dark:text-gray-300">Shipping</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($shippingTotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-3 dark:border-gray-700">
                            <dt class="font-semibold text-gray-900 dark:text-white">Grand Total</dt>
                            <dd class="text-xl font-bold text-ocean-primary">${{ number_format($grandTotal, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
