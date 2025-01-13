<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;

class AddNewCar implements CommandInterface
{
    public function __construct(
        private readonly string $brand,
        private readonly string $registrationNo,
        private readonly string $ownerId
    ) {}

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getRegistrationNo(): string
    {
        return $this->registrationNo;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
