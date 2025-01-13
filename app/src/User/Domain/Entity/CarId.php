<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\EntityId;
use App\User\Domain\Exception\CarException;

class CarId extends EntityId
{
    public function __construct(string $uuid)
    {
        parent::__construct($uuid, CarException::invalidId($uuid));
    }
}
