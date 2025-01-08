<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\EntityId;

class CarId extends EntityId
{
    public function __construct()
    {
        parent::__construct();
    }
}
