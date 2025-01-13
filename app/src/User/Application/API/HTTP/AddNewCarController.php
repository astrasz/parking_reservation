<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP;

use App\User\Application\Command\AddNewCar;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/cars/new', name: 'app_new_car', methods: ['Post'])]
class AddNewCarController extends AbstractController
{

    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request, TranslatorInterface $translator): Response
    {

        $params = [];
        try {
            $params = $request->request->all();
            /**
             * @var UserSecurityInterface $user 
             */
            $user = $this->getUser();


            $this->handle(new AddNewCar(
                $params['brand'],
                $params['registrationNo'],
                $user->getUser()->getId()
            ));

            $this->addFlash('success', 'Car was added. We have sent a confirmation to your email address.');

            return $this->redirectToRoute('app_show_cars');
        } catch (Exception $e) {
            // dd($e);
            $this->addFlash('error', 'Something went wrong, try again.');

            return $this->render('user/new_car.html.twig', [
                'error' => $e->getMessage(),
                'brand' => $params['brand'],
            ]);
        }
    }
}
