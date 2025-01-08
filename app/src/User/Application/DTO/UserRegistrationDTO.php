<?php

declare(strict_types=1);

namespace App\User\Application\DTO;

class UserRegistrationDTO
{

    private readonly string $email;
    private readonly string $password;
    private readonly bool $terms;

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }


    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setTerms(bool $terms): void
    {
        $this->terms = $terms;
    }

    public function getTerms(): bool
    {
        return $this->terms;
    }
}
