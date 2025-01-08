<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP;

use App\User\Application\Command\RegisterUser;
use App\User\Application\DTO\UserRegistrationDTO;
use App\User\Application\Security\UserRegistrationFormInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/register', name: 'app_register', methods: ['Get', 'Post'])]
class RegisterController extends AbstractController
{
    use HandleTrait;

    public function __construct(private readonly UserRegistrationFormInterface $form, MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(Request $request, TranslatorInterface $translator): Response
    {
        $user = new UserRegistrationDTO();
        $form = $this->createForm($this->form::class, $user);
        $form->handleRequest($request);
        $status = 200;

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $message = $this->handle(new RegisterUser($form->get('email')->getData(), $form->get('password')->getData()));


                if ($message instanceof UniqueConstraintViolationException) {
                    $this->addFlash('error', $translator->trans('This email address is unavailable, try another one.'));
                    $status = 400;
                } else {
                    $this->addFlash('success', $message);
                    $status = 201;
                }
            }
        } catch (Exception $e) {
            $this->addFlash('error', $translator->trans('Something went wrong, try again.'));
            $status = 500;
        } finally {
            if ($status === 201) {
                $form = $this->createForm($this->form::class, new UserRegistrationDTO());
            }
            return $this->render('user/register.html.twig', [
                'registrationForm' => $form
            ])->setStatusCode($status);
        }
    }
}
