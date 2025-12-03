<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
readonly class DataExtraction
{
    public function __construct(
        private string $source,
        private array $criteria,
    ) {
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }
}
