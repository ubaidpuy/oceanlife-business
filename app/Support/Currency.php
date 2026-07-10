<?php

namespace App\Support;

class Currency
{
    public static function format(float|int|string|null $amount): string
    {
        return 'Rs '.number_format((float) $amount, 2);
    }
}
