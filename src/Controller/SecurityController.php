<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, SessionInterface $session): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $cartQuantity = $this->getCartQuantity($session);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'cartQuantity' => $cartQuantity,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
        // Symfony will intercept this route and handle the logout automatically
    }

    private function getCartQuantity(SessionInterface $session): int
    {
        $cart = $session->get('cart', []);
        $quantity = 0;

        foreach ($cart as $item) {
            $quantity += $item['quantity'];
        }

        return $quantity;
    }
}
