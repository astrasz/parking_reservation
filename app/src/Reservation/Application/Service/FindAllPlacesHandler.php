<?php

declare(strict_types=1);

namespace App\Reservation\Application\Service;


use App\Reservation\Application\Query\FindAllPlaces;
use App\Reservation\Domain\Repository\PlaceRepositoryInterface;
use App\Shared\Application\Service\QueryHandlerInterface;

class FindAllPlacesHandler implements QueryHandlerInterface
{

    public function __construct(
        private readonly PlaceRepositoryInterface $placeRepo
    ) {}

    public function __invoke(FindAllPlaces $query)
    {
        return $this->placeRepo->getParkingPlaces();
    }
}
