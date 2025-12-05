<?php

namespace App\Controller;

use App\Dto\FullPost;
use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/object-mapper')]
class ObjectMapperController extends AbstractController
{
    #[Route]
    public function index(
        ObjectMapperInterface $objectMapper,
        PostRepository $postRepository,
    ): Response {
        $posts = $postRepository->findAll();
        $normalizedPosts = array_map(fn (Post $post) => $objectMapper->map($post, FullPost::class), $posts);

        return $this->json($normalizedPosts);
    }
}
