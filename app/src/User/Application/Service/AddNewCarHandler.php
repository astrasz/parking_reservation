<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\Shared\Application\Service\CommandHandlerInterface;
use App\User\Application\Command\AddNewCar;
use App\User\Domain\Entity\CarBrand;
use App\User\Domain\Entity\CarId;
use App\User\Domain\Entity\CarOwner;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\CarRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

class AddNewCarHandler implements CommandHandlerInterface
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepo,
        private readonly CarRepositoryInterface $carRepo,
        private readonly UuidFactory $uuidFactory,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function __invoke(AddNewCar $command): void
    {
        $user = $this->userRepo->find($command->getOwnerId());

        $this->carRepo->save(
            User::addCar(
                new CarId($this->uuidFactory->create()->toString()),
                CarBrand::from(ucfirst(strtolower($command->getBrand()))),
                $command->getRegistrationNo(),
                new CarOwner($user)
            )
        );

        foreach ($user->fethEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}
