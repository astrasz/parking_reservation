<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

enum CarBrand: string
{
    case VOLVO = 'Volvo';
    case TOYOTA = 'Toyota';
    case POLONEZ = 'Polonez';
    case TESLA = 'Tesla';
    case FERRARI = 'Ferrari';
    case MERCEDES = 'Mercedes';
    case PORSCHE = 'Porsche';
    case BMW = 'BMW';
    case VOLKSWAGEN = 'Volkswagen';

    public function toString()
    {
        return $this->value;
    }
}
