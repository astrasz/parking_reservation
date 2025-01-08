<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegisterCarEvent extends Event implements DomainEventInterface
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
