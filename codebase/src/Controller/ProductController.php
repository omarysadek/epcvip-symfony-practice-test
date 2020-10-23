<?php

namespace App\Controller;

use App\Component\HttpFoundation\ApiResponse;
use App\Entity\Product;
use App\Enum\StatusEnumType;
use App\Exception\FormException;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/products")
 */
class ProductController extends FOSRestController
{
    /**
     * @Rest\Get("")
     */
    public function index(ProductRepository $productRepository, ApiResponse $apiResponse): Response
    {
        $data = [
            'content' => $productRepository->findAll(),
            'group' => 'product'
        ];

        return $apiResponse->new($data, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("")
     */
    public function new(Request $request, ApiResponse $apiResponse): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $data = [
                'content' => $product,
                'group' => 'product'
            ];

            return $apiResponse->new($data, Response::HTTP_CREATED);
        }

        throw new FormException($form);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function show(Product $product, ApiResponse $apiResponse): Response
    {
        $data = [
            'content' => $product,
            'group' => 'product'
        ];

        return $apiResponse->new($data, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, Product $product, ApiResponse $apiResponse): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $data = [
                'content' => $product,
                'group' => 'product'
            ];

            return $apiResponse->new($data, Response::HTTP_OK);
        }

        throw new FormException($form);
    }

    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(Request $request, Product $product, ApiResponse $apiResponse): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if (is_null($product->getDeletedAt())) {
            $product->setStatus(StatusEnumType::DELETED_STATUS);
            $entityManager->remove($product);
            $entityManager->flush();

            $entityManager->persist($product);
            $entityManager->flush();
        }

        $data = [
            'content' => $product,
            'group' => 'product'
        ];

        return $apiResponse->new($data, Response::HTTP_OK);
    }
}
