<?php

namespace App\Twig\Components;

use App\Repository\TagRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class TagShortcuts
{
    private array $tags;
    private bool $isInitialized = false;

    public function __construct(
        private readonly TagRepository $tagRepository,
    ) {
    }

    public function getTags()
    {
        if (!$this->isInitialized) {
            $this->tags = $this->tagRepository->findAll();
            $this->isInitialized = true;
        }

        return $this->tags;
    }
}
