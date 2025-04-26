<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Repository;

/**
 * @extends ServiceEntityRepository<ReservationStatus>
 *
 * @method ReservationStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationStatus[]    findAll()
 * @method ReservationStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ReservationStatusRepositoryInterface {}
