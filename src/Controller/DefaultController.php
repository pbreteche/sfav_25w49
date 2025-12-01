<?php

namespace App\Controller;

use App\Event\MyCustomEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route('/')]
final class DefaultController extends AbstractController
{
    #[Route]
    public function index(EventDispatcherInterface $eventDispatcher): Response
    {
        $event = new MyCustomEvent('Hello', 'world');
        $eventDispatcher->dispatch($event, MyCustomEvent::NAME);

        return $this->render('default/index.html.twig');
    }
}
