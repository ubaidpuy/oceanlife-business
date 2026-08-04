@extends('layouts.shop')

@section('title', 'Order Received - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full {{ $order->payment_method === 'bank_or_jazzcash' ? 'bg-amber-100' : 'bg-ocean-secondary/10' }}">
                @if($order->payment_method === 'bank_or_jazzcash')
                    <svg class="h-10 w-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
                @else
                    <svg class="h-10 w-10 text-ocean-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                @endif
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $order->payment_method === 'bank_or_jazzcash' ? 'Order Received — Payment Verification Pending' : 'Thank You for Your Order!' }}</h1>
            <p class="mt-3 text-gray-600 dark:text-gray-300">{{ $order->payment_method === 'bank_or_jazzcash' ? 'Complete the step below so we can confirm your order.' : 'Your order has been placed successfully.' }}</p>
        </div>

        @if($order->payment_method === 'bank_or_jazzcash')
            <div class="mt-8 rounded-2xl border-2 border-amber-400 bg-amber-50 p-5 dark:bg-amber-950/30 sm:p-6">
                <h2 class="text-lg font-bold text-amber-900 dark:text-amber-200">Send your payment screenshot on WhatsApp</h2>
                <p class="mt-2 text-amber-800 dark:text-amber-300">After making the payment, send a screenshot of your payment receipt to:</p>
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <a href="https://wa.me/923044605447" target="_blank" rel="noopener" class="text-2xl font-bold text-green-700 underline decoration-green-700/30 underline-offset-4">0304-4605447</a>
                    <button type="button" class="rounded-lg border border-amber-300 bg-white px-3 py-2 text-sm font-semibold text-amber-900 hover:bg-amber-100" onclick="navigator.clipboard.writeText('0304-4605447'); this.textContent='Copied!'; setTimeout(() => this.textContent='Copy', 2000)">Copy</button>
                </div>
                <p class="mt-4 font-bold text-red-700 dark:text-red-300">Your order is not confirmed yet. It will only be confirmed after we receive and verify your payment screenshot on WhatsApp.</p>
            </div>
        @endif

        <div class="card mt-10 p-6 lg:p-8">
            <div class="mb-8 flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 pb-6 dark:border-gray-700">
                <div>
                    <p class="text-sm text-gray-500">Order Number</p>
                    <p class="text-2xl font-bold text-ocean-primary">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Status</p>
                    @php
                        $statusClasses = match($order->status) {
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'payment_verification_pending' => 'bg-orange-100 text-orange-700',
                            'confirmed' => 'bg-blue-100 text-blue-700',
                            'shipped' => 'bg-indigo-100 text-indigo-700',
                            'delivered' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <span class="badge {{ $statusClasses }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            <div class="mb-6 border-b border-gray-200 pb-6 dark:border-gray-700">
                <p class="text-sm text-gray-500">Payment Method</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $order->payment_method_label }}</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2">
                <div>
                    <h2 class="mb-4 font-semibold text-gray-900 dark:text-white">Shipping Details</h2>
                    <dl class="space-y-2 text-sm">
                        <div>
                            <dt class="text-gray-500">Name</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $order->customer_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Phone</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $order->phone }}</dd>
                        </div>
                        @if($order->email)
                            <div>
                                <dt class="text-gray-500">Email</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">{{ $order->email }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-gray-500">Address</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">
                                {{ $order->address }}<br>
                                {{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>
                                {{ $order->country }}
                            </dd>
                        </div>
                        @if($order->notes)
                            <div>
                                <dt class="text-gray-500">Notes</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">{{ $order->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div>
                    <h2 class="mb-4 font-semibold text-gray-900 dark:text-white">Order Items</h2>
                    <ul class="space-y-3">
                        @foreach($order->items as $item)
                            <li class="flex items-center justify-between text-sm">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $item->product_name }}</p>
                                    <p class="text-gray-500">Qty: {{ $item->quantity }} &times; {{ \App\Support\Currency::format($item->price) }}</p>
                                </div>
                                <x-currency :amount="$item->subtotal" class="items-end" />
                            </li>
                        @endforeach
                    </ul>

                    <dl class="mt-6 space-y-2 border-t border-gray-200 pt-4 text-sm dark:border-gray-700">
                        <div class="flex justify-between">
                            <dt class="text-gray-600 dark:text-gray-300">Subtotal</dt>
                            <dd><x-currency :amount="$order->subtotal" class="items-end" /></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600 dark:text-gray-300">Shipping</dt>
                            <dd><x-currency :amount="$order->shipping_total" class="items-end" /></dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2 dark:border-gray-700">
                            <dt class="font-semibold text-gray-900 dark:text-white">Grand Total</dt>
                            <dd><x-currency :amount="$order->grand_total" class="items-end" amount-class="text-lg font-bold text-ocean-primary" /></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-gray-500">
                Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
            </p>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('shop.products.index') }}" class="btn-primary">Continue Shopping</a>
            <a href="{{ route('shop.home') }}" class="btn-outline">Back to Home</a>
        </div>
    </div>
@endsection
