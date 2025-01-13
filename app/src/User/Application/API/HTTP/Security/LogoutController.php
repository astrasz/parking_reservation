<?php

declare(strict_types=1);

namespace App\User\Application\API\HTTP\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/logout', name: 'app_logout', methods: ['Get'])]
class LogoutController extends AbstractController
{
    public function __construct() {}

    public function __invoke(): void {}
}
