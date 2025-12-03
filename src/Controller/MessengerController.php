<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PostState;
use App\Message\DataExtraction;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/messenger')]
class MessengerController extends AbstractController
{
    #[Route]
    public function index(
        MailerInterface $mailer,
        string $projectDir,
    ): Response {
        $message = new Email();
        $message
            ->from('noreply@example.com')
            ->to('recipient@example.com')
            ->subject('Conference invitation')
            ->text('Hello, here is your invitation!')
            ->html('<p>Conference invitation</p>');

        $ressource = fopen('php://temp', 'rb+');
        fputcsv($ressource, ['Name', 'Email']);
        fputcsv($ressource, ['John', 'Doe']);

        $message = new TemplatedEmail();
        $message
            ->from('noreply@example.com')
            ->to('recipient@example.com')
            ->subject('Conference invitation')
            ->textTemplate('messenger/mail/index.txt.twig')
            ->htmlTemplate('messenger/mail/index.html.twig')
            ->context([
                'recipient_name' => 'John Doe',
                'conference' => [
                    'name' => 'Formation Symfony',
                    'date' => new \DateTimeImmutable('+1 month midnight'),
                ],
            ])
            ->attach($ressource, 'recipient_list.csv', 'text/csv')
            ->addPart(new DataPart(
                new File(sprintf('%s/assets/images/symfony_logo.svg', $projectDir)),
                'logo',
                'image/svg+xml',
            ))
        ;
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
