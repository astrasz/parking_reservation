<?php

declare(strict_types=1);

namespace App\Reservation\Domain\Entity;

use App\Shared\Domain\Entity\AggregateRoot;
use App\Shared\Domain\Entity\Timestampbale;
use DateTime;

class Reservation extends AggregateRoot
{
    use Timestampbale;

    private string $id;
    // private string $placeId;
    private ParkingPlace $place;
    private string $carId;
    private string $userId;
    private DateTime $start;
    private DateTime $end;
    // private int $statusId;
    private ReservationStatus $status;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPlace(): ParkingPlace
    {
        return $this->place;
    }

    public function setPlace(ParkingPlace $place): void
    {
        $this->place = $place;
    }

    // public function getPlaceId(): string
    // {
    //     return $this->placeId;
    // }

    public function getCarId(): string
    {
        return $this->carId;
    }

    public function setCarId(string $carId): void
    {
        $this->carId = $carId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getStart(): DateTime
    {
        return $this->start;
    }

    public function setStart(DateTime $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): DateTime
    {
        return $this->end;
    }

    public function setEnd(DateTime $end): void
    {
        $this->end = $end;
    }

    // public function getStatusId(): int
    // {
    //     return $this->statusId;
    // }

    public function getStatus(): ReservationStatus
    {
        return $this->status;
    }

    public function setStatus(ReservationStatus $status): void
    {
        $this->status = $status;
    }

    public static function create(
        ReservationId $id,
        ParkingPlace $place,
        ReservationStatus $status,
        BookerId $userId,
        BookerCarId $carId,
        int $start,
        int $end

    ): self {
        $reservation = new self((string) $id);
        $reservation->setPlace($place);
        $reservation->setStatus($status);
        $reservation->setUserId((string) $userId);
        $reservation->setCarId((string) $carId);
        $reservation->setStart((new DateTime())->setTimestamp($start));
        $reservation->setEnd((new DateTime())->setTimestamp($end));
        $reservation->setCreatedAt(new DateTime());
        $reservation->setUpdatedAt(new DateTIme());

        $reservation->addEvent(new ReservationIsCreatedEvent(
            (string) $userId,
            (string) $carId,
            $place->getNumber(),
            $start,
            $end
        ));

        return $reservation;
    }
}
