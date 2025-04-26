<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Repository;


use App\Reservation\Application\DTO\ReservationPlaceDTO;
use App\Reservation\Domain\Entity\ParkingPlace;
use App\Reservation\Domain\Repository\PlaceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class PlaceRepository extends ServiceEntityRepository implements PlaceRepositoryInterface
{

    private ObjectManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParkingPlace::class);
        $this->em  = $registry->getManager();
    }

    public function getParkingPlaces(): array
    {
        $qb = $this->createQueryBuilder('p');
        $result = $qb
            ->select('p.id', 'p.number', '(r.userId) as reservationOwner', '(r.start) as reservationStart', '(r.end) as reservationEnd', '(r.status) as reservationStatus', '(c.brand) as reservationCar')
            ->leftJoin(
                'App\Reservation\Domain\Entity\Reservation',
                'r',
                Join::WITH,
                $qb->expr()->andX('p.id = r.place', 'r.status=2')
            )
            ->leftJoin('App\User\Domain\Entity\Car', 'c', JOIN::WITH, 'r.carId = c.id')
            ->getQuery()
            ->getArrayResult();

        $reservationPlaces = array_map(function ($el) {
            $reservationPlace = new ReservationPlaceDTO();
            $reservationPlace->setNumber($el['number']);
            $reservationPlace->setIsFree($el['reservationOwner'] ? 0 : 1);
            $reservationPlace->setOngoingReservationEnd($el['reservationEnd']);
            $reservationPlace->setOwnerOngoingReservation($el['reservationOwner']);
            $reservationPlace->setOngoingReservationCarBrand($el['reservationCar']);
            return $reservationPlace;
        }, $result);

        return $reservationPlaces;
    }

    public function getParkingPlace(int $id): ReservationPlaceDTO
    {

        $qb = $this->createQueryBuilder('p');
        $result = $qb
            ->select('p.id', 'p.number', '(r.userId) as reservationOwner', '(r.start) as reservationStart', '(r.end) as reservationEnd', '(r.status) as reservationStatus', '(c.brand) as reservationCar')
            ->leftJoin(
                'App\Reservation\Domain\Entity\Reservation',
                'r',
                Join::WITH,
                $qb->expr()->andX('p.id = r.place', 'r.status=2')
            )
            ->leftJoin('App\User\Domain\Entity\Car', 'c', JOIN::WITH, 'r.carId = c.id')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery()
            // ->getSQL();
            ->getOneOrNullResult();


        $reservationPlace = new ReservationPlaceDTO();

        $reservationPlace->setNumber($result['number']);
        $reservationPlace->setIsFree($result['reservationOwner'] ? 1 : 0);
        $reservationPlace->setOngoingReservationEnd($result['reservationEnd']);
        $reservationPlace->setOwnerOngoingReservation($result['reservationOwner']);
        $reservationPlace->setOngoingReservationCarBrand($result['reservationCar']);

        return $reservationPlace;
    }
}
