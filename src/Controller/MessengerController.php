<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PostState;
use App\Message\DataExtraction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/messenger')]
class MessengerController extends AbstractController
{
    #[Route]
    public function index(MailerInterface $mailer): Response
    {
        $message = new Email();
        $message
            ->from('noreply@example.com')
            ->to('recipient@example.com')
            ->subject('Conference invitation')
            ->text('Hello, here is your invitation!')
            ->html('<p>Conference invitation</p>');
        $mailer->send($message);


        return $this->render('messenger/index.html.twig');
    }

    #[Route('/extract-data')]
    public function extractData(
        MessageBusInterface $messageBus,
    ): Response {
        $messageBus->dispatch(new DataExtraction('post', ['state' => PostState::Published]));

        return new Response();
    }
}
