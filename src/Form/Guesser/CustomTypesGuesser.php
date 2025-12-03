<?php

namespace App\Form\Guesser;

use App\DataType\Duration;
use App\Form\widget\DurationType;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess;

class CustomTypesGuesser implements FormTypeGuesserInterface
{

    public function guessType(string $class, string $property): ?Guess\TypeGuess
    {
        $reflectionProperty = new \ReflectionProperty($class, $property);

        $type = $reflectionProperty->getType();
        if ($type instanceof \ReflectionNamedType) {
            switch ($type->getName()) {
                case Duration::class:
                    return new Guess\TypeGuess(DurationType::class, [], Guess\Guess::VERY_HIGH_CONFIDENCE);
            }
        }

        return null;
    }

    public function guessRequired(string $class, string $property): ?Guess\ValueGuess
    {
        return null;
    }

    public function guessMaxLength(string $class, string $property): ?Guess\ValueGuess
    {
        return null;
    }

    public function guessPattern(string $class, string $property): ?Guess\ValueGuess
    {
        return null;
    }
}
