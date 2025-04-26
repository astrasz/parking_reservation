<?php

declare(strict_types=1);

namespace App\Reservation\Application\API\HTTP;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/reservations', name: 'app_show_reservations', methods: ['Get'])]
class ShowReservationsController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(): Response
    {
        return $this->render('reservation/user_reservations.html.twig');
    }
}
