<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
//
use \Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

// use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
// use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;

use App\Entity\User;
use App\Repository\UserRepository;
// use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    public function __construct(
        private UserRepository $userRepository, 
        private RouterInterface $router
    ) {
        // $this->userRepository = $userRepository;
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_login');
    }

     public function supports(Request $request): bool
     {
         //dd(__FILE__);
         // dump($request);

         return $request->getPathInfo() === '/login' && $request->isMethod('POST');
     }

    public function authenticate(Request $request): Passport
    {
        // dump($request->request);
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge(
                    'authenticate',
                    $request->request->get('_csrf_token')
                ),
                new RememberMeBadge(),
            ]
        );

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): Response
    {
        // dd('success');
        return new RedirectResponse(
            $this->router->generate('app_homepage')
        );

    }

//     public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
//     {
//         $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
//         dump($exception);
//         dump($exception->getMessageData());
//
//         return new RedirectResponse(
//             $this->router->generate('app_login')
//         );
//
//     }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//         //$request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
//         dump($request);
//         dump($authException);
//         dump($authException->getMessage());
//         $request->getSession()->set(Security::AUTHENTICATION_ERROR, $authException);
//
//         return new RedirectResponse(
//             $this->router->generate('app_login')
//         );
//
//     }
}
