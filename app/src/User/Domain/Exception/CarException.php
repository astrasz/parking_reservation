<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainExceptionInterface;
use Exception;

class CarException extends Exception implements DomainExceptionInterface
{

    public static function invalidId(string $id): static
    {
        return new static(sprintf("Car id %s is not valid uuid", $id));
    }

    public static function invalidArgument(string $email): static
    {
        return new static(sprintf("Value %s is not valid Car property"));
    }

    public static function invalidCarOwner(string $userId): static
    {
        return new static(sprintf('User %s cannot be car owner', $userId));
    }
}
