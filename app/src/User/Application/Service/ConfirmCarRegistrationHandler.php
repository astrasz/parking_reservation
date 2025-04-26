<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\Shared\Application\Service\EventHandlerInterface;
use App\User\Application\Event\ConfirmCarRegistration;
use App\User\Domain\Repository\CarRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

// #[AsMessageHandler]
class ConfirmCarRegistrationHandler implements EventHandlerInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UserRepositoryInterface $userRepo,
        private readonly CarRepositoryInterface $carRepo
    ) {}

    public function __invoke(ConfirmCarRegistration $event): void
    {
        $user = $this->userRepo->find((string) $event->getOwnerId());
        $car = $this->carRepo->find((string) $event->getCarId());

        if ($car && $user) {
            $email = (new TemplatedEmail())
                ->from(new Address('test@parkingapp.test', 'Parking Manager'))
                ->to($user->getEmail())
                ->subject('Confirmation of a car\'s registration')
                ->htmlTemplate('user/confirmation_car_registration.html.twig');

            $context = $email->getContext();
            $context['registrationNo'] = $car->getRegistrationNo();
            $context['brand'] = $car->getBrand()->toString();

            $email->context($context);

            $this->mailer->send($email);
        }
    }
}
