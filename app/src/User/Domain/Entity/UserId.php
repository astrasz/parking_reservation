<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\EntityId;
use App\User\Domain\Exception\UserException;

class UserId extends EntityId
{
    public function __construct(string $uuid)
    {
        parent::__construct($uuid, UserException::invalidId($uuid));
    }
}
