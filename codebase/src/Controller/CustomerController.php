<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Enum\StatusEnumType;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

/**
 * @Route("/customers")
 */
class CustomerController extends FOSRestController
{
    /**
     * @Rest\Get("")
     */
    public function index(CustomerRepository $customerRepository): View
    {
        return View::create($customerRepository->findAll(), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("")
     */
    public function new(Request $request): View
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return View::create($customer, Response::HTTP_CREATED);
        }

        return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Get("/{uuid}")
     */
    public function show(Customer $customer): View
    {
        return View::create($customer, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{uuid}")
     */
    public function edit(Request $request, Customer $customer): View
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return View::create($customer, Response::HTTP_OK);
        }

        return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Delete("/{uuid}")
     */
    public function delete(Request $request, Customer $customer): View
    {
        $entityManager = $this->getDoctrine()->getManager();
        if (is_null($customer->getDeletedAt())) {
            $customer->setStatus(StatusEnumType::DELETED_STATUS);
            $entityManager->remove($customer);
            $entityManager->flush();

            $entityManager->persist($customer);
            $entityManager->flush();
        }

        return View::create($customer, Response::HTTP_OK);
    }
}
