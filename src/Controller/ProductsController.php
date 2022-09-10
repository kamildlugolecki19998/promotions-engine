<?php

namespace App\Controller;

use App\Controller\Cache\PromotionCache;
use App\DTO\LowestPriceEnquiry;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Filter\PromotionFilterInterface;
use App\Repository\ProductRepository;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ProductsController extends AbstractController
{

    public function __construct(
        private ProductRepository      $productRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: ['POST'])]
    public function lowestPrice(
        Request                  $request,
        int                      $id,
        DTOSerializer            $serializer,
        PromotionFilterInterface $promotionFilter,
        PromotionCache           $promotionCache
    ): Response {
        if ($request->headers->has('force-fail')) {
            return new JsonResponse(['error' => 'Promotions engine failure message'], $request->headers->get('force_fail'));
        }
        // 1. Deserialize json data into EnquiryDTO
        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');

        $product = $this->productRepository->find($id); // add error handling

        $lowestPriceEnquiry->setProduct($product);
        //caching
        $promotions = $promotionCache->findValidForProduct($product, $lowestPriceEnquiry->getRequestDate());


        $modifiedEnquiry = $promotionFilter->apply($lowestPriceEnquiry, ...$promotions);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');

        return new Response($responseContent, 200, ['Content-type' => 'application/json']);
    }


    #[Route('/products/{id}/promotions', name: 'promotions', methods: ['GET'])]
    public function promotions()
    {

    }
}
