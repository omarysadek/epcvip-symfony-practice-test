<?php

namespace App\Controller;

use App\Component\HttpFoundation\ApiResponse;
use App\Entity\Customer;
use App\Enum\StatusEnumType;
use App\Exception\FormException;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/customers")
 */
class CustomerController extends FOSRestController
{
    /**
     * @Rest\Get("")
     */
    public function index(CustomerRepository $customerRepository, ApiResponse $apiResponse): Response
    {
        $data = [
            'content' => $customerRepository->findAll(),
            'group' => 'customer'
        ];

        return $apiResponse->new($data, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("")
     */
    public function new(Request $request, ApiResponse $apiResponse): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            $data = [
                'content' => $customer,
                'group' => 'customer'
            ];

            return $apiResponse->new($data, Response::HTTP_CREATED);
        }

        throw new FormException($form);
    }

    /**
     * @Rest\Get("/{uuid}")
     */
    public function show(Customer $customer, ApiResponse $apiResponse): Response
    {
        $data = [
            'content' => $customer,
            'group' => 'customer'
        ];

        return $apiResponse->new($data, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{uuid}")
     */
    public function edit(Request $request, Customer $customer, ApiResponse $apiResponse): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $data = [
                'content' => $customer,
                'group' => 'customer'
            ];

            return $apiResponse->new($data, Response::HTTP_OK);
        }

        throw new FormException($form);
    }

    /**
     * @Rest\Delete("/{uuid}")
     */
    public function delete(Request $request, Customer $customer, ApiResponse $apiResponse): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if (is_null($customer->getDeletedAt())) {
            $customer->setStatus(StatusEnumType::DELETED_STATUS);
            $entityManager->remove($customer);
            $entityManager->flush();

            $entityManager->persist($customer);
            $entityManager->flush();
        }

        $data = [
            'content' => $customer,
            'group' => 'customer'
        ];

        return $apiResponse->new($data, Response::HTTP_OK);
    }
}
