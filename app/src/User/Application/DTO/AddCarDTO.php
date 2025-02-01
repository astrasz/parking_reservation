<?php

declare(strict_types=1);

namespace App\User\Application\DTO;

use App\User\Domain\Entity\CarBrand;

class AddCarDTO
{
    private readonly CarBrand $brand;
    private readonly string $registrationNo;

    public function setBrand(CarBrand $brand): void
    {
        $this->brand = $brand;
    }

    public function getBrand(): CarBrand
    {
        return $this->brand;
    }

    public function setRegistrationNo(string $registrationNo): void
    {
        $this->registrationNo = $registrationNo;
    }

    public function getRegistrationNo(): string
    {
        return $this->registrationNo;
    }
}
