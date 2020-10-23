<?php

namespace App\Exception;

use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class FormException extends HttpException
{
    protected $form;

    public function __construct(
        FormInterface $form,
        string $message = null,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        \Exception $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->form = $form;
    }

    public function getErrors()
    {
        return $this->form->getErrors(true);
    }
}