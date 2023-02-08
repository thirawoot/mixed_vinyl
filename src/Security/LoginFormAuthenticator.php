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

use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

use App\Entity\User;
use App\Repository\UserRepository;
// use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private UserRepository $userRepository, 
        private RouterInterface $router
    ) {
        // $this->userRepository = $userRepository;
    }

    public function supports(Request $request): ?bool
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
            new UserBadge($email, 
                // /* example of custom user loader */
                // function ($userIdentifier) {
                //     /* optionally pass a callback to load the User manually */
                //     dump($userIdentifier);
                //     $user = $this->userRepository->findOneBy(['email' => $userIdentifier]);  
                //     dump($user);
                //     if (!$user) {
                //         throw new BadCredentialsException(); // UserNotFoundException();
                //     }  
                // }
            ),
            /* if UserBadge return user object, user credential will check */
            new CustomCredentials( 
                function ($credentials, User $user) {
                    
                    return $credentials === 'tada';
                    
                    dd($credentials, $user);
                }, 
                $password
            )
        );


    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // dd('success');
        return new RedirectResponse(
            $this->router->generate('app_homepage')
        );

    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        dump($exception);
        dump($exception->getMessageData());

        return new RedirectResponse(
            $this->router->generate('app_login')
        );

    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
