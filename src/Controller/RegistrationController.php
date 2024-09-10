<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder, SessionInterface $session): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordEncoder->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login'); // Redirect to the login page after registration
        }
        $cartQuantity = $this->getCartQuantity($session);

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
            'cartQuantity' => $cartQuantity, // Korrigierter Variablenname
        ]);
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
