<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BaseController extends AbstractController
{
    protected function getCartQuantity(SessionInterface $session): int
    {
        // Holen Sie sich den Warenkorb aus der Session, falls vorhanden
        $cart = $session->get('cart', []);

        // Überprüfen Sie, ob der Warenkorb ein Array ist
        if (!is_array($cart)) {
            return 0;
        }

        // Summieren Sie die Mengen im Warenkorb
        return array_sum(array_column($cart, 'quantity'));
    }
}
