<?php

declare(strict_types=1);

namespace App\User\Application\DTO;

use App\User\Domain\Entity\CarBrand;

class UserCarDTO
{
    private readonly string $id;
    private readonly string $brand;
    private readonly string $registrationNumber;


    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setRegistrationNumber(string $registrationNumber): void
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }
}
