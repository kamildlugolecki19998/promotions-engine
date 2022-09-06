<?php

namespace App\Filter\Modifier;

use App\Entity\Promotion;
use App\PromotionEnquiryInterface;

class RaiseItemDiscountModifier implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        if($quantity < 3){
            return  $price * $quantity;
        }



        if(!$promotion->getType() === "if_more_then_less") {
            return $price * $quantity;
        }
        $requestDate = date_create($enquiry->getRequestDate());
        $from = date_create($promotion->getCriteria()['from']);
        $to = date_create($promotion->getCriteria()['to']);

//        dd($requestDate, $from, $to);
        if(!($from <= $requestDate && $to > $requestDate)){
            return $price * $quantity;
        }


        $percentDiscount = $promotion->getAdjustment() * $quantity;
        $discount  = ($price * $quantity) * $percentDiscount;

        return ($price * $quantity) - $discount;
    }
}
