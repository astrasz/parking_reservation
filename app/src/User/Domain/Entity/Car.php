<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\Timestampbale;

class Car
{
    use Timestampbale;

    private string $id;
    private string $brand;
    private string $registrationNo;
    private int $status = CarStatus::ACTIVE->value;
    private User $owner;
    private string $ownerId;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): CarId
    {
        return new CarId($this->id);
    }

    public function getBrand(): CarBrand
    {
        return CarBrand::from($this->brand);
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getRegistrationNo(): string
    {
        return $this->registrationNo;
    }

    public function setRegistrationNo(string $registrationNo): void
    {
        $this->registrationNo = $registrationNo;
    }

    public function getStatus(): CarStatus
    {
        return CarStatus::from($this->status);
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getOwner(): CarOwner
    {
        return new CarOwner($this->owner);
    }

    public function setOwner(CarOwner $owner): void
    {
        $this->owner = $owner->getUser();
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function setOwnerId(string $ownerId): void
    {
        $this->owner = (string) $ownerId;
    }
}
