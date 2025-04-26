<?php

declare(strict_types=1);

namespace App\Reservation\Application\DomainEventSubscriber;

use App\Reservation\Domain\Entity\ReservationIsCreatedEvent;
use App\Shared\Domain\Event\UserCreatedReservationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OnReservationIsCreatedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            ReservationIsCreatedEvent::class => 'confirmCarRegistration'
        ];
    }

    public function confirmCarRegistration(ReservationIsCreatedEvent $event): void
    {
        $this->eventDispatcher->dispatch(new UserCreatedReservationEvent(
            $event->getUserId(),
            $event->getCarId(),
            $event->getPlaceNumber(),
            $event->getStart(),
            $event->getEnd()
        ));
    }
}
