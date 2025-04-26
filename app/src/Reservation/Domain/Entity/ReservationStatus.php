<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Entity;

class ReservationStatus
{
    private string $id;
    private string $name;


    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
