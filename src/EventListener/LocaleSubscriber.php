<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['setPreferredLanguage', 80],
        ];
    }

    public function setPreferredLanguage(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $preferredLocale = $request->getPreferredLanguage(['en', 'fr', 'es', 'de']);
        if ($preferredLocale) {
            $request->attributes->set('preferred_locale', $preferredLocale);
            $request->setLocale($preferredLocale);
        }
    }
}
