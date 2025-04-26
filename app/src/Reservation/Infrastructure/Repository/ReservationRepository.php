<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Repository;

use App\Reservation\Domain\Entity\Reservation;
use App\Reservation\Domain\Repository\ReservationRepositoryInterface;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class ReservationRepository extends ServiceEntityRepository implements ReservationRepositoryInterface
{

    private ObjectManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
        $this->em = $registry->getManager();
    }

    public function isPeriodAvailable(int $placeId, int $start, int $end): bool
    {
        $qb = $this->createQueryBuilder('r');
        $result = $qb
            ->select('r')
            ->where('r.place = :placeId')
            ->setParameter('placeId', $placeId)
            ->andWhere(
                $qb->expr()->orX(
                    // Given period starts inside the existing period
                    $qb->expr()->andX(
                        'r.start <= :start',
                        'r.end >= :end'
                    ),
                    // Given period ends inside the existing period
                    $qb->expr()->andX(
                        'r.start <= :end',
                        'r.end >= :end'
                    ),
                    // Given period fully contains the existing period
                    $qb->expr()->andX(
                        'r.start >= :start',
                        'r.end <= :end'
                    ),
                    // Existing period fully contains the given period
                    $qb->expr()->andX(
                        'r.start <= :start',
                        'r.end >= :end'
                    )
                )
            )
            ->setParameter('start', (new DateTime)->setTimestamp($start))
            ->setParameter('end', (new DateTime)->setTimestamp($end))
            ->setMaxResults(1)
            ->getQuery()
            // ->getSql();
            ->getOneOrNullResult();

        return !$result;
    }

    public function save(Reservation $reservation): void
    {
        $this->em->persist($reservation);
        $this->em->flush();
    }
}
