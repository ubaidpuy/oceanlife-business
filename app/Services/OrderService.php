<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(private CartService $cart) {}

    public function createFromCart(array $customerData): Order
    {
        $lineItems = $this->cart->getLineItems();

        if ($lineItems->isEmpty()) {
            throw new \RuntimeException('Cart is empty.');
        }

        return DB::transaction(function () use ($lineItems, $customerData) {
            $subtotal = $this->cart->subtotal();
            $shippingTotal = $this->cart->shippingTotal();

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'customer_name' => $customerData['customer_name'],
                'phone' => $customerData['phone'],
                'email' => $customerData['email'] ?? null,
                'address' => $customerData['address'],
                'city' => $customerData['city'],
                'state' => $customerData['state'],
                'postal_code' => $customerData['postal_code'],
                'country' => $customerData['country'],
                'notes' => $customerData['notes'] ?? null,
                'subtotal' => $subtotal,
                'shipping_total' => $shippingTotal,
                'grand_total' => $subtotal + $shippingTotal,
                'status' => 'pending',
            ]);

            foreach ($lineItems as $line) {
                $product = $line['product'];

                Product::where('id', $product->id)
                    ->where('stock', '>=', $line['quantity'])
                    ->decrement('stock', $line['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $line['price'],
                    'shipping_charge' => $line['shipping_charge'],
                    'quantity' => $line['quantity'],
                    'subtotal' => $line['subtotal'],
                ]);
            }

            $this->cart->clear();

            return $order->load('items');
        });
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'OL-'.strtoupper(Str::random(8));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
