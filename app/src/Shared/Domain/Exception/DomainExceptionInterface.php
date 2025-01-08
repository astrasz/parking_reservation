<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

interface DomainExceptionInterface
{
    // sprintf("Id %s is not valid uuid", $id)
    public static function invalidId(string $id): static;

    // sprintf("%s is not valid", $email)
    public static function invalidArgument(string $email): static;
}
