<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

enum CarBrand: string
{
    case VOLVO = 'Volvo';
    case TOYOTA = 'Toyota';
    case POLONEZ = 'Polonez';

    public function toString()
    {
        return $this->value;
    }
}
