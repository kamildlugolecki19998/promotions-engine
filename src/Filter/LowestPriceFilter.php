<?php

namespace App\Filter;

use App\Entity\Promotion;
use App\PromotionEnquiryInterface;

class LowestPriceFilter implements PromotionFilterInterface
{

    public function apply(PromotionEnquiryInterface $enquiry, Promotion ...$promotion): PromotionEnquiryInterface
    {
        $enquiry->setDiscountedPrice(50);
        $enquiry->setPrice(100);
        $enquiry->setPromotionId(3);
        $enquiry->setPromotionName('Black friday half price sale');

        return $enquiry;
    }
}
