<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Entity;

use App\Reservation\Domain\Exception\ReservationException;
use App\Shared\Domain\Entity\EntityId;

class BookerId extends EntityId
{
    public function __construct(string $uuid)
    {
        parent::__construct($uuid, ReservationException::invalidArgument($uuid));
    }
}
