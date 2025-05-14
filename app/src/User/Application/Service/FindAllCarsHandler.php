<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\Shared\Application\Service\QueryHandlerInterface;
use App\User\Application\DTO\UserCarDTO;
use App\User\Application\Query\FindAllCars;
use App\User\Domain\Entity\Car;
use App\User\Domain\Repository\CarRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;

class FindAllCarsHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CarRepositoryInterface $carRepo,
        private readonly Security $security
    ) {}

    /**
     * @return UserCarDTO[]
     */
    public function __invoke(FindAllCars $query): array
    {
        /**
         * @var SecurityUserInterace user 
         */
        $user = $this->security->getUser();
        $cars = $this->carRepo->findBy([
            'owner' => $user->getUser(),
            'status' => 1
        ]);

        $carDTOs = array_map(function (Car $car) {
            $userCar =  new UserCarDTO();
            $userCar->setId((string) $car->getId());
            $userCar->setBrand($car->getBrand()->toString());
            $userCar->setRegistrationNumber($car->getRegistrationNo());
            return $userCar;
        }, $cars);

        return $carDTOs;
    }
}
