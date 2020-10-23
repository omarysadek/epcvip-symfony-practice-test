<?php

namespace App\EventListener;

use App\Factory\NormalizerFactory;
use App\Component\HttpFoundation\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    private $normalizerFactory;

    private $apiResponse;
    
    public function __construct(NormalizerFactory $normalizerFactory, ApiResponse $apiResponse)
    {
        $this->normalizerFactory = $normalizerFactory;
        $this->apiResponse = $apiResponse;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $event->setResponse(
            $this->createApiResponse(
                $event->getException()
            )
        );
    }
    
    private function createApiResponse(\Exception $exception)
    {
        $normalizer = $this->normalizerFactory->getNormalizer($exception);

        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        try {
            $errors = $normalizer ? $normalizer->normalize($exception) : [];

        } catch (\Throwable $e) {
            $errors = [];
        }

        return $this->apiResponse->new(null, $statusCode, $exception->getMessage(), $errors);
    }
}