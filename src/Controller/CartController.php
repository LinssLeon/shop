<?php
// src/Controller/CartController.php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/cart', name: 'cart')]
    public function index(): Response
    {
        $cartItems = $this->cartService->getCartItems();
        $total = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item->getProduct()->getPrice() * $item->getQuantity());
        }, 0);
        $cartQuantity = array_reduce($cartItems, function ($carry, $item) {
            return $carry + $item->getQuantity();
        }, 0);

        return $this->render('cart/index.html.twig', [
            'cartItems' => $cartItems,
            'total' => $total,
            'cartQuantity' => $cartQuantity,
        ]);
    }

    #[Route('/cart/add/{productId}', name: 'cart_add')]
    public function add(int $productId, Request $request): Response
    {
        $quantity = $request->request->get('quantity', 1);
        $this->cartService->addToCart($productId, $quantity);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/update/{productId}', name: 'cart_update')]
    public function update(int $productId, Request $request): Response
    {
        $quantity = $request->request->get('quantity', 1);
        $this->cartService->updateCart($productId, $quantity);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove/{productId}', name: 'cart_remove')]
    public function remove(int $productId): Response
    {
        $this->cartService->removeFromCart($productId);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove-quantity/{productId}', name: 'cart_remove_quantity')]
    public function removeQuantity(int $productId, Request $request): Response
    {
        $quantity = $request->request->get('quantity', 1);
        $this->cartService->removeQuantityFromCart($productId, $quantity);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(): Response
    {
        $this->cartService->clearCart();
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/apply-coupon', name: 'apply_coupon', methods: ['POST'])]
    public function applyCoupon(Request $request): Response
    {
        $couponCode = $request->request->get('coupon_code');
        // Logik zum Verarbeiten des Gutscheincodes...

        return $this->redirectToRoute('cart');
    }
}
