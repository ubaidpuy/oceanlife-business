<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('items')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product.images');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(OrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->update(['status' => $request->validated('status')]);

        return back()->with('success', 'Order status updated successfully.');
    }
}
