<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const PAYMENT_METHODS = [
        'cash_on_delivery' => 'Cash on Delivery',
        'bank_or_jazzcash' => 'Bank / JazzCash Payment',
    ];

    public const STATUSES = [
        'pending' => 'Pending',
        'payment_verification_pending' => 'Payment Verification Pending',
        'confirmed' => 'Confirmed',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];

    protected $fillable = [
        'order_number',
        'customer_name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'notes',
        'payment_method',
        'subtotal',
        'shipping_total',
        'grand_total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_total' => 'decimal:2',
            'grand_total' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? ucfirst(str_replace('_', ' ', $this->payment_method));
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'payment_verification_pending' => 'orange',
            'confirmed' => 'blue',
            'shipped' => 'indigo',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }
}
