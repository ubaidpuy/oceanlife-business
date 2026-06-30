<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private OrderService $orderService
    ) {}

    public function index(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('shop.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('shop.checkout.index', [
            'lineItems' => $this->cart->getLineItems(),
            'subtotal' => $this->cart->subtotal(),
            'shippingTotal' => $this->cart->shippingTotal(),
            'grandTotal' => $this->cart->grandTotal(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('shop.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        try {
            $order = $this->orderService->createFromCart($request->validated());
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('shop.checkout.success', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function success(\App\Models\Order $order): View
    {
        $order->load('items');

        return view('shop.checkout.success', compact('order'));
    }
}
