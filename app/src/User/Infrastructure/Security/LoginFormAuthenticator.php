<?php

namespace App\User\Infrastructure\Security;

use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\ParameterBagUtils;
use Symfony\Component\Security\Http\SecurityRequestAttributes;


class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    public const LOGIN_PATH = 'app_login';
    public const HOME_PATH = 'app_show_parking';

    public function __construct(private readonly UserRepositoryInterface $userRepo, private readonly UrlGeneratorInterface $urlGenerator,  private array $options = [
        'username_parameter' => '_username',
        'password_parameter' => '_password',
        'check_path' => '/login_check',
        'post_only' => true,
        'enable_csrf' => true,
        'csrf_parameter' => '_csrf_token',
        'csrf_token_id' => 'authenticate',
    ]) {}

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_PATH);
    }

    public function authenticate(Request $request): Passport
    {
        $credentials = $this->getCredentials($request);

        $userBadge = new UserBadge($credentials['username'], function ($username) {
            $user = $this->userRepo->findByIdentifier($username);

            if (!$user) {
                return null;
            }
            $userSecurity = new UserSecurity();
            $userSecurity->setUser($user);
            return $userSecurity;
        });

        $passport = new Passport($userBadge, new PasswordCredentials($credentials['password']), [new RememberMeBadge()]);

        if ($this->options['enable_csrf']) {
            $passport->addBadge(new CsrfTokenBadge($this->options['csrf_token_id'], $credentials['csrf_token']));
        }

        return $passport;
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        return new UsernamePasswordToken($passport->getUser(), $firewallName, $passport->getUser()->getRoles());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate(self::HOME_PATH));
    }

    private function getCredentials(Request $request): array
    {
        $credentials = [];
        $credentials['csrf_token'] = ParameterBagUtils::getRequestParameterValue($request, $this->options['csrf_parameter']);

        if ($this->options['post_only']) {
            $credentials['username'] = ParameterBagUtils::getParameterBagValue($request->request, $this->options['username_parameter']);
            $credentials['password'] = ParameterBagUtils::getParameterBagValue($request->request, $this->options['password_parameter']) ?? '';
        } else {
            $credentials['username'] = ParameterBagUtils::getRequestParameterValue($request, $this->options['username_parameter']);
            $credentials['password'] = ParameterBagUtils::getRequestParameterValue($request, $this->options['password_parameter']) ?? '';
        }

        if (!\is_string($credentials['username']) && !$credentials['username'] instanceof \Stringable) {
            throw new BadRequestHttpException(sprintf('The key "%s" must be a string, "%s" given.', $this->options['username_parameter'], \gettype($credentials['username'])));
        }

        $credentials['username'] = trim($credentials['username']);

        if ('' === $credentials['username']) {
            throw new BadCredentialsException(sprintf('The key "%s" must be a non-empty string.', $this->options['username_parameter']));
        }

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $credentials['username']);

        if (!\is_string($credentials['password']) && (!\is_object($credentials['password']) || !method_exists($credentials['password'], '__toString'))) {
            throw new BadRequestHttpException(sprintf('The key "%s" must be a string, "%s" given.', $this->options['password_parameter'], \gettype($credentials['password'])));
        }

        if ('' === (string) $credentials['password']) {
            throw new BadCredentialsException(sprintf('The key "%s" must be a non-empty string.', $this->options['password_parameter']));
        }

        if (!\is_string($credentials['csrf_token'] ?? '') && (!\is_object($credentials['csrf_token']) || !method_exists($credentials['csrf_token'], '__toString'))) {
            throw new BadRequestHttpException(sprintf('The key "%s" must be a string, "%s" given.', $this->options['csrf_parameter'], \gettype($credentials['csrf_token'])));
        }

        return $credentials;
    }
}
