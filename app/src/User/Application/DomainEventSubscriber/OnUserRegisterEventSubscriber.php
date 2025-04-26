<?php

declare(strict_types=1);

namespace App\User\Application\DomainEventSubscriber;

use App\User\Application\Security\EmailVerifierInterface;
use App\User\Domain\Event\UserRegisterEvent;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Address;

class OnUserRegisterEventSubscriber implements EventSubscriberInterface
{

    public function __construct(private readonly EmailVerifierInterface $emailVerifier, private readonly UserRepositoryInterface $repo) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisterEvent::class => 'sendConfirmationEmail'
        ];
    }


    public function sendConfirmationEmail(UserRegisterEvent $event): void
    {
        $user = $this->repo->find($event->getUserId());

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, (new TemplatedEmail())
            ->from(new Address('test@parkingapp.test', 'Parking Manager'))
            ->to($user->getEmail())
            ->subject('Please Confirm Your Email')
            ->htmlTemplate('user/security/confirmation_email.html.twig'));
    }
}
