<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\DomainExceptionInterface;
use Exception;

class UserException extends Exception implements DomainExceptionInterface
{

    public static function invalidId(string $id): static
    {
        return new static(sprintf("User id %s is not valid uuid", $id));
    }

    public static function invalidArgument(string $prop): static
    {
        return new static(sprintf('Value %s is not valid User property', $prop));
    }
}
