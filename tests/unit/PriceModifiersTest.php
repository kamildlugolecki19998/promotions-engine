<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\FixedPriceVoucher;
use App\Tests\ServiceTestCase;

class PriceModifiersTest extends ServiceTestCase
{
    /** @test */
    public function DateRangeMultiplierReturnsACorrectlyModifiedPrice(): void
    {
        //Given

        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setRequestDate("2022-11-27");

        $promotion = new Promotion();
        $promotion->setName('Black friday half price sale');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotion->setType('date_range_multiplier');

        $dateRangeModifier = new DateRangeMultiplier();

        //When
        $modifiedPrice = $dateRangeModifier->modify(100, 5, $promotion, $enquiry);


        //Then
        $this->assertEquals(250, $modifiedPrice);
    }
    /** @test */
    public function fixedDateVoucher(): void
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setVoucherCode("OU812");


        $promotion = new Promotion();
        $promotion->setName('Voucher OU812');
        $promotion->setAdjustment(100);
        $promotion->setCriteria(["code" => "OU812"]);
//        $promotion->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotion->setType('fixed_price_voucher');

        $fixedPriceModifier = new FixedPriceVoucher();
        $modifiedPrice = $fixedPriceModifier->modify(100, 5, $promotion, $enquiry);

        $this->assertEquals(400, $modifiedPrice);
    }
}
