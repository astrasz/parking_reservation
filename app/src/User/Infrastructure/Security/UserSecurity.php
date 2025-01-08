<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security;

use App\User\Application\Security\UserSecurityInterface;
use App\User\Domain\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserSecurity implements UserSecurityInterface, PasswordAuthenticatedUserInterface
{

    private readonly User $user;

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getRoles(): array
    {
        return $this->user->getRoles();
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->user->getEmail();
    }

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

    public function setEmail(string $email): void
    {
        $this->user->setEmail($email);
    }

    public function setPassword(string $password): void
    {
        $this->user->setPassword($password);
    }

    public function getPassword(): string
    {
        return $this->user->getPassword();
    }
}
