<?php

declare(strict_types=1);

namespace App\Reservation\Application\API\HTTP;

use App\Reservation\Application\Query\FindAllPlaces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_show_parking', methods: ['Get'])]
class ShowParkingController extends AbstractController
{

    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(): Response
    {

        $message = $this->handle(new FindAllPlaces());
        $places = count($message) ? $message : [];

        return $this->render('reservation/parking.html.twig', [
            'places' => $places
        ]);
    }
}
