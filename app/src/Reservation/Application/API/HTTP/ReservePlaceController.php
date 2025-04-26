<?php

declare(strict_types=1);

namespace App\Reservation\Application\API\HTTP;

use App\Reservation\Application\Command\ReservePlace;
use App\Reservation\Application\DTO\ReservePlaceDTO;
use App\Reservation\Application\Form\ReservePlaceFormInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/reservations/new', name: 'app_new_reservation', methods: ['Get', 'Post'])]
class ReservePlaceController extends AbstractController
{
    use HandleTrait;

    public function __construct(private readonly ReservePlaceFormInterface $form, MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $status = 200;

        try {
            $placeNo = $request->query->get('no');
            $newReservation = new ReservePlaceDTO();
            $form = $this->createForm($this->form::class, $newReservation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var UserSecurityInterface $user 
                 */
                $user = $this->getUser();

                $this->handle(new ReservePlace(
                    (int)$form->get('placeNo')->getData(),
                    $form->get('carId')->getData()->getValue(),
                    $user->getUser()->getId(),
                    $form->get('start')->getData()->getTimestamp(),
                    $form->get('end')->getData()->getTimestamp()
                ));

                $this->addFlash('success', 'Reservation was registered. We have sent a confirmation to your email address.');
                $status = 201;
            }
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof BadRequestException || $e->getPrevious() instanceof BadRequestException) {
                $this->addFlash('error', $e->getPrevious()->getMessage());
                $status = 400;
            } else {
                $this->addFlash('error', 'Something went wrong, try again.');
                $status = 500;
            }
        } catch (Exception $e) {
            $this->addFlash('error', 'Something went wrong, try again.');
            $status = 500;
        } finally {
            if ($status === 201) {
                return $this->redirectToRoute('app_show_parking');
            }

            $errors = $form->getErrors(true);

            if (count($errors)) {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }

            return $this->render('reservation/new_reservation.html.twig', [
                'reservePlaceForm' => $form,
                'placeNo' => $placeNo
            ])->setStatusCode($status);
        }
    }
}
