<?php
// src/Controller/CheckoutController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CartService;

class CheckoutController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/checkout', name: 'checkout')]
    public function index(): Response
    {
        $cartItems = $this->cartService->getCartItems();
        $total = $this->cartService->getTotal();

        return $this->render('checkout/index.html.twig', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }
}
