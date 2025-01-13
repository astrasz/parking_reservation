<?php

declare(strict_types=1);

namespace App\User\Application\EventSubscriber;

use App\User\Application\Event\ConfirmCarRegistration;
use App\User\Domain\Event\UserRegisterCarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OnUserRegisterCarEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $eventBus
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisterCarEvent::class => 'confirmCarRegistration'
        ];
    }

    public function confirmCarRegistration(UserRegisterCarEvent $event): void
    {
        $this->eventBus->dispatch(new ConfirmCarRegistration($event->getCarId(), $event->getOwnerId()));
    }
}
