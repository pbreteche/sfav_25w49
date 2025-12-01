<?php

namespace App\Controller;

use App\Event\MyCustomEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
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

    #[Route('/cache')]
    public function demoCache(
        CacheInterface $cache,
    ): Response {
        $stopWatch = new Stopwatch();
        $stopWatch->start('computation');
        $data = $cache->get('demo_cache', function (ItemInterface $item) {
            $item->expiresAfter(30);
            sleep(2);

            return 42;
        });
        $duration = $stopWatch->stop('computation')->getDuration();

        return $this->render('default/cache.html.twig', [
            'answer' => $data,
            'duration' => $duration,
        ]);
    }
}
