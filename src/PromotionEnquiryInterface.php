<?php

namespace App;

use App\Entity\Product;
use Symfony\Component\Serializer\SerializerInterface;

interface PromotionEnquiryInterface //extends \JsonSerializable
{
    public function getProduct(): ?Product;

    public function setPromotionId(int $promotionId);

    public function setPromotionName(string $promotionName);
}
