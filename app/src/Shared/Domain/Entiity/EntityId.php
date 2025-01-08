<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Exception\DomainExceptionInterface;

abstract class EntityId
{
    protected string $id;

    public function __construct(string $id, DomainExceptionInterface $domainException)
    {
        if (!preg_match("/^[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12}$/", $id)) {
            throw $domainException;
        }

        $this->id = $id;
    }

    public function getValue(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
