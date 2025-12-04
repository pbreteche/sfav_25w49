<?php

namespace App\Twig\Components;

use App\Repository\TagRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class TagShortcuts
{
    use DefaultActionTrait;
    #[LiveProp(writable: true)]
    public ?string $query = null;
    private array $tags = [];
    private bool $isInitialized = false;

    public function __construct(
        private readonly TagRepository $tagRepository,
    ) {
    }

    public function getTags()
    {
        if (!$this->isInitialized && $this->query) {
            $this->tags = $this->tagRepository->findNamesStartingBy($this->query);
            $this->isInitialized = true;
        }

        return $this->tags;
    }
}
