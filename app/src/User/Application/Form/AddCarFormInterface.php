<?php

declare(strict_types=1);

namespace App\User\Application\Form;

use App\User\Application\DTO\AddCarDTO;

interface AddCarFormInterface
{
    public function handleRequest($data): void;
    public function isValid(): bool;
    public function getData(): AddCarDTO;
}
