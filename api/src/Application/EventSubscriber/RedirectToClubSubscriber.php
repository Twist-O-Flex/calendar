<?php

namespace App\Application\EventSubscriber;

use ApiPlatform\Core\Api\UrlGeneratorInterface;
use App\Domain\Exception\ClubAlreadyExistsException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class RedirectToClubSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            "kernel.exception" => ["redirectToClub", -95], // listener of API Platform is -96
        ];
    }

    public function redirectToClub(ExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof ClubAlreadyExistsException) {
            return;
        }

        $event->setResponse(
            new RedirectResponse(
                $this->urlGenerator->generate("api_clubs_get_item", ["id" => $exception->getClubId()])
            )
        );
    }
}
