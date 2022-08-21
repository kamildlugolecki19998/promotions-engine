<?php

namespace App\Filter;

use App\PromotionEnquiryInterface;

interface PromotionFilterInterface
{
    public function apply(PromotionEnquiryInterface $enquiry): PromotionEnquiryInterface;
}
