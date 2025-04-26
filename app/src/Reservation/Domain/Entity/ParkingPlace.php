<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Entity;

class ParkingPlace
{
    private int $id;
    private int $number;


    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}
