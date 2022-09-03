<?php

namespace App\Filter;

use App\Entity\Promotion;
use App\PromotionEnquiryInterface;

class LowestPriceFilter implements PromotionFilterInterface
{

    public function apply(PromotionEnquiryInterface $enquiry, Promotion ...$promotion): PromotionEnquiryInterface
    {
        $price = $enquiry->getProduct()->getPrice();
        $quantity = $enquiry->getQuantity();
        $lowestPrice = $quantity * $price;


//        $modifiedPrice = $priceModifier->modify($price, $quantity, $promotion, $enquiry);




        $enquiry->setDiscountedPrice(250);
        $enquiry->setPrice(100);
        $enquiry->setPromotionId(3);
        $enquiry->setPromotionName('Black friday half price sale');

        return $enquiry;
    }
}
