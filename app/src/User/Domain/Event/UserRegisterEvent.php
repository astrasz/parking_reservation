<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegisterEvent extends Event implements DomainEventInterface
{
    public function __construct(private readonly string $userId) {}

    public function getUserId(): string
    {
        return $this->userId;
    }
}
