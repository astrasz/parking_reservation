<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Repository;

use App\Reservation\Application\DTO\ReservationPlaceDTO;


/**
 * @extends ServiceEntityRepository<Place>
 *
 * @method ParkingPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParkingPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParkingPlace[]    findAll()
 * @method ParkingPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface PlaceRepositoryInterface
{
    /**
     * @return ReservationPlaceDTO[]
     */
    public function getParkingPlaces(): array;
    public function getParkingPlace(int $id): ReservationPlaceDTO;
}
