@extends('layouts.admin')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
    <div class="mb-6">
        <p class="text-sm text-gray-600">View and manage customer orders</p>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Order #</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
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
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <p class="text-gray-900">{{ $order->customer_name }}</p>
                                <p class="text-xs text-gray-500">{{ $order->email }}</p>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">${{ number_format($order->grand_total, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="badge {{ $badgeClass }}">{{ $order->status_label }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-ocean-primary hover:text-ocean-dark">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
