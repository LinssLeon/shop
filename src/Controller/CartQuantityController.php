<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartQuantityController extends AbstractController
{
    protected function getCartQuantity(Request $request): int
    {
        // Holen Sie sich die Session aus dem Request
        $session = $request->getSession();

        // Holen Sie sich den Warenkorb aus der Session, falls vorhanden
        $cart = $session->get('cart', []);

        // Überprüfen Sie, ob der Warenkorb ein Array ist
        if (!is_array($cart)) {
            return 0;
        }

        // Summieren Sie die Mengen im Warenkorb
        return array_sum(array_column($cart, 'quantity'));
    }

    protected function renderWithCartQuantity(Request $request, string $view, array $parameters = [], int $status = Response::HTTP_OK): Response
    {
        // Fügen Sie die Warenkorbmenge zu den Parametern hinzu
        $parameters['cartQuantity'] = $this->getCartQuantity($request);

        // Rendern Sie die Ansicht mit den Parametern und dem Status
        return $this->render($view, $parameters, null);
    }
}
