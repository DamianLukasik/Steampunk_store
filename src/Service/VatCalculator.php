<?php
namespace App\Service;

class VatCalculator
{
    private const VAT_RATE = 0.23;

    public function calculate(float $subtotal): float
    {
        return $subtotal * self::VAT_RATE;
    }
}
