<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP;

use App\User\Application\Command\AddNewCar;
use App\User\Application\DTO\AddCarDTO;
use App\User\Application\Form\AddCarFormInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/cars/new', name: 'app_new_car', methods: ['Get', 'Post'])]
class AddNewCarController extends AbstractController
{

    use HandleTrait;

    public function __construct(private readonly AddCarFormInterface $form, MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request, TranslatorInterface $translator): Response
    {
        $car = new AddCarDTO();
        $form = $this->createForm($this->form::class, $car);
        $form->handleRequest($request);
        $status = 200;

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var UserSecurityInterface $user 
                 */
                $user = $this->getUser();

                $this->handle(new AddNewCar(
                    $form->get('brand')->getData()->toString(),
                    $form->get('registrationNo')->getData(),
                    $user->getUser()->getId()
                ));

                $this->addFlash('success', $translator->trans('Car was added. We have sent a confirmation to your email address.'));
                $status = 201;
            }
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof UniqueConstraintViolationException) {
                $this->addFlash('error', $translator->trans('This registration number is unavailable, try another one.'));
                $status = 400;
            }
        } catch (Exception $e) {
            $this->addFlash('error', $translator->trans('Something went wrong, try again.'));
            $status = 500;
        } finally {
            if ($status === 201) {
                return $this->redirectToRoute('app_show_cars');
            }
            return $this->render('user/new_car.html.twig', [
                'addCarForm' => $form
            ])->setStatusCode($status);
        }
    }
}
