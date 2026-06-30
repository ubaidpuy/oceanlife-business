<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'cart';

    public function items(): Collection
    {
        return collect(session(self::SESSION_KEY, []));
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $cart = $this->items();
        $productId = $product->id;
        $existing = $cart->get($productId, [
            'product_id' => $productId,
            'quantity' => 0,
        ]);

        $newQuantity = min($existing['quantity'] + $quantity, $product->stock);
        $cart->put($productId, [
            'product_id' => $productId,
            'quantity' => $newQuantity,
        ]);

        session([self::SESSION_KEY => $cart->all()]);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->items();

        if ($quantity <= 0) {
            $this->remove($productId);

            return;
        }

        $product = Product::findOrFail($productId);
        $cart->put($productId, [
            'product_id' => $productId,
            'quantity' => min($quantity, $product->stock),
        ]);

        session([self::SESSION_KEY => $cart->all()]);
    }

    public function remove(int $productId): void
    {
        $cart = $this->items();
        $cart->forget($productId);
        session([self::SESSION_KEY => $cart->all()]);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return $this->items()->sum('quantity');
    }

    public function isEmpty(): bool
    {
        return $this->items()->isEmpty();
    }

    public function getLineItems(): Collection
    {
        $productIds = $this->items()->keys()->all();
        $products = Product::with(['images', 'category'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        return $this->items()->map(function (array $item) use ($products) {
            $product = $products->get($item['product_id']);

            if (! $product) {
                return null;
            }

            $price = $product->effective_price;
            $shipping = (float) ($product->shipping_charge ?? 0);
            $quantity = $item['quantity'];

            return [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'shipping_charge' => $shipping,
                'subtotal' => $price * $quantity,
                'shipping_subtotal' => $shipping * $quantity,
            ];
        })->filter()->values();
    }

    public function subtotal(): float
    {
        return (float) $this->getLineItems()->sum('subtotal');
    }

    public function shippingTotal(): float
    {
        return (float) $this->getLineItems()->sum('shipping_subtotal');
    }

    public function grandTotal(): float
    {
        return $this->subtotal() + $this->shippingTotal();
    }
}
