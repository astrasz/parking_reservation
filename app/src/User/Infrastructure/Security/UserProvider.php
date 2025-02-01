<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security;

use App\User\Domain\Entity\User;
use App\User\Infrastructure\Repository\UserRepository;
use App\User\Infrastructure\Security\UserSecurity;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{

    public function __construct(private readonly UserRepository $userRepo) {}
    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me. If you're not using these features, you do not
     * need to implement this method.
     *
     * @throws UserNotFoundException if the user is not found
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {

        // Load a User object from your data source or throw UserNotFoundException.
        // The $identifier argument is whatever value is being returned by the
        // getUserIdentifier() method in your User class.
        $user = $this->userRepo->findByIdentifier($identifier);

        if (!$user || !$user instanceof User) {
            throw new UserNotFoundException();
        }

        $securityUser = new UserSecurity();
        $securityUser->setUser($user);

        return $securityUser;
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        // Return a User object after making sure its data is "fresh".
        // Or throw a UserNotFoundException if the user no longer exists.
        if (!$user instanceof UserSecurity) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }
        $refreshedUser = $this->userRepo->find($user->getUser()->getId());

        if (!$refreshedUser instanceof User) {
            throw new UserNotFoundException();
        }

        if ($this->isUserChanged($user->getUser(), $refreshedUser)) {
            throw new UserNotFoundException();
        }

        $userSecurity = new UserSecurity();
        $userSecurity->setUser($refreshedUser);

        return $userSecurity;
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class): bool
    {
        return UserSecurity::class === $class || is_subclass_of($class, UserSecurity::class);
    }

    /**
     * Upgrades the hashed password of a user, typically for using a better hash algorithm.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: when hashed passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newHashedPassword);
        if (!$user instanceof UserSecurity) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }
        $user->getUser()->setPassword($newHashedPassword);
        $this->userRepo->save($user->getUser());
    }

    private function isUserChanged(User $user, User $refreshedUser): bool
    {
        return
            $user->getId() !== $refreshedUser->getId() ||
            $user->getEmail() !== $refreshedUser->getEmail() ||
            $user->getPassword() !== $refreshedUser->getPassword() ||
            $user->getRoles() !== $refreshedUser->getRoles() ||
            $user->getStatus() !== $refreshedUser->getStatus() ||
            $user->getIsVerified() !== $refreshedUser->getIsVerified();
    }
}
