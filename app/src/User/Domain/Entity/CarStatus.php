<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

enum CarStatus: int
{
    case ACTIVE = 1;
    case DISABLED = 0;
}
