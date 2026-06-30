<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\CartAddRequest;
use App\Http\Requests\Shop\CartUpdateRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View
    {
        return view('shop.cart.index', [
            'lineItems' => $this->cart->getLineItems(),
            'subtotal' => $this->cart->subtotal(),
            'shippingTotal' => $this->cart->shippingTotal(),
            'grandTotal' => $this->cart->grandTotal(),
        ]);
    }

    public function add(CartAddRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->status && $product->stock > 0, 404);

        $this->cart->add($product, $request->validated('quantity'));

        return back()->with('success', 'Product added to cart.');
    }

    public function update(CartUpdateRequest $request, int $productId): RedirectResponse
    {
        $this->cart->update($productId, $request->validated('quantity'));

        return back()->with('success', 'Cart updated.');
    }

    public function remove(int $productId): RedirectResponse
    {
        $this->cart->remove($productId);

        return back()->with('success', 'Item removed from cart.');
    }
}
