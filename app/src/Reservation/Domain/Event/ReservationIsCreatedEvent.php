<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Entity;

use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ReservationIsCreatedEvent extends Event implements DomainEventInterface
{
    public function __construct(
        private readonly string $userId,
        private readonly string $carId,
        private readonly int $placeNumber,
        private readonly int $start,
        private readonly int $end
    ) {}

    public function getUserId(): string
    {
        return $this->userId;
    }
    public function getCarId(): string
    {
        return $this->carId;
    }
    public function getPlaceNumber(): int
    {
        return $this->placeNumber;
    }
    public function getStart(): int
    {
        return $this->start;
    }
    public function getEnd(): int
    {
        return $this->end;
    }
}
