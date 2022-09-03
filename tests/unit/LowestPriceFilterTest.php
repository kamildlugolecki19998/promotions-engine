<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Filter\LowestPriceFilter;
use App\Tests\ServiceTestCase;

class LowestPriceFilterTest extends ServiceTestCase
{
    /** @test */
    public function lowestPricePromotionFilteringIsAppliedCorrectly(): void
    {
        //Given
        $enquiry = new LowestPriceEnquiry();

        $promotions = $this->promotionsDataProvider();
        $lowestPriceFilter = $this->container->get(LowestPriceFilter::class);

        //When
        $filteredEnquiry = $lowestPriceFilter->apply($enquiry, ...$promotions);

        //Then
        $this->assertSame(100, $filteredEnquiry->getPrice());
        $this->assertSame(50, $filteredEnquiry->getDiscountedPrice());
        $this->assertSame('Black friday half price sale', $filteredEnquiry->getPromotionName());
    }


    protected function promotionsDataProvider(): array
    {
        $promotionOne = new Promotion();
        $promotionOne->setName('Black friday half price sale');
        $promotionOne->setAdjustment(100);
        $promotionOne->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotionOne->setType('date_range_multiplier');

        $promotionTwo = new Promotion();
        $promotionTwo->setName('Voucher OU812');
        $promotionTwo->setAdjustment(0.5);
        $promotionTwo->setCriteria(["code" => "OU812"]);
        $promotionTwo->setType('fixed_price_voucher');

        $promotionThree = new Promotion();
        $promotionThree->setName('Boy one get one free');
        $promotionThree->setAdjustment(0.5);
        $promotionThree->setCriteria(["minimum_quantity" => 2]);
        $promotionThree->setType('event_items_multiplier');

        return [$promotionOne, $promotionTwo, $promotionThree];
    }
}
