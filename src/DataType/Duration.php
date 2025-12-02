<?php

namespace App\DataType;

readonly class Duration
{
    public function __construct(
        private int $valueInMinutes,
    ) {
    }

    public function getHours(): int
    {
        return intdiv($this->valueInMinutes, 60);
    }

    public function getMinutes(): int
    {
        return $this->valueInMinutes % 60;
    }

    public function toInt(): int
    {
        return $this->valueInMinutes;
    }
}
