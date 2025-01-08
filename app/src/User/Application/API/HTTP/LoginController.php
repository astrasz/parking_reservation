<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: '/login', name: 'app_login', methods: ['Get', 'Post'])]
class LoginController extends AbstractController
{

    public function __construct(private readonly AuthenticationUtils $authUtils) {}

    public function __invoke(TranslatorInterface $translator): Response
    {
        $error = $this->authUtils->getLastAuthenticationError();

        if ($error !== null) {
            $this->addFlash('error', $translator->trans($error->getMessageKey()));
        }

        $lastUsername = $this->authUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }
}
