<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class LocaleListener
{
    #[AsEventListener(priority: 60)]
    public function getLocaleFromSession(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (
            $request->query->has('_locale')
            && in_array($request->query->get('_locale'), ['en', 'fr', 'es', 'de'])
        ) {
            $request->getSession()->set('_locale', $request->query->get('_locale'));
        }

        if ($request->getSession()->get('_locale')) {
            $request->setLocale($request->getSession()->get('_locale'));
        }
    }
}
