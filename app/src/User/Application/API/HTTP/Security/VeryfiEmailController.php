<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP\Security;

use App\User\Application\Security\UserSecurityInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route('/verify/email', name: 'app_verify_email')]
class VeryfiEmailController extends AbstractController
{

    public function __construct(private EmailVerifier $emailVerifier, private UserRepositoryInterface $repo) {}

    public function __invoke(Request $request, TranslatorInterface $translator): Response
    {
        try {
            $id = $request->query->get('id');

            if (null === $id) {
                $this->addFlash('error', $translator->trans('Cannot recognize you, register', [], 'VerifyEmailBundle'));

                return $this->redirectToRoute('app_register');
            }

            $user = $this->repo->find($id);

            if (null === $user) {
                $this->addFlash('error', $translator->trans('Cannot recognize you, register', [], 'VerifyEmailBundle'));

                return $this->redirectToRoute('app_register');
            }
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_login');
    }
}
