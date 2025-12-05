<?php

namespace App\Controller;

use App\Calendar\Calendar;
use App\Entity\Post;
use App\Event\MyCustomEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/')]
final class DefaultController extends AbstractController
{
    #[Route]
    public function index(EventDispatcherInterface $eventDispatcher): Response
    {
        $event = new MyCustomEvent('Hello', 'world');
        $eventDispatcher->dispatch($event, MyCustomEvent::NAME);

        return $this->render('default/index.html.twig', [
            'post' => new Post(),
        ]);
    }

    #[Route('/cache')]
    #[Cache(maxage: 3600, public: true)]
    public function demoCache(
        Request $request,
        TagAwareCacheInterface $cache,
        HttpClientInterface $httpClient,
        Calendar $calendar,
    ): Response {
        $forceRecompute = $request->query->has('force');
        // ajouter des éléments pour garantir l'unicité de l'identifiant de l'élément de cache
        $cacheId = 'demo_cache.'.$request->getLocale();

        if ($forceRecompute) {
            $cache->delete($cacheId);
        }

        $stopWatch = new Stopwatch();
        $stopWatch->start('computation');
        // utilisation d'un service dans une fonction de rappel de calcul de cache
        $data = $cache->get($cacheId, function (ItemInterface $item) use ($httpClient) {
            $item
                ->expiresAfter(600)
                ->tag(['website', 'post'])
            ;
            sleep(2);
            $httpClient->request('GET', 'https://dawan.fr');

            return 42;
        });
        $duration = $stopWatch->stop('computation')->getDuration();

        // supprimer l'ensemble des éléments désignés par le tag
        $cache->invalidateTags(['post']);

        return $this->render('default/cache.html.twig', [
            'answer' => $data,
            'duration' => $duration,
        ]);
    }
}
