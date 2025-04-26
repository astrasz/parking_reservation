<?php

declare(strict_types=1);

namespace App\Reservation\Application\Form;

use App\Reservation\Application\DTO\ReservePlaceDTO;

interface ReservePlaceFormInterface
{
    public function handleRequest($data): void;
    public function isValid(): bool;
    public function getData(): ReservePlaceDTO;
}
