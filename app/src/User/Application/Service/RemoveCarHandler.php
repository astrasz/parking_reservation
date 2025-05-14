<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\Shared\Application\Service\CommandHandlerInterface;
use App\User\Application\Command\RemoveCar;
use App\User\Domain\Repository\CarRepositoryInterface;
use Exception;

class RemoveCarHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CarRepositoryInterface $carRepo
    ) {}


    public function __invoke(RemoveCar $command): void
    {
        $owner = $command->getCar()->getOwner();

        $owner->getUser()->getId() !== $command->getUserId() ?? throw new Exception('Security error: cannot remove car');

        $car = $command->getCar();
        $car->ensureCanBeRemovedBy($owner);

        $this->carRepo->remove($car);
    }
}
