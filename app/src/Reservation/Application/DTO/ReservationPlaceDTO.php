<?php

declare(strict_types=1);

namespace App\Reservation\Application\DTO;

class ReservationPlaceDTO
{
    private readonly int $number;
    private readonly int $isFree;
    private readonly int|null $ongoingReservationEnd;
    // private readonly int $nextReservationStart;
    private readonly int|null $ownerOngoingReservation;
    // private readonly int $isUserOwnerNextReservation;
    private readonly string|null $ongoingReservationCarBrand;


    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    public function getNumber(): int|null
    {
        return $this->number;
    }

    public function setIsFree(int $isFree): void
    {
        $this->isFree = $isFree;
    }

    public function getIsFree(): int
    {
        return $this->isFree;
    }

    public function setOngoingReservationEnd(?int $ongoingReservationEnd): void
    {
        $this->ongoingReservationEnd = $ongoingReservationEnd;
    }

    public function getOngoingReservationEnd(): int|null
    {
        return $this->ongoingReservationEnd;
    }

    // public function setNextReservationStart(int $nextReservationStart): void
    // {
    //     $this->nextReservationStart = $nextReservationStart;
    // }

    // public function getNextReservationStart(): int
    // {
    //     return $this->nextReservationStart;
    // }

    public function setOwnerOngoingReservation(?int $ownerOngoingReservation): void
    {
        $this->ownerOngoingReservation = $ownerOngoingReservation;
    }

    public function getOwnerOngoingReservation(): int|null
    {
        return $this->ownerOngoingReservation;
    }

    // public function setIsUserOwnerNextReservation(int $isUserOwnerNextReservation): void
    // {
    //     $this->isUserOwnerNextReservation = $isUserOwnerNextReservation;
    // }

    // public function getIsUserOwnerNextReservation(): int
    // {
    //     return $this->isUserOwnerNextReservation;
    // }

    public function setOngoingReservationCarBrand(?string $ongoingReservationCarBrand): void
    {
        $this->ongoingReservationCarBrand = $ongoingReservationCarBrand;
    }

    public function getOngoingReservationCarBrand(): string|null
    {
        return $this->ongoingReservationCarBrand;
    }
}
