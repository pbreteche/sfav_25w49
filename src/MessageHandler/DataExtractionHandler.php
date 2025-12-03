<?php

namespace App\MessageHandler;

use App\Message\DataExtraction;
use App\Repository\PostRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DataExtractionHandler
{
    public function __construct(
        private PostRepository $postRepository,
    ) {
    }

    public function __invoke(DataExtraction $dataExtraction): void
    {
        // Do some async stuff
        $data = $this->postRepository->findBy($dataExtraction->getCriteria());
    }
}
