<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\User\Domain\Exception\CarException;

class CarOwner
{
    private string $userId;
    private User $user;

    public function __construct(User $user)
    {
        if (!($user->getIsVerified() && $user->getStatus() === UserStatus::ACTIVE)) {
            throw CarException::invalidCarOwner($user->getId());
        }

        $this->userId = $user->getId();
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function __toString(): string
    {
        return $this->userId;
    }
}
