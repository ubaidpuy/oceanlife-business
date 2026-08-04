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
                <form
                    action="{{ route('shop.checkout.store') }}"
                    method="POST"
                    class="card p-6 lg:p-8"
                    x-data="{ paymentMethod: @js(old('payment_method', 'cash_on_delivery')), copied: '' }"
                >
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

                    <section class="mt-10 border-t border-gray-200 pt-8 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Payment Method</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose how you would like to pay for your order.</p>

                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            <label
                                class="flex cursor-pointer items-start gap-3 rounded-2xl border-2 p-4 transition"
                                :class="paymentMethod === 'cash_on_delivery' ? 'border-ocean-primary bg-ocean-primary/5' : 'border-gray-200 hover:border-ocean-primary/40 dark:border-gray-700'"
                            >
                                <input type="radio" name="payment_method" value="cash_on_delivery" x-model="paymentMethod" class="mt-1 text-ocean-primary focus:ring-ocean-primary" required>
                                <span>
                                    <span class="block font-semibold text-gray-900 dark:text-white">Cash on Delivery</span>
                                    <span class="mt-1 block text-sm text-gray-500 dark:text-gray-400">Pay when your order is delivered.</span>
                                </span>
                            </label>

                            <label
                                class="flex cursor-pointer items-start gap-3 rounded-2xl border-2 p-4 transition"
                                :class="paymentMethod === 'bank_or_jazzcash' ? 'border-ocean-primary bg-ocean-primary/5' : 'border-gray-200 hover:border-ocean-primary/40 dark:border-gray-700'"
                            >
                                <input type="radio" name="payment_method" value="bank_or_jazzcash" x-model="paymentMethod" class="mt-1 text-ocean-primary focus:ring-ocean-primary" required>
                                <span>
                                    <span class="block font-semibold text-gray-900 dark:text-white">Bank / JazzCash Payment</span>
                                    <span class="mt-1 block text-sm text-gray-500 dark:text-gray-400">Pay in advance and send your receipt on WhatsApp.</span>
                                </span>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <div x-cloak x-show="paymentMethod === 'bank_or_jazzcash'" x-transition class="mt-6 space-y-5 rounded-2xl border border-ocean-primary/20 bg-cyan-50/60 p-5 dark:bg-gray-900/40 sm:p-6">
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
                                    <h3 class="font-bold text-ocean-primary">JazzCash</h3>
                                    <dl class="mt-3 space-y-2 text-sm">
                                        <div><dt class="text-gray-500">Account / Number</dt><dd class="font-semibold text-gray-900 dark:text-white">0300-4290159</dd></div>
                                        <div><dt class="text-gray-500">Account Name</dt><dd class="font-semibold text-gray-900 dark:text-white">Kamran Ahmad</dd></div>
                                    </dl>
                                </div>
                                <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
                                    <h3 class="font-bold text-ocean-primary">Bank Alfalah</h3>
                                    <dl class="mt-3 space-y-2 text-sm">
                                        <div><dt class="text-gray-500">Account Number</dt><dd class="break-all font-semibold text-gray-900 dark:text-white">55065001802963</dd></div>
                                        <div><dt class="text-gray-500">Account Title</dt><dd class="font-semibold text-gray-900 dark:text-white">Ubaid Ur Rehman</dd></div>
                                    </dl>
                                </div>
                            </div>

                            <div class="rounded-xl border-l-4 border-amber-500 bg-amber-50 p-4 dark:bg-amber-950/30">
                                <p class="font-semibold text-amber-900 dark:text-amber-200">Payment screenshot required</p>
                                <p class="mt-2 text-sm text-amber-800 dark:text-amber-300">After making the payment, send a screenshot of your payment receipt on WhatsApp.</p>
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    <span class="text-sm font-medium text-amber-900 dark:text-amber-200">WhatsApp Number:</span>
                                    <a href="https://wa.me/923044605447" target="_blank" rel="noopener" class="text-lg font-bold text-green-700 underline decoration-green-700/30 underline-offset-4">0304-4605447</a>
                                    <button
                                        type="button"
                                        class="rounded-lg border border-amber-300 bg-white px-3 py-1.5 text-xs font-semibold text-amber-900 hover:bg-amber-100"
                                        @click="navigator.clipboard.writeText('0304-4605447'); copied = 'whatsapp'; setTimeout(() => copied = '', 2000)"
                                        x-text="copied === 'whatsapp' ? 'Copied!' : 'Copy'"
                                    >Copy</button>
                                </div>
                                <p class="mt-4 font-bold text-red-700 dark:text-red-300">Your order will only be confirmed after we receive and verify your payment screenshot on WhatsApp.</p>
                            </div>
                        </div>
                    </section>

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
                                <x-currency :amount="$item['subtotal']" class="items-end" />
                            </li>
                        @endforeach
                    </ul>

                    <dl class="space-y-3 border-t border-gray-200 pt-4 dark:border-gray-700">
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600 dark:text-gray-300">Subtotal</dt>
                            <dd><x-currency :amount="$subtotal" class="items-end" /></dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-600 dark:text-gray-300">Shipping</dt>
                            <dd><x-currency :amount="$shippingTotal" class="items-end" /></dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-3 dark:border-gray-700">
                            <dt class="font-semibold text-gray-900 dark:text-white">Grand Total</dt>
                            <dd><x-currency :amount="$grandTotal" class="items-end" amount-class="text-xl font-bold text-ocean-primary" /></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
