<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Event\DomainEventInterface;

abstract class AggreagateRoot
{
    private array $domainEvents;

    public function addEvent(DomainEventInterface $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function fethEvents(): array
    {

        $events = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }
}
