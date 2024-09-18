<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;

class AccountController extends AbstractController
{
    #[Route("/account", name: "account")]
    public function index(Request $request, UserInterface $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Ihre Daten wurden aktualisiert.');
        }

        return $this->render('account/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
