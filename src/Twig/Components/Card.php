<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use function Symfony\Component\String\u;

#[AsTwigComponent]
final class Card
{
    public string $title;
    public ?string $image = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $data['title'] = u($data['title'])->title(true);

        return $data;
    }
}
