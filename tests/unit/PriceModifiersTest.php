<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\FixedPriceVoucher;
use App\Filter\Modifier\RaiseItemDiscountModifier;
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

    /** @test  */
    public function raiseItemDiscount(): void
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setRequestDate("2022-09-03");

        $promotion = new Promotion();
        $promotion->setName("If more then less");
        $promotion->setAdjustment(0.05);
        $promotion->setCriteria(["from" => "2022-08-01", "to" => "2022-10-15", "maxItem" => 15]);
        $promotion->setType('if_more_then_less');

        $raiseItemDiscountModifier = new RaiseItemDiscountModifier();
        $modifiedPrice = $raiseItemDiscountModifier->modify(30, 15, $promotion, $enquiry);

        $this->assertEquals(112, $modifiedPrice);
    }
}
