<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Entity\Car;
use App\User\Domain\Repository\CarRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class CarRepository extends ServiceEntityRepository implements CarRepositoryInterface
{

    private ObjectManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
        $this->em = $registry->getManager();
    }


    public function remove(Car $car): void
    {
        $this->em->remove($car);
        $this->em->flush();
    }

    public function save(Car $car): void
    {
        $this->em->persist($car);
        $this->em->flush();
    }
}
