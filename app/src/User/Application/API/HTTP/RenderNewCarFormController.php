<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/cars/new', name: 'app_show_car_form', methods: ['Get'])]
class RenderNewCarFormController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            'user/new_car.html.twig',
            [
                'brand' => "",
                'registrationNo' => ""
            ]
        );
    }
}
