<?php

namespace App\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ApiResponse extends JsonResponse
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function new($data = [], $status = 200, string $message = null, array $errors = [], array $headers = [], bool $json = false)
    {
        $response = [];

        if ($message) {
            $response['message'] = $message;
        }

        if ($data) {
            $response['data'] = ($this->serializer->normalize($data['content'], 'json', ['groups' => $data['group']]));
        }

        if ($errors) {
            $response['errors'] = $errors;
        }

        return New JsonResponse($response, $status, $headers, $json);
    }
}