<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/login', name: 'app_login', methods: ['Get', 'Post'])]
class LoginController extends AbstractController
{

    public function __construct(private readonly AuthenticationUtils $authUtils) {}

    public function __invoke(): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('app_show_parking');
        }

        $error = $this->authUtils->getLastAuthenticationError();

        if ($error !== null) {
            $this->addFlash('error', $error->getMessageKey());
        }

        $lastUsername = $this->authUtils->getLastUsername();

        return $this->render('user/security/login.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }
}
