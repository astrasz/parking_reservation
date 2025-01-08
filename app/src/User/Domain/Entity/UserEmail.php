<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\Email;

class UserEmail extends Email
{
    public function __construct(string $email)
    {
        parent::__construct($email);
    }
}
