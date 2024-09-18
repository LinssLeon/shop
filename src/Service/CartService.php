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
        $customer = $this->security->getUser();
        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $customer, 'product' => $product]);

        if ($cartItem) {
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
        } else {
            $cartItem = new CartItem();
            $cartItem->setCustomer($customer);
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $this->em->persist($cartItem);
        }

        $this->em->flush();
    }

    public function updateCart($productId, $quantity)
    {
        $customer = $this->security->getUser();
        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $customer, 'product' => $product]);

        if ($cartItem) {
            $cartItem->setQuantity($quantity);
            $this->em->flush();
        }
    }

    public function getCartItems()
    {
        $customer = $this->security->getUser();
        return $this->cartItemRepository->findBy(['customer' => $customer]);
    }

    public function removeFromCart($productId)
    {
        $customer = $this->security->getUser();
        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $customer, 'product' => $productId]);

        if ($cartItem) {
            $this->em->remove($cartItem);
            $this->em->flush();
        }
    }

    public function removeQuantityFromCart($productId, $quantity)
    {
        $customer = $this->security->getUser();
        $cartItem = $this->cartItemRepository->findOneBy(['customer' => $customer, 'product' => $productId]);

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
        $customer = $this->security->getUser();
        $cartItems = $this->cartItemRepository->findBy(['customer' => $customer]);

        foreach ($cartItems as $cartItem) {
            $this->em->remove($cartItem);
        }

        $this->em->flush();
    }

    public function getCartQuantity(): int
    {
        $customer = $this->security->getUser();
        if (!$customer) {
            return 0;
        }

        $cartItems = $this->cartItemRepository->findBy(['customer' => $customer]);
        $cartQuantity = array_reduce($cartItems, function ($carry, $item) {
            return $carry + $item->getQuantity();
        }, 0);

        return $cartQuantity;
    }
}
