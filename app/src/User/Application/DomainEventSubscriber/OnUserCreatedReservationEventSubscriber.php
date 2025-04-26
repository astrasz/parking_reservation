<?php

declare(strict_types=1);

namespace App\User\Application\DomainEventSubscriber;

use App\Shared\Domain\Event\UserCreatedReservationEvent;
use App\User\Application\Event\PlaceReservationConfirmation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OnUserCreatedReservationEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $eventBus
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedReservationEvent::class => 'confirmCarRegistration'
        ];
    }

    public function confirmCarRegistration(UserCreatedReservationEvent $event): void
    {
        $this->eventBus->dispatch(new PlaceReservationConfirmation(
            $event->getUserId(),
            $event->getCarId(),
            $event->getPlaceNo(),
            $event->getStart(),
            $event->getEnd()
        ));
    }
}
