<?php
// src/Controller/CartController.php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends BaseController
{
    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session): Response
    {
        // Den Warenkorb aus der Session holen
        $cart = $session->get('cart', []);

        // Gesamtsumme berechnen
        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $cartQuantity = $this->getCartQuantity($session);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'cartQuantity' => $cartQuantity,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(int $id, Request $request, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        // Produkt aus der Datenbank holen
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produkt nicht gefunden.');
        }

        // Warenkorb aus der Session holen oder einen neuen erstellen
        $cart = $session->get('cart', []);

        $quantity = $request->request->getInt('quantity', 1);

        // Wenn das Produkt schon im Warenkorb ist, Menge erhöhen
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Neues Produkt hinzufügen
            $cart[$id] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => $quantity,
            ];
        }

        // Warenkorb zurück in die Session speichern
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id, SessionInterface $session): Response
    {
        // Warenkorb aus der Session holen
        $cart = $session->get('cart', []);

        // Prüfen, ob das Produkt existiert und es dann entfernen
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        // Warenkorb zurück in die Session speichern
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }
}
