<?php

namespace App\Component\Serializer\Normalizer;

use App\Exception\FormException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FormExceptionNormalizer implements NormalizerInterface
{
    public function normalize($exception, $format = null, array $context = [])
    {
        $data   = [];
        $errors = $exception->getErrors();

        foreach ($errors as $error) {
            $data[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof FormException;
    }
}