<?php
namespace App\Service;
use Doctrine\Common\Collections\Collection;

class SubtotalCalculator
{
    public function calculate(Collection $orderItems): float
    {
        $totalPrice = 0;
        foreach ($orderItems as $orderItem) {
            $totalPrice += $orderItem->getProduct()->getPrice() * $orderItem->getQuantity();
        }
        return $totalPrice;
    }
}
