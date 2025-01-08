<?php

declare(strict_types=1);

namespace App\User\Application\Security;

use App\User\Domain\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserSecurityInterface extends UserInterface, PasswordAuthenticatedUserInterface
{

    public function setUser(User $user): void;

    public function getUser(): User;
}
