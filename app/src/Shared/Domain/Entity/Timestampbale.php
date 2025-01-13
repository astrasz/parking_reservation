<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use DateTime;

trait Timestampbale
{
    private DateTime $createdAt;

    private DateTime $updatedAt;

    public function setCreatedAt()
    {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt()
    {
        $this->updatedAt = new DateTime();
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
