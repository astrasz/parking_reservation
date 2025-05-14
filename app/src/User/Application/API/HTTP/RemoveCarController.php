<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP;

use App\User\Application\Command\RemoveCar;
use App\User\Domain\Entity\Car;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/cars/{id}', name: 'app_remove_car', methods: ['Post'])]
class RemoveCarController extends AbstractController
{
    use HandleTrait;
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request, Car $car): Response
    {

        $formToken = $request->request->get('_token');

        try {
            if ($this->isCsrfTokenValid('delete' . $car->getId(), $formToken)) {

                /**
                 * @var UserSecurityInterface $user 
                 */
                $user = $this->getUser();

                $this->handle(new RemoveCar(
                    $car,
                    $user->getUser()->getId()
                ));

                $this->addFlash('success', 'Car removed successfully!');
            } else {
                $this->addFlash('error', 'Security check failed. Cannot remove car.');
            }
        } catch (Exception $e) {
            dump($e);
            $this->addFlash('error', 'Something went wrong.');
        }
        return $this->redirectToRoute('app_show_cars');
    }
}
