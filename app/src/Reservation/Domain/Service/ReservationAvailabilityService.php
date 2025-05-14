<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Service;

use App\Reservation\Domain\Entity\ParkingPlace;
use App\Reservation\Domain\Exception\PlaceException;
use App\Reservation\Domain\Exception\ReservationException;
use App\Reservation\Domain\Repository\ReservationRepositoryInterface;
use App\Reservation\Infrastructure\Repository\PlaceRepository;

class ReservationAvailabilityService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepo,
        private readonly PlaceRepository $placeRepo
    ) {}

    public function ensurePlaceIsAvailable(int $placeId, int $start, int $end): void
    {
        $this->reservationRepo->isPeriodAvailable($placeId, $start, $end) ?? throw ReservationException::periodNotAvailable($placeId, date('Y-m-d H:i:s', $start), date('Y-m-d H:i:s', $end));
    }

    public function ensurePlaceExists(int $placeNo): ?ParkingPlace
    {
        return $this->placeRepo->findOneBy(['number' => $placeNo]) ?? throw PlaceException::notFound($placeNo);
    }
}
