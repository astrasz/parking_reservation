<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Repository;

use App\Reservation\Domain\Entity\Reservation;

/**
 * @extends ServiceEntityRepository<Place>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ReservationRepositoryInterface
{
    public function isPeriodAvailable(int $placeId, int $start, int $end): bool;

    public function save(Reservation $reservation): void;
}
