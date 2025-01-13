<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use App\Shared\Application\Event\EventInterface;
use App\User\Domain\Entity\CarId;
use App\User\Domain\Entity\UserId;

class ConfirmCarRegistration implements EventInterface
{
    public function __construct(private readonly string $carId, private readonly string $ownerId) {}

    public function getCarId(): string
    {
        return $this->carId;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
