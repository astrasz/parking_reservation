<?php

declare(strict_types=1);

namespace App\User\Application\Security;

use App\User\Application\DTO\UserRegistrationDTO;

interface UserRegistrationFormInterface
{
    public function handleRequest($data): void;
    public function isValid(): bool;
    public function getData(): UserRegistrationDTO;
}
