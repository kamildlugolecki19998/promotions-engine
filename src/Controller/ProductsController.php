<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Service\Serializer\DTOSerializer;
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
        DTOSerializer $serializer
    ): Response
    {
        if ($request->headers->has('force-fail')) {
            return new JsonResponse(['error' => 'Promotions engine failure message'], $request->headers->get('force_fail'));
        }
        // 1. Deserialize json data into EnquiryDTO
        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');
//        dd($lowestPriceEnquiry);

        $lowestPriceEnquiry->setDiscountedPrice(50);
        $lowestPriceEnquiry->setPrice(100);
        $lowestPriceEnquiry->setPromotionId(3);
        $lowestPriceEnquiry->setPromotionName('Black friday half price sale');

//        return new JsonResponse($lowestPriceEnquiry, 200);
        $responseContent = $serializer->serialize($lowestPriceEnquiry, 'json');

        return new Response($responseContent, 200);
        //2. Pass the Enquiry into a prmotions filter the appropirate promotion will be applied

    }


    #[Route('/products/{id}/promotions', name: 'promotions', methods: ['GET'])]
    public function promotions()
    {

    }
}
