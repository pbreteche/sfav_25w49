<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class LocaleListener
{
    #[AsEventListener(priority: 80)]
    public function onRequestEvent(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $preferredLocale = $request->getPreferredLanguage(['en', 'fr', 'es', 'de']);
        if ($preferredLocale) {
            $request->attributes->set('preferred_locale', $preferredLocale);
            $request->setLocale($preferredLocale);
        }
    }
}
