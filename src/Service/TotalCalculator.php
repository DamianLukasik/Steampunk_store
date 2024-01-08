<?php
namespace App\Service;

class TotalCalculator
{
    public function calculate(float $subtotal, float $vat): float
    {
        return $subtotal + $vat;
    }
}
