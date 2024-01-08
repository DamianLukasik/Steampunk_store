<?php
namespace App\Service;

use Doctrine\Common\Collections\Collection;

class OrderCalculator
{
    private SubtotalCalculator $subtotalCalculator;
    private VatCalculator $vatCalculator;
    private TotalCalculator $totalCalculator; 

    public function __construct(SubtotalCalculator $subtotalCalculator, VatCalculator $vatCalculator, TotalCalculator $totalCalculator)
    {
        $this->subtotalCalculator = $subtotalCalculator;
        $this->vatCalculator = $vatCalculator;
        $this->totalCalculator = $totalCalculator;
    }

    public function calculateOrderTotal(Collection $orderItems): array
    {
        $subtotal = $this->subtotalCalculator->calculate($orderItems);
        $vat = $this->vatCalculator->calculate($subtotal);
        $total =  $this->totalCalculator->calculate($subtotal, $vat);

        return [
            'subtotal' => $subtotal,
            'vat' => $vat,
            'total' => $total,
        ];
    }
}
