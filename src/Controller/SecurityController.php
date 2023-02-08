<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
//use Symfony\Component\Security\Http\Attribute\IsGranted;


class SecurityController extends BaseController
{
    #[Route('/login', name: 'app_login')]
//    #[IsGranted("IS_AUTHENTICATED_REMEMBERED")]
    public function login(AuthenticationUtils $authenticationUtils, Security $security, Request $request): Response
    {
        $this->getUser();
        if ($request->isMethod('GET') && null !== $security->getToken()?->getUser()) {
            $security->logout(false);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \Exception('logout() should never be reached');
    }

    #[Route('/user-support/tickets', name: 'app_user-support_tickets')]
    #[IsGranted("ROLE_USER")]    // not work ---> เพราะไม่ได้ Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function support_tickets(Security $security): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
//         $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

//        $user = $security->getToken()?->getUser();

//        if ($security->getUser()) {
//        }
// ++++++++++++++
//        if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//            // ...
//        }

        return new Response('OPEN SUPPORT TICKETS!, <br />@' . __CLASS__ . ' ~ line:' . __LINE__);    
    }

}
