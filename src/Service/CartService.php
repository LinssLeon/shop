<?php
// src/Service/CartService.php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartItemRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CartService
{
    private $em;
    private $security;
    private $cartItemRepository;
    private $productRepository;

    public function __construct(EntityManagerInterface $em, Security $security, CartItemRepository $cartItemRepository, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->security = $security;
        $this->cartItemRepository = $cartItemRepository;
        $this->productRepository = $productRepository;
    }

    public function addToCart($productId, $quantity)
    {
        $user = $this->security->getUser();
        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $user, 'product' => $product]);

        if ($cartItem) {
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
        } else {
            $cartItem = new CartItem();
            $cartItem->setCustomer($user);
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $this->em->persist($cartItem);
        }

        $this->em->flush();
    }

    public function updateCart($productId, $quantity)
    {
        $user = $this->security->getUser();
        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $user, 'product' => $product]);

        if ($cartItem) {
            $cartItem->setQuantity($quantity);
            $this->em->flush();
        }
    }

    public function getCartItems()
    {
        $user = $this->security->getUser();
        return $this->cartItemRepository->findBy(['customer' => $user]);
    }

    public function removeFromCart($productId)
    {
        $user = $this->security->getUser();
        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $user, 'product' => $productId]);

        if ($cartItem) {
            $this->em->remove($cartItem);
            $this->em->flush();
        }
    }

    public function removeQuantityFromCart($productId, $quantity)
    {
        $user = $this->security->getUser();
        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $user, 'product' => $productId]);

        if ($cartItem) {
            $newQuantity = $cartItem->getQuantity() - $quantity;
            if ($newQuantity > 0) {
                $cartItem->setQuantity($newQuantity);
            } else {
                $this->em->remove($cartItem);
            }
            $this->em->flush();
        }
    }

    public function clearCart()
    {
        $user = $this->security->getUser();
        $cartItems = $this->cartItemRepository->findBy(['customer' => $user]);

        foreach ($cartItems as $cartItem) {
            $this->em->remove($cartItem);
        }

        $this->em->flush();
    }

    public function getCartQuantity(): int
    {
        $user = $this->security->getUser();
        if (!$user) {
            return 0;
        }

        $cartItems = $this->cartItemRepository->findBy(['customer' => $user]);
        $cartQuantity = array_reduce($cartItems, function ($carry, $item) {
            return $carry + $item->getQuantity();
        }, 0);

        return $cartQuantity;
    }
}
