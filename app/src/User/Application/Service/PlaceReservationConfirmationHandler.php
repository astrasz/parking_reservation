<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\Shared\Application\Service\EventHandlerInterface;
use App\User\Application\Event\PlaceReservationConfirmation;
use App\User\Domain\Repository\CarRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class PlaceReservationConfirmationHandler implements EventHandlerInterface
{

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UserRepositoryInterface $userRepo,
        private readonly CarRepositoryInterface $carRepo
    ) {}

    public function __invoke(PlaceReservationConfirmation $event)
    {
        $car = $this->carRepo->findOneBy(['id' => $event->getCarId()]);

        $user = $this->userRepo->findOneBy(['id' => $event->getUserId()]);

        if ($car && $user) {
            $email = (new TemplatedEmail())
                ->from(new Address('test@parkingapp.test', 'Parking Manager'))
                ->to($user->getEmail())
                ->subject('Confirmation of a parking place`s reservation')
                ->htmlTemplate('user/confirmation_place_reservation.html.twig');

            $context = $email->getContext();
            $context['placeNo'] = $event->getPlaceNo();
            $context['registrationNo'] = $car->getRegistrationNo();
            $context['start'] = (new DateTime())->setTimestamp($event->getStart())->format('Y-m-d H:m');
            $context['end'] = (new DateTime())->setTimestamp($event->getEnd())->format('Y-m-d H:m');

            $email->context($context);

            $this->mailer->send($email);
        }
    }
}
