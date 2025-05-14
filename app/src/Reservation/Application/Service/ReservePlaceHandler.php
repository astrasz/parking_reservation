<?php

declare(strict_types=1);

namespace App\Reservation\Application\Service;

use App\Reservation\Application\Command\ReservePlace;
use App\Reservation\Domain\Entity\BookerCarId;
use App\Reservation\Domain\Entity\BookerId;
use App\Reservation\Domain\Entity\ParkingPlace;
use App\Reservation\Domain\Entity\Reservation;
use App\Reservation\Domain\Entity\ReservationId;
use App\Reservation\Domain\Entity\ReservationStatus;
use App\Reservation\Domain\Repository\PlaceRepositoryInterface;
use App\Reservation\Domain\Repository\ReservationRepositoryInterface;
use App\Reservation\Domain\Repository\ReservationStatusRepositoryInterface;
use App\Reservation\Domain\Service\ReservationAvailabilityService;
use App\Shared\Application\Service\CommandHandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Uid\Factory\UuidFactory;

class ReservePlaceHandler implements CommandHandlerInterface
{

    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepo,
        private readonly ReservationStatusRepositoryInterface $reservationStatusRepo,
        private readonly PlaceRepositoryInterface $placeRepo,
        private readonly UuidFactory $uuidFactory,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ReservationAvailabilityService $reservationAvailability
    ) {}

    public function __invoke(ReservePlace $command): void
    {
        /**
         * @var ParkingPlace $parkingPlace
         */
        $parkingPlace = $this->reservationAvailability->ensurePlaceExists($command->getPlaceNo());

        $this->reservationAvailability->ensurePlaceIsAvailable($parkingPlace->getId(), $command->getStart(), $command->getEnd());

        /**
         * @var ReservationStatus $reservedStatus
         */
        $reservedStatus = $this->reservationStatusRepo->findOneBy(['id' => 1]);

        $reservation = Reservation::create(
            new ReservationId($this->uuidFactory->create()->toString()),
            $parkingPlace,
            $reservedStatus,
            new BookerId($command->getUserId()),
            new BookerCarId($command->getCarId()),
            $command->getStart(),
            $command->getEnd()
        );

        $this->reservationRepo->save(
            $reservation
        );

        foreach ($reservation->fethEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}
