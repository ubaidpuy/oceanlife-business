@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order ' . $order->order_number)

@section('content')
    @php
        $colorMap = [
            'yellow' => 'bg-yellow-100 text-yellow-800',
            'blue' => 'bg-blue-100 text-blue-800',
            'indigo' => 'bg-indigo-100 text-indigo-800',
            'green' => 'bg-green-100 text-green-800',
            'red' => 'bg-red-100 text-red-800',
            'gray' => 'bg-gray-100 text-gray-800',
        ];
        $badgeClass = $colorMap[$order->status_color] ?? $colorMap['gray'];
    @endphp

    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-ocean-primary">
            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Orders
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="card p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                    <span class="badge {{ $badgeClass }}">{{ $order->status_label }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-gray-100 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="pb-3 pr-4">Product</th>
                                <th class="pb-3 pr-4">Price</th>
                                <th class="pb-3 pr-4">Shipping</th>
                                <th class="pb-3 pr-4">Qty</th>
                                <th class="pb-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="py-4 pr-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $itemImage = $item->product?->images->firstWhere('is_primary', true) ?? $item->product?->images->first();
                                            @endphp
                                            @if($itemImage)
                                                <img src="{{ $itemImage->url }}" alt="{{ $item->product_name }}" class="h-12 w-12 rounded-lg object-cover">
                                            @else
                                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                            <span class="font-medium text-gray-900">{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 pr-4 text-gray-600">${{ number_format($item->price, 2) }}</td>
                                    <td class="py-4 pr-4 text-gray-600">${{ number_format($item->shipping_charge, 2) }}</td>
                                    <td class="py-4 pr-4 text-gray-600">{{ $item->quantity }}</td>
                                    <td class="py-4 text-right font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-gray-200">
                            <tr>
                                <td colspan="4" class="pt-4 text-right text-gray-600">Subtotal</td>
                                <td class="pt-4 text-right font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="pt-2 text-right text-gray-600">Shipping</td>
                                <td class="pt-2 text-right font-medium text-gray-900">${{ number_format($order->shipping_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="pt-2 text-right text-lg font-semibold text-gray-900">Grand Total</td>
                                <td class="pt-2 text-right text-lg font-bold text-ocean-primary">${{ number_format($order->grand_total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($order->notes)
                <div class="card p-6">
                    <h2 class="mb-2 text-lg font-semibold text-gray-900">Order Notes</h2>
                    <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="card p-6">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Customer Details</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Name</dt>
                        <dd class="text-gray-900">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Email</dt>
                        <dd class="text-gray-900">{{ $order->email }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Phone</dt>
                        <dd class="text-gray-900">{{ $order->phone }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Address</dt>
                        <dd class="text-gray-900">
                            {{ $order->address }}<br>
                            {{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>
                            {{ $order->country }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="card p-6">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Order Info</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Order Number</dt>
                        <dd class="text-gray-900">{{ $order->order_number }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Placed On</dt>
                        <dd class="text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Items</dt>
                        <dd class="text-gray-900">{{ $order->items->sum('quantity') }} item(s)</dd>
                    </div>
                </dl>
            </div>

            <div class="card p-6">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Update Status</h2>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" required class="input-field @error('status') border-red-500 @enderror">
                            @foreach(\App\Models\Order::STATUSES as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $order->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary w-full">Update Status</button>
                </form>
            </div>
        </div>
    </div>
@endsection
