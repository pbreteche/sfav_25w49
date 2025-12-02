<?php

declare(strict_types=1);

namespace App\Controller;

use App\DataType\Duration;
use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/form')]
class FormController extends AbstractController
{
    #[Route(methods: ['GET', 'POST'])]
    public function index(
        Request $request,
    ): Response {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->get('duration')->setData(new Duration(450));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->get('duration')->getData());
        }

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
