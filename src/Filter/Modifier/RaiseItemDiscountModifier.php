<?php

namespace App\Filter\Modifier;

use App\Entity\Promotion;
use App\PromotionEnquiryInterface;

class RaiseItemDiscountModifier implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        $minimumQuantity = date_create($promotion->getCriteria()["minimum_quantity"]);

        if($quantity < $minimumQuantity){
            return  $price * $quantity;
        }

        $percentDiscount = $promotion->getAdjustment() * $quantity;
        $discount  = ($price * $quantity) * $percentDiscount;
//     dd($discount, $percentDiscount);
        return ($price * $quantity) - $discount;
    }
}
