<?php

namespace App\Filter\Modifier;

use App\Entity\Promotion;
use App\PromotionEnquiryInterface;

class FixedPriceVoucher implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        //check if given voucher is valid

        if (!isset($promotion->getCriteria()['code'])) {
            return $price * $quantity;
        }

        if ($promotion->getCriteria()['code'] !== $enquiry->getVoucherCode()) {
            return $price * $quantity;

        }

        return ($price * $quantity) - $promotion->getAdjustment();
    }
}
