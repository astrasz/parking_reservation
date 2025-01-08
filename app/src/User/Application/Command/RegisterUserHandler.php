<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Application\Command\RegisterUser;
use App\User\Application\Security\UserSecurityInterface;
use App\User\Domain\Entity\User;
use App\User\Domain\Entity\UserEmail;
use App\User\Domain\Entity\UserId;
use App\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

#[AsMessageHandler]
class RegisterUserHandler
{

    public function __construct(
        private readonly PasswordHasherFactoryInterface $hasherFactory,
        private readonly UserRepositoryInterface $repo,
        private readonly UuidFactory $uuidFactory,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function __invoke(RegisterUser $command): string | UniqueConstraintViolationException
    {

        try {
            $user = User::create(
                new UserId($this->uuidFactory->create()->toString()),
                new UserEmail($command->getEmail()),
                $this->hasherFactory->getPasswordHasher(UserSecurityInterface::class)->hash($command->getPassword())
            );

            $this->repo->save($user);
        } catch (UniqueConstraintViolationException $e) {
            return $e;
        } catch (\Throwable $e) {
            return 'We have sent a message to your email address. Follow the instructions to confirm your registration.';
        }

        foreach ($user->fethEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }

        return 'We have sent a message to your email address. Follow the instructions to confirm your registration.';
    }
}
