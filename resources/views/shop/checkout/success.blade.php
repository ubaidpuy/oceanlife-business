@extends('layouts.shop')

@section('title', 'Order Confirmed - ' . ($shopSettings->shop_name ?? 'Ocean Life'))

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-ocean-secondary/10">
                <svg class="h-10 w-10 text-ocean-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Thank You for Your Order!</h1>
            <p class="mt-3 text-gray-600 dark:text-gray-300">Your order has been placed successfully.</p>
        </div>

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
                                    <p class="text-gray-500">Qty: {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</p>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">${{ number_format($item->subtotal, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="mt-6 space-y-2 border-t border-gray-200 pt-4 text-sm dark:border-gray-700">
                        <div class="flex justify-between">
                            <dt class="text-gray-600 dark:text-gray-300">Subtotal</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($order->subtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600 dark:text-gray-300">Shipping</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($order->shipping_total, 2) }}</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2 dark:border-gray-700">
                            <dt class="font-semibold text-gray-900 dark:text-white">Grand Total</dt>
                            <dd class="text-lg font-bold text-ocean-primary">${{ number_format($order->grand_total, 2) }}</dd>
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
