<?php

namespace App\Twig\Components;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class PostForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?Post $initialData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(PostType::class, $this->initialData);
    }

    #[LiveAction]
    public function publishNextWeek(): void
    {
        $this->formValues['publishedAt'] = (new \DateTimeImmutable('+1 week'))->format('c');
    }

    #[LiveAction]
    public function save(
        EntityManagerInterface $entityManager,
    ): Response {
        // Soumet et valide les données du formulaire
        // Lève une exception UnprocessableEntityHttpException (422)
        // L'exception est gérée par LiveController
        $this->submitForm();

        $entityManager->persist($this->getForm()->getData());
        $entityManager->flush();

        $this->addFlash('success', 'Post saved!');

        return $this->redirectToRoute('app_default_index');
    }
}
