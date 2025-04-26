<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Exception;

use App\Shared\Domain\Exception\DomainExceptionInterface;
use Exception;

class PlaceException extends Exception implements DomainExceptionInterface
{
    public static function invalidId(string $id): static
    {
        return new static(sprintf("Place id %s is not valid uuid", $id));
    }

    public static function invalidArgument(string $prop): static
    {
        return new static(sprintf("Value %s is not valid Place property", $prop));
    }
}
