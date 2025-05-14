<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Entity\Car;

class RemoveCar
{

    public function __construct(
        private Car $car,
        private string $userId
    ) {}

    public function getCar(): Car
    {
        return $this->car;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
