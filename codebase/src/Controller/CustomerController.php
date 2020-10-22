<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * todo WIP
 * @Route("/customer")
 */
class CustomerController extends FOSRestController
{
    /**
     * @Rest\Get("/")
     */
    public function index(CustomerRepository $customerRepository)
    {
        return $this->handleView(
            $this->view($customerRepository->findAll())
        );
    }
}
