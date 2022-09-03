<?php

namespace App\Filter;

use App\Entity\Promotion;
use App\PromotionEnquiryInterface;

interface PromotionFilterInterface
{
    public function apply(PromotionEnquiryInterface $enquiry, Promotion ...$promotion): PromotionEnquiryInterface;
}
