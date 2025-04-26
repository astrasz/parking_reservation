<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

interface DomainExceptionInterface
{
    public static function invalidId(string $id): static;

    public static function invalidArgument(string $prop): static;
}
