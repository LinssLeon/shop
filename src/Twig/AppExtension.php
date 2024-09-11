<?php
// src/Twig/AppExtension.php

namespace App\Twig;

use App\Service\CartService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cart_quantity', [$this, 'getCartQuantity']),
        ];
    }

    public function getCartQuantity(): int
    {
        return $this->cartService->getCartQuantity();
    }
}
