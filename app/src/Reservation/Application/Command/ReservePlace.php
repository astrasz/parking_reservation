<?php

declare(strict_types=1);

namespace App\Reservation\Application\Command;

use App\Shared\Application\Command\CommandInterface;

class ReservePlace implements CommandInterface
{
    public function __construct(
        private int $placeNo,
        private string $carId,
        private string $userId,
        private int $start,
        private int $end
    ) {}

    public function getPlaceNo(): int
    {
        return $this->placeNo;
    }

    public function getCarId(): string
    {
        return $this->carId;
    }

    public function getUserId(): string
    {
        return $this->userId;
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
