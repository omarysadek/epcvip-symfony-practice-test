<?php

namespace App\Controller;

use App\Entity\Product;
use App\Enum\StatusEnumType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

/**
 * @Route("/products")
 */
class ProductController extends FOSRestController
{
    /**
     * @Rest\Get("")
     */
    public function index(ProductRepository $productRepository): View
    {
        return View::create($productRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("")
     */
    public function new(Request $request): View
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return View::create($product, Response::HTTP_CREATED);
        }

        return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function show(Product $product): View
    {
        return View::create($product, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, Product $product): View
    {
        //todo not working 
        $form = $this->createForm(ProductType::class, $product);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return View::create($product, Response::HTTP_OK);
        }

        return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(Request $request, Product $product): View
    {
        $entityManager = $this->getDoctrine()->getManager();
        if (is_null($product->getDeletedAt())) {
            $product->setStatus(StatusEnumType::DELETED_STATUS);
            $entityManager->remove($product);
            $entityManager->flush();

            $entityManager->persist($product);
            $entityManager->flush();
        }
        
        return View::create($product, Response::HTTP_OK);
    }
}
