<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Repository;

use App\Reservation\Domain\Entity\ReservationStatus;
use App\Reservation\Domain\Repository\ReservationStatusRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class ReservationStatusRepository extends ServiceEntityRepository implements ReservationStatusRepositoryInterface
{
    private ObjectManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationStatus::class);
        $this->em = $registry->getManager();
    }
}
