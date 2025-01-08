<?php

declare(strict_types=1);

namespace App\User\Application\Security;

use App\User\Domain\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

interface EmailVerifierInterface
{
    public function sendEmailConfirmation(string $verifyEmailRouteName, User $user, TemplatedEmail $email): void;
}
