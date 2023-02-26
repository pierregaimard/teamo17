<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    public function authenticate(Request $request): Passport
    {
        $password = $request->request->get('_password');
        $username = $request->request->get('_username');
        $csrfToken = $request->request->get('_csrf_token');

        if (!$username) {
            throw new CustomUserMessageAuthenticationException("Oups! vous avez oublié d'entrer votre email");
        }

        return new Passport(
            new UserBadge($username),
            new CustomCredentials(
                function ($credentials, User $user) {
                    if (!$user->isActive()) {
                        throw new CustomUserMessageAuthenticationException(
                            "Oups! vôtre compte a été temporairement désactivé, merci de nous contacter à l'adresse contact@teamo17.fr"
                        );
                    }

                    return $this->passwordHasher->isPasswordValid($user, $credentials);
                },
                $password
            ),
            [new CsrfTokenBadge('authenticate', $csrfToken)]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('home'));
    }
}
