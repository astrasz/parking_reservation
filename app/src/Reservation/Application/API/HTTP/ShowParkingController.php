<?php

declare(strict_types=1);

namespace App\Reservation\Application\API\HTTP;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_show_parking', methods: ['Get'])]
class ShowParkingController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('reservation/parking.html.twig');
    }
}
