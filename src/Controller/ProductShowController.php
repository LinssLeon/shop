<?php
// src/Controller/ProductShowController.php
namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductShowController extends BaseController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $cartQuantity = $this->getCartQuantity($session);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'cartQuantity' => $cartQuantity,
        ]);
    }
}
