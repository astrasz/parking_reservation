<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

enum UserStatus: string
{
    case UNVERIFIED = 'unverified';
    case ACTIVE  = 'active';
    case BLOCKED = 'blocked';
    case DELETED = 'deleted';

    public function toString()
    {
        return $this->value;
    }
}
