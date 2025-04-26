<?php

declare(strict_types=1);

namespace App\Reservation\Application\DTO;

use DateTime;

class ReservePlaceDTO
{

    private string $placeNo;
    private string $carId;
    private ?DateTime $start;
    private ?DateTime $end;

    public function setPlaceNo(string $placeNo): void
    {
        $this->placeNo = $placeNo;
    }

    public function getPlaceNo(): string
    {
        return $this->placeNo;
    }

    public function setCarId(string $carId): void
    {
        $this->carId = $carId;
    }

    public function getCarid(): string
    {
        return $this->carId;
    }

    public function setStart(?DateTime $start): void
    {
        $this->start = $start;
    }

    public function getStart(): ?DateTime
    {
        return $this->start;
    }

    public function setEnd(?DateTime $end): void
    {
        $this->end = $end;
    }

    public function getEnd(): ?DateTime
    {
        return $this->end;
    }
}
