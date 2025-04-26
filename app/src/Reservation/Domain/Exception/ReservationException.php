<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Exception;

use App\Shared\Domain\Exception\DomainExceptionInterface;
use Exception;

class ReservationException extends Exception implements DomainExceptionInterface
{
    public static function invalidId(string $id): static
    {
        return new static(sprintf("Reservation id %s is not valid uuid", $id));
    }

    public static function invalidArgument(string $prop): static
    {
        return new static(sprintf("Reservation %s is not valid Reservation property", $prop));
    }
}
