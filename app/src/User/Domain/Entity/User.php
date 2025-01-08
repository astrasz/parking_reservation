<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\AggreagateRoot;
use App\Shared\Domain\Entity\Timestampbale;
use App\User\Domain\Event\UserRegisterCarEvent;
use App\User\Domain\Event\UserRegisterEvent;
use DateTime;

class User extends AggreagateRoot
{
    use Timestampbale;

    private string $id;
    private string $email;
    private string $password;
    private array $roles = [];
    private string $status = UserStatus::UNVERIFIED->value;
    private int $isVerified = 0;


    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getStatus(): UserStatus
    {
        return UserStatus::from($this->status);
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getIsVerified(): int
    {
        return $this->isVerified;
    }

    public function setIsVerified(int $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public static function create(
        UserId $id,
        UserEmail $email,
        string $password
    ): self {
        /**
         * @var string $id
         * @var string $email
         */
        $user = new self((string) $id);
        $user->setEmail((string) $email);
        $user->setPassword($password);
        $user->setCreatedAt(new DateTime());
        $user->setUpdatedAt(new DateTime());

        $user->addEvent(new UserRegisterEvent((string) $id));

        return $user;
    }

    public static function addCar(
        CarId $id,
        CarBrand $brand,
        string $registrationNo,
        CarOwner $carOwner
    ): Car {

        /**
         * @var string $id
         */
        $car = new Car($id);
        $car->setBrand((string) $brand);
        $car->setRegistrationNo($registrationNo);
        $car->setOwnerid((string) $carOwner);

        $carOwner->getUser()->addEvent(new UserRegisterCarEvent($id, (string) $carOwner));

        return $car;
    }
}
