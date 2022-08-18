<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: ['POST'])]
    public function lowestPrice(
        Request             $request,
        int                 $id,
        SerializerInterface $serializer
    ): Response
    {
        if ($request->headers->has('force-fail')) {
            return new JsonResponse(['error' => 'Promotions engine failure message'], $request->headers->get('force_fail'));
        }
        // 1. Deserialize json data into EnquiryDTO
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');
        dd($lowestPriceEnquiry);

        //2. Pass the Enquiry into a prmotions filter the appropirate promotion will be applied
        return new JsonResponse(
            [
                'quantity'         => 5,
                'request_location' => 'UK',
                'voucher_code'     => '0U812',
                'request_date'     => '2022-04-04',
                'product_id'       => $id,
                'price'            => 100,
                'discounted_price' => 50,
                'promotion_id'     => 3,
                'promotion_name'   => 'Black friday half price sale'
            ], 200);
    }


    #[Route('/products/{id}/promotions', name: 'promotions', methods: ['GET'])]
    public function promotions()
    {

    }
}
