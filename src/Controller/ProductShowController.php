<?php
// src/Controller/ProductShowController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProductShowController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $cart = $session->get('cart', []);
        $cartQuantity = array_sum($cart);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'cartQuantity' => $cartQuantity,
        ]);
    }
}
