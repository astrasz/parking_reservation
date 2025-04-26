<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use App\Shared\Application\Event\EventInterface;

class PlaceReservationConfirmation implements EventInterface
{

    public function __construct(
        private readonly string $userId,
        private readonly string $carId,
        private readonly int $placeNo,
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

    public function getPlaceNo(): int
    {
        return $this->placeNo;
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
