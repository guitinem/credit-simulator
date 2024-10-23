<?php

namespace App\Helpers;

use Illuminate\Support\Number;

class Sanitize
{
    /**
     * Formata um valor monetário para BRL.
     *
     * @param float $amount
     * @return string
     */
    public static function formatCurrencyBRL($amount)
    {
        return 'R$ ' . number_format($amount, 2, ',', '.');
    }
}
