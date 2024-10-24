<?php

namespace App\Helpers;

use Illuminate\Support\Number;

class Sanitize
{
    /**
     * Formatt the amount according with the currency.
     *
     * @param float $amount
     * @return string
     */
    public static function formatCurrency($amount, $currency)
    {
        if($currency == 'BRL') {
            return 'R$ ' . number_format($amount, 2, ',', '.');
        }

        return Number::currency($amount, in: $currency);
    }
}
