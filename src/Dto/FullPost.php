<?php

namespace App\Dto;

use App\DataType\Duration;
use App\Entity\PostState;

class FullPost
{
    public ?int $id;
    public ?string $title;
    public ?string $body;
    public ?\DateTimeImmutable $createdAt;
    public ?\DateTimeImmutable $publishedAt;
    public ?PostState $state;
    public array $tags;
    public Duration $duration;
}
