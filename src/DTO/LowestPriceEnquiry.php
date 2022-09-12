<?php

namespace App\DTO;

use App\Entity\Product;
use App\PromotionEnquiryInterface;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

class LowestPriceEnquiry implements PriceEnquiryInterface
{

    #[Ignore]
    private ?Product $product;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?int $quantity;

    private ?string $request_location;

    private ?string $voucher_code;

    #[Assert\NotBlank]
    private ?string $request_date;

    #[Assert\Positive]
    private ?int $price;

    private ?int $discounted_price;

    private ?int $promotion_id;

    private ?string $promotion_name;

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string|null
     */
    public function getRequestLocation(): ?string
    {
        return $this->request_location;
    }

    /**
     * @param string|null $request_location
     */
    public function setRequestLocation(?string $request_location): void
    {
        $this->request_location = $request_location;
    }

    /**
     * @return string|null
     */
    public function getVoucherCode(): ?string
    {
        return $this->voucher_code;
    }

    /**
     * @param string|null $voucher_code
     */
    public function setVoucherCode(?string $voucher_code): void
    {
        $this->voucher_code = $voucher_code;
    }

    /**
     * @return string|null
     */
    public function getRequestDate(): ?string
    {
        return $this->request_date;
    }

    /**
     * @param string|null $request_date
     */
    public function setRequestDate(?string $request_date): void
    {
        $this->request_date = $request_date;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }


    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     */
    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getDiscountedPrice(): ?int
    {
        return $this->discounted_price;
    }

    /**
     * @param int|null $discounted_price
     */
    public function setDiscountedPrice(?int $discounted_price): void
    {
        $this->discounted_price = $discounted_price;
    }

    /**
     * @return int|null
     */
    public function getPromotionId(): ?int
    {
        return $this->promotion_id;
    }

    /**
     * @param int|null $promotion_id
     */
    public function setPromotionId(?int $promotion_id): void
    {
        $this->promotion_id = $promotion_id;
    }

    /**
     * @return string|null
     */
    public function getPromotionName(): ?string
    {
        return $this->promotion_name;
    }

    /**
     * @param string|null $promotion_name
     */
    public function setPromotionName(?string $promotion_name): void
    {
        $this->promotion_name = $promotion_name;
    }
//
//    public function jsonSerialize(): mixed
//    {
//        return get_object_vars($this);
//    }
}
