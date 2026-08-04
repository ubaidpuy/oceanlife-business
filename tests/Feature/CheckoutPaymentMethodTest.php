<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutPaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_cash_on_delivery_order_uses_normal_pending_status(): void
    {
        $product = $this->product();

        $response = $this->withSession($this->cart($product))->post(route('shop.checkout.store'), $this->checkoutData([
            'payment_method' => 'cash_on_delivery',
        ]));

        $order = Order::firstOrFail();
        $response->assertRedirect(route('shop.checkout.success', $order));
        $this->assertSame('cash_on_delivery', $order->payment_method);
        $this->assertSame('pending', $order->status);
        $this->assertSame('250.00', $order->shipping_total);
    }

    public function test_advance_payment_order_waits_for_payment_verification(): void
    {
        $product = $this->product();

        $response = $this->withSession($this->cart($product))->post(route('shop.checkout.store'), $this->checkoutData([
            'payment_method' => 'bank_or_jazzcash',
        ]));

        $order = Order::firstOrFail();
        $response->assertRedirect(route('shop.checkout.success', $order));
        $this->assertSame('bank_or_jazzcash', $order->payment_method);
        $this->assertSame('payment_verification_pending', $order->status);

        $this->get(route('shop.checkout.success', $order))
            ->assertOk()
            ->assertSee('Payment Verification Pending')
            ->assertSee('0304-4605447');
    }

    public function test_checkout_rejects_an_unknown_payment_method(): void
    {
        $product = $this->product();

        $this->withSession($this->cart($product))
            ->from(route('shop.checkout.index'))
            ->post(route('shop.checkout.store'), $this->checkoutData(['payment_method' => 'unknown']))
            ->assertRedirect(route('shop.checkout.index'))
            ->assertSessionHasErrors('payment_method');

        $this->assertDatabaseCount('orders', 0);
    }

    private function product(): Product
    {
        $category = Category::create(['name' => 'Aquariums', 'status' => true]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Ocean Tank',
            'description' => 'A test aquarium.',
            'price' => 5000,
            'shipping_charge' => 250,
            'stock' => 5,
            'status' => true,
        ]);
    }

    private function cart(Product $product): array
    {
        return ['cart' => [$product->id => ['product_id' => $product->id, 'quantity' => 2]]];
    }

    private function checkoutData(array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Test Customer',
            'phone' => '03001234567',
            'email' => 'customer@example.com',
            'address' => '123 Ocean Road',
            'city' => 'Lahore',
            'state' => 'Punjab',
            'postal_code' => '54000',
            'country' => 'Pakistan',
        ], $overrides);
    }
}
