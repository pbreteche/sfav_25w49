<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class MyCustomEvent extends Event
{
    // Nom par défaut est le FQCN (implicite)
    // Possibilité de remplacer par un nom plus simple, mais explicite
    public const NAME = 'app.custom';

    public function __construct(
        private readonly string $verb,
        private readonly string $subject,
    ) {
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getVerb(): string
    {
        return $this->verb;
    }
}
