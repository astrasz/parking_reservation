<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;
use App\User\Domain\Entity\CarId;
use App\User\Domain\Entity\CarOwner;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegisterCarEvent extends Event implements DomainEventInterface
{
    public function __construct(private readonly CarId $carId, private readonly CarOwner $ownerId) {}

    public function getCarId(): string
    {
        return (string) $this->carId;
    }

    public function getOwnerId(): string
    {
        return (string) $this->ownerId;
    }
}
