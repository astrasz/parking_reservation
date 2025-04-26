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
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function __invoke(ReservePlace $command): void
    {
        /**
         * @var ParkingPlace $parkingPlace
         */
        $parkingPlace = $this->placeRepo->findOneBy(['number' => $command->getPlaceNo()]) ?? throw new NotFoundResourceException('Place not found');

        if (!$this->reservationRepo->isPeriodAvailable($parkingPlace->getId(), $command->getStart(), $command->getEnd())) {
            throw new BadRequestException('Parking place is not available in the selected period.');
        }

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
