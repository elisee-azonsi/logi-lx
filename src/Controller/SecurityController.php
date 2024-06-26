<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @method getDoctrine()
 * @method get(string $string)
 */
class SecurityController extends AbstractController
{
    #[Route(path:'/login', name: 'app_login')]

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->isGranted('ROLE_ADMIN')) {
             return $this->redirectToRoute('app_manager');
         } elseif ($this->isGranted('ROLE_USER')){
             return $this->redirectToRoute('app_shift');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

      return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }



}
