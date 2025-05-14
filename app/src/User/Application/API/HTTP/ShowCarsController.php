<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP;

use App\User\Application\Query\FindAllCars;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/cars', name: 'app_show_cars', methods: ['Get'])]
class ShowCarsController extends AbstractController
{

    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(): Response
    {

        try {
            $message = $this->handle(new FindAllCars());

            if ($message instanceof Exception) {
                $this->addFlash('error', $message->getMessage());
                $message = null;
            }
        } catch (Exception $e) {
            $this->addFlash('error', 'Something went wrong');
            $message = '';
        }

        return $this->render('user/cars_list.html.twig', [
            'cars' => $message
        ]);
    }
}
