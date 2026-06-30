@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card
            label="Total Products"
            :value="$totalProducts"
            icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
            color="ocean-primary"
        />
        <x-admin.stat-card
            label="Total Categories"
            :value="$totalCategories"
            icon="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
            color="ocean-secondary"
        />
        <x-admin.stat-card
            label="Total Orders"
            :value="$totalOrders"
            icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
            color="ocean-dark"
        />
        <x-admin.stat-card
            label="Pending Orders"
            :value="$pendingOrders"
            icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
            color="yellow-500"
        />
    </div>

    <div class="card mt-8 overflow-hidden">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Latest Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-ocean-primary hover:text-ocean-dark">View all</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Order #</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($latestOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4 text-gray-900">${{ number_format($order->grand_total, 2) }}</td>
                            <td class="px-6 py-4">
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
                                <span class="badge {{ $badgeClass }}">{{ $order->status_label }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-ocean-primary hover:text-ocean-dark">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
