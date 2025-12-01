<?php

namespace App\EventListener;

use App\Event\MyCustomEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

readonly class MyCustomEventListener
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    #[AsEventListener(event: MyCustomEvent::NAME)]
    public function onMyCustomEvent(MyCustomEvent $event): void
    {
        $this->logger->info('Événement '.MyCustomEvent::NAME);
    }
}
