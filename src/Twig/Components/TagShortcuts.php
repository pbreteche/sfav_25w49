<?php

namespace App\Twig\Components;

use App\Repository\TagRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final readonly class TagShortcuts
{
    public function __construct(
        private TagRepository $tagRepository,
    ) {
    }

    public function getTags()
    {
        return $this->tagRepository->findAll();
    }
}
